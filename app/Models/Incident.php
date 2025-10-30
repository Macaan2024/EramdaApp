<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
        'individual_name',
        'individual_address',
        'individual_sex',
        'individual_contact_number',
        'individual_status',
        'individual_transportation_type',
        'incident_position',
        'first_aid_applied'
    ];
}
