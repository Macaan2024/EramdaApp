<x-layout.layout>
    {{-- 1. LOAD CHART.JS LIBRARY --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- 2. STYLES --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500&display=swap');
        
        /* Modal Animations */
        .modal-enter { opacity: 0; transform: scale(0.95); }
        .modal-enter-active { opacity: 1; transform: scale(1); transition: opacity 0.3s ease, transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
        
        /* Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Elegant Card Hover */
        .stat-card { transition: all 0.3s ease; border: 1px solid #f3f4f6; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08); border-color: #e5e7eb; cursor: pointer; }
    </style>

    <div class="p-6 font-[Poppins] bg-gray-50/50 min-h-screen">
        
        {{-- ================================================== --}}
        {{-- SECTION 1: INCIDENT STAT CARDS                     --}}
        {{-- ================================================== --}}
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-[13px] font-bold text-gray-500 uppercase tracking-widest">Incident Overview</h2>
            <span class="text-[11px] text-gray-400 bg-white px-3 py-1 rounded-full border border-gray-100 shadow-sm">{{ now()->format('F d, Y') }}</span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-8">
            
            {{-- Total Reports --}}
            <div onclick="openTableModal('totalIncidents')" class="stat-card bg-white p-5 rounded-2xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide font-[Roboto]">Total Reports</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ count($allReportsList) }}</h3>
                    </div>
                    <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-600 group-hover:bg-gray-800 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-[11px] text-gray-400">
                    <span class="text-green-500 font-medium mr-1">●</span> Live Database
                </div>
            </div>

            {{-- Pending --}}
            <div onclick="openTableModal('pendingIncidents')" class="stat-card bg-white p-5 rounded-2xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] font-semibold text-yellow-500/80 uppercase tracking-wide font-[Roboto]">Pending</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ count($pendingReportsList) }}</h3>
                    </div>
                    <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-yellow-50 text-yellow-600 group-hover:bg-yellow-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-[11px] text-gray-400">
                    <span class="text-yellow-500 font-medium mr-1">{{ round((count($pendingReportsList) / (count($allReportsList) ?: 1)) * 100) }}%</span> of total
                </div>
            </div>

            {{-- Ongoing --}}
            <div onclick="openTableModal('ongoingIncidents')" class="stat-card bg-white p-5 rounded-2xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] font-semibold text-blue-500/80 uppercase tracking-wide font-[Roboto]">Ongoing</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ count($ongoingReportsList) }}</h3>
                    </div>
                    <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-[11px] text-gray-400">
                    <span class="text-blue-500 font-medium mr-1">Active</span> Operations
                </div>
            </div>

            {{-- Resolved --}}
            <div onclick="openTableModal('resolvedIncidents')" class="stat-card bg-white p-5 rounded-2xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] font-semibold text-emerald-500/80 uppercase tracking-wide font-[Roboto]">Resolved</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ count($resolvedReportsList) }}</h3>
                    </div>
                    <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-[11px] text-gray-400">
                    <span class="text-emerald-500 font-medium mr-1">{{ round((count($resolvedReportsList) / (count($allReportsList) ?: 1)) * 100) }}%</span> Success Rate
                </div>
            </div>
        </div>

        {{-- ================================================== --}}
        {{-- SECTION 2: AGENCY ACTION CARDS                     --}}
        {{-- ================================================== --}}
        <h2 class="text-[13px] font-bold text-gray-500 mb-4 uppercase tracking-widest mt-10">Agency Response</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-8">
            <div onclick="openTableModal('totalActions')" class="stat-card bg-white p-4 rounded-xl shadow-sm flex items-center justify-between">
                <div><h3 class="text-xl font-bold text-gray-800">{{ count($allActionList) }}</h3><p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Total Actions</p></div>
                <div class="h-2 w-2 rounded-full bg-gray-400 ring-4 ring-gray-50"></div>
            </div>
            <div onclick="openTableModal('acceptedActions')" class="stat-card bg-white p-4 rounded-xl shadow-sm flex items-center justify-between">
                <div><h3 class="text-xl font-bold text-gray-800">{{ count($acceptActionList) }}</h3><p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Accepted</p></div>
                <div class="h-2 w-2 rounded-full bg-emerald-500 ring-4 ring-emerald-50"></div>
            </div>
            <div onclick="openTableModal('declinedActions')" class="stat-card bg-white p-4 rounded-xl shadow-sm flex items-center justify-between">
                <div><h3 class="text-xl font-bold text-gray-800">{{ count($declineActionList) }}</h3><p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Declined</p></div>
                <div class="h-2 w-2 rounded-full bg-red-500 ring-4 ring-red-50"></div>
            </div>
            <div onclick="openTableModal('pendingActions')" class="stat-card bg-white p-4 rounded-xl shadow-sm flex items-center justify-between">
                <div><h3 class="text-xl font-bold text-gray-800">{{ count($pendingActionList) }}</h3><p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Pending</p></div>
                <div class="h-2 w-2 rounded-full bg-yellow-500 ring-4 ring-yellow-50"></div>
            </div>
        </div>

        {{-- ================================================== --}}
        {{-- SECTION 3: CHARTS GRID (RESIZED & ELEGANT)         --}}
        {{-- ================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
            
            {{-- WIDGET 1: HIGH RISK --}}
            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-gray-100 p-5 flex flex-col h-full hover:shadow-lg transition duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div><h2 class="text-gray-800 font-bold text-[14px]">High Risk Areas</h2><p class="text-[11px] text-gray-400 font-medium">Top 3 Barangays</p></div>
                    <button id="openBarangayModalBtn" class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition">VIEW ALL</button>
                </div>
                {{-- RESIZED CONTAINER: h-[150px] --}}
                <div class="relative w-full flex-grow flex items-center" style="height: 150px;"><canvas id="previewChart"></canvas></div>
            </div>

            {{-- WIDGET 2: INCIDENT TYPE --}}
            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-gray-100 p-5 flex flex-col h-full hover:shadow-lg transition duration-300">
                <div class="flex justify-between items-start mb-2">
                    <div><h2 class="text-gray-800 font-bold text-[14px]">Incident Distribution</h2><p class="text-[11px] text-gray-400 font-medium">By Category</p></div>
                    <div class="p-1.5 bg-gray-50 rounded-md text-gray-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path></svg></div>
                </div>
                {{-- RESIZED CONTAINER: h-[150px] --}}
                <div class="relative w-full flex-grow flex items-center justify-center" style="height: 150px;"><canvas id="categoryChart"></canvas></div>
                 <div class="mt-4 flex justify-center gap-6">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span><span class="text-[11px] font-semibold text-gray-600">Road</span></div>
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-red-500"></span><span class="text-[11px] font-semibold text-gray-600">Disaster</span></div>
                </div>
            </div>

            {{-- WIDGET 3: MONTHLY TRENDS --}}
            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-gray-100 p-5 flex flex-col h-full hover:shadow-lg transition duration-300">
                <div class="flex justify-between items-start mb-2">
                    <div><h2 class="text-gray-800 font-bold text-[14px]">Annual Trends</h2><p class="text-[11px] text-gray-400 font-medium">Monthly Volume</p></div>
                    <div class="p-1.5 bg-emerald-50 text-emerald-600 rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></div>
                </div>
                {{-- RESIZED CONTAINER: h-[150px] --}}
                <div class="relative w-full flex-grow flex items-center justify-center" style="height: 150px;"><canvas id="monthChart"></canvas></div>
            </div>
        </div>

    </div>


    {{-- ================================================== --}}
    {{-- MODAL 1: FULL BARANGAY CHART (Hidden)              --}}
    {{-- ================================================== --}}
    <div id="barangayModal" class="fixed inset-0 z-50 hidden font-[Poppins]" aria-modal="true">
        <div id="barangayBackdrop" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity opacity-0"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div id="barangayPanel" class="relative transform rounded-2xl bg-white shadow-2xl transition-all sm:w-full sm:max-w-4xl modal-enter overflow-hidden">
                    <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-[15px] font-bold text-gray-800">Analytics by Barangay</h3>
                        <button onclick="closeModal('barangayModal')" class="bg-gray-50 hover:bg-gray-100 p-2 rounded-full text-gray-500 transition">&times;</button>
                    </div>
                    <div class="bg-white px-6 py-6 h-[60vh] overflow-y-auto custom-scroll">
                        <div id="fullChartContainer" class="relative w-full"><canvas id="fullBarangayChart"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ================================================== --}}
    {{-- MODAL 2: CATEGORY TABLES (Hidden)                  --}}
    {{-- ================================================== --}}
    <div id="categoryModal" class="fixed inset-0 z-50 hidden font-[Poppins]" aria-modal="true">
        <div id="categoryBackdrop" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity opacity-0"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div id="categoryPanel" class="relative transform rounded-2xl bg-white shadow-2xl transition-all sm:w-full sm:max-w-4xl modal-enter overflow-hidden">
                    <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 id="catModalTitle" class="text-[15px] font-bold text-gray-800">Report Details</h3>
                        <button onclick="closeModal('categoryModal')" class="bg-gray-50 hover:bg-gray-100 p-2 rounded-full text-gray-500 transition">&times;</button>
                    </div>
                    <div class="bg-white px-6 py-6 custom-scroll overflow-y-auto max-h-[60vh]">
                        {{-- Road Table --}}
                        <div id="roadTable" class="hidden">
                            @foreach($roadAccidents as $report)
                                <div class="grid grid-cols-5 p-4 border-b border-gray-50 text-[12px] font-[Roboto] text-gray-600 hover:bg-blue-50/50 transition rounded-lg">
                                    <div class="col-span-1 font-medium">{{ $report->created_at->format('M d, Y') }}</div>
                                    <div class="col-span-1 text-gray-900 font-bold">{{ $report->incident_type }}</div>
                                    <div class="col-span-2 text-gray-500">{{ $report->barangay_name }}</div>
                                    <div class="col-span-1 text-right text-emerald-600 font-medium">Resolved</div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Disaster Table --}}
                        <div id="disasterTable" class="hidden">
                            @foreach($disasterIncidents as $report)
                                <div class="grid grid-cols-5 p-4 border-b border-gray-50 text-[12px] font-[Roboto] text-gray-600 hover:bg-red-50/50 transition rounded-lg">
                                    <div class="col-span-1 font-medium">{{ $report->created_at->format('M d, Y') }}</div>
                                    <div class="col-span-1 text-gray-900 font-bold">{{ $report->incident_type }}</div>
                                    <div class="col-span-2 text-gray-500">{{ $report->barangay_name }}</div>
                                    <div class="col-span-1 text-right text-emerald-600 font-medium">Resolved</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ================================================== --}}
    {{-- MODAL 3: CARD DETAILS TABLES (Hidden)              --}}
    {{-- ================================================== --}}
    <div id="detailsModal" class="fixed inset-0 z-50 hidden font-[Poppins]" aria-modal="true">
        <div id="detailsBackdrop" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity opacity-0"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div id="detailsPanel" class="relative transform rounded-2xl bg-white shadow-2xl transition-all sm:w-full sm:max-w-5xl modal-enter overflow-hidden">
                    <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h3 id="detailsModalTitle" class="text-[15px] font-bold text-gray-800">Records</h3>
                            <p class="text-[11px] text-gray-400">Detailed logs from database</p>
                        </div>
                        <button onclick="closeModal('detailsModal')" class="bg-gray-50 hover:bg-gray-100 p-2 rounded-full text-gray-500 transition">&times;</button>
                    </div>
                    <div class="bg-white px-6 py-6 custom-scroll overflow-y-auto max-h-[60vh]">
                        
                        {{-- Header Row --}}
                        <div class="grid grid-cols-6 bg-gray-50/80 p-3 rounded-lg text-[11px] font-bold text-gray-500 font-[Roboto] uppercase tracking-wider sticky top-0 mb-3">
                            <div class="col-span-1">Date</div><div class="col-span-1">Type</div><div class="col-span-2">Location</div><div class="col-span-1">Agency</div><div class="col-span-1 text-right">Status</div>
                        </div>

                        {{-- Total Reports --}}
                        <div id="table-totalIncidents" class="data-table hidden">
                            @foreach($allReportsList as $r)
                                <div class="grid grid-cols-6 p-3 border-b border-gray-50 text-[12px] font-[Roboto] text-gray-600 hover:bg-gray-50 transition items-center">
                                    <div class="col-span-1 font-medium">{{ $r->created_at->format('M d') }}</div>
                                    <div class="col-span-1 font-bold text-gray-800">{{ $r->incident_type }}</div>
                                    <div class="col-span-2">{{ $r->barangay_name }}</div>
                                    <div class="col-span-1 text-[11px]">{{ $r->from_agency ?? '-' }}</div>
                                    <div class="col-span-1 text-right"><span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-gray-100 text-gray-600 uppercase">{{ $r->report_status }}</span></div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pending Reports --}}
                        <div id="table-pendingIncidents" class="data-table hidden">
                            @foreach($pendingReportsList as $r)
                                <div class="grid grid-cols-6 p-3 border-b border-gray-50 text-[12px] font-[Roboto] text-gray-600 hover:bg-gray-50 transition items-center">
                                    <div class="col-span-1 font-medium">{{ $r->created_at->format('M d') }}</div>
                                    <div class="col-span-1 font-bold text-gray-800">{{ $r->incident_type }}</div>
                                    <div class="col-span-2">{{ $r->barangay_name }}</div>
                                    <div class="col-span-1">{{ $r->from_agency ?? '-' }}</div>
                                    <div class="col-span-1 text-right"><span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-yellow-50 text-yellow-600 uppercase border border-yellow-100">Pending</span></div>
                                </div>
                            @endforeach
                        </div>

                         {{-- Ongoing Reports --}}
                         <div id="table-ongoingIncidents" class="data-table hidden">
                            @foreach($ongoingReportsList as $r)
                                <div class="grid grid-cols-6 p-3 border-b border-gray-50 text-[12px] font-[Roboto] text-gray-600 hover:bg-gray-50 transition items-center">
                                    <div class="col-span-1 font-medium">{{ $r->created_at->format('M d') }}</div>
                                    <div class="col-span-1 font-bold text-gray-800">{{ $r->incident_type }}</div>
                                    <div class="col-span-2">{{ $r->barangay_name }}</div>
                                    <div class="col-span-1">{{ $r->from_agency ?? '-' }}</div>
                                    <div class="col-span-1 text-right"><span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-blue-600 uppercase border border-blue-100">Ongoing</span></div>
                                </div>
                            @endforeach
                        </div>

                         {{-- Resolved Reports --}}
                         <div id="table-resolvedIncidents" class="data-table hidden">
                            @foreach($resolvedReportsList as $r)
                                <div class="grid grid-cols-6 p-3 border-b border-gray-50 text-[12px] font-[Roboto] text-gray-600 hover:bg-gray-50 transition items-center">
                                    <div class="col-span-1 font-medium">{{ $r->created_at->format('M d') }}</div>
                                    <div class="col-span-1 font-bold text-gray-800">{{ $r->incident_type }}</div>
                                    <div class="col-span-2">{{ $r->barangay_name }}</div>
                                    <div class="col-span-1">{{ $r->from_agency ?? '-' }}</div>
                                    <div class="col-span-1 text-right"><span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-600 uppercase border border-emerald-100">Resolved</span></div>
                                </div>
                            @endforeach
                        </div>

                        {{-- ACTIONS TABLES (Similar Structure) --}}
                        <div id="table-totalActions" class="data-table hidden">
                            @foreach($allActionList as $a)
                                <div class="grid grid-cols-6 p-3 border-b border-gray-50 text-[12px] font-[Roboto] text-gray-600 hover:bg-gray-50 transition items-center">
                                    <div class="col-span-1 font-medium">{{ $a->created_at->format('M d') }}</div>
                                    <div class="col-span-1 font-bold text-gray-800">{{ $a->submittedReport->incident_type ?? '?' }}</div>
                                    <div class="col-span-2">{{ $a->submittedReport->barangay_name ?? 'N/A' }}</div>
                                    <div class="col-span-1">{{ $a->agency_name ?? 'Sys' }}</div>
                                    <div class="col-span-1 text-right"><span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-gray-100 text-gray-600 uppercase">{{ $a->report_action }}</span></div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Accepted --}}
                        <div id="table-acceptedActions" class="data-table hidden">
                            @foreach($acceptActionList as $a)
                                <div class="grid grid-cols-6 p-3 border-b border-gray-50 text-[12px] font-[Roboto] text-gray-600 hover:bg-gray-50 transition items-center">
                                    <div class="col-span-1 font-medium">{{ $a->created_at->format('M d') }}</div>
                                    <div class="col-span-1 font-bold text-gray-800">{{ $a->submittedReport->incident_type ?? '?' }}</div>
                                    <div class="col-span-2">{{ $a->submittedReport->barangay_name ?? 'N/A' }}</div>
                                    <div class="col-span-1">{{ $a->agency_name ?? 'Sys' }}</div>
                                    <div class="col-span-1 text-right"><span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-green-50 text-green-700 uppercase border border-green-100">Accepted</span></div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Declined --}}
                        <div id="table-declinedActions" class="data-table hidden">
                            @foreach($declineActionList as $a)
                                <div class="grid grid-cols-6 p-3 border-b border-gray-50 text-[12px] font-[Roboto] text-gray-600 hover:bg-gray-50 transition items-center">
                                    <div class="col-span-1 font-medium">{{ $a->created_at->format('M d') }}</div>
                                    <div class="col-span-1 font-bold text-gray-800">{{ $a->submittedReport->incident_type ?? '?' }}</div>
                                    <div class="col-span-2">{{ $a->submittedReport->barangay_name ?? 'N/A' }}</div>
                                    <div class="col-span-1">{{ $a->agency_name ?? 'Sys' }}</div>
                                    <div class="col-span-1 text-right"><span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-red-50 text-red-600 uppercase border border-red-100">Declined</span></div>
                                </div>
                            @endforeach
                        </div>
                         {{-- Pending Actions --}}
                         <div id="table-pendingActions" class="data-table hidden">
                            @foreach($pendingActionList as $a)
                                <div class="grid grid-cols-6 p-3 border-b border-gray-50 text-[12px] font-[Roboto] text-gray-600 hover:bg-gray-50 transition items-center">
                                    <div class="col-span-1 font-medium">{{ $a->created_at->format('M d') }}</div>
                                    <div class="col-span-1 font-bold text-gray-800">{{ $a->submittedReport->incident_type ?? '?' }}</div>
                                    <div class="col-span-2">{{ $a->submittedReport->barangay_name ?? 'N/A' }}</div>
                                    <div class="col-span-1">{{ $a->agency_name ?? 'Sys' }}</div>
                                    <div class="col-span-1 text-right"><span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-yellow-50 text-yellow-600 uppercase border border-yellow-100">Pending</span></div>
                                </div>
                            @endforeach
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ================================================== --}}
    {{-- JAVASCRIPT LOGIC                                   --}}
    {{-- ================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- 1. PREPARE DATA FROM CONTROLLER ---
            const barangayLabels = @json($barangayList);
            const barangayValues = @json($barangayData);
            const monthData = @json($monthData);
            const roadCount = {{ $roadAccidents->count() }};
            const disasterCount = {{ $disasterIncidents->count() }};

            // Combine for Sorting
            const combined = barangayLabels.map((name, i) => ({ name, value: barangayValues[i] })).sort((a, b) => b.value - a.value);
            const top3 = combined.slice(0, 3);
            const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            // --- 2. FONTS & UTILS ---
            const fontOpts = { titleFont: { size: 11, family: 'Poppins' }, bodyFont: { size: 11, family: 'Roboto' }, ticks: { size: 10, family: 'Roboto', weight: '500' } };
            const getGrad = (ctx, c1, c2) => { const g = ctx.createLinearGradient(0,0,0,300); g.addColorStop(0,c1); g.addColorStop(1,c2); return g; };

            // --- 3. INITIALIZE CHARTS ---
            
            // CHART A: HIGH RISK (Bar) - RESIZED
            const ctxBar = document.getElementById('previewChart').getContext('2d');
            const gBar = ctxBar.createLinearGradient(0,0,300,0); gBar.addColorStop(0,'#6366f1'); gBar.addColorStop(1,'#818cf8');
            new Chart(ctxBar, {
                type: 'bar', data: { labels: top3.map(d=>d.name), datasets: [{ data: top3.map(d=>d.value), backgroundColor: gBar, borderRadius: 6, barThickness: 20 }] },
                options: { indexAxis: 'y', maintainAspectRatio: false, plugins: { legend: {display:false} }, scales: { x:{display:false}, y:{grid:{display:false}, ticks:{color:"#374151", ...fontOpts.ticks}} } }
            });

            // CHART B: INCIDENT TYPE (Doughnut) - RESIZED
            const ctxCat = document.getElementById('categoryChart').getContext('2d');
            const catChart = new Chart(ctxCat, {
                type: 'doughnut', data: { labels: ['Road', 'Disaster'], datasets: [{ data: [roadCount, disasterCount], backgroundColor: ['#f59e0b', '#ef4444'], borderWidth: 0, hoverOffset: 4 }] },
                options: { maintainAspectRatio: false, cutout: '75%', plugins: { legend:{display:false} }, 
                onClick: (e) => { const pts = catChart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true); if(pts.length) openCategoryModal(pts[0].index); },
                onHover: (e, el) => e.native.target.style.cursor = el[0] ? 'pointer' : 'default' }
            });

            // CHART C: MONTHLY TRENDS (Line) - RESIZED
            const ctxMon = document.getElementById('monthChart').getContext('2d');
            const gMon = ctxMon.createLinearGradient(0,0,0,200); gMon.addColorStop(0,'rgba(16,185,129,0.15)'); gMon.addColorStop(1,'rgba(16,185,129,0.0)');
            new Chart(ctxMon, {
                type: 'line', data: { labels: monthLabels, datasets: [{ data: monthData, borderColor: '#10b981', backgroundColor: gMon, borderWidth: 2, pointRadius: 0, pointHoverRadius: 4, fill: true, tension: 0.4 }] },
                options: { maintainAspectRatio: false, plugins: { legend:{display:false} }, scales: { x:{grid:{display:false}, ticks:{color:'#9ca3af', ...fontOpts.ticks}}, y:{display:false} } }
            });

            // --- 4. MODAL LOGIC (Barangay Chart) ---
            window.fullChartInit = false;
            document.getElementById('openBarangayModalBtn').addEventListener('click', () => {
                openModal('barangayModal');
                if(!window.fullChartInit) {
                    const ctxFull = document.getElementById('fullBarangayChart').getContext('2d');
                    const gF = ctxFull.createLinearGradient(0,0,300,0); gF.addColorStop(0,'#3b82f6'); gF.addColorStop(1,'#2dd4bf');
                    document.getElementById('fullChartContainer').style.height = (combined.length * 35) + 'px';
                    new Chart(ctxFull, { type: 'bar', data: { labels: combined.map(d=>d.name), datasets: [{ data: combined.map(d=>d.value), backgroundColor: gF, borderRadius: 4, barThickness: 18 }] }, options: { indexAxis: 'y', maintainAspectRatio: false, plugins:{legend:{display:false}}, scales:{y:{grid:{display:false}, ticks:fontOpts.ticks}, x:{position:'top', ticks:fontOpts.ticks}} } });
                    window.fullChartInit = true;
                }
            });

            // --- 5. MODAL LOGIC (Category Tables) ---
            window.openCategoryModal = function(index) {
                const rT = document.getElementById('roadTable'), dT = document.getElementById('disasterTable'), tit = document.getElementById('catModalTitle');
                if(index === 0) { rT.classList.remove('hidden'); dT.classList.add('hidden'); tit.innerText = "Road Accident Reports"; }
                else { rT.classList.add('hidden'); dT.classList.remove('hidden'); tit.innerText = "Disaster Incident Reports"; }
                openModal('categoryModal');
            };

            // --- 6. MODAL LOGIC (Stat Cards) ---
            window.openTableModal = function(type) {
                document.querySelectorAll('.data-table').forEach(el => el.classList.add('hidden'));
                const t = document.getElementById('table-'+type); if(t) t.classList.remove('hidden');
                
                let title = "Detailed Report";
                if(type.includes('pending')) title = "Pending Items"; else if(type.includes('resolved')) title = "Resolved Cases"; else if(type.includes('ongoing')) title = "Ongoing Operations";
                else if(type.includes('declined')) title = "Declined Actions"; else if(type.includes('accepted')) title = "Accepted Actions";
                document.getElementById('detailsModalTitle').innerText = title;
                openModal('detailsModal');
            }
        });

        // --- GLOBAL HELPER FUNCTIONS ---
        function openModal(id) {
            const m = document.getElementById(id), back = m.firstElementChild, panel = m.lastElementChild.firstElementChild.firstElementChild;
            m.classList.remove('hidden');
            setTimeout(() => { back.classList.remove('opacity-0'); panel.classList.add('modal-enter-active'); }, 10);
        }
        function closeModal(id) {
            const m = document.getElementById(id), back = m.firstElementChild, panel = m.lastElementChild.firstElementChild.firstElementChild;
            back.classList.add('opacity-0'); panel.classList.remove('modal-enter-active');
            setTimeout(() => m.classList.add('hidden'), 200);
        }
        // Close on Backdrop Click
        window.addEventListener('click', (e) => {
            if(e.target.id === 'barangayModal' || e.target.id === 'barangayBackdrop') closeModal('barangayModal');
            if(e.target.id === 'categoryModal' || e.target.id === 'categoryBackdrop') closeModal('categoryModal');
            if(e.target.id === 'detailsModal' || e.target.id === 'detailsBackdrop') closeModal('detailsModal');
        });
    </script>
</x-layout.layout>