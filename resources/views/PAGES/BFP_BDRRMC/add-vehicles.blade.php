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
        action="{{ route('bfp.submit-vehicles') }}" method="POST" enctype="multipart/form-data">

        @csrf
        <input type="hidden" name="agency_id" value="{{ auth()->user()->agency_id }}">
        <input type="hidden" name="availabilityStatus" value="Available">

        <!-- Heading -->
        <div class="text-center">
            <h2 class="text-lg font-semibold text-gray-800 font-[Poppins]">Add Emergency Vehicle</h2>
            <p class="text-gray-500 text-[12px] font-[Poppins]">Fill in the details to register a new vehicle</p>
        </div>

        <!-- Grid fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Vehicle Type -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Vehicle Type</label>
                <select name="vehicleTypes"
                    class="w-full rounded-lg border @error('vehicleTypes') border-red-500 @else border-gray-300 @enderror
               px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500" required>
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
                           rounded-lg cursor-pointer text-[12px] font-[Poppins]">
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