<?php

namespace App\Http\Controllers;

use App\Models\EmergencyRoomBed;
use App\Models\IndividualErBedList;
use App\Models\TreatmentService;
use Illuminate\Http\Request;

class DashboardsController extends Controller
{
    public function bfp()
    {

        return view('PAGES/BFP_BDRRMC/dashboard');
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
