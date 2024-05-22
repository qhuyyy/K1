<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\MenuDish;
use App\Models\Dish;
use App\Models\Ingredient;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('dishes')->get();
        $dates = Menu::distinct()->pluck('Date');

        return view('menu.menus.index',compact('menus','dates'));
    }

    public function filterMenu(Request $request)
    {
        $query = Menu::query();
        $dates = Menu::select('Date')->distinct()->pluck('Date');

        if ($request->ajax()) {
            if (!empty($request->date)){
                $menus = $query->with('dishes')->where('Date', $request->date)->get();
            } else {
                $menus = $query->with('dishes')->get();
            }
            return response()->json(['menus' => $menus]);
        }

        $menus = $query->get();
        return view('menu.menus.index', compact('menus', 'dates'));
    }

    public function getMenuIdByDate(Request $request)
    {
        // Lấy tham số 'date' từ query string
        $date = $request->query('date');

        // Tìm kiếm bản ghi có trường Date khớp với giá trị nhận được
        $menu = Menu::where('Date', $date)->first();

        if ($menu) {
            // Lấy danh sách các dish_id tương ứng với menu_id
            $dishesIds = MenuDish::where('Menu_ID', $menu->id)->pluck('Dish_ID')->toArray();
            
            // Lấy thông tin chi tiết của các món ăn từ bảng dishes
            $dishes = Dish::whereIn('id', $dishesIds)->select('id', 'DishName', 'Price')->get()->toArray();

            // Trả về danh sách các DishName
            return response()->json(['menu_id' => $menu->id, 'dishes' => $dishes]);
        } else {
            return response()->json(['menu_id' => '', 'dishes' => []]);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dishes = Dish::with('ingredients')->get();
        $menus = Menu::all();
        $ingredients = Ingredient::all();
        $dishIngredients = DB::table('dish_ingredients')->select('Dish_ID', 'Ingredient_ID', 'Amount')->get();

        
        return view('menu.menus.create',compact('dishes','menus','ingredients','dishIngredients'));
    }
    
    public function createWithoutParams()
    {
        $dishes = Dish::with('ingredients')->get();
        $menus = Menu::all();
        $ingredients = Ingredient::all();
        $dishIngredients = DB::table('dish_ingredients')->select('Dish_ID', 'Ingredient_ID', 'Amount')->get();

        
        return view('menu.menus.create',compact('dishes','menus','ingredients','dishIngredients'));
    } 
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Date' => 'required|date',
            'NumberOfTotalPortions' => 'required|integer|min:1',
        ]);

        $menu = new Menu();
        $menu->Date = $request->input('Date');
        $menu->NumberOfTotalPortions = $request->input('NumberOfTotalPortions');

        $menu->save();

        $dishesData = $request->input('dishes');

        foreach ($dishesData as $dishData) {
            $dishId = $dishData['id'];
            $numberOfPortions = $dishData['numberOfPortions'];

            // Lưu thông tin món ăn vào bảng trung gian
            $menu->dishes()->attach($dishId, ['NumberOfPortions' => $numberOfPortions]);
        }

        return redirect()->route('menus.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = Menu::where('id', '=', $id)->select('*')->first();
        $dishes = Dish::all();

        return view('menu.menus.show',compact('menu','dishes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menu::find($id);
        $dishes = Dish::with('ingredients')->get();
        $ingredients = Ingredient::all();
        $dishIngredients = DB::table('dish_ingredients')->select('Dish_ID', 'Ingredient_ID', 'Amount')->get();

        return view('menu.menus.edit',compact('menu','dishes','ingredients','dishIngredients'));
    }

    public function getIngredients($dishId)
    {
        $dish = Dish::findOrFail($dishId);
        $ingredients = $dish->ingredients()->select('IngredientName', 'Price')->get();
        return response()->json($ingredients);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = Menu::findOrFail($id);

        $menu->fill($request->only(['Date', 'NumberOfTotalPortions']));
        $menu->save();

        // Lưu giá trị Amount tương ứng vào bảng trung gian dish_ingredients
        if ($request->has('dishes')) {
            $dishData = [];

            foreach ($request->input('dishes') as $key => $dish) {
                $dishID = $dish['id'];
                $numberOfPortions = $dish['numberOfPortions'];
                $dishData[$dishID] = ['NumberOfPortions' => $numberOfPortions];
            }

            $menu->dishes()->sync($dishData);
        } else {
            $menu->dishes()->detach();
        }

        return redirect()->route('menus.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->dishes()->detach();
        $menu->delete();

        return redirect()->route('menus.index');
    }
}
