<x-layout.layout>
    <x-partials.toast-messages />

    <div class="p-4">
        <!-- 🧭 Page Title -->
        <h6 class="font-[Poppins] text-[16px] mb-4 text-gray-800 font-semibold">
            Incident Reports
        </h6>

        <!-- 🔍 Search & Add Button -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
            <!-- Search Form -->
            <form class="w-full md:max-w-md" action="" method="GET">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="search-reports"
                        class="block w-full p-3 ps-10 text-[13px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 
                               focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search Reports..." name="search" value="{{ request('search') }}" />
                    <button type="submit"
                        class="text-white absolute end-2.5 top-1/2 -translate-y-1/2 
                               bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none 
                               focus:ring-blue-300 rounded-lg text-[12px] font-[Poppins] px-4 py-2">
                        Search
                    </button>
                </div>
            </form>

            <!-- Add Report Button -->
            <a href="{{ route('operation-officer.add-report') }}"
                class="bg-blue-700 hover:bg-blue-800 text-white text-[13px] font-[Poppins] rounded-lg px-5 py-2.5 transition shadow-sm">
                + Add Report
            </a>
        </div>
        
        <!-- 📦 Submitted Reports Table -->
        <h6 class="font-[Poppins] text-[15px] mb-3 text-gray-700">Submitted Reports</h6>
        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg border border-gray-200">
            <table class="w-full text-[13px] font-[Roboto] text-gray-700">
                <thead class="bg-gradient-to-r from-green-600 to-blue-600 text-white font-[Poppins] text-[13px] uppercase">
                    <tr class="text-left">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Report ID</th>
                        <th class="px-4 py-3">Nearest Agency</th>
                        <th class="px-4 py-3">Agency Type</th>
                        <th class="px-4 py-3">Action Taken</th>
                        <th class="px-4 py-3">Created At</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $index => $report)
                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition">
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">{{ $report->submittedreport->id }}</td>
                        <td class="px-4 py-3">{{ $report->nearest_agency_name }}</td>
                        <td class="px-4 py-3">{{ $report->agency_type }}</td>
                        <td class="px-4 py-3">{{ $report->report_action }}</td>
                        <td class="px-4 py-3">{{ $report->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-3 text-center space-x-1">
                            <a href="#"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-[12px] shadow-sm">View</a>
                            <a href="#"
                                class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-[12px] shadow-sm">Edit</a>
                            <form action="#" method="POST" class="inline-block"
                                onsubmit="return confirm('Are you sure you want to delete this report?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-[12px] shadow-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-4 py-4 text-center text-gray-500">
                            No submitted reports found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <x-partials.stack-js />
</x-layout.layout>