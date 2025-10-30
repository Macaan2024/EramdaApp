<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyReportAction extends Model
{
    use HasFactory;


    protected $fillable = [
        'submitted_report_id',
        'shortestpath_trigger_num',
        'incident_longitude',
        'incident_latitude',
        'nearest_agency_name',
        'agency_type',
        'agency_latitude',
        'agency_longitude',
        'report_action',
        'decline_reason'
    ];


    public function submittedReport () {

        return $this->belongsTo(SubmittedReport::class, 'submitted_report_id', 'id');
    }

}
