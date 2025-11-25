<?php

namespace App\Http\Controllers;

use App\Models\AgencyReportAction;
use App\Models\DeploymentList;
use App\Models\EmergencyVehicle;
use App\Models\SubmittedReport;
use App\Models\User;
use Illuminate\Http\Request;

class DeploymentListController extends Controller
{
    public function submitDeploy(Request $request, $reportId)
    {
        // Validate the request
        $request->validate([
            'vehicles' => 'nullable|array',
            'vehicles.*' => 'exists:emergency_vehicles,id',
            'responders' => 'nullable|array',
            'responders.*' => 'exists:users,id',
        ]);

        // Deploy vehicles if any selected
        if ($request->filled('vehicles')) {
            foreach ($request->vehicles as $vehicleId) {
                DeploymentList::create([
                    'submitted_report_id' => $reportId,
                    'emergency_vehicle_id' => $vehicleId,
                    'from_agency' => auth()->user()->agency->agencyNames
                ]);

                // Optional: mark vehicle as unavailable
                EmergencyVehicle::find($vehicleId)->update(['availabilityStatus' => 'Unavailable']);
            }
        }

        // Deploy responders if any selected
        if ($request->filled('responders')) {
            foreach ($request->responders as $responderId) {
                DeploymentList::create([
                    'user_id' => $responderId,
                    'submitted_report_id' => $reportId,
                    'emergency_vehicle_id' => null, // responders do not need vehicle
                    'from_agency' => auth()->user()->agency->agencyNames

                ]);

                // Optional: mark responder as unavailable
                User::find($responderId)->update(['availability_status' => 'Unavailable']);
            }
        }

        AgencyReportAction::where('submitted_report_id', $reportId)
            ->update(['report_action' => 'Accepted']);

        SubmittedReport::where('id', $reportId)->update([
            'report_status' => 'Ongoing'
        ]);


        return redirect()->back()->with('success', 'Units deployed successfully.');
    }
}
