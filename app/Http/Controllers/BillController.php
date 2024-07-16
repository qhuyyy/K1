<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Menu;
use App\Models\Dish;
use App\Models\Table;
use App\Models\Customer;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Bill::all();
        $dates = Bill::distinct()->pluck('Date');
        $products = Product::all();
        return view('sales.bills.index', compact('bills', 'dates', 'products'));
    }

    public function filterBill(Request $request)
    {
        $query = Bill::query();
        $dates = Bill::select('Date')->distinct()->pluck('Date');

        if ($request->ajax()) {
            if (!empty($request->date)) {
                $bills = $query->with(['products', 'tables'])->where('Date', $request->date)->get();
            } else {
                $bills = $query->with(['products', 'tables'])->get();
            }

            return response()->json(['bills' => $bills]);
        }

        // Nếu không phải ajax request, trả về view cho trình duyệt
        $bills = $query->get();
        return view('sales.bills.index', compact('bills', 'dates'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $producttypes = ProductType::all();
        $products = Product::with('product_type')->get();
        $menus = Menu::with('dishes')->get();

        return view('sales.bills.create', compact('producttypes', 'products', 'menus'));
    }

    public function createWithoutParams()
    {
        $producttypes = ProductType::all();
        $products = Product::with('product_type')->get();
        $menus = Menu::with('dishes')->get();

        return view('sales.bills.create', compact('producttypes', 'products', 'menus'));
    }

    public function create2()
    {
        return view('sales.bills.create2', compact('producttypes', 'products', 'menus'));
    }

    public function createWithoutParams2()
    {
        return view('sales.bills.create2', compact('producttypes', 'products', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveProducts(Request $request)
    {
        $customer = new Customer();
        $customer->CustomerName = $request->input('CustomerName');
        $customer->Contact = $request->input('Contact');
        $customer->Note = $request->input('Note');
        $customer->save();

        $bill = new Bill();
        $bill->Date = $request->input('Date');
        $bill->BillType_ID = '1';
        $bill->Customer_ID = $customer->id;
        $bill->Extra = '0';
        $bill->Prepaid = '0';
        $bill->Total = $request->input('Total');
        $bill->save();

        $productsData = $request->input('products');

        foreach ($productsData as $productData) {
            $productId = $productData['id'];
            $quantity = $productData['quantity'];
            $subtotal = $productData['subtotal'];

            // Lưu thông tin món ăn vào bảng trung gian
            $bill->products()->attach($productId, ['Quantity' => $quantity, 'SubTotal' => $subtotal]);
        }

        return redirect()->route('bills.index');
    }

    public function saveTables(Request $request)
    {
        // Lưu thông tin khách hàng
        $customer = new Customer();
        $customer->CustomerName = $request->input('CustomerName');
        $customer->Contact = $request->input('Contact');
        $customer->Note = $request->input('Note');
        $customer->save();

        $bill = new Bill();
        $bill->Date = $request->input('Date');
        $bill->BillType_ID = '2';
        $bill->Customer_ID = $customer->id;
        $bill->Extra = $request->input('Extra');
        $bill->Prepaid = $request->input('Prepaid');
        $bill->Total = $request->input('Total');
        $bill->save();

        // Tạo mới một bản ghi trong bảng tables và cung cấp giá trị cho trường Bill_ID
        $table = new Table();
        $table->Bill_ID = $bill->id;
        $table->NumberOfTables = $request->input('NumberOfTables');
        $table->save();

        // Lưu thông tin các món ăn vào bảng trung gian
        $dishesData = $request->input('dishes');
        foreach ($dishesData as $dishData) {
            $dishId = $dishData['id'];
            $numberOfDishes = $dishData['quantity'];
            $table->dishes()->attach($dishId, ['NumberOfDishes' => $numberOfDishes]);
        }

        return redirect()->route('bills.index')->with('success', 'Dữ liệu đã được lưu thành công.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bill = Bill::where('id', '=', $id)->select('*')->first();
        $products = Product::with('product_type')->get();
        $tables = Table::all();

        return view('sales.bills.show', compact('bill', 'products', 'tables'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bill = Bill::find($id);
        $products = Product::with('product_type')->get();
        $table = Table::where('Bill_ID', $bill->id)->with('dishes')->first(); // Sử dụng first() thay vì get()
        $dishes = Dish::all();

        return view('sales.bills.edit', compact('bill', 'products', 'table', 'dishes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProducts(Request $request, string $id)
    {
        $bill = Bill::findOrFail($id);

        $bill->fill($request->only(['Date', 'Extra', 'Prepaid', 'Total']));
        $bill->save();

        $customer = Customer::findOrFail($bill->Customer_ID);
        $customer->fill($request->only(['CustomerName', 'Contact', 'Note']));
        $customer->save();

        $productsData = $request->input('products', []);
        $productData = [];
        foreach ($productsData as $product) {
            $productId = $product['id'];
            $quantity = $product['quantity'];
            $subtotal = $product['subtotal'];
            $productData[$productId] = ['Quantity' => $quantity, 'SubTotal' => $subtotal];
        }
        $bill->products()->sync($productData);

        return redirect()->route('bills.index');
    }

    public function updateTables(Request $request, string $id)
    {
        $bill = Bill::findOrFail($id);

        $bill->fill($request->only(['Date', 'Extra', 'Prepaid', 'Total']));
        $bill->save();

        $customer = Customer::findOrFail($bill->Customer_ID);
        $customer->fill($request->only(['CustomerName', 'Contact', 'Note']));
        $customer->save();

        $table = Table::where('Bill_ID', $bill->id)->first();
        $table->fill($request->only(['NumberOfTables']));
        $table->save();

        $dishesData = $request->input('dishes', []);
        $dishData = [];
        foreach ($dishesData as $dish) {
            if (isset($dish['id']) && isset($dish['quantity'])) {
                $dishId = $dish['id'];
                $quantity = $dish['quantity'];
                $dishData[$dishId] = ['NumberOfDishes' => $quantity];
            }
        }

        $table->dishes()->sync($dishData);

        // Chuyển hướng người dùng sau khi cập nhật thành công
        return redirect()->route('bills.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bill = Bill::findOrFail($id);
        $bill->products()->detach();
        $bill->delete();

        return redirect()->route('bills.index');
    }
}
