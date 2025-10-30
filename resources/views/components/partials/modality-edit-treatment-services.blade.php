<!-- 🟡 Edit Service Button -->
<button onclick="toggleEditServiceModal('{{ $service->id }}', true)"
    class="px-3 py-1.5 rounded-lg text-[12px] font-[Poppins] font-semibold bg-yellow-600 text-white hover:bg-yellow-700 transition">
    Edit
</button>

<!-- ✏️ Edit Service Modal -->
<div id="editServiceModal-{{ $service->id }}"
    class="fixed inset-0 backdrop-blur-sm bg-black/50 flex items-center justify-center hidden z-50 transition">
    <div id="editServiceModalBox-{{ $service->id }}"
        class="bg-white w-[90%] sm:w-full sm:max-w-lg rounded-2xl shadow-2xl p-6 sm:p-8 animate-fadeIn relative mx-2 border border-gray-200">

        <!-- Close Button -->
        <button onclick="toggleEditServiceModal('{{ $service->id }}', false)"
            class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 text-[20px] font-bold">&times;</button>

        <!-- Header -->
        <div class="text-center mb-6">
            <h3 class="text-[16px] font-[Poppins] font-semibold text-gray-800">Edit Service</h3>
            <p class="text-[12px] font-[Roboto] text-gray-500 mt-1">Update the details of this treatment service below.</p>
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

        <!-- Edit Service Form -->
        <form action="{{ route('nurse-chief.edit-services', $service->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <!-- Service Name -->
                <div>
                    <label class="block text-start text-[12px] font-[Poppins] text-gray-700 mb-1">Service Name</label>
                    <input type="text" name="serviceName" value="{{ $service->serviceName }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-[12px] font-[Roboto]
                        focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Enter service name" required>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-start text-[12px] font-[Poppins] text-gray-700 mb-1">Category</label>
                    <select name="category"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-[12px] font-[Roboto]
                        focus:ring-2 focus:ring-blue-600 focus:border-blue-600" required>
                        <option value="Medical" {{ $service->category == 'Medical' ? 'selected' : '' }}>Medical</option>
                        <option value="Therapy" {{ $service->category == 'Therapy' ? 'selected' : '' }}>Therapy</option>
                        <option value="Rehabilitation" {{ $service->category == 'Rehabilitation' ? 'selected' : '' }}>Rehabilitation</option>
                        <option value="Other" {{ $service->category == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="flex gap-2 justify-start">
                    <label for="">Last Updated At :</label>
                    <span>{{ $service->updated_at->timezone('Asia/Manila')->format('F j Y, g:ia') }}</span>
                </div>

                <!-- Service Availability -->
                <input type="hidden" name="serviceAvailability" value="{{ $service->serviceAvailability }}">
                <input type="hidden" name="agency_id" value="{{ auth()->user()->agency_id }}">
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                <button type="button" onclick="toggleEditServiceModal('{{ $service->id }}', false)"
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
    function toggleEditServiceModal(id, show) {
        const modal = document.getElementById(`editServiceModal-${id}`);
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
</script>