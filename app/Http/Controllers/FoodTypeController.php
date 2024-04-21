<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodType;
class FoodTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foodtypes = FoodType::all();
        return view('food.foodtypes.index', compact('foodtypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('food.foodtypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $foodtype = new FoodType;
        $foodtype->FoodTypeName = $request->FoodTypeName;
        $foodtype->Description = $request->Description;

        $foodtype->save();
    
        
        return redirect()->route('foodtypes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $foodtype = FoodType::where('id', '=', $id)->select('*')->first();
        return view('food.foodtypes.show',compact('foodtype'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $foodtype = FoodType::find($id);
        return view('food.foodtypes.edit',compact('foodtype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        FoodType::where('id', $request->input('id'))
            ->update([
                'FoodTypeName' => $request->input('FoodTypeName'),
                'Description' => $request->input('Description'),
            ]);

        return redirect()->route('foodtypes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $foodtype = FoodType::find($id);
        $foodtype->delete();
        return redirect()->route('foodtypes.index');
    }
}
