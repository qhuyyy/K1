<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Unit;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('menu.ingredients.index', compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::all();
        return view('menu.ingredients.create',compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ingredient = new Ingredient;
        $ingredient->IngredientName = $request->IngredientName;
        $ingredient->Price = $request->Price;
        $ingredient->Unit_ID = $request->Unit_ID;

        $ingredient->save();
    
        
        return redirect()->route('ingredients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ingredient = Ingredient::where('id', '=', $id)->select('*')->first();
        return view('menu.ingredients.show',compact('ingredient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ingredient = Ingredient::find($id);
        $units = Unit::all();
        return view('menu.ingredients.edit',compact('ingredient','units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Ingredient::where('id', $request->input('id'))
            ->update([
                'IngredientName' => $request->input('IngredientName'),
                'Price' => $request->input('Price'),
                'Unit_ID' => $request->input('Unit_ID')
            ]);

        return redirect()->route('ingredients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ingredient = Ingredient::find($id);
        $ingredient->delete();
        return redirect()->route('ingredients.index');
    }
}
