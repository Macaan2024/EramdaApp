<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\EmergencyVehicle;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmergencyVehiclesController extends Controller
{

    public function vehicleIndex(Request $request)
    {
        $vehicles = EmergencyVehicle::where('agency_id', auth()->user()->agency_id)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('vehicleTypes', 'like', '%' . $request->search . '%')
                        ->orWhere('plateNumber', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Keep the search value when switching pages
        $vehicles->appends(['search' => $request->search]);

        return view('PAGES/bfp/manage-emergency-vehicle', compact('vehicles'));
    }

    public function addVehicles(Request $request)
    {
        $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'vehicleTypes' => 'required|string|max:255',
            'plateNumber' => 'required|string|max:255|unique:emergency_vehicles,plateNumber',
            'vehicle_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'availabilityStatus' => 'required|in:Available,Unavailable',
        ]);

        $photoPath = $request->hasFile('vehicle_photo')
            ? $request->file('vehicle_photo')->store('vehicles', 'public')
            : null;

        $vehicle = EmergencyVehicle::create([
            'agency_id' => $request->agency_id,
            'vehicleTypes' => $request->vehicleTypes,
            'plateNumber' => $request->plateNumber,
            'vehicle_photo' => $photoPath,
            'availabilityStatus' => $request->availabilityStatus,
        ]);

        return $vehicle
            ? redirect()->back()->with('success', 'Successfully Registered Emergency Vehicle.')
            : redirect()->back()->with('error', 'Register failed, Please try again.')->withInput();
    }

    public function updateVehicle(Request $request, $id)
    {
        // Validate inputs
        $request->validate([
            'vehicleTypes' => 'required|string',
            'plateNumber' => 'required|string',
            'vehicle_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'availabilityStatus' => 'required|string',
        ]);

        // Find the vehicle
        $vehicle = EmergencyVehicle::findOrFail($id);

        // Update fields
        $vehicle->vehicleTypes = $request->vehicleTypes;
        $vehicle->plateNumber = $request->plateNumber;
        $vehicle->availabilityStatus = $request->availabilityStatus;
        $vehicle->agency_id = auth()->user()->agency_id;

        // Handle photo (simple)
        if ($request->hasFile('vehicle_photo')) {
            $path = $request->vehicle_photo->store('vehicles', 'public'); // saves in storage/app/public/vehicles
            $vehicle->vehicle_photo = $path;
        }

        $vehicle->save();

        return back()->with('success', 'Vehicle updated successfully!');
    }
}
