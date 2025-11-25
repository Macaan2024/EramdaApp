<button data-modal-target="track-modal-{{ $report->id }}" data-modal-toggle="track-modal-{{ $report->id }}"
    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-sm text-sm px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
    Track
</button>

<div id="track-modal-{{ $report->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full md:inset-0 max-h-full">

    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-xl shadow-2xl p-6 border border-gray-100">
            <div class="flex items-center justify-between border-b pb-4 mb-4">
                <h3 class="text-xl font-extrabold text-blue-700">
                    Report ID: {{ $report->id }}
                </h3>
                <button type="button"
                    class="text-gray-500 bg-transparent hover:bg-red-100 hover:text-red-600 rounded-full text-lg w-8 h-8 flex justify-center items-center transition-colors"
                    data-modal-hide="track-modal-{{ $report->id }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="py-2 space-y-6">

                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <h4 class="text-sm font-bold text-blue-700 mb-3">Report Status Timeline</h4>
                    <ol class="relative border-s border-gray-200 ml-4">
                        <li class="mb-4 ms-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -start-3 ring-8 ring-blue-500/10 dark:ring-gray-900">
                                <span class="text-green-600 text-xs font-bold">✓</span>
                            </span>
                            <h3 class="flex items-center mb-1 text-sm font-semibold text-gray-900">
                                Report Submitted
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded ms-3">Initial</span>
                            </h3>
                            <time class="block mb-2 text-xs font-normal leading-none text-gray-400">
                                {{ \Carbon\Carbon::parse($report->submittedReport->created_at)->format('F d, Y at h:i A') }}
                            </time>
                        </li>
                        {{-- The rest of the timeline items (e.g., Dispatched, On-site, Resolved) would be dynamically inserted here based on actual report history --}}
                        <li class="mb-4 ms-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-blue-500/10 dark:ring-gray-900">
                                <span class="text-blue-600 text-xs font-bold">...</span>
                            </span>
                            <h3 class="text-sm font-semibold text-gray-900">
                                Current Status: {{ $report->submittedReport->report_status }}
                            </h3>
                            <p class="text-xs font-normal text-gray-500 mt-1">Awaiting dispatch or further action by the agency.</p>
                        </li>
                    </ol>
                </div>


                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                    <h4 class="text-sm font-bold text-gray-700 border-b border-gray-200 pb-2 mb-4">Detailed Report Information</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-3 gap-x-6 mb-4">
                        <div class="detail-item">
                            <p class="text-xs font-semibold uppercase text-gray-500">Incident</p>
                            <p class="text-sm font-medium text-gray-900">{{ $report->submittedReport->incident_category }}</p>
                        </div>
                        <div class="detail-item">
                            <p class="text-xs font-semibold uppercase text-gray-500">Type</p>
                            <p class="text-sm font-medium text-gray-900">{{ $report->submittedReport->incident_type }}</p>
                        </div>
                        <div class="detail-item">
                            <p class="text-xs font-semibold uppercase text-gray-500">Alarm Level</p>
                            <p class="text-sm font-bold {{ $report->submittedReport->alarm_level == 'High' ? 'text-red-600' : ($report->submittedReport->alarm_level == 'Medium' ? 'text-yellow-600' : 'text-green-600') }}">
                                {{ $report->submittedReport->alarm_level }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-3 gap-x-6 border-t border-gray-100 pt-4 mb-4">
                        <div class="detail-item sm:col-span-3">
                            <p class="text-xs font-semibold uppercase text-gray-500">Address</p>
                            <p class="text-sm text-gray-900">
                                {{ $report->submittedReport->purok ? $report->submittedReport->purok . ', ' : '' }}
                                {{ $report->submittedReport->street_name ? $report->submittedReport->street_name . ', ' : '' }}
                                {{ $report->submittedReport->barangay_name }}, {{ $report->submittedReport->city_name }}
                            </p>
                        </div>
                        <div class="detail-item">
                            <p class="text-xs font-semibold uppercase text-gray-500">Latitude</p>
                            <p class="text-sm text-gray-700">{{ $report->submittedReport->barangay_latitude }}</p>
                        </div>
                        <div class="detail-item">
                            <p class="text-xs font-semibold uppercase text-gray-500">Longitude</p>
                            <p class="text-sm text-gray-700">{{ $report->submittedReport->barangay_longitude }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 border-t border-gray-100 pt-4">
                        <div class="detail-item">
                            <p class="text-xs font-semibold uppercase text-gray-500">Resources Requested (Total)</p>
                            <p class="text-sm font-medium text-gray-900">
                                Police: {{ $report->submittedReport->police_car_request ?? 0 }},
                                Fire: {{ $report->submittedReport->fire_truck_request ?? 0 }},
                                Ambulance: {{ $report->submittedReport->ambulance_request ?? 0 }}
                            </p>
                        </div>
                        <div class="detail-item">
                            <p class="text-xs font-semibold uppercase text-gray-500">Report Source</p>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $report->submittedReport->reported_by }} (via {{ $report->submittedReport->from_agency }})
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="flex justify-end space-x-3 border-t pt-4 mt-4">
                <button type="button"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 font-medium text-sm transition-colors"
                    data-modal-hide="track-modal-{{ $report->id }}">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>