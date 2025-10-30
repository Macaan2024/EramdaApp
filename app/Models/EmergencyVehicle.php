<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyVehicle extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'agency_id',
        'vehicleTypes',
        'plateNumber',
        'vehicle_photo',
        'availabilityStatus',
    ];


    public function log()
    {
        return $this->hasMany(Log::class);
    }

    public function agency() {
        return $this->belongsTo(Agency::class, 'agency_id', 'id');
    }
}
