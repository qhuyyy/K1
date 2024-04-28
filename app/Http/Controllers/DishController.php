<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DishType;
use App\Models\Ingredient;
use App\Models\Dish;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dishtypes = DishType::all();
        $dishes = Dish::all();
        $dishes = Dish::with('ingredient1')->get();
        $dishes = Dish::with('ingredient2')->get();
        $dishes = Dish::with('ingredient3')->get();
        $dishes = Dish::with('ingredient4')->get();
        $dishes = Dish::with('ingredient5')->get();
        $dishes = Dish::with('dish_type')->get();
        return view('menu.dishes.index',compact('dishes','dishtypes'));
    }

    public function filterDish(Request $request)
    {
        $query = Dish::query();
        $dishtypes = DishType::all();
        
        if ($request->ajax()) {
            if ($request->dishtype) {
                $dishes = $query->with(['dish_type', 'ingredient1', 'ingredient2', 'ingredient3', 'ingredient4', 'ingredient5'])
                                ->where('dishtype_ID', $request->dishtype)
                                ->get();
            } else {
                $dishes = $query->with(['dish_type', 'ingredient1', 'ingredient2', 'ingredient3', 'ingredient4', 'ingredient5'])->get();
            }
            
            return response()->json(['dishes' => $dishes]);
        }
        
        $dishes = $query->with(['dish_type', 'ingredient1', 'ingredient2', 'ingredient3', 'ingredient4', 'ingredient5'])->get();
        return view('menu.dishes.index', compact('dishes', 'dishtypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dishtypes = DishType::all();
        $ingredients = Ingredient::all();
        return view('menu.dishes.create', compact('dishtypes','ingredients'));
    }

    public function createWithoutParams()
    {
        $dishtypes = DishType::all();
        $ingredients = Ingredient::all();
        return view('menu.dishes.create', compact('dishtypes','ingredients'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dish = new Dish;
        $dish->DishName = $request->DishName;
        $dish->DishType_ID = $request->dishtype;
        $dish->Ingredient1_ID = $request->Ingredient1_ID;
        $dish->Ingredient2_ID = $request->Ingredient2_ID;
        $dish->Ingredient3_ID = $request->Ingredient3_ID;
        $dish->Ingredient4_ID = $request->Ingredient4_ID;
        $dish->Ingredient5_ID = $request->Ingredient5_ID;

        $dish->save();
    
        
        return redirect()->route('dishes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dishtypes = DishType::all();
        $ingredients = Ingredient::all();
        $dish = Dish::where('id', '=', $id)->select('*')->first();
        return view('menu.dishes.show',compact('dish', 'dishtypes', 'ingredients'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dish = Dish::find($id);
        $dishtypes = DishType::all();
        $ingredients = Ingredient::all();
        return view('menu.dishes.edit',compact('dish','dishtypes','ingredients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Dish::where('id', $request->input('id'))
            ->update([
                'DishName' => $request->input('DishName'),
                'DishType_ID' => $request->input('DishType_ID'),
                'Ingredient1_ID' => $request->input('Ingredient1_ID'),
                'Ingredient2_ID' => $request->input('Ingredient2_ID'),
                'Ingredient3_ID' => $request->input('Ingredient3_ID'),
                'Ingredient4_ID' => $request->input('Ingredient4_ID'),
                'Ingredient5_ID' => $request->input('Ingredient5_ID')
            ]);

        return redirect()->route('dishes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dish = Dish::find($id);
        $dish->delete();
        return redirect()->route('dishes.index');
    }
}
