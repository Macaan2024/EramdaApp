<?php

namespace App\Http\Controllers;

use App\Models\AgencyReportAction;
use Illuminate\Http\Request;
use App\Events\ReportSubmitted;

class ReceiveReportsController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get the filter inputs from the request
        $barangay = $request->barangay;
        $date = $request->date;

        // Get the current agency's identifier (assuming 'agencyNames' is the property holding the name/ID used in 'nearest_agency_name')
        $agencyIdentifier = auth()->user()->agency->agencyNames;

        // 2. Start the query
        $receives = AgencyReportAction::with('submittedReport.user')
            // **FIXED: Filter reports to those destined for the logged-in agency**
            // This ensures only reports marked for this agency's name are retrieved.
            ->where('nearest_agency_name', $agencyIdentifier)

            // NOTE: The previous ordering logic was removed from a whereHas closure 
            // where it did not belong. Add proper ordering here if required, 
            // e.g., ->orderBy('created_at', 'desc')

            // 3. Apply Barangay Filter
            ->when($barangay && $barangay !== 'All', function ($q) use ($barangay) {
                $q->whereHas('submittedReport', function ($sub) use ($barangay) {
                    $sub->where('barangay_name', $barangay);
                });
            })

            // 4. Apply Date Filter
            ->when($date, function ($q) use ($date) {
                // Assuming 'created_at' is on the AgencyReportAction table.
                $q->whereDate('created_at', $date);
            })

            // 5. Paginate results
            ->paginate(20);

        // 6. Return the view
        // Make sure 'PAGES/bfp/receive-report' matches your actual folder structure
        return view('PAGES/bfp/receive-report', compact('receives'));
    }
}
