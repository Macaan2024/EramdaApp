<button data-modal-target="report-modal" data-modal-toggle="report-modal"
    class="text-white bg-blue-700 py-1 px-3 rounded-sm">
    View
</button>


<!-- Modal structure -->
<div id="report-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="relative bg-white border border-gray-200 rounded-lg shadow-lg w-[95%] max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">

        <!-- Modal header -->
        <div class="flex items-center justify-between border-b border-gray-200 p-4 sticky top-0 bg-white z-10">
            <h3 class="text-lg font-medium text-gray-900">Incident Location</h3>
            <button type="button"
                class="text-gray-500 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-9 h-9 flex justify-center items-center transition"
                data-modal-hide="report-modal">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        <!-- Scrollable modal body -->
        <div class="flex-1 overflow-y-auto p-4 space-y-6">

            <!-- Map section -->
            <div class="relative">
                <div class="map-container" id="modal-map"></div>
                <div id="modal-travel-time"
                    class="travel-time absolute top-4 left-1/2 transform -translate-x-1/2 z-[9999]"></div>
            </div>

            <!-- Report timeline -->
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <h4 class="text-sm font-bold text-blue-700 mb-3">Report Status Timeline</h4>
                <ol class="relative border-s border-gray-200 ml-4">
                    <li class="mb-4 ms-6">
                        <span
                            class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -start-3 ring-8 ring-blue-500/10">
                            <span class="text-green-600 text-xs font-bold">✓</span>
                        </span>
                        <h3 class="mb-1 text-sm font-semibold text-gray-900">
                            Report Submitted
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded ms-3">Initial</span>
                        </h3>
                        <time class="block mb-2 text-xs text-gray-400">
                            {{ \Carbon\Carbon::parse($report->submittedReport->created_at)->format('F d, Y h:i A') }}
                        </time>
                    </li>
                    <li class="mb-4 ms-6">
                        <span
                            class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-blue-500/10">
                            <span class="text-blue-600 text-xs font-bold">...</span>
                        </span>
                        <h3 class="text-sm font-semibold text-gray-900">
                            Current Status: {{ $report->submittedReport->report_status }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">Awaiting dispatch or further action by the agency.</p>
                    </li>
                </ol>
            </div>

            <!-- Report details -->
            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                <h4 class="text-sm font-bold text-gray-700 border-b border-gray-200 pb-2 mb-4">
                    Detailed Report Information
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-3 gap-x-6 mb-4">
                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">Incident</p>
                        <p class="text-sm font-medium text-gray-900">{{ $report->submittedReport->incident_category }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">Type</p>
                        <p class="text-sm font-medium text-gray-900">{{ $report->submittedReport->incident_type }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">Alarm Level</p>
                        <p
                            class="text-sm font-bold {{ $report->submittedReport->alarm_level == 'High' ? 'text-red-600' : ($report->submittedReport->alarm_level == 'Medium' ? 'text-yellow-600' : 'text-green-600') }}">
                            {{ $report->submittedReport->alarm_level }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-3 gap-x-6 border-t border-gray-100 pt-4 mb-4">
                    <div class="sm:col-span-3">
                        <p class="text-xs font-semibold uppercase text-gray-500">Address</p>
                        <p class="text-sm text-gray-900">
                            {{ $report->submittedReport->purok ? $report->submittedReport->purok . ', ' : '' }}
                            {{ $report->submittedReport->street_name ? $report->submittedReport->street_name . ', ' : '' }}
                            {{ $report->submittedReport->barangay_name }}, {{ $report->submittedReport->city_name }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">Latitude</p>
                        <p class="text-sm text-gray-700">{{ $report->submittedReport->barangay_latitude }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">Longitude</p>
                        <p class="text-sm text-gray-700">{{ $report->submittedReport->barangay_longitude }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 border-t border-gray-100 pt-4">
                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">Resources Requested</p>
                        <p class="text-sm font-medium text-gray-900">
                            Police: {{ $report->submittedReport->police_car_request ?? 0 }},
                            Fire: {{ $report->submittedReport->fire_truck_request ?? 0 }},
                            Ambulance: {{ $report->submittedReport->ambulance_request ?? 0 }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">Report Source</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $report->submittedReport->reported_by }} (via {{ $report->submittedReport->from_agency }})
                        </p>
                    </div>
                </div>
            </div>

            @php
            $deployments = \App\Models\DeploymentList::where('submitted_report_id', $report->submitted_report_id)->get();
            @endphp


            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                <h4 class="text-sm font-bold text-gray-700 border-b border-gray-200 pb-2 mb-4">
                    Deployment Information
                </h4>

                <h4 class="text-sm font-bold text-gray-700 border-b border-gray-200 pb-2 mb-4">
                    Responder Deploy
                </h4>

                <div class="overflow-x-auto shadow-sm rounded-lg border border-gray-200 mb-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Gender
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Position
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact Number
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Timestamp
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($deployments as $deployment)
                            @if ($deployment->user_id !== null)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ asset('storage/' . $deployment->user->photo) }}"
                                        alt=""
                                        class="h-8 w-8 object-cover rounded bg-gray-200">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $deployment->user->firstname }} {{ $deployment->user->lastname }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $deployment->user->gender }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $deployment->user->position }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $deployment->user->contact_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $deployment->created_at->timezone('Asia/Manila')->format('F d Y, h:i A') }}
                                </td>
                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No responders deployed.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <h4 class="text-sm font-bold text-gray-700 border-b border-gray-200 pb-2 mb-4">
                    Emergency Vehicle Deploy
                </h4>

                <div class="overflow-x-auto shadow-sm rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Vehicle Type
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Plate Number
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Timestamp
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($deployments as $deployment)
                            @if ($deployment->emergency_vehicle_id !== null)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ asset('storage/' . $deployment->emergencyVehicle->vehicle_photo) }}"
                                        alt=""
                                        class="h-8 w-8 object-cover rounded bg-gray-200">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $deployment->emergencyVehicle->vehicleTypes ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $deployment->emergencyVehicle->plateNumber ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $deployment->created_at->timezone('Asia/Manila')->format('F d Y, h:i A') }}
                                </td>
                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No emergency vehicles deployed.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>

