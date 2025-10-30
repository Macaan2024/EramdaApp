<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyReportAction;
use Illuminate\Http\Request;
use App\Models\SubmittedReport;
use App\Models\Log;

class SubmittedReportController extends Controller
{

    public function reportLogs(Request $request, $status, $id = null)
    {
        $agencies = Agency::paginate(10);
        $reportActions = AgencyReportAction::paginate(10);
        $search = $request->input('search');

        if (empty($id)) {

            if ($status === 'All') {

                $reports = SubmittedReport::paginate(10);
                return view('PAGES/admin/log-reports', compact('status', 'id', 'reports', 'agencies', 'reportActions'));
            } elseif ($status === 'Pending') {

                $reports = SubmittedReport::where('report_status', 'Pending')->paginate(10);
                return view('PAGES/admin/log-reports', compact('status', 'id', 'reports', 'agencies', 'reportActions'));
            } elseif ($status === 'Ongoing') {

                $reports = SubmittedReport::where('report_status', 'Ongoing')->paginate(10);
                return view('PAGES/admin/log-reports', compact('status', 'id', 'reports', 'agencies', 'reportActions'));
            } elseif ($status === 'Resolved') {

                $reports = SubmittedReport::where('report_status', 'Resolved')->paginate(10);
                return view('PAGES/admin/log-reports', compact('status', 'id', 'reports', 'agencies', 'reportActions'));
            }
        } else {

            if ($status === 'All') {

                $reports = SubmittedReport::where('from_agency', $id)->paginate(10);
                return view('PAGES/admin/log-reports', compact('status', 'id', 'reports', 'agencies', 'reportActions'));
            } elseif ($status === 'Pending') {

                $reports = SubmittedReport::where('report_status', 'Pending')
                    ->where('from_agency', $id)
                    ->paginate(10);
                return view('PAGES/admin/log-reports', compact('status', 'id', 'reports', 'agencies', 'reportActions'));
            } elseif ($status === 'Ongoing') {

                $reports = SubmittedReport::where('report_status', 'Ongoing')
                    ->where('from_agency', $id)
                    ->paginate(10);
                return view('PAGES/admin/log-reports', compact('status', 'id', 'reports', 'agencies', 'reportActions'));
            } elseif ($status === 'Resolved') {

                $reports = SubmittedReport::where('report_status', 'Resolved')
                    ->where('from_agency', $id)
                    ->paginate(10);
                return view('PAGES/admin/log-reports', compact('status', 'id', 'reports', 'agencies', 'reportActions'));
            }
        }
    }


    public function submitReports(Request $request)
    {
        // ✅ Step 1: Validate input
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'incident_category' => 'required|in:Disaster Incidents,Road Accidents',
            'incident_type' => 'required|string|max:255',
            'barangay_name' => ['required', 'regex:/^[A-Za-z\s\.\-\(\)]+$/'],
            'city_name' => 'required|in:Iligan City',
            'purok' => 'required|string|max:255',
            'street_name' => 'required|string|max:255',
            'barangay_longitude' => 'required|numeric',
            'barangay_latitude' => 'required|numeric',
            'report_status' => 'required|in:Pending',
            'alarm_level' => 'required|string|max:255',
            'fire_truck_request' => 'nullable|numeric|min:0',
            'ambulance_request' => 'nullable|numeric|min:0',
            'police_car_request' => 'nullable|numeric|min:0',
            'reported_by' => 'required|string|max:255',
            'from_agency' => 'required|string|max:255',
            'vehicle_type_request' => 'required|string|max:255',
        ]);

        // ✅ Step 2: Save to submitted_reports
        $submittedReport = SubmittedReport::create($validatedData);

        if ($submittedReport) {

            // ✅ Step 3: Identify nearest agency
            $incidentLat = $submittedReport->barangay_latitude;
            $incidentLng = $submittedReport->barangay_longitude;

            // Only select available agencies
            $agencies = Agency::where('availabilityStatus', 'Available')
                ->where('agencyTypes', '!=', 'HOSPITAL')
                ->get();

            $nearestAgency = null;
            $shortestDistance = PHP_FLOAT_MAX;

            foreach ($agencies as $agency) {
                $distance = $this->calculateDistance(
                    $incidentLat,
                    $incidentLng,
                    $agency->latitude,
                    $agency->longitude
                );

                if ($distance < $shortestDistance) {
                    $shortestDistance = $distance;
                    $nearestAgency = $agency;
                }
            }

            // ✅ Step 4: Create agency_report_actions entry
            if ($nearestAgency) {
                AgencyReportAction::create([
                    'submitted_report_id' => $submittedReport->id,
                    'shortestpath_trigger_num' => $shortestDistance,
                    'incident_longitude' => $incidentLng,
                    'incident_latitude' => $incidentLat,
                    'nearest_agency_name' => $nearestAgency->agencyNames,
                    'agency_type' => $nearestAgency->agencyTypes,
                    'agency_longitude' => $nearestAgency->longitude,
                    'agency_latitude' => $nearestAgency->latitude, // ✅ fixed spelling
                    'report_action' => 'Pending',
                    'decline_reason' => '',
                ]);
            }

            // ✅ Step 5: Log activity
            Log::create([
                'interaction_type' => 'Add',
                'user_id' => auth()->user()->id,
                'submitted_report_id' => $submittedReport->id,
            ]);

            // ✅ Step 6: Redirect back
            return redirect()
                ->route('admin.log-reports', 'All')
                ->with('success', 'Successfully Submitted Report and sent to nearest agency.');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Failed to submit incident report.');
    }

    /**
     * ✅ Helper function to calculate distance (Haversine formula)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // in km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }
}
