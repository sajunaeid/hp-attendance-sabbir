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
use Illuminate\Support\Carbon;

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
            return DataTables::of(Employee::orderBy('name', 'asc'))->make(true);
        }
        return view('employees.index');
    }


    public function we(Request $request)
    {
        $employees = Employee::orderBy('id', 'desc')->get();
        return view('employees.we',['employees'=> $employees]);
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

        $employee = new Employee;
        $employee->name = $request->name;
        $employee->emp_id = $request->emp_id;
        $employee->emp_number = $request->emp_number; // Note: Fixed typo from 'emp_nuber'
        $employee->wh = (string)$request->whours . ':' . (string)$request->wminutes;
        $employee->we = json_encode($request->we);


        if ($request->phone) {
            $employee->phone = $request->phone;
        }
        if ($request->nid) {
            $employee->nid = $request->nid;
        }
        if ($request->score) {
            $employee->score = $request->score;
        }
        if ($request->score_note) {
            $employee->score_note = $request->score_note;
        }

        $employee->save();


        return redirect()->route('employees.index')->with(['status' => 200, 'message' => 'Employee Created!']);

    }



    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $employee = Employee::with('documents')->find($id);
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


        // dd($employee->wh);
        if ($employee && $employee->wh && strpos($employee->wh, ':') !== false) {
            // Split the wh value (e.g., "11:20") into hours and minutes
            list($hours, $minutes) = explode(':', $employee->wh);
            $hours = (int) $hours;
            $minutes = (int) $minutes;
        } else {
            $hours = NULL; // Or 0 if you prefer
            $minutes = NULL; // Or 0 if you prefer
        }


        // Pass $hours and $minutes to the view
        return view('employees.edit', compact('employee', 'hours', 'minutes'));
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

        // dd($request);

        $employee = Employee::find($id);
        $employee->name = $request->name;
        $employee->emp_id = $request->emp_id;
        $employee->emp_number = $request->emp_number; // Note: Fixed typo from 'emp_nuber'
        $employee->wh = (string)$request->whours . ':' . (string)$request->wminutes;
        $employee->we = json_encode($request->we);


        if ($request->phone) {
            $employee->phone = $request->phone;
        }
        if ($request->nid) {
            $employee->nid = $request->nid;
        }
        if ($request->score) {
            $employee->score = $request->score;
        }
        if ($request->score_note) {
            $employee->score_note = $request->score_note;
        }

        // Photo
        if ($request->file('pp')) {

            $file = $request->file('pp');
            $image_full_name = time().'pp'.'.'.$file->getClientOriginalExtension();
            $upload_path = 'profilepic/';
            $image_url = $upload_path.$image_full_name;
            $success = $file->move($upload_path, $image_full_name);
            $employee->pp = $image_url;
        }

        $employee->update();

        return redirect()->route('employees.index')->with(['status' => 200, 'message' => 'Employee updated successfully']);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function old(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Employee::withTrashed()->where('deleted_at', '>', Carbon::now()->subWeek())->get())->make(true);
        }
        return view('employees.old');
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


    // Restoring a deleted employee
    public function restore($id)
    {
        $employee = Employee::withTrashed()->find($id);
        $employee->restore();
        return response()->json(['success' => 'Employee Restored !']);
    }



    public function fdelete($id)
    {
        $employee = Employee::withTrashed()->find($id);

        if ($employee->pp) {
            // Deleting profile picture
            $filePath = public_path($employee->pp);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $employee->forceDelete();
        return response()->json(['success' => 'Employee deleted Permanently!']);
    }





}
