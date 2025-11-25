<x-layout.layout>
    <x-partials.toast-messages />

    @php
    $agencies = App\Models\Agency::all();
    @endphp

    <div class="min-h-screen bg-gray-100 p-4 sm:p-6">
        <div class="bg-white p-4 rounded-2xl shadow border border-gray-200 mb-6">
            <h6 class="font-[Poppins] text-[14px] sm:text-[16px] mb-0 text-gray-800 font-semibold">
                Edit Agency
            </h6>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 font-[Poppins] text-[12px]">
            <form action="{{ route('admin.update-agency', $agency->id) }}" method="POST" id="agencyForm"
                class="space-y-4 bg-white p-6 rounded-2xl shadow-lg border border-gray-200" enctype="multipart/form-data">
                
                @csrf
                {{-- ADDED: Standard practice for update routes --}}
                @method('PATCH') 

                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                    <h2 class="text-[14px] font-semibold text-blue-800 mb-1">About This Form</h2>
                    <p class="text-gray-700 text-[12px] leading-relaxed">
                        This form allows you to <b>update details</b> of official agencies in Iligan City. Please ensure all information is correct.
                    </p>
                </div>

                <div>
                    <label for="agencyTypes" class="block font-semibold text-[13px] mb-1 text-gray-700">Agency Type</label>
                    <select name="agencyTypes" id="agencyType"
                        class="w-full text-[12px] text-gray-700 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="">Select Type</option>
                        <option value="BFP" {{ old('agencyTypes', $agency->agencyTypes) == 'BFP' ? 'selected' : '' }}>Bureau of Fire Protection</option>
                        <option value="HOSPITAL" {{ old('agencyTypes', $agency->agencyTypes) == 'HOSPITAL' ? 'selected' : '' }}>Hospital</option>
                        <option value="BDRRMC" {{ old('agencyTypes', $agency->agencyTypes) == 'BDRRMC' ? 'selected' : '' }}>Barangay Disaster Risk Reduction and Management Committee</option>
                        <option value="CDRRMO" {{ old('agencyTypes', $agency->agencyTypes) == 'CDRRMO' ? 'selected' : '' }}>City Disaster Risk Reduction and Management Office</option>
                    </select>
                    @error('agencyTypes')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="agencyName" class="block font-semibold text-[13px] mb-1 text-gray-700">Agency Name</label>
                    <select name="agencyNames" id="agencyName"
                        class="w-full text-[12px] text-gray-700 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="">Choose Agency</option>
                        {{-- Options populated by JS below --}}
                    </select>
                    @error('agencyNames')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block font-semibold text-[13px] mb-1 text-gray-700">Agency Email</label>
                    <input type="text" id="email" name="email"
                        value="{{ old('email', $agency->email) }}"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                    @error('email')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact_number" class="block font-semibold text-[13px] mb-1 text-gray-700">Agency Contact Number</label>
                    <input type="text" name="contact_number"
                        value="{{ old('contact_number', $agency->contact_number) }}"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                    @error('contact_number')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telephone_number" class="block font-semibold text-[13px] mb-1 text-gray-700">Agency Telephone Number</label>
                    <input type="text" name="telephone_number"
                        value="{{ old('telephone_number', $agency->telephone_number) }}"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                    @error('telephone_number')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-[13px] mb-1 text-gray-700">Region</label>
                        <input type="text" name="region" readonly value="{{ old('region', $agency->region ?? 'REGION-X') }}"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                    </div>
                    <div>
                        <label class="block font-semibold text-[13px] mb-1 text-gray-700">Province</label>
                        <input type="text" name="province" readonly value="{{ old('province', $agency->province ?? 'Lanao Del Norte') }}"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-[13px] mb-1 text-gray-700">City</label>
                        <input type="text" value="{{ old('city', $agency->city ?? 'Iligan City') }}" readonly name="city"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                    </div>
                    <div>
                        <label class="block font-semibold text-[13px] mb-1 text-gray-700">Barangay</label>
                        <input type="text" name="barangay"
                            value="{{ old('barangay', $agency->barangay) }}"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                        @error('barangay')
                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-[13px] mb-1 text-gray-700">Zip Code</label>
                        <input type="text" name="zipcode"
                            value="{{ old('zipcode', $agency->zipcode) }}"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                        @error('zipcode')
                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block font-semibold text-[13px] mb-1 text-gray-700">Address</label>
                        <input type="text" name="address" id="address"
                            value="{{ old('address', $agency->address) }}"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                        @error('address')
                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="longitude" class="block font-semibold text-[13px] mb-1 text-gray-700">Longitude</label>
                        <input type="text" id="longitude"
                            value="{{ old('longitude', $agency->longitude) }}"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700"
                            name="longitude" readonly />
                    </div>
                    <div>
                        <label for="latitude" class="block font-semibold text-[13px] mb-1 text-gray-700">Latitude</label>
                        <input type="text" id="latitude"
                            value="{{ old('latitude', $agency->latitude) }}"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700"
                            name="latitude" readonly />
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-[13px] mb-1 text-gray-700">Upload Logo</label>
                    <input type="file" name="logo" id="logoInput" accept="image/*" class="mb-2" />
                    <div>
                        @if ($agency->logo)
                        <img id="logoPreview" src="{{ asset('storage/' . $agency->logo) }}" alt="Uploaded Logo"
                            class="w-24 h-24 object-contain border border-gray-300 rounded-lg mt-2" />
                        @else
                        <img id="logoPreview" src="" alt="Uploaded Logo"
                            class="w-24 h-24 object-cover border border-gray-300 rounded-lg hidden mt-2" />
                        @endif
                    </div>
                </div>

                <input type="hidden" value="Available" name="availabilityStatus">

                <input type="submit" value="Update Agency"
                    class="w-full bg-green-600 py-3 px-2 text-[13px] text-white font-semibold font-[Poppins] rounded-lg hover:bg-green-700 transition cursor-pointer" />
            </form>

            <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-200">
                <h2 class="text-[14px] font-semibold text-gray-700 mb-3">Track Agency Location</h2>
                {{-- Ensure the container has fixed dimensions --}}
                <div id="map" class="z-0 rounded-lg border border-gray-300" style="height: 520px;"></div> 
            </div>
        </div>
    </div>

    <x-partials.stack-js />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // --- DATA PASSED TO JS ---
        const currentLogoUrl = "{{ $agency->logo ? asset('storage/' . $agency->logo) : '' }}"; // CORRECTED: Pre-calculate the full URL
        const currentAgencyId = {{ $agency->id }}; // CORRECTED: Removed bad Blade syntax
        const allSavedAgencies = @json($agencies);
        
        // Extract names of all SAVED agencies (excluding the current one)
        const savedAgencyNames = allSavedAgencies
            .filter(a => a.id !== currentAgencyId)
            .map(a => a.agencyNames.toLowerCase().trim());
        // --- END DATA ---

        // LOGO PREVIEW
        const logoInput = document.getElementById('logoInput');
        const logoPreview = document.getElementById('logoPreview');
        logoInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = () => {
                logoPreview.src = reader.result;
                logoPreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });

        // MAP LOGIC
        const agencies = {
            BFP: [{
                name: "Iligan City Fire Station",
                lat: 8.228746,
                lon: 124.236534
            }, {
                name: "Saray Fire Sub-Station",
                lat: 8.235013,
                lon: 124.237052
            }, {
                name: "Brgy. Suarez Fire Station",
                lat: 8.1881318,
                lon: 124.2152089
            }, {
                name: "Buru-un Fire Sub-Station",
                lat: 8.187321,
                lon: 124.1688235
            }, {
                name: "Dalipuga Fire Station",
                lat: 8.305854,
                lon: 124.2579671
            }, {
                name: "Tubod Fire Station",
                lat: 8.214164,
                lon: 124.2423562
            }, {
                name: "Sta. Filomena Fire Station",
                lat: 8.2684499,
                lon: 124.2596316
            }],
            HOSPITAL: [{
                name: "Adventist Medical Center",
                lat: 8.2414007,
                lon: 124.2470207
            }, {
                name: "Gregorio T. Lluch Memorial Hospital",
                lat: 8.2266985,
                lon: 124.2546045
            }, {
                name: "Dr. Uy Hospital",
                lat: 8.2274663,
                lon: 124.2403326
            }, {
                name: "Iligan Medical Center Hospital",
                lat: 8.2305497,
                lon: 124.249373
            }, {
                name: "Mercy Community Hospital",
                lat: 8.215,
                lon: 124.23117
            }, {
                name: "ST.MARY'S MATERNITY & CHILDREN'S HOSPITAL, INC.",
                lat: 8.2284255,
                lon: 124.2421032
            }],
            BDRRMC: [{
                name: "Abuno Barangay Hall",
                lat: 8.1833705,
                lon: 124.2573418
            }, {
                name: "Bagong Silang Barangay Hall",
                lat: 8.2415686,
                lon: 124.2513755
            }, {
                name: "Bunawan Barangay Hall",
                lat: 8.3034275,
                lon: 124.3042801
            }, {
                name: "Buru-un Barangay Hall",
                lat: 8.1872272,
                lon: 124.168809
            }, {
                name: "Dalipuga Barangay Hall",
                lat: 8.30613,
                lon: 124.25823
            }, {
                name: "Hinaplanon Barangay Hall",
                lat: 8.2465119,
                lon: 124.2596822
            }],
            CDRRMO: [{
                name: "Iligan City CDRRMO Office",
                lat: 8.228,
                lon: 124.245
            }]
        };

        const DEFAULT_COORDS = {
            lat: 8.228,
            lon: 124.245
        };
        const map = L.map("map").setView([DEFAULT_COORDS.lat, DEFAULT_COORDS.lon], 13);
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19
        }).addTo(map);

        let marker = L.marker([DEFAULT_COORDS.lat, DEFAULT_COORDS.lon]).addTo(map);

        const agencyTypeSelect = document.getElementById("agencyType");
        const agencyNameSelect = document.getElementById("agencyName");
        const latitudeInput = document.getElementById("latitude");
        const longitudeInput = document.getElementById("longitude");

        function updateMarker(lat, lon, name) {
            marker.remove(); // remove old marker first
            marker = L.marker([lat, lon], {
                draggable: true // make the current one draggable
            }).addTo(map);
            map.setView([lat, lon], 15);
            latitudeInput.value = lat.toFixed(6);
            longitudeInput.value = lon.toFixed(6);

            // CORRECTED: Use the JS variable `currentLogoUrl` instead of injecting Blade directly
            const logoHtml = currentLogoUrl ?
                `<div><img src='${currentLogoUrl}' class='w-6 h-6 object-contain mb-1'/></div>` :
                '';

            marker.bindPopup(`
                <div class="flex flex-row justify-center items-center gap-2">
                    ${logoHtml}
                    <div>
                        <b>${name} (Editing)</b>
                    </div>
                </div>
            `).openPopup();

            // Update coordinates when dragged
            marker.on("dragend", () => {
                const {
                    lat,
                    lng
                } = marker.getLatLng();
                latitudeInput.value = lat.toFixed(6);
                longitudeInput.value = lng.toFixed(6);
            });
        }

        // Function to filter agencies for the dropdown
        function filterAgenciesForDropdown(agencyList, currentAgencyName) {
            const lowerCurrentName = currentAgencyName.toLowerCase().trim();
            // Include the current agency name, but exclude all others that are already saved.
            return agencyList.filter(a =>
                a.name.toLowerCase().trim() === lowerCurrentName ||
                !savedAgencyNames.includes(a.name.toLowerCase().trim())
            );
        }

        // EVENT LISTENER: Agency Type Change
        agencyTypeSelect.addEventListener("change", () => {
            const type = agencyTypeSelect.value;
            // Clear previous options
            agencyNameSelect.innerHTML = `<option value="">Choose Agency</option>`;

            if (!type || !agencies[type]) return;

            const currentAgencyName = "{{ old('agencyNames', $agency->agencyNames) }}";

            // Filter the list to exclude saved names, but INCLUDE the currently edited one.
            const filteredAgencies = filterAgenciesForDropdown(agencies[type], currentAgencyName);

            // Populate the dropdown with filtered names
            filteredAgencies.forEach(a => {
                const option = document.createElement("option");
                option.value = a.name;
                option.text = a.name;

                // Keep the existing agency name selected if it matches
                if (a.name === currentAgencyName) option.selected = true;

                agencyNameSelect.appendChild(option);
            });
        });

        // EVENT LISTENER: Agency Name Change
        agencyNameSelect.addEventListener("change", () => {
            const type = agencyTypeSelect.value;
            const name = agencyNameSelect.value;
            if (!type || !name) return;

            // Find the selected agency's coordinates
            const agency = agencies[type].find(a => a.name === name);
            if (agency) updateMarker(agency.lat, agency.lon, agency.name);
        });

        // Auto-populate and map on page load for EDIT mode
        window.addEventListener("DOMContentLoaded", () => {
            const type = "{{ old('agencyTypes', $agency->agencyTypes) }}";
            const savedName = "{{ old('agencyNames', $agency->agencyNames) }}";

            if (type && agencies[type]) {
                // Manually trigger the population logic

                // Filter the list to exclude other saved agencies, but INCLUDE the one being edited
                const filteredAgencies = filterAgenciesForDropdown(agencies[type], savedName);

                filteredAgencies.forEach(a => {
                    const option = document.createElement("option");
                    option.value = a.name;
                    option.text = a.name;
                    if (a.name === savedName) option.selected = true;
                    agencyNameSelect.appendChild(option);
                });

                // Set map marker to the existing location
                const savedLat = parseFloat("{{ $agency->latitude }}");
                const savedLon = parseFloat("{{ $agency->longitude }}");
                if (!isNaN(savedLat) && !isNaN(savedLon)) {
                    updateMarker(savedLat, savedLon, savedName);
                }
            }

            // Load markers for all OTHER SAVED agencies on the map
            if (allSavedAgencies && allSavedAgencies.length > 0) {
                allSavedAgencies.forEach(agency => {
                    // Only display other agency markers (not the one being edited)
                    if (agency.latitude && agency.longitude && agency.id !== currentAgencyId) {
                        const otherLogoUrl = agency.logo ? `/storage/${agency.logo}` : '';
                        const logo = otherLogoUrl ?
                            `<div class="flex flex-row gap-2 items-center justify-center">
                            <img src='${otherLogoUrl}' class='w-6 h-6 object-contain mb-1'/>` :
                            '';

                        const staticMarker = L.marker([agency.latitude, agency.longitude], {
                            opacity: 0.6
                        }).addTo(map);
                        const popupContent = `
                            <div class='text-center text-xs'>
                                ${logo}
                                <b>${agency.agencyNames}</b>
                            </div>
                            </div>
                        `;
                        staticMarker.bindPopup(popupContent); // Do not open popup immediately for all static markers
                    }
                });
            }
        });
    </script>
</x-layout.layout>