<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Page Title -->
    <div class="flex flex-row justify-between items-center mb-5">
        <h6 class="text-sm font-[Poppins] font-semibold text-gray-800">
            Submit Incident Report
        </h6>
        <a href="{{ route('bfp.manage-reports') }}"
            class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 
                   font-medium rounded-lg text-xs font-[Poppins] px-4 py-2">
            ← Back
        </a>
    </div>

    <!-- Form -->
    <div class="overflow-x-auto shadow-md rounded-lg p-5 bg-white">
        <form action="{{ route('reports.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Barangay -->
            <div>
                <label for="barangay_id" class="block text-sm font-medium text-gray-700">Barangay</label>
                <select name="barangay_id" id="barangay_id" class="w-full border rounded p-2 text-xs font-[Poppins]">
                    @foreach ($barangays as $barangay)
                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                    @endforeach
                </select>
                @error('barangay_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Incident Type -->
            <div>
                <label for="incident_types_id" class="block text-sm font-medium text-gray-700">Incident Type</label>
                <select name="incident_types_id" id="incident_types_id" class="w-full border rounded p-2 text-xs font-[Poppins]">
                    @foreach ($incidentTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('incident_types_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Latitude / Longitude -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="incidentLatitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                    <input type="text" name="incidentLatitude" id="incidentLatitude"
                        class="w-full border rounded p-2 text-xs font-[Poppins]" value="{{ old('incidentLatitude') }}">
                </div>
                <div>
                    <label for="incidentLongitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                    <input type="text" name="incidentLongitude" id="incidentLongitude"
                        class="w-full border rounded p-2 text-xs font-[Poppins]" value="{{ old('incidentLongitude') }}">
                </div>
            </div>

            <!-- Deaths / Injuries -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="numberOfDeaths" class="block text-sm font-medium text-gray-700">Deaths</label>
                    <input type="number" name="numberOfDeaths" id="numberOfDeaths"
                        class="w-full border rounded p-2 text-xs font-[Poppins]" value="{{ old('numberOfDeaths') }}">
                </div>
                <div>
                    <label for="numberOfInjuries" class="block text-sm font-medium text-gray-700">Injuries</label>
                    <input type="number" name="numberOfInjuries" id="numberOfInjuries"
                        class="w-full border rounded p-2 text-xs font-[Poppins]" value="{{ old('numberOfInjuries') }}">
                </div>
            </div>

            <!-- Date & Time -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="day" class="block text-sm font-medium text-gray-700">Day</label>
                    <input type="text" name="day" id="day" class="w-full border rounded p-2 text-xs font-[Poppins]" value="{{ old('day') }}">
                </div>
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                    <input type="text" name="month" id="month" class="w-full border rounded p-2 text-xs font-[Poppins]" value="{{ old('month') }}">
                </div>
                <div>
                    <label for="time" class="block text-sm font-medium text-gray-700">Time</label>
                    <input type="time" name="time" id="time" class="w-full border rounded p-2 text-xs font-[Poppins]" value="{{ old('time') }}">
                </div>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <input type="text" name="status" id="status" class="w-full border rounded p-2 text-xs font-[Poppins]" value="{{ old('status') }}">
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3" class="w-full border rounded p-2 text-xs font-[Poppins]">{{ old('description') }}</textarea>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-xs font-[Poppins]">
                    Submit Report
                </button>
            </div>
        </form>
    </div>

    <x-partials.stack-js />
</x-layout.layout>
