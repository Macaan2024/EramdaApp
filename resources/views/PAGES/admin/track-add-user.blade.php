<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Page Title -->
    <h6 class="font-medium font-[Poppins] text-[16px] mb-4">📊 Logs Management</h6>

    <!-- Navigation Links -->
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('admin.logs-responder', 'All') }}" class="px-4 py-2 bg-white dark:bg-gray-800 shadow rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-blue-600 hover:text-white transition">Personnel Responders</a>
        <a href="#" class="px-4 py-2 bg-white dark:bg-gray-800 shadow rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-green-600 hover:text-white transition">Emergency Vehicles</a>
        <a href="#" class="px-4 py-2 bg-white dark:bg-gray-800 shadow rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-red-600 hover:text-white transition">Injuries</a>
        <a href="#" class="px-4 py-2 bg-white dark:bg-gray-800 shadow rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-purple-600 hover:text-white transition">Attendance</a>
        <a href="#" class="px-4 py-2 bg-white dark:bg-gray-800 shadow rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-600 hover:text-white transition">Deployments</a>
        <a href="#" class="px-4 py-2 bg-white dark:bg-gray-800 shadow rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-yellow-600 hover:text-white transition">Reports</a>
        <a href="#" class="px-4 py-2 bg-white dark:bg-gray-800 shadow rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-pink-600 hover:text-white transition">Requests</a>
        <a href="#" class="px-4 py-2 bg-white dark:bg-gray-800 shadow rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-teal-600 hover:text-white transition">ER Beds</a>
        <a href="#" class="px-4 py-2 bg-white dark:bg-gray-800 shadow rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-cyan-600 hover:text-white transition">Hospital Services</a>
    </div>

    <!-- Statistics Overview -->
    <h6 class="font-semibold text-[14px] text-gray-800 dark:text-gray-100 mb-4"> Overview</h6>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Responders -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div class="text-blue-600 text-4xl mb-2">👨‍🚒</div>
            <h4 class="text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Total Responders</h4>
            <p class="text-3xl font-bold text-blue-600">128</p>
        </div>

        <!-- Available Vehicles -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div class="text-green-600 text-4xl mb-2">🚑</div>
            <h4 class="text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Available Vehicles</h4>
            <p class="text-3xl font-bold text-green-600">16</p>
        </div>

        <!-- Injuries -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div class="text-red-600 text-4xl mb-2">🤕</div>
            <h4 class="text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Reported Injuries</h4>
            <p class="text-3xl font-bold text-red-600">54</p>
        </div>

        <!-- Attendance -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div class="text-purple-600 text-4xl mb-2">📝</div>
            <h4 class="text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Attendance Logs</h4>
            <p class="text-3xl font-bold text-purple-600">320</p>
        </div>

        <!-- Deployments -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div class="text-indigo-600 text-4xl mb-2">🚀</div>
            <h4 class="text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Active Deployments</h4>
            <p class="text-3xl font-bold text-indigo-600">42</p>
        </div>

        <!-- Reports -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div class="text-yellow-600 text-4xl mb-2">📄</div>
            <h4 class="text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Pending Reports</h4>
            <p class="text-3xl font-bold text-yellow-600">7</p>
        </div>

        <!-- Requests -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div class="text-pink-600 text-4xl mb-2">📩</div>
            <h4 class="text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Open Requests</h4>
            <p class="text-3xl font-bold text-pink-600">12</p>
        </div>

        <!-- ER Beds -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div class="text-teal-600 text-4xl mb-2">🛏️</div>
            <h4 class="text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Available ER Beds</h4>
            <p class="text-3xl font-bold text-teal-600">25</p>
        </div>

        <!-- Hospital Services -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div class="text-cyan-600 text-4xl mb-2">🏥</div>
            <h4 class="text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Hospital Services</h4>
            <p class="text-3xl font-bold text-cyan-600">9</p>
        </div>
    </div>

    <x-partials.stack-js />
</x-layout.layout>