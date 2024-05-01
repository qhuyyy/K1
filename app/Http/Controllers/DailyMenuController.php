<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyMenu;
use App\Models\Dish;

class DailyMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dailymenus = DailyMenu::all();
        $dailymenus = DailyMenu::with('dish1')->get();
        $dailymenus = DailyMenu::with('dish2')->get();
        $dailymenus = DailyMenu::with('dish3')->get();
        $dailymenus = DailyMenu::with('dish4')->get();
        $dailymenus = DailyMenu::with('dish5')->get();
        $dailymenus = DailyMenu::with('dish6')->get();
        $dailymenus = DailyMenu::with('dish7')->get();
        $dailymenus = DailyMenu::with('dish8')->get();
        $dailymenus = DailyMenu::with('dish9')->get();
        $dailymenus = DailyMenu::with('dish10')->get();
        $dates = DailyMenu::distinct()->pluck('Date');
        return view('menu.dailymenus.index', compact('dailymenus','dates'));
    }
    
    public function filterDailyMenu(Request $request)
    {
        $query = DailyMenu::query();
        $dates = DailyMenu::select('Date')->distinct()->pluck('Date');
        
        if ($request->ajax()) {
            if (!empty($request->date)){
                $dailymenus = $query->where('Date', $request->date)->get();
            }
            else{
                $dailymenus = $query->get();
            }
            return response()->json(['dailymenus' => $dailymenus]);
        }
        
        $dailymenus = $query->get();
        return view('menu.dailymenus.index', compact('dailymenus', 'dates'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dishes = Dish::all();
        //Truy cập lấy ra tất cả bản ghi có id = id món ăn, id nguyên liệu
        //làm triong hàm này 
       // xong đẩy dữ liệu qua view
        return view('menu.dailymenus.create', compact('dishes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dailymenu = new DailyMenu;
        $dailymenu->Date = $request->Date;
        $dailymenu->NumberOfTotalPortions = $request->NumberOfTotalPortions;
        for ($i = 1; $i <= 10; $i++) {
            $fieldName = "Dish{$i}_ID";
            $dailymenu->$fieldName = $request->$fieldName;
        
            $portionsFieldName = "NumberOfPortions{$i}";
            $dailymenu->$portionsFieldName = $request->$portionsFieldName;
        }

        $dailymenu->save();
    
        
        return redirect()->route('dailymenus.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dishes = Dish::all();
        $dailymenu = DailyMenu::where('id', '=', $id)->select('*')->first();
        return view('menu.dailymenus.show',compact('dishes', 'dailymenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dailymenu = DailyMenu::find($id);
        $dishes = Dish::all();
        return view('menu.dailymenus.edit',compact('dishes','dailymenu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DailyMenu::where('id', $request->input('id'))
            ->update([
                'Date' => $request->input('Date'),
                'NumberOfPortions' => $request->input('NumberOfPortions'),
                'Dish1_ID' => $request->input('Dish1_ID'),
                'Dish2_ID' => $request->input('Dish2_ID'),
                'Dish3_ID' => $request->input('Dish3_ID'),
                'Dish4_ID' => $request->input('Dish4_ID'),
                'Dish5_ID' => $request->input('Dish5_ID'),
                'Dish6_ID' => $request->input('Dish6_ID'),
                'Dish7_ID' => $request->input('Dish7_ID'),
                'Dish8_ID' => $request->input('Dish8_ID'),
                'Dish9_ID' => $request->input('Dish9_ID'),
                'Dish10_ID' => $request->input('Dish10_ID'),
            ]);

        return redirect()->route('dailymenus.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
