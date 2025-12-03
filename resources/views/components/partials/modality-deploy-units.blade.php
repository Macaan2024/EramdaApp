<button data-modal-target="deploy-modal-{{ $report->id }}" data-modal-toggle="deploy-modal-{{ $report->id }}"
    class="bg-gray-600 py-1 px-3 rounded-sm text-white">
    Accept
</button>
<div id="deploy-modal-{{ $report->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full md:inset-0 max-h-full">

    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-xl shadow-2xl p-6 border border-gray-100">

            <div class="flex items-center justify-between border-b pb-4 mb-4">
                <h3 class="text-xl font-extrabold text-blue-700">Units Deployment</h3>

                <button type="button"
                    class="text-gray-500 bg-transparent hover:bg-red-100 hover:text-red-600 rounded-full text-lg w-8 h-8 flex justify-center items-center transition-colors"
                    data-modal-hide="deploy-modal-{{ $report->id }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="py-2 space-y-6">

                {{-- REQUESTED UNITS SUMMARY --}}
                <div id="requested-units-summary">
                    <h4 class="text-sm font-bold text-blue-700 mb-3">Requested Units</h4>

                    <ul class="flex flex-col items-start gap-2 text-start">

                        <li class="bg-blue-100 py-2 px-4 rounded-md w-full"
                            data-vehicle-type="Police Car"
                            data-request-count="{{ $report->submittedReport->police_car_request ?? 0 }}">
                            🚓 Police Cars: {{ $report->submittedReport->police_car_request ?? 0 }}
                        </li>

                        <li class="bg-blue-100 py-2 px-4 rounded-md w-full"
                            data-vehicle-type="Fire Truck"
                            data-request-count="{{ $report->submittedReport->fire_truck_request ?? 0 }}">
                            🚒 Fire Trucks: {{ $report->submittedReport->fire_truck_request ?? 0 }}
                        </li>

                        <li class="bg-blue-100 py-2 px-4 rounded-md w-full"
                            data-vehicle-type="Ambulance"
                            data-request-count="{{ $report->submittedReport->ambulance_request ?? 0 }}">
                            🚑 Ambulances: {{ $report->submittedReport->ambulance_request ?? 0 }}
                        </li>

                    </ul>
                </div>

                @php
                use App\Models\EmergencyVehicle;
                use App\Models\User;

                $agencyId = auth()->user()->agency_id;

                $vehicles = EmergencyVehicle::where('agency_id', $agencyId)->get();
                $responders = User::where('agency_id', $agencyId)
                ->where('user_type', 'responder')
                ->get();
                @endphp

                <form action="{{ route('operation-officer.submit-deploy', $report->submitted_report_id) }}" method="POST">
                    @csrf

                    {{-- VEHICLE SELECTION --}}
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-sm font-bold text-gray-700">Select Vehicles</h4>
                            <h4 class="text-sm font-bold text-gray-700">
                                Total Selected: <span id="total-vehicles-selected-{{ $report->id }}">0</span>
                            </h4>
                        </div>

                        <p id="no-vehicles-msg-{{ $report->id }}" class="text-red-600 font-semibold hidden mb-2"></p>

                        @foreach ($vehicles as $vehicle)
                        <div class="flex items-center gap-3 p-2 border rounded-md mb-1
                            {{ $vehicle->availabilityStatus === 'Unavailable' ? 'bg-red-100' : 'bg-green-100' }}">

                            <input type="checkbox"
                                name="vehicles[]"
                                class="vehicle-checkbox-{{ $report->id }} h-4 w-4"
                                data-type="{{ $vehicle->vehicleTypes }}"
                                data-status="{{ $vehicle->availabilityStatus }}"
                                value="{{ $vehicle->id }}"
                                {{ $vehicle->availabilityStatus === 'Unavailable' ? 'disabled' : '' }}>

                            <label class="text-sm">
                                {{ $vehicle->vehicleTypes }} — {{ $vehicle->plateNumber }}
                                ({{ $vehicle->availabilityStatus }})
                            </label>
                        </div>
                        @endforeach
                    </div>

                    {{-- RESPONDER SELECTION --}}
                    <div class="mt-4">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-sm font-bold text-gray-700">Select Responders</h4>
                            <h4 class="text-sm font-bold text-gray-700">
                                Total Selected: <span id="total-responders-selected-{{ $report->id }}">0</span>
                            </h4>
                        </div>

                        @foreach ($responders as $responder)
                        <div class="flex items-center gap-3 p-2 border rounded-md mb-1
                            {{ $responder->availability_status === 'Unavailable' ? 'bg-red-100' : 'bg-green-100' }}">

                            <input type="checkbox"
                                name="responders[]"
                                class="responder-checkbox-{{ $report->id }} h-4 w-4"
                                data-status="{{ $responder->availability_status }}"
                                value="{{ $responder->id }}"
                                {{ $responder->availability_status === 'Unavailable' ? 'disabled' : '' }}>

                            <label class="text-sm">
                                {{ $responder->firstname }} {{ $responder->lastname }}
                                ({{ $responder->availability_status }})
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end mt-4 pt-4 border-t">
                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                            Deploy Units
                        </button>

                        <button type="button"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 ml-2"
                            data-modal-hide="deploy-modal-{{ $report->id }}">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


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
    // We wrap the logic in a block to prevent variable name collisions 
    // when this script is rendered inside a loop.
    {
        const modalId = "{{ $report->id }}";

        document.addEventListener("DOMContentLoaded", function() {
            // Select elements specifically for THIS modal using the unique ID
            const vehicleCheckboxes = document.querySelectorAll(`.vehicle-checkbox-${modalId}`);
            const responderCheckboxes = document.querySelectorAll(`.responder-checkbox-${modalId}`);
            const vehicleTotal = document.getElementById(`total-vehicles-selected-${modalId}`);
            const responderTotal = document.getElementById(`total-responders-selected-${modalId}`);
            const noVehiclesMsg = document.getElementById(`no-vehicles-msg-${modalId}`);

            // Ensure we are getting clean numbers
            const requests = {
                "Police Car": parseInt("{{ $report->submittedReport->police_car_request ?? 0 }}"),
                "Fire Truck": parseInt("{{ $report->submittedReport->fire_truck_request ?? 0 }}"),
                "Ambulance": parseInt("{{ $report->submittedReport->ambulance_request ?? 0 }}"),
            };

            // Group vehicles by type
            const grouped = {
                "Police Car": [],
                "Fire Truck": [],
                "Ambulance": []
            };

            vehicleCheckboxes.forEach(cb => {
                let type = cb.dataset.type;
                if (grouped[type]) grouped[type].push(cb);
            });

            // CHECK IF NO AVAILABLE VEHICLES
            let unavailableTypes = [];
            for (let type in grouped) {
                if (requests[type] > 0) {
                    const available = grouped[type].filter(v => v.dataset.status !== "Unavailable");
                    if (available.length === 0) {
                        unavailableTypes.push(type);
                    }
                }
            }

            if (unavailableTypes.length > 0 && noVehiclesMsg) {
                noVehiclesMsg.classList.remove("hidden");
                noVehiclesMsg.textContent = "No available vehicles for: " + unavailableTypes.join(", ");
            }

            // LIMIT SELECTION PER VEHICLE TYPE
            function enforceVehicleRules() {
                let total = 0;

                for (let type in grouped) {
                    const req = requests[type];
                    const list = grouped[type];

                    // Count how many are CURRENTLY checked
                    const checked = list.filter(v => v.checked);
                    total += checked.length;

                    list.forEach(v => {
                        if (v.dataset.status === "Unavailable") {
                            v.disabled = true;
                        } else if (!v.checked && checked.length >= req) {
                            // If not checked, and we reached the limit, disable it
                            v.disabled = true;
                        } else {
                            // Otherwise it's free to be toggled
                            v.disabled = false;
                        }
                    });
                }

                if (vehicleTotal) vehicleTotal.textContent = total;
            }

            // Attach event listeners
            vehicleCheckboxes.forEach(cb => cb.addEventListener("change", enforceVehicleRules));
            // Run once on load to set initial state
            enforceVehicleRules();

            // RESPONDERS LOGIC
            function enforceResponderRules() {
                let total = 0;
                responderCheckboxes.forEach(cb => {
                    if (cb.dataset.status === "Unavailable") {
                        cb.disabled = true;
                    }
                    if (cb.checked) total++;
                });
                if (responderTotal) responderTotal.textContent = total;
            }

            responderCheckboxes.forEach(cb => cb.addEventListener("change", enforceResponderRules));
            enforceResponderRules();
        });
    }
</script>