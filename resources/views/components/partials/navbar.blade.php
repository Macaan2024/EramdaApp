<nav class="fixed top-0 z-50 w-full bg-blue-700 shadow-xl transition-colors duration-300">
    <div class="px-4 py-3 lg:px-6 lg:pl-3 flex items-center justify-between">

        <div class="flex items-center">
            <button data-drawer-target="drawer-navigation" data-drawer-show="drawer-navigation" type="button"
                class="inline-flex items-center p-2 text-sm text-white rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600 transition duration-150 ease-in-out"
                aria-controls="drawer-navigation" aria-expanded="false">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>

        <div class="flex items-center">
            <div class="relative">
                <button type="button" data-dropdown-toggle="dropdown-user"
                    class="flex items-center text-sm bg-gray-700 rounded-full focus:ring-4 focus:ring-gray-500 hover:opacity-90 transition duration-150"
                    aria-expanded="false" data-dropdown-placement="bottom-end">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-10 h-10 rounded-full border-2 border-white object-cover"
                        src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                </button>

                <div id="dropdown-user"
                    class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl divide-y divide-gray-100 dark:bg-gray-700 dark:divide-gray-600 z-50">
                    <div class="px-4 py-3">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</p>
                        <p class="text-xs text-gray-500 truncate dark:text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                        <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-150"><span class="material-symbols-outlined mr-2 text-lg">person_edit</span>Edit Profile</a></li>
                        <li><a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-150"><span class="material-symbols-outlined mr-2 text-lg">settings</span>Settings</a></li>
                    </ul>
                    <div class="py-2">
                        <form action="{{ url('submit-logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-gray-600 dark:text-red-400 dark:hover:text-red-300 transition duration-150">
                                <span class="material-symbols-outlined mr-2 text-lg">logout</span>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>