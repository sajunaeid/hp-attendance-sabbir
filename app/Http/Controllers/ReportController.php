<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Hour;
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

                $totalworkedHour = $employee->hours()
                ->whereDate('created_at', $targatedDate  )
                ->sum('wh_time');

                if ($totalworkedHour == 0) {
                    return '00:00:00';
                } else {
                    $outputString = substr_replace($totalworkedHour, ':', -4, 0);
                    $outputString = substr_replace($outputString, ':', -2, 0);
                    return $outputString ;
                }

            })
            ->rawColumns(['total_wh_time'])
            ->make(true);
        }
        return view('reports.daily',['targatedDate'=>$targatedDate]);

    }


    /**
     * Show daily report.
     */
    public function latest(Request $request)
    {

        $targatedDate = now()->toDateString();

        if ($request->ajax()) {

            return DataTables::of(
                Attendance::with('employee')->whereDate('created_at', $targatedDate)->latest()->take(5)->get()
            )
            ->make(true);
        }

    }


    public function present(Request $request)
    {
        if ($request->targatedDay) {
            $targatedDate = $request->targatedDay;
        }else{
            $targatedDate = now()->toDateString();
        }

        if ($request->ajax()) {
            return DataTables::of(Employee::query())
            ->addColumn('ads', function ($employee) use ($targatedDate){
                $scantoday = Hour::where('employee_id',$employee->id)->whereDate('created_at', $targatedDate)->get();
                if ($scantoday->count() > 0) {
                    if ($scantoday->count() == 1) {
                        $hour = Hour::where('employee_id',$employee->id)->whereDate('created_at', $targatedDate)->latest()->first();
                        if ($hour && $hour->in_time && $hour->out_time) {
                            return 1;
                        } else {
                            return 2;
                        }
                    } else {

                        return 1;
                    }
                } else {
                    return 2 ;
                }
            })
            ->addColumn('state', function ($employee) use ($targatedDate){
                $hour = Hour::where('employee_id',$employee->id)->whereDate('created_at', $targatedDate)->latest()->first();
                if ($hour && $hour->in_time && !$hour->out_time) {
                    return 1;
                } elseif($hour && $hour->in_time && $hour->out_time) {
                    return 2 ;
                }else {
                    return 2;
                }
            })
            ->rawColumns(['ads','state'])
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
                $totalworkedHour = $employee->hours()
                    // ->whereDate('created_at', $targatedDate  )
                    ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                    ->sum('wh_time');


                if ($totalworkedHour == 0) {
                    return '00:00:00';
                } else {
                    $outputString = substr_replace($totalworkedHour, ':', -4, 0);
                    $outputString = substr_replace($outputString, ':', -2, 0);
                    return $outputString ;
                }
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
                $totalworkedHour = $employee->hours()
                    // ->whereDate('created_at', $targatedDate  )
                    ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
                    ->sum('wh_time');


                if ($totalworkedHour == 0) {
                    return '00:00:00';
                } else {
                    $outputString = substr_replace($totalworkedHour, ':', -4, 0);
                    $outputString = substr_replace($outputString, ':', -2, 0);
                    return $outputString ;
                }
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
                $totalworkedHour = $employee->hours()
                    ->whereMonth('created_at', $targatedMonth)
                    ->sum('wh_time');

                if ($totalworkedHour == 0) {
                    return '00:00:00';
                } else {
                    $outputString = substr_replace($totalworkedHour, ':', -4, 0);
                    $outputString = substr_replace($outputString, ':', -2, 0);
                    return $outputString ;
                }
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
                $totalworkedHour = $employee->hours()
                    ->whereYear('created_at', $targatedYear)
                    ->sum('wh_time');

                    if ($totalworkedHour == 0) {
                        return '00:00:00';
                    } else {
                        $outputString = substr_replace($totalworkedHour, ':', -4, 0);
                        $outputString = substr_replace($outputString, ':', -2, 0);
                        return $outputString ;
                    }
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
                $totalworkedHour = $employee->hours()
                    // ->whereDate('created_at', $targatedDate  )
                    ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                    ->sum('wh_time');

                    if ($totalworkedHour == 0) {
                        return '00:00:00';
                    } else {
                        $outputString = substr_replace($totalworkedHour, ':', -4, 0);
                        $outputString = substr_replace($outputString, ':', -2, 0);
                        return $outputString ;
                    }
            })
            ->rawColumns(['total_wh_time'])
            ->make(true);
        }


        return view('reports.custom',['startOfThisWeek'=>$startOfThisWeek,'endOfThisWeek'=>$endOfThisWeek]);
    }
}
