<?php

namespace App\Http\Controllers;

use App\Models\EmergencyRoomBed;
use App\Models\Individual;
use App\Models\IndividualErBedList;
use Illuminate\Http\Request;

class IndividualController extends Controller
{

    public function index()
    {

        $patientAdmitted = IndividualErBedList::orderBy('admit_status')->get();

        $admittedTotal = IndividualErBedList::where('admit_status', 'Admitted')->count();
        $dischargeTotal = IndividualErBedList::where('admit_status', 'Discharge')->count();


        return view('PAGES/hospital/manage-admit-patient', compact('patientAdmitted', 'admittedTotal', 'dischargeTotal'));
    }

    public function releasePatient($id)
    {
        $patient = IndividualErBedList::findOrFail($id);

        if ($patient->admit_status === 'Admitted') {
            // Update patient
            $patient->admit_status = 'Discharge';
            $patient->save();

            // Update bed availability
            $bed = $patient->emergencyroomerbed;
            if ($bed) {
                $bed->availabilityStatus = 'Available';
                $bed->save();
            }

            return redirect()->back()->with('success', 'Patient successfully released.');
        }

        return redirect()->back()->with('error', 'Patient cannot be released.');
    }


    public function submitIndividual(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:emergency_room_beds,id',
            'individual_name' => 'required|string|max:255',
            'individual_address' => 'required|string|max:255',
            'individual_sex' => 'required|string|max:20',
            'individual_contact_number' => 'required|string|max:20',
            'injury_status' => 'required|string|max:50',
            'transportation_type' => 'required|string|max:50',
            'incident_position' => 'required|string|max:50',
            'first_aid_applied' => 'required|in:Yes,No',
        ]);

        $individual = Individual::create([
            'individual_name' => $request->individual_name,
            'individual_address' => $request->individual_address,
            'individual_sex' => $request->individual_sex,
            'individual_contact_number' => $request->individual_contact_number,
            'injury_status' => $request->injury_status,
            'transportation_type' => $request->transportation_type,
            'incident_position' => $request->incident_position,
            'first_aid_applied' => $request->first_aid_applied,
        ]);


        $bed = EmergencyRoomBed::findOrFail($request->bed_id);
        $bed->update(['availabilityStatus' => 'Occupied']);

        // Optionally attach to bed
        IndividualErBedList::create([
            'incident_id' => $request->incident_id ?? null,
            'individual_id' => $individual->id,
            'emergency_room_bed_id' => $request->bed_id,
            'admit_status' => 'Admitted',
        ]);

        return redirect()->back()->with('success', 'Patient assigned successfully!');
    }
}
