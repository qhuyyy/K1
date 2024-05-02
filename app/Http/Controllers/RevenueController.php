<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Revenue;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $revenues = Revenue::all();
        $dates = Revenue::select('Date')->distinct()->pluck('Date');
        return view('sales.revenues.index', compact('revenues','dates'));
    }

    public function filterRevenue(Request $request)
    {
        $query = Revenue::query();
        $dates = Revenue::select('Date')->distinct()->pluck('Date');

        if($request->ajax()){
            $revenues = $query->where(['Date'=>$request->date])->get();
            return response()->json(['revenues'=>$revenues]);
        }

        $revenues = $query->get();
        return view('sales.revenues.index', compact('dates','revenues'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales.revenues.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $revenue = new Revenue;
        $revenue->Date = $request->input('Date');
        $revenue->Lunch = $request->input('Lunch');
        $revenue->Dinner = $request->input('Dinner');
        $revenue->FastFood = $request->input('FastFood');
        $revenue->BankTransfer = $request->input('BankTransfer');
        $revenue->Total = $request->input('Total');

        $revenue->save();

        return redirect()->route('revenues.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $revenue = Revenue::where('id', '=', $id)->select('*')->first();
        return view('sales.revenues.show',compact('revenue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $revenue = Revenue::find($id);
        return view('sales.revenues.edit',compact('revenue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Revenue::where('id', $request->input('id'))
            ->update([
                'Date' => $request->input('Date'),
                'Lunch' => $request->input('Lunch'),
                'Dinner' => $request->input('Dinner'),
                'FastFood' => $request->input('FastFood'),
                'BankTransfer' => $request->input('BankTransfer'),
                'Total' => $request->input('Total'),
            ]);

        return redirect()->route('revenues.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $revenue = Revenue::find($id);
        $revenue->delete();

        return redirect()->route('revenues.index');
    }
}
