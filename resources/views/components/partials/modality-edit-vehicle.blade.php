<!-- 🟡 Edit Vehicle Button -->
<button onclick="toggleEditVehicleModal('{{ $vehicle->id }}', true)"
    class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1.5 rounded-sm text-[12px] font-[Poppins]">
    Edit
</button>

@if($vehicle && $vehicle->id)
<div id="editVehicleModal-{{ $vehicle->id }}"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-all duration-300 ease-in-out">

    <div id="editVehicleModalBox-{{ $vehicle->id }}"
        class="relative bg-white rounded-2xl shadow-2xl w-[90%] sm:w-[80%] md:w-[55%] lg:w-[40%] max-h-[90vh] transform scale-95 opacity-0 transition-all duration-300 ease-in-out border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="flex justify-between items-center bg-blue-800 border-b border-gray-200 px-4 py-2 rounded-t-2xl">
            <h2 class="text-[16px] text-white font-medium font-[Poppins] tracking-wide">
                Edit Vehicle Details
            </h2>
            <button onclick="toggleEditVehicleModal('{{ $vehicle->id }}', false)"
                class="text-white hover:text-blue-300 text-3xl font-bold transition-transform transform hover:rotate-90">
                &times;
            </button>
        </div>

        <!-- Scrollable Form -->
        <div class="scrollbar-container p-6 font-[Roboto] text-[13px] text-gray-700 space-y-5 overflow-y-auto max-h-[80vh]">

            <!-- Intro -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                <h2 class="text-[14px] font-semibold text-blue-700 mb-1 text-left">Vehicle Update Form</h2>
                <p class="text-gray-700 text-[12px] text-wrap text-left">
                    Update the details of this emergency vehicle. Make sure all information such as agency, type, and plate number are correct.
                </p>
            </div>

            <form action="{{ route('operation-officer.update-vehicle', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="availabilityStatus" value="Available">
                <input type="hidden" name="agency_id" value="{{ auth()->user()->agency_id }}">

                <h3 class="text-[15px] font-[Poppins] font-semibold text-blue-700 border-l-4 border-blue-500 pl-2 my-6 text-left">
                    Vehicle Information
                </h3>

                <!-- Agency -->
                <div>
                    <label class="block text-gray-800 mb-2 font-[Poppins] text-left">Assigned Agency</label>
                    <input type="text" disabled value="{{ auth()->user()->agency->agencyNames }}"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto] bg-gray-100">
                </div>

                <!-- Vehicle Type -->
                <div class="mt-4">
                    <label class="block text-gray-800 mb-2 font-[Poppins] text-left">Vehicle Type</label>
                    <select name="vehicleTypes" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]" required>
                        <option value="Ambulance" {{ $vehicle->vehicleTypes == 'Ambulance' ? 'selected' : '' }}>Ambulance</option>
                        <option value="Fire Truck" {{ $vehicle->vehicleTypes == 'Fire Truck' ? 'selected' : '' }}>Fire Truck</option>
                        <option value="Police Patrol" {{ $vehicle->vehicleTypes == 'Police Patrol' ? 'selected' : '' }}>Police Patrol</option>
                        <option value="Boat" {{ $vehicle->vehicleTypes == 'Boat' ? 'selected' : '' }}>Boat</option>
                    </select>
                </div>

                <!-- Plate Number -->
                <div class="mt-4">
                    <label class="block text-gray-800 mb-2 text-left font-[Poppins]">Plate Number</label>
                    <input type="text" name="plateNumber" value="{{ old('plateNumber', $vehicle->plateNumber) }}"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]" required>
                </div>

                <!-- Photo -->
                <div class="mt-4">
                    <label class="block text-gray-800 mb-2 text-left font-[Poppins]">Vehicle Photo</label>
                    <input type="file" name="vehicle_photo" id="vehiclePhotoUpload-{{ $vehicle->id }}"
                        class="w-full border border-gray-300 rounded-lg cursor-pointer text-[13px] font-[Roboto] bg-white shadow-sm">

                    <div class="my-4 flex justify-start">
                        <img id="vehiclePhotoPreview-{{ $vehicle->id }}"
                            src="{{ $vehicle->vehicle_photo ? asset('storage/' . $vehicle->vehicle_photo) : '' }}"
                            alt="Vehicle Photo"
                            class="w-36 h-28 object-cover rounded-md border-2 border-blue-400 shadow-lg {{ $vehicle->vehicle_photo ? '' : 'hidden' }}">
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full text-white bg-green-600 hover:bg-blue-800 font-[Poppins] rounded-lg px-5 py-2.5 text-[13px]">
                    Update Vehicle
                </button>
            </form>
        </div>
    </div>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const upload = document.getElementById(`vehiclePhotoUpload-{{ $vehicle->id }}`);
        const preview = document.getElementById(`vehiclePhotoPreview-{{ $vehicle->id }}`);

        if (upload) {
            upload.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    preview.src = URL.createObjectURL(file);
                    preview.classList.remove('hidden');
                }
            });
        }
    });

    function toggleEditVehicleModal(id, show) {
        const modal = document.getElementById(`editVehicleModal-${id}`);
        const box = document.getElementById(`editVehicleModalBox-${id}`);

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
</script>

<style>
    .scrollbar-container {
        scrollbar-gutter: stable both-edges;
        border-radius: 1rem;
    }

    .scrollbar-container::-webkit-scrollbar {
        width: 8px;
    }

    .scrollbar-container::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    .scrollbar-container::-webkit-scrollbar-track {
        background: transparent;
    }
</style>