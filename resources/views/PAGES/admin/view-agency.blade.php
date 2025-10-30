<x-layout.layout>
    <x-partials.toast-messages />

    <div class="flex flex-col gap-6 mt-10 px-6 lg:px-12">

        <!-- AGENCY INFORMATION + MAP -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- AGENCY INFO -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 space-y-6">
                <!-- Header -->
                <div class="flex items-center mb-4">
                    <i class="fa-solid fa-building text-blue-600 text-2xl mr-3"></i>
                    <h2 class="text-[16px] font-[Poppins] font-semibold text-gray-900">
                        Agency Information
                    </h2>
                </div>

                <!-- Logo & Name -->
                <div class="flex items-start gap-6">
                    @if($agency->logo)
                        <img src="{{ asset('storage/' . $agency->logo) }}" alt="Agency Logo"
                             class="h-28 w-28 object-cover rounded-full border-4 border-blue-100 shadow-sm">
                    @else
                        <div class="h-28 w-28 flex items-center justify-center bg-gray-100 text-gray-400 rounded-full border border-gray-300">
                            No Logo
                        </div>
                    @endif
                    <div class="flex-1 space-y-2">
                        <h3 class="text-[16px] font-[Poppins] font-bold text-gray-800">
                            {{ $agency->agencyNames }}
                        </h3>
                        <p class="text-[14px] font-[Roboto] text-blue-600">{{ $agency->agencyTypes }}</p>
                        <span class="inline-block px-3 py-1 rounded-full text-[12px] font-[Roboto] font-semibold
                            {{ $agency->availabilityStatus === 'Available' ? 'bg-green-100 text-green-700' :
                               ($agency->availabilityStatus === 'Inactive' ? 'bg-yellow-100 text-yellow-700' :
                               'bg-red-100 text-red-700') }}">
                            {{ $agency->availabilityStatus }}
                        </span>
                    </div>
                </div>

                <!-- Details -->
                <div class="grid grid-cols-2 gap-y-3 gap-x-6 text-[14px] font-[Roboto] text-gray-700 mt-4">
                    <p class="font-medium text-gray-500">Region:</p>
                    <p class="font-medium text-gray-800">{{ $agency->region ?? 'N/A' }}</p>

                    <p class="font-medium text-gray-500">Province:</p>
                    <p class="font-medium text-gray-800">{{ $agency->province ?? 'N/A' }}</p>

                    <p class="font-medium text-gray-500">City:</p>
                    <p class="font-medium text-gray-800">{{ $agency->city }}</p>

                    <p class="font-medium text-gray-500">Barangay:</p>
                    <p class="font-medium text-gray-800">{{ $agency->barangay }}</p>

                    <p class="font-medium text-gray-500">Address:</p>
                    <p class="font-medium text-gray-800">{{ $agency->address }}</p>

                    <p class="font-medium text-gray-500">Zipcode:</p>
                    <p class="font-medium text-gray-800">{{ $agency->zipcode }}</p>

                    <p class="font-medium text-gray-500">Email:</p>
                    <p class="font-medium text-blue-700 underline hover:text-blue-900 transition">{{ $agency->email }}</p>

                    <p class="font-medium text-gray-500">Latitude:</p>
                    <p class="font-medium text-gray-800">{{ $agency->latitude ?? 'N/A' }}</p>

                    <p class="font-medium text-gray-500">Longitude:</p>
                    <p class="font-medium text-gray-800">{{ $agency->longitude ?? 'N/A' }}</p>

                    <p class="font-medium text-gray-500">Created At:</p>
                    <p class="font-medium text-gray-800">{{ $agency->created_at->format('F d, Y') }}</p>

                    <p class="font-medium text-gray-500">Updated At:</p>
                    <p class="font-medium text-gray-800">{{ $agency->updated_at->format('F d, Y') }}</p>
                </div>
            </div>

            <!-- MAP -->
            <div class="flex flex-col space-y-4">
                <h3 class="text-[16px] font-[Poppins] font-semibold text-blue-800 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-blue-600"></i>Agency Location
                </h3>
                <div id="map" class="w-full h-[480px] rounded-2xl border border-gray-200 shadow-md"></div>
            </div>
        </div>
    </div>

    <!-- MAP SCRIPT -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const agency = @json($agency);

        const map = L.map('map').setView(
            [agency.latitude || 8.228, agency.longitude || 124.245],
            14
        );

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
        }).addTo(map);

        if (agency.latitude && agency.longitude) {
            const marker = L.marker([agency.latitude, agency.longitude]).addTo(map);
            const logoHTML = agency.logo ?
                `<img src="/storage/${agency.logo}" class="w-8 h-8 object-contain mb-1" />` :
                "";
            marker.bindPopup(`
                <div class="text-center">
                    ${logoHTML}
                    <b>${agency.agencyNames}</b><br>
                    <small>${agency.agencyTypes}</small>
                </div>
            `).openPopup();
        }
    </script>
</x-layout.layout>
