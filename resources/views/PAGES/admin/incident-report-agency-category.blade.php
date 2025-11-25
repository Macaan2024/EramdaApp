<x-layout.layout>
    <x-partials.toast-messages />

    <div class="space-y-6 p-4 md:p-6 lg:p-8 font-['Poppins']">
        {{-- Title/Heading --}}
        <h3 class="text-[16px] font-medium text-gray-800 border-b pb-2 mb-4 flex items-center gap-2">
            <i class="fas fa-file-alt text-blue-600"></i> Submitted Reports Overview
        </h3>

        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                {{-- Base Text Size for Table --}}
                <table class="w-full text-[12px] text-left text-gray-600">

                    {{-- THEAD: Font Medium and Base Text Size --}}
                    <thead class="text-[12px] text-white uppercase bg-blue-700 font-medium">
                        <tr>
                            <th scope="col" class="py-2 px-2">Report ID</th>
                            <th scope="col" class="py-2 px-2">Re-routing Number</th>
                            <th scope="col" class="py-2 px-2">Nearest Agency</th>
                            <th scope="col" class="py-2 px-2">Agency Type</th>
                            <th scope="col" class="py-2 px-2">Decline Reason</th>
                            <th scope="col" class="py-2 px-2">Action</th>
                            <th scope="col" class="py-2 px-2">Timestamp</th>
                            <th scope="col" class="py-2 px-2 text-center">Action</th>
                        </tr>
                    </thead>

                    {{-- TBODY: Optimized for space and using new palette --}}
                    <tbody>
                        @forelse ($reports as $report)
                        <tr class="bg-white border-b hover:bg-blue-50/50 transition duration-150">

                            {{-- Report ID: Font Medium for the ID number --}}
                            <th  class="py-3 px-2 font-mono text-gray-700">
                                <span class="font-normal">{{ $report->submitted_report_id }}</span>
                            </th>

                            <td class="py-3 px-2 font-mono text-gray-700">1</td>

                            <td class="py-3 px-2 font-medium text-gray-800">{{ $report->nearest_agency_name }}</td>

                            <td class="py-3 px-2">
                                <span class="bg-indigo-100 text-indigo-800 text-[12px] font-medium px-2.5 py-0.5 rounded-full whitespace-nowrap">
                                    {{ $report->agency_type }}
                                </span>
                            </td>

                            <td class="py-3 px-2">
                                @if ($report->decline_reason)
                                <span class="text-red-600 font-medium text-[12px] truncate block max-w-[10rem]" title="{{ $report->decline_reason }}">
                                    {{ $report->decline_reason }}
                                </span>
                                @else
                                <span class="text-gray-400">N/A</span>
                                @endif
                            </td>

                            <td class="py-3 px-2 whitespace-nowrap">
                                {{-- Status Badges: Using font-medium and 12px for consistency --}}
                                @if ($report->report_action == 'Accepted')
                                <span class="bg-green-100 text-green-800 text-[12px] font-medium px-2.5 py-0.5 rounded">Accepted</span>
                                @elseif ($report->report_action == 'Declined')
                                <span class="bg-red-100 text-red-800 text-[12px] font-medium px-2.5 py-0.5 rounded">Declined</span>
                                @elseif ($report->report_action == 'Completed')
                                <span class="bg-blue-100 text-blue-800 text-[12px] font-medium px-2.5 py-0.5 rounded">Completed</span>
                                @else
                                <span class="bg-gray-100 text-gray-800 text-[12px] font-medium px-2.5 py-0.5 rounded">{{ $report->report_action ?? 'Pending' }}</span>
                                @endif
                            </td>

                            <td class="py-3 px-2 whitespace-nowrap">{{ $report->created_at->timezone('Asia/Manila')->format('g:i A') }}</td>


                            <td class="py-3 px-2 text-center">
                                {{-- View Link: Using font-medium --}}
                                <a href="{{ url('/reports/' . $report->submitted_report_id) }}"
                                    class="font-medium text-blue-600 hover:text-blue-800 transition duration-150 flex items-center justify-center text-[12px]">
                                    View <i class="fas fa-arrow-right text-[12px] ml-1"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-white">
                            <td colspan="9" class="py-6 px-6 text-center text-gray-500 text-[12px]">
                                <i class="fas fa-folder-open text-xl mb-2"></i>
                                <p>No submitted reports found.</p>
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