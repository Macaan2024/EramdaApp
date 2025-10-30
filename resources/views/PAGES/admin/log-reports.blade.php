<x-layout.layout>
    <x-partials.toast-messages />

    <!-- 🧭 Title -->
    <h6 class="font-[Poppins] text-[14px] mb-3 text-gray-800">Submitted Incident Reports</h6>

    <!-- 🔍 Search & Add Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">

        <!-- Search Form -->
        <form class="w-full md:max-w-md" action="" method="GET">
            <label for="search-reports" class="sr-only">Search Reports</label>
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
                <input type="search" id="search-reports"
                    class="block w-full p-3 ps-10 text-[12px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 
                      focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search Reports..." name="search" value="{{ request('search') }}" />

                <!-- Search Button -->
                <button type="submit"
                    class="text-white absolute end-2.5 top-1/2 -translate-y-1/2 
                   bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none 
                   focus:ring-blue-300 rounded-lg text-[12px] font-[Poppins] px-4 py-2">
                    Search
                </button>
            </div>
        </form>

        <!-- Add Report Button -->
        <a href="{{ route('admin.add-incident-reports') }}"
            class="bg-blue-700 hover:bg-blue-800 text-white text-[12px] font-[Poppins] rounded-lg px-5 py-2.5 transition mt-2 sm:mt-0">
            Add Report
        </a>
    </div>

    <!-- 🏢 Agency Filter -->
    <div class="w-full sm:w-1/3 mb-6">
        <select
            onchange="
                if (this.value) {
                    window.location.href = '/admin/logs/reports/{{ $status }}/' + this.value;
                } else {
                    window.location.href = '/admin/logs/reports/All';
                }"
            class="block w-full p-3 text-[12px] sm:text-[13px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 
            focus:ring-blue-500 focus:border-blue-500">
            <option value="">Select Agency</option>
            @forelse ($agencies as $agency)
            <option value="{{ $agency->id }}" {{ $id == $agency->id ? 'selected' : '' }}>
                {{ $agency->agencyNames }}
            </option>
            @empty
            <option disabled>No agencies found</option>
            @endforelse
        </select>
    </div>

    <!-- 🟢 Status Filter Buttons -->
    <div class="flex flex-wrap gap-3 text-[12px] sm:text-[13px] font-[Poppins] mb-6">
        <a href="/admin/logs/reports/All/{{ $id ?? '' }}"
            class="px-4 py-2 rounded-lg transition 
            {{ $status === 'All' ? 'bg-gray-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">All</a>

        <a href="/admin/logs/reports/Pending/{{ $id ?? '' }}"
            class="px-4 py-2 rounded-lg transition 
            {{ $status === 'Pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Pending</a>

        <a href="/admin/logs/reports/Ongoing/{{ $id ?? '' }}"
            class="px-4 py-2 rounded-lg transition 
            {{ $status === 'Ongoing' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Ongoing</a>

        <a href="/admin/logs/reports/Resolved/{{ $id ?? '' }}"
            class="px-4 py-2 rounded-lg transition 
            {{ $status === 'Resolved' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Resolved</a>
        <a href="/admin/logs/reports/Prank/{{ $id ?? '' }}"
            class="px-4 py-2 rounded-lg transition 
            {{ $status === 'Prank' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Prank</a>
    </div>

    <!-- 📋 Reports Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-[12px] font-[Roboto] text-gray-700">
            <thead class="bg-gradient-to-r from-blue-600 to-green-600 text-white font-[Poppins] text-[13px] uppercase">
                <tr class="text-left">
                    <th class="px-3 py-2">No</th>
                    <th class="px-3 py-2">Category</th>
                    <th class="px-3 py-2">Type</th>
                    <th class="px-3 py-2">Barangay</th>
                    <th class="px-3 py-2">City</th>
                    <th class="px-3 py-2">Alarm Level</th>
                    <th class="px-3 py-2">Reported By</th>
                    <th class="px-3 py-2">From Agency</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                <tr class="bg-white hover:bg-gray-100 border-b border-gray-200 text-gray-900">
                    <td class="px-3 py-2">{{ $loop->iteration }}</td>
                    <td class="px-3 py-2">{{ $report->incident_category }}</td>
                    <td class="px-3 py-2">{{ $report->incident_type }}</td>
                    <td class="px-3 py-2">{{ $report->barangay_name }}</td>
                    <td class="px-3 py-2">{{ $report->city_name }}</td>
                    <td class="px-4 sm:px-6 py-3 font-semibold">
                        @php
                        $alarmColor = match($report->alarm_level) {
                        'Level 1' => 'bg-yellow-500 text-white',
                        'Level 2' => 'bg-orange-500 text-white',
                        'Level 3' => 'bg-red-600 text-white',
                        };
                        @endphp

                        <span class="px-2 py-1 rounded-md text-[12px] {{ $alarmColor }}">
                            {{ $report->alarm_level }}
                        </span>
                    </td>
                    <td class="px-3 py-2">{{ $report->reported_by ?? 'N/A' }}</td>
                    <td class="px-3 py-2">{{ $report->from_agency ?? 'N/A' }}</td>
                    <td class="px-3 py-2 font-medium">
                        @php
                        $statusColor = match($report->report_status) {
                        'Pending' => 'bg-yellow-500 text-white',
                        'Ongoing' => 'bg-blue-600 text-white',
                        'Resolved' => 'bg-green-600 text-white',
                        default => 'bg-gray-300 text-gray-700'
                        };
                        @endphp
                        <span class="px-2 py-1 rounded-md text-[11px] font-[Poppins] {{ $statusColor }}">
                            {{ $report->report_status }}
                        </span>
                    </td>
                    <td class="px-3 py-2">
                        <a href="#"
                            class="bg-blue-700 hover:bg-blue-800 text-white px-3 py-1.5 rounded-sm text-[12px] font-[Poppins]">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4 text-gray-400">🚫 No Submitted Reports Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- 📄 Pagination -->
    <div class="mt-10 flex justify-center">
        {{ $reports->links('vendor.pagination.tailwind') }}
    </div>

    <hr class="my-6">

    <!-- 🧾 Agency Incident Report Actions Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
        <table class="w-full text-[12px] font-[Roboto] text-gray-700">
            <thead class="bg-gradient-to-r from-green-600 to-blue-600 text-white font-[Poppins] text-[13px] uppercase">
                <tr class="text-left">
                    <th class="px-3 py-2">No</th>
                    <th class="px-3 py-2">Report ID</th>
                    <th class="px-3 py-2">Nearest Agency</th>
                    <th class="px-3 py-2">Agency Type</th>
                    <th class="px-3 py-2">Longitude</th>
                    <th class="px-3 py-2">Latitude</th>
                    <th class="px-3 py-2">Action Taken</th>
                    <th class="px-3 py-2">Decline Reason</th>
                    <th class="px-3 py-2">Created At</th>
                    <th class="px-3 py-2">Response At</th>
                    <th class="px-3 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reportActions as $reportAction)
                <tr class="bg-white hover:bg-gray-100 border-b border-gray-200 text-gray-900">
                    <td class="px-3 py-2">{{ $loop->iteration }}</td>
                    <td class="px-3 py-2">#{{ $reportAction->submitted_report_id }}</td>
                    <td class="px-3 py-2">{{ $reportAction->nearest_agency_name }}</td>
                    <td class="px-3 py-2">{{ $reportAction->agency_type }}</td>
                    <td class="px-3 py-2">{{ $reportAction->agency_longitude }}</td>
                    <td class="px-3 py-2">{{ $reportAction->agency_latitude }}</td>
                    <td class="px-3 py-2 font-semibold text-blue-700">{{ $reportAction->report_action }}</td>
                    <td class="px-3 py-2">
                        {{ $reportAction->decline_reason ? $action->decline_reason : '—' }}
                    </td>
                    <td class="px-3 py-2 text-gray-600">
                        {{ $reportAction->created_at->format('F j, Y, g:i a') }}
                    </td>
                    <td class="px-3 py-2 text-gray-600">
                        {{ $reportAction->updated_at->format('F j, Y, g:i a') }}
                    </td>
                    <td>
                        <button>
                            View
                        </button>
                    </td>


                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-gray-400">
                        🚫 No Agency Incident Report Actions Found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- 📄 Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $reportActions->links('vendor.pagination.tailwind') }}
    </div>


    <x-partials.stack-js />
</x-layout.layout>