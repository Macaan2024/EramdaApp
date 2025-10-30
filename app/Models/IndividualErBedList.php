<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualErBedList extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'individual_id',
        'emergency_room_bed_id',
        'admit_status'
    ];

    public function individual()
    {
        return $this->belongsTo(Individual::class, 'individual_id', 'id');
    }

    public function emergencyRoomErBed()
    {
        return $this->belongsTo(EmergencyRoomBed::class, 'emergency_room_bed_id', 'id');
    }

    public function incident()
    {
        return $this->belongsTo(incident::class, 'incident_id', 'id');
    }
}
