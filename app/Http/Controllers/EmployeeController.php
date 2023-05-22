<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $pageTitle = 'Employee List';

        // RAW SQL QUERY
        //$employees = DB::select('
        //   select *, employees.id as employee_id, positions.name as position_name
        //    from employees
        //   left join positions on employees.position_id = positions.id
        //');

        // Query BUilder
        $employees = DB::table('employees')
        ->select ('*', 'employees.id as employee_id', 'positions.name as position_name')
        ->leftJoin ('positions', 'employees.position_id', '=', 'positions.id')
        ->get();

        return view('employee.index', [
            'pageTitle' => $pageTitle,
            'employees' => $employees
        ]);
    }

    public function create()
    {
        $pageTitle = 'Create Employee';

        // RAW SQL Query
        // $positions = DB::select('select * from positions');
        // Query Builder

        return view('employee.create', compact('pageTitle', 'positions'));
    }

    public function store(Request $request)
{
    $messages = [
        'required' => ':Attribute harus diisi.',
        'email' => 'Isi :attribute dengan format yang benar',
        'numeric' => 'Isi :attribute dengan angka'
    ];

    $validator = Validator::make($request->all(), [
        'firstName' => 'required',
        'lastName' => 'required',
        'email' => 'required|email',
        'age' => 'required|numeric',
    ], $messages);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // INSERT QUERY
    DB::table('employees')->insert([
        'firstname' => $request->firstName,
        'lastname' => $request->lastName,
        'email' => $request->email,
        'age' => $request->age,
        'position_id' => $request->position,
    ]);

    return redirect()->route('employees.index');
}


public function show(string $id)
{
    $pageTitle = 'Employee Detail';

    // RAW SQL QUERY
    //$employee = collect(DB::select('
    //    select *, employees.id as employee_id, positions.name as position_name
    //    from employees
    //    left join positions on employees.position_id = positions.id
    //    where employees.id = ?
    //', [$id]))->first();


    //Query Builder
        $employee = DB::table('employees')
        ->select ('*', 'employees.id as employee_id', 'positions.name as position_name')
        ->leftJoin ('positions', 'employees.position_id', '=', 'positions.id')
        ->where('employees.id', '=', $id)
        ->get();


    return view('employee.show', compact('pageTitle', 'employee'));
}

    public function edit(string $id, Request $request)
{
    $pageTitle = 'Employee Edit';
    $positions = DB::table('positions')->get();
    $employee = DB::table('employees')
        ->where('id', $id)
        ->first();
    return view('employee.edit', compact('pageTitle', 'employee', 'positions'));
}


/**
 * Update the specified resource in storage.
 */

    public function update(Request $request, string $id)
 {
     //
         $messages = [
             'required' => ':Attribute harus diisi.',
             'email' => 'Isi :attribute dengan format yang benar',
             'numeric' => 'Isi :attribute dengan angka'
         ];

         $validator = Validator::make($request->all(), [
             'firstName' => 'required',
             'lastName' => 'required',
             'email' => 'required|email',
             'age' => 'required|numeric',
         ], $messages);

         if ($validator->fails()) {
             return redirect()->back()->withErrors($validator)->withInput();
         }

         DB::table('employees')
             ->where('id', $id)
             ->update([
                 'firstName' => $request->input('firstName'),
                 'lastName' => $request->input('lastName'),
                 'email' => $request->input('email'),
                 'age' => $request->input('age'),
                 'age' => $request->input('age'),
                 'position_id' => $request->input('position')
                 // kolom-kolom lain yang ingin diupdate
             ]);
         return redirect()->route('employees.index')->with('success', 'Data berhasil diperbarui.');
}

    public function destroy(string $id)
    {
        // QUERY BUILDER
        DB::table('employees')
            ->where('id', $id)
            ->delete();

        return redirect()->route('employees.index');
    }
}
