<x-layout.layout>
    <form class="max-w-3xl mx-auto bg-gray-100 shadow-lg rounded-2xl p-8 space-y-6"
        action="{{ route('bfp.submit-reports') }}"
        method="POST">
        @csrf

        <div class="text-center">
            <h2 class="text-lg font-semibold text-gray-800 font-[Poppins]">Submit Emergency Report</h2>
            <p class="text-gray-500 text-[12px] font-[Poppins]">Fill in the details about the emergency incident</p>
        </div>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 text-[12px] font-[Poppins] px-4 py-3 rounded relative">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Incident Type -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Incident Type</label>
                <select name="incident_types_id" required
                    class="w-full rounded-lg border @error('incident_types_id') border-red-500 @else border-gray-300 @enderror">
                    <option value="">-- Select Incident --</option>
                    @foreach ($incidentTypes as $incident)
                    <option value="{{ $incident->id }}" {{ old('incident_types_id') == $incident->id ? 'selected' : '' }}>
                        {{ $incident->incident_name }}
                    </option>
                    @endforeach
                </select>
                @error('incident_types_id')
                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Description</label>
                <textarea name="description" rows="3"
                    class="w-full rounded-lg border @error('description') border-red-500 @else border-gray-300 @enderror
                           px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Provide more details about the incident..." required>{{ old('description') }}</textarea>
                @error('description')
                <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Barangay -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Barangay</label>
                <select name="barangay_id" id="barangay" required
                    class="w-full rounded-lg border @error('barangay_id') border-red-500 @else border-gray-300 @enderror">
                    <option value="">-- Select Barangay --</option>
                    @foreach ($barangays as $barangay)
                    <option value="{{ $barangay->id }}"
                        data-lat="{{ $barangay->latitude }}"
                        data-lon="{{ $barangay->longitude }}"
                        {{ old('barangay_id') == $barangay->id ? 'selected' : '' }}>
                        {{ $barangay->barangayNames }}
                    </option>
                    @endforeach
                </select>
                @error('barangay_id')
                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Coordinates -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Longitude</label>
                <input type="text" id="longitude" name="incidentLongitude" value="{{ old('incidentLongitude') }}"
                    readonly
                    class="w-full rounded-lg border bg-gray-100 cursor-not-allowed
                           px-3 py-2 text-[12px] font-[Poppins]">
            </div>
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Latitude</label>
                <input type="text" id="latitude" name="incidentLatitude" value="{{ old('incidentLatitude') }}"
                    readonly
                    class="w-full rounded-lg border bg-gray-100 cursor-not-allowed
                           px-3 py-2 text-[12px] font-[Poppins]">
            </div>

            <!-- Hidden defaults -->
            <input type="hidden" name="status" value="Pending">
            <input type="hidden" name="agency_id" value="{{ auth()->user()->agency_id }}">
        </div>

        <button type="submit"
            class="w-full mt-4 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300
                   font-medium rounded-lg px-5 py-2.5 transition text-[12px] font-[Poppins]">
            🚨 Submit Report
        </button>
    </form>

    <script>
        // Auto-fill longitude & latitude when selecting Barangay
        document.getElementById('barangay').addEventListener('change', function() {
            let selected = this.options[this.selectedIndex];
            let lat = selected.getAttribute('data-lat');
            let lon = selected.getAttribute('data-lon');

            document.getElementById('latitude').value = lat || "";
            document.getElementById('longitude').value = lon || "";
        });
    </script>
</x-layout.layout>
