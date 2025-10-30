<?php

namespace App\Http\Controllers;

use App\Models\EmergencyRoomBed;
use Illuminate\Http\Request;

class EmergencyRoomBedController extends Controller
{
    public function index(Request $request)
    {
        $sessionUserAgency = auth()->user()->agency_id;
        $search = $request->input('search');

        $beds = EmergencyRoomBed::where('agency_id', $sessionUserAgency)
            ->when($search, function ($query, $search) {
                $query->where('room_number', 'like', "%{$search}%")
                    ->orWhere('bed_type', 'like', "%{$search}%")
                    ->orWhere('bed_number', 'like', "%{$search}%")
                    ->orWhere('availabilityStatus', 'like', "%{$search}%");
            })
            ->orderBy('bed_type')->paginate(10);

        $bedsAvailable = $beds->where('availabilityStatus', 'Available')->count();
        $bedsUnavailable = $beds->where('availabilityStatus', 'Unavailable')->count();

        return view('PAGES/hospital/manage-er-bed', compact('beds', 'bedsAvailable', 'bedsUnavailable', 'search'));
    }


    public function submitBed(Request $request)
    {
        $validatedData = $request->validate([
            'room_number' => 'required|numeric|min:0',
            'bed_type' => 'required|string|max:220',
            'bed_number' => 'required|numeric|min:0',
            'availabilityStatus' => 'in:Available,Unavailable',
            'agency_id' => 'required|exists:agencies,id',
        ]);

        // 🧠 Check for existing bed with same agency, room_number, bed_type, and bed_number
        $existingBed = EmergencyRoomBed::where('agency_id', $validatedData['agency_id'])
            ->where('room_number', $validatedData['room_number'])
            ->where('bed_type', $validatedData['bed_type'])
            ->where('bed_number', $validatedData['bed_number'])
            ->first();

        if ($existingBed) {
            return redirect()->back()->with('error', 'This bed already exists for this agency, room, type, and number.');
        }

        // ✅ Create new bed if unique
        EmergencyRoomBed::create([
            'room_number' => $validatedData['room_number'],
            'bed_type' => $validatedData['bed_type'],
            'bed_number' => $validatedData['bed_number'],
            'availabilityStatus' => $validatedData['availabilityStatus'],
            'agency_id' => $validatedData['agency_id'],
        ]);

        return redirect()->back()->with('success', 'New bed added successfully!');
    }

    public function editBed(Request $request, $id)
    {
        $validatedData = $request->validate([
            'room_number' => 'required|numeric|min:0',
            'bed_type' => 'required|string|max:220',
            'bed_number' => 'required|numeric|min:0',
            'availabilityStatus' => 'in:Available,Unavailable',
            'agency_id' => 'required|exists:agencies,id',
        ]);

        // 🛏 Find the bed to update
        $bed = EmergencyRoomBed::findOrFail($id);

        // 🧠 Check if another bed with same agency, room_number, bed_type, and bed_number already exists
        $duplicate = EmergencyRoomBed::where('agency_id', $validatedData['agency_id'])
            ->where('room_number', $validatedData['room_number'])
            ->where('bed_type', $validatedData['bed_type'])
            ->where('bed_number', $validatedData['bed_number'])
            ->where('id', '!=', $id) // exclude current bed being edited
            ->first();

        if ($duplicate) {
            return redirect()->back()->with('error', 'Another bed with the same agency, room, type, and number already exists.');
        }

        // ✅ Update bed details
        $bed->update([
            'room_number' => $validatedData['room_number'],
            'bed_type' => $validatedData['bed_type'],
            'bed_number' => $validatedData['bed_number'],
            'availabilityStatus' => $validatedData['availabilityStatus'],
            'agency_id' => $validatedData['agency_id'],
        ]);

        return redirect()->back()->with('success', 'Bed details updated successfully!');
    }

    public function deleteBed($id)
    {
        $bed = EmergencyRoomBed::findOrFail($id);
        $bed->delete(); // Soft delete — it won't be permanently removed
        return redirect()->back()->with('success', 'Bed deleted successfully.');
    }
}
