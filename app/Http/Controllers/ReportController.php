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
        } else {
            $targatedDate = Carbon::today();
        }

        if ($request->ajax()) {
            return DataTables::of(Employee::query())
                ->addColumn('total_wh_time', function ($employee) use ($targatedDate) {
                    $totalWorkedSeconds = $employee->hours()
                        ->whereDate('created_at', $targatedDate)
                        ->get()
                        ->reduce(function ($total, $hour) {
                            // Assuming `wh_time` is stored as "HH:MM:SS"
                            list($hours, $minutes, $seconds) = explode(':', $hour->wh_time);
                            $secondsFromTime = ($hours * 3600) + ($minutes * 60) + $seconds;
                            return $total + $secondsFromTime;
                        }, 0);

                    if ($totalWorkedSeconds == 0) {
                        return '00 min';
                    }

                    // Convert total seconds to HH:MM:SS format
                    $hours = floor($totalWorkedSeconds / 3600);
                    $minutes = floor(($totalWorkedSeconds % 3600) / 60);
                    $seconds = $totalWorkedSeconds % 60;

                    return sprintf('%02d hr %02d min', $hours, $minutes, $seconds);
                })
                ->addColumn('target', function ($employee) use ($targatedDate) {

                    // return var_dump($employee->we);

                    $carbonDate = Carbon::parse($targatedDate);
                    $dayOfWeek = $carbonDate->format('l');
                    $weekends = json_decode($employee->we);
                    if ($employee->we && in_array($dayOfWeek,$weekends)) {
                        return "Weekend";
                    }
                    return $employee->wh." hr";
                })
                ->rawColumns(['total_wh_time','target'])
                ->make(true);
        }

        return view('reports.daily', ['targatedDate' => $targatedDate]);
    }



    /**
     * Show daily report.
     */
    public function latest(Request $request)
    {

        $targatedDate = now()->toDateString();

        if ($request->ajax()) {

            return DataTables::of(
                Attendance::with(['employee','capture'])->whereDate('created_at', $targatedDate)->latest()->take(5)->orderBy('id', 'ASC')
            )
            ->make(true);
        }

    }

    /**
     * Show daily report.
     */
    public function dailyscan(Request $request)
    {

        if ($request->targatedDay) {
            $targatedDate = $request->targatedDay;
        } else {
            $targatedDate = Carbon::today();
        }

        if ($request->ajax()) {

            return DataTables::of(
                Attendance::with(['employee','capture'])->whereDate('created_at', $targatedDate)->latest()->orderBy('id', 'ASC')
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
                    return 1;
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
            ->addColumn('total_wh_time', function ($employee) use ($startOfThisWeek,$endOfThisWeek) {
                $totalWorkedSeconds = $employee->hours()
                ->whereBetween('created_at',  [$startOfThisWeek, $endOfThisWeek])
                    ->get()
                    ->reduce(function ($total, $hour) {
                        // Assuming `wh_time` is stored as "HH:MM:SS"
                        list($hours, $minutes, $seconds) = explode(':', $hour->wh_time);
                        $secondsFromTime = ($hours * 3600) + ($minutes * 60) + $seconds;
                        return $total + $secondsFromTime;
                    }, 0);

                if ($totalWorkedSeconds == 0) {
                    return '00 min';
                }

                // Convert total seconds to HH:MM:SS format
                $hours = floor($totalWorkedSeconds / 3600);
                $minutes = floor(($totalWorkedSeconds % 3600) / 60);
                $seconds = $totalWorkedSeconds % 60;

                return sprintf('%02d hr %02d min', $hours, $minutes, $seconds);
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
            ->addColumn('total_wh_time', function ($employee) use ($startOfLastWeek,$endOfLastWeek) {
                $totalWorkedSeconds = $employee->hours()
                ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
                    ->get()
                    ->reduce(function ($total, $hour) {
                        // Assuming `wh_time` is stored as "HH:MM:SS"
                        list($hours, $minutes, $seconds) = explode(':', $hour->wh_time);
                        $secondsFromTime = ($hours * 3600) + ($minutes * 60) + $seconds;
                        return $total + $secondsFromTime;
                    }, 0);

                if ($totalWorkedSeconds == 0) {
                    return '00 min';
                }

                // Convert total seconds to HH:MM:SS format
                $hours = floor($totalWorkedSeconds / 3600);
                $minutes = floor(($totalWorkedSeconds % 3600) / 60);
                $seconds = $totalWorkedSeconds % 60;

                return sprintf('%02d hr %02d min', $hours, $minutes, $seconds);
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
            ->addColumn('total_wh_time', function ($employee) use ($targatedMonth) {
                $totalWorkedSeconds = $employee->hours()
                ->whereMonth('created_at', $targatedMonth)
                    ->get()
                    ->reduce(function ($total, $hour) {
                        // Assuming `wh_time` is stored as "HH:MM:SS"
                        list($hours, $minutes, $seconds) = explode(':', $hour->wh_time);
                        $secondsFromTime = ($hours * 3600) + ($minutes * 60) + $seconds;
                        return $total + $secondsFromTime;
                    }, 0);

                if ($totalWorkedSeconds == 0) {
                    return '00 min';
                }

                // Convert total seconds to HH:MM:SS format
                $hours = floor($totalWorkedSeconds / 3600);
                $minutes = floor(($totalWorkedSeconds % 3600) / 60);
                $seconds = $totalWorkedSeconds % 60;

                return sprintf('%02d hr %02d min', $hours, $minutes, $seconds);
            })
            ->rawColumns(['total_wh_time'])
            ->make(true);
        }


        return view('reports.monthly',['thisMonth' => $targatedMonth]);

    }


    // public function yearly (Request $request)
    // {

    //     $targatedYear = now()->year;
    //     // var_dump($targatedYear);
    //     // return $targatedYear;

    //     if ($request->targatedYear) {
    //         $targatedYear = $request->targatedYear;
    //     }

    //     if ($request->ajax()) {

    //         return DataTables::of(Employee::query())
    //         ->addColumn('total_wh_time', function ($employee) use ($targatedYear){
    //             $totalworkedHour = $employee->hours()
    //                 ->whereYear('created_at', $targatedYear)
    //                 ->sum('wh_time');

    //                 if ($totalworkedHour == 0) {
    //                     return '00:00:00';
    //                 } else {
    //                     $outputString = substr_replace($totalworkedHour, ':', -4, 0);
    //                     $outputString = substr_replace($outputString, ':', -2, 0);
    //                     return $outputString ;
    //                 }
    //         })
    //         ->rawColumns(['total_wh_time'])
    //         ->make(true);
    //     }

    //     return view('reports.yearly');

    // }





    public function yearly(Request $request)
    {
        $targatedYear = now()->year;

        if ($request->targatedYear) {
            $targatedYear = $request->targatedYear;
        }

        if ($request->ajax()) {
            return DataTables::of(Employee::query())
                ->addColumn('total_wh_time', function ($employee) use ($targatedYear) {
                    $totalWorkedSeconds = $employee->hours()
                    ->whereYear('created_at', $targatedYear)
                        ->get()
                        ->reduce(function ($total, $hour) {
                            // Assuming `wh_time` is stored as "HH:MM:SS"
                            list($hours, $minutes, $seconds) = explode(':', $hour->wh_time);
                            $secondsFromTime = ($hours * 3600) + ($minutes * 60) + $seconds;
                            return $total + $secondsFromTime;
                        }, 0);

                    if ($totalWorkedSeconds == 0) {
                        return '00 min';
                    }

                    // Convert total seconds to HH:MM:SS format
                    $hours = floor($totalWorkedSeconds / 3600);
                    $minutes = floor(($totalWorkedSeconds % 3600) / 60);
                    $seconds = $totalWorkedSeconds % 60;

                    return sprintf('%02d hr %02d min', $hours, $minutes, $seconds);
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
                    $totalWorkedSeconds = $employee->hours()
                    // ->whereDate('created_at', $targatedDate  )
                    ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                    ->get()
                    ->reduce(function ($total, $hour) {
                        // Assuming `wh_time` is stored as "HH:MM:SS"
                        list($hours, $minutes, $seconds) = explode(':', $hour->wh_time);
                        $secondsFromTime = ($hours * 3600) + ($minutes * 60) + $seconds;
                        return $total + $secondsFromTime;
                    }, 0);

                    if ($totalWorkedSeconds == 0) {
                        return '00 min';
                    }

                    // Convert total seconds to HH:MM:SS format
                    $hours = floor($totalWorkedSeconds / 3600);
                    $minutes = floor(($totalWorkedSeconds % 3600) / 60);
                    $seconds = $totalWorkedSeconds % 60;

                    return sprintf('%02d hr %02d min', $hours, $minutes, $seconds);
            })
            ->rawColumns(['total_wh_time'])
            ->make(true);
        }


        return view('reports.custom',['startOfThisWeek'=>$startOfThisWeek,'endOfThisWeek'=>$endOfThisWeek]);
    }
}
