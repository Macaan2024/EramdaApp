<x-layout.layout>

    <!-- Main Container -->
    <div class="max-w-6xl mx-auto dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">

        <!-- Profile Section -->
        <div class="p-6 sm:p-10 bg-gray-50">


            <!-- Logs Table -->
            <h5 class="text-lg font-[Poppins] font-semibold mb-4 text-gray-700 dark:text-gray-200">User Profile</h5>

            <!-- Divider -->
            <div class="my-8 border-t border-gray-200 dark:border-gray-700"></div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-8">
                <!-- Profile Picture -->
                <div class="flex justify-center mb-6 sm:mb-0">
                    <img src="{{ asset('storage/' . $user->photo) }}"
                        alt="Profile Photo"
                        class="w-28 h-28 sm:w-36 sm:h-36 rounded-full object-cover shadow-md border-4 border-gray-200 dark:border-gray-700">
                </div>

                <!-- User Info -->
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm sm:text-[13px] font-[Poppins]">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Lastname</p>
                        <p class=" text-gray-800 dark:text-white">{{ $user->lastname }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Firstname</p>
                        <p class=" text-gray-800 dark:text-white">{{ $user->firstname }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Email</p>
                        <p class=" text-gray-800 dark:text-white break-words">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Contact Number</p>
                        <p class=" text-gray-800 dark:text-white">{{ $user->contact_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Agency</p>
                        <p class=" text-gray-800 dark:text-white">{{ $user->agency?->agencyTypes ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Role</p>
                        <p class="text-gray-800 dark:text-white">{{ $user->user_type }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Position</p>
                        <p class="text-gray-800 dark:text-white">{{ $user->position }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Gender</p>
                        <p class=" text-gray-800 dark:text-white">
                            {{ $user->gender === 'm' ? 'Male' : 'Female' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Account Status</p>
                        <p class=" {{ $user->account_status === 'Approved' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $user->account_status }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Availability</p>
                        <p class=" {{ $user->availability_status === 'Available' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $user->availability_status }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="my-8 border-t border-gray-200 dark:border-gray-700"></div>

            <!-- Logs Table -->
            <h5 class="text-lg font-[Poppins] font-semibold mb-4 text-gray-700 dark:text-gray-200">Activity Logs</h5>
            <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="w-full text-sm font-[Poppins] text-gray-700 dark:text-gray-300">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Interaction Type</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Created At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150
                            {{ $id == $log->id ? 'bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap {{ $id == $log->id ? 'font-bold text-blue-700 dark:text-blue-400' : '' }}">
                                {{ $loop->iteration + ($logs->firstItem() - 1) }}
                            </td>
                            <td class="px-6 py-4 px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ $log->interaction_type }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ $log->created_at->format('Y-m-d H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">No logs found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

</x-layout.layout>