<x-layout.layout>
    <div class="min-h-screen p-6 bg-gray-100">

        <!-- PAGE HEADER -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">BFP Dashboard</h1>
            <p class="text-gray-600 mt-1">Overview of responders, vehicles, and reports</p>
        </div>

        <!-- STAT CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Responders -->
            <div class="bg-white rounded-xl shadow p-5 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Responders</h3>
                <p class="text-4xl font-bold text-blue-600">{{ $responderCount }}</p>
                <p class="text-sm text-gray-500 mt-1">Available: <span class="font-medium text-green-600">{{ $responderAvailableCount }}</span></p>
            </div>

            <!-- Police Cars -->
            <div class="bg-white rounded-xl shadow p-5 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Police Cars</h3>
                <p class="text-4xl font-bold text-blue-600">{{ $policeVehicleCount }}</p>
                <p class="text-sm text-gray-500 mt-1">Available: <span class="font-medium text-green-600">{{ $policeVehicleAvailableCount }}</span></p>
            </div>

            <!-- Fire Trucks -->
            <div class="bg-white rounded-xl shadow p-5 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Fire Trucks</h3>
                <p class="text-4xl font-bold text-blue-600">{{ $fireTruckCount }}</p>
                <p class="text-sm text-gray-500 mt-1">Available: <span class="font-medium text-green-600">{{ $fireTruckAvailableCount }}</span></p>
            </div>

            <!-- Ambulances -->
            <div class="bg-white rounded-xl shadow p-5 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Ambulances</h3>
                <p class="text-4xl font-bold text-blue-600">{{ $ambulanceCount }}</p>
                <p class="text-sm text-gray-500 mt-1">Available: <span class="font-medium text-green-600">{{ $ambulanceAvailableCount }}</span></p>
            </div>

            <!-- Reports Today -->
            <div class="bg-white rounded-xl shadow p-5 border border-gray-200 col-span-1 sm:col-span-2 lg:col-span-3">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Reports Today</h3>
                <p class="text-4xl font-bold text-blue-600">{{ $reportTodayCount ?? 0 }}</p>
            </div>

        </div>
    </div>
</x-layout.layout>
