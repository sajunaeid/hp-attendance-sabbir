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
                    }else{
                        list($hours, $minutes) = explode(':', $employee->wh);
                        $hours = (int) $hours;
                        $minutes = (int) $minutes;
                        return $hours.' hr '.$minutes.' min';
                    }

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
            ->addColumn('total_wh_time', function ($employee) use ($startOfThisWeek, $endOfThisWeek) {
                $totalWorkedSeconds = $employee->hours()
                    ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
                    ->get()
                    ->reduce(function ($total, $hour) {
                        // Assuming `wh_time` is stored as "HH:MM:SS"
                        if ($hour->wh_time) {
                            list($hours, $minutes, $seconds) = explode(':', $hour->wh_time);
                            $secondsFromTime = ($hours * 3600) + ($minutes * 60) + $seconds;
                            return $total + $secondsFromTime;
                        }
                        return $total;
                    }, 0);

                if ($totalWorkedSeconds == 0) {
                    return '00 hr 00 min';
                }

                // Convert total seconds to HH:MM:SS format
                $hours = floor($totalWorkedSeconds / 3600);
                $minutes = floor(($totalWorkedSeconds % 3600) / 60);
                $seconds = $totalWorkedSeconds % 60;

                return sprintf('%02d hr %02d min', $hours, $minutes);
            })->addColumn('target', function ($employee) use ($startOfThisWeek, $endOfThisWeek) {
                $weekends = json_decode($employee->we);
                $totalSeconds = 0;

                // Parse the employee's creation date
                $employeeCreatedAt = Carbon::parse($employee->created_at);

                // Determine the start date for the calculation
                $calculationStartDate = $employeeCreatedAt->greaterThan(Carbon::parse($startOfThisWeek))
                                        ? $employeeCreatedAt
                                        : Carbon::parse($startOfThisWeek);

                // Loop through each day of the week from the calculated start date to the end of the week
                $currentDate = $calculationStartDate;
                while ($currentDate->lte(Carbon::parse($endOfThisWeek))) {
                    $dayOfWeek = $currentDate->format('l');

                    // If the day is not a weekend for the employee, add the work hours
                    if (!in_array($dayOfWeek, $weekends)) {
                        if ($employee->wh) {
                            list($hours, $minutes) = explode(':', $employee->wh);
                            $secondsFromTime = ($hours * 3600) + ($minutes * 60);
                            $totalSeconds += $secondsFromTime;
                        }
                    }

                    // Move to the next day
                    $currentDate->addDay();
                }

                // Convert total seconds to hours and minutes
                $hours = floor($totalSeconds / 3600);
                $minutes = floor(($totalSeconds % 3600) / 60);

                return sprintf('%02d hr %02d min', $hours, $minutes);
            })
            ->rawColumns(['total_wh_time','target'])
            ->make(true);
        }

    }


    public function lastWeek(Request $request)
    {

        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek(Carbon::SATURDAY);
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek(Carbon::FRIDAY);

        if ($request->ajax()) {

            return DataTables::of(Employee::query())
            ->addColumn('total_wh_time', function ($employee) use ($startOfLastWeek, $endOfLastWeek) {
                $totalWorkedSeconds = $employee->hours()
                    ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
                    ->get()
                    ->reduce(function ($total, $hour) {
                        // Check if `wh_time` is set and has the correct format
                        if ($hour->wh_time) {
                            list($hours, $minutes, $seconds) = explode(':', $hour->wh_time);
                            $secondsFromTime = ($hours * 3600) + ($minutes * 60) + $seconds;
                            return $total + $secondsFromTime;
                        }
                        return $total;
                    }, 0);

                if ($totalWorkedSeconds == 0) {
                    return '00 hr 00 min';
                }

                // Convert total seconds to hours and minutes
                $hours = floor($totalWorkedSeconds / 3600);
                $minutes = floor(($totalWorkedSeconds % 3600) / 60);
                // The variable $seconds is not used in the return statement

                return sprintf('%02d hr %02d min', $hours, $minutes);
            })->addColumn('target', function ($employee) use ($startOfLastWeek, $endOfLastWeek) {
                $weekends = json_decode($employee->we);
                $totalSeconds = 0;

                // Parse the employee's creation date
                $employeeCreatedAt = Carbon::parse($employee->created_at);

                // Determine the start date for the calculation
                $calculationStartDate = $employeeCreatedAt->greaterThan(Carbon::parse($startOfLastWeek))
                                        ? $employeeCreatedAt
                                        : Carbon::parse($startOfLastWeek);

                // Loop through each day of the week from the calculated start date to the end of the week
                $currentDate = $calculationStartDate;
                while ($currentDate->lte(Carbon::parse($endOfLastWeek))) {
                    $dayOfWeek = $currentDate->format('l');

                    // If the day is not a weekend for the employee, add the work hours
                    if (!in_array($dayOfWeek, $weekends)) {
                        if ($employee->wh) {
                            list($hours, $minutes) = explode(':', $employee->wh);
                            $secondsFromTime = ($hours * 3600) + ($minutes * 60);
                            $totalSeconds += $secondsFromTime;
                        }
                    }

                    // Move to the next day
                    $currentDate->addDay();
                }

                // Convert total seconds to hours and minutes
                $hours = floor($totalSeconds / 3600);
                $minutes = floor(($totalSeconds % 3600) / 60);

                return sprintf('%02d hr %02d min', $hours, $minutes);
            })
            ->rawColumns(['total_wh_time','target'])
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
            })->addColumn('target', function ($employee) use ($targatedMonth) {

                // Get the current date and month
                $currentDate = Carbon::now();
                $currentMonth = $currentDate->month;

                // Determine the start and end dates based on the targeted month
                if ($targatedMonth == $currentMonth) {
                    // Targeted month is this month
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon::now(); // Today
                } else {
                    // Targeted month is not this month
                    $startOfMonth = Carbon::create($currentDate->year, $targatedMonth, 1)->startOfDay();
                    $endOfMonth = Carbon::create($currentDate->year, $targatedMonth, Carbon::create($currentDate->year, $targatedMonth)->daysInMonth)->endOfDay();
                }

                // Adjust the start date if created_at is in the targeted month
                $createdAt = Carbon::parse($employee->created_at);
                if ($createdAt->month == $targatedMonth && $createdAt->year == $currentDate->year) {
                    $startOfMonth = $createdAt;
                }

                // Get all the working days in the date range
                $workingDays = [];
                for ($date = $startOfMonth->copy(); $date->lessThanOrEqualTo($endOfMonth); $date->addDay()) {
                    // Check if the current date is a weekday and not a weekend
                    if (!in_array($date->format('l'), json_decode($employee->we))) {
                        $workingDays[] = $date->copy(); // Store the working day
                    }
                }

                // Calculate the total working hours
                list($hours, $minutes) = explode(':', $employee->wh);
                $totalHours = (int) $hours;
                $totalMinutes = (int) $minutes;

                // Calculate total working time based on working days
                $totalWorkingTime = count($workingDays) * ($totalHours * 60 + $totalMinutes); // Total minutes

                // Convert total minutes back to hours and minutes
                $finalHours = floor($totalWorkingTime / 60);
                $finalMinutes = $totalWorkingTime % 60;

                return sprintf("%d hr %d min", $finalHours, $finalMinutes);

            })->addColumn('presentDays', function ($employee) use ($targatedMonth) {
                $currentDate = Carbon::now();
                $currentMonth = $currentDate->month;

                // Determine the start and end dates
                if ($targatedMonth == $currentMonth) {
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon::now(); // Today
                } else {
                    $startOfMonth = Carbon::create($currentDate->year, $targatedMonth, 1)->startOfDay();
                    $endOfMonth = Carbon::create($currentDate->year, $targatedMonth, Carbon::create($currentDate->year, $targatedMonth)->daysInMonth)->endOfDay();
                }

                // Adjust the start date if created_at is in the targeted month
                $createdAt = Carbon::parse($employee->created_at);
                if ($createdAt->month == $targatedMonth && $createdAt->year == $currentDate->year) {
                    $startOfMonth = $createdAt;
                }

                $presentDays = 0;
                $weekends = json_decode($employee->we) ?? [];

                // Iterate over each day in the range
                for ($date = $startOfMonth->copy(); $date->lessThanOrEqualTo($endOfMonth); $date->addDay()) {
                    if (in_array($date->format('l'), $weekends)) {
                        continue; // Skip weekends
                    }

                    $attendance = Attendance::where('employee_id', $employee->id)
                        ->whereDate('created_at', $date)
                        ->first();

                    if ($attendance) {
                        $presentDays++; // Count present days
                    }
                }
                return $presentDays;
            })->addColumn('absentDays', function ($employee) use ($targatedMonth) {
                $currentDate = Carbon::now();
                $currentMonth = $currentDate->month;

                // Determine the start and end dates
                if ($targatedMonth == $currentMonth) {
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon::now(); // Today
                } else {
                    $startOfMonth = Carbon::create($currentDate->year, $targatedMonth, 1)->startOfDay();
                    $endOfMonth = Carbon::create($currentDate->year, $targatedMonth, Carbon::create($currentDate->year, $targatedMonth)->daysInMonth)->endOfDay();
                }

                // Adjust the start date if created_at is in the targeted month
                $createdAt = Carbon::parse($employee->created_at);
                if ($createdAt->month == $targatedMonth && $createdAt->year == $currentDate->year) {
                    $startOfMonth = $createdAt;
                }

                $absentDays = 0;
                $weekends = json_decode($employee->we) ?? [];

                // Iterate over each day in the range
                for ($date = $startOfMonth->copy(); $date->lessThanOrEqualTo($endOfMonth); $date->addDay()) {
                    if (in_array($date->format('l'), $weekends)) {
                        continue; // Skip weekends
                    }

                    $attendance = Attendance::where('employee_id', $employee->id)
                        ->whereDate('created_at', $date)
                        ->first();

                    if (!$attendance) {
                        $absentDays++; // Count absent days
                    }
                }

                return $absentDays;
            })->addColumn('totalWeekends', function ($employee) use ($targatedMonth) {
                $currentDate = Carbon::now();
                $currentMonth = $currentDate->month;

                // Determine the start and end dates
                if ($targatedMonth == $currentMonth) {
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon::now(); // Today
                } else {
                    $startOfMonth = Carbon::create($currentDate->year, $targatedMonth, 1)->startOfDay();
                    $endOfMonth = Carbon::create($currentDate->year, $targatedMonth, Carbon::create($currentDate->year, $targatedMonth)->daysInMonth)->endOfDay();
                }

                // Adjust the start date if created_at is in the targeted month
                $createdAt = Carbon::parse($employee->created_at);
                if ($createdAt->month == $targatedMonth && $createdAt->year == $currentDate->year) {
                    $startOfMonth = $createdAt;
                }

                $totalWeekends = 0;
                $weekends = json_decode($employee->we) ?? [];

                // Iterate over each day in the range
                for ($date = $startOfMonth->copy(); $date->lessThanOrEqualTo($endOfMonth); $date->addDay()) {
                    if (in_array($date->format('l'), $weekends)) {
                        $totalWeekends++; // Count weekends
                    }
                }

                return $totalWeekends;
            })
            ->rawColumns(['total_wh_time','target','presentDays','absentDays','totalWeekends'])
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
