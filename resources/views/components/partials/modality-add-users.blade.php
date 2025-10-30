<!-- Button to open modal -->
<button onclick="toggleAddUserModal(true)"
    class="bg-blue-600 hover:bg-blue-800 
           text-white text-[13px] font-[Poppins] rounded-xl px-6 py-2.5 shadow-md 
           transition-transform">
    Add User
</button>

<!-- Modal Background -->
<div id="addUserModal"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center 
           z-50 hidden transition-all duration-300 ease-in-out">

    <!-- Modal Box -->
    <div id="addUserModalBox"
        class="relative bg-white rounded-2xl shadow-2xl 
               w-[90%] sm:w-[80%] md:w-[55%] lg:w-[40%] 
               max-h-[90vh] flex flex-col transform scale-95 opacity-0 
               transition-all duration-300 ease-in-out border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="flex justify-between items-center bg-blue-800 border-b border-gray-200 px-4 py-2">
            <h2 class="text-[16px] font-medium text-white font-[Poppins] tracking-wide">
                Add New User
            </h2>
            <button onclick="toggleAddUserModal(false)"
                class="text-white hover:text-red-600 text-3xl font-bold transition-transform transform hover:rotate-90">
                &times;
            </button>
        </div>

        <!-- Form Content (Scrollable) -->
        <div class="p-6 font-[Roboto] text-[13px] text-gray-700 space-y-5 overflow-y-auto max-h-[80vh] pr-2">
            <!-- 🧍‍♂️ Introductory Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                <h2 class="text-[14px] font-semibold text-blue-700 mb-1">About This Form</h2>
                <p class="text-gray-700 text-[12px] leading-relaxed">
                    This form is designed to <span class="font-semibold">add new users</span> into the system, including responders,
                    operation officers, and nurse chiefs associated with official agencies in Iligan City.<br><br>
                    Please ensure that all user information is entered accurately, including their assigned
                    <span class="font-semibold">agency, role, position, and contact details</span>.
                    A default password will be set automatically for each new account.
                    You may also upload a profile photo to complete the user’s registration record.
                </p>
            </div>

            <form action="{{ route('admin.submit-user') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <input type="hidden" name="password" value="12345678">
                <input type="hidden" name="password_confirmation" value="12345678">
                <input type="hidden" name="account_status" value="Active">
                <input type="hidden" name="availability_status" value="Available">

                <h3 class="text-[15px] font-[Poppins] font-semibold text-blue-700 border-l-4 border-blue-500 pl-2">
                    User Details
                </h3>

                <!-- Agency -->
                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Agency</label>
                    <select name="agency_id"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]
                               focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none bg-white shadow-sm transition">
                        <option disabled selected>Choose Agency</option>
                        @forelse ($agencies as $agency)
                        <option value="{{ $agency->id }}">{{ $agency->agencyNames }}</option>
                        @empty
                        <option disabled>No agencies available</option>
                        @endforelse
                    </select>
                    @error('agency_id')
                    <p class="text-red-500 text-[12px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">User Role</label>
                    <select name="user_type"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]
                               focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none bg-white shadow-sm transition">
                        <option disabled selected>Choose Role</option>
                        <option value="responder">Responder</option>
                        <option value="operation-officer">Operation Officer</option>
                        <option value="nurse-chief">Nurse Chief</option>
                    </select>
                    @error('user_type')
                    <p class="text-red-500 text-[12px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Email</label>
                    <input type="email" name="email" placeholder="name@domain.com"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]
                               focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none bg-white shadow-sm" required>
                    @error('email')
                    <p class="text-red-500 text-[12px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lastname & Firstname -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-800 mb-1 font-[Poppins]">Lastname</label>
                        <input type="text" name="lastname"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]
                                   focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none bg-white shadow-sm" required>
                        @error('lastname')
                        <p class="text-red-500 text-[12px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-800 mb-1 font-[Poppins]">Firstname</label>
                        <input type="text" name="firstname"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]
                                   focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none bg-white shadow-sm" required>
                        @error('firstname')
                        <p class="text-red-500 text-[12px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Gender</label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 text-[13px] font-[Roboto] cursor-pointer">
                            <input type="radio" name="gender" value="m" class="text-blue-600 focus:ring-blue-500">
                            Male
                        </label>
                        <label class="flex items-center gap-2 text-[13px] font-[Roboto] cursor-pointer">
                            <input type="radio" name="gender" value="f" class="text-blue-600 focus:ring-blue-500">
                            Female
                        </label>
                    </div>
                    @error('gender')
                    <p class="text-red-500 text-[12px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Position & Contact -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-800 mb-1 font-[Poppins]">Position</label>
                        <input type="text" name="position"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]
                                   focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none bg-white shadow-sm" required>
                        @error('position')
                        <p class="text-red-500 text-[12px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-800 mb-1 font-[Poppins]">Contact Number</label>
                        <input type="text" name="contact_number"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-[13px] font-[Roboto]
                                   focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none bg-white shadow-sm" required>
                        @error('contact_number')
                        <p class="text-red-500 text-[12px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Upload Photo -->
                <div>
                    <label class="block text-gray-800 mb-1 font-[Poppins]">Upload Photo</label>
                    <input type="file" name="photo" id="photoUpload"
                        class="w-full border border-gray-300 rounded-lg cursor-pointer text-[13px] font-[Roboto]
                               bg-white shadow-sm hover:border-blue-400 transition">
                    @error('photo')
                    <p class="text-red-500 text-[12px] mt-1">{{ $message }}</p>
                    @enderror

                    <div class="mt-4 flex justify-start">
                        <img id="photoPreview" src="" alt="Preview will appear here"
                            class="hidden w-28 h-28 object-cover rounded-sm border-2 border-green-400 shadow-lg transition-all duration-300">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 
                           font-[Poppins] font-medium rounded-lg px-5 py-2.5 transition transform hover:scale-105 
                           text-[13px] shadow-md">
                    Submit
                </button>
            </form>
        </div>
    </div>
</div>

<!-- JS for Modal -->
<script>
    function toggleAddUserModal(show) {
        const modal = document.getElementById('addUserModal');
        const box = document.getElementById('addUserModalBox');

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

    // Close modal when clicking outside
    document.getElementById('addUserModal').addEventListener('click', function(e) {
        if (e.target === this) toggleAddUserModal(false);
    });

    // Photo preview
    document.getElementById('photoUpload')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const preview = document.getElementById('photoPreview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    });
</script>
