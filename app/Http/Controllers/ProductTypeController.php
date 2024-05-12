<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductType;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $producttypes = ProductType::all();

        return view('sales.producttypes.index', compact('producttypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales.producttypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $producttypes = new ProductType;
        $producttypes->ProductTypeName = $request->ProductTypeName;
        $producttypes->Note = $request->Note;


        $producttypes->save();
    
        
        return redirect()->route('producttypes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producttype = ProductType::where('id', '=', $id)->select('*')->first();

        return view('sales.producttypes.show',compact('producttype'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producttype = ProductType::find($id);

        return view('sales.producttypes.edit',compact('producttype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ProductType::where('id', $request->input('id'))
            ->update([
                'ProductTypeName' => $request->input('ProductTypeName'),
                'Note' => $request->input('Note')
            ]);

        return redirect()->route('producttypes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producttype = ProductType::find($id);
        $producttype->delete();

        return redirect()->route('producttypes.index');
    }
}
