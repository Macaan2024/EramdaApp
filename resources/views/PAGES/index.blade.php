<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    {{-- Material Symbols Outlined Link --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    {{-- Custom Style for Material Symbols (to match size) --}}
    <style>
        .material-symbols-outlined {
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24;
            /* Default size for icons */
            font-size: 1.1rem; 
        }
    </style>

    <title>Emergency Response Application - Hotlines</title>
</head>

<body class="bg-gray-50">

    <header>
        <nav class="fixed top-0 z-50 w-full bg-blue-700 shadow-xl">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex flex-row items-center justify-between">

                    <div class="flex items-center justify-start rtl:justify-end">
                        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                            aria-controls="logo-sidebar" type="button"
                            class="inline-flex items-center p-2 text-sm text-gray-200 rounded-lg sm:hidden hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" />
                            </svg>
                        </button>

                        <a href="{{ url('/') }}" class="flex ms-2 md:me-24">
                            <span
                                class="self-center font-[Poppins] text-white text-[16px] font-semibold whitespace-nowrap">
                                Emergency Response Application
                            </span>
                        </a>
                    </div>
                    <div>
                        {{-- COOL EFFECT 1: Login Button Hover --}}
                        <a href="{{ route('login') }}"
                            class="text-white bg-blue-400 font-medium py-1 px-4 text-[14px] font-[Poppins] rounded-sm transition duration-300 transform hover:bg-blue-600 hover:scale-95 shadow-md hover:shadow-lg">
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        </header>

    <main class="pt-16 min-h-screen">
        <h4 class="px-8 py-4 font-[Poppins] text-base sm:text-lg font-bold bg-blue-100 text-blue-800 shadow-inner">
            <span class="material-symbols-outlined mr-2 align-middle">phone_in_talk</span> Agency Hotline Numbers
        </h4>

        <div class="px-4 sm:px-6 lg:px-8 py-6">
            {{-- Filter and Search Section --}}
            <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-center">
                
                {{-- Agency Type Filter --}}
                <div class="w-full sm:w-1/3">
                    <label for="agencyFilter" class="block text-xs font-medium text-gray-700 mb-1">Filter by Type</label>
                    {{-- COOL EFFECT 2: Select Hover/Focus --}}
                    <select name="agencyFilter" id="agencyFilter"
                        class="w-full bg-white text-xs text-gray-700 border border-gray-300 rounded-lg p-2 transition duration-200 focus:ring-4 focus:ring-blue-300 focus:border-blue-600 hover:border-blue-500">
                        <option value="ALL">Show All Agencies</option>
                        <option value="HOSPITAL">Hospital</option>
                        <option value="CDRRMO">City Disaster Risk Reduction and Management Office</option>
                        <option value="BFP">Bureau of Fire Protection (BFP)</option>
                        <option value="BDRRMC">Barangay DRRMC</option>
                    </select>
                </div>
                
                {{-- Quick Search --}}
                <div class="w-full sm:w-2/3">
                    <label for="agencySearch" class="block text-xs font-medium text-gray-700 mb-1">Search by Name or Address</label>
                    {{-- COOL EFFECT 3: Input Hover/Focus --}}
                    <input type="text" id="agencySearch" placeholder="E.g., Mercy Hospital or Tubod"
                        class="w-full bg-white text-xs border border-gray-300 rounded-lg p-2 transition duration-200 focus:ring-4 focus:ring-blue-300 focus:border-blue-600 hover:border-blue-500">
                </div>
            </div>


            {{-- Agencies List Container --}}
            <div id="agenciesList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

                @forelse ($agencies as $agency)
                    {{-- COOL EFFECT 4: Card Hover Lift and Shadow --}}
                    <div class="agency-card bg-white p-4 rounded-lg shadow border border-gray-100 transition duration-300 transform hover:-translate-y-1 hover:shadow-2xl hover:border-blue-400"
                        data-type="{{ $agency->agencyTypes }}"
                        data-name="{{ strtolower($agency->agencyNames) }}"
                        data-address="{{ strtolower($agency->address) }}">

                        {{-- Card Header: Logo and Name --}}
                        <div class="flex items-center space-x-3 mb-3 border-b pb-3">
                            @if ($agency->logo)
                                <img src="{{ asset('storage/' . $agency->logo) }}" alt="Agency Logo"
                                    class="w-10 h-10 object-contain rounded-full border-2 border-blue-400 p-0.5 flex-shrink-0">
                            @else
                                <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full border border-gray-300 flex-shrink-0 text-gray-400">
                                    <span class="material-symbols-outlined text-lg">apartment</span>
                                </div>
                            @endif
                            
                            <div class="min-w-0">
                                <h4 class="text-sm font-['Poppins'] font-bold text-gray-800 leading-tight truncate">
                                    {{ $agency->agencyNames }}
                                </h4>
                                <p class="text-[10px] font-['Roboto'] font-semibold text-blue-600 uppercase tracking-wider">
                                    {{ $agency->agencyTypes }}
                                </p>
                            </div>
                        </div>

                        {{-- Card Body: Contact and Address Details (GAMIT ANG MATERIAL SYMBOLS) --}}
                        <div class="space-y-2 text-xs font-['Roboto']">
                            
                            {{-- Contact Number --}}
                            <div class="flex items-center text-gray-700">
                                <span class="material-symbols-outlined text-green-600 w-4 flex-shrink-0">call</span>
                                <div class="ml-2">
                                    <p class="text-[10px] text-gray-500 uppercase font-medium">Contact No.</p>
                                    <a href="tel:{{ $agency->contact_number }}" class="font-semibold text-gray-800 hover:text-green-600 transition duration-150">{{ $agency->contact_number }}</a>
                                </div>
                            </div>

                            {{-- Telephone Number (if available) --}}
                            @if ($agency->telephone_number)
                            <div class="flex items-center text-gray-700">
                                <span class="material-symbols-outlined text-orange-600 w-4 flex-shrink-0">settings_phone</span>
                                <div class="ml-2">
                                    <p class="text-[10px] text-gray-500 uppercase font-medium">Telephone No.</p>
                                    <a href="tel:{{ $agency->telephone_number }}" class="font-semibold text-gray-800 hover:text-orange-600 transition duration-150">{{ $agency->telephone_number }}</a>
                                </div>
                            </div>
                            @endif

                            {{-- Email --}}
                            <div class="flex items-center text-gray-700">
                                <span class="material-symbols-outlined text-blue-600 w-4 flex-shrink-0">mail</span>
                                <div class="ml-2 truncate">
                                    <p class="text-[10px] text-gray-500 uppercase font-medium">Email</p>
                                    <a href="mailto:{{ $agency->email }}" class="font-semibold text-gray-800 hover:text-blue-600 transition duration-150">{{ $agency->email }}</a>
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="flex items-start pt-2 border-t border-gray-100">
                                <span class="material-symbols-outlined text-red-600 w-4 mt-1 flex-shrink-0">location_on</span>
                                <div class="ml-2">
                                    <p class="text-[10px] text-gray-500 uppercase font-medium">Address</p>
                                    <p class="font-medium text-gray-800">{{ $agency->address }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 py-10 text-lg">No agencies found.</p>
                @endforelse

                {{-- Placeholder for No Results (Controlled by JS) --}}
                <div id="noResultsMessage" class="col-span-full text-center py-10 hidden">
                    <p class="text-lg text-red-500 font-semibold"><span class="material-symbols-outlined align-middle mr-2">sentiment_dissatisfied</span> No hotlines match your current filter/search.</p>
                </div>

            </div>

        </div>
    </main>

    {{-- REQUIRED SCRIPT FOR FILTERING --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterSelect = document.getElementById('agencyFilter');
            const searchInput = document.getElementById('agencySearch');
            const agencyCards = document.querySelectorAll('.agency-card');
            const noResultsMessage = document.getElementById('noResultsMessage');

            // --- Core Filtering Function ---
            function applyFilters() {
                const selectedType = filterSelect.value;
                const searchTerm = searchInput.value.toLowerCase().trim();
                let resultsFound = false;

                agencyCards.forEach(card => {
                    const cardType = card.getAttribute('data-type');
                    const cardName = card.getAttribute('data-name');
                    const cardAddress = card.getAttribute('data-address');
                    
                    // 1. Check Type Filter
                    const typeMatch = selectedType === 'ALL' || cardType === selectedType;

                    // 2. Check Search Term
                    const searchMatch = !searchTerm || cardName.includes(searchTerm) || cardAddress.includes(searchTerm);

                    // 3. Show/Hide Card
                    if (typeMatch && searchMatch) {
                        card.style.display = 'block';
                        resultsFound = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Update No Results Message
                if (resultsFound) {
                    noResultsMessage.classList.add('hidden');
                } else {
                    noResultsMessage.classList.remove('hidden');
                }
            }

            // --- Event Listeners ---
            filterSelect.addEventListener('change', applyFilters);
            searchInput.addEventListener('input', applyFilters);

            // Apply filters on initial load to reflect 'Show All' or any default setting
            applyFilters(); 
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>