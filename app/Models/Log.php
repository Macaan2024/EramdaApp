<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'modified_by',
        'agency_id',
        'interaction_type',
        'user_id',
        'personnel_responder_id',
        'emergency_vehicle_id',
        'injury_id',
        'attendance_id',
        'deployment_id',
        'treatment_service_id',
        'submit_report_id',
        'report_action_id',
        'emergency_room_bed_id',
        'request_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function submittedReport() {
        return $this->belongsTo(SubmittedReport::class, 'submitted_report_id', 'id');
    }

    public function personnelResponder()
    {
        return $this->belongsTo(PersonnelResponder::class, 'personnel_responder_id', 'id');
    }

    public function emergencyVehicle()
    {
        return $this->belongsTo(EmergencyVehicle::class, 'emergency_vehicle_id', 'id');
    }

    public function agency() {
        return $this->belongsTo(Agency::class, 'agency_id', 'id');
    }
}
