<x-layout.layout>
    <x-partials.toast-messages />

    <div class="min-h-screen bg-gray-100 p-3 sm:p-6 rounded-md">

        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg">

            <h6 class="font-[Poppins] text-[14px] sm:text-[16px] mb-4 text-gray-800 font-semibold">
                User Management
            </h6>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-5">
                <div class="bg-blue-900 text-white rounded-xl shadow p-3 sm:p-4 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[12px] sm:text-[14px] font-medium">Available Responder</h4>
                    <p class="text-lg sm:text-2xl font-bold mt-1">{{ $totalAvailableResponder }}</p>
                </div>

                <div class="bg-red-900 text-white rounded-xl shadow p-3 sm:p-4 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[12px] sm:text-[14px] font-medium">Unavailable Responder</h4>
                    <p class="text-lg sm:text-2xl font-bold mt-1">{{ $totalUnavailableResponder }}</p>
                </div>
            </div>


            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-4 mb-4">

                <form class="w-full sm:max-w-md relative" action="{{ route('operation-officer.responder') }}" method="GET">
                    <div class="relative">
                        <input type="search" name="search" value="{{ request('search') }}"
                            id="search-responders"
                            class="block w-full p-2 sm:p-3 pl-10 text-[11px] sm:text-[13px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search by name, position, or contact..." />

                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>

                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-700 hover:bg-blue-800 text-white text-[11px] sm:text-[12px] font-[Poppins] px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg shadow">
                            Search
                        </button>
                    </div>
                </form>

                <div class="flex flex-wrap gap-2 sm:gap-3 mt-2 sm:mt-0 items-center">
                    @php
                    $agencies = \App\Models\Agency::all();
                    @endphp

                    <x-partials.modality-add-users :agencies="$agencies" />
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
                <table class="w-full text-[10px] sm:text-[12px] font-[Roboto] text-gray-700 min-w-[750px]">
                    <thead class="bg-blue-600 text-white font-[Poppins] text-[11px] sm:text-[12px] uppercase">
                        <tr>
                            <th class="px-3 py-2 text-start">No</th>
                            <th class="px-3 py-2 text-start">Image</th>
                            <th class="px-3 py-2 text-start">Name</th>
                            <th class="px-3 py-2 text-start">Position</th>
                            <th class="px-3 py-2 text-start">Contact Number</th>
                            <th class="px-3 py-2 text-start">Gender</th>
                            <th class="px-3 py-2 text-start">Account Status</th>
                            <th class="px-3 py-2 text-start">Availability</th>
                            <th class="px-3 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($responders as $responder)
                        <tr class="bg-white hover:bg-gray-100 border-b border-gray-200 text-gray-800">
                            <td class="px-3 py-2 text-start">{{ $loop->iteration }}</td>

                            <td class="px-3 py-2">
                                @if($responder->photo)
                                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full overflow-hidden border">
                                    <img src="{{ asset('storage/' . $responder->photo) }}"
                                        alt="Responder Photo"
                                        class="w-full h-full object-cover">
                                </div>
                                @else
                                <span class="text-gray-400 text-[10px] sm:text-[11px]">No Image</span>
                                @endif
                            </td>

                            <td class="px-3 py-2">
                                {{ $responder->firstname }} {{ $responder->lastname }}
                            </td>

                            <td class="px-3 py-2">{{ $responder->position }}</td>

                            <td class="px-3 py-2">{{ $responder->contact_number }}</td>

                            <td class="px-3 py-2">
                                {{ $responder->gender == 'm' ? 'Male' : ($responder->gender == 'f' ? 'Female' : 'N/A') }}
                            </td>


                            <td class="px-3 py-2">
                                <span class="px-2 py-0.5 rounded text-[10px] sm:text-[11px] font-[Poppins] font-medium
     {{
        $responder->account_status === 'Active' ? 'bg-green-600 text-white' :
        ($responder->account_status === 'Pending' ? 'bg-orange-500 text-white' :
        ($responder->account_status === 'Deactivate' ? 'bg-gray-500 text-white' :
        ($responder->account_status === 'Decline' ? 'bg-red-600 text-white' : 'bg-gray-300 text-black')))
    }}">
                                    {{ $responder->account_status }}
                                </span>
                            </td>

                            <td class="px-3 py-2">
                                <span class="px-2 py-0.5 rounded text-[10px] sm:text-[11px] font-[Poppins] font-medium
                                        {{ $responder->availability_status === 'Available' ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}">
                                    {{ $responder->availability_status }}
                                </span>
                            </td>

                            @php
                            $user = $responder;
                            @endphp
                            <td class="px-3 py-2 flex flex-row gap-1 justify-center">
                                <x-partials.modality-view-user :user="$user" />
                                <x-partials.modality-edit-user :user="$user" :agencies="$agencies" />
                                <form action="#" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1.5 rounded-sm text-[12px] font-[Poppins] font-medium bg-red-600 text-white hover:bg-red-700 transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-gray-500 font-[Poppins] text-[11px] sm:text-[12px]">
                                🚫 No Responders Found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-center">
                {{ $responders->appends(request()->query())->links() }}
            </div>

        </div>
    </div> <x-partials.stack-js />
</x-layout.layout>