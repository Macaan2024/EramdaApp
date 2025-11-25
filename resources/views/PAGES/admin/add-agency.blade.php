<x-layout.layout>
    <x-partials.toast-messages />

    @php
    $agencies = App\Models\Agency::all();
    @endphp

    <div class="min-h-screen bg-gray-100 p-4 sm:p-6 rounded-md">
        <div class="bg-white p-4 rounded-2xl shadow border border-gray-200 mb-6">
            <h6 class="font-[Poppins] text-[14px] sm:text-[16px] mb-0 text-gray-800 font-semibold">
                Add Agency
            </h6>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 font-[Poppins] text-[12px]">
            <form action="{{ route('admin.submit-agency') }}" method="POST" id="agencyForm"
                class="space-y-4 bg-white p-6 rounded-2xl shadow-lg border border-gray-200" enctype="multipart/form-data">
                @csrf

                <!-- INFO BOX -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                    <h2 class="text-[14px] font-semibold text-blue-800 mb-1">About This Form</h2>
                    <p class="text-gray-700 text-[12px] leading-relaxed">
                        This form allows you to register or update details of official agencies in Iligan City, including
                        the <span class="font-semibold">Bureau of Fire Protection (BFP)</span>,
                        <span class="font-semibold">City Disaster Risk Reduction and Management Office (CDRRMO)</span>,
                        <span class="font-semibold">Barangay Disaster Risk Reduction and Management Committee (BDRRMC)</span>,
                        and local <span class="font-semibold">Hospitals</span>.<br><br>
                        Please fill out all required information accurately. Select the agency type first, then choose the agency from the dropdown. The map will update automatically.
                    </p>
                </div>

                <!-- Agency Type -->
                <div>
                    <label for="agencyType" class="block font-semibold text-[13px] mb-1 text-gray-700">Agency Type</label>
                    <select name="agencyTypes" id="agencyType"
                        class="w-full text-[12px] text-gray-700 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="">Select Type</option>
                        <option value="BFP">Bureau of Fire Protection</option>
                        <option value="HOSPITAL">Hospital</option>
                        <option value="BDRRMC">Barangay Disaster Risk Reduction and Management Committee</option>
                        <option value="CDRRMO">City Disaster Risk Reduction and Management Office</option>
                    </select>
                    @error('agencyTypes')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Agency Name -->
                <div>
                    <label for="agencyName" class="block font-semibold text-[13px] mb-1 text-gray-700">Agency Name</label>
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
                    <label for="email" class="block font-semibold text-[13px] mb-1 text-gray-700">Agency Email</label>
                    <input type="text" id="email" name="email"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                    @error('email')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div>
                    <label for="contact_number" class="block font-semibold text-[13px] mb-1 text-gray-700">Agency Contact Number</label>
                    <input type="text" name="contact_number"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                    @error('contact_number')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telephone Number -->
                <div>
                    <label for="telephone_number" class="block font-semibold text-[13px] mb-1 text-gray-700">Agency Telephone Number</label>
                    <input type="text" name="telephone_number"
                        class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                    @error('telephone_number')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Region / Province -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-[13px] mb-1 text-gray-700">Region</label>
                        <input type="text" name="region" readonly value="REGION-X"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                    </div>
                    <div>
                        <label class="block font-semibold text-[13px] mb-1 text-gray-700">Province</label>
                        <input type="text" name="province" readonly value="Lanao Del Norte"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                    </div>
                </div>

                <!-- City / Barangay -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-[13px] mb-1 text-gray-700">City</label>
                        <input type="text" value="Iligan City" readonly name="city"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                    </div>
                    <div>
                        <label class="block font-semibold text-[13px] mb-1 text-gray-700">Barangay</label>
                        <input type="text" name="barangay"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                    </div>
                </div>

                <!-- Zip / Address -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-[13px] mb-1 text-gray-700">Zip Code</label>
                        <input type="text" name="zipcode"
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-2 focus:ring-blue-600 focus:outline-none" />
                    </div>
                    <div>
                        <label class="block font-semibold text-[13px] mb-1 text-gray-700">Address</label>
                        <input type="text" name="address" id="address" readonly
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                    </div>
                </div>

                <!-- Coordinates -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="longitude" class="block font-semibold text-[13px] mb-1 text-gray-700">Longitude</label>
                        <input type="text" id="longitude" name="longitude" readonly
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                    </div>
                    <div>
                        <label for="latitude" class="block font-semibold text-[13px] mb-1 text-gray-700">Latitude</label>
                        <input type="text" id="latitude" name="latitude" readonly
                            class="w-full text-[12px] border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700" />
                    </div>
                </div>

                <!-- Logo -->
                <div>
                    <label class="block font-semibold text-[13px] mb-1 text-gray-700">Upload Logo</label>
                    <input type="file" name="logo" id="logoInput" accept="image/*" class="mb-2" />
                    <div>
                        <img id="logoPreview" src="" alt="Uploaded Logo"
                            class="w-24 h-24 object-contain border border-gray-300 rounded-lg hidden mt-2" />
                    </div>
                </div>

                <input type="hidden" value="Available" name="availabilityStatus">
                <input type="submit" value="Add New Agency"
                    class="w-full bg-blue-700 py-3 px-2 text-[13px] text-white font-semibold font-[Poppins] rounded-lg hover:bg-blue-800 transition cursor-pointer" />
            </form>

            <!-- Map -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-200">
                <h2 class="text-[14px] font-semibold text-gray-700 mb-3">Track Agency Location</h2>
                <div id="map" class="z-0 rounded-lg border border-gray-300" style="height: 520px;"></div>
            </div>
        </div>
    </div>

    <x-partials.stack-js />

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // === LOGO PREVIEW ===
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

        // === MAP SETUP ===
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

        let marker = L.marker([DEFAULT_COORDS.lat, DEFAULT_COORDS.lon], {
            draggable: true
        }).addTo(map);
        marker.bindPopup("<b>Iligan City</b>").openPopup();

        const agencyTypeSelect = document.getElementById("agencyType");
        const agencyNameSelect = document.getElementById("agencyName");
        const latitudeInput = document.getElementById("latitude");
        const longitudeInput = document.getElementById("longitude");

        function updateMarker(lat, lon, name) {
            marker.setLatLng([lat, lon]);
            map.setView([lat, lon], 15);
            latitudeInput.value = lat.toFixed(6);
            longitudeInput.value = lon.toFixed(6);
            marker.bindPopup(`<b>${name}</b>`).openPopup();
        }

        const savedAgencies = @json($agencies);

        // === Filter & Populate Agency Names ===
        agencyTypeSelect.addEventListener("change", () => {
            const type = agencyTypeSelect.value;
            agencyNameSelect.innerHTML = `<option value="">Choose Agency</option>`;
            if (!type || !agencies[type]) return;

            const existingNames = savedAgencies
                .filter(a => a.agencyTypes === type)
                .map(a => a.agencyNames.toLowerCase().trim());

            agencies[type].forEach(a => {
                if (!existingNames.includes(a.name.toLowerCase().trim())) {
                    const option = document.createElement("option");
                    option.value = a.name;
                    option.text = a.name;
                    agencyNameSelect.appendChild(option);
                }
            });

            if (agencyNameSelect.options.length === 1) {
                const option = document.createElement("option");
                option.disabled = true;
                option.text = "All agencies already registered";
                agencyNameSelect.appendChild(option);
            }

            latitudeInput.value = "";
            longitudeInput.value = "";
        });

        // === Select Agency ===
        agencyNameSelect.addEventListener("change", () => {
            const type = agencyTypeSelect.value;
            const agencyName = agencyNameSelect.value;
            if (!type || !agencyName) return;
            const agency = agencies[type].find(a => a.name === agencyName);
            if (agency) updateMarker(agency.lat, agency.lon, agency.name);
        });

        marker.on("dragend", () => {
            const {
                lat,
                lng
            } = marker.getLatLng();
            latitudeInput.value = lat.toFixed(6);
            longitudeInput.value = lng.toFixed(6);
        });

        // === Auto Address Update ===
        const barangayInput = document.querySelector('input[name="barangay"]');
        const cityInput = document.querySelector('input[name="city"]');
        const provinceInput = document.querySelector('input[name="province"]');
        const regionInput = document.querySelector('input[name="region"]');
        const addressInput = document.getElementById('address');

        function updateAddress() {
            const barangay = barangayInput.value.trim();
            const city = cityInput.value.trim();
            const province = provinceInput.value.trim();
            const region = regionInput.value.trim();
            addressInput.value = `${barangay}, ${city}, ${province}, ${region}`;
        }

        barangayInput.addEventListener("input", updateAddress);
        updateAddress();

        // === Display Saved Agencies on Map ===
        if (savedAgencies && savedAgencies.length > 0) {
            savedAgencies.forEach(agency => {
                if (agency.latitude && agency.longitude) {
                    const logo = agency.logo ?
                        `<div><img src='/storage/${agency.logo}' class='w-6 h-6 object-contain mb-1'/></div>` :
                        '';
                    const savedMarker = L.marker([agency.latitude, agency.longitude]).addTo(map);
                    savedMarker.bindPopup(
                        `<div class='flex flex-row items-center gap-2 border-gray-200'>${logo}<div>${agency.agencyNames}</div></div>`
                    );
                }
            });
        }
    </script>
</x-layout.layout>