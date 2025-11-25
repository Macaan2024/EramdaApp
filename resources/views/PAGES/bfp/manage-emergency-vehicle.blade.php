<x-layout.layout>
    <x-partials.toast-messages />

    <div class="min-h-screen bg-gray-100 p-3 sm:p-6">

        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-4 mb-4">

                <form class="w-full sm:max-w-md relative" action="{{ route('operation-officer.vehicle') }}" method="GET">
                    <div class="relative">
                        <input type="search" name="search" value="{{ request('search') }}"
                            id="search-responders"
                            class="block w-full p-2 sm:p-3 pl-10 text-[11px] sm:text-[13px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search by plate number" />

                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>

                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-700 hover:bg-blue-800 text-white text-[11px] sm:text-[12px] font-[Poppins] px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg shadow">
                            Search
                        </button>
                    </div>
                </form>

                <div class="flex flex-wrap gap-2 sm:gap-3 mt-2 sm:mt-0 items-center">
                    @php
                    $agencies = \App\Models\Agency::all();
                    @endphp
                    <x-partials.modality-add-vehicle :agencies="$agencies" />
                </div>

            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
                <table class="w-full text-[10px] sm:text-[12px] font-[Roboto] text-gray-700 min-w-[750px]">
                    <thead class="bg-blue-600 text-white font-[Poppins] text-[11px] sm:text-[12px] uppercase">
                        <tr>
                            <th class="px-3 py-2 text-start">No</th>
                            <th class="px-3 py-2 text-start">Image</th>
                            <th class="px-3 py-2 text-start">Vehicle Type</th>
                            <th class="px-3 py-2 text-start">Plate Number</th>
                            <th class="px-3 py-2 text-start">Availability Status</th>
                            <th class="px-3 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehicles as $vehicle)
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                            {{-- 1. Corrected $loop->iteration --}}
                            <td class="px-3 py-2">{{ $loop->iteration }}</td>

                            {{-- 2. Added image display logic --}}
                            <td class="px-3 py-2">
                                @if ($vehicle->vehicle_photo)
                                <img src="{{ asset('storage/' . $vehicle->vehicle_photo) }}"
                                    alt="Vehicle Photo"
                                    class="w-8 h-8 object-cover rounded-md" />
                                @else
                                N/A
                                @endif
                            </td>

                            {{-- 3. Vehicle Type --}}
                            <td class="px-3 py-2">{{ $vehicle->vehicleTypes }}</td>

                            {{-- 4. Added Plate Number --}}
                            <td class="px-3 py-2 font-semibold text-gray-800">{{ $vehicle->plateNumber }}</td>

                            {{-- 5. Availability Status (with dynamic styling) --}}
                            <td class="px-3 py-2">
                                <span class="px-4 py-2 rounded-sm text-[12px] font-medium 
                                    @if ($vehicle->availabilityStatus === 'Available') 
                                        bg-green-700 text-white
                                    @elseif ($vehicle->availabilityStatus === 'Occupied')
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-red-100 text-red-700
                                    @endif">
                                    {{ $vehicle->availabilityStatus }}
                                </span>
                            </td>
                            {{-- 6. Actions column --}}
                            <td class="px-3 py-2 text-center space-x-2 whitespace-nowrap">
                                <x-partials.modality-edit-vehicle :vehicle="$vehicle" />
                                {{-- Delete Button (Form) --}}
                                <form action="{{ route('operation-officer.delete-vehicle', $vehicle->id) }}"
                                    method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-white bg-red-600 hover:bg-red-700 
                       text-xs font-semibold py-1.5 px-3 rounded-md transition shadow-sm 
                       inline-block text-center min-w-[55px]">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-3 py-4 text-center text-gray-500">
                                No emergency vehicles found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-center">
                {{ $vehicles->appends(request()->query())->links() }}
            </div>

        </div>
    </div> <x-partials.stack-js />
</x-layout.layout>