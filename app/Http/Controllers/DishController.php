<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dish;
use App\Models\DishType;
use App\Models\Ingredient;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dishes = Dish::with('ingredients')->get();
        $dishtypes = DishType::all();
        
        return view('menu.dishes.index', compact('dishes','dishtypes'));
    }

    public function filterDish(Request $request)
    {
        $query = Dish::query();
        $dishtypes = DishType::all();

        if ($request->ajax()) {
            if ($request->dishtype) {
                $dishes = $query->with(['dish_type'])
                                ->where('dishtype_ID', $request->dishtype)
                                ->get();
            } else {
                $dishes = $query->with(['dish_type'])->get();
            }

            return response()->json(['dishes' => $dishes]);
        }

        $dishes = $query->with(['dish_type'])->get();
        
        return view('menu.dishes.index', compact('dishes', 'dishtypes'));
    }
    /**
     * Show the form for creating a new resource.
     */

     public function createWithoutParams()
     {
        $dishtypes = DishType::all();
        $ingredients = Ingredient::all();

        return view('menu.dishes.create', compact('dishtypes','ingredients'));
     } 

    public function create()
    {
        $dishtypes = DishType::all();
        $ingredients = Ingredient::all();

        return view('menu.dishes.create',compact('dishtypes','ingredients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dish = Dish::create([
            'DishName' => $request->input('DishName'),
            'DishType_ID' => $request->input('dishtype')
        ]);

        $ingredients = $request->input('ingredient');
        $amounts = $request->input('amount');

        // Lặp qua mỗi nguyên liệu và thêm vào món ăn với số lượng tương ứng
        foreach ($ingredients as $key => $ingredientId) {
            $amount = $amounts[$key];
            $dish->ingredients()->attach($ingredientId, ['amount' => $amount]);
        }

        return redirect()->route('dishes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dishtypes = DishType::all();
        $dish = Dish::where('id', '=', $id)->select('*')->first();
        $ingredients = Ingredient::all();

        return view('menu.dishes.show',compact('dish', 'dishtypes','ingredients'));
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
        $request->validate([
            'DishName' => 'required|string|max:255',
            'DishType_ID' => 'required|exists:dish_types,id',
            'amount' => 'array', // Kiểm tra xem 'amount' có phải là một mảng không
        ]);

        $dish = Dish::findOrFail($id);

        $dish->update([
            'DishName' => $request->input('DishName'),
            'DishType_ID' => $request->input('DishType_ID'),
        ]);

        // Lưu giá trị Amount tương ứng vào bảng trung gian dish_ingredients
        if ($request->has('ingredient')) {
            $ingredientData = [];

            foreach ($request->input('ingredient') as $key => $ingredientID) {
                $amount = $request->input('amount')[$key];
                $ingredientData[$ingredientID] = ['Amount' => $amount];
            }

            $dish->ingredients()->sync($ingredientData);
        } else {
            $dish->ingredients()->detach();
        }

        return redirect()->route('dishes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dish = Dish::findOrFail($id);
        $dish->ingredients()->detach();
        $dish->delete();

        return redirect()->route('dishes.index');
    }
}
