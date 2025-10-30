<!-- Button to Open Modal -->
<button onclick="togglePatientModal(true)"
    class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold text-sm hover:bg-blue-700 transition">
    Add Patient
</button>

<!-- Modal -->
<div id="patientModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-xl shadow-lg p-6 relative">
        <!-- Close Button -->
        <button onclick="togglePatientModal(false)"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            ✕
        </button>

        <!-- Header -->
        <div class="flex items-center gap-3 mb-5 border-b pb-3">
            <img src="{{ asset('storage/' . auth()->user()->agency->logo) }}"
                alt="Agency Logo" class="w-12 h-12 rounded-full object-cover border border-gray-300">
            <div>
                <p class="text-base font-bold text-gray-800">{{ auth()->user()->agency->agencyNames }}</p>
                <p class="text-xs text-gray-500">Add Individual Record</p>
            </div>
        </div>

        <!-- Form -->
        <form action="#" method="POST" class="space-y-4 text-sm">
            @csrf
            <div>
                <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                <input type="text" name="individual_name" placeholder="Enter full name"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 outline-none">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Address</label>
                <input type="text" name="individual_address" placeholder="Enter address"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 outline-none">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Sex</label>
                <select name="individual_sex"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 outline-none bg-white">
                    <option value="" disabled selected>Select sex</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Contact Number</label>
                <input type="text" name="individual_contact_number" placeholder="09XXXXXXXXX"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 outline-none">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Injury Status</label>
                <input type="text" name="injury_status" placeholder="e.g. Minor Injury, Critical"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 outline-none">
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 pt-3 border-t">
                <button type="button" onclick="togglePatientModal(false)"
                    class="px-4 py-2 text-sm rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePatientModal(show) {
        const modal = document.getElementById('patientModal');
        if (show) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }
</script>
