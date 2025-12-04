<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Tailwind CSS (can be in layout) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Inter Font -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f9;
        }
    </style>

    <div class="py-6">
        <div class="max-w-5xl mx-auto bg-white p-6 md:p-10 rounded-xl shadow-2xl border border-gray-100">

            <header class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 border-b-4 border-indigo-600 pb-2">
                    Detailed Traffic Incident Report
                </h1>
                <p class="mt-2 text-gray-600">
                    Please fill in all relevant details for the incident report. Fields marked with * are required.
                </p>
            </header>


            <form action="{{ route('responder.submit-incident') }}" method="POST" class="space-y-8">
                @csrf

                <input type="hidden" name="submitted_report_id" value="{{ $report->submittedReport->id }}">
                <!-- 1. Incident Basics & Status -->
                <div class="bg-indigo-50 p-6 rounded-lg shadow-inner">
                    <h2 class="text-xl font-semibold mb-4 text-indigo-700">Incident Basics & Status</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        <div>
                            <label for="severity_level" class="block text-sm font-medium text-gray-700">Severity Level *</label>
                            <select id="severity_level" name="severity_level" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select Level</option>
                                <option value="Minor">Minor</option>
                                <option value="Moderate">Moderate</option>
                                <option value="Severe">Severe</option>
                                <option value="Fatal">Fatal</option>
                            </select>
                        </div>

                        <div>
                            <label for="incident_status" class="block text-sm font-medium text-gray-700">Incident Status *</label>
                            <select id="incident_status" name="incident_status" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Resolved">Resolved</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>

                        <div>
                            <label for="case_status" class="block text-sm font-medium text-gray-700">Case Status *</label>
                            <select id="case_status" name="case_status" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select Case Status</option>
                                <option value="Open">Open</option>
                                <option value="Under Investigation">Under Investigation</option>
                                <option value="Cleared">Cleared</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 lg:col-span-3">
                            <label for="incident_cause" class="block text-sm font-medium text-gray-700">Incident Cause *</label>
                            <input type="text" id="incident_cause" name="incident_cause" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="e.g., Driver Negligence, Mechanical Failure">
                        </div>

                        <div class="md:col-span-2 lg:col-span-3">
                            <label for="incident_description" class="block text-sm font-medium text-gray-700">Incident Description *</label>
                            <textarea id="incident_description" name="incident_description" rows="3" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="A brief narrative of the events leading to the incident."></textarea>
                        </div>

                        <div class="md:col-span-2 lg:col-span-3">
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks *</label>
                            <textarea id="remarks" name="remarks" rows="2" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="Any additional notes or observations."></textarea>
                        </div>

                    </div>
                </div>

                <!-- 2. Location & Coordinates -->
                <div class="bg-white p-6 rounded-lg shadow-md border">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Location Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                        <div>
                            <label for="incident_region" class="block text-sm font-medium text-gray-700">Region *</label>
                            <input type="text" id="incident_region" name="incident_region" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="Region Name">
                        </div>

                        <div>
                            <label for="incident_province" class="block text-sm font-medium text-gray-700">Province *</label>
                            <input type="text" id="incident_province" name="incident_province" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="Province Name">
                        </div>

                        <div>
                            <label for="incident_city" class="block text-sm font-medium text-gray-700">City *</label>
                            <input type="text" id="incident_city" name="incident_city" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="City/Municipality">
                        </div>

                        <div>
                            <label for="location_name" class="block text-sm font-medium text-gray-700">Specific Location Name *</label>
                            <input type="text" id="location_name" name="location_name" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="Intersection or landmark">
                        </div>

                        <div>
                            <label for="road_name" class="block text-sm font-medium text-gray-700">Road Name *</label>
                            <input type="text" id="road_name" name="road_name" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="Main road or street">
                        </div>

                        <div>
                            <label for="incident_latitude" class="block text-sm font-medium text-gray-700">Latitude (Manual Input)</label>
                            <input type="text" readonly id="incident_latitude" name="incident_latitude" value="{{ $latitude }}" class="bg-gray-100 mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="e.g., 14.5995">
                        </div>

                        <div>
                            <label for="incident_longitude" class="block text-sm font-medium text-gray-700">Longitude (Manual Input)</label>
                            <input type="text" readonly id="incident_longitude" name="incident_longitude" value="{{ $longitude }}" class="bg-gray-100 mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="e.g., 120.9842">
                        </div>

                    </div>
                </div>

                <!-- 3. Casualties and Vehicles -->
                <div class="bg-indigo-50 p-6 rounded-lg shadow-inner">
                    <h2 class="text-xl font-semibold mb-4 text-indigo-700">Casualties and Vehicles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                        <div class="col-span-full">
                            <label for="num_vehicles" class="block text-sm font-medium text-gray-700">Number of Vehicles Involved *</label>
                            <input type="number" id="num_vehicles" name="num_vehicles" min="0" value="0" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                        </div>

                        <!-- Fatalities -->
                        <div class="col-span-full md:col-span-2 lg:col-span-2 border-r pr-6">
                            <p class="text-md font-medium text-red-600 mb-2">Fatalities</p>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label for="num_driver_casualties" class="block text-xs font-medium text-gray-700">Driver</label>
                                    <input type="number" id="num_driver_casualties" name="num_driver_casualties" min="0" value="0" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 p-2 border">
                                </div>
                                <div>
                                    <label for="num_pedestrian_casualties" class="block text-xs font-medium text-gray-700">Pedestrian</label>
                                    <input type="number" id="num_pedestrian_casualties" name="num_pedestrian_casualties" min="0" value="0" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 p-2 border">
                                </div>
                                <div>
                                    <label for="num_passenger_casualties" class="block text-xs font-medium text-gray-700">Passenger</label>
                                    <input type="number" id="num_passenger_casualties" name="num_passenger_casualties" min="0" value="0" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 p-2 border">
                                </div>
                            </div>
                        </div>

                        <!-- Injured -->
                        <div class="col-span-full md:col-span-2 lg:col-span-2">
                            <p class="text-md font-medium text-orange-600 mb-2">Injured</p>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label for="num_driver_injured" class="block text-xs font-medium text-gray-700">Driver</label>
                                    <input type="number" id="num_driver_injured" name="num_driver_injured" min="0" value="0" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border">
                                </div>
                                <div>
                                    <label for="num_pedestrian_injured" class="block text-xs font-medium text-gray-700">Pedestrian</label>
                                    <input type="number" id="num_pedestrian_injured" name="num_pedestrian_injured" min="0" value="0" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border">
                                </div>
                                <div>
                                    <label for="num_passenger_injured" class="block text-xs font-medium text-gray-700">Passenger</label>
                                    <input type="number" id="num_passenger_injured" name="num_passenger_injured" min="0" value="0" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                @if ($report->submittedReport->incident_category === 'Road Accidents')

                <!-- 4. Road & Environmental Conditions -->
                <div class="bg-white p-6 rounded-lg shadow-md border">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Road & Environmental Conditions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                        <div>
                            <label for="junction_type" class="block text-sm font-medium text-gray-700">Junction Type *</label>
                            <select id="junction_type" name="junction_type" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select Type</option>
                                <option value="T-Junction">T-Junction</option>
                                <option value="Cross Intersection">Cross Intersection</option>
                                <option value="Roundabout">Roundabout</option>
                                <option value="Mid-Block">Mid-Block</option>
                            </select>
                        </div>

                        <div>
                            <label for="collision_type" class="block text-sm font-medium text-gray-700">Collision Type *</label>
                            <select id="collision_type" name="collision_type" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select Type</option>
                                <option value="Rear-end">Rear-end</option>
                                <option value="Head-on">Head-on</option>
                                <option value="Sideswipe">Sideswipe</option>
                                <option value="Roll-over">Roll-over</option>
                            </select>
                        </div>

                        <div>
                            <label for="weather_condition" class="block text-sm font-medium text-gray-700">Weather Condition *</label>
                            <select id="weather_condition" name="weather_condition" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select Condition</option>
                                <option value="Clear">Clear</option>
                                <option value="Rain">Rain</option>
                                <option value="Fog">Fog</option>
                                <option value="Cloudy">Cloudy</option>
                            </select>
                        </div>

                        <div>
                            <label for="light_condition" class="block text-sm font-medium text-gray-700">Light Condition *</label>
                            <select id="light_condition" name="light_condition" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select Condition</option>
                                <option value="Daylight">Daylight</option>
                                <option value="Dusk">Dusk</option>
                                <option value="Dark - Street Lights">Dark - Street Lights</option>
                                <option value="Dark - No Lights">Dark - No Lights</option>
                            </select>
                        </div>

                        <div>
                            <label for="road_character" class="block text-sm font-medium text-gray-700">Road Character *</label>
                            <select id="road_character" name="road_character" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select Character</option>
                                <option value="Straight Level">Straight Level</option>
                                <option value="Curve">Curve</option>
                                <option value="Gradient/Hill">Gradient/Hill</option>
                            </select>
                        </div>

                        <div>
                            <label for="surface_condition" class="block text-sm font-medium text-gray-700">Surface Condition *</label>
                            <select id="surface_condition" name="surface_condition" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select Condition</option>
                                <option value="Dry">Dry</option>
                                <option value="Wet/Slippery">Wet/Slippery</option>
                                <option value="Icy">Icy</option>
                            </select>
                        </div>

                        <div>
                            <label for="surface_type" class="block text-sm font-medium text-gray-700">Surface Type *</label>
                            <select id="surface_type" name="surface_type" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select Type</option>
                                <option value="Asphalt">Asphalt</option>
                                <option value="Concrete">Concrete</option>
                                <option value="Gravel">Gravel</option>
                            </select>
                        </div>

                        <div>
                            <label for="road_class" class="block text-sm font-medium text-gray-700">Road Class *</label>
                            <select id="road_class" name="road_class" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select Class</option>
                                <option value="Expressway">Expressway</option>
                                <option value="Primary">Primary Road</option>
                                <option value="Secondary">Secondary Road</option>
                                <option value="Local">Local Street</option>
                            </select>
                        </div>

                        <div class="lg:col-span-2">
                            <label for="main_cause" class="block text-sm font-medium text-gray-700">Main Contributing Cause *</label>
                            <input type="text" id="main_cause" name="main_cause" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="e.g., Illegal U-Turn, Speeding">
                        </div>

                        <div class="lg:col-span-2">
                            <label for="road_repairs" class="block text-sm font-medium text-gray-700">Road Repairs Status *</label>
                            <select id="road_repairs" name="road_repairs" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select Status</option>
                                <option value="None">None</option>
                                <option value="Active Construction">Active Construction</option>
                                <option value="Recent Repair">Recent Repair</option>
                            </select>
                        </div>
                    </div>
                </div>
                @endif

                <!-- 5. $reng and Investigation -->
                <div class="bg-indigo-50 p-6 rounded-lg shadow-inner">
                    <h2 class="text-xl font-semibold mb-4 text-indigo-700">Reporting & Investigation</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label for="reported_by" class="block text-sm font-medium text-gray-700">Reported By *</label>
                            <input type="text" id="reported_by" readonly name="reported_by" value="{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}" required class="bg-gray-100 mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="Name or Agency ID">
                        </div>

                        <div>
                            <label for="response_lead_agency" class="block text-sm font-medium text-gray-700">Response Lead Agency *</label>
                            <input type="text" readonly id="response_lead_agency" name="response_lead_agency" value="{{ auth()->user()->agency->agencyNames }}" required class="bg-gray-100 mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="e.g., LTO, Local Police">
                        </div>

                        <div>
                            <label for="investigating_officer" class="block text-sm font-medium text-gray-700">Investigating Officer *</label>
                            <input type="text" id="investigating_officer" name="investigating_officer" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="Name/Badge of Officer">
                        </div>

                        <div>
                            <label for="supervising_officer" class="block text-sm font-medium text-gray-700">Supervising Officer *</label>
                            <input type="text" id="supervising_officer" name="supervising_officer" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="Name/Badge of Supervisor">
                        </div>

                        @if ($report->submittedReport->incident_category === 'Road Accidents')
                        <div>
                            <label for="hit_and_run" class="block text-sm font-medium text-gray-700">Hit and Run? *</label>
                            <select id="hit_and_run" name="hit_and_run" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6 space-y-4">
                        <div>
                            <label for="action_taken" class="block text-sm font-medium text-gray-700">Action Taken *</label>
                            <textarea id="action_taken" name="action_taken" rows="2" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="Immediate actions taken at the scene (e.g., traffic diversion, first aid)."></textarea>
                        </div>

                        <div>
                            <label for="recommendation" class="block text-sm font-medium text-gray-700">Recommendation *</label>
                            <textarea id="recommendation" name="recommendation" rows="2" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="Recommendations for future prevention or enforcement."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Submission Button -->
                <div class="pt-5">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                        Submit Incident Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-partials.stack-js />
</x-layout.layout>
