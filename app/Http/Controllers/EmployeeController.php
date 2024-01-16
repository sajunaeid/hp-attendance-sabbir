<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    function __construct()
    {
        $this->middleware('permission:employee-list|employee-create|employee-edit|employee-delete', ['only' => ['index','show']]);
        $this->middleware('permission:employee-create', ['only' => ['create','store']]);
        $this->middleware('permission:employee-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:employee-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {

        // return $employees = Employee::all();

        if ($request->ajax()) {
            return DataTables::of(Employee::orderBy('id', 'desc'))->make(true);
        }
        return view('employees.index');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function create(): View
    {
        return view('employees.create');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // : RedirectResponse
    public function store(StoreEmployeeRequest $request)
    {

        $employee = Employee::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'nid' => $request->nid,
            'emp_id' => $request->emp_id,
            'emp_number' => $request->emp_number,
            'wh' => $request->wh,
            'score' => $request->score,
            'score_note' => $request->score_note,
        ]);
        return redirect()->route('employees.index')->with(['status' => 200, 'message' => 'Employee Created!']);

    }



    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $employee = Employee::find($id);
        return view('employees.show',compact('employee'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $employee = Employee::find($id);
        return view('employees.edit',compact('employee'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  : RedirectResponse
    public function update(UpdateEmployeeRequest $request, $id)
    {


        $employee = Employee::find($id);
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->nid = $request->nid;
        $employee->emp_id = $request->emp_id;
        $employee->emp_number = $request->emp_number;
        $employee->wh = $request->wh;
        $employee->score = $request->score;
        $employee->score_note = $request->score_note;

        $employee->update();

        return redirect()->route('employees.index')->with(['status' => 200, 'message' => 'Employee updated successfully']);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {

        $employee = Employee::find($id);
        $employee->delete();
        return response()->json(['success' => 'Employee deleted !']);
    }

}
