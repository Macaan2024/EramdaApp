<x-layout.layout>

    <x-partials.toast-messages />

    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">

        <!-- Header Image Section -->
        <div class="relative">
            @if($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}"
                alt="User Photo"
                class="w-full h-64 object-cover">
            @else
            <div class="w-full h-64 bg-gray-100 flex items-center justify-center">
                <span class="text-gray-500 text-sm font-[Poppins]">No photo available</span>
            </div>
            @endif

            <!-- Overlay Label -->
            @if($user)
            <div class="absolute bottom-4 left-4 bg-black/60 text-white px-4 py-2 rounded-lg">
                <h2 class="text-xl font-semibold font-[Poppins]">{{ $user->firstname }} {{ $user->lastname }}</h2>
                <p class="text-sm text-gray-200 font-[Poppins]">{{ ucfirst($user->user_type) }}</p>
            </div>
            @endif
        </div>

        <!-- User Info -->
        <div class="p-8 space-y-6">
            <div class="border-b border-gray-200 pb-3">
                <h3 class="text-lg font-semibold text-gray-800 font-[Poppins]">User Information</h3>
                <p class="text-gray-500 text-sm font-[Poppins]">Detailed information about this user</p>
            </div>

            @if($user)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-[14px] font-[Poppins]">

                <div>
                    <h4 class="text-gray-600 font-medium mb-1">Agency</h4>
                    <p class="text-gray-800 font-semibold">{{ $user->agency->agencyNames }}</p>
                </div>

                <div>
                    <h4 class="text-gray-600 font-medium mb-1">Position</h4>
                    <p class="text-gray-800 font-semibold">{{ $user->position }}</p>
                </div>

                <div>
                    <h4 class="text-gray-600 font-medium mb-1">Email</h4>
                    <p class="text-gray-800 font-semibold">{{ $user->email }}</p>
                </div>

                <div>
                    <h4 class="text-gray-600 font-medium mb-1">Gender</h4>
                    <p class="text-gray-800 font-semibold">{{ $user->gender === 'm' ? 'Male' : 'Female' }}</p>
                </div>

                <div>
                    <h4 class="text-gray-600 font-medium mb-1">Contact Number</h4>
                    <p class="text-gray-800 font-semibold">{{ $user->contact_number }}</p>
                </div>

                <div>
                    <h4 class="text-gray-600 font-medium mb-1">Account Status</h4>
                    <span class="inline-block px-3 py-1 text-xs rounded-full text-white font-semibold
                        {{ ($user->account_status) === 'Approved' ? 'bg-green-500' : ($user->account_status === 'Pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                        {{ ucfirst($user->account_status) }}
                    </span>
                </div>

                <div>
                    <h4 class="text-gray-600 font-medium mb-1">Availability</h4>
                    <span class="inline-block px-3 py-1 text-xs rounded-full text-white font-semibold
                        {{ ($user->availability_status) === 'Available' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ ucfirst($user->availability_status) }}
                    </span>
                </div>

                <div>
                    <h4 class="text-gray-600 font-medium mb-1">Last Updated</h4>
                    <p class="text-gray-800 font-semibold">{{ $user->updated_at?->format('F d, Y h:i A') ?? '—' }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.logs-edit-users',  $user->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg shadow transition">
                    Edit User
                </a>
                <form action="{{ route('admin.logs-delete-users', $user->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg shadow transition">
                        Delete User
                    </button>
                </form>
            </div>

            @else
            <p class="text-center text-gray-500 font-[Poppins] py-6">No user details found.</p>
            @endif
        </div>
    </div>

</x-layout.layout>
