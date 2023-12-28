<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Employee;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    /**
     * Show daily report.
     */
    public function daily(Request $request)
    {

        if ($request->targatedDay) {
            $targatedDate = $request->targatedDay;
        }else{
            $targatedDate = now()->toDateString();
        }



        if ($request->ajax()) {

            return DataTables::of(Employee::query())
            ->addColumn('total_wh_time', function ($employee) use ($targatedDate){
                return $employee->hours()
                    ->whereDate('created_at', $targatedDate  )
                    ->sum('wh_time');
            })
            ->rawColumns(['total_wh_time'])
            ->make(true);
        }
        return view('reports.daily',['targatedDate'=>$targatedDate]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function weekly(Request $request)
    {

        $startOfThisWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $endOfThisWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY);
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek(Carbon::SATURDAY);
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek(Carbon::FRIDAY);



        return view('reports.weekly',[
            'startOfThisWeek'=>$startOfThisWeek,
            'endOfThisWeek'=>$endOfThisWeek,
            'startOfLastWeek'=>$startOfLastWeek,
            'endOfLastWeek'=>$endOfLastWeek,
        ]);

    }

    public function thisWeek(Request $request)
    {

        $startOfThisWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $endOfThisWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY);

        if ($request->ajax()) {

            return DataTables::of(Employee::query())
            ->addColumn('total_wh_time', function ($employee) use ($startOfThisWeek,$endOfThisWeek){
                return $employee->hours()
                    // ->whereDate('created_at', $targatedDate  )
                    ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                    ->sum('wh_time');
            })
            ->rawColumns(['total_wh_time'])
            ->make(true);
        }

    }


    public function lastWeek(Request $request)
    {

        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek(Carbon::SATURDAY);
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek(Carbon::FRIDAY);

        if ($request->ajax()) {

            return DataTables::of(Employee::query())
            ->addColumn('total_wh_time', function ($employee) use ($startOfLastWeek,$endOfLastWeek){
                return $employee->hours()
                    // ->whereDate('created_at', $targatedDate  )
                    ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
                    ->sum('wh_time');
            })
            ->rawColumns(['total_wh_time'])
            ->make(true);
        }

    }


    public function monthly(Request $request)
    {

        $targatedMonth = now()->month;
        // var_dump($targatedMonth);
        // return $targatedMonth;

        if ($request->targatedMonth) {
            $targatedMonth = $request->targatedMonth;
        }

        if ($request->ajax()) {

            return DataTables::of(Employee::query())
            ->addColumn('total_wh_time', function ($employee) use ($targatedMonth){
                return $employee->hours()
                    ->whereMonth('created_at', $targatedMonth)
                    ->sum('wh_time');
            })
            ->rawColumns(['total_wh_time'])
            ->make(true);
        }


        return view('reports.monthly',['thisMonth' => $targatedMonth]);

    }


    public function yearly (Request $request)
    {

        $targatedYear = now()->year;
        // var_dump($targatedYear);
        // return $targatedYear;

        if ($request->targatedYear) {
            $targatedYear = $request->targatedYear;
        }

        if ($request->ajax()) {

            return DataTables::of(Employee::query())
            ->addColumn('total_wh_time', function ($employee) use ($targatedYear){
                return $employee->hours()
                    ->whereYear('created_at', $targatedYear)
                    ->sum('wh_time');
            })
            ->rawColumns(['total_wh_time'])
            ->make(true);
        }

        return view('reports.yearly');

    }


    public function range(Request $request)
    {

        $startOfThisWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $endOfThisWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY);

        if ($request->ajax()) {
            if ($request->startDate) {
                $startOfThisWeek = Carbon::parse($request->startDate);
                $endOfThisWeek = Carbon::parse($request->endDate);
            }
            return DataTables::of(Employee::query())
            ->addColumn('total_wh_time', function ($employee) use ($startOfThisWeek,$endOfThisWeek){
                return $employee->hours()
                    // ->whereDate('created_at', $targatedDate  )
                    ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                    ->sum('wh_time');
            })
            ->rawColumns(['total_wh_time'])
            ->make(true);
        }


        return view('reports.custom',['startOfThisWeek'=>$startOfThisWeek,'endOfThisWeek'=>$endOfThisWeek]);
    }
}
