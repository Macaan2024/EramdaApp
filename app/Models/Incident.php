<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
        'submitted_report_id',
        'severity_level',
        'incident_region',
        'incident_province',
        'incident_city',
        'incident_longitude',
        'incident_latitude',
        'incident_cause',
        'incident_description',
        'remarks',
        'incident_status',
        'num_vehicles',
        'num_driver_casualties',
        'num_pedestrian_casualties',
        'num_passenger_casualties',
        'num_driver_injured',
        'num_pedestrian_injured',
        'num_passenger_injured',
        'junction_type',
        'collision_type',
        'weather_condition',
        'light_condition',
        'road_character',
        'surface_condition',
        'surface_type',
        'main_cause',
        'road_class',
        'road_repairs',
        'road_name',
        'location_name',
        'hit_and_run',
        'case_status',
        'reported_by',
        'response_lead_agency',
        'investigating_officer',
        'supervising_officer',
        'recommendation',
        'action_taken',
    ];
}
