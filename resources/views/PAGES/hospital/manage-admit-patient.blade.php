<x-layout.layout>

    <x-partials.toast-messages />

    <div class="p-3 sm:p-6 bg-gray-50 min-h-screen font-['Roboto']">

        <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg border border-gray-100 mb-6 flex flex-row gap-4 items-center">
            <img src="{{ asset('storage/' . auth()->user()->agency->logo) }}"
                alt="Agency Image" class="w-14 h-14 sm:w-16 sm:h-16 rounded-full object-cover shadow-md border-2 border-indigo-100" />
            <div class="flex flex-col">
                {{-- Heading/Title: text-[16px], font-[Poppins] --}}
                <p class="text-[16px] sm:text-[18px] font-[Poppins] font-bold text-gray-900 tracking-tight">
                    {{ auth()->user()->agency->agencyNames }}
                </p>
                {{-- Normal Text: text-[12px], font-[Roboto] --}}
                <p class="text-[11px] sm:text-[12px] text-gray-500 font-medium font-[Roboto]">Patient Admission List</p>
            </div>
        </div>

        <div class="flex gap-4 mb-6 overflow-x-auto pb-4 flex-nowrap"> 
            
            {{-- Total Admitted Patients Card --}}
            <div class="flex-shrink-0 w-max bg-white border-l-4 border-indigo-600 rounded-lg shadow-md p-4 flex items-center justify-between min-w-[280px]">
                <div>
                    {{-- Title: text-[14px], font-[Poppins] --}}
                    <h3 class="text-gray-600 font-[Poppins] font-medium text-[14px] uppercase tracking-wider mb-1 whitespace-nowrap">
                        Total Admitted Patients
                    </h3>
                    {{-- Count: Increased size for focus, but controlled --}}
                    <p class="text-2xl font-[Poppins] font-bold text-indigo-700">
                        {{ $admittedTotal ?? 0 }} 
                    </p>
                    {{-- Normal Text: text-[12px], font-[Roboto] --}}
                    <p class="text-[12px] text-gray-500 font-medium font-[Roboto]">Currently in care</p>
                </div>
                {{-- Icon: Resized --}}
                <span class="material-symbols-outlined text-indigo-500 text-3xl opacity-75 ml-6">group</span>
            </div>

            {{-- Total Discharged Patients Card --}}
            <div class="flex-shrink-0 w-max bg-white border-l-4 border-green-600 rounded-lg shadow-md p-4 flex items-center justify-between min-w-[280px]">
                <div>
                    {{-- Title: text-[14px], font-[Poppins] --}}
                    <h3 class="text-gray-600 font-[Poppins] font-medium text-[14px] uppercase tracking-wider mb-1 whitespace-nowrap">
                        Total Discharged Patients
                    </h3>
                    {{-- Count: Increased size for focus, but controlled --}}
                    <p class="text-2xl font-[Poppins] font-bold text-green-700">
                        {{ $dischargeTotal ?? 0 }} 
                    </p>
                    {{-- Normal Text: text-[12px], font-[Roboto] --}}
                    <p class="text-[12px] text-gray-500 font-medium font-[Roboto]">Total successful releases</p>
                </div>
                {{-- Icon: Resized --}}
                <span class="material-symbols-outlined text-green-500 text-3xl opacity-75 ml-6">check_circle</span>
            </div>
            
            {{-- Optional: If you had more cards, they would continue horizontally here --}}

        </div>
        
        <hr class="border-gray-300 mb-6"> 
        
        <div class="bg-white p-4 sm:p-8 rounded-xl shadow-2xl border border-gray-200">

            {{-- Heading/Title: text-[16px], font-[Poppins] --}}
            <h6 class="font-[Poppins] text-[16px] sm:text-xl mb-6 text-gray-900 font-bold border-b border-indigo-500/30 pb-3">
                Admitted Patients Overview
            </h6>

            <div class="relative overflow-x-auto border border-gray-200 rounded-lg">
                <table class="w-full text-left text-[11px] sm:text-[13px] font-[Roboto] text-gray-700 min-w-[700px]">
                    {{-- Table Header: Darker Indigo Blue for an elegant touch --}}
                    <thead class="bg-indigo-700 text-white font-[Poppins] text-[11px] sm:text-[12px] uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-3 py-3 sm:px-4 sm:py-3 font-semibold text-center rounded-tl-lg">No</th>
                            <th scope="col" class="px-3 py-3 sm:px-4 sm:py-3 font-semibold">Patient Name</th>
                            <th scope="col" class="px-3 py-3 sm:px-4 sm:py-3 font-semibold text-center">Injury</th>
                            <th scope="col" class="px-3 py-3 sm:px-4 sm:py-3 font-semibold text-center">Bed Type</th>
                            <th scope="col" class="px-3 py-3 sm:px-4 sm:py-3 font-semibold text-center">Room/Bed</th>
                            <th scope="col" class="px-3 py-3 sm:px-4 sm:py-3 font-semibold text-center">Status</th>
                            <th scope="col" class="px-3 py-3 sm:px-4 sm:py-3 font-semibold text-center">Admission Date</th>
                            <th scope="col" class="px-3 py-3 sm:px-4 sm:py-3 font-semibold text-center rounded-tr-lg w-[140px]">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patientAdmitted as $patient)
                        @php
                            // Dynamic class for row based on status
                            $status = $patient->admit_status;
                            $rowClass = ($status === 'Admitted') ? 'bg-white hover:bg-indigo-50' : 'bg-gray-50 hover:bg-gray-100';

                            // Dynamic color for Injury Status
                            $injury = $patient->individual->injury_status ?? 'N/A';
                            $injuryColor = match ($injury) {
                                'Critical' => 'text-red-600 font-bold',
                                'Serious Injury' => 'text-orange-600 font-semibold',
                                'Minor Injury' => 'text-green-600 font-medium',
                                default => 'text-gray-500'
                            };

                            // Dynamic Bed Type color
                            $bedType = ucfirst($patient->emergencyroomerbed->bed_type ?? 'N/A');
                            $bedTypeColor = match ($bedType) {
                                'Icu' => 'bg-red-100 text-red-700',
                                'Private' => 'bg-yellow-100 text-yellow-700',
                                'Ward' => 'bg-blue-100 text-blue-700',
                                default => 'bg-gray-100 text-gray-500'
                            };
                        @endphp
                        <tr class="{{ $rowClass }} border-b border-gray-200 text-gray-800 text-center transition duration-150 ease-in-out">
                            <td class="px-3 py-3 sm:px-4 sm:py-3 font-medium text-center">{{ $loop->iteration }}</td>
                            <td class="px-3 py-3 sm:px-4 sm:py-3 text-left font-semibold text-gray-900">
                                {{ $patient->individual->individual_name ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-3 sm:px-4 sm:py-3 {{ $injuryColor }}">
                                {{ $injury }}
                            </td>
                            {{-- Bed Type (Pill/Badge style) --}}
                            <td class="px-3 py-3 sm:px-4 sm:py-3">
                                <span class="inline-block px-3 py-1 text-[10px] rounded-full {{ $bedTypeColor }} font-medium">
                                    {{ $bedType }}
                                </span>
                            </td>
                            {{-- Room/Bed Number Combination --}}
                            <td class="px-3 py-3 sm:px-4 sm:py-3 text-gray-600 font-medium">
                                R: {{ $patient->emergencyroomerbed->room_number ?? 'N/A' }} / B: {{ $patient->emergencyroomerbed->bed_number ?? 'N/A' }}
                            </td>
                            {{-- Admit Status (Pill style) --}}
                            <td class="px-3 py-3 sm:px-4 sm:py-3">
                                <span class="inline-block px-3 py-1 text-[10px] rounded-full font-medium 
                                    @if($patient->admit_status === 'Admitted') bg-indigo-100 text-indigo-700 @else bg-gray-100 text-gray-500 @endif">
                                    {{ $status }}
                                </span>
                            </td>
                            {{-- Date/Time --}}
                            <td class="px-3 py-3 sm:px-4 sm:py-3 text-gray-500 text-[10px] sm:text-[11px]">
                                {{ $patient->created_at->timezone('Asia/Manila')->format('M d, Y h:i A') }}
                            </td>
                            {{-- Action Button (Equalized Size) --}}
                            <td class="px-3 py-3 sm:px-4 sm:py-3">
                                @if($patient->admit_status === 'Admitted')
                                <form action="{{ route('nurse-chief.release-patient', $patient->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="w-full px-3 py-2 rounded-lg text-white bg-green-600 hover:bg-green-700 font-[Poppins] text-[11px] sm:text-[12px] transition duration-150 ease-in-out shadow-md shadow-green-500/30">
                                        Release
                                    </button>
                                </form>
                                @else
                                <button type="button"
                                    class="w-full px-3 py-2 rounded-lg text-white bg-gray-400 cursor-not-allowed font-[Poppins] text-[11px] sm:text-[12px]" disabled>
                                    Released
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-white">
                            <td colspan="8" class="text-center py-6 text-gray-500 font-[Poppins] text-[13px] italic">
                                No patients are currently admitted in this facility.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</x-layout.layout>