<div id="drawer-navigation"
    class="fixed top-0 left-0 z-40 w-64 h-screen p-4 overflow-y-auto bg-blue-800 border-r border-gray-200 -translate-x-full transition-transform duration-300 ease-out dark:bg-gray-800 dark:border-gray-700">

    <div class="flex items-center justify-between border-b border-blue-600 pb-4 dark:border-gray-700 mt-16 text-white">
        <h6 class="text-[16px] font-medium font-[Poppins]">Emergency Response Application</h6>
        <button type="button" data-drawer-hide="drawer-navigation" class="text-white hover:text-gray-200 transition duration-150" aria-controls="drawer-navigation">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <ul class="mt-5 space-y-1 font-medium text-white dark:text-gray-400">

        @if (auth()->user()->user_type === 'admin')
        <li>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700 dark:hover:bg-gray-700 transition duration-150 group">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                <span class="ml-3 font-[Poppins] text-[12px]">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.user', 'All') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700 dark:hover:bg-gray-700 transition duration-150 group">
                <span class="material-symbols-outlined">
                    groups
                </span>
                <span class="ml-3 font-[Poppins] text-[12px]">User Management</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.agency') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700 dark:hover:bg-gray-700 transition duration-150 group">
                <span class="material-symbols-outlined">
                    apartment
                </span>
                <span class="ml-3 font-[Poppins] text-[12px]">Agency Management</span>
            </a>
        </li>
        <li>
            <button type="button" class="flex items-center justify-between w-full p-2 rounded-lg hover:bg-blue-700 dark:hover:bg-gray-700 transition duration-150 group"
                aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                <div class="flex items-center">
                    <span class="material-symbols-outlined">
                        e911_emergency
                    </span>
                    <span class="ml-3 whitespace-nowrap font-[Poppins] text-[12px]">Incident Report</span>
                </div>
                <svg class="w-3 h-3 transition-transform duration-200 transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                </svg>
            </button>
            <ul id="dropdown-example" class="hidden py-2 space-y-1 pl-4 border-l border-blue-600 dark:border-gray-600 ml-2">
                <li><a href="{{ route('admin.agency-category') }}" class="block py-2 px-3 rounded-lg hover:bg-blue-700/50 dark:hover:bg-gray-700 transition duration-150 font-[Poppins] text-[12px]">Agency Category</a></li>
                <li><a href="#" class="block py-2 px-3 rounded-lg hover:bg-blue-700/50 dark:hover:bg-gray-700 transition duration-150 font-[Poppins] text-[12px]">Barangay Category</a></li>
            </ul>
        </li>
        @elseif (auth()->user()->user_type === 'operation-officer')
        <li>
            <a href="{{ route('operation-officer.dashboard') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700 dark:hover:bg-gray-700 transition duration-150 group">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                <span class="ml-3 font-[Poppins] text-[12px]">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('operation-officer.responder') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700 dark:hover:bg-gray-700 transition duration-150 group">
                <span class="material-symbols-outlined">
                    groups
                </span>
                <span class="ml-3 font-[Poppins] text-[12px]">Responders Management</span>
            </a>
        </li>
        <li>
            <a href="{{ route('operation-officer.vehicle') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700 dark:hover:bg-gray-700 transition duration-150 group">
                <span class="material-symbols-outlined">
                    fire_truck
                </span>
                <span class="ml-3 font-[Poppins] text-[12px]">Emergency Vehicle Management</span>
            </a>
        </li>
        <li>
            <button type="button" class="flex items-center justify-between w-full p-2 rounded-lg hover:bg-blue-700 dark:hover:bg-gray-700 transition duration-150 group"
                aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                <div class="flex items-center">
                    <span class="material-symbols-outlined">
                        e911_emergency
                    </span>
                    <span class="ml-3 whitespace-nowrap font-[Poppins] text-[12px]">Incident Report</span>
                </div>
                <svg class="w-3 h-3 transition-transform duration-200 transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                </svg>
            </button>
            <ul id="dropdown-example" class="hidden py-2 space-y-1 pl-4 border-l border-blue-600 dark:border-gray-600 ml-2">
                <li><a href="{{ route('operation-officer.submitted-report') }}" class="block py-2 px-3 rounded-lg hover:bg-blue-700/50 dark:hover:bg-gray-700 transition duration-150 font-[Poppins] text-[12px]">Submitted Report</a></li>
                <li><a href="{{ route('operation-officer.receive') }}" class="block py-2 px-3 rounded-lg hover:bg-blue-700/50 dark:hover:bg-gray-700 transition duration-150 font-[Poppins] text-[12px]">Receive Report</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="flex items-center p-2 rounded-lg hover:bg-blue-700 dark:hover:bg-gray-700 transition duration-150 group">
                <span class="material-symbols-outlined">
                    data_check
                </span>
                <span class="ml-3 font-[Poppins] text-[12px]">Attendance Management</span>
            </a>
        </li>
        @endif
    </ul>
</div>