<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Page Title -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h6 class="text-[16px] sm:text-[18px] font-[Poppins] font-semibold text-gray-800 mb-2 sm:mb-0">
            User Logs
        </h6>
    </div>

    <!-- Stats Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start gap-6 font-[Poppins] mb-6">
        <div class="w-full lg:w-1/2 flex flex-wrap gap-4 justify-start">
            <!-- Added -->
            <div class="bg-blue-600 text-white rounded-[10px] px-6 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 w-[45%] sm:w-auto text-center">
                <h3 class="text-[13px] sm:text-[14px] font-medium mb-1 opacity-90">Total Added</h3>
                <p class="text-[18px] sm:text-[20px] font-semibold">{{ $addedCount }}</p>
            </div>
            <!-- Edited -->
            <div class="bg-green-600 text-white rounded-[10px] px-6 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 w-[45%] sm:w-auto text-center">
                <h3 class="text-[13px] sm:text-[14px] font-medium mb-1 opacity-90">Total Edited</h3>
                <p class="text-[18px] sm:text-[20px] font-semibold">{{ $editedCount }}</p>
            </div>
            <!-- Deleted -->
            <div class="bg-red-600 text-white rounded-[10px] px-6 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 w-[45%] sm:w-auto text-center">
                <h3 class="text-[13px] sm:text-[14px] font-medium mb-1 opacity-90">Total Deleted</h3>
                <p class="text-[18px] sm:text-[20px] font-semibold">{{ $deletedCount }}</p>
            </div>
            <!-- Restored -->
            <div class="bg-gray-600 text-white rounded-[10px] px-6 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 w-[45%] sm:w-auto text-center">
                <h3 class="text-[13px] sm:text-[14px] font-medium mb-1 opacity-90">Total Restored</h3>
                <p class="text-[18px] sm:text-[20px] font-semibold">{{ $restoredCount }}</p>
            </div>
        </div>
    </div>

    <!-- Search + Filters -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 my-6 font-[Poppins]">
        <!-- Search -->
        <form class="w-full md:max-w-md flex" action="" method="GET">
            <div class="relative w-full">
                <input type="search" id="search-users"
                    class="block w-full p-3 ps-10 text-[12px] sm:text-[13px] text-gray-800 border border-gray-300 rounded-[10px] bg-white shadow-sm 
                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="Search users..." name="search" value="{{ request('search') }}" />
                <button type="submit"
                    class="absolute end-2.5 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white rounded-[10px] text-[12px] sm:text-[13px] font-medium px-4 py-2 transition">
                    Search
                </button>
            </div>
        </form>

        <!-- Agency Filter -->
        <form class="w-full md:w-auto">
            <select
                onchange="
            if (this.value) {
                window.location.href = '/admin/logs-users/{{ $status }}/' + this.value;
            } else {
                window.location.href = '/admin/logs-users/All';
            }
        "
                class="block w-full p-3 text-[12px] sm:text-[13px] text-gray-800 border border-gray-300 rounded-[10px] bg-white shadow-sm 
        focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">Select Agency</option>
                @forelse ($agencies as $agency)
                <option value="{{ $agency->id }}" {{ $id == $agency->id ? 'selected' : '' }}>
                    {{ $agency->agencyNames }}
                </option>
                @empty
                <option disabled>No agencies found</option>
                @endforelse
            </select>
        </form>
    </div>

    <!-- Status Buttons + Add User -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
        <div class="flex flex-wrap gap-3 text-[12px] sm:text-[13px] font-[Poppins]">
            <a href="/admin/logs-users/All/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'All' ? 'bg-gray-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">All</a>
            <a href="/admin/logs-users/Add/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Add' ? 'bg-blue-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Added</a>
            <a href="/admin/logs-users/Update/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Update' ? 'bg-green-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Edited</a>
            <a href="/admin/logs-users/Delete/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Delete' ? 'bg-red-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Deleted</a>
            <a href="/admin/logs-users/Restored/{{ $id ?? '' }}"
                class="px-5 py-2 rounded-[10px] border shadow-sm transition 
                {{ $status === 'Restored' ? 'bg-gray-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' }}">Restored</a>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="overflow-x-auto shadow-lg rounded-[10px] border border-gray-200 bg-white font-[Poppins]">
        <table class="min-w-full text-[12px] sm:text-[13px] text-gray-700">
            <thead class="bg-gradient-to-r from-blue-600 to-green-600 text-white uppercase">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left">No</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Image</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Name</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Agency</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Interaction</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Created At</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Updated At</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($logs as $log)
                <tr class="hover:bg-blue-50 transition duration-200">
                    <td class="px-4 sm:px-6 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 sm:px-6 py-3">
                        @if ($log->user && $log->user->photo)
                        <img src="{{ asset('storage/' . $log->user->photo) }}"
                            alt="User Image" class="w-14 h-14 sm:w-16 sm:h-16 object-cover rounded-full border shadow-sm">
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 sm:px-6 py-3">{{ $log->user->firstname . ' ' .  $log->user->lastname ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $log->user->agency->agencyNames ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3 font-semibold">
                        @php
                        $type = $log->interaction_type;
                        $textColor = match($type) {
                        'Add' => 'text-blue-600',
                        'Update' => 'text-green-600',
                        'Delete' => 'text-red-600',
                        default => 'text-gray-700',
                        };
                        @endphp
                        <span class="{{ $textColor }}">{{ $log->interaction_type }}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-3">{{ $log->created_at?->format('Y-m-d H:i') ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $log->updated_at?->format('Y-m-d H:i') ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">
                        <div class="flex flex-row gap-4 items-center">
                            <button type="button"
                                class="track-btn px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-blue-600 text-white shadow-sm hover:bg-blue-700 hover:shadow-md transition-all duration-200"
                                data-user-id="{{ $log->user->id ?? '' }}">
                                Track
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500 text-[12px]">
                        No user logs found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex justify-center">
        {{ $logs->appends(request()->except('logs_page'))->links() }}
    </div>

    <!-- Second Table -->
    <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
    <h6 class="text-[14px] sm:text-[16px] font-[Poppins] font-semibold text-gray-800 my-6">Users Table Data</h6>

    <!-- Add User -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
        <div class="w-full lg:w-1/2 flex flex-wrap gap-4 justify-start">
            <!-- Added -->
            <div class="bg-blue-600 text-white rounded-[10px] px-6 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 w-[45%] sm:w-auto text-center">
                <h3 class="text-[13px] sm:text-[14px] font-medium mb-1 opacity-90">Total Pending</h3>
                <p class="text-[18px] sm:text-[20px] font-semibold">{{ $pendingCount }}</p>
            </div>
            <!-- Edited -->
            <div class="bg-green-600 text-white rounded-[10px] px-6 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 w-[45%] sm:w-auto text-center">
                <h3 class="text-[13px] sm:text-[14px] font-medium mb-1 opacity-90">Total Active</h3>
                <p class="text-[18px] sm:text-[20px] font-semibold">{{ $activeCount }}</p>
            </div>
            <!-- Deleted -->
            <div class="bg-red-600 text-white rounded-[10px] px-6 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 w-[45%] sm:w-auto text-center">
                <h3 class="text-[13px] sm:text-[14px] font-medium mb-1 opacity-90">Total Deactivate</h3>
                <p class="text-[18px] sm:text-[20px] font-semibold">{{ $deactivateCount }}</p>
            </div>
            <!-- Restored -->
        </div>
        <div class="w-full sm:w-auto">
            <a class="bg-gray-600 text-white py-3 px-6 rounded-[10px] hover:bg-gray-900 transition text-[12px] sm:text-[13px] font-[Poppins] font-medium block text-center sm:inline-block"
                href="{{ route('admin.logs-users-add') }}">
                Add Users
            </a>
        </div>
    </div>

    <!-- Users Table -->
    <div class="overflow-x-auto shadow-lg rounded-[10px] border border-gray-200 bg-white font-[Poppins]">
        <table class="min-w-full text-[12px] sm:text-[13px] text-gray-700">
            <thead class="bg-gradient-to-r from-blue-600 to-green-600 text-white uppercase">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left">No</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Image</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Name</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Email</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Role</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Agency</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Position</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Account Status</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Availability</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($users as $user)
                <tr id="user-{{ $user->id }}" class="hover:bg-blue-50 transition duration-200">
                    <td class="px-4 sm:px-6 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 sm:px-6 py-3">
                        @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}"
                            alt="User Image" class="w-14 h-14 sm:w-16 sm:h-16 object-cover rounded-full border shadow-sm">
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 sm:px-6 py-3">{{ $user->firstname . ' ' . $user->lastname }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $user->email ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $user->user_type ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $user->agency->agencyNames ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $user->position ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $user->account_status ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">{{ $user->availability_status ?? '—' }}</td>
                    <td class="px-4 sm:px-6 py-3">
                        @if (!$user->trashed())
                        <a href="{{ route('admin.logs-view-users', $user->id) }}"
                            class="px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-blue-600 text-white shadow-sm hover:bg-blue-700 hover:shadow-md transition-all duration-200">
                            View
                        </a>
                        @else
                        <form action="{{ route('admin.logs-restore-users', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="px-4 py-2 text-[12px] sm:text-[13px] font-medium rounded-[10px] bg-green-600 text-white shadow-sm hover:bg-green-700 hover:shadow-md transition-all duration-200">
                                Restore
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 text-[12px]">
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex justify-center">
        {{ $users->appends(request()->except('users_page'))->links() }}
    </div>

    <x-partials.stack-js />
    <!-- Track JS -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const trackButtons = document.querySelectorAll(".track-btn");

            trackButtons.forEach(button => {
                button.addEventListener("click", () => {
                    const userId = button.dataset.userId;
                    if (!userId) return;

                    const url = new URL(window.location.href);
                    url.searchParams.set("track_user_id", userId);
                    window.location.href = url.toString();
                });
            });

            const params = new URLSearchParams(window.location.search);
            const trackId = params.get("track_user_id");

            if (trackId) {
                const targetRow = document.getElementById(`user-${trackId}`);
                if (targetRow) {
                    targetRow.classList.add("bg-yellow-200");
                    targetRow.scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });
                    setTimeout(() => targetRow.classList.remove("bg-yellow-200"), 2000);
                } else {
                    alert("The user is not on this page. Please go to the next/previous page.");
                }
            }
        });
    </script>

    <style>
        @keyframes flashHighlight {
            0% {
                background-color: #fef08a;
            }

            50% {
                background-color: #fde047;
            }

            100% {
                background-color: #fef08a;
            }
        }

        .bg-yellow-200 {
            animation: flashHighlight 1s ease-in-out;
        }
    </style>

</x-layout.layout>