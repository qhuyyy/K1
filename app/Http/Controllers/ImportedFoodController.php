<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportedFood;
use App\Models\FoodType;
use App\Models\Unit;

class ImportedFoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imported_food = ImportedFood::with('food_type')->get();

        $foodtypes = FoodType::all();
        $dates = ImportedFood::distinct()->pluck('Date');
        return view('food.importedfood.index', compact('imported_food', 'foodtypes', 'dates'));
    }
    
    public function filterImportedFood(Request $request)
    {
        $query = ImportedFood::query();
        $foodtypes = FoodType::all();
        $dates = ImportedFood::select('Date')->distinct()->pluck('Date');
        
        if($request->ajax()){
            if(empty($request->foodtype) && empty($request->date)){
                $imported_food = $query->with(['food_type', 'unit'])->get();
            }
            elseif(!empty($request->foodtype) && empty($request->date)){
                $imported_food = $query->with(['food_type', 'unit'])->where('FoodType_ID', $request->foodtype)->get();
            }
            elseif(empty($request->foodtype) && !empty($request->date)){
                $imported_food = $query->with(['food_type', 'unit'])->whereDate('Date', $request->date)->get();
            }
            else{
                $imported_food = $query->with(['food_type', 'unit'])
                                        ->where('FoodType_ID', $request->foodtype)
                                        ->whereDate('Date', $request->date)
                                        ->get();
            }
            return response()->json(['imported_food' => $imported_food]);
        }
        
        $imported_food = $query->with(['food_type', 'unit'])->get();
        return view('food.importedfood.index', compact('foodtypes', 'imported_food', 'dates'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($foodtype, $date)
    {
        $foodtypes = FoodType::all();
        $units = Unit::all();
        
        return view('food.importedfood.create', compact('foodtypes', 'units', 'foodtype', 'date'));
    }

    public function createWithoutParams()
    {
        $foodtypes = FoodType::all();
        $units = Unit::all();
        
        return view('food.importedfood.create', compact('foodtypes', 'units'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $imported_food = new ImportedFood;
        $imported_food->Date = $request->Date;
        $imported_food->FoodType_ID = $request->foodtype;
        $imported_food->FoodName = $request->FoodName;
        $imported_food->Unit_ID = $request->Unit_ID;
        $imported_food->UnitPrice = $request->UnitPrice;
        $imported_food->Quantity = $request->Quantity;
        $imported_food->Total = $request->Total;
        $imported_food->Note = $request->Note;
        $imported_food->save();
    
        
        return redirect()->route('importedfood.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $foodtypes = FoodType::all();
        $units = Unit::all();
        $imported_food = ImportedFood::where('id', '=', $id)->select('*')->first();
        return view('food.importedfood.show',compact('imported_food', 'foodtypes','units'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $imported_food = ImportedFood::find($id);
        $foodtypes = FoodType::all();
        $units = Unit::all();
        return view('food.importedfood.edit',compact('imported_food','foodtypes','units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ImportedFood::where('id', $request->input('id'))
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

        return redirect()->route('importedfood.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $imported_food = ImportedFood::find($id);
        $imported_food->delete();
        return redirect()->route('importedfood.index');
    }
}
