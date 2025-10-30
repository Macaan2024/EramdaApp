<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Navigation Links -->
    <div class="flex gap-4 mb-6 text-sm font-[Poppins]">
        <a href="{{ route('bfp.receive-reports') }}"
            class="px-3 py-1.5 rounded {{ request()->routeIs('bfp.receive-reports') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Receive Reports
        </a>
        <a href="{{ route('bfp.request-reports') }}"
            class="px-3 py-1.5 rounded {{ request()->routeIs('bfp.request-reports') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Request Reports
        </a>
        <a href="{{ route('bfp.submitted-reports') }}"
            class="px-3 py-1.5 rounded {{ request()->routeIs('bfp.submitted-reports') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Submitted Reports
        </a>
    </div>

    <!-- Page Title -->
    <div class="flex justify-between items-center mb-5">
        <h6 class="text-sm font-[Poppins] font-semibold text-gray-800">
            Submitted Reports
        </h6>
        <!-- Add Report Button -->
        <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            Add Report
        </button>
    </div>

    <!-- Main Modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex justify-center items-center backdrop-blur-sm bg-white/30 overflow-y-auto">

        <div class="relative w-full max-w-md md:max-w-2xl mx-4 my-6">
            <!-- Modal content -->
            <div class="relative bg-white rounded-2xl shadow-xl dark:bg-gray-800 transition transform scale-95 hover:scale-100 duration-200">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-[16px] font-[Poppins] font-semibold text-gray-900 dark:text-white">
                        Choose Types of Incident Reports
                    </h3>
                    <button type="button"
                        class="text-gray-400 hover:text-gray-900 hover:bg-gray-200 rounded-full p-2 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="default-modal">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-3 flex flex-col md:flex-row md:space-y-0 md:space-x-4 text-center">
                    <a href="{{ route('bfp.create-reports', 'Road Accident') }}"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg shadow-sm 
               hover:bg-blue-600 hover:text-white transition-colors">
                        🚗 Road Incidents
                    </a>
                    <a href="{{ route('bfp.create-reports', 'Disaster Incident') }}"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg shadow-sm 
               hover:bg-blue-600 hover:text-white transition-colors">
                        🌪 Disaster Incidents
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- Search -->
    <div class="mb-5">
        <form action="{{ route('bfp.search-submitted-reports') }}" method="GET" class="w-full max-w-md">
            <div class="relative">
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search submitted reports"
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
                    <th class="px-4 py-3 text-left">Incident Type</th>
                    <th class="px-4 py-3 text-left">Location</th>
                    <th class="px-4 py-3 text-left text-wrap">Number of Injuries</th>
                    <th class="px-4 py-3 text-left">Number of Deaths</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Date Reported</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{ $report->incidenttype->incident_name }}</td>
                    <td class="px-4 py-3">{{ $report->barangay->barangayNames}}, {{ $report->barangay->city }}</td>
                    <td class="px-4 py-3">{{ $report->barangay->numberOfInjuries}}</td>
                    <td class="px-4 py-3">{{ $report->barangay->numberOfDeaths}}</td>
                    <td class="px-4 py-3">{{ $report->created_at->format('M d, Y h:i A') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-white text-xs font-[Poppins]
                            {{ $report->status === 'Pending' ? 'bg-yellow-500' : '' }}
                            {{ $report->status === 'Resolved' ? 'bg-green-500' : '' }}
                            {{ $report->status === 'Rejected' ? 'bg-red-500' : '' }}">
                            {{ $report->status ?? 'Pending' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2 items-center">
                            <a href="#"
                                class="px-3 py-1 rounded bg-blue-500 hover:bg-blue-600 text-white text-xs font-[Poppins]">
                                View
                            </a>
                            <a href="#"
                                class="px-3 py-1 rounded bg-blue-500 hover:bg-blue-600 text-white text-xs font-[Poppins]">
                                Edit
                            </a>
                            <form action="#" method="POST">
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
                        No reports submitted yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-5 flex justify-center">
        {{ $reports->appends(request()->query())->links() }}
    </div>

    <x-partials.stack-js />
</x-layout.layout>