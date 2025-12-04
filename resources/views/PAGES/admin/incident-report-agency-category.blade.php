<x-layout.layout>
    @php
    // ------------------------------------------------------
    // LOGIC BLOCK
    // ------------------------------------------------------

    // 1. Get Agencies for filter dropdown (FIXED)
    // We fetch directly from the 'Agency' model to get ALL agencies,
    // not just the ones that have reports.
    $agencies = \App\Models\Agency::pluck('agencyNames', 'agencyNames')->sort();

    // 2. Base Query
    $query = \App\Models\AgencyReportAction::with(['submittedReport.user.agency']);

    // 3. Apply Filters
    if (request('agency')) {
        // Filters by the agency receiving the report
        $query->whereHas('submittedReport.user.agency', function($q){
            $q->where('agencyNames', request('agency'));
        });
    }

    if (request('date')) {
        // FIXED: TIMEZONE DATE FILTERING
        // We take the selected date as 'Asia/Manila', find the start and end of that day,
        // and convert it to UTC for the database query.
        try {
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', request('date'), 'Asia/Manila')
                            ->startOfDay()
                            ->setTimezone('UTC');
            $endDate   = \Carbon\Carbon::createFromFormat('Y-m-d', request('date'), 'Asia/Manila')
                            ->endOfDay()
                            ->setTimezone('UTC');

            $query->whereBetween('created_at', [$startDate, $endDate]);
        } catch (\Exception $e) {
            // Fallback if date parsing fails
            $query->whereDate('created_at', request('date'));
        }
    }

    // 4. Get Filtered Reports
    $reports = $query->latest()->get();

    // 5. Summary Counts
    $totalDisaster = $reports->filter(function($item) {
        return optional($item->submittedReport)->incident_category == 'Disaster Incidents';
    })->count();

    $totalRoad = $reports->filter(function($item) {
        return optional($item->submittedReport)->incident_category == 'Road Accidents';
    })->count();

    $totalPending = $reports->where('report_action', 'Pending')->count();
    $totalAccepted = $reports->where('report_action', 'Accepted')->count();
    $totalDeclined = $reports->where('report_action', 'Declined')->count();
    @endphp

    <x-partials.toast-messages />

    <div class="space-y-6 p-6 font-[Roboto] bg-gray-50 min-h-screen">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-gray-300 pb-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-blue-700"></i> Submitted Reports Overview
                </h3>
                <p class="text-xs text-gray-500 mt-1">Manage incident reports and agency actions.</p>
            </div>
            <div class="mt-2 md:mt-0">
                 <span class="bg-blue-900 text-white text-[10px] font-bold px-3 py-1 rounded shadow-sm">
                    SYSTEM DATE: {{ now()->format('M d, Y') }}
                </span>
            </div>
        </div>

        {{-- Summary Cards (Professional Box Style) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
            {{-- Disaster --}}
            <div class="bg-white p-4 border-l-4 border-red-500 shadow-sm rounded-r-md">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Disaster Incidents</p>
                <h4 class="text-2xl font-bold text-gray-800">{{ $totalDisaster }}</h4>
            </div>
            {{-- Road --}}
            <div class="bg-white p-4 border-l-4 border-orange-500 shadow-sm rounded-r-md">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Road Incidents</p>
                <h4 class="text-2xl font-bold text-gray-800">{{ $totalRoad }}</h4>
            </div>
            {{-- Pending --}}
            <div class="bg-white p-4 border-l-4 border-gray-500 shadow-sm rounded-r-md">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pending</p>
                <h4 class="text-2xl font-bold text-gray-800">{{ $totalPending }}</h4>
            </div>
            {{-- Accepted --}}
            <div class="bg-white p-4 border-l-4 border-green-600 shadow-sm rounded-r-md">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Accepted</p>
                <h4 class="text-2xl font-bold text-gray-800">{{ $totalAccepted }}</h4>
            </div>
            {{-- Declined --}}
            <div class="bg-white p-4 border-l-4 border-red-700 shadow-sm rounded-r-md">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Declined</p>
                <h4 class="text-2xl font-bold text-gray-800">{{ $totalDeclined }}</h4>
            </div>
        </div>

        {{-- Filter Form --}}
        <div class="bg-white p-4 border border-gray-200 shadow-sm rounded-sm mb-6">
            <div class="flex items-center gap-2 mb-3 text-sm font-bold text-gray-700">
                <i class="fas fa-filter text-blue-600"></i> FILTER RECORDS
            </div>
            <form method="GET" action="{{ url()->current() }}" class="flex flex-col md:flex-row gap-4 items-end">
                {{-- Agency --}}
                <div class="w-full md:w-1/4">
                    <label class="block text-[11px] font-bold text-gray-600 mb-1 uppercase">Select Agency</label>
                    <div class="relative">
                        <select name="agency" onchange="this.form.submit()"
                            class="w-full text-[13px] border-gray-300 rounded-sm focus:ring-blue-900 focus:border-blue-900 bg-gray-50 h-10">
                            <option value="">All Agencies</option>
                            @foreach($agencies as $agencyName)
                            <option value="{{ $agencyName }}" {{ request('agency') == $agencyName ? 'selected' : '' }}>
                                {{ $agencyName }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Date --}}
                <div class="w-full md:w-1/4">
                    <label class="block text-[11px] font-bold text-gray-600 mb-1 uppercase">Select Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()"
                        class="w-full text-[13px] border-gray-300 rounded-sm focus:ring-blue-900 focus:border-blue-900 bg-gray-50 h-10">
                </div>

                {{-- Reset --}}
                @if(request('agency') || request('date'))
                <div class="pb-0.5">
                    <a href="{{ url()->current() }}" class="inline-flex items-center justify-center h-10 px-4 bg-gray-600 hover:bg-gray-700 text-white text-[12px] font-bold uppercase tracking-wide rounded-sm transition-colors">
                        Reset
                    </a>
                </div>
                @endif
            </form>
        </div>

        {{-- Table Container --}}
        <div class="bg-white shadow-md border border-gray-200 rounded-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-700 min-w-[900px]">
                    {{-- Table Head (Professional Blue) --}}
                    <thead class="bg-blue-900 text-white text-[11px] font-bold uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-4 border-r border-blue-800">Report ID</th>
                            <th class="py-3 px-4 border-r border-blue-800">Reported By</th>
                            <th class="py-3 px-4 border-r border-blue-800">Nearest Agency</th>
                            <th class="py-3 px-4 border-r border-blue-800">Agency Type</th>
                            <th class="py-3 px-4 border-r border-blue-800">Action</th>
                            <th class="py-3 px-4 border-r border-blue-800">Timestamp</th>
                            <th class="py-3 px-4 text-center">View</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100 text-[13px]">
                        @forelse ($reports as $report)
                        <tr class="hover:bg-blue-50 transition-colors duration-200 even:bg-gray-50">
                            <td class="py-3 px-4 font-mono font-bold text-blue-900">{{ $report->submitted_report_id }}</td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-gray-800">{{ $report->submittedReport->user->lastname }}</div>
                                <div class="text-[11px] text-gray-500">{{ $report->submittedReport->user->position }} ({{ $report->submittedReport->user->agency->agencyNames }})</div>
                            </td>
                            <td class="py-3 px-4 font-medium">{{ $report->nearest_agency_name }}</td>
                            <td class="py-3 px-4">
                                <span class="bg-gray-100 border border-gray-300 text-gray-700 text-[11px] font-bold px-2 py-1 rounded-sm">
                                    {{ $report->agency_type }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @php
                                $actionColors = [
                                    'Accepted' => 'bg-green-600 text-white',
                                    'Declined' => 'bg-red-600 text-white',
                                    'Completed' => 'bg-blue-600 text-white',
                                    'Pending' => 'bg-gray-500 text-white',
                                ];
                                $action = $report->report_action ?? 'Pending';
                                $colors = $actionColors[$action] ?? $actionColors['Pending'];
                                @endphp
                                <span class="inline-block {{ $colors }} text-[10px] font-bold uppercase px-2 py-1 rounded-sm">
                                    {{ $action }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-[12px] text-gray-600">
                                {{ $report->created_at->timezone('Asia/Manila')->format('M d, g:i A') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <x-partials.modality-track-report :report="$report" />
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400 text-sm italic bg-gray-50">
                                <i class="fas fa-search mb-2 text-lg"></i>
                                <p>No records found matching your filters.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <x-partials.stack-js />
</x-layout.layout>