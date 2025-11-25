<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function attendanceIndexTwo($shift, $date)
    {
        $users = User::where('agency_id', auth()->user()->agency_id)->where('user_type', 'responder')->paginate(10);



        return view('PAGES/bfp/manage-attendance-time-out', compact('users', 'shift', 'date'));
    }

    public function attendanceIndex($shift, $date)
    {
        $users = User::where('agency_id', auth()->user()->agency_id)->where('user_type', 'responder')->paginate(10);



        return view('PAGES/bfp/manage-attendance', compact('users', 'shift', 'date'));
    }

    // Record Time-in
    public function attendanceTimeIn(Request $request)
    {
        Attendance::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'shift' => $request->shift,
                'date' => $request->date,
                'category' => $request->category
            ],
            [
                'time_in' => $request->time_in,
                'status' => 'Time-in Success',
            ]
        );

        User::where('id', $request->user_id)->update([
            'availability_status' => 'Available'
        ]);

        return back()->with('success', 'Time-in recorded successfully!');
    }

    // Record Time-out
    public function attendanceTimeOut(Request $request)
    {
        Attendance::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'shift' => $request->shift,
                'date' => $request->date,
                'category' => $request->category
            ],
            [
                'time_out' => $request->time_out,
                'status' => 'Time-out Success',
            ]
        );

        User::where('id', $request->user_id)->update([
            'availability_status' => 'Unavailable'
        ]);

        return back()->with('success', 'Time-out recorded successfully!');
    }


    // Mark as Absent or Missed Time-out
    public function attendanceMissedTimeOut(Request $request)
    {
        Attendance::create([
            'user_id' => $request->user_id,
            'shift' => $request->shift,
            'date' => $request->date,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        User::where('id', $request->user_id)->update([
            'availability_status' => 'Unavailable'
        ]);

        return back()->with('success', 'Missed Time-out Recorded successfully');
    }
    // Mark as Absent or Missed Time-out
    public function attendanceAbsent(Request $request)
    {
        Attendance::create([
            'user_id' => $request->user_id,
            'shift' => $request->shift,
            'date' => $request->date,
            'category' => $request->category,
            'status' => $request->status,

        ]);

        User::where('id', $request->user_id)->update([
            'availability_status' => 'Unavailable'
        ]);

        return redirect()->back()->with('success', 'Absent Recorded successfully');
    }

    public function cancelAttendance($id)
    {
        $attendanceRecord = Attendance::findOrFail($id);

        // Get the user ID from the attendance record
        $userId = $attendanceRecord->user_id;

        // Delete the attendance record
        $attendanceRecord->delete();

        // Update the user's availability
        User::where('id', $userId)->update([
            'availability_status' => 'Unavailable'
        ]);

        return back()->with('success', 'Attendance record canceled!');
    }
}
