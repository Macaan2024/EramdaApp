<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Individual extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'individual_name',
        'individual_address',
        'individual_sex',
        'individual_contact_number',
        'injury_status',
        'transportation_type',
        'incident_position',
        'first_aid_applied'
    ];
}
