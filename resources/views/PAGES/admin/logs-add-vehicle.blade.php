<x-layout.layout>

    <x-partials.toast-messages />

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 text-[12px] font-[Poppins] px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form class="max-w-3xl mx-auto bg-gray-100 shadow-lg rounded-2xl p-8 space-y-6"
        action="{{ route('admin.logs-add-vehicles') }}" method="POST" enctype="multipart/form-data">

        @csrf
        <!-- Heading -->
        <div class="text-center">
            <h2 class="text-lg font-semibold text-gray-800 font-[Poppins]">Add Emergency Vehicle</h2>
            <p class="text-gray-500 text-[12px] font-[Poppins]">Fill in the details to register a new vehicle</p>
        </div>

        <!-- Grid fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Agency Select -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Agency</label>
                <select name="agency_id" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[12px] font-[Poppins] focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition cursor-pointer bg-white">
                    <option disabled selected>Choose Agency</option>
                    @forelse($agencies as $agency)
                        <option value="{{ $agency->id }}">{{ $agency->agencyNames }}</option>
                    @empty
                        <option disabled>No agencies found</option>
                    @endforelse
                </select>
            </div>

            <!-- Vehicle Type -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Vehicle Type</label>
                <select name="vehicleTypes" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[12px] font-[Poppins] focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition cursor-pointer bg-white">
                    <option disabled selected>Choose Vehicle Type</option>
                    <option value="Fire Truck">🚒 Fire Truck</option>
                    <option value="Ambulance">🚑 Ambulance</option>
                    @if (auth()->user()->agency->agencyTypes === 'CDRRMO')
                        <option value="Police Car">🚓 Police Car</option>
                    @endif
                </select>

                @error('vehicleTypes')
                <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Plate Number -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Plate Number</label>
                <input type="text" name="plateNumber" value="{{ old('plateNumber') }}"
                    class="w-full rounded-lg border @error('plateNumber') border-red-500 @else border-gray-300 @enderror
                           px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter plate number" required>
                @error('plateNumber')
                <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Vehicle Photo -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Upload Vehicle Photo</label>
                <input type="file" name="vehicle_photo"
                    class="w-full border @error('vehicle_photo') border-red-500 @else border-gray-300 @enderror
                           rounded-lg cursor-pointer text-[12px] font-[Poppins] bg-white">
                @error('vehicle_photo')
                <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror

                <!-- Preview -->
                <div class="mt-3 flex justify-start">
                    <img id="vehiclePhotoPreview" src="" alt="Preview will appear here"
                        class="hidden w-40 h-28 object-cover rounded-lg border-2 border-blue-400 shadow-md">
                </div>
            </div>
        </div>

        <input type="hidden" name="availabilityStatus" value="Available">
        <!-- Submit Button -->
        <button type="submit"
            class="w-full mt-4 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300
                   font-medium rounded-lg px-5 py-2.5 transition text-[12px] font-[Poppins]">
            Submit Vehicle
        </button>
    </form>

    <x-partials.stack-js />

    <!-- Script for preview -->
    <script>
        const vehicleInput = document.querySelector('input[name="vehicle_photo"]');
        const vehiclePreview = document.getElementById('vehiclePhotoPreview');

        vehicleInput?.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    vehiclePreview.src = ev.target.result;
                    vehiclePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-layout.layout>
