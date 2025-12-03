<x-layout.layout>

    <x-partials.toast-messages />

    <div class="min-h-screen p-6 bg-gray-100">

        <input type="hidden" id="active-report-id" 
               value="{{ $receives->isNotEmpty() ? $receives->first()->submittedReport->id : '' }}">

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
                            <span class="px-2 py-1 rounded-md text-[12px] 
                                {{ $receive->submittedReport->alarm_level == 'Level 3' ? 'bg-red-600 text-white' : 
                                  ($receive->submittedReport->alarm_level == 'Level 2' ? 'bg-orange-500 text-white' : 'bg-yellow-500 text-white') }}">
                                {{ $receive->submittedReport->alarm_level }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-md text-[11px] font-[Poppins] bg-blue-600 text-white">
                                {{ $receive->submittedReport->report_status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">{{ $receive->report_action }}</td>
                        <td class="px-4 py-3 flex flex-row gap-2 items-center justify-center">
                            
                            <a href="{{ route('responder.incident', ['reportId' => $receive->submittedReport->id, 'latitude' => $receive->incident_latitude, 'longitude' => $receive->incident_longitude, ]) }}" class="py-2 px-4 bg-gray-700 text-white rounded-sm hover:bg-gray-800 transition">
                                Resolve
                            </a>

                            <div><x-partials.modality-track-report :report="$receive" /></div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">No submitted reports found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-0 bg-gray-100">
            <h6 class="font-[Poppins] text-[15px] mb-3 text-gray-700">Incident Map</h6>
            <div id="reports-map" class="w-full h-[500px] rounded-lg border border-gray-200 shadow-lg mb-4 z-0"></div>
        </div>

        <button id="locate-user-btn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
            Locate Nearest Hospital
        </button>

        <div id="er-beds-container" class="mt-4">
            <h6 class="font-[Poppins] text-[15px] mb-2 text-gray-700">ER Beds of Nearest Hospital</h6>
            <div class="relative overflow-x-auto shadow-lg sm:rounded-lg border border-gray-200">
                <table id="er-beds-table" class="w-full text-sm font-[Roboto] text-gray-700 hidden">
                    <thead class="bg-gray-200 text-xs uppercase font-semibold text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left whitespace-nowrap">No</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Room</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Bed Type</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Bed No.</th>
                            <th class="px-4 py-3 text-center whitespace-nowrap">Status</th>
                            <th class="px-4 py-3 text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200"></tbody>
                </table>
            </div>
        </div>

    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>

    <style>
        .user-marker { position: relative; width: 40px; height: 40px; }
        .user-marker .pulse {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 123, 255, 0.25); border-radius: 50%;
            animation: pulse-animation 1.5s infinite; z-index: 1; transform: scale(0.5);
        }
        .user-marker img {
            position: absolute; width: 30px; height: 30px; top: 5px; left: 5px; z-index: 2;
        }
        @keyframes pulse-animation {
            0% { transform: scale(0.5); opacity: 0.8; }
            70% { transform: scale(1.9); opacity: 0; }
            100% { transform: scale(1.9); opacity: 0; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Initialize Map
            const map = L.map('reports-map').setView([14.5995, 120.9842], 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);

            const hospitalsData = @json($hospitals);
            const hospitalMarkers = [];
            let userMarker;
            let routeControl;
            
            const erBedsTable = document.getElementById('er-beds-table');
            const erBedsTitle = document.querySelector('#er-beds-container h6');
            const tbody = document.querySelector('#er-beds-table tbody');

            // 2. Render Table Function
            window.renderBedTable = function(hospitalName, beds, context = 'status', hospitalId) {
                // Get the Report ID from the hidden input (Now Pre-filled!)
                const activeReportId = document.getElementById('active-report-id').value;
                const hasReport = activeReportId !== "";

                if (context === 'destination') {
                    erBedsTitle.textContent = `Destination: ${hospitalName} (Nearest Available)`;
                    erBedsTitle.className = "font-[Poppins] text-[15px] mb-2 text-green-700 font-bold px-1";
                } else {
                    erBedsTitle.textContent = `Hospital Status: ${hospitalName}`;
                    erBedsTitle.className = "font-[Poppins] text-[15px] mb-2 text-gray-700 px-1";
                }

                erBedsTable.classList.remove('hidden');
                tbody.innerHTML = '';

                if (!beds || beds.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="6" class="px-4 py-4 text-center text-gray-500">No bed data available.</td></tr>`;
                    return;
                }

                const rows = beds.map((bed, idx) => {
                    const rowClass = idx % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                    const isAvailable = bed.status === 'Available';
                    
                    // Button Logic
                    let btnText = 'Not Available';
                    let btnClass = "bg-gray-100 text-gray-400 border border-gray-200 cursor-not-allowed";
                    let btnDisabled = "disabled";

                    if (isAvailable) {
                        if (hasReport) {
                            // Valid Case: Available Bed + Active Report
                            btnText = 'Reserve';
                            btnClass = "bg-blue-600 hover:bg-blue-700 text-white active:scale-95 shadow-sm cursor-pointer";
                            btnDisabled = "";
                        } else {
                            // Fallback: Should not happen if data exists, but handled safely
                            btnText = 'No Incident Found';
                            btnClass = "bg-yellow-100 text-yellow-700 border border-yellow-200 cursor-not-allowed";
                        }
                    }

                    let badgeClass = isAvailable ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';

                    return `
                    <tr class="${rowClass} hover:bg-blue-50 transition duration-150">
                        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">${idx + 1}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-600">${bed.room ?? '-'}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-600">${bed.bed_type ?? '-'}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-600 font-medium">${bed.bed_number ?? '-'}</td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold ${badgeClass}">
                                ${bed.status ?? 'Unknown'}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <form action="{{ route('responder.submit-reserve') }}" method="POST" onsubmit="return confirm('Confirm reservation for ${bed.room} - ${bed.bed_number}?');">
                                @csrf
                                <input type="hidden" name="submitted_report_id" value="${activeReportId}" />
                                <input type="hidden" name="agency_id" value="${hospitalId}" />
                                <input type="hidden" name="emergency_room_bed_id" value="${bed.id}" />
                                
                                <button type="submit" ${btnDisabled} class="px-3 py-1.5 rounded text-xs font-medium tracking-wide transition-all w-full sm:w-auto ${btnClass}">
                                    ${btnText}
                                </button>
                            </form>
                        </td>
                    </tr>`;
                });
                tbody.innerHTML = rows.join('');
            }

            // 3. Helper: Fetch and Show
            async function fetchAndShowMarkerData(hospital) {
                erBedsTitle.textContent = `Fetching data for ${hospital.name}...`;
                erBedsTable.classList.remove('hidden');
                tbody.innerHTML = `<tr><td colspan="6" class="px-4 py-6 text-center text-gray-500 animate-pulse">Loading...</td></tr>`;
                try {
                    const response = await fetch(`/responder/nearest-hospital-beds/${hospital.id}`);
                    const beds = await response.json();
                    renderBedTable(hospital.name, beds, 'view', hospital.id); // Pass ID
                } catch (e) { console.error(e); }
            }

            // 4. Markers
            hospitalsData.forEach(hospital => {
                const lat = parseFloat(hospital.latitude);
                const lng = parseFloat(hospital.longitude);
                if (!isNaN(lat) && !isNaN(lng)) {
                    const hospitalObj = { id: hospital.id, lat: lat, lng: lng, name: hospital.agencyNames, address: hospital.address };
                    const marker = L.marker([lat, lng], { 
                        icon: L.icon({ iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png', iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34] }) 
                    }).addTo(map);
                    
                    marker.bindPopup(`<strong>${hospitalObj.name}</strong><br>${hospitalObj.address}<br><span class="text-xs text-blue-600 italic">Click marker to view beds</span>`);
                    marker.on('click', () => fetchAndShowMarkerData(hospitalObj));
                    hospitalMarkers.push(hospitalObj);
                }
            });
            if (hospitalMarkers.length > 0) map.fitBounds(hospitalMarkers.map(h => [h.lat, h.lng]), { padding: [50, 50] });

            // 5. Nearest Logic
            async function findNearestAvailableHospital(userLat, userLng, sortedHospitals) {
                erBedsTitle.textContent = "Checking hospital availability...";
                tbody.innerHTML = `<tr><td colspan="6" class="px-4 py-6 text-center text-gray-500 animate-pulse">Searching available beds...</td></tr>`;

                for (let i = 0; i < sortedHospitals.length; i++) {
                    const hospital = sortedHospitals[i];
                    try {
                        const response = await fetch(`/responder/nearest-hospital-beds/${hospital.id}`);
                        const beds = await response.json();
                        if (beds && beds.some(b => b.status === 'Available')) {
                            drawRouteToHospital(userLat, userLng, hospital);
                            renderBedTable(hospital.name, beds, 'destination', hospital.id); // Pass ID
                            return;
                        }
                    } catch (e) { console.error(e); }
                }
                erBedsTitle.textContent = "No available hospitals found.";
                tbody.innerHTML = `<tr><td colspan="6" class="px-4 py-4 text-center text-red-600">All nearby hospitals are full.</td></tr>`;
            }

            function drawRouteToHospital(userLat, userLng, hospital) {
                if (routeControl) map.removeControl(routeControl);
                routeControl = L.Routing.control({
                    waypoints: [L.latLng(userLat, userLng), L.latLng(hospital.lat, hospital.lng)],
                    lineOptions: { styles: [{ color: 'blue', opacity: 0.6, weight: 5 }] },
                    router: L.Routing.osrmv1(),
                    createMarker: () => null, show: false, addWaypoints: false
                }).addTo(map);
                map.fitBounds([[userLat, userLng], [hospital.lat, hospital.lng]], { padding: [50, 50] });
            }

            // 6. Locate User Button
            document.getElementById('locate-user-btn').addEventListener('click', () => {
                if (!navigator.geolocation) return alert('Geolocation not supported');
                erBedsTable.classList.add('hidden');
                erBedsTitle.textContent = 'Analyzing nearby hospitals...';
                navigator.geolocation.getCurrentPosition(pos => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    if (userMarker) map.removeLayer(userMarker);
                    userMarker = L.marker([lat, lng], { icon: L.divIcon({ className: '', html: `<div class="user-marker"><div class="pulse"></div><img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="You"/></div>`, iconSize: [40, 40], iconAnchor: [20, 20] }) }).addTo(map);
                    
                    hospitalMarkers.forEach(h => h.distance = map.distance([lat, lng], [h.lat, h.lng]));
                    hospitalMarkers.sort((a, b) => a.distance - b.distance);
                    findNearestAvailableHospital(lat, lng, hospitalMarkers);
                }, () => alert('Location access denied.'), { enableHighAccuracy: true });
            });
        });
    </script>
</x-layout.layout>