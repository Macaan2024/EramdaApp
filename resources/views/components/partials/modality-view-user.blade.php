<!-- View Button -->
<button onclick="toggleViewUserModal('{{ $user->id }}', true)"
    class="px-3 py-1.5 rounded-sm text-[12px] font-[Poppins] font-medium bg-blue-600 text-white hover:bg-blue-700 transition">
    View
</button>

<!-- ✨ View User Modal -->
<div id="viewUserModal-{{ $user->id }}"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-all duration-300 ease-in-out">

    <div id="viewUserModalBox-{{ $user->id }}"
        class="relative bg-white rounded-3xl shadow-2xl w-[95%] sm:w-[85%] md:w-[70%] lg:w-[60%] max-h-[80vh] flex transform scale-95 opacity-0 transition-all duration-300 ease-in-out overflow-hidden">

        <!-- Header -->
        <div class="absolute top-4 right-6">
            <button onclick="toggleViewUserModal('{{ $user->id }}', false)"
                class="text-gray-500 hover:text-red-600 text-3xl font-bold transition-transform transform hover:rotate-90">&times;</button>
        </div>

        <!-- Modal Content -->
        <div class="flex flex-col md:flex-row w-full h-full overflow-hidden">

            <!-- Left Column: User Photo -->
            <div class="md:w-1/3 bg-gray-50 p-6 flex flex-col items-center gap-3">
                @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo"
                    class="w-28 h-28 object-cover rounded-full border-2 border-gray-200 shadow-md">
                @else
                <div class="w-28 h-28 bg-gray-200 flex items-center justify-center rounded-full">
                    <span class="text-gray-500 font-[Poppins]">No photo</span>
                </div>
                @endif

                <h3 class="text-xl font-semibold font-[Poppins] text-center">{{ $user->firstname }} {{ $user->lastname }}</h3>
                <p class="text-gray-500 font-[Poppins] text-center">{{ ucfirst($user->user_type) }}</p>
            </div>

            <!-- Right Column: Agency & Info -->
            <div class="md:w-2/3 p-6 overflow-y-auto space-y-4">

                <!-- Agency Info -->
                <div class="flex items-center gap-4 mb-4">
                    @if($user->agency->logo)
                    <img src="{{ asset('storage/' . $user->agency->logo) }}" alt="Agency Logo"
                        class="w-16 h-16 object-contain rounded-md border border-gray-200 shadow-sm">
                    @else
                    <div class="w-16 h-16 bg-gray-200 flex items-center justify-center rounded-md">
                        <span class="text-gray-500 text-xs font-[Poppins]">No Logo</span>
                    </div>
                    @endif
                    <div>
                        <h4 class="text-lg font-semibold font-[Poppins] text-blue-800">{{ $user->agency->agencyNames }}</h4>
                        @if ($user->agency->agencyTypes === 'BFP')
                        <p class="text-gray-500 font-[Poppins] text-sm">Bureau of Fire Protection</p>
                        @elseif ($user->agency->agencyTypes === 'BDRRMC')
                        <p class="text-gray-500 font-[Poppins] text-sm">Barangay Disaster Risk Reduction and Management Committee</p>
                        @elseif ($user->agency->agencyTypes === 'CDRRMO')
                        <p class="text-gray-500 font-[Poppins] text-sm">City Disaster Risk Reduction and Management Office</p>
                        @else
                        <p class="text-gray-500 font-[Poppins] text-sm">No Agency</p>
                        @endif
                    </div>
                </div>

                <!-- User Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-gray-700">
                    <div class="flex gap-4 border-b border-gray-200 py-2">
                        <span class="font-medium text-gray-500">Position:</span>
                        <span class="font-semibold text-gray-800">{{ $user->position }}</span>
                    </div>

                    <div class="flex gap-4 border-b border-gray-200 py-2">
                        <span class="font-medium text-gray-500">Email:</span>
                        <span class="font-semibold text-gray-800">{{ $user->email }}</span>
                    </div>

                    <div class="flex gap-4 border-b border-gray-200 py-2">
                        <span class="font-medium text-gray-500">Gender:</span>
                        <span class="font-semibold text-gray-800">{{ $user->gender === 'm' ? 'Male' : 'Female' }}</span>
                    </div>

                    <div class="flex gap-4 border-b border-gray-200 py-2">
                        <span class="font-medium text-gray-500">Contact:</span>
                        <span class="font-semibold text-gray-800">{{ $user->contact_number }}</span>
                    </div>

                    <div class="flex gap-4 border-b border-gray-200 py-2">
                        <span class="font-medium text-gray-500">Account Status:</span>
                        <span class="px-2 py-1 rounded-full text-white text-xs font-semibold
                            {{ ($user->account_status) === 'Active' ? 'bg-green-500' : ($user->account_status === 'Pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                            {{ ucfirst($user->account_status) }}
                        </span>
                    </div>

                    <div class="flex gap-4 border-b border-gray-200 py-2">
                        <span class="font-medium text-gray-500">Availability:</span>
                        <span class="px-2 py-1 rounded-full text-white text-xs font-semibold
                            {{ ($user->availability_status) === 'Available' ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ ucfirst($user->availability_status) }}
                        </span>
                    </div>

                    <div class="flex gap-4 border-b border-gray-200 py-2">
                        <span class="font-medium text-gray-500">Last Updated:</span>
                        <span class="font-semibold text-gray-800">{{ $user->updated_at?->format('F d, Y h:i A') ?? '—' }}</span>
                    </div>
                </div>

                <!-- Optional Action Button -->
                <div class="flex justify-end mt-4">
                    <form action="{{ route('admin.deactivate-user', $user->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to deactivate this user?');">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white text-[13px] font-[Poppins] rounded-lg px-5 py-2 shadow-md transition transform hover:scale-105">
                            Deactivate Account
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script>
    function toggleViewUserModal(id, show) {
        const modal = document.getElementById(`viewUserModal-${id}`);
        const box = document.getElementById(`viewUserModalBox-${id}`);

        if (show) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            }, 50);
        } else {
            box.classList.add('scale-95', 'opacity-0');
            box.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => modal.classList.add('hidden'), 200);
        }
    }

    // Close when clicking outside
    document.querySelectorAll('[id^="viewUserModal-"]').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                const id = this.id.split('-')[2];
                toggleViewUserModal(id, false);
            }
        });
    });
</script>