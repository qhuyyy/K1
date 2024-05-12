<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Product;
use App\Models\ProductType;

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
        return view('sales.bills.index',compact('bills','dates','products'));
    }

    public function filterBill(Request $request)
    {
        $query = Bill::query();
        $dates = Bill::select('Date')->distinct()->pluck('Date');

        if ($request->ajax()) {
            if (!empty($request->date)) {
                $bills = $query->with('products')->where('Date', $request->date)->get();
            } else {
                $bills = $query->with('products')->get();
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

        return view('sales.bills.create',compact('producttypes','products'));
    }

    public function createWithoutParams()
    {
        $producttypes = ProductType::all();
        $products = Product::with('product_type')->get();
        
        return view('sales.bills.create', compact('producttypes', 'products'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bill = new Bill();
        $bill->Date = $request->input('Date');
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bill = Bill::where('id', '=', $id)->select('*')->first();
        $products = Product::with('product_type')->get();

        return view('sales.bills.show',compact('bill','products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bill = Bill::find($id);
        $products = Product::with('product_type')->get();

        return view('sales.bills.edit',compact('bill','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bill = Bill::findOrFail($id);

        $bill->fill($request->only(['Date', 'Total']));
        $bill->save();

        if ($request->has('products')) {
            $productData = [];

            foreach ($request->input('products') as $key => $product) {
                $productID = $product['id'];
                $quantity = $product['quantity'];
                $subtotal = $product['subtotal'];
                $productData[$productID] = ['Quantity' => $quantity, 'SubTotal' => $subtotal];
            }

            $bill->products()->sync($productData);
        } else {
            $bill->products()->detach();
        }

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
