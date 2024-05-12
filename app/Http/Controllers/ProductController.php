<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return view('sales.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $producttypes = ProductType::all();

        return view('sales.products.create', compact('producttypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->ProductType_ID = $request->ProductType_ID;
        $product->ProductName = $request->ProductName;
        $product->Price = $request->Price;

        $product->save();
    
        
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producttypes = ProductType::all();
        $product = Product::where('id', '=', $id)->select('*')->first();

        return view('sales.products.show',compact('product', 'producttypes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $producttypes = ProductType::all();

        return view('sales.products.edit',compact('product','producttypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Product::where('id', $request->input('id'))
            ->update([
                'ProductType_ID' => $request->input('ProductType_ID'),
                'ProductName' => $request->input('ProductName'),
                'Price' => $request->input('Price')
            ]);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('products.index');
    }
}
