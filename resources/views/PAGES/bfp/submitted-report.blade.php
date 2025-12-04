<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Header -->
    <div class="flex flex-row justify-between items-center mb-3">
        <h6 class="font-[Poppins] text-[15px] text-gray-700">Submitted Reports</h6>
        <a class="bg-blue-700 text-white py-1 px-3 rounded-sm"
            href="{{ route('operation-officer.add-report') }}">Submit Report</a>
    </div>

    <!-- Filtering Form -->
    <form method="GET" action="{{ route('operation-officer.submitted-report') }}"
        class="flex flex-row justify-between items-center mb-4">

        <select name="barangay" onchange="this.form.submit()"
            class="px-3 py-2 border border-gray-300 rounded-lg text-sm">

            <option value="All" {{ request('barangay') == 'All' ? 'selected' : '' }}>
                Show All Barangay
            </option>

            @php
            $barangays = [
            "Abuno","Acmac-Mariano Badelles Sr.","Bagong Silang","Bonbonon","Bunawan","Buru-un",
            "Dalipuga","Del Carmen","Digkilaan","Ditucalan","Dulag","Hinaplanon","Hindang",
            "Kabacsanan","Kalilangan","Kiwalan","Lanipao","Luinab","Mahayahay","Mainit","Mandulog",
            "Maria Cristina","Pala-o","Panoroganan","Poblacion","Puga-an","Rogongon","San Miguel",
            "San Roque","Santa Elena","Santa Filomena","Santiago","Santo Rosario","Saray","Suarez",
            "Tambacan","Tibanga","Tipanoy","Tomas L. Cabili (Tominobo Proper)","Tubod",
            "Upper Hinaplanon","Upper Tominobo","Ubaldo Laya"
            ];
            @endphp

            @foreach ($barangays as $b)
            <option value="{{ $b }}" {{ request('barangay') == $b ? 'selected' : '' }}>
                {{ $b }}
            </option>
            @endforeach

        </select>

        <input type="date" name="date" value="{{ request('date') }}"
            onchange="this.form.submit()"
            class="px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-sm">
    </form>

    <!-- Table -->
    <div class="relative overflow-x-auto shadow-lg sm:rounded-lg border border-gray-200 mb-8">
        <table class="w-full text-[13px] font-[Roboto] text-gray-700">

            <thead class="bg-gradient-to-r from-blue-600 to-green-600 text-white font-[Poppins] text-[13px] uppercase">
                <tr class="text-left">
                    <th class="px-3 py-2">No</th>
                    <th class="px-3 py-2">Incident</th>
                    <th class="px-3 py-2">Type</th>
                    <th class="px-3 py-2">Nearest</th>
                    <th class="px-3 py-2">Barangay</th>
                    <th class="px-3 py-2">Level</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Report Action</th>
                    <th class="px-3 py-2">Date</th>
                    <th class="px-3 py-2">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($receives as $index => $receive)
                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition">

                    <td class="px-3 py-2">{{ $index + 1 }}</td>

                    <td class="px-3 py-2">{{ $receive->submittedReport->incident_category ?? 'N/A' }}</td>

                    <td class="px-3 py-2">{{ $receive->submittedReport->incident_type ?? 'N/A' }}</td>
                    <td class="px-3 py-2">{{ $receive->nearest_agency_name }}</td>
                    <td class="px-3 py-2">{{ $receive->submittedReport->barangay_name ?? 'N/A' }}</td>

                    <td class="px-3 py-2">
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

                    <td class="px-3 py-2">
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
                    <td class="px-3 py-2">{{ $receive->report_action }}</td>

                    <td class="px-3 py-2">
                        {{ $receive->created_at->timezone('Asia/Manila')->format('F d Y, g:i A') }}
                    </td>
                    <td class="px-3 py-2">
                        <div class="flex flex-row gap-1">
                            <x-partials.modality-track-report :report="$receive" />
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-3 py-4 text-center text-gray-500">
                        No submitted reports found.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex justify-center">
        {{ $receives->appends(request()->query())->links('vendor.pagination.tailwind') }}
    </div>

    <x-partials.stack-js />
</x-layout.layout>