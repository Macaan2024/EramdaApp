<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        $agencies = Agency::when($request->search, function ($query) use ($request) {
            return $query->whereAny([
                'agencyNames',
                'agencyTypes',
                'address',
                'email',
                'longitude',
                'latitude',
                'activeStatus'
            ], 'like', '%'  . $request->search . '%');
        })->paginate(10);

        $totalBFP = Agency::where('agencyTypes', 'BFP')->count();
        $totalBDRRMC = Agency::where('agencyTypes', 'BDRRMC')->count();
        $totalHOSPITAL = Agency::where('agencyTypes', 'HOSPITAL')->count();
        $totalCDRRMO = Agency::where('agencyTypes', 'CDRRMO')->count();
        

        return view('PAGES/admin/manage-agency', compact('agencies', 'totalBFP', 'totalHOSPITAL', 'totalBDRRMC', 'totalCDRRMO'));
    }


    public function submitAgency(Request $request)
    {
        $validatedData = $request->validate([
            'agencyNames' => 'required|string|unique:agencies,agencyNames',
            'agencyTypes' => 'required|in:BFP,BDRRMC,CDRRMO,HOSPITAL',
            'region' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string|in:Iligan City',
            'barangay' => 'required|string',
            'zipcode' => 'nullable|string',
            'email' => 'required|email|unique:agencies,email',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'availabilityStatus' => 'required|in:Available,Unavailable',
            'logo' => 'nullable|image|max:2048',
        ]);

        // Auto create address
        $validatedData['address'] = $validatedData['barangay'] . ', ' .
            $validatedData['city'] . ', ' .
            $validatedData['province'] . ', ' .
            $validatedData['region'];

        // Upload logo if exists
        if ($request->hasFile('logo')) {
            $validatedData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $submittedAgency = Agency::create($validatedData);


        return $submittedAgency ? redirect()->route('admin.agency')->with('success', 'Successfully Submitted Agency') : redirect()->back()->with('errors', 'Fail to Submit Agency')->withInput();
    }


    // View single agency
    public function viewAgency($id)
    {
        $agency = Agency::findOrFail($id);
        return view('PAGES/admin/view-agency', compact('agency'));
    }

    // Show edit form
    public function editAgency($id)
    {
        $agency = Agency::findOrFail($id);
        return view('PAGES.admin.edit-agency', compact('agency'));
    }

    public function updateAgency(Request $request, $id)
    {
        $validated = $request->validate([
            'agencyTypes' => 'required|string',
            'agencyNames' => 'required|string',
            'email' => 'required|email',
            'barangay' => 'required|string',
            'zipcode' => 'required|string',
            'address' => 'required|string',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $agency = Agency::findOrFail($id);

        // 🖼 Handle logo upload (if user uploads a new one)
        if ($request->hasFile('logo')) {

            // Store new logo
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }

        $agency->update($validated);

        return redirect()->route('admin.agency')->with('success', 'Agency updated successfully!');
    }



    // Delete agency
    public function deleteAgency($id)
    {
        $agency = Agency::findOrFail($id);
        $agency->delete();

        return redirect()->route('admin.agency')->with('success', 'Agency deleted successfully.');
    }
}
