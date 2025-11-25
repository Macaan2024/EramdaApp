<?php

namespace App\Http\Controllers;

use App\Models\AgencyReportAction;
use Illuminate\Http\Request;
use App\Events\ReportSubmitted;

class ReceiveReportsController extends Controller
{
    public function index()
    {


        $receives = AgencyReportAction::where('nearest_agency_name', auth()->user()->agency->agencyNames)->paginate(10);

        return view('PAGES/bfp/receive-report', compact('receives'));
    }
}
