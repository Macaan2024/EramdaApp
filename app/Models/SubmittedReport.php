<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'incident_category',
        'incident_type',
        'city_name',
        'purok',
        'street_name',
        'barangay_name',
        'barangay_longitude',
        'barangay_latitude',
        'report_status',
        'reported_by',
        'from_agency',
        'alarm_level',
        'fire_truck_request',
        'ambulance_request',
        'police_car_request',
        'vehicle_type_request',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
