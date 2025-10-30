<x-layout.layout>
    <x-partials.toast-messages />


    @php
    $agencies = App\Models\Agency::all();
    @endphp

    <div class="flex flex-row justify-between items-center mb-4">
        <h1 class="text-[20px] font-[Poppins] font-bold text-gray-800">Edit Agency</h1>
    </div>
    <hr class="mb-6 border-gray-300">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 font-[Poppins] text-[12px]">
        <!-- 🧾 Left Column: Form -->
        <form action="{{ route('admin.update-agency', $agency->id) }}" method="POST" id="agencyForm"
            class="space-y-4 bg-white p-6 rounded-2xl shadow-lg border border-gray-200" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <!-- 📝 Intro Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                <h2 class="text-[14px] font-semibold text-blue-700 mb-1">About This Form</h2>
                <p class="text-gray-700 text-[12px] leading-relaxed">
                    This form allows you to update details of official agencies in Iligan City. Please ensure all information is correct.
                </p>
            </div>

            <!-- Agency Type -->
            <div>
                <label for="agencyTypes" class="block font-semibold text-[14px] mb-1 text-gray-700">Agency Type</label>
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

            <!-- Agency Name -->
            <div>
                <label for="agencyName" class="block font-semibold text-[14px] mb-1 text-gray-700">Agency Name</label>
                <select name="agencyNames" id="agencyName"
                    class="w-full text-[12px] text-gray-700 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <option value="">Choose Agency</option>
                </select>
                @error('agencyNames')
                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block font-semibold text-[14px] mb-1 text-gray-700">Agency Email</label>
                <input type="text" id="email" name="email"
                    value="{{ old('email', $agency->email) }}"
                    class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700" />
                @error('email')
                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Region and Province -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-[14px] mb-1 text-gray-700">Region</label>
                    <input type="text" name="region" readonly value="{{ old('region', $agency->region ?? 'REGION-X') }}"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                </div>
                <div>
                    <label class="block font-semibold text-[14px] mb-1 text-gray-700">Province</label>
                    <input type="text" name="province" readonly value="{{ old('province', $agency->province ?? 'Lanao Del Norte') }}"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                </div>
            </div>

            <!-- City and Barangay -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-[14px] mb-1 text-gray-700">City</label>
                    <input type="text" value="{{ old('city', $agency->city ?? 'Iligan City') }}" readonly name="city"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                </div>
                <div>
                    <label class="block font-semibold text-[14px] mb-1 text-gray-700">Barangay</label>
                    <input type="text" name="barangay"
                        value="{{ old('barangay', $agency->barangay) }}"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700" />
                    @error('barangay')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address and Zip -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-[14px] mb-1 text-gray-700">Zip Code</label>
                    <input type="text" name="zipcode"
                        value="{{ old('zipcode', $agency->zipcode) }}"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700" />
                    @error('zipcode')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block font-semibold text-[14px] mb-1 text-gray-700">Address</label>
                    <input type="text" name="address" id="address"
                        value="{{ old('address', $agency->address) }}"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700" />
                    @error('address')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Coordinates -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="longitude" class="block font-semibold text-[14px] mb-1 text-gray-700">Longitude</label>
                    <input type="text" id="longitude"
                        value="{{ old('longitude', $agency->longitude) }}"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600 focus:outline-none"
                        name="longitude" readonly />
                </div>
                <div>
                    <label for="latitude" class="block font-semibold text-[14px] mb-1 text-gray-700">Latitude</label>
                    <input type="text" id="latitude"
                        value="{{ old('latitude', $agency->latitude) }}"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600 focus:outline-none"
                        name="latitude" readonly />
                </div>
            </div>

            <!-- Logo Upload -->
            <div>
                <label class="block font-semibold text-[14px] mb-1 text-gray-700">Upload Logo</label>
                <input type="file" name="logo" id="logoInput" accept="image/*" class="mb-2" />
                <div>
                    @if ($agency->logo)
                    <img id="logoPreview" src="{{ asset('storage/' . $agency->logo) }}" alt="Uploaded Logo"
                        class="w-32 h-32 object-contain border border-gray-300 rounded-lg" />
                    @else
                    <img id="logoPreview" src="" alt="Uploaded Logo"
                        class="w-32 h-32 object-cover border border-gray-300 rounded-lg hidden" />
                    @endif
                </div>
            </div>

            <input type="hidden" value="Available" name="availabilityStatus">

            <input type="submit" value="Update Agency"
                class="w-full bg-green-600 py-3 px-2 text-[12px] text-white font-[Poppins] rounded-lg hover:bg-green-700 transition" />
        </form>

        <!-- 🗺️ Map -->
        <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-300">
            <h2 class="text-[14px] font-semibold text-gray-700 mb-2">Track Agency Location</h2>
            <div id="map" class="rounded-lg border border-gray-300" style="height: 520px;"></div>
        </div>
    </div>

    <x-partials.stack-js />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // LOGO PREVIEW
        const currentLogo = "{{ $agency->logo }}";
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
                },
                {
                    name: "Saray Fire Sub-Station",
                    lat: 8.235013,
                    lon: 124.237052
                },
                {
                    name: "Brgy. Suarez Fire Station",
                    lat: 8.1881318,
                    lon: 124.2152089
                },
                {
                    name: "Buru-un Fire Sub-Station",
                    lat: 8.187321,
                    lon: 124.1688235
                },
                {
                    name: "Dalipuga Fire Station",
                    lat: 8.305854,
                    lon: 124.2579671
                },
                {
                    name: "Tubod Fire Station",
                    lat: 8.214164,
                    lon: 124.2423562
                },
                {
                    name: "Sta. Filomena Fire Station",
                    lat: 8.2684499,
                    lon: 124.2596316
                }
            ],
            HOSPITAL: [{
                    name: "Adventist Medical Center",
                    lat: 8.2414007,
                    lon: 124.2470207
                },
                {
                    name: "Gregorio T. Lluch Memorial Hospital",
                    lat: 8.2266985,
                    lon: 124.2546045
                },
                {
                    name: "Dr. Uy Hospital",
                    lat: 8.2274663,
                    lon: 124.2403326
                },
                {
                    name: "Iligan Medical Center Hospital",
                    lat: 8.2305497,
                    lon: 124.249373
                },
                {
                    name: "Mercy Community Hospital",
                    lat: 8.215,
                    lon: 124.23117
                },
                {
                    name: "ST.MARY'S MATERNITY & CHILDREN'S HOSPITAL, INC.",
                    lat: 8.2284255,
                    lon: 124.2421032
                }
            ],
            BDRRMC: [{
                    name: "Abuno Barangay Hall",
                    lat: 8.1833705,
                    lon: 124.2573418
                },
                {
                    name: "Bagong Silang Barangay Hall",
                    lat: 8.2415686,
                    lon: 124.2513755
                },
                {
                    name: "Bunawan Barangay Hall",
                    lat: 8.3034275,
                    lon: 124.3042801
                },
                {
                    name: "Buru-un Barangay Hall",
                    lat: 8.1872272,
                    lon: 124.168809
                },
                {
                    name: "Dalipuga Barangay Hall",
                    lat: 8.30613,
                    lon: 124.25823
                },
                {
                    name: "Hinaplanon Barangay Hall",
                    lat: 8.2465119,
                    lon: 124.2596822
                }
            ],
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
                draggable: true
            }).addTo(map); // make only this one draggable
            map.setView([lat, lon], 15);
            latitudeInput.value = lat.toFixed(6);
            longitudeInput.value = lon.toFixed(6);
             marker.bindPopup(`
        <div class="flex flex-row justify-center items-center gap-2">
            <div>
                <img src='/storage/${currentLogo}' class='w-6 h-6 object-contain mb-1'/>
            </div>
            <div>
                <b>${name}</b>
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


        agencyTypeSelect.addEventListener("change", () => {
            const type = agencyTypeSelect.value;
            agencyNameSelect.innerHTML = `<option value="">Choose Agency</option>`;
            if (!type || !agencies[type]) return;
            agencies[type].forEach(a => {
                const option = document.createElement("option");
                option.value = a.name;
                option.text = a.name;
                agencyNameSelect.appendChild(option);
            });
        });

        agencyNameSelect.addEventListener("change", () => {
            const type = agencyTypeSelect.value;
            const name = agencyNameSelect.value;
            if (!type || !name) return;
            const agency = agencies[type].find(a => a.name === name);
            if (agency) updateMarker(agency.lat, agency.lon, agency.name, agency.logo);
        });

        // Auto-populate for edit mode
        window.addEventListener("DOMContentLoaded", () => {
            const type = "{{ old('agencyTypes', $agency->agencyTypes) }}";
            const savedName = "{{ old('agencyNames', $agency->agencyNames) }}";
            if (type && agencies[type]) {
                agencies[type].forEach(a => {
                    const option = document.createElement("option");
                    option.value = a.name;
                    option.text = a.name;
                    if (a.name === savedName) option.selected = true;
                    agencyNameSelect.appendChild(option);
                });

                const savedLat = parseFloat("{{ $agency->latitude }}");
                const savedLon = parseFloat("{{ $agency->longitude }}");
                if (!isNaN(savedLat) && !isNaN(savedLon)) {
                    updateMarker(savedLat, savedLon, savedName);
                }
            }
        });


        const savedAgencies = @json($agencies);

        const currentAgency = {{$agency->id}};


        if (savedAgencies && savedAgencies.length > 0) {
            savedAgencies.forEach(agency => {
                if (agency.latitude && agency.longitude && agency.id !== currentAgency) {
                    const logo = agency.logo ?
                        `
                        <div class="flex flex-row gap-2 items-center justify-center">
                        <img src='/storage/${agency.logo}' class='w-6 h-6 object-contain mb-1'/>` :
                        '';

                    const marker = L.marker([agency.latitude, agency.longitude]).addTo(map);
                    const popupContent = `
                <div class='text-center'>
                    ${logo}
                    <b>${agency.agencyNames}</b>
                </div>
                </div>
            `;
                    marker.bindPopup(popupContent, {
                        autoClose: false,
                        closeOnClick: false
                    }).openPopup();
                }
            });
        }
    </script>
</x-layout.layout>