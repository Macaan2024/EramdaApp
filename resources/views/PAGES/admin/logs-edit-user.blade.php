<x-layout.layout>
    <form class="max-w-3xl mx-auto bg-gray-100 shadow-lg rounded-2xl p-8 space-y-6"
        action="{{ route('admin.logs-update-users', $user->id) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <input type="hidden" name="agency_id" value="{{ $user->id }}">
        <input type="hidden" name="user_type" value="responders">

        <!-- Heading -->
        <div class="text-center">
            <h2 class="text-lg font-semibold text-gray-800 font-[Poppins]">Edit User Information</h2>
            <p class="text-gray-500 text-[12px] font-[Poppins]">Update the user details</p>
        </div>

        <!-- Grid fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Email -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full rounded-lg border @error('email') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500"
                    placeholder="name@domain.com" required>
                @error('email')
                <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lastname -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Lastname</label>
                <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}"
                    class="w-full rounded-lg border @error('lastname') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500" required>
                @error('lastname')
                <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Firstname -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Firstname</label>
                <input type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}"
                    class="w-full rounded-lg border @error('firstname') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500" required>
                @error('firstname')
                <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div class="md:col-span-2">
                <span class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Gender</span>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 text-[12px] font-[Poppins]">
                        <input type="radio" value="m" name="gender"
                            {{ old('gender', $user->gender) === 'm' ? 'checked' : '' }}
                            class="text-blue-600 focus:ring-blue-500">
                        Male
                    </label>
                    <label class="flex items-center gap-2 text-[12px] font-[Poppins]">
                        <input type="radio" value="f" name="gender"
                            {{ old('gender', $user->gender) === 'f' ? 'checked' : '' }}
                            class="text-blue-600 focus:ring-blue-500">
                        Female
                    </label>
                </div>
                @error('gender')
                <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Position -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Position</label>
                <input type="text" name="position" value="{{ old('position', $user->position) }}"
                    class="w-full rounded-lg border @error('position') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500" required>
                @error('position')
                <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contact -->
            <div>
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Contact Number</label>
                <input type="text" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}"
                    class="w-full rounded-lg border @error('contact_number') border-red-500 @else border-gray-300 @enderror
                    px-3 py-2 text-[12px] font-[Poppins] focus:ring-blue-500 focus:border-blue-500" required>
                @error('contact_number')
                <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload photo -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Upload Photo</label>
                <input type="file" name="photo" id="photoUpload"
                    class="w-full border @error('photo') border-red-500 @else border-gray-300 @enderror
        rounded-lg cursor-pointer text-[12px] font-[Poppins]">
                @error('photo')
                <p class="text-red-500 text-[11px] mt-1 font-[Poppins]">{{ $message }}</p>
                @enderror

                <div class="mt-3 flex justify-start">
                    <img id="photoPreview"
                        src="{{ $user->photo ? asset('storage/' . $user->photo) : '' }}"
                        alt="Preview"
                        class="{{ $user->photo ? 'block' : 'hidden' }}
                   w-32 h-32 object-cover rounded-lg border-2 border-blue-400 shadow-md">
                </div>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full mt-4 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300
               font-medium rounded-lg px-5 py-2.5 transition text-[12px] font-[Poppins]">
            Update
        </button>
    </form>
</x-layout.layout>
