<?php

namespace App\Http\Controllers;

use App\Models\AgencyReportAction;
use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyCategoryController extends Controller
{
    public function index($id = null)
    {
        if ($id === null) {
            $reports = AgencyReportAction::with('submittedReport.user')->paginate(10);
        } else {
            $reports = AgencyReportAction::with('submittedReport.user')
                ->where('agency_id', auth()->user()->agency_id)
                ->paginate(10);
        }

        return view('PAGES/admin/incident-report-agency-category', compact('reports'));
    }
}
