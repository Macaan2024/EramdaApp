<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Outer Gray Container -->
    <div class="min-h-screen bg-gray-100 p-4 sm:p-6 space-y-6">

        <!-- Title -->
        <div class="bg-white p-4 rounded-2xl shadow border border-gray-200">
            <h6 class="font-[Poppins] text-[14px] mb-0 text-gray-800">Agencies Management</h6>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- BDRRMC Card -->
            <div class="bg-blue-900 text-white rounded-xl shadow p-4 flex flex-col items-center">
                <h4 class="font-[Poppins] text-[14px] font-medium">Total BDRRMC</h4>
                <p class="text-2xl font-bold mt-1">{{ $totalBDRRMC }}</p>
            </div>

            <!-- BFP Card -->
            <div class="bg-red-900 text-white rounded-xl shadow p-4 flex flex-col items-center">
                <h4 class="font-[Poppins] text-[14px] font-medium">Total BFP</h4>
                <p class="text-2xl font-bold mt-1">{{ $totalBFP }}</p>
            </div>

            <!-- Hospital Card -->
            <div class="bg-green-900 text-white rounded-xl shadow p-4 flex flex-col items-center">
                <h4 class="font-[Poppins] text-[14px] font-medium">Total Hospital</h4>
                <p class="text-2xl font-bold mt-1">{{ $totalHOSPITAL }}</p>
            </div>

            <!-- CDRRMO Card -->
            <div class="bg-yellow-900 text-white rounded-xl shadow p-4 flex flex-col items-center">
                <h4 class="font-[Poppins] text-[14px] font-medium">Total CDRRMO</h4>
                <p class="text-2xl font-bold mt-1">{{ $totalCDRRMO }}</p>
            </div>
        </div>

        <!-- Search & Add Button -->
        <div class="bg-white p-4 rounded-2xl shadow border border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

            <!-- Search Form -->
            <form class="w-full md:max-w-md" action="{{ route('admin.search-agency') }}" method="POST">
                @csrf
                <label for="search-responders" class="sr-only">Search Responders</label>
                <div class="relative">
                    <!-- Search Icon -->
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>

                    <!-- Search Input -->
                    <input type="search" id="search-responders"
                        class="block w-full p-3 ps-10 text-[12px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 
                        focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search Responders..." name="search" value="{{ request('search') }}" />

                    <!-- Keep agency filter when searching -->
                    <input type="hidden" name="agency" value="{{ request('agency') }}">

                    <!-- Search Button -->
                    <button type="submit"
                        class="text-white absolute end-2.5 top-1/2 -translate-y-1/2 
                        bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none 
                        focus:ring-blue-300 rounded-lg text-[12px] font-[Poppins] px-4 py-2">
                        Search
                    </button>
                </div>
            </form>

            <!-- Add Agency Button -->
            <a href="{{ route('admin.add-agency') }}"
                class="bg-blue-700 hover:bg-blue-800 text-white text-[12px] font-[Poppins] rounded-lg px-5 py-2.5 transition mt-2 sm:mt-0">
                Add Agency
            </a>
        </div>

        <!-- Agencies Table -->
        <div class="bg-white p-4 rounded-2xl shadow border border-gray-200 overflow-x-auto">
            <table class="w-full text-[12px] font-[Roboto] text-gray-800">
                <thead class="bg-blue-600 text-white font-[Poppins] text-[14px] uppercase">
                    <tr class="text-left">
                        <th class="px-3 py-2">No</th>
                        <th class="px-3 py-2">Logo</th>
                        <th class="px-3 py-2">Names</th>
                        <th class="px-3 py-2">Agency Types</th>
                        <th class="px-3 py-2">Emails</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Created At</th>
                        <th class="px-3 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($agencies as $agency)
                    <tr class="bg-white hover:bg-gray-50 border-b border-gray-200 text-black">
                        <td class="px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2 flex items-center">
                            @if ($agency->logo)
                            <img src="{{ asset('storage/' . $agency->logo) }}" alt="Logo" class="h-8 w-8 object-cover rounded-full" />
                            @else
                            <span class="text-gray-400 text-[12px]">No Logo</span>
                            @endif
                        </td>
                        <td class="px-3 py-2">{{ $agency->agencyNames }}</td>
                        <td class="px-3 py-2">{{ $agency->agencyTypes }}</td>
                        <td class="px-3 py-2">{{ $agency->email }}</td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-1 rounded-sm text-[12px] font-[Poppins]
                            {{ $agency->availabilityStatus === 'Available' ? 'bg-green-600 text-white' : ($agency->availabilityStatus === 'Inactive' ? 'bg-yellow-600 text-white' : 'bg-red-600 text-white') }}">
                                {{ $agency->availabilityStatus }}
                            </span>
                        </td>
                        <td class="px-3 py-2">{{ $agency->created_at->format('F d, Y h:i A') }}</td>
                        <td class="px-3 py-2 flex gap-2">
                            <a href="{{ route('admin.view-agency', $agency->id) }}"
                                class="bg-blue-700 hover:bg-blue-800 text-white px-3 py-1.5 rounded-sm text-[12px] font-[Poppins]">View</a>
                            <a href="{{ route('admin.edit-agency', $agency->id) }}"
                                class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1.5 rounded-sm text-[12px] font-[Poppins]">Edit</a>
                            <form action="{{ route('admin.delete-agency', $agency->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-sm text-[12px] font-[Poppins]">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-400">🚫 No Agencies Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $agencies->appends(request()->query())->links('vendor.pagination.tailwind') }}
        </div>

    </div>

    <x-partials.stack-js />
</x-layout.layout>
