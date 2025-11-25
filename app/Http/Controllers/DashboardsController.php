<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyReportAction;
use App\Models\EmergencyRoomBed;
use App\Models\EmergencyVehicle;
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
            ->where('report_action', 'Accepted')
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

        return view('PAGES/admin/dashboard');
    }

    public function nurseIndex()
    {
        $sessionUserAgency = auth()->user()->agency_id;

        // Fetch all beds
        $beds = EmergencyRoomBed::where('agency_id', $sessionUserAgency)
            ->orderBy('bed_type')
            ->orderBy('room_number')
            ->orderBy('bed_number')
            ->orderBy('availabilityStatus')
            ->get();

        $privateBedTotals = $beds->where('bed_type', 'private')->where('availabilityStatus', 'Available')->count();
        $icuBedTotals = $beds->where('bed_type', 'icu')->where('availabilityStatus', 'Available')->count();
        $wardenBedTotals = $beds->where('bed_type', 'ward')->where('availabilityStatus', 'Available')->count();

        // Fetch patients
        $patients = IndividualErBedList::whereHas('emergencyroomerbed', function ($q) use ($sessionUserAgency) {
            $q->where('agency_id', $sessionUserAgency);
        })->get();

        // Chart 1: Injury Status
        $injuryStatusLabels = ['Minor Injury', 'Serious Injury', 'Critical', 'Deceased'];
        $injuryStatusData = [
            $patients->where('injury_status', 'Minor Injury')->count(),
            $patients->where('injury_status', 'Serious Injury')->count(),
            $patients->where('injury_status', 'Critical')->count(),
            $patients->where('injury_status', 'Deceased')->count(),
        ];

        // Chart 2: Beds by Type
        $bedTypeLabels = ['Private', 'ICU', 'Ward'];
        $bedTypeData = [$privateBedTotals, $icuBedTotals, $wardenBedTotals];

        return view('PAGES.hospital.dashboard', compact(
            'beds',
            'privateBedTotals',
            'icuBedTotals',
            'wardenBedTotals',
            'injuryStatusLabels',
            'injuryStatusData',
            'bedTypeLabels',
            'bedTypeData'
        ));
    }
}
