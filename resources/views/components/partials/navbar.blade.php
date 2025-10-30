<!-- ================= NAVBAR (Top Navigation Bar) ================= -->
<nav class="fixed top-0 z-50 w-full bg-blue-700 shadow-md">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">

            <!-- ===== LEFT SIDE: Menu Button + Logo ===== -->
            <div class="flex items-center justify-start rtl:justify-end">
                <!-- Sidebar Toggle -->
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-200 rounded-lg sm:hidden hover:bg-blue-600 
                 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 
                 0 010 1.5H2.75A.75.75 0 012 4.75zm0 
                 10.5a.75.75 0 01.75-.75h7.5a.75.75 
                 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 
                 10a.75.75 0 01.75-.75h14.5a.75.75 
                 0 010 1.5H2.75A.75.75 0 012 10z" />
                    </svg>
                </button>

                <!-- Logo + Title -->
                <a href="{{ url('/BFP/dashboard') }}" class="flex ms-2 md:me-24">
                    <span class="self-center font-[Poppins] text-white text-[16px] font-semibold whitespace-nowrap">
                        Emergency Response Application
                    </span>
                </a>
            </div>
            <!-- ===== END LEFT SIDE ===== -->

            <!-- ===== RIGHT SIDE: User Profile Dropdown ===== -->
            <div class="flex items-center">
                <div class="relative ms-3">
                    <!-- Profile Button -->
                    <button type="button"
                        class="flex items-center text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-blue-300"
                        aria-expanded="false" data-dropdown-toggle="dropdown-user">
                        <img class="w-9 h-9 rounded-full border-2 border-white"
                            src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                    </button>

                    <!-- Dropdown -->
                    <div id="dropdown-user"
                        class="absolute right-0 z-50 hidden w-56 mt-2 text-base bg-white rounded-lg shadow-lg divide-y divide-gray-100 dark:bg-gray-800 dark:divide-gray-700">

                        <!-- User Info -->
                        <div class="px-4 py-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                            </p>
                            <p class="text-xs text-gray-500 truncate dark:text-gray-400">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <!-- Menu Items -->
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                            <li>
                                <a href="#"
                                    class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="material-symbols-outlined mr-1">
                                        person_edit
                                    </span>
                                    Edit Profile
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="material-symbols-outlined mr-1">
                                        settings
                                    </span>
                                    Settings
                                </a>
                            </li>
                        </ul>

                        <!-- Logout -->
                        <div class="py-2">
                            <form action="{{ url('submit-logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-gray-700">
                                    <span class="material-symbols-outlined mr-1">
                                        logout
                                    </span>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ===== END RIGHT SIDE ===== -->

        </div>
    </div>
</nav>
<!-- ================= END NAVBAR ================= -->