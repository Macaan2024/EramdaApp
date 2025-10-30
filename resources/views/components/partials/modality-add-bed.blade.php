<button id="openAddBedModal"
    class="px-4 py-2 rounded-lg text-[12px] font-[Poppins] font-semibold bg-blue-600 text-white hover:bg-blue-700 transition">
    Add Bed
</button>


<!-- Add Bed Modal -->
<div id="addBedModal"
    class="fixed inset-0 backdrop-blur-sm bg-black/50 flex items-center justify-center hidden z-50 transition">
    <div
        class="bg-white w-[90%] sm:w-full sm:max-w-lg rounded-2xl shadow-2xl p-6 sm:p-8 animate-fadeIn relative mx-2">

        <!-- Close Button -->
        <button id="closeAddBedModal"
            class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 text-[20px] font-bold">&times;</button>

        <!-- Header -->
        <div class="text-center mb-6">
            <h3 class="text-[16px] font-[Poppins] font-semibold text-gray-800">Add New Bed</h3>
            <p class="text-[12px] font-[Roboto] text-gray-500 mt-1">Fill out the form below to register a new bed.</p>
        </div>

        <!-- Agency Info -->
        <div
            class="bg-gray-100 rounded-xl p-4 mb-6 flex flex-col sm:flex-row items-center sm:items-start sm:gap-4 text-center sm:text-left shadow-sm">
            <img src="{{ auth()->user()->agency->logo ? asset('storage/' . auth()->user()->agency->logo) : asset('images/default-logo.png') }}"
                alt="Agency Logo"
                class="w-16 h-16 rounded-full border border-gray-300 object-cover mb-3 sm:mb-0">
            <div>
                <h6 class="text-[14px] font-[Poppins] font-semibold text-gray-800">
                    {{ auth()->user()->agency->agencyNames }}
                </h6>
                <p class="text-[12px] font-[Roboto] text-gray-600">
                    {{ auth()->user()->agency->agencyTypes }}
                </p>
            </div>
        </div>

        <!-- Add Bed Form -->
        <form action="{{ route('nurse-chief.submit-bed') }}" method="POST">

            @csrf
            <div class="space-y-4">
                <!-- Room Number -->
                <div>
                    <label class="block text-[12px] font-[Poppins] text-gray-700 mb-1">Room Number</label>
                    <input type="number"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-[12px] font-[Roboto] focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                        placeholder="Enter Room Number" name="room_number">
                </div>
                @error('room_number')
                <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                @enderror

                <!-- Bed Type -->
                <div>
                    <label class="block text-[12px] font-[Poppins] text-gray-700 mb-1">Bed Type</label>
                    <select
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-[12px] font-[Roboto] focus:ring-2 focus:ring-blue-600 focus:border-blue-600" name="bed_type">
                        <option value="private">Private</option>
                        <option value="ward">Ward</option>
                        <option value="icu">ICU</option>
                    </select>
                </div>
                @error('bed_type')
                <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                @enderror

                <!-- Bed Number -->
                <div>
                    <label class="block text-[12px] font-[Poppins] text-gray-700 mb-1">Bed Number</label>
                    <input type="number"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-[12px] font-[Roboto] focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                        placeholder="Enter Bed Number" name="bed_number">
                </div>
                @error('bed_number')
                <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                @enderror

                <input type="hidden" name="agency_id" value="{{ auth()->user()->agency_id }}">
                <input type="hidden" name="availabilityStatus" value="Available">
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                <button type="button" id="cancelAddBedModal"
                    class="px-4 py-2 rounded-lg text-[12px] font-[Poppins] bg-gray-300 hover:bg-gray-400 text-gray-800 transition w-full sm:w-auto">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-lg text-[12px] font-[Poppins] bg-blue-600 hover:bg-blue-700 text-white shadow-md transition w-full sm:w-auto">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Script -->
<script>
    const openModalBtn = document.getElementById('openAddBedModal');
    const closeModalBtn = document.getElementById('closeAddBedModal');
    const cancelModalBtn = document.getElementById('cancelAddBedModal');
    const modal = document.getElementById('addBedModal');

    openModalBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    closeModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
    cancelModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.add('hidden');
    });
</script>

<!-- Smooth Fade Animation -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.96);
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