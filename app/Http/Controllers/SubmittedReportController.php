<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyReportAction;
use Illuminate\Http\Request;
use App\Models\SubmittedReport;
use App\Models\Log;
use App\Events\ReportSubmitted;


class SubmittedReportController extends Controller
{
    public function index(Request $request)
    {
        $barangay = $request->barangay;
        $date = $request->date;

        $receives = AgencyReportAction::with('submittedReport.user')
            ->whereHas('submittedReport.user', function ($q) {
                $q->where('agency_id', auth()->user()->agency_id)->orderBy('incident_category', 'asc')->orderBy('created_at', 'asc');
            })

            // Filter by Barangay
            ->when($barangay && $barangay !== 'All', function ($q) use ($barangay) {
                $q->whereHas('submittedReport', function ($sub) use ($barangay) {
                    $sub->where('barangay_name', $barangay);
                });
            })

            // Filter by Date
            ->when($date, function ($q) use ($date) {
                $q->whereDate('created_at', $date);
            })

            ->paginate(20);

        return view('PAGES/bfp/submitted-report', compact('receives'));
    }



    public function reportIndex()
    {
        $user = auth()->user();       // define $user
        $userAgency = $user->agency;

        // Reports received by this agency
        if ($userAgency) {
            $receives = AgencyReportAction::where('nearest_agency_name', $userAgency->agencyNames)
                ->latest()
                ->paginate(10);
        } else {
            $receives = collect(); // empty collection if no agency
        }

        // Reports submitted by this user
        $reports = AgencyReportAction::with('submittedReport')
            ->whereHas('submittedReport', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->paginate(10);

        return view('PAGES/bfp/manage-incident-report', compact('reports', 'receives'));
    }


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
        // Validate input
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
            'alarm_level' => 'required|string',
            'fire_truck_request' => 'nullable|numeric|min:0',
            'ambulance_request' => 'nullable|numeric|min:0',
            'police_car_request' => 'nullable|numeric|min:0',
            'reported_by' => 'required|string|max:255',
            'from_agency' => 'required|string|max:255',
            'vehicle_type_request' => 'required|string|max:255',
        ]);

        // Save report
        $submittedReport = SubmittedReport::create($validatedData);

        if (!$submittedReport) {
            return back()->with('error', 'Failed to submit report.');
        }

        $incidentLat = $submittedReport->barangay_latitude;
        $incidentLng = $submittedReport->barangay_longitude;

        // ------------------------------------
        // 🚨 ALARM LEVEL 3: SEND TO ALL AGENCIES except hospitals
        // ------------------------------------
        if ($submittedReport->alarm_level == 'Level 3') {

            $agencies = Agency::where('availabilityStatus', 'Available')
                ->where('agencyTypes', '!=', 'HOSPITAL')
                ->get();

            foreach ($agencies as $agency) {
                if ($agency->agencyNames == auth()->user()->agency->agencyNames) continue;

                AgencyReportAction::create([
                    'submitted_report_id' => $submittedReport->id,
                    'shortestpath_trigger_num' => null,
                    'incident_longitude' => $incidentLng,
                    'incident_latitude' => $incidentLat,
                    'nearest_agency_name' => $agency->agencyNames,
                    'agency_type' => $agency->agencyTypes,
                    'agency_longitude' => $agency->longitude,
                    'agency_latitude' => $agency->latitude,
                    'report_action' => 'Pending',
                    'decline_reason' => '',
                ]);
            }

            return redirect()->route('operation-officer.report')
                ->with('success', 'Report submitted and forwarded to ALL agencies.');
        }

        // ------------------------------------
        // 🚨 ALARM 1 & 2: Find nearest agency based on incident type
        // ------------------------------------
        if ($submittedReport->incident_category === 'Road Accidents') {
            $agencies = Agency::where('availabilityStatus', 'Available')
                ->whereIn('agencyTypes', ['BDRRMC', 'CDRRMO'])
                ->get();
        } elseif ($submittedReport->incident_category === 'Disaster Incidents' && $submittedReport->incident_type === 'Fire') {
            $agencies = Agency::where('availabilityStatus', 'Available')->where('agencyTypes', 'BFP')->get();
        } else { // Disaster Incidents
            $agencies = Agency::where('availabilityStatus', 'Available')
                ->whereIn('agencyTypes', ['BDRRMC', 'CDRRMO', 'BFP'])
                ->get();
        }

        $nearestAgency = null;
        $shortestDistance = PHP_FLOAT_MAX;

        foreach ($agencies as $agency) {
            // Skip current user's agency
            if ($agency->agencyNames === auth()->user()->agency->agencyNames) continue;

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

        if ($nearestAgency) {
            $agencyAction = AgencyReportAction::create([
                'submitted_report_id' => $submittedReport->id,
                'shortestpath_trigger_num' => $shortestDistance,
                'incident_longitude' => $incidentLng,
                'incident_latitude' => $incidentLat,
                'nearest_agency_name' => $nearestAgency->agencyNames,
                'agency_type' => $nearestAgency->agencyTypes,
                'agency_longitude' => $nearestAgency->longitude,
                'agency_latitude' => $nearestAgency->latitude,
                'report_action' => 'Pending',
                'decline_reason' => '',
            ]);

            event(new ReportSubmitted($agencyAction));
        }

        return redirect()->route('operation-officer.report')
            ->with('success', 'Report submitted and sent to nearest agency.');
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
