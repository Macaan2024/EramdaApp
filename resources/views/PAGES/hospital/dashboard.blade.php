<x-layout.layout>

    <x-partials.toast-messages />

    <div class="p-6 bg-gray-100 min-h-screen font-['Roboto']">
        {{-- Header --}}
        <div class="bg-white p-6 rounded-xl shadow-lg mb-6 flex flex-row gap-4 items-center">
            <img src="{{ asset('storage/' . auth()->user()->agency->logo) }}"
                alt="Agency Image" class="w-16 h-16 rounded-full object-cover shadow-md border border-gray-100" />
            <div class="flex flex-col">
                <p class="text-lg font-[Poppins] font-bold text-gray-900">
                    {{ auth()->user()->agency->agencyNames }}
                </p>
                <p class="text-[12px] text-gray-500 font-[Roboto]">Bed Availability Dashboard</p>
            </div>
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
            {{-- Injury Status Chart --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-[Poppins] font-semibold text-gray-700 text-[14px] mb-4">Injury Status Monitoring</h3>
                <canvas id="injuryStatusChart" class="w-full h-64"></canvas>
            </div>

            {{-- Bed Type Chart --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-[Poppins] font-semibold text-gray-700 text-[14px] mb-4">Bed Type Overview</h3>
                <canvas id="bedTypeChart" class="w-full h-64"></canvas>
            </div>
        </div>


        {{-- Bed Summary Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            {{-- Private --}}
            <div
                class="bg-white border-t-4 border-blue-600 rounded-xl shadow-md p-3 sm:p-5 flex flex-col justify-between hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-700 font-[Poppins] font-semibold text-[12px] uppercase tracking-wider">PRIVATE BEDS</h3>
                    <span class="material-symbols-outlined text-blue-600 text-2xl sm:text-3xl">hotel</span>
                </div>
                <p class="text-3xl font-[Poppins] font-medium text-blue-600">{{ $privateBedTotals }}</p>
                <p class="text-[12px] text-gray-500 font-[Roboto]">Total Available Beds</p>
            </div>

            {{-- ICU --}}
            <div
                class="bg-white border-t-4 border-red-600 rounded-xl shadow-md p-3 sm:p-5 flex flex-col justify-between hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-700 font-[Poppins] font-semibold text-[12px] uppercase tracking-wider">ICU BEDS</h3>
                    <span class="material-symbols-outlined text-red-600 text-2xl sm:text-3xl">monitor_heart</span>
                </div>
                <p class="text-3xl font-[Poppins] font-medium text-red-600">{{ $icuBedTotals }}</p>
                <p class="text-[12px] text-gray-500 font-[Roboto]">Total Available Beds</p>
            </div>

            {{-- Ward --}}
            <div
                class="bg-white border-t-4 border-indigo-600 rounded-xl shadow-md p-3 sm:p-5 flex flex-col justify-between hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-700 font-[Poppins] font-semibold text-[12px] uppercase tracking-wider">WARD BEDS</h3>
                    <span class="material-symbols-outlined text-indigo-600 text-2xl sm:text-3xl">bed</span>
                </div>
                <p class="text-3xl font-[Poppins] font-medium text-indigo-600">{{ $wardenBedTotals }}</p>
                <p class="text-[12px] text-gray-500 font-[Roboto]">Total Available Beds</p>
            </div>

            {{-- Total --}}
            <div
                class="bg-white border-t-4 border-gray-400 rounded-xl shadow-md p-3 sm:p-5 flex flex-col justify-between hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-700 font-[Poppins] font-semibold text-[12px] uppercase tracking-wider">TOTAL BEDS</h3>
                    <span class="material-symbols-outlined text-gray-600 text-2xl sm:text-3xl">inventory_2</span>
                </div>
                <p class="text-3xl font-[Poppins] font-medium text-gray-600">
                    {{ $privateBedTotals + $icuBedTotals + $wardenBedTotals }}
                </p>
                <p class="text-[12px] text-gray-500 font-[Roboto]">Sum of all types</p>
            </div>
        </div>

        {{-- BED LIST --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            @foreach ($beds as $bed)
            @php
            $type = strtoupper($bed->bed_type);
            $isOccupied = $bed->availabilityStatus === 'Occupied';

            switch ($type) {
            case 'ICU':
            $color = 'red';
            $icon = 'monitor_heart';
            break;
            case 'PRIVATE':
            $color = 'yellow';
            $icon = 'person';
            break;
            case 'WARD':
            $color = 'blue';
            $icon = 'bed';
            break;
            default:
            $color = 'gray';
            $icon = 'help';
            }
            @endphp

            <div class="bg-white shadow-md rounded-xl p-4 flex flex-col items-center text-center
                    border-t-4 border-{{ $color }}-500 hover:shadow-xl hover:-translate-y-0.5 transition">
                <div class="w-12 h-12 flex items-center justify-center rounded-full mb-3
                        bg-{{ $color }}-100 text-{{ $color }}-600">
                    <span class="material-symbols-outlined text-3xl">{{ $icon }}</span>
                </div>

                <p class="font-[Poppins] font-medium text-gray-900 text-[14px] mb-1">Bed {{ $bed->bed_number }}</p>
                <p class="font-[Poppins] text-[10px] mb-2 px-2 py-0.5 rounded-full
                        bg-{{ $color }}-100 text-{{ $color }}-700 uppercase">{{ $type }}</p>
                <p class="text-[12px] text-gray-600 font-[Roboto] mb-3">Room {{ $bed->room_number }}</p>

                <div class="mt-auto w-full border-t border-gray-100 pt-3">
                    @if ($isOccupied)
                    <span class="block bg-red-100 text-red-700 font-medium px-3 py-1.5 rounded-lg text-[12px]">
                        OCCUPIED
                    </span>
                    @else
                    <button onclick="openModal({{ $bed->id }})"
                        class="w-full bg-blue-600 text-white px-3 py-2 rounded-lg text-[12px] font-medium hover:bg-blue-700 transition">
                        Add Patient
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- MODAL --}}
    <div id="bedModal"
        class="hidden fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 p-4">
        <div
            class="bg-white w-full max-w-xl rounded-xl shadow-2xl p-6 sm:p-8 animate-fadeIn relative border border-gray-200 overflow-y-auto max-h-[90vh]">

            {{-- Close --}}
            <button onclick="closeModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition text-2xl">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>

            {{-- Header --}}
            <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                <img src="{{ asset('storage/' . auth()->user()->agency->logo) }}"
                    class="w-14 h-14 rounded-full object-cover border border-gray-300 shadow-sm">
                <div>
                    <h2 class="font-[Poppins] font-bold text-[16px] text-gray-900">Assign Individual to Bed</h2>
                    <p class="text-[12px] text-gray-500 font-[Roboto]">{{ auth()->user()->agency->agencyNames }}</p>
                </div>
            </div>

            {{-- Bed Info --}}
            <div class="mb-6 text-sm text-gray-700 bg-blue-50 rounded-lg p-4 border border-blue-200 shadow-inner">
                <p class="text-[12px] font-semibold text-blue-800 uppercase mb-1">Selected Bed Details</p>
                <div class="text-gray-900 font-[Poppins] text-sm">
                    <p>Bed: <span id="modalBedNumber" class="font-semibold text-blue-800"></span></p>
                    <p>Type: <span id="modalBedType" class="font-semibold text-blue-800"></span></p>
                    <p>Room: <span id="modalRoomNumber" class="font-semibold text-blue-800"></span></p>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('nurse-chief.submit-admit') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="bed_id" id="modalBedId" value="{{ old('bed_id') }}">

                <p class="font-[Poppins] font-medium text-[14px] text-gray-800 border-b border-gray-100 pb-2 mb-2">
                    Patient Information
                </p>

                {{-- Name --}}
                <input type="text" name="individual_name" placeholder="Full Name"
                    value="{{ old('individual_name') }}"
                    class="w-full border border-gray-300 px-4 py-2.5 rounded-lg text-[14px] focus:ring-2 focus:ring-blue-500 outline-none" required>
                @error('individual_name') <p class="text-red-500 text-[12px]">{{ $message }}</p> @enderror

                {{-- Address --}}
                <input type="text" name="individual_address" placeholder="Address"
                    value="{{ old('individual_address') }}"
                    class="w-full border border-gray-300 px-4 py-2.5 rounded-lg text-[14px] focus:ring-2 focus:ring-blue-500 outline-none" required>
                @error('individual_address') <p class="text-red-500 text-[12px]">{{ $message }}</p> @enderror

                {{-- Sex / Contact --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="text-gray-700 font-medium mb-1 sm:mb-0">Choose Gender:</label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="individual_sex" value="Male"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500"
                            {{ old('individual_sex') == 'Male' ? 'checked' : '' }} required>
                        <span class="text-gray-700">Male</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="individual_sex" value="Female"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500"
                            {{ old('individual_sex') == 'Female' ? 'checked' : '' }} required>
                        <span class="text-gray-700">Female</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="individual_sex" value="Other"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500"
                            {{ old('individual_sex') == 'Other' ? 'checked' : '' }}>
                        <span class="text-gray-700">Other</span>
                    </label>


                    <input type="text" name="individual_contact_number" placeholder="Contact Number"
                        value="{{ old('individual_contact_number') }}"
                        class="w-full border border-gray-300 px-4 py-2.5 rounded-lg text-[14px] focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
                @error('individual_contact_number') <p class="text-red-500 text-[12px]">{{ $message }}</p> @enderror
                @error('individual_sex')
                <p class="text-red-500 text-[12px] mt-1">{{ $message }}</p>
                @enderror

                {{-- Injury Status --}}
                <select name="injury_status"
                    class="w-full border border-gray-300 px-4 py-2.5 rounded-lg text-[14px] focus:ring-2 focus:ring-blue-500 bg-white" required>
                    <option value="" disabled {{ old('injury_status') ? '' : 'selected' }}>Select Injury Status</option>
                    <option {{ old('injury_status') === 'Minor Injury' ? 'selected' : '' }}>Minor Injury</option>
                    <option {{ old('injury_status') === 'Serious Injury' ? 'selected' : '' }}>Serious Injury</option>
                    <option {{ old('injury_status') === 'Critical' ? 'selected' : '' }}>Critical</option>
                    <option {{ old('injury_status') === 'Deceased' ? 'selected' : '' }}>Deceased</option>
                </select>
                @error('injury_status') <p class="text-red-500 text-[12px]">{{ $message }}</p> @enderror

                {{-- Transportation --}}
                <select name="transportation_type"
                    class="w-full border border-gray-300 px-4 py-2.5 rounded-lg text-[14px] focus:ring-2 focus:ring-blue-500 bg-white" required>
                    <option value="" disabled {{ old('transportation_type') ? '' : 'selected' }}>Select Transportation Type</option>
                    <option {{ old('transportation_type') === 'Ambulance' ? 'selected' : '' }}>Ambulance</option>
                    <option {{ old('transportation_type') === 'Private Vehicle' ? 'selected' : '' }}>Private Vehicle</option>
                    <option {{ old('transportation_type') === 'Walk-in' ? 'selected' : '' }}>Walk-in</option>
                    <option {{ old('transportation_type') === 'Police Vehicle' ? 'selected' : '' }}>Police Vehicle</option>
                </select>

                {{-- Incident Role --}}
                <select name="incident_position"
                    class="w-full border border-gray-300 px-4 py-2.5 rounded-lg text-[14px] focus:ring-2 focus:ring-blue-500 bg-white" required>
                    <option value="" disabled {{ old('incident_position') ? '' : 'selected' }}>Select Role or Position</option>
                    <option {{ old('incident_position') === 'Driver' ? 'selected' : '' }}>Driver</option>
                    <option {{ old('incident_position') === 'Passenger' ? 'selected' : '' }}>Passenger</option>
                    <option {{ old('incident_position') === 'Pedestrian' ? 'selected' : '' }}>Pedestrian</option>
                    <option {{ old('incident_position') === 'Witness' ? 'selected' : '' }}>Witness</option>
                    <option {{ old('incident_position') === 'Evacuee' ? 'selected' : '' }}>Evacuee</option>
                </select>

                {{-- First Aid --}}
                <div class="flex items-center justify-between border border-gray-300 rounded-lg px-4 py-2.5 text-[14px]">
                    <label class="text-gray-700 font-[Roboto] font-medium">First Aid Applied?</label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-1.5">
                            <input type="radio" name="first_aid_applied" value="Yes" class="text-blue-600 w-4 h-4"
                                {{ old('first_aid_applied') === 'Yes' ? 'checked' : '' }} required>
                            <span>Yes</span>
                        </label>
                        <label class="flex items-center gap-1.5">
                            <input type="radio" name="first_aid_applied" value="No" class="text-blue-600 w-4 h-4"
                                {{ old('first_aid_applied') === 'No' ? 'checked' : '' }}>
                            <span>No</span>
                        </label>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-100 text-gray-700 font-[Poppins] px-5 py-2 rounded-lg hover:bg-gray-200 w-full sm:w-auto">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-blue-600 text-white font-[Poppins] px-5 py-2 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 w-full sm:w-auto">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>


 {{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const injuryStatusCtx = document.getElementById('injuryStatusChart').getContext('2d');
new Chart(injuryStatusCtx, {
    type: 'bar',
    data: {
        labels: @json($injuryStatusLabels),
        datasets: [{
            label: 'Number of Patients',
            data: @json($injuryStatusData),
            backgroundColor: ['#60A5FA','#F87171','#FBBF24','#6B7280']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});

const bedTypeCtx = document.getElementById('bedTypeChart').getContext('2d');
new Chart(bedTypeCtx, {
    type: 'doughnut',
    data: {
        labels: @json($bedTypeLabels),
        datasets: [{
            data: @json($bedTypeData),
            backgroundColor: ['#60A5FA','#F87171','#6366F1']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>

    {{-- Scripts --}}
    <script>
        const bedsData = @json($beds);

        function openModal(bedId) {
            const bed = bedsData.find(b => b.id === bedId);
            if (!bed) return console.error("Bed not found:", bedId);

            document.getElementById('modalBedNumber').innerText = bed.bed_number;
            document.getElementById('modalBedType').innerText = bed.bed_type;
            document.getElementById('modalRoomNumber').innerText = bed.room_number;
            document.getElementById('modalBedId').value = bed.id;

            document.getElementById('bedModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('bedModal').classList.add('hidden');
            document.body.style.overflow = '';
        }
    </script>

    {{-- Auto-open modal if validation failed --}}
    @if ($errors->any() && old('bed_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            openModal({
                {
                    (int) old('bed_id')
                }
            });
        });
    </script>
    @endif

    {{-- Fade-in animation --}}
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.25s ease-out;
        }
    </style>

</x-layout.layout>