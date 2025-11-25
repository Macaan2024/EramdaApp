<!-- ✏️ Add Vehicle Button -->
<button onclick="toggleAddVehicleModal(true)"
    class="bg-blue-600 hover:bg-blue-800 
           text-white text-[13px] font-[Poppins] rounded-xl px-6 py-2.5 shadow-md 
           transition-transform">
    Add Vehicle
</button>

<div id="addVehicleModal"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center 
           z-50 hidden transition-all duration-300 ease-in-out">

    <div id="addVehicleModalBox"
        class="relative bg-white rounded-2xl shadow-2xl 
               w-[90%] sm:w-[80%] md:w-[50%] lg:w-[35%] 
               max-h-[90vh] flex flex-col transform scale-95 opacity-0 
               transition-all duration-300 ease-in-out border border-gray-200 overflow-hidden">

        <div class="flex justify-between items-center bg-blue-800 border-b border-gray-200 px-4 py-2">
            <h2 class="text-[16px] font-medium text-white font-[Poppins] tracking-wide">
                Add New Emergency Vehicle
            </h2>
            <button onclick="toggleAddVehicleModal(false)"
                class="text-white hover:text-blue-300 text-3xl font-bold transition-transform transform hover:rotate-90">
                &times;
            </button>
        </div>

        <div class="p-6 font-[Roboto] text-[13px] text-gray-700 space-y-5 overflow-y-auto max-h-[80vh] pr-2">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                <h2 class="text-[14px] font-semibold text-blue-700 mb-1">Vehicle Registration</h2>
                <p class="text-gray-700 text-[12px] leading-relaxed">
                    This form is used to register a new <b>emergency vehicle</b> (e.g., ambulance, fire truck, rescue vehicle)
                    into the system. Please provide the correct <b>Agency</b>, <b>Vehicle Type</b>, and <b>Plate Number</b>.
                    The initial status will be set to <b>'Available'</b>.
                </p>
            </div>

            <form action="{{ route('operation-officer.submit-vehicle') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="availabilityStatus" value="Available">

                <h3 class="text-[15px] font-[Poppins] font-semibold text-blue-700 border-l-4 border-blue-500 pl-2">
                    Vehicle Information
                </h3>

                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Assigned Agency</label>

                    @if (auth()->user()->user_type !== 'admin')
                        <input type="text" disabled value="{{ auth()->user()->agency->agencyNames }}" class="w-full rounded-lg px-3 py-2 bg-gray-100 text-[12px]">
                        <input type="hidden" name="agency_id" value="{{ auth()->user()->agency->id }}">
                    @else
                        <select name="agency_id"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]
                                   focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none bg-white shadow-sm transition" required>
                            <option disabled selected>Choose Agency</option>
                            @forelse ($agencies as $agency)
                                <option value="{{ $agency->id }}">{{ $agency->agencyNames }}</option>
                            @empty
                                <option disabled>No agencies available</option>
                            @endforelse
                        </select>
                    @endif
                </div>

                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Vehicle Type</label>
                    <select name="vehicleTypes"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]
                               focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none bg-white shadow-sm transition" required>
                        <option disabled selected>Select Vehicle Type</option>
                        <option value="Ambulance">Ambulance</option>
                        <option value="Fire Truck">Fire Truck</option>
                        <option value="Police Car">Police Patrol</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Plate Number (Must be unique)</label>
                    <input type="text" name="plateNumber" placeholder="ABC 1234"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]
                               focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none bg-white shadow-sm" required>
                </div>

                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Upload Vehicle Photo (Optional)</label>
                    <input type="file" name="vehicle_photo" id="vehiclePhotoUpload"
                        class="w-full border border-gray-300 rounded-lg cursor-pointer text-[13px] font-[Roboto]
                               bg-white shadow-sm hover:border-blue-400 transition">

                    <div class="mt-4 flex justify-start">
                        <img id="vehiclePhotoPreview" src="" alt="Photo preview"
                            class="hidden w-36 h-28 object-cover rounded-md border-2 border-blue-400 shadow-lg transition-all duration-300">
                    </div>
                </div>

                <button type="submit"
                    class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 
                           font-[Poppins] font-medium rounded-lg px-5 py-2.5 transition transform hover:scale-105 
                           text-[13px] shadow-md">
                    Register Vehicle
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function toggleAddVehicleModal(show) {
    const modal = document.getElementById('addVehicleModal');
    const box = document.getElementById('addVehicleModalBox');

    if (show) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 50);
    } else {
        box.classList.add('scale-95', 'opacity-0');
        box.classList.remove('scale-100', 'opacity-100');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }
}

// Close modal when clicking outside
document.getElementById('addVehicleModal').addEventListener('click', function(e) {
    if (e.target === this) toggleAddVehicleModal(false);
});

// Photo preview
document.getElementById('vehiclePhotoUpload')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const preview = document.getElementById('vehiclePhotoPreview');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
});
</script>
