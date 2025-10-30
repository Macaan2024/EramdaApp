<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentService extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'agency_id',
        'serviceName',
        'category',
        'serviceAvailability',
    ];
}
