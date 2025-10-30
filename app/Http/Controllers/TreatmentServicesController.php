<?php

namespace App\Http\Controllers;

use App\Models\TreatmentService;
use Illuminate\Http\Request;

class TreatmentServicesController extends Controller
{
    public function index(Request $request)
    {
        $query = TreatmentService::query();

        // Filter by category if selected
        if ($request->has('category') && $request->category != 'All') {
            $query->where('category', $request->category);
        }

        $services = $query->paginate(10)->withQueryString();

        // Get distinct categories for the select dropdown
        $categories = TreatmentService::select('category')->distinct()->pluck('category');

        $servicesAvailable = TreatmentService::where('serviceAvailability', 'Available')->count();

        $servicesUnavailable = TreatmentService::where('serviceAvailability', 'Unavailable')->count();

        $serviceTotal = TreatmentService::count();

        return view('PAGES/hospital/manage-treatment-services', compact('services', 'categories', 'servicesAvailable', 'servicesUnavailable', 'serviceTotal'));
    }


    public function submitServices(Request $request)
    {
        // ✅ Validate input
        $validatedData = $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'serviceName' => 'required|string|max:220',
            'category' => 'required|string|max:220',
            'serviceAvailability' => 'required|string|max:220',
        ]);

        // 🧠 Check for existing service with same agency, category, and service name
        $existingServices = TreatmentService::where('agency_id', $validatedData['agency_id'])
            ->where('serviceName', $validatedData['serviceName'])
            ->where('category', $validatedData['category'])
            ->first();

        if ($existingServices) {
            return redirect()->back()->with('error', 'This service already exists in the selected category for this agency.');
        }

        // ✅ Create new service if unique
        TreatmentService::create([
            'agency_id' => $validatedData['agency_id'],
            'serviceName' => $validatedData['serviceName'],
            'category' => $validatedData['category'],
            'serviceAvailability' => $validatedData['serviceAvailability'],
        ]);

        return redirect()->back()->with('success', 'New service added successfully!');
    }

    public function editServices(Request $request, $id)
    {
        // ✅ Validate input
        $validatedData = $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'serviceName' => 'required|string|max:220',
            'category' => 'required|string|max:220',
            'serviceAvailability' => 'required|string|max:220',
        ]);

        // 🧠 Find the service by ID
        $service = TreatmentService::findOrFail($id);

        // 🧠 Check if another service with the same agency, name, and category exists (exclude current)
        $existingService = TreatmentService::where('agency_id', $validatedData['agency_id'])
            ->where('serviceName', $validatedData['serviceName'])
            ->where('category', $validatedData['category'])
            ->where('id', '!=', $id) // exclude the current service
            ->first();

        if ($existingService) {
            return redirect()->back()->with('error', 'Another service with this name and category already exists for this agency.');
        }

        // ✅ Update the service
        $service->update([
            'serviceName' => $validatedData['serviceName'],
            'category' => $validatedData['category'],
            'serviceAvailability' => $validatedData['serviceAvailability'],
        ]);

        return redirect()->back()->with('success', 'Service updated successfully!');
    }

    public function deleteServices($id)
    {

        $services = TreatmentService::findOrFail($id);
        $services->delete();

        return redirect()->back()->with('success', 'Services deleted successfully.');
    }
}
