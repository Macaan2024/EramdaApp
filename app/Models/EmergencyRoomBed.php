<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyRoomBed extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'agency_id',
        'room_number',
        'bed_type',
        'bed_number',
        'availabilityStatus',
    ];
}
