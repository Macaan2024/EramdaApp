{{-- resources/views/PAGES/BFP/view-vehicle.blade.php --}}
<x-layout.layout>

    <x-partials.toast-messages />

    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl overflow-hidden">
        <!-- Header with Photo -->
        <div class="relative">
            @if($vehicles->vehicle_photo)
                <img src="{{ asset('storage/' . $vehicles->vehicle_photo) }}" 
                     alt="Vehicle Photo"
                     class="w-full h-56 object-fit">
            @else
                <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500 text-sm font-[Poppins]">No photo available</span>
                </div>
            @endif
            <div class="absolute top-4 left-4">
                <a href="{{ route('bfp.vehicles') }}" 
                   class="bg-white/80 backdrop-blur px-3 py-1 rounded-lg text-xs font-[Poppins] text-gray-700 hover:bg-gray-100">
                    ← Back
                </a>
            </div>
        </div>

        <!-- Info Section -->
        <div class="p-6 md:p-8">
            <h2 class="text-2xl font-bold text-gray-800 font-[Poppins] mb-1">
                {{ $vehicles->vehicleTypes }}
            </h2>
            <p class="text-gray-500 text-sm font-[Poppins] mb-4">Plate No: {{ $vehicles->plateNumber }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-1 font-[Poppins]">Vehicle Type</h3>
                    <p class="text-gray-600 font-[Poppins]">{{ $vehicles->vehicleTypes }}</p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-700 mb-1 font-[Poppins]">Plate Number</h3>
                    <p class="text-gray-600 font-[Poppins]">{{ $vehicles->plateNumber }}</p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-700 mb-1 font-[Poppins]">Availability</h3>
                    <span class="inline-block px-3 py-1 text-xs rounded text-white font-[Poppins]
                        {{ ($vehicles->availabilityStatus) === 'Available' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ ucfirst($vehicles->availabilityStatus) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

</x-layout.layout>
