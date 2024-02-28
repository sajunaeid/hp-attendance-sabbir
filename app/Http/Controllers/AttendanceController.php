<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Hour;
use Illuminate\Support\Facades\DB;
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

        // Finding the employee withe his/her employee id.
        $requestedEmployee = Employee::where('emp_id', $request->emp_number)->first();
        // If employee not found with the requested employee id.
        if (!$requestedEmployee) {
            return response()->json(['message' => 'Employee not Found.']);
        }

        $currentTime = Carbon::now();//Current date time.
        $nineAm = Carbon::today()->setHour(9);// Scan start time
        $tenPm = Carbon::today()->setHour(22);// Scan end time
        $now = Carbon::now()->format('h:i:s');// Current time
        $today = Carbon::now()->format('Y-m-d');// Current date

        $formattedDateTime = $currentTime->format('Y-m-d H:i:s');
        $carbonated = Carbon::parse($formattedDateTime)->setTimezone('Asia/Dhaka');// Fixing local time for dhaka/asia

        if ($currentTime < $nineAm) {
            // Checking if it is before 9 am.
            return response()->json(['message' => 'You can only scan after 9 am']);
        } elseif ($currentTime >= $tenPm) {
            // Checking if it is after 10 pm.
            return response()->json(['message' => 'Sorry, you are late']);
        } else {
            // Checking is there's an entry for today's date for this employee
            // Last scan today
            $previousScanToday = Attendance::latest()->where('employee_id', $requestedEmployee->id)
            ->whereDate('created_at', $today)
            ->orderBy('scan_time', 'desc')->first();

            if (!$previousScanToday) {
                // If he didn't scan any today
                $this->inentry($requestedEmployee, $carbonated);
                return response()->json(['message' => $requestedEmployee->name.' IN.', 'mode' => 1]);
            } else {

                // Check if it's been more than 2 minutes since the last scan
                $lastScanTime = Carbon::parse($previousScanToday->created_at);

                if ($carbonated->diffInSeconds($lastScanTime) <= 20) {
                    return response()->json(['message' => 'Please wait at least 2 minutes before scanning again.', 'mode' => 2]);
                }


                // last snan type in - out
                if ($previousScanToday->scan_type == 1) {
                    // $this->createAttendance($requestedEmployee->id, 2, $carbonated);

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



                    DB::transaction(function () use ($requestedEmployee, $carbonated){
                        Attendance::create([
                            'employee_id' => $requestedEmployee->id,
                            'scan_type' => 2,
                            'scan_time' => $carbonated,
                        ]);
                    });

                    $empHour->wh_time = $workedHour;
                    $empHour->update();


                    return response()->json(['message' => $requestedEmployee->name.' OUT.', 'mode' => 2]);
                }else {

                    $this->inentry($requestedEmployee, $carbonated);


                    // old code is here...
                    // $this->createAttendance($requestedEmployee->id, 1, $carbonated);
                    // Hour::create([
                    //     'employee_id' => $requestedEmployee->id,
                    //     'in_time' => $carbonated,
                    // ]);

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

    protected function inentry($requestedEmployee,$carbonated){
        DB::transaction(function () use ($requestedEmployee, $carbonated){
            Attendance::create([
                'employee_id' => $requestedEmployee->id,
                'scan_type' => 1,
                'scan_time' => $carbonated,
            ]);

            Hour::create([
                'employee_id' => $requestedEmployee->id,
                'in_time' => $carbonated,
            ]);
        });
    }


    protected function createAttendance($employeeId, $scanType, $scanTime)
    {
        DB::transaction(function ($employeeId, $scanType, $scanTime) {

            $attendance = Attendance::create([
                'employee_id' => $employeeId,
                'scan_type' => $scanType,
                'scan_time' => $scanTime,
            ]);
        });


    }



}
