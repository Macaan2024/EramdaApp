<x-layout.layout>

    <x-partials.toast-messages />

    <div class="min-h-screen bg-gray-50 p-4 sm:p-8">
        <div class="bg-white p-6 sm:p-8 rounded-xl shadow-2xl border border-gray-100">

            <header class="mb-8 border-b pb-4 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Shift Attendance 🕒</h1>
                    <h6 id="currentTimeDisplay" class="text-base text-blue-600 font-medium mt-2"></h6>
                    <h6 class="text-sm text-gray-500 font-medium">
                        {{ now('Asia/Manila')->format('l, F j, Y') }}
                    </h6>
                </div>
            </header>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div class="flex flex-wrap gap-2 text-sm font-semibold" id="shiftButtons">
                    @foreach(['Morning','Afternoon','Evening','Night'] as $shiftName)
                    <a id="{{ strtolower($shiftName) }}Link"
                        class="px-4 py-2 rounded-lg transition duration-150 ease-in-out
                        {{ $shift === $shiftName ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-blue-100' }}"
                        href="{{ route('operation-officer.attendance', ['shift' => $shiftName, 'date' => $date]) }}">
                        {{ $shiftName }}
                    </a>
                    @endforeach
                </div>

                <div class="flex items-center gap-2">
                    <label for="attendanceDate" class="text-sm font-medium text-gray-700 hidden sm:block">Select Date:</label>
                    <input type="date" id="attendanceDate" name="attendance_date" value="{{ $date }}"
                        class="px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-sm
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            @php
            $shiftTimeRanges = [
            'Morning' => ['startTime' => '6:00 AM', 'endTime' => '12:00 PM'],
            'Afternoon' => ['startTime' => '12:00 PM', 'endTime' => '6:00 PM'],
            'Evening' => ['startTime' => '6:00 PM', 'endTime' => '12:00 AM'],
            'Night' => ['startTime' => '12:00 AM', 'endTime' => '6:00 AM'],
            ];
            $currentShiftTimeRange = $shiftTimeRanges[$shift] ?? ['startTime' => 'N/A', 'endTime' => 'N/A'];
            @endphp

            <div class="relative overflow-x-auto shadow-xl sm:rounded-xl border border-gray-200">
                <div class="flex bg-gray-50 border-b border-gray-200">
                    <a href="{{ route('operation-officer.attendance', ['shift' => $shift, 'date' => $date]) }}"
                        class="w-1/2 text-center text-sm font-semibold py-3 transition duration-150 ease-in-out
                        bg-blue-600 text-white">
                        Time-in Status
                    </a>
                    <a href="{{ route('operation-officer.attendance-time-out-page', ['shift' => $shift, 'date' => $date]) }}"
                        class="w-1/2 text-center text-sm font-semibold py-3 transition duration-150 ease-in-out
                        bg-gray-100">
                        Time-out Status
                    </a>
                </div>

                <table class="w-full text-xs font-[Roboto] min-w-[750px] text-left text-gray-600">
                    <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider border-b border-gray-200">
                        <tr class="text-center">
                            <th scope="col" class="px-3 py-2 font-bold text-start ">No</th>
                            <th scope="col" class="px-3 py-2 font-bold text-start">Responder</th>
                            <th scope="col" class="px-3 py-2 font-bold text-start ">Shift</th>
                            <th scope="col" class="px-3 py-2 font-bold text-start ">Time-in</th>
                            <th scope="col" class="px-3 py-2 font-bold text-start ">Status</th>
                            <th scope="col" class="px-3 py-2 font-bold  text-start">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($users as $user)
                        <tr class="">
                            <td class="py-2 px-3">{{ $loop->iteration }}</td>
                            <td class="py-2 px-3">{{ $user->firstname }} {{ $user->lastname }}</td>
                            <td class="py-2 px-3">{{ $shift }}</td>

                            @php
                            $attendance = App\Models\Attendance::where('user_id', $user->id)
                            ->where('shift', $shift)
                            ->where('date', $date)
                            ->where('category', 'Time-in')
                            ->first();
                            @endphp

                            <td class="py-2 px-3">
                                {{ $attendance 
        ? \Carbon\Carbon::parse($attendance->time_in)->timezone('Asia/Manila')->format('g:i A') 
        : 'No Record' 
    }}
                            </td>
                            <td class="py-2 px-3">
                                @if ($attendance)
                                @php
                                $status = $attendance->status;
                                $statusClasses = match($status) {
                                'Time-in Success' => 'bg-green-600 text-white font-semibold rounded px-3 py-2',
                                'Absent' => 'bg-red-600 text-white font-semibold rounded px-3 py-2',
                                'Missed Time-out' => 'bg-yellow-600 text-yellow-800 font-semibold rounded px-3 py-2',
                                default => 'bg-gray-600 text-black font-semibold rounded px-3 py-2',
                                };
                                @endphp
                                <span class="{{ $statusClasses }}">{{ $status }}</span>
                                @else
                                <span class="bg-gray-100 text-gray-500 font-semibold rounded px-2 py-1">No Record</span>
                                @endif
                            </td>
                            <td class=" py-2 px-3 flex flex-row justify-start item-center gap-2">
                                @if (!$attendance)
                                <form action="{{ route('operation-officer.attendance-time-in') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <input type="hidden" name="shift" value="{{ $shift }}">
                                    <input type="hidden" name="date" value="{{ $date }}">
                                    <input type="hidden" name="time_in" value="{{ now('Asia/Manila')->format('H:i:s') }}">
                                    <input type="hidden" name="category" value="Time-in">
                                    <input type="hidden" name="status" value="Time-in Success">
                                    <button class="px-3 py-1 bg-green-600 text-white rounded">Time-in</button>
                                </form>
                                {{-- Absent --}}
                                <form action="{{ route('operation-officer.attendance-absent') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <input type="hidden" name="shift" value="{{ $shift }}">
                                    <input type="hidden" name="date" value="{{ $date }}">
                                    <input type="hidden" name="category" value="Time-in">
                                    <input type="hidden" name="status" value="Absent"> <button class="px-3 py-1 bg-red-600 text-white rounded">Absent</button>
                                </form>
                                @else
                                <form action="{{ route('operation-officer.attendance-cancel', $attendance->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-gray-500 text-white rounded">Undo</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Display current time
        function updateCurrentTime() {
            const options = {
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true,
                timeZone: 'Asia/Manila'
            };
            const dateOptions = {
                weekday: 'long'
            };
            const weekday = new Date().toLocaleString('en-US', dateOptions);

            document.getElementById('currentTimeDisplay').textContent = `${weekday}, ${new Date().toLocaleString('en-US', options)}`;
        }
        updateCurrentTime();
        setInterval(updateCurrentTime, 1000);

        // DATE INPUT DYNAMIC BEHAVIOR
        const dateInput = document.getElementById('attendanceDate');
        dateInput.addEventListener('change', function() {
            const selectedDate = this.value;
            const currentShift = '{{ $shift }}';
            // Navigates to the new date based on current status and shift
            window.location.href = `/operation-officer/attendance/${currentShift}/${selectedDate}`;
        });
    </script>

    <x-partials.stack-js />
</x-layout.layout>