<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // we will use this for API calls


class BarangayController extends Controller
{
    public function index(Request $request)
    {
        $barangays = Barangay::when($request->search, function ($query) use ($request) {
            return $query->whereAny([
                'barangayNames',
                'city',
            ], 'like', '%'  . $request->search . '%');
        })->paginate(10);

        return view('PAGES/admin/manage-barangay', compact('barangays'));
    }

    public function addBarangay(Request $request)
    {
        $request->validate([
            'barangayNames' => 'required|string|max:255|unique:barangays,barangayNames',
            'city' => 'required|string|max:255',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            // store in storage/app/public/logos
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $barangay = Barangay::create([
            'barangayNames' => $request->barangayNames,
            'city' => $request->city,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'logo' => $logoPath
        ]);

        return $barangay
            ? redirect()->route('admin.barangay')->with('success', 'Successfully Registered Barangay with Coordinates')
            : redirect()->back()->with('error', 'Failed to Register Barangay');
    }

    public function edit($id)
    {
        $barangays = Barangay::findOrFail($id);



        return view('PAGES/admin/edit-barangay', compact('barangays'));
    }

    public function updateBarangay(Request $request, $id)
    {
        $barangay = Barangay::findOrFail($id);

        $request->validate([
            'barangayNames' => 'required|string|max:255|unique:barangays,barangayNames,' . $barangay->id,
            'city' => 'required|string|max:255',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->only(['barangayNames', 'city', 'longitude', 'latitude']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $barangay->update($data);

        return redirect()->route('admin.barangay')->with('success', 'Successfully Edited Barangay');
    }

    public function destroy($id)
    {
        $barangays = Barangay::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Successfully Delete Barangay');
    }

    public function show($id)
    {

        $barangay = Barangay::findOrFail($id);


        return view('PAGES/admin/view-barangay', compact('barangay'));
    }
}
