<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Hour;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:admin-dash', ['only' => ['dashboard']]);
    }

    public function home(Request $request)
    {
        return view('welcome');
    }


    public function dashboard(Request $request)
    {
        $today = Carbon::now()->format('l');
        $employeesWithWeekendToday = Employee::whereJsonContains('we', $today)->get();
        $targatedDate = now()->toDateString();
        return view('dashboard',['targatedDate'=>$targatedDate, 'employees' => $employeesWithWeekendToday]);
    }





}
