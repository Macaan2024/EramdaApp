<x-layout.layout>
    <x-partials.toast-messages />
    <!-- 🧾 Receive Reports Table -->
    <h6 class="font-[Poppins] text-[15px] mb-3 text-gray-700">Receive Reports</h6>

    <div class="relative overflow-x-auto shadow-lg sm:rounded-lg border border-gray-200 mb-8">
        <table class="w-full text-[13px] font-[Roboto] text-gray-700">
            <thead class="bg-gradient-to-r from-blue-600 to-green-600 text-white font-[Poppins] text-[13px] uppercase">
                <tr class="text-left">
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Incident</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Barangay</th>
                    <th class="px-4 py-3">Level</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Report Action</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($receives as $index => $receive)
                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition">
                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">{{ $receive->submittedReport->incident_category ?? 'N/A' }}</td>
                    <td class="px-4 py-3">{{ $receive->submittedReport->incident_type ?? 'N/A' }}</td>
                    <td class="px-4 py-3">{{ $receive->submittedReport->barangay_name ?? 'N/A' }}</td>
                    <td class="px-4 py-3">
                        @php
                        $alarmColor = match($receive->submittedReport->alarm_level) {
                        'Level 1' => 'bg-yellow-500 text-white',
                        'Level 2' => 'bg-orange-500 text-white',
                        'Level 3' => 'bg-red-600 text-white',
                        };
                        @endphp

                        <span class="px-2 py-1 rounded-md text-[12px] {{ $alarmColor }}">
                            {{ $receive->submittedReport->alarm_level }}
                        </span>
                    </td>

                    <td class="px-4 py-3">
                        @php
                        $statusColor = match($receive->submittedReport->report_status) {
                        'Pending' => 'bg-yellow-500 text-white',
                        'Ongoing' => 'bg-blue-600 text-white',
                        'Resolved' => 'bg-green-600 text-white',
                        default => 'bg-gray-300 text-gray-700'
                        };
                        @endphp
                        <span class="px-2 py-1 rounded-md text-[11px] font-[Poppins] {{ $statusColor }}">
                            {{ $receive->submittedReport->report_status }}
                        </span>
                    </td>
                    <td class="text-center">
                        {{ $receive->report_action }}
                    </td>
                    <td class="px-1 py-1">
                        <div class="flex flex-row gap-1 justify-center item-center">

                            @if ($receive->report_action !== 'Accepted')
                            <x-partials.modality-deploy-units :report="$receive" />
                            @endif
                            <x-partials.modality-track-report :report="$receive" />
                        </div>
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
    <x-partials.stack-js />
</x-layout.layout>