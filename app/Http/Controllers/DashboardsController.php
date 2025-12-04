<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyReportAction;
use App\Models\EmergencyRoomBed;
use App\Models\EmergencyVehicle;
use App\Models\Incident;
use App\Models\IndividualErBedList;
use App\Models\SubmittedReport;
use App\Models\TreatmentService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardsController extends Controller
{

    public function responderIndex()
    {

        $receives = AgencyReportAction::where('nearest_agency_name', auth()->user()->agency->agencyNames)
            ->whereHas('submittedReport', function ($q) {
                $q->where('report_status', 'Ongoing');
            })
            ->get();


        $hospitals = Agency::where('agencyTypes', 'Hospital')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('PAGES/responder/dashboard', compact('receives', 'hospitals'));
    }


    public function bfpIndex()
    {
        $agencyId = auth()->user()->agency_id;
        $today = Carbon::today();

        // Submitted Reports for this agency
        $reportTodayCount = SubmittedReport::whereHas('user', function ($q) use ($agencyId) {
            $q->where('agency_id', $agencyId);
        })
            ->whereDate('created_at', $today)
            ->count();

        $totalReports = SubmittedReport::whereHas('user', function ($q) use ($agencyId) {
            $q->where('agency_id', $agencyId);
        })
            ->count();

        // Responders
        $responderCount = User::where('user_type', 'responder')
            ->where('agency_id', $agencyId)
            ->count();

        $responderAvailableCount = User::where('user_type', 'responder')
            ->where('agency_id', $agencyId)
            ->where('availability_status', 'Available')
            ->count();

        // Police Cars
        $policeVehicleCount = EmergencyVehicle::where('agency_id', $agencyId)
            ->where('vehicleTypes', 'Police Car')
            ->count();

        $policeVehicleAvailableCount = EmergencyVehicle::where('agency_id', $agencyId)
            ->where('vehicleTypes', 'Police Car')
            ->where('availabilityStatus', 'Available')
            ->count();

        // Fire Trucks
        $fireTruckCount = EmergencyVehicle::where('agency_id', $agencyId)
            ->where('vehicleTypes', 'Fire Truck')
            ->count();

        $fireTruckAvailableCount = EmergencyVehicle::where('agency_id', $agencyId)
            ->where('vehicleTypes', 'Fire Truck')
            ->where('availabilityStatus', 'Available')
            ->count();

        // Ambulances
        $ambulanceCount = EmergencyVehicle::where('agency_id', $agencyId)
            ->where('vehicleTypes', 'Ambulance')
            ->count();

        $ambulanceAvailableCount = EmergencyVehicle::where('agency_id', $agencyId)
            ->where('vehicleTypes', 'Ambulance')
            ->where('availabilityStatus', 'Available')
            ->count();

        return view('PAGES/bfp/dashboard', compact(
            'reportTodayCount',
            'totalReports',
            'responderCount',
            'responderAvailableCount',
            'policeVehicleCount',
            'policeVehicleAvailableCount',
            'fireTruckCount',
            'fireTruckAvailableCount',
            'ambulanceCount',
            'ambulanceAvailableCount'
        ));
    }


    public function adminIndex()
    {

        $pendingReportsList = SubmittedReport::where('report_status', 'Pending')->latest()->get();
        $ongoingReportsList = SubmittedReport::where('report_status', 'Ongoing')->latest()->get();
        $resolvedReportsList = SubmittedReport::where('report_status', 'Resolved')->latest()->get();
        $allReportsList     = SubmittedReport::latest()->get(); // For "Total"

        // --- 2. AGENCY ACTIONS (Counts & Lists) ---
        $declineActionList = AgencyReportAction::where('report_action', 'Declined')->with('submittedReport')->latest()->get();
        $acceptActionList  = AgencyReportAction::where('report_action', 'Accepted')->with('submittedReport')->latest()->get();
        $pendingActionList = AgencyReportAction::where('report_action', 'Pending')->with('submittedReport')->latest()->get();
        $allActionList     = AgencyReportAction::with('submittedReport')->latest()->get();


        $pendingReports = SubmittedReport::where('report_status', 'Pending')->count();
        $ongoingReports = SubmittedReport::where('report_status', 'Ongoing')->count();
        $resolvedReports = SubmittedReport::where('report_status', 'Resolved')->count();
        $totalReports = SubmittedReport::count();

        $declineReportAction = AgencyReportAction::where('report_action', 'Declined')->count();
        $acceptReportAction = AgencyReportAction::where('report_action', 'Accepted')->count();
        $pendingReportAction = AgencyReportAction::where('report_action', 'Pending')->count();
        $totalReportAction = AgencyReportAction::count();

        // --- 1. EXISTING LOGIC (Barangays & Categories) ---
        $categoryIncidents = SubmittedReport::where('report_status', 'Resolved')
            ->whereIn('incident_category', ['Road Accidents', 'Disaster Incidents'])
            ->get();

        $roadAccidents = $categoryIncidents->where('incident_category', 'Road Accidents');
        $disasterIncidents = $categoryIncidents->where('incident_category', 'Disaster Incidents');

        $barangayList = [
            'Abuno',
            'Acmac-Mariano Badelles Sr.',
            'Bagong Silang',
            'Bonbonon',
            'Bunawan',
            'Buru-un',
            'Dalipuga',
            'Del Carmen',
            'Digkilaan',
            'Ditucalan',
            'Dulag',
            'Hinaplanon',
            'Hindang',
            'Kabacsanan',
            'Kalilangan',
            'Kiwalan',
            'Lanipao',
            'Luinab',
            'Mahayahay',
            'Mainit',
            'Mandulog',
            'Maria Cristina',
            'Pala-o',
            'Panoroganan',
            'Poblacion',
            'Puga-an',
            'Rogongon',
            'San Miguel',
            'San Roque',
            'Santa Elena',
            'Santa Filomena',
            'Santiago',
            'Santo Rosario',
            'Saray',
            'Suarez',
            'Tambacan',
            'Tibanga',
            'Tipanoy',
            'Tomas L. Cabili (Tominobo Proper)',
            'Tubod',
            'Upper Hinaplanon',
            'Upper Tominobo',
            'Ubaldo Laya'
        ];

        $dbCounts = SubmittedReport::where('report_status', 'Resolved')
            ->selectRaw('barangay_name, COUNT(*) as total')
            ->groupBy('barangay_name')
            ->pluck('total', 'barangay_name');

        $barangayData = collect($barangayList)->map(function ($name) use ($dbCounts) {
            return $dbCounts[$name] ?? 0;
        });

        $maxCount = $barangayData->max();
        $mostActiveIndex = $barangayData->search($maxCount);
        $mostActiveName = $mostActiveIndex !== false ? $barangayList[$mostActiveIndex] : 'None';


        // --- 2. NEW LOGIC: MONTHLY TRENDS (Jan-Dec) ---
        $monthlyCounts = SubmittedReport::where('report_status', 'Resolved')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y')) // Optional: Filter by current year
            ->groupBy('month')
            ->pluck('count', 'month');

        // Fill 1-12 with data or 0
        $monthData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData[] = $monthlyCounts[$i] ?? 0;
        }


        return view('PAGES.admin.dashboard', [
            'incidents' => Incident::paginate(20),
            'barangayList' => $barangayList,
            'barangayData' => $barangayData,
            'roadAccidents' => $roadAccidents,
            'disasterIncidents' => $disasterIncidents,
            'mostActiveName' => $mostActiveName,
            'maxCount' => $maxCount,
            'monthData' => $monthData, // <--- Pass this new variable
            'pendingReportsList' => $pendingReportsList,
            'ongoingReportsList' => $ongoingReportsList,
            'resolvedReportsList' => $resolvedReportsList,
            'allReportsList' => $allReportsList,
            'declineActionList' => $declineActionList,
            'acceptActionList' => $acceptActionList,
            'pendingActionList' => $pendingActionList,
            'allActionList' => $allActionList,
        ]);
    }

    public function nurseIndex()
    {
        $sessionUserAgency = auth()->user()->agency_id;

        // 1. Fetch all beds
        $beds = EmergencyRoomBed::where('agency_id', $sessionUserAgency)
            ->orderBy('bed_type')
            ->orderBy('room_number')
            ->orderBy('bed_number')
            ->orderBy('availabilityStatus')
            ->get();

        // 2. Calculate Bed Totals
        $privateBedTotals = $beds->where('bed_type', 'private')->where('availabilityStatus', 'Available')->count();
        $icuBedTotals = $beds->where('bed_type', 'icu')->where('availabilityStatus', 'Available')->count();
        $wardenBedTotals = $beds->where('bed_type', 'ward')->where('availabilityStatus', 'Available')->count();

        // 3. Fetch patients currently admitted
        $patients = IndividualErBedList::with('individual', 'emergencyRoomBed')
            ->whereHas('emergencyRoomBed', function ($query) use ($sessionUserAgency) {
                $query->where('agency_id', $sessionUserAgency);
            })
            ->get();

        // 4. Map the patients to their individual model
        // This flattens the list so we can access patient details directly
        $individuals = $patients->pluck('individual');

        // --- PREPARE CHART DATA ---

        // Chart 1: Injury Status (Correctly used $individuals)
        $injuryStatusData = [
            $individuals->where('injury_status', 'Minor Injury')->count(),
            $individuals->where('injury_status', 'Serious Injury')->count(),
            $individuals->where('injury_status', 'Critical')->count(),
            $individuals->where('injury_status', 'Deceased')->count(),
        ];

        // Chart 2: Incident Role (FIXED: Changed $patients to $individuals)
        $roleData = [
            $individuals->where('incident_position', 'Driver')->count(),
            $individuals->where('incident_position', 'Passenger')->count(),
            $individuals->where('incident_position', 'Pedestrian')->count(),
            $individuals->where('incident_position', 'Witness')->count(),
            $individuals->where('incident_position', 'Evacuee')->count(),
        ];

        // Chart 3: First Aid Applied (FIXED: Changed $patients to $individuals)
        $firstAidData = [
            $individuals->where('first_aid_applied', 'Yes')->count(),
            $individuals->where('first_aid_applied', 'No')->count(),
        ];

        // Chart 4: Gender (Correctly used $individuals)
        $genderData = [
            $individuals->where('individual_sex', 'Male')->count(),
            $individuals->where('individual_sex', 'Female')->count(),
        ];

        return view('PAGES.hospital.dashboard', compact(
            'beds',
            'privateBedTotals',
            'icuBedTotals',
            'wardenBedTotals',
            'injuryStatusData',
            'roleData',
            'firstAidData',
            'genderData'
        ));
    }
}
