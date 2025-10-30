<x-layout.layout>

    <x-partials.toast-messages />

    <div class="max-w-4xl mx-auto bg-gray-200 dark:bg-gray-800 rounded-2xl shadow-lg p-6 sm:p-10">
        <!-- Title -->
        <h4 class="bg-blue-700 p-2 rounded-sm text-white mb-6 text-center font-[Poppins] text-[16px] font-semibold text-gray-800 dark:text-gray-200">
            User Profile
        </h4>

        <!-- Profile Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-8">
            <!-- Profile Picture -->
            <div class="flex justify-center mb-6 sm:mb-0">
                <img src="{{ asset('storage/' . $responder->photo) }}"
                    alt="Profile Photo"
                    class="w-28 h-28 sm:w-36 sm:h-36 rounded-full object-cover shadow-md border-4 border-gray-200 dark:border-gray-700">
            </div>

            <!-- User Basic Info -->
            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm sm:text-[13px] font-[Poppins]">
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Lastname</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $responder->lastname }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Firstname</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $responder->firstname }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Email</p>
                    <p class="font-semibold text-gray-800 dark:text-white break-words">{{ $responder->email }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Contact Number</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $responder->contact_number }}</p>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="my-6 border-t border-gray-200 dark:border-gray-700"></div>

        <!-- More Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm sm:text-[13px] font-[Poppins]">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Agency</p>
                <p class="font-semibold text-gray-800 dark:text-white">{{ $responder->agency?->agencyTypes ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Role</p>
                <p class="font-semibold text-gray-800 dark:text-white">{{ $responder->user_type }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Position</p>
                <p class="font-semibold text-gray-800 dark:text-white">{{ $responder->position }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Gender</p>
                <p class="font-semibold text-gray-800 dark:text-white">
                    {{ $responder->gender === 'm' ? 'Male' : 'Female' }}
                </p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Account Status</p>
                <p class="font-semibold {{ $responder->account_status === 'Approved' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $responder->account_status }}
                </p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Availability</p>
                <p class="font-semibold text-gray-800 dark:text-white">{{ $responder->availability_status ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
    <x-partials.stack-js />
</x-layout.layout>