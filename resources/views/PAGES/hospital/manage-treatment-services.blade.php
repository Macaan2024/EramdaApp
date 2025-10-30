<x-layout.layout>

    <x-partials.toast-messages />

    <div class="p-4 sm:p-6 bg-gray-100 min-h-screen font-['Roboto']">

        <!-- Inner White Container -->
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow">

            <!-- Title -->
            <h6 class="font-[Poppins] text-[14px] sm:text-[16px] mb-2 sm:mb-3 text-gray-800 font-semibold">Treatment Services</h6>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 mb-3 sm:mb-4">
                <div class="bg-blue-900 text-white rounded-xl shadow-sm p-2 sm:p-3 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[11px] sm:text-[13px] font-medium">Total Services</h4>
                    <p class="text-lg sm:text-xl font-bold mt-1">{{ $serviceTotal }}</p>
                </div>

                <div class="bg-green-800 text-white rounded-xl shadow-sm p-2 sm:p-3 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[11px] sm:text-[13px] font-medium">Total Available</h4>
                    <p class="text-lg sm:text-xl font-bold mt-1">{{ $servicesAvailable }}</p>
                </div>

                <div class="bg-red-800 text-white rounded-xl shadow-sm p-2 sm:p-3 flex flex-col items-center">
                    <h4 class="font-[Poppins] text-[11px] sm:text-[13px] font-medium">Total Unavailable</h4>
                    <p class="text-lg sm:text-xl font-bold mt-1">{{ $servicesUnavailable }}</p>
                </div>
            </div>

            <!-- Search & Add -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                <form class="w-full md:max-w-md relative">
                    <div class="relative">
                        <input type="search" id="search-bed"
                            class="block w-full md:w-full p-2 sm:p-3 ps-8 sm:ps-10 text-[11px] sm:text-[12px] font-[Poppins] text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search Services..." name="search" value="{{ request('search') }}" />

                        <button type="submit"
                            class="text-white absolute end-2.5 top-1/2 -translate-y-1/2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-[10px] sm:text-[12px] font-[Poppins] px-2 sm:px-4 py-1 sm:py-2">
                            Search
                        </button>
                    </div>
                </form>
                <div class="flex flex-wrap gap-1 sm:gap-2 mt-2 sm:mt-0">
                    <x-partials.modality-add-treatment-services />
                </div>
            </div>

            <!-- Filter Buttons & Category -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-1 sm:gap-2 mb-3">
                <form method="GET" class="flex flex-col sm:flex-row gap-1 sm:gap-2 items-start sm:items-center">
                    <label class="text-[10px] sm:text-[12px] font-[Poppins]">Filter Category:</label>
                    <select name="category" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-1 sm:px-2 py-1 text-[10px] sm:text-[12px] font-[Roboto] focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        <option value="All" {{ request('category') == 'All' ? 'selected' : '' }}>All</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Services Table -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">
                <table class="w-full text-[10px] sm:text-[12px] font-[Roboto] text-gray-700 min-w-[500px]">
                    <thead class="bg-blue-600 text-white font-[Poppins] text-[11px] sm:text-[12px] uppercase">
                        <tr>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium">No</th>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium">Service Name</th>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium">Category</th>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium">Status</th>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium">Created At</th>
                            <th class="px-1 py-1 sm:px-3 sm:py-2 font-medium text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                            <tr class="bg-white hover:bg-gray-100 border-b border-gray-200">
                                <td class="px-1 py-1 sm:px-3 sm:py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="px-1 py-1 sm:px-3 sm:py-2">{{ $service->serviceName }}</td>
                                <td class="px-1 py-1 sm:px-3 sm:py-2">{{ $service->category }}</td>
                                <td class="px-1 py-1 sm:px-3 sm:py-2 text-center">
                                    <span class="px-2 py-1 rounded-full text-white text-[9px] sm:text-[12px] font-[Poppins] {{ $service->serviceAvailability === 'Available' ? 'bg-green-600' : 'bg-red-600' }}">
                                        {{ $service->serviceAvailability }}
                                    </span>
                                </td>
                                <td class="px-1 py-1 sm:px-3 sm:py-2">{{ $service->created_at->format('M d, Y') }}</td>
                                <td class="px-1 py-1 sm:px-3 sm:py-2 text-center flex flex-wrap justify-center gap-1">
                                    <x-partials.modality-edit-treatment-services :service="$service" />
                                    <form action="{{ route('nurse-chief.delete-services', $service->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this service?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-2 py-1 sm:px-3 sm:py-1.5 rounded-lg text-[10px] sm:text-[12px] font-[Poppins] font-semibold bg-red-600 text-white hover:bg-red-700 shadow-md w-full sm:w-auto">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-1 py-1 text-center text-gray-500 text-[10px] sm:text-[12px]">
                                    No services found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 flex justify-center">
                {{ $services->appends(request()->except('users_page'))->links() }}
            </div>

        </div> <!-- End inner white container -->

    </div>

</x-layout.layout>
