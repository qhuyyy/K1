<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceivedFood;
use App\Models\FoodType;
use App\Models\Unit;

class ReceivedFoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $received_food = ReceivedFood::with('food_type')->get();

        $foodtypes = FoodType::all();
        $dates = ReceivedFood::distinct()->pluck('Date');
        return view('food.receivedfood.index', compact('received_food', 'foodtypes', 'dates'));
    }

    public function search(Request $request)
    {
        // Lấy giá trị tìm kiếm từ request
        $date = $request->input('Date');
        $foodType_ID = $request->input('FoodType_ID');
        $dates = ReceivedFood::distinct()->pluck('Date');
        $foodtypes = FoodType::all();
        // Tìm kiếm trong cơ sở dữ liệu
        $received_food = ReceivedFood::query();

        // Áp dụng điều kiện tìm kiếm theo ngày nếu có
        if (!empty($date)) {
            $received_food->where('Date', $date);
        }

        // Áp dụng điều kiện tìm kiếm theo loại thực phẩm nếu có
        if (!empty($foodType_ID)) {
            $received_food->where('FoodType_ID', $foodType_ID);
        }

        // Lấy kết quả của tìm kiếm
        $received_food = $received_food->get();

        // Trả về view và truyền kết quả tìm kiếm
        return view('food.receivedfood.index', compact('received_food','dates','foodtypes'));
    }

    
    public function filterReceivedFood(Request $request)
    {
        $query = ReceivedFood::query();
        $foodtypes = FoodType::all();
        $dates = ReceivedFood::select('Date')->distinct()->pluck('Date');
        
        if($request->ajax()){
            if(empty($request->foodtype) && empty($request->date)){
                $received_food = $query->with(['food_type', 'unit'])->get();
            }
            elseif(!empty($request->foodtype) && empty($request->date)){
                $received_food = $query->with(['food_type', 'unit'])->where('FoodType_ID', $request->foodtype)->get();
            }
            elseif(empty($request->foodtype) && !empty($request->date)){
                $received_food = $query->with(['food_type', 'unit'])->whereDate('Date', $request->date)->get();
            }
            else{
                $received_food = $query->with(['food_type', 'unit'])
                                        ->where('FoodType_ID', $request->foodtype)
                                        ->whereDate('Date', $request->date)
                                        ->get();
            }
            return response()->json(['received_food' => $received_food]);
        }
        
        $received_food = $query->with(['food_type', 'unit'])->get();
        return view('food.receivedfood.index', compact('foodtypes', 'received_food', 'dates'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $foodtypes = FoodType::all();
        $units = Unit::all();
        return view('food.receivedfood.create',compact('foodtypes','units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $received_food = new ReceivedFood;
        $received_food->Date = $request->Date;
        $received_food->FoodType_ID = $request->FoodType_ID;
        $received_food->FoodName = $request->FoodName;
        $received_food->Unit_ID = $request->Unit_ID;
        $received_food->UnitPrice = $request->UnitPrice;
        $received_food->Quantity = $request->Quantity;
        $received_food->Total = $request->Total;
        $received_food->Note = $request->Note;
        $received_food->save();
    
        
        return redirect()->route('receivedfood.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $foodtypes = FoodType::all();
        $units = Unit::all();
        $received_food = ReceivedFood::where('id', '=', $id)->select('*')->first();
        return view('food.receivedfood.show',compact('received_food', 'foodtypes','units'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $received_food = ReceivedFood::find($id);
        $foodtypes = FoodType::all();
        $units = Unit::all();
        return view('food.receivedfood.edit',compact('received_food','foodtypes','units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ReceivedFood::where('id', $request->input('id'))
            ->update([
                'Date' => $request->input('Date'),
                'FoodType_ID' => $request->input('FoodType_ID'),
                'FoodName' => $request->input('FoodName'),
                'Unit_ID' => $request->input('Unit_ID'),
                'UnitPrice' => $request->input('UnitPrice'),
                'Quantity' => $request->input('Quantity'),
                'Total' => $request->input('Total'),
                'Note' => $request->input('Note')
            ]);

        return redirect()->route('receivedfood.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $received_food = ReceivedFood::find($id);
        $received_food->delete();
        return redirect()->route('receivedfood.index');
    }
}