<style>
    .map-container {
        height: 400px;
        width: 100%;
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .pulse-wrapper {
        position: relative;
        width: 36px;
        height: 36px;
    }

    .pulse-ring {
        position: absolute;
        left: 50%;
        top: 50%;
        width: 36px;
        height: 36px;
        margin-left: -18px;
        margin-top: -18px;
        border-radius: 50%;
        background: rgba(255, 0, 0, 0.25);
        animation: pulseRing 1.8s infinite ease-out;
    }

    .pulse-core {
        position: absolute;
        left: 50%;
        top: 50%;
        width: 16px;
        height: 16px;
        margin-left: -8px;
        margin-top: -8px;
        border-radius: 50%;
        background: #dc2626;
        border: 2px solid #fff;
        z-index: 2;
        animation: coreBounce 1.8s infinite ease;
    }

    @keyframes pulseRing {
        0% {
            transform: scale(0.7);
            opacity: 0.9;
        }

        60% {
            transform: scale(1.7);
            opacity: 0;
        }

        100% {
            transform: scale(1.7);
            opacity: 0;
        }
    }

    @keyframes coreBounce {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.15);
        }

        100% {
            transform: scale(1);
        }
    }

    .travel-time {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        color: white;
        background: #2563eb;
        padding: 10px 14px;
        border-radius: 12px;
        font-weight: 600;
        opacity: 0;
        transform: translateY(8px);
        transition: opacity 350ms ease, transform 350ms ease;
        z-index: 9999;
    }

    .travel-time.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<script>
    let mapInstance = null;
    let travelTimeHtml = '';

    document.querySelector('[data-modal-toggle="report-modal"]').addEventListener('click', () => {
        setTimeout(initMap, 300); // wait for modal to animate in
    });

    function initMap() {
        const mapEl = document.getElementById('modal-map');
        const travelTimeEl = document.getElementById('modal-travel-time');

        const agencyLat = parseFloat('{{ auth()->user()->agency->latitude ?? 0 }}');
        const agencyLng = parseFloat('{{ auth()->user()->agency->longitude ?? 0 }}');
        const incidentLat = parseFloat('{{ $report->submittedReport->barangay_latitude ?? 0 }}');
        const incidentLng = parseFloat('{{ $report->submittedReport->barangay_longitude ?? 0 }}');

        if (!mapInstance) {
            mapInstance = L.map(mapEl).setView([agencyLat, agencyLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(mapInstance);

            if (agencyLat && agencyLng)
                L.marker([agencyLat, agencyLng]).addTo(mapInstance).bindPopup('Agency Location');

            if (incidentLat && incidentLng) {
                const pulseHtml = `<div class="pulse-wrapper"><div class="pulse-ring"></div><div class="pulse-core"></div></div>`;
                const pulseIcon = L.divIcon({
                    html: pulseHtml,
                    className: '',
                    iconSize: [36, 36],
                    iconAnchor: [18, 18]
                });
                L.marker([incidentLat, incidentLng], {
                    icon: pulseIcon
                }).addTo(mapInstance).bindPopup('Incident Location');
            }

            if (agencyLat && agencyLng && incidentLat && incidentLng) {
                const control = L.Routing.control({
                    waypoints: [L.latLng(agencyLat, agencyLng), L.latLng(incidentLat, incidentLng)],
                    routeWhileDragging: false,
                    addWaypoints: false,
                    draggableWaypoints: false,
                    show: false,
                    lineOptions: {
                        styles: [{
                            color: '#2563eb',
                            opacity: 0.9,
                            weight: 6
                        }]
                    },
                    createMarker: (i, wp) => L.marker(wp.latLng).bindPopup(i === 0 ? 'Agency Location' : 'Incident Location')
                }).addTo(mapInstance);

                control.on('routesfound', e => {
                    const route = e.routes[0];
                    const totalSeconds = Math.max(0, route.summary.totalTime || 0);
                    let minutes = Math.round(totalSeconds / 60);
                    if (minutes <= 0 && totalSeconds > 0) minutes = 1;

                    travelTimeHtml = `<div class="travel-time show"><span style="font-size:18px;">🚗</span><span>Estimated Travel Time: <strong>${minutes} min</strong></span></div>`;
                    travelTimeEl.innerHTML = travelTimeHtml;
                });
            }
        } else {
            travelTimeEl.innerHTML = travelTimeHtml;
            setTimeout(() => mapInstance.invalidateSize(), 200);
        }
    }
</script>