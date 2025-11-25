<x-layout.layout>

    <x-partials.toast-messages />

    <div class="min-h-screen p-6 bg-gray-100">

        <h6 class="font-[Poppins] text-[15px] mb-3 text-gray-700">Receive Reports</h6>
        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg border border-gray-200 mb-8">
            <table class="w-full text-[13px] font-[Roboto] text-gray-700">
                <thead class="bg-gradient-to-r from-blue-600 to-green-600 text-white font-[Poppins] text-[13px] uppercase">
                    <tr class="text-left">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Incident</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Barangay</th>
                        <th class="px-4 py-3">Level</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">Report Action</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($receives as $index => $receive)
                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition">
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">{{ $receive->submittedReport->incident_category ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $receive->submittedReport->incident_type ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $receive->submittedReport->barangay_name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">
                            @php
                            $alarmColor = match($receive->submittedReport->alarm_level) {
                                'Level 1' => 'bg-yellow-500 text-white',
                                'Level 2' => 'bg-orange-500 text-white',
                                'Level 3' => 'bg-red-600 text-white',
                                default => 'bg-gray-300 text-gray-700',
                            };
                            @endphp
                            <span class="px-2 py-1 rounded-md text-[12px] {{ $alarmColor }}">
                                {{ $receive->submittedReport->alarm_level }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @php
                            $statusColor = match($receive->submittedReport->report_status) {
                                'Pending' => 'bg-yellow-500 text-white',
                                'Ongoing' => 'bg-blue-600 text-white',
                                'Resolved' => 'bg-green-600 text-white',
                                default => 'bg-gray-300 text-gray-700',
                            };
                            @endphp
                            <span class="px-2 py-1 rounded-md text-[11px] font-[Poppins] {{ $statusColor }}">
                                {{ $receive->submittedReport->report_status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">{{ $receive->report_action }}</td>
                        <td class="px-4 py-3 flex flex-row gap-2 items-center">
                            <div>
                                <!-- Resolve link: initially '#' — JS will populate with user coords when available -->
                                <a id="resolve-link-{{ $receive->id }}"
                                   href="#"
                                   data-report-id="{{ $receive->id }}"
                                   class="py-2 px-4 bg-gray-700 text-white rounded-sm">
                                    Resolve
                                </a>
                            </div>
                            <div><x-partials.modality-track-report :report="$receive" /></div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-4 py-4 text-center text-gray-500">
                            No submitted reports found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-0 bg-gray-100">
            <h6 class="font-[Poppins] text-[15px] mb-3 text-gray-700">Incident Map</h6>
            <div id="reports-map" class="w-full h-[500px] rounded-lg border border-gray-200 shadow-lg mb-4 z-0"></div>
        </div>

        <button id="locate-user-btn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Locate Nearest Hospital
        </button>

        <div id="er-beds-container" class="mt-4">
            <h6 class="font-[Poppins] text-[15px] mb-2 text-gray-700">ER Beds of Nearest Hospital</h6>
            <div class="relative overflow-x-auto shadow-lg sm:rounded-lg border border-gray-200">
                <table id="er-beds-table" class="w-full text-[13px] font-[Roboto] text-gray-700 hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Room</th>
                            <th class="px-4 py-3 text-left">Bed Type</th>
                            <th class="px-4 py-3 text-left">Bed Number</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Leaflet & Routing CSS/JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>

    <style>
        /* Corrected CSS for User pulse marker */
        .user-marker {
            position: relative;
            width: 40px;
            height: 40px;
        }

        .user-marker .pulse {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 123, 255, 0.25);
            border-radius: 50%;
            animation: pulse-animation 1.5s infinite;
            z-index: 1; /* Under the icon */
            transform: scale(0.5);
            transform-origin: center center;
        }

        .user-marker img {
            position: absolute;
            width: 30px;
            height: 30px;
            top: 5px; /* center inside 40px container */
            left: 5px;
            z-index: 2; /* above pulse */
        }

        @keyframes pulse-animation {
            0% {
                transform: scale(0.5);
                opacity: 0.8;
            }
            70% {
                transform: scale(1.9);
                opacity: 0;
            }
            100% {
                transform: scale(1.9);
                opacity: 0;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const map = L.map('reports-map').setView([14.5995, 120.9842], 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Display hospital markers
            const hospitals = @json($hospitals);
            const hospitalMarkers = [];
            hospitals.forEach(hospital => {
                const lat = parseFloat(hospital.latitude);
                const lng = parseFloat(hospital.longitude);
                if (!isNaN(lat) && !isNaN(lng)) {
                    const hospitalIcon = L.icon({
                        iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34]
                    });

                    L.marker([lat, lng], { icon: hospitalIcon })
                        .addTo(map)
                        .bindPopup(`<strong>${hospital.agencyNames}</strong><br>${hospital.address}`);

                    hospitalMarkers.push({
                        id: hospital.id,
                        lat,
                        lng,
                        name: hospital.agencyNames
                    });
                }
            });

            if (hospitalMarkers.length > 0) {
                map.fitBounds(hospitalMarkers.map(h => [h.lat, h.lng]), { padding: [50, 50] });
            }

            let userMarker;
            let routeControl;
            const erBedsTable = document.getElementById('er-beds-table');
            const erBedsTitle = document.querySelector('#er-beds-container h6');

            // Helper: update all Resolve links with user's coords
            function updateResolveLinks(userLat, userLng) {
                // Encode values just in case
                const lat = encodeURIComponent(userLat);
                const lng = encodeURIComponent(userLng);

                // Select all resolve links by id prefix
                document.querySelectorAll("[id^='resolve-link-']").forEach(link => {
                    const reportId = link.dataset.reportId || link.id.replace('resolve-link-', '');
                    // Build URL - adapt path if your named route uses different structure.
                    // This uses: /responder/incident/{reportId}?user-latitude=...&user-longitude=...
                    const newUrl = `/responder/incident/${reportId}/${lat}/${lng}`;
                    link.setAttribute('href', newUrl);
                });
            }

            // When user clicks Locate Nearest Hospital
            document.getElementById('locate-user-btn').addEventListener('click', () => {
                if (!navigator.geolocation) {
                    alert('Geolocation not supported');
                    return;
                }

                // remove previous route if any
                if (routeControl) map.removeControl(routeControl);
                erBedsTable.classList.add('hidden');
                erBedsTitle.textContent = 'ER Beds of Nearest Hospital';

                navigator.geolocation.getCurrentPosition(position => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    // Update Resolve links immediately with the user's coords
                    updateResolveLinks(userLat, userLng);

                    // Remove old user marker if exists
                    if (userMarker) map.removeLayer(userMarker);

                    // User marker with pulse (DivIcon)
                    const userDivIcon = L.divIcon({
                        className: '',
                        html: `<div class="user-marker"><div class="pulse"></div><img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="You"/></div>`,
                        iconSize: [40, 40],
                        iconAnchor: [20, 20]
                    });

                    userMarker = L.marker([userLat, userLng], { icon: userDivIcon }).addTo(map);

                    // Find nearest hospital (by map distance)
                    let nearestHospital = null;
                    let minDistance = Infinity;
                    hospitalMarkers.forEach(h => {
                        const distance = map.distance([userLat, userLng], [h.lat, h.lng]);
                        if (distance < minDistance) {
                            minDistance = distance;
                            nearestHospital = h;
                        }
                    });

                    if (nearestHospital) {
                        // Draw route from user to nearest hospital
                        routeControl = L.Routing.control({
                            waypoints: [
                                L.latLng(userLat, userLng),
                                L.latLng(nearestHospital.lat, nearestHospital.lng)
                            ],
                            lineOptions: {
                                styles: [{ color: 'blue', opacity: 0.6, weight: 5 }]
                            },
                            router: L.Routing.osrmv1(),
                            createMarker: () => null,
                            show: false,
                            addWaypoints: false
                        }).addTo(map);

                        const bounds = L.latLngBounds([
                            [userLat, userLng],
                            [nearestHospital.lat, nearestHospital.lng]
                        ]);
                        map.fitBounds(bounds, { padding: [50, 50] });

                        // Fetch ER Beds via AJAX (backend route: /responder/nearest-hospital-beds/{agency_id})
                        fetch(`/responder/nearest-hospital-beds/${nearestHospital.id}`)
                            .then(res => {
                                if (!res.ok) {
                                    throw new Error(`HTTP error! status: ${res.status}`);
                                }
                                return res.json();
                            })
                            .then(beds => {
                                const tbody = document.querySelector('#er-beds-table tbody');
                                tbody.innerHTML = '';

                                erBedsTitle.textContent = `ER Beds of Nearest Hospital: ${nearestHospital.name}`;

                                if (!beds || beds.length === 0) {
                                    tbody.innerHTML = `<tr><td colspan="5" class="px-4 py-3 text-center text-gray-500">No beds available for ${nearestHospital.name}</td></tr>`;
                                } else {
                                    const rows = beds.map((bed, idx) => {
                                        const rowClass = idx % 2 === 0 ? 'odd:bg-white' : 'even:bg-gray-50';
                                        let bedStatusColor;
                                        switch ((bed.status || '').toString()) {
                                            case 'Available': bedStatusColor = 'bg-green-500 text-white'; break;
                                            case 'Occupied': bedStatusColor = 'bg-red-500 text-white'; break;
                                            default: bedStatusColor = 'bg-gray-300 text-gray-700';
                                        }
                                        return `
                                            <tr class="${rowClass} hover:bg-gray-100 transition">
                                                <td class="px-4 py-3">${idx + 1}</td>
                                                <td class="px-4 py-3">${bed.room ?? ''}</td>
                                                <td class="px-4 py-3">${bed.bed_type ?? ''}</td>
                                                <td class="px-4 py-3">${bed.bed_number ?? ''}</td>
                                                <td class="px-4 py-3">
                                                    <span class="px-2 py-1 rounded-md text-[11px] font-[Poppins] ${bedStatusColor}">
                                                        ${bed.status ?? ''}
                                                    </span>
                                                </td>
                                            </tr>
                                        `;
                                    });
                                    tbody.innerHTML = rows.join('');
                                }

                                erBedsTable.classList.remove('hidden');
                            })
                            .catch(error => {
                                console.error('Error fetching ER beds:', error);
                                alert('Could not fetch ER bed data. Please ensure the backend route is reachable.');
                            });
                    }

                }, err => {
                    console.error('Geolocation error', err);
                    alert('Unable to get your location. Please allow location access and try again.');
                }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 });
            });

        });
    </script>

</x-layout.layout>
