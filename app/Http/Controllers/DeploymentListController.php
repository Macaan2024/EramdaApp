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
        // Ensure report exists
        $report = SubmittedReport::find($reportId);
        if (!$report) {
            return back()->with('error', 'Submitted report not found.');
        }

        // Validate
        $request->validate([
            'vehicles' => 'nullable|array',
            'vehicles.*' => 'exists:emergency_vehicles,id',
            'responders' => 'nullable|array',
            'responders.*' => 'exists:users,id',
        ]);

        // Deploy vehicles
        if ($request->filled('vehicles')) {
            foreach ($request->vehicles as $vehicleId) {
                DeploymentList::create([
                    'submitted_report_id' => $reportId,
                    'emergency_vehicle_id' => $vehicleId,
                    'from_agency' => auth()->user()->agency->agencyNames,
                ]);

                EmergencyVehicle::find($vehicleId)
                    ->update(['availabilityStatus' => 'Unavailable']);
            }
        }

        // Deploy responders
        if ($request->filled('responders')) {
            foreach ($request->responders as $responderId) {
                DeploymentList::create([
                    'submitted_report_id' => $reportId,
                    'user_id' => $responderId,
                    'from_agency' => auth()->user()->agency->agencyNames,
                ]);

                User::find($responderId)
                    ->update(['availability_status' => 'Unavailable']);
            }
        }

        // Update report action (FIXED)
        AgencyReportAction::where('submitted_report_id', $reportId)
            ->update(['report_action' => 'Accepted']);

        SubmittedReport::where('id', $reportId)
            ->update(['report_status' => 'Ongoing']);

        return back()->with('success', 'Units deployed successfully.');
    }
}
