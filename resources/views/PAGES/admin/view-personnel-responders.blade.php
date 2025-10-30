<x-layout.layout>
    <div class="w-full h-full px-6 py-8">
        <div class="w-full h-full bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 flex flex-col">

            <!-- Profile Header with Banner -->
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1520975918318-3a38e4f6ec24?auto=format&fit=crop&w=1600&q=80"
                    alt="Profile Banner"
                    class="w-full h-56 object-cover">
                <div class="absolute -bottom-20 left-1/2 transform -translate-x-1/2">
                    <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-white shadow-lg">
                        <img src="http://localhost:8000/storage/photos/EFLx56zdXjlsK32jcc2NoyUGlo8FnuAeNdbLiHmx.jpg"
                            alt="Responder Photo"
                            class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="mt-24 text-center px-8">
                <h2 class="text-3xl font-bold text-gray-900 font-[Poppins] tracking-tight">
                    nathan salvediass
                </h2>
                <p class="text-blue-600 text-sm font-medium mt-1">
                    Deputy Leader
                </p>

                <!-- Tags -->
                <div class="flex justify-center gap-3 mt-4 flex-wrap">
                    <span class="px-4 py-1.5 text-sm rounded-full bg-green-100 text-green-700 font-medium">Verified</span>
                    <span class="px-4 py-1.5 text-sm rounded-full bg-blue-100 text-blue-700 font-medium">Experienced</span>
                    <span class="px-4 py-1.5 text-sm rounded-full bg-yellow-100 text-yellow-700 font-medium">Available</span>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t my-8"></div>

            <!-- Details Section (Occupies wide space) -->
            <div class="flex-1 px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 font-[Poppins]">
                <div class="flex items-center gap-3 p-5 rounded-xl bg-gray-50 shadow-sm">
                    <span class="material-symbols-outlined text-blue-600 text-xl">mail</span>
                    <div>
                        <p class="text-xs text-gray-500">Email</p>
                        <p class="text-sm font-semibold text-gray-800">nathan@gmail.com</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-5 rounded-xl bg-gray-50 shadow-sm">
                    <span class="material-symbols-outlined text-green-600 text-xl">call</span>
                    <div>
                        <p class="text-xs text-gray-500">Contact</p>
                        <p class="text-sm font-semibold text-gray-800">09606294089</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-5 rounded-xl bg-gray-50 shadow-sm">
                    <span class="material-symbols-outlined text-pink-600 text-xl">man</span>
                    <div>
                        <p class="text-xs text-gray-500">Gender</p>
                        <p class="text-sm font-semibold text-gray-800">Male</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-5 rounded-xl bg-gray-50 shadow-sm">
                    <span class="material-symbols-outlined text-yellow-600 text-xl">check_circle</span>
                    <div>
                        <p class="text-xs text-gray-500">Status</p>
                        <span class="px-4 py-1 inline-block rounded-full text-xs font-semibold text-white bg-green-500">
                            Available
                        </span>
                    </div>
                </div>
            </div>

            <!-- About Section (Full width) -->
            <div class="px-8 pb-8 mt-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-3">About</h3>
                <p class="text-gray-700 text-sm leading-relaxed">
                    I’m an experienced responder with training in emergency services,
                    skilled in handling crisis situations, and dedicated to ensuring
                    public safety. I’ve worked on multiple emergency responses and
                    continue to train for effective and fast action.
                </p>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 py-5 text-center border-t">
                <a href="http://localhost:8000/bfp/respondersmanagement"
                    class="px-8 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 transition text-white text-sm font-[Poppins] shadow-md">
                    ← Back to Responders
                </a>
            </div>
        </div>
    </div>

</x-layout.layout>