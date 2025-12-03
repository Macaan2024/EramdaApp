<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BedReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'submitted_report_id',
        'agency_id',
        'emergency_room_bed_id',
        'user_id',
        'request_status'

    ];

    public function submittedReport()
    {
        return $this->belongsTo(SubmittedReport::class, 'submitted_report_id', 'id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'id');
    }
    public function emergencyRoomBed()
    {
        return $this->belongsTo(EmergencyRoomBed::class, 'emergency_room_bed_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
