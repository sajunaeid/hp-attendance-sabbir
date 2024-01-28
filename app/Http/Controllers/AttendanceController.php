<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Hour;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request)
    {

        // return $request;
        $requestedEmployee = Employee::where('emp_id', $request->emp_number)->first();

        if (!$requestedEmployee) {
            return response()->json(['message' => 'Employee not Found.']);
        }

        $currentTime = Carbon::now();
        $nineAm = Carbon::today()->setHour(9);
        $tenPm = Carbon::today()->setHour(22);
        $now = Carbon::now()->format('h:i:s');
        $today = Carbon::now()->format('Y-m-d');

        $formattedDateTime = $currentTime->format('Y-m-d H:i:s');
        $carbonated = Carbon::parse($formattedDateTime)->setTimezone('Asia/Dhaka');

        if ($currentTime < $nineAm) {
            return response()->json(['message' => 'You can only scan after 9 am']);
        } elseif ($currentTime > $tenPm) {
            return response()->json(['message' => 'Sorry, you are late']);
        } else {
            // Check if there's an entry for today's date for this employee
            // Last scan today
            $previousScanToday = Attendance::latest()->where('employee_id', $requestedEmployee->id)
            ->whereDate('created_at', $today)
            ->orderBy('scan_time', 'desc')->first();

            if (!$previousScanToday) {

                $this->createAttendance($requestedEmployee->id, 1, $carbonated);
                Hour::create([
                    'employee_id' => $requestedEmployee->id,
                    'in_time' => $carbonated,
                ]);
                return response()->json(['message' => $requestedEmployee->name.' IN.', 'mode' => 1]);

            } else {

                // Check if it's been more than 2 minutes since the last scan
                $lastScanTime = Carbon::parse($previousScanToday->created_at);
                if ($carbonated->diffInSeconds($lastScanTime) < 50) {
                    return response()->json(['message' => 'Please wait at least 2 minutes before scanning again.']);
                }


                // last snan type in - out
                if ($previousScanToday->scan_type == 1) {
                    $this->createAttendance($requestedEmployee->id, 2, $carbonated);
                    $empHour = Hour::where('employee_id',$requestedEmployee->id)->orderBy('id', 'desc')->first();
                    $eh_inTime = Carbon::parse($empHour->in_time);
                    $eh_outTime = Carbon::parse($now);

                    $empHour->out_time = $carbonated;
                    $minutesDifference = $carbonated->diffInMinutes($eh_inTime);

                    // Calculate hours and remaining minutes
                    $hr = intdiv($minutesDifference, 60);
                    $mn = $minutesDifference % 60;

                    $timeString = strval($hr).':'.strval($mn).':00';
                    // Convert the string to a Carbon instance
                    $workedHour = Carbon::create(0, 0, 0, $hr, $mn, 0)->format('H:i:s');;
                    // $workedHour = Carbon::createFromFormat('H:i:s', $timeString);
                    $empHour->wh_time = $workedHour;
                    $empHour->update();
                    return response()->json(['message' => $requestedEmployee->name.' OUT.', 'mode' => 2]);
                }else {
                    $this->createAttendance($requestedEmployee->id, 1, $carbonated);
                    Hour::create([
                        'employee_id' => $requestedEmployee->id,
                        'in_time' => $carbonated,
                    ]);
                    return response()->json(['message' => $requestedEmployee->name.' IN.', 'mode' => 1]);
                }
            }
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }


    protected function createAttendance($employeeId, $scanType, $scanTime)
    {
        Attendance::create([
            'employee_id' => $employeeId,
            'scan_type' => $scanType,
            'scan_time' => $scanTime,
        ]);
    }
}
