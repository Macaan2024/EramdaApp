<!-- 🟡 Edit Button -->
<button onclick="toggleEditBedModal('{{ $bed->id }}', true)"
    class="px-3 py-1.5 rounded-lg text-[12px] font-[Poppins] font-semibold bg-yellow-600 text-white hover:bg-yellow-700 transition">
    Edit
</button>

<!-- ✏️ Edit Bed Modal -->
<div id="editBedModal-{{ $bed->id }}"
    class="fixed inset-0 backdrop-blur-sm bg-black/50 flex items-center justify-center hidden z-50 transition">
    <div id="editBedModalBox-{{ $bed->id }}"
        class="bg-white w-[90%] sm:w-full sm:max-w-lg rounded-2xl shadow-2xl p-6 sm:p-8 animate-fadeIn relative mx-2 border border-gray-200">

        <!-- Close Button -->
        <button onclick="toggleEditBedModal('{{ $bed->id }}', false)"
            class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 text-[20px] font-bold">&times;</button>

        <!-- Header -->
        <div class="text-center mb-6">
            <h3 class="text-[16px] font-[Poppins] font-semibold text-gray-800">Edit Bed</h3>
            <p class="text-[12px] font-[Roboto] text-gray-500 mt-1">Update the details of this bed below.</p>
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

        <!-- Edit Bed Form -->
        <form action="{{ route('nurse-chief.edit-bed', $bed->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <!-- Room Number -->
                <div>
                    <label class="block text-start text-start text-[12px] font-[Poppins] text-gray-700 mb-1">Room Number</label>
                    <input type="number" name="room_number" value="{{ $bed->room_number }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-[12px] font-[Roboto]
                        focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Enter Room Number">
                </div>

                <!-- Bed Type -->
                <div>
                    <label class="block text-start text-[12px] font-[Poppins] text-gray-700 mb-1">Bed Type</label>
                    <select name="bed_type"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-[12px] font-[Roboto]
                        focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        <option value="private" {{ $bed->bed_type == 'private' ? 'selected' : '' }}>Private</option>
                        <option value="ward" {{ $bed->bed_type == 'ward' ? 'selected' : '' }}>Ward</option>
                        <option value="icu" {{ $bed->bed_type == 'icu' ? 'selected' : '' }}>ICU</option>
                    </select>
                </div>

                <!-- Bed Number -->
                <div>
                    <label class="block text-start text-[12px] font-[Poppins] text-gray-700 mb-1">Bed Number</label>
                    <input type="number" name="bed_number" value="{{ $bed->bed_number }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-[12px] font-[Roboto]
                        focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Enter Bed Number">
                </div>

                <input type="hidden" name="availabilityStatus" value="Available">

                <input type="hidden" name="agency_id" value="{{ auth()->user()->agency_id }}">
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                <button type="button" onclick="toggleEditBedModal('{{ $bed->id }}', false)"
                    class="px-4 py-2 rounded-lg text-[12px] font-[Poppins] bg-gray-300 hover:bg-gray-400 text-gray-800 transition w-full sm:w-auto">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-lg text-[12px] font-[Poppins] bg-blue-600 hover:bg-blue-700 text-white shadow-md transition w-full sm:w-auto">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Script -->
<script>
    function toggleEditBedModal(id, show) {
        const modal = document.getElementById(`editBedModal-${id}`);
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
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