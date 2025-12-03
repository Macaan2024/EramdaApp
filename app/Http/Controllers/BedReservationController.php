<?php

namespace App\Http\Controllers;

use App\Models\BedReservation;
use App\Models\EmergencyRoomBed;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class BedReservationController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            'submitted_report_id' => 'required|exists:submitted_reports,id',
            'agency_id' => 'required|exists:agencies,id',
            'emergency_room_bed_id' => 'required|exists:emergency_room_beds,id',
        ]);

        // 2. Find the bed to check status and update it
        $bed = EmergencyRoomBed::findOrFail($request->emergency_room_bed_id);

        if ($bed->availabilityStatus !== 'Available') {
            return back()->with('error', 'This bed is no longer available.');
        }

        // 3. Create the Reservation (Eloquent)
        BedReservation::create([
            'submitted_report_id'   => $request->submitted_report_id,
            'agency_id'             => $request->agency_id,
            'emergency_room_bed_id' => $request->emergency_room_bed_id,
            'user_id'               => auth()->user()->id, // Correct syntax for logged in user
            'request_status' => 'Pending'
        ]);

        return back()->with('success', 'Bed reserved successfully.');
    }

    public function acceptReserve($id)
    {
        $reservation = BedReservation::findOrFail($id);
        $reservation->emergencyRoomBed->update([
            'availabilityStatus' => 'Reserved'
        ]);

        $reservation->request_status = 'Accepted';
        $reservation->save();

        return back()->with('success', 'Reservation accepted successfully.');
    }

    public function cancelReserve($id)
    {
        $reservation = BedReservation::findOrFail($id);

        $reservation->request_status = 'Cancelled';
        $reservation->save();

        return back()->with('error', 'Reservation has been cancelled.');
    }

    public function undo($id)
    {
        $reservation = BedReservation::findOrFail($id);
        $reservation->emergencyRoomBed->update([
            'availabilityStatus' => 'Available'
        ]);

        // Revert status to Pending so Accept/Cancel appear again
        $reservation->request_status = 'Pending';
        $reservation->save();

        return back()->with('info', 'Reservation status reverted to Pending.');
    }
}
