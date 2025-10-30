<x-layout.layout>

    <x-partials.toast-messages />

    <div class="p-3 sm:p-6 bg-gray-100 min-h-screen font-['Roboto']">

        <!-- User Info -->
        <div class="bg-white p-3 sm:p-4 rounded-lg shadow mb-6 sm:mb-8 flex flex-row gap-3 sm:gap-4 items-center">
            <img src="{{ asset('storage/' . auth()->user()->agency->logo) }}"
                alt="Agency Image" class="w-12 h-12 sm:w-16 sm:h-16 rounded-full object-cover shadow-md" />
            <div class="flex flex-col">
                <p class="text-[14px] sm:text-[16px] font-[Poppins] font-bold text-gray-800">
                    {{ auth()->user()->agency->agencyNames }}
                </p>
                <p class="text-[10px] sm:text-[12px] text-gray-500">Dashboard</p>
            </div>
        </div>

        <!-- Inner White Container -->
        <div class="bg-white p-3 sm:p-6 rounded-lg shadow">

            <!-- Title -->
            <h6 class="font-[Poppins] text-[14px] sm:text-[16px] mb-3 sm:mb-4 text-gray-800 font-semibold">
                Hospital ER Beds
            </h6>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 mb-3 sm:mb-4">
                <div class="bg-blue-900 text-white rounded-xl shadow-sm p-2 sm:p-3 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[11px] sm:text-[13px] font-medium">Total Beds</h4>
                    <p class="text-lg sm:text-xl font-bold mt-1">{{ $beds->count() }}</p>
                </div>

                <div class="bg-green-800 text-white rounded-xl shadow-sm p-2 sm:p-3 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[11px] sm:text-[13px] font-medium">Total Available Beds</h4>
                    <p class="text-lg sm:text-xl font-bold mt-1">{{ $bedsAvailable }}</p>
                </div>

                <div class="bg-red-800 text-white rounded-xl shadow-sm p-2 sm:p-3 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[11px] sm:text-[13px] font-medium">Total Unavailable Beds</h4>
                    <p class="text-lg sm:text-xl font-bold mt-1">{{ $bedsUnavailable }}</p>
                </div>
            </div>

            <!-- Search & Add Button -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-3 sm:mb-4 gap-2 sm:gap-3">
                <form class="w-full md:max-w-md relative" action="{{ route('nurse-chief.bed') }}" method="GET">
                    <div class="relative">
                        <input type="search" id="search-bed"
                            class="block w-full p-2 sm:p-3 ps-8 sm:ps-10 text-[10px] sm:text-[11px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search Beds..." name="search" value="{{ request('search') }}" />

                        <button type="submit"
                            class="text-white absolute end-2.5 top-1/2 -translate-y-1/2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-[10px] sm:text-[11px] font-[Poppins] px-2 sm:px-4 py-1 sm:py-2">
                            Search
                        </button>
                    </div>
                </form>

                <div class="flex flex-wrap gap-1 sm:gap-2 mt-2 sm:mt-0">
                    <x-partials.modality-add-bed />
                </div>
            </div>

            <!-- Beds Table -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">
                <table class="w-full text-[10px] sm:text-[11px] font-[Roboto] text-gray-700 min-w-[500px]">
                    <thead class="bg-blue-600 text-white font-[Poppins] text-[11px] sm:text-[12px] uppercase">
                        <tr>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium">No</th>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium">Room</th>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium">Bed Type</th>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium">Bed Number</th>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium">Status</th>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium">Created At</th>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($beds as $bed)
                        <tr class="bg-white hover:bg-gray-100 border-b border-gray-200 text-gray-800">
                            <td class="px-1 py-1 sm:px-3 sm:py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-1 py-1 sm:px-3 sm:py-2 text-center">{{ $bed->room_number }}</td>
                            <td class="px-1 py-1 sm:px-3 sm:py-2 text-center">
                                @php
                                $typeColor = match(strtolower($bed->bed_type)) {
                                'ward' => 'bg-blue-500',
                                'private' => 'bg-yellow-500',
                                'icu' => 'bg-red-500',
                                default => 'bg-gray-400'
                                };
                                @endphp
                                <span class="{{ $typeColor }} text-white px-2 py-1 rounded-full text-[10px] sm:text-[11px] font-[Poppins]">
                                    {{ ucfirst($bed->bed_type) }}
                                </span>
                            </td>
                            <td class="px-1 py-1 sm:px-3 sm:py-2 text-center">{{ $bed->bed_number }}</td>
                            <td class="px-1 py-1 sm:px-3 sm:py-2 text-center">
                                <span class="px-2 py-1 rounded-full text-white text-[9px] sm:text-[11px] font-[Poppins] {{ $bed->availabilityStatus === 'Available' ? 'bg-green-600' : 'bg-red-600' }}">
                                    {{ $bed->availabilityStatus }}
                                </span>
                            </td>
                            <td class="px-1 py-1 sm:px-3 sm:py-2 text-center">{{ $bed->created_at->format('M d, Y') }}</td>
                            <td class="px-1 py-1 sm:px-3 sm:py-2 text-center flex flex-wrap justify-center gap-1">
                                <x-partials.modality-edit-bed :bed="$bed" />
                                <form action="{{ route('nurse-chief.delete-bed', $bed->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this bed?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-1 sm:px-3 sm:py-1.5 rounded-lg text-[10px] sm:text-[11px] font-[Poppins] font-semibold bg-red-600 text-white hover:bg-red-700 shadow-md w-full sm:w-auto">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-2 text-gray-500 font-[Poppins] text-[10px] sm:text-[11px]">
                                No beds found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3 sm:mt-4 flex justify-center">
                {{ $beds->appends(request()->except('users_page'))->links() }}
            </div>
        </div>

    </div>

</x-layout.layout>
