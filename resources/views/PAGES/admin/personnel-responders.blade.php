<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Page Title -->
    <div class="flex justify-between items-center mb-5">
        <h6 class="text-[16px] font-[Poppins] font-semibold text-gray-800">
            User Management
        </h6>
        <!-- Add Responder Button -->
        <a href="{{ route('admin.add-responders') }}"
            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 
                  font-medium rounded-lg text-[14px] font-[Poppins] px-4 py-2">
            + Add Responder
        </a>
    </div>

    @php
    $totalPendingUser = 0;
    $totalApprovedUser = 0;
    $totalDeclinedUser = 0;
    $totalArchivedUser = 0;

    foreach ($responders as $responder) {
    if ($responder->account_status === 'Pending') {
    $totalPendingUser++;
    } elseif ($responder->account_status === 'Approved') {
    $totalApprovedUser++;
    } elseif ($responder->account_status === 'Declined') {
    $totalDeclinedUser++;
    }
    if ($responder->deleted_at) {
    $totalArchivedUser++;
    }
    }

    $cards = [
    ['label' => 'Pending', 'count' => $totalPendingUser, 'color' => 'bg-yellow-500'],
    ['label' => 'Approved', 'count' => $totalApprovedUser, 'color' => 'bg-green-500'],
    ['label' => 'Declined', 'count' => $totalDeclinedUser, 'color' => 'bg-red-500'],
    ['label' => 'Archived', 'count' => $totalArchivedUser, 'color' => 'bg-gray-500'],
    ];
    @endphp

    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach($cards as $card)
        @if($card['count'] > 0)
        <div class="p-5 rounded-lg shadow-md text-white {{ $card['color'] }}">
            <h3 class="text-[16px] font-semibold font-[Poppins]">{{ $card['label'] }}</h3>
            <p class="text-2xl font-bold mt-2">{{ $card['count'] }}</p>
        </div>
        @endif
        @endforeach
    </div>

    <!-- Search + Filters -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- Search Form -->
        <form class="w-full md:max-w-md" action="{{ route('admin.search-responders') }}" method="GET">
            <label for="search-responders" class="sr-only">Search Responders</label>
            <div class="relative">
                <!-- Search Icon -->
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>

                <!-- Search Input -->
                <input type="search" id="search-responders"
                    class="block w-full p-3 ps-10 text-[12px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 
                      focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search Responders..." name="search" value="{{ request('search') }}" />

                <!-- Keep agency filter when searching -->
                <input type="hidden" name="agency" value="{{ request('agency') }}">

                <!-- Search Button -->
                <button type="submit"
                    class="text-white absolute end-2.5 top-1/2 -translate-y-1/2 
                   bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none 
                   focus:ring-blue-300 rounded-lg text-[12px] font-[Poppins] px-4 py-2">
                    Search
                </button>
            </div>
        </form>

        <!-- Agency Filter -->
        <form action="{{ route('admin.filter-agency', 'All') }}" method="GET" class="w-full md:w-auto">
            <select name="agency" onchange="this.form.submit()"
                class="block w-auto p-3 text-[12px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 
                   focus:ring-blue-500 focus:border-blue-500">
                <option value="">Select Agency</option>
                @foreach ($agencies as $agency)
                <option value="{{ $agency->id }}" {{ request('agency') == $agency->id ? 'selected' : '' }}>
                    {{ $agency->agencyNames }}
                </option>
                @endforeach
            </select>
            <input type="hidden" name="search" value="{{ request('search') }}">
        </form>
    </div>

    @php
    // Normalise status to lowercase so comparisons are easier
    $currentStatus = $status ?? 'All';
    @endphp

    <div class="flex flex-wrap justify-start gap-3 text-[12px] font-[Poppins] my-5">
        <a href="{{ route('admin.responders', 'All') }}"
            class="px-4 py-2 rounded-full border 
       {{ $currentStatus === 'All' ? 'bg-gray-800 text-white' : 'border-gray-300 hover:bg-gray-100' }}">
            All
        </a>

        <a href="{{ route('admin.responders', 'Pending') }}"
            class="px-4 py-2 rounded-full border 
       {{ $currentStatus === 'Pending' ? 'bg-yellow-500 text-white' : 'border-gray-300 hover:bg-yellow-100 text-yellow-700' }}">
            Pending
        </a>

        <a href="{{ route('admin.responders', 'Declined') }}"
            class="px-4 py-2 rounded-full border 
       {{ $currentStatus === 'Declined' ? 'bg-red-500 text-white' : 'border-gray-300 hover:bg-red-100 text-red-700' }}">
            Declined
        </a>

        <a href="{{ route('admin.responders', 'Approved') }}"
            class="px-4 py-2 rounded-full border 
       {{ $currentStatus === 'Approved' ? 'bg-green-500 text-white' : 'border-gray-300 hover:bg-green-100 text-green-700' }}">
            Approved
        </a>

        <a href="{{ route('admin.responders', 'Archived') }}"
            class="px-4 py-2 rounded-full border 
       {{ $currentStatus === 'Archived' ? 'bg-gray-500 text-white' : 'border-gray-300 hover:bg-gray-200 text-gray-700' }}">
            Archived
        </a>
    </div>


    <!-- Table -->
    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="w-full text-xs font-[Poppins] text-gray-700 border border-gray-200">
            <thead class="bg-blue-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Image</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">UserType</th>
                    <th class="px-4 py-3 text-left">Gender</th>
                    <th class="px-4 py-3 text-left">Account Status</th>
                    <th class="px-4 py-3 text-left">Availability Status</th>
                    <th class="px-4 py-3 text-left">Created At</th>
                    <th class="px-4 py-3 text-left">Updated At</th>
                    <th class="px-4 py-3 text-left">Deleted At</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($responders as $responder)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <!-- Row Number -->
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{ $responder->id }}</td>
                    <!-- Responsive Image -->
                    <td class="px-4 py-3">
                        @if($responder->photo)
                        <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 rounded-full overflow-hidden border">
                            <img src="{{ asset('storage/' . $responder->photo) }}"
                                alt="Responder Photo"
                                class="w-full h-full object-cover">
                        </div>
                        @else
                        <span class="text-gray-500">No photo</span>
                        @endif
                    </td>

                    <!-- Full Name -->
                    <td class="px-4 py-3">
                        {{ $responder->firstname }} {{ $responder->lastname }}
                    </td>

                    <!-- Position -->
                    <td class="px-4 py-3">{{ $responder->user_type }}</td>

                    <!-- Genders -->
                    <td class="px-4 py-3">
                        {{ $responder->gender == 'm' ? 'Male' : ($responder->gender == 'f' ? 'Female' : 'N/A') }}
                    </td>

                    <!-- Account Status -->
                    <td class="px-4 py-3">
                        @if ($responder->account_status === 'Approved')
                        <span class="px-2 py-1 rounded text-white text-xs font-[Poppins] bg-green-500">
                            {{ $responder->account_status }}
                        </span>
                        @elseif ($responder->account_status === 'Pending')
                        <span class="px-2 py-1 rounded text-white text-xs font-[Poppins] bg-orange-500">
                            {{ $responder->account_status }}
                        </span>
                        @else
                        <span class="px-2 py-1 rounded text-white text-xs font-[Poppins] bg-red-500">
                            {{ $responder->account_status }}
                        </span>
                        @endif
                    </td>

                    <!-- Availability Status -->
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-white text-xs font-[Poppins]
                    {{ $responder->availability_status === 'Available' ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ $responder->availability_status }}
                        </span>
                    </td>

                    <!-- Created At -->
                    <td class="px-4 py-3">
                        {{ $responder->created_at ? $responder->created_at->format('Y-m-d H:i') : '—' }}
                    </td>

                    <!-- Updated At -->
                    <td class="px-4 py-3">
                        {{ $responder->updated_at ? $responder->updated_at->format('Y-m-d H:i') : '—' }}
                    </td>

                    <!-- Deleted At -->
                    <td class="px-4 py-3">
                        {{ $responder->deleted_at ? $responder->deleted_at->format('Y-m-d H:i') : '—' }}
                    </td>

                    <!-- Actions -->
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2 items-center">
                            @if ($responder->trashed())
                            <!-- Restore Button -->
                            <form action="{{ route('admin.restore-responders', $responder->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-3 py-1 rounded bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-[Poppins]">
                                    Restore
                                </button>
                            </form>

                            <!-- Force Delete Button -->
                            <form action="{{ route('admin.force-delete-responders', $responder->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to permanently delete this responder? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 rounded bg-red-700 hover:bg-red-800 text-white text-xs font-[Poppins]">
                                    Force Delete
                                </button>
                            </form>

                            @elseif ($responder->account_status === 'Pending')
                            <!-- Accept Button -->
                            <form action="{{ route('admin.accept-responders', $responder->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-3 py-1 rounded bg-green-500 hover:bg-green-600 text-white text-xs font-[Poppins]">
                                    Accept
                                </button>
                            </form>

                            <!-- Decline Button -->
                            <form action="{{ route('admin.decline-responders', $responder->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-3 py-1 rounded bg-red-500 hover:bg-red-600 text-white text-xs font-[Poppins]">
                                    Decline
                                </button>
                            </form>

                            @else
                            <!-- View Button -->
                            <a href="{{ route('admin.view-responder', $responder->id) }}"
                                class="px-3 py-1 rounded bg-blue-500 hover:bg-blue-600 text-white text-xs font-[Poppins]">
                                View
                            </a>

                            <!-- Edit Button -->
                            <a href="{{ route('admin.edit-responders', $responder->id) }}"
                                class="px-3 py-1 rounded bg-green-500 hover:bg-green-600 text-white text-xs font-[Poppins]">
                                Edit
                            </a>

                            <!-- Soft Delete Button -->
                            <form action="{{ route('bfp.delete-responders', $responder->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 rounded bg-red-500 hover:bg-red-600 text-white text-xs font-[Poppins]">
                                    Delete
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-4 py-3 text-center text-gray-500">
                        No responders found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-5 flex justify-center">
        {{ $responders->appends(request()->query())->links() }}
    </div>

    <x-partials.stack-js />
</x-layout.layout>