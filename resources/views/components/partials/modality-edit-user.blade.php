<button onclick="toggleEditUserModal('{{ $user->id }}', true)"
    class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1.5 rounded-sm text-[12px] font-[Poppins]">
    Edit
</button>

<!-- ✏️ Edit User Modal -->
<div id="editUserModal-{{ $user->id }}"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center 
           z-50 hidden transition-all duration-300 ease-in-out">

    <div id="editUserModalBox-{{ $user->id }}"
        class="relative bg-white rounded-2xl shadow-2xl 
           w-[90%] sm:w-[80%] md:w-[55%] lg:w-[40%] 
           max-h-[90vh] transform scale-95 opacity-0 
           transition-all duration-300 ease-in-out border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="flex justify-between items-center bg-blue-800 border-b border-gray-200 px-4 py-2 rounded-t-2xl">
            <h2 class="text-[16px] text-white font-medium font-[Poppins] tracking-wide">
                Edit User
            </h2>
            <button onclick="toggleEditUserModal('{{ $user->id }}', false)"
                class="text-white hover:text-red-600 text-3xl font-bold transition-transform transform hover:rotate-90">
                &times;
            </button>
        </div>

        <!-- Scrollable Form -->
        <div class="scrollbar-container p-6 font-[Roboto] text-[13px] text-gray-700 space-y-5 overflow-y-auto max-h-[80vh]">

            @if ($errors->all())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.update-user', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <h3 class="text-[15px] font-[Poppins] font-semibold text-blue-700 border-l-4 border-blue-500 pl-2 mb-2">
                    User Details
                </h3>

                <!-- Agency -->
                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Agency</label>
                    <select name="agency_id"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]">
                        @foreach ($agencies as $agency)
                        <option value="{{ $agency->id }}" {{ $user->agency_id == $agency->id ? 'selected' : '' }}>
                            {{ $agency->agencyNames }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">User Role</label>
                    <select name="user_type"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]">
                        <option value="responder" {{ $user->user_type == 'responder' ? 'selected' : '' }}>Responder</option>
                        <option value="operation-officer" {{ $user->user_type == 'operation-officer' ? 'selected' : '' }}>Operation Officer</option>
                        <option value="nurse-chief" {{ $user->user_type == 'nurse-chief' ? 'selected' : '' }}>Nurse Chief</option>
                    </select>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]" required>
                </div>

                <!-- Password (optional) -->
                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">New Password (Leave blank if not changing)</label>
                    <input type="password" name="password"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]" placeholder="Enter new password">
                </div>

                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]" placeholder="Confirm new password">
                </div>

                <!-- Name -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-800 mb-1 font-[Poppins]">Lastname</label>
                        <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]" required>
                    </div>
                    <div>
                        <label class="block text-gray-800 mb-1 font-[Poppins]">Firstname</label>
                        <input type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]" required>
                    </div>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Gender</label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="gender" value="m" {{ $user->gender == 'm' ? 'checked' : '' }}>
                            Male
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="gender" value="f" {{ $user->gender == 'f' ? 'checked' : '' }}>
                            Female
                        </label>
                    </div>
                </div>

                <!-- Position & Contact -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-800 mb-1 font-[Poppins]">Position</label>
                        <input type="text" name="position" value="{{ old('position', $user->position) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]" required>
                    </div>
                    <div>
                        <label class="block text-gray-800 mb-1 font-[Poppins]">Contact Number</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]" required>
                    </div>
                </div>

                <!-- Photo -->
                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Photo</label>
                    <input type="file" name="photo" id="photoUpload-{{ $user->id }}"
                        class="w-full border border-gray-300 rounded-lg cursor-pointer text-[13px] font-[Roboto] bg-white shadow-sm">

                    <div class="mt-4 flex justify-start">
                        <img id="photoPreview-{{ $user->id }}"
                            src="{{ $user->photo ? asset('storage/' . $user->photo) : '' }}"
                            alt="User Photo"
                            class="w-28 h-28 object-cover rounded-sm border-2 border-green-400 shadow-lg {{ $user->photo ? '' : 'hidden' }}">
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full text-white bg-green-600 hover:bg-blue-800 font-[Poppins] rounded-lg px-5 py-2.5 text-[13px]">
                    Update User
                </button>
            </form>
        </div>
    </div>
</div>

<!-- JS -->
<script>
    function toggleEditUserModal(id, show) {
        const modal = document.getElementById(`editUserModal-${id}`);
        const box = document.getElementById(`editUserModalBox-${id}`);

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

    document.getElementById(`photoUpload-{{ $user->id }}`)?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const preview = document.getElementById(`photoPreview-{{ $user->id }}`);
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    });
</script>

<!-- CSS -->
<style>
    .scrollbar-container {
        scrollbar-gutter: stable both-edges;
        /* ✅ Prevents scrollbar overlap */
        border-radius: 1rem;
        /* ✅ Matches rounded-2xl */
    }

    .scrollbar-container::-webkit-scrollbar {
        width: 8px;
    }

    .scrollbar-container::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    .scrollbar-container::-webkit-scrollbar-track {
        background: transparent;
    }
</style>