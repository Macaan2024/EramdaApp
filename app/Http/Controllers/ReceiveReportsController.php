<?php

namespace App\Http\Controllers;

use App\Models\AgencyReportAction;
use Illuminate\Http\Request;

class ReceiveReportsController extends Controller
{
    public function index()
    {

        $receives = AgencyReportAction::with('submittedReport.user')
            ->whereHas('submittedReport.user', function ($q) {
                $q->where('agency_id', auth()->user()->agency_id);
            })
            ->paginate(10);

        return view('PAGES/bfp/receive-report', compact('receives'));
    }
}
