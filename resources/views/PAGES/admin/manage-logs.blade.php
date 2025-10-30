<x-layout.layout>
    <x-partials.toast-messages />

    <!-- Page Title -->
    <h6 class="font-medium font-[Poppins] text-[16px] mb-6">Logs Management</h6>

    <!-- Navigation Links -->
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('admin.logs-users', 'All') }}" class="px-4 py-2 bg-blue-600 shadow rounded-[10px] text-sm font-[Poppins] font-medium text-white hover:bg-blue-700 transition">Personnel Responders</a>
        <a href="{{ route('admin.logs-vehicles', 'All') }}" class="px-4 py-2 bg-green-600 shadow rounded-[10px] text-sm font-[Poppins] font-medium text-white hover:bg-green-700 transition">Emergency Vehicles</a>
        <a href="#" class="px-4 py-2 bg-red-600 shadow rounded-[10px] text-sm font-[Poppins] font-medium text-white hover:bg-red-700 transition">Injuries</a>
        <a href="#" class="px-4 py-2 bg-purple-600 shadow rounded-[10px] text-sm font-[Poppins] font-medium text-white hover:bg-purple-700 transition">Attendance</a>
        <!-- Add other links similarly -->
    </div>

    <x-partials.stack-js />
</x-layout.layout>