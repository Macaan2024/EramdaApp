<?php

namespace App\Http\Controllers;

use App\Models\AgencyReportAction;
use App\Models\DeploymentList;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function incidentIndex($reportId, $latitude, $longitude)
    {

        $report = AgencyReportAction::whereHas('submittedReport', function ($q) use ($reportId) {
            $q->where('id', $reportId);
        })->with('submittedReport')->firstOrFail();



        return view('PAGES/responder/resolve-incident', compact('report', 'latitude', 'longitude'));
    }

    public function submitIncident(Request $request)
    {
        $validated = $request->validate([
            'submitted_report_id' => 'required|exists:submitted_reports,id',

            'severity_level' => 'nullable|string',
            'incident_region' => 'nullable|string',
            'incident_province' => 'nullable|string',
            'incident_city' => 'nullable|string',
            'incident_longitude' => 'nullable|string',
            'incident_latitude' => 'nullable|string',
            'incident_cause' => 'nullable|string',
            'incident_description' => 'nullable|string',
            'remarks' => 'nullable|string',
            'incident_status' => 'nullable|string',
            'num_vehicles' => 'nullable|integer',
            'num_driver_casualties' => 'nullable|integer',
            'num_pedestrian_casualties' => 'nullable|integer',
            'num_passenger_casualties' => 'nullable|integer',
            'num_driver_injured' => 'nullable|integer',
            'num_pedestrian_injured' => 'nullable|integer',
            'num_passenger_injured' => 'nullable|integer',
            'junction_type' => 'nullable|string',
            'collision_type' => 'nullable|string',
            'weather_condition' => 'nullable|string',
            'light_condition' => 'nullable|string',
            'road_character' => 'nullable|string',
            'surface_condition' => 'nullable|string',
            'surface_type' => 'nullable|string',
            'main_cause' => 'nullable|string',
            'road_class' => 'nullable|string',
            'road_repairs' => 'nullable|string',
            'road_name' => 'nullable|string',
            'location_name' => 'nullable|string',
            'hit_and_run' => 'nullable|string',
            'case_status' => 'nullable|string',
            'reported_by' => 'nullable|string',
            'response_lead_agency' => 'nullable|string',
            'investigating_officer' => 'nullable|string',
            'supervising_officer' => 'nullable|string',
            'recommendation' => 'nullable|string',
            'action_taken' => 'nullable|string',
        ]);


        $incident = Incident::create($validated);

        $report = AgencyReportAction::where('submitted_report_id', $incident->submitted_report_id)
            ->where('report_action', 'Accepted')
            ->latest()
            ->first();

        if ($report) {
            $report->submittedReport->update([
                'report_status' => 'Resolved'
            ]);
        }

        $deploys = DeploymentList::where('submitted_report_id', $report->submitted_report_id)->get();

        foreach ($deploys as $deploy) {

            // If deployment has a user
            if ($deploy->user) {
                $deploy->user->update([
                    'availability_status' => 'Available'
                ]);
            }

            // If deployment has an emergency vehicle
            if ($deploy->emergencyVehicle) {
                $deploy->emergencyVehicle->update([
                    'availabilityStatus' => 'Available'  // <-- Use correct column name
                ]);
            }
        }

        return redirect()->route('responder.dashboard')->with('success', 'Incident report submitted successfully!');
    }
}
