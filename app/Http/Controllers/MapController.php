<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\EmergencyRoomBed;
use Illuminate\Http\Request;

class MapController extends Controller
{
    // API endpoint for nearest hospital
    public function nearestHospital(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $userLat = $request->latitude;
        $userLng = $request->longitude;

        $nearest = Agency::selectRaw("
            *, 
            (6371 * acos(
                cos(radians(?)) 
                * cos(radians(latitude)) 
                * cos(radians(longitude) - radians(?)) 
                + sin(radians(?)) 
                * sin(radians(latitude))
            )) AS distance", [$userLat, $userLng, $userLat])
            ->orderBy('distance')
            ->first();

        return response()->json(['agency' => $nearest]);
    }

    public function getErBeds($agency_id)
    {
        $erBeds = EmergencyRoomBed::select([
            'id',
            'bed_number',
            'bed_type',
            'room_number AS room',
            'availabilityStatus AS status'
        ])
            ->where('agency_id', $agency_id)
            ->get();

        return response()->json($erBeds);
    }
}
