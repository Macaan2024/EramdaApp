<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function incidentIndex ($reportId, $latitude, $longitude) {


        return view('PAGES/responder/resolve-incident', compact('reportId', 'latitude', 'longitude'));
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

        Incident::create($validated);

        return redirect()->back()->with('success', 'Incident report submitted successfully!');
    }
}
