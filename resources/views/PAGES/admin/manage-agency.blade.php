<x-layout.layout>
    <x-partials.toast-messages />

    <div class="min-h-screen bg-gray-100 p-3 sm:p-6 rounded-md">

        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg">

            <h6 class="font-[Poppins] text-[14px] sm:text-[16px] mb-4 text-gray-800 font-semibold">
                Agencies Management
            </h6>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-5">
                <div class="bg-blue-900 text-white rounded-xl shadow p-3 sm:p-4 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[12px] sm:text-[14px] font-medium">Total BDRRMC</h4>
                    <p class="text-lg sm:text-2xl font-bold mt-1">{{ $totalBDRRMC }}</p>
                </div>

                <div class="bg-red-900 text-white rounded-xl shadow p-3 sm:p-4 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[12px] sm:text-[14px] font-medium">Total BFP</h4>
                    <p class="text-lg sm:text-2xl font-bold mt-1">{{ $totalBFP }}</p>
                </div>

                <div class="bg-green-900 text-white rounded-xl shadow p-3 sm:p-4 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[12px] sm:text-[14px] font-medium">Total Hospital</h4>
                    <p class="text-lg sm:text-2xl font-bold mt-1">{{ $totalHOSPITAL }}</p>
                </div>

                <div class="bg-yellow-900 text-white rounded-xl shadow p-3 sm:p-4 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[12px] sm:text-[14px] font-medium">Total CDRRMO</h4>
                    <p class="text-lg sm:text-2xl font-bold mt-1">{{ $totalCDRRMO }}</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-4 mb-4">

                <form class="w-full sm:max-w-md relative" action="{{ route('admin.search-agency') }}" method="POST">
                    @csrf
                    <div class="relative">
                        <input type="search" id="search-responders"
                            class="block w-full p-2 sm:p-3 pl-10 text-[11px] sm:text-[13px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search by agency name or email.. " name="search" value="{{ request('search') }}" />
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-700 hover:bg-blue-800 text-white text-[11px] sm:text-[12px] font-[Poppins] px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg shadow">
                            Search
                        </button>
                    </div>
                </form>

                <div class="flex flex-wrap gap-2 sm:gap-3 mt-2 sm:mt-0 items-center">
                    {{-- The User Management page had a filter here, but this Agencies page originally had only the 'Add Agency' button.
                         If you want consistency, we keep only the 'Add Agency' button, using the consistent styling. --}}
                    <a href="{{ route('admin.add-agency') }}"
                        class="bg-blue-700 hover:bg-blue-800 text-white text-[11px] sm:text-[12px] font-[Poppins] rounded-lg px-4 py-2 sm:py-2.5 transition">
                        Add Agency
                    </a>
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
                <table class="w-full text-[10px] sm:text-[12px] font-[Roboto] text-gray-700 min-w-[600px]">
                    <thead class="bg-blue-600 text-white font-[Poppins] text-[11px] sm:text-[12px] uppercase">
                        <tr class="text-left">
                            <th class="px-2 py-2 sm:px-3 sm:py-2">No</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2">Logo</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2">Names</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2">Agency Types</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2">Emails</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2">Status</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2">Created At</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($agencies as $agency)
                        <tr class="bg-white hover:bg-gray-100 border-b border-gray-200 text-gray-800">
                            <td class="px-2 py-1 sm:px-3 sm:py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">
                                @if ($agency->logo)
                                <img src="{{ asset('storage/' . $agency->logo) }}" alt="Logo" class="h-6 w-6 sm:h-8 sm:w-8 object-cover rounded-full" />
                                @else
                                <span class="text-gray-400 text-[10px] sm:text-[11px]">No Logo</span>
                                @endif
                            </td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">{{ $agency->agencyNames }}</td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">{{ $agency->agencyTypes }}</td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">{{ $agency->email }}</td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">
                                <span class="px-2 py-0.5 rounded text-[10px] sm:text-[11px] font-[Poppins]
                                {{ $agency->availabilityStatus === 'Available' ? 'bg-green-600 text-white' : ($agency->availabilityStatus === 'Inactive' ? 'bg-yellow-600 text-white' : 'bg-red-600 text-white') }}">
                                    {{ $agency->availabilityStatus }}
                                </span>
                            </td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">{{ $agency->created_at->format('M d, Y') }}</td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2 flex gap-1 justify-center items-center">
                                <a href="{{ route('admin.view-agency', $agency->id) }}"
                                    class="bg-blue-700 hover:bg-blue-800 text-white px-3 py-1.5 rounded-sm text-[12px] font-[Poppins] font-medium transition">View</a>
                                <a href="{{ route('admin.edit-agency', $agency->id) }}"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1.5 rounded-sm text-[12px] font-[Poppins] font-medium transition">Edit</a>
                                <form action="{{ route('admin.delete-agency', $agency->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-sm text-[12px] font-[Poppins] font-medium transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-gray-500 font-[Poppins] text-[11px] sm:text-[12px]">🚫 No Agencies Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-center">
                {{ $agencies->appends(request()->query())->links('vendor.pagination.tailwind') }}
            </div>

        </div> </div> </x-layout.layout>