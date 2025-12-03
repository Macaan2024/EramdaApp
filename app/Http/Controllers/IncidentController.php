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
            'severity_level' => 'required|string',
            'incident_region' => 'required|string',
            'incident_province' => 'required|string',
            'incident_city' => 'required|string',
            'incident_longitude' => 'nullable|string',
            'incident_latitude' => 'nullable|string',
            'incident_cause' => 'required|string',
            'incident_description' => 'required|string',
            'remarks' => 'required|string',
            'incident_status' => 'required|string',
            'num_vehicles' => 'required|integer',
            'num_driver_casualties' => 'required|integer',
            'num_pedestrian_casualties' => 'required|integer',
            'num_passenger_casualties' => 'required|integer',
            'num_driver_injured' => 'required|integer',
            'num_pedestrian_injured' => 'required|integer',
            'num_passenger_injured' => 'required|integer',
            'junction_type' => 'required|string',
            'collision_type' => 'required|string',
            'weather_condition' => 'required|string',
            'light_condition' => 'required|string',
            'road_character' => 'required|string',
            'surface_condition' => 'required|string',
            'surface_type' => 'required|string',
            'main_cause' => 'required|string',
            'road_class' => 'required|string',
            'road_repairs' => 'required|string',
            'road_name' => 'required|string',
            'location_name' => 'required|string',
            'hit_and_run' => 'required|string',
            'case_status' => 'required|string',
            'reported_by' => 'required|string',
            'response_lead_agency' => 'required|string',
            'investigating_officer' => 'required|string',
            'supervising_officer' => 'required|string',
            'recommendation' => 'required|string',
            'action_taken' => 'required|string',
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
