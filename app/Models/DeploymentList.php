<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;

class DeploymentList extends Model
{
     use HasFactory;

    protected $fillable = [
        'from_agency',
        'user_id',
        'submitted_report_id',
        'emergency_vehicle_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function submittedReport()
    {
        return $this->belongsTo(SubmittedReport::class, 'submitted_report_id', 'id');
    }

      public function emergencyVehicle()
    {
        return $this->belongsTo(emergencyVehicle::class, 'emergency_vehicle_id', 'id');
    }
}
