<x-layout.layout>
    <x-partials.toast-messages />

    {{-- 🔴 Display All Validation Errors --}}
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <strong class="font-semibold">Please fix the following errors:</strong>
        <ul class="list-disc list-inside mt-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex flex-row justify-between items-center mb-4">
        <h1 class="text-3xl font-bold text-gray-800">Add Incident Reports</h1>
    </div>
    <hr class="mb-6 border-gray-300">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- 🧾 Left Column: Form -->
        <form action="{{ route('admin.submit-reports') }}" method="POST" id="incidentForm" class="space-y-4 bg-white p-6 rounded-xl shadow-md border border-gray-200">
            @csrf

            <!-- Incident Category -->
            <div>
                <label for="incident_category" class="block font-semibold mb-1 text-gray-700">Incident Category</label>
                <select id="incident_category" name="incident_category" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">Select Category</option>
                    <option value="Disaster Incidents" {{ old('incident_category') == 'Disaster Incidents' ? 'selected' : '' }}>Disaster Incidents</option>
                    <option value="Road Accidents" {{ old('incident_category') == 'Road Accidents' ? 'selected' : '' }}>Road Accidents</option>
                </select>
                @error('incident_category') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Subcategory -->
            <div>
                <label for="incident_type" class="block font-semibold mb-1 text-gray-700">Incident Type</label>
                <select id="incident_type" name="incident_type" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">Select Type</option>
                    @if(old('incident_category') && old('incident_type'))
                    <option value="{{ old('incident_type') }}" selected>{{ old('incident_type') }}</option>
                    @endif
                </select>
                @error('incident_type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- City Name -->
            <div>
                <label for="city_name" class="block font-semibold mb-1 text-gray-700">City Name</label>
                <input type="text" readonly name="city_name" value="{{ old('city_name', 'Iligan City') }}" class="w-full border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700">
                @error('city_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Barangay -->
            <div>
                <label for="barangay" class="block font-semibold mb-1 text-gray-700">Barangay Name</label>
                <select name="barangay_name" id="barangay" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="" disabled {{ old('barangay_name') ? '' : 'selected' }}>Select Barangay</option>
                    @foreach([
                    'Abuno', 'Acmac-Mariano Badelles Sr.', 'Bagong Silang', 'Bonbonon', 'Bunawan', 'Buru-un', 'Dalipuga', 'Del Carmen', 'Digkilaan',
                    'Ditucalan', 'Dulag', 'Hinaplanon', 'Hindang', 'Kabacsanan', 'Kalilangan', 'Kiwalan', 'Lanipao', 'Luinab', 'Mahayahay', 'Mainit',
                    'Mandulog', 'Maria Cristina', 'Pala-o', 'Panoroganan', 'Poblacion', 'Puga-an', 'Rogongon', 'San Miguel', 'San Roque', 'Santa Elena',
                    'Santa Filomena', 'Santiago', 'Santo Rosario', 'Saray', 'Suarez', 'Tambacan', 'Tibanga', 'Tipanoy', 'Tomas L. Cabili (Tominobo Proper)',
                    'Tubod', 'Upper Hinaplanon', 'Upper Tominobo', 'Ubaldo Laya'
                    ] as $barangay)
                    <option value="{{ $barangay }}" {{ old('barangay_name') == $barangay ? 'selected' : '' }}>{{ $barangay }}</option>
                    @endforeach
                </select>
                @error('barangay_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Purok and Street -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="purok" class="block font-semibold mb-1 text-gray-700">Purok</label>
                    <input type="text" id="purok" name="purok" value="{{ old('purok') }}" class="w-full border border-gray-300 rounded-lg p-2">
                    @error('purok') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="street_name" class="block font-semibold mb-1 text-gray-700">Street Name</label>
                    <input type="text" id="street_name" name="street_name" value="{{ old('street_name') }}" class="w-full border border-gray-300 rounded-lg p-2">
                    @error('street_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Coordinates -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="barangay_longitude" class="block font-semibold mb-1 text-gray-700">Longitude</label>
                    <input type="text" id="barangay_longitude" name="barangay_longitude" value="{{ old('barangay_longitude') }}" class="w-full border border-gray-300 rounded-lg p-2">
                    @error('barangay_longitude') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="barangay_latitude" class="block font-semibold mb-1 text-gray-700">Latitude</label>
                    <input type="text" id="barangay_latitude" name="barangay_latitude" value="{{ old('barangay_latitude') }}" class="w-full border border-gray-300 rounded-lg p-2">
                    @error('barangay_latitude') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Alarm Level -->
            <div>
                <label for="alarm_level" class="block font-semibold mb-1 text-gray-700">Alarm Level</label>
                <select name="alarm_level" id="alarm_level" class="w-full border border-gray-300 rounded-lg p-2">
                    <option value="Level 1" {{ old('alarm_level') == 'Level 1' ? 'selected' : '' }}>Level 1</option>
                    <option value="Level 2" {{ old('alarm_level') == 'Level 2' ? 'selected' : '' }}>Level 2</option>
                    <option value="Level 3" {{ old('alarm_level') == 'Level 3' ? 'selected' : '' }}>Level 3</option>
                </select>
                @error('alarm_level') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Vehicle Requests -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="police_car_request" class="block font-semibold mb-1 text-gray-700">Police Car Request</label>
                    <input type="number" id="police_car_request" name="police_car_request" value="{{ old('police_car_request') }}" class="w-full border border-gray-300 rounded-lg p-2">
                    @error('police_car_request') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="fire_truck_request" class="block font-semibold mb-1 text-gray-700">Fire Truck Request</label>
                    <input type="number" id="fire_truck_request" name="fire_truck_request" value="{{ old('fire_truck_request') }}" class="w-full border border-gray-300 rounded-lg p-2">
                    @error('fire_truck_request') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="ambulance_request" class="block font-semibold mb-1 text-gray-700">Ambulance Request</label>
                    <input type="number" id="ambulance_request" name="ambulance_request" value="{{ old('ambulance_request') }}" class="w-full border border-gray-300 rounded-lg p-2">
                    @error('ambulance_request') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Hidden Vehicle Type Request Field -->
                <input type="hidden" name="vehicle_type_request" id="vehicle_type_request" value="{{ old('vehicle_type_request') }}">
                @error('vehicle_type_request') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Hidden Fields -->
            <input type="hidden" name="report_status" value="Pending">
            @error('report_status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            @error('user_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

            <input
                type="hidden"
                name="reported_by"
                value="{{ (auth()->check() && auth()->user()->user_type && auth()->user()->lastname && auth()->user()->firstname) 
                    ? auth()->user()->position . ' - ' . auth()->user()->lastname . ' ' . auth()->user()->firstname 
                    : 'N/A' }}" />
            @error('reported_by') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

            <input
                type="hidden"
                name="from_agency"
                value="{{ optional(auth()->user()->agency)->agencyNames ?? 'N/A' }}" />
            @error('from_agency') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition-all">
                    Submit Report
                </button>
            </div>
        </form>

        <!-- 🗺️ Right Column: Map -->
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200">
            <h2 class="text-lg font-semibold mb-2 text-gray-700">Barangay Location</h2>
            <div id="map" style="height: 520px;" class="rounded-lg border"></div>
        </div>
    </div>

    <x-partials.stack-js />

    <!-- Leaflet Library and Script (unchanged) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    {{-- your entire JS remains unchanged below --}}
    <script>
        // 🔹 Dynamic options for incident type
        const incidentOptions = {
            "Disaster Incidents": ["Flood", "Earthquake", "Landslide", "Fire", "Typhoon"],
            "Road Accidents": ["Car Collision", "Motorcycle Accident", "Truck Accident", "Pedestrian Accident", "Bus Crash"]
        };

        const categorySelect = document.getElementById('incident_category');
        const typeSelect = document.getElementById('incident_type');
        const alarmSelect = document.getElementById('alarm_level');
        const policeCarRequestField = document.getElementById('police_car_request');
        const fireTruckRequestField = document.getElementById('fire_truck_request');
        const ambulanceRequestField = document.getElementById('ambulance_request');
        const vehicleTypeRequestedField = document.getElementById('vehicle_type_request');

        // 🔹 Populate incident types dynamically
        function populateIncidentTypes(selectedCategory) {
            typeSelect.innerHTML = '<option value="">Select Type</option>';
            if (incidentOptions[selectedCategory]) {
                incidentOptions[selectedCategory].forEach(t => {
                    const opt = document.createElement('option');
                    opt.value = t;
                    opt.textContent = t;
                    if (t === "{{ old('incident_type') }}") opt.selected = true;
                    typeSelect.appendChild(opt);
                });
            }
        }

        // When category changes
        categorySelect.addEventListener('change', function() {
            populateIncidentTypes(this.value);
            updateVehicleRequests();
        });

        // Restore old data (if validation failed)
        if ("{{ old('incident_category') }}") {
            populateIncidentTypes("{{ old('incident_category') }}");
        }

        alarmSelect.addEventListener('change', updateVehicleRequests);
        typeSelect.addEventListener('change', updateVehicleRequests);

        // 🔹 Function: Update vehicle requests based on alarm level & incident type
        function updateVehicleRequests() {
            const alarmLevel = alarmSelect.value;
            const incidentCategory = categorySelect.value;
            const incidentType = typeSelect.value;

            // Reset values first
            policeCarRequestField.value = "";
            fireTruckRequestField.value = "";
            ambulanceRequestField.value = "";
            vehicleTypeRequestedField.value = "";

            if (alarmLevel === 'Level 1') {
                if (incidentCategory === 'Road Accidents') {
                    ambulanceRequestField.value = 1;
                } else if (incidentCategory === 'Disaster Incidents' && incidentType === 'Fire') {
                    fireTruckRequestField.value = 1;
                }
            } else if (alarmLevel === 'Level 2') {
                if (incidentCategory === 'Road Accidents') {
                    ambulanceRequestField.value = 2;
                } else if (incidentCategory === 'Disaster Incidents') {
                    if (incidentType !== 'Fire') {
                        ambulanceRequestField.value = 2;
                    } else {
                        fireTruckRequestField.value = 2;
                        ambulanceRequestField.value = 2;
                    }
                }
            } else if (alarmLevel === 'Level 3') {
                policeCarRequestField.value = 3;
                ambulanceRequestField.value = 3;

                // ✅ Fire trucks only if incident type is 'Fire'
                if (incidentType === 'Fire') {
                    fireTruckRequestField.value = 3;
                } else {
                    fireTruckRequestField.value = "";
                }
            }

            // Update hidden field with selected vehicle types
            let vehicleTypes = [];
            if (policeCarRequestField.value > 0) vehicleTypes.push("Police Car");
            if (fireTruckRequestField.value > 0) vehicleTypes.push("Fire Truck");
            if (ambulanceRequestField.value > 0) vehicleTypes.push("Ambulance");

            vehicleTypeRequestedField.value = vehicleTypes.join(", ");
        }

        // 🔹 Initialize Leaflet Map
        const map = L.map('map').setView([8.2280, 124.2452], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);
        let marker = L.marker([8.2280, 124.2452]).addTo(map).bindPopup("Iligan City").openPopup();

        // 🔹 Barangay selection: auto-fill coordinates
        document.getElementById('barangay').addEventListener('change', async function() {
            const barangay = this.value;
            if (!barangay) return;
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${barangay}, Iligan City, Philippines`;
            const response = await fetch(url);
            const data = await response.json();

            if (data && data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lon = parseFloat(data[0].lon);
                document.getElementById('barangay_latitude').value = lat;
                document.getElementById('barangay_longitude').value = lon;

                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lon]).addTo(map).bindPopup(barangay).openPopup();
                map.setView([lat, lon], 14);
            } else {
                alert('Coordinates not found for ' + barangay);
            }
        });

        // 🔹 Update vehicle types when user edits inputs manually
        document.getElementById('police_car_request').addEventListener('input', updateVehicleRequests);
        document.getElementById('fire_truck_request').addEventListener('input', updateVehicleRequests);
        document.getElementById('ambulance_request').addEventListener('input', updateVehicleRequests);

        // Run once when page loads
        updateVehicleRequests();
    </script>
</x-layout.layout>