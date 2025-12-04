<x-layout.layout>
    <x-partials.toast-messages />

    <div class="min-h-screen bg-gray-100 p-3 sm:p-6 rounded-md">

        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg">

            <h6 class="font-[Poppins] text-[14px] sm:text-[16px] mb-4 text-gray-800 font-semibold">
                User Management
            </h6>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-5">
                <div class="bg-blue-900 text-white rounded-xl shadow p-3 sm:p-4 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[12px] sm:text-[14px] font-medium">BDRRMC Members</h4>
                    <p class="text-lg sm:text-2xl font-bold mt-1">{{ $totalBDRRMC }}</p>
                </div>

                <div class="bg-red-900 text-white rounded-xl shadow p-3 sm:p-4 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[12px] sm:text-[14px] font-medium">BFP Members</h4>
                    <p class="text-lg sm:text-2xl font-bold mt-1">{{ $totalBFP }}</p>
                </div>

                <div class="bg-green-900 text-white rounded-xl shadow p-3 sm:p-4 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[12px] sm:text-[14px] font-medium">Hospital Members</h4>
                    <p class="text-lg sm:text-2xl font-bold mt-1">{{ $totalHOSPITAL }}</p>
                </div>

                <div class="bg-yellow-900 text-white rounded-xl shadow p-3 sm:p-4 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[12px] sm:text-[14px] font-medium">CDRRMO Members</h4>
                    <p class="text-lg sm:text-2xl font-bold mt-1">{{ $totalCDRRMO }}</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-4 mb-4">

                <form class="w-full sm:max-w-md relative" action="{{ route('admin.search-user') }}" method="POST">
                    @csrf
                    <div class="relative">
                        <input type="search" id="search-responders"
                            class="block w-full p-2 sm:p-3 pl-10 text-[11px] sm:text-[13px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search Responders..." name="search" value="{{ request('search') }}" />
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-700 hover:bg-blue-800 text-white text-[11px] sm:text-[12px] font-[Poppins] px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg shadow">
                            Search
                        </button>
                    </div>
                </form>

                <div class="flex flex-wrap gap-2 sm:gap-3 mt-2 sm:mt-0 items-center">
                    <form class="w-full sm:w-auto">
                        <select
                            onchange="
                            if (this.value) {
                                window.location.href = '/admin/user/All/' + this.value;
                            } else {
                                window.location.href = '/admin/user/All';
                            }
                        "
                            class="block w-full p-2 sm:p-3 text-[11px] sm:text-[12px] border border-gray-300 rounded-lg bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Show All User</option>
                            @forelse ($agencies as $agency)
                            <option value="{{ $agency->id }}" {{ $id == $agency->id ? 'selected' : '' }}>
                                {{ $agency->agencyNames }}
                            </option>
                            @empty
                            <option disabled>No agencies found</option>
                            @endforelse
                        </select>
                    </form>

                    <x-partials.modality-add-users :agencies="$agencies" />
                </div>
            </div>

            <div class="flex flex-wrap gap-2 sm:gap-3 py-2">
                @php
                $buttons = ['All' => 'gray', 'BFP' => 'red', 'HOSPITAL' => 'blue', 'CDRRMO' => 'green', 'BDRRMC' => 'yellow'];
                @endphp
                @foreach($buttons as $key => $color)
                <a href="{{ route('admin.user', $key) }}"
                    class="px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg text-[11px] sm:text-[12px] font-[Poppins] font-semibold transition
                        {{ $status === $key ? 'bg-'.$color.'-700 text-white' : 'bg-'.$color.'-500 text-white hover:bg-'.$color.'-600' }}">
                    {{ $key }}
                </a>
                @endforeach
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
                <table class="w-full text-[10px] sm:text-[12px] font-[Roboto] text-gray-700 min-w-[500px]">
                    <thead class="bg-blue-600 text-white font-[Poppins] text-[11px] sm:text-[12px] uppercase">
                        <tr>
                            <th class="px-2 py-2 sm:px-3 sm:py-2 text-start">No</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2 text-start">Image</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2 text-start">Agency</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2 text-start">Role</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2 text-start">Name</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2 text-start ">Position</th>
                            <th class="px-2 py-2 sm:px-3 sm:py-2 text-start">Account Status</th>
                            <th class="px-2 py-1 sm:px-3 sm:py-2 text-start">Availability Status</th>
                            <th class="px-2 py-1 sm:px-3 sm:py-2 text-start">Created At</th>
                            <th class="px-2 py-1 sm:px-3 sm:py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="bg-white hover:bg-gray-100 border-b border-gray-200 text-gray-800">
                            <td class="px-2 py-1 sm:px-3 sm:py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">
                                @if ($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="User Image"
                                    class="h-6 w-6 sm:h-8 sm:w-8 object-cover rounded-full">
                                @else
                                <span class="text-gray-400 text-[10px] sm:text-[11px]">No Image</span>
                                @endif
                            </td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">{{ $user->agency->agencyNames ?? 'N/A' }}</td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">{{ $user->user_type ?? 'N/A' }}</td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">{{ $user->firstname ?? 'N/A' }} {{ $user->lastname ?? 'N/A' }}</td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">{{ $user->position ?? 'N/A' }}</td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">
                                <span class="px-2 py-0.5 rounded text-[10px] sm:text-[11px] font-[Poppins]
    {{
        $user->account_status === 'Active' ? 'bg-green-600 text-white' :
        ($user->account_status === 'Pending' ? 'bg-orange-500 text-white' :
        ($user->account_status === 'Deactivate' ? 'bg-gray-500 text-white' :
        ($user->account_status === 'Decline' ? 'bg-red-600 text-white' : 'bg-gray-300 text-black')))
    }}">
                                    {{ $user->account_status ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">
                                <span class="px-2 py-0.5 rounded text-[10px] sm:text-[11px] font-[Poppins] {{ $user->availability_status === 'Available' ? 'bg-yellow-600 text-white' : 'bg-gray-500 text-white' }}">
                                    {{ $user->availability_status ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
                            <td class="px-2 py-1 sm:px-3 sm:py-2">
                                <div class="flex flex-row gap-1 justify-center item-center">
                                    @if($user->account_status === 'Pending')
                                    <form action="{{ route('admin.accept-user', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-sm text-[12px] font-[Poppins] font-medium bg-green-600 text-white hover:bg-green-700 transition">
                                            Accept
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.decline-user', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-sm text-[12px] font-[Poppins] font-medium bg-red-600 text-white hover:bg-red-700 transition">
                                            Decline
                                        </button>
                                    </form>

                                    <button class="px-2 py-1.5 rounded-sm text-[12px] font-[Poppins] font-medium bg-blue-600 text-white transition">...</button>

                                    @else
                                    <x-partials.modality-view-user :user="$user" />
                                    <x-partials.modality-edit-user :user="$user" :agencies="$agencies" />
                                    <form action="{{ route('admin.delete-user', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1.5 rounded-sm text-[12px] font-[Poppins] font-medium bg-red-600 text-white hover:bg-red-700 transition">
                                            Delete
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-3 text-gray-500 font-[Poppins] text-[11px] sm:text-[12px]">
                                🚫 No Users Found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-center">
                {{ $users->appends(request()->except('users_page'))->links() }}
            </div>

        </div>
    </div>
</x-layout.layout>