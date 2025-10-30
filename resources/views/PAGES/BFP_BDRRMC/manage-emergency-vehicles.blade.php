<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Page Title -->
    <div class="flex justify-between items-center mb-5">
        <h6 class="text-sm font-[Poppins] font-semibold text-gray-800">
            Emergency Vehicles Management
        </h6>
        <!-- Add Vehicle Button -->
        <a href="{{ route('bfp.add-vehicles') }}"
            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 
                  font-medium rounded-lg text-xs font-[Poppins] px-4 py-2">
            + Add Vehicle
        </a>
    </div>

    <!-- Search -->
    <div class="mb-5">
        <form action="{{ route('bfp.search-vehicles') }}" method="GET" class="w-full max-w-md">
            <div class="relative">
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search by plate number..."
                    class="block w-full p-2.5 ps-10 text-xs font-[Poppins] border border-gray-300 rounded-lg bg-gray-50
                          focus:ring-blue-500 focus:border-blue-500" />
                <button type="submit"
                    class="absolute end-2.5 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 
                           text-white rounded-lg text-xs font-[Poppins] px-3 py-1.5">
                    Search
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="w-full text-xs font-[Poppins] text-gray-700 border border-gray-200">
            <thead class="bg-blue-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Photo</th>
                    <th class="px-4 py-3 text-left">Plate Number</th>
                    <th class="px-4 py-3 text-left">Availability</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vehicles as $index => $vehicle)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <!-- Row Number -->
                    <td class="px-4 py-3">{{ $vehicles->firstItem() + $index }}</td>

                    <!-- Photo -->
                    <td class="px-4 py-3">
                        @if($vehicle->vehicle_photo)
                        <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 rounded-full overflow-hidden border">
                            <img src="{{ asset('storage/' . $vehicle->vehicle_photo) }}"
                                alt="Vehicle Photo"
                                class="w-full h-full object-cover">
                        </div>
                        @else
                        <span class="text-gray-500">No photo</span>
                        @endif
                    </td>

                    <!-- Plate Number -->
                    <td class="px-4 py-3">{{ $vehicle->plateNumber }}</td>

                    <!-- Availability -->
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-white text-xs font-[Poppins]
                                {{ $vehicle->availabilityStatus === 'Available' ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ ucfirst($vehicle->availabilityStatus) }}
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2 items-center">
                            <a href="{{ route('bfp.view-vehicles', $vehicle->id) }}"
                                class="px-3 py-1 rounded bg-blue-500 hover:bg-blue-600 text-white text-xs font-[Poppins]">
                                View
                            </a>
                            <a href="{{ route('bfp.edit-vehicles', $vehicle->id) }}"
                                class="px-3 py-1 rounded bg-green-500 hover:bg-green-600 text-white text-xs font-[Poppins]">
                                Edit
                            </a>
                            <form action="{{ route('bfp.delete-vehicles', $vehicle->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 rounded bg-red-500 hover:bg-red-600 text-white text-xs font-[Poppins]">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-3 text-center text-gray-500">
                        No vehicles found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-5 flex justify-center">
        {{ $vehicles->appends(request()->query())->links() }}
    </div>

    <x-partials.stack-js />
</x-layout.layout>
