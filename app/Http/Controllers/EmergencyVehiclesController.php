<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\EmergencyVehicle;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmergencyVehiclesController extends Controller
{

    public function index(Request $request)
    {
        $vehicles = EmergencyVehicle::where('agency_id', auth()->user()->agency_id)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('vehicleTypes', 'like', '%' . $request->search . '%')
                        ->orWhere('plateNumber', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('PAGES/BFP_BDRRMC/manage-emergency-vehicles', compact('vehicles'));
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

        Log::create([
            'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
            'interaction_type' => 'Add',
            'agency_id' => auth()->user()->agency_id,
            'emergency_vehicle_id' => $vehicle->id, // ✅ only the ID
        ]);


        return $vehicle
            ? redirect()->route('bfp.vehicles')->with('success', 'Successfully Registered Emergency Vehicle.')
            : redirect()->back()->with('error', 'Register failed, Please try again.')->withInput();
    }

    /**
     * Show the form for editing the specified emergency vehicle.
     */
    public function edit($id)
    {
        $vehicles = EmergencyVehicle::findOrFail($id);
        return view('PAGES/BFP_BDRRMC/edit-emergency-vehicles', compact('vehicles'));
    }

    /**
     * Update the specified emergency vehicle in storage.
     */
    public function updateVehicles(Request $request, $id)
    {
        $vehicle = EmergencyVehicle::findOrFail($id);

        $request->validate([
            'vehicleTypes' => 'required|string|max:255',
            'plateNumber' => 'required|string|max:255|unique:emergency_vehicles,plateNumber,' . $id,
            'vehicle_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'availabilityStatus' => 'required|in:Available,Unavailable',
        ]);

        $data = $request->only([
            'vehicleTypes',
            'plateNumber',
            'availabilityStatus',
        ]);

        if ($request->hasFile('vehicle_photo')) {
            $data['vehicle_photo'] = $request->file('vehicle_photo')->store('vehicles', 'public');
        }

        $updated = $vehicle->update($data);

        // Log action
        Log::create([
            'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
            'interaction_type' => 'Update',
            'agency_id' => auth()->user()->agency_id,
            'emergency_vehicle_id' => $vehicle->id

        ]);

        return $updated
            ? redirect()->route('bfp.vehicles')->with('success', 'Successfully Updated Emergency Vehicle.')
            : redirect()->back()->with('error', 'Update failed, please try again.')->withInput();
    }

    /**
     * Display the specified emergency vehicle.
     */
    public function show($id)
    {
        $vehicles = EmergencyVehicle::findOrFail($id);
        return view('PAGES/BFP_BDRRMC/view-emergency-vehicles', compact('vehicles'));
    }

    /**
     * Remove the specified emergency vehicle from storage.
     */
    public function destroy($id)
    {
        $vehicle = EmergencyVehicle::findOrFail($id);


        // Log action before delete
        Log::create([
            'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
            'interaction_type' => 'Delete',
            'agency_id' => auth()->user()->agency_id,
            'emergency_vehicle_id' => $vehicle->id

        ]);

        $vehicle->delete();

        return $vehicle
            ? redirect()->back()->with('success', 'Emergency Vehicle successfully deleted.')
            : redirect()->back()->with('error', 'Delete failed, please try again.');
    }
}
