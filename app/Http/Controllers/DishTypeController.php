<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DishType;

class DishTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dishtypes = DishType::all();
        return view('menu.dishtypes.index', compact('dishtypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.dishtypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dishtype = new DishType;
        $dishtype->DishTypeName = $request->DishTypeName;

        $dishtype->save();
    
        
        return redirect()->route('dishtypes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dishtype = DishType::where('id', '=', $id)->select('*')->first();
        return view('menu.dishtypes.show',compact('dishtype'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dishtype = DishType::find($id);
        return view('menu.dishtypes.edit',compact('dishtype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DishType::where('id', $request->input('id'))
            ->update([
                'DishTypeName' => $request->input('DishTypeName')
            ]);

        return redirect()->route('dishtypes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dishtype = DishType::find($id);
        $dishtype->delete();
        return redirect()->route('dishtypes.index');
    }
}
