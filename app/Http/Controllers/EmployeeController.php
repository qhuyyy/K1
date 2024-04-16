<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        $employees = Employee::with('position')->get();
        return view('employees.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positions = Position::all();
        return view('employees.create', compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee = new Employee;
        $employee->Name = $request->Name;
        $employee->DateOfBirth = $request->DateOfBirth;
        $employee->CICN = $request->CICN;
        $employee->PhoneNumber = $request->PhoneNumber;
        $employee->Position_ID = $request->Position_ID;

        $employee->save();
    
        
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $positions = Position::all();
        $employee = Employee::where('id', '=', $id)->select('*')->first();
        return view('employees.show',compact('employee', 'positions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::find($id);
        $positions = Position::all();
        return view('employees.edit',compact('employee','positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Employee::where('id', $request->input('id'))
            ->update([
                'Name' => $request->input('Name'),
                'DateOfBirth' => $request->input('DateOfBirth'),
                'CICN' => $request->input('CICN'),
                'PhoneNumber' => $request->input('PhoneNumber'),
                'Position_ID' => $request->input('Position_ID')
            ]);

        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return redirect()->route('employees.index');
    }
}
