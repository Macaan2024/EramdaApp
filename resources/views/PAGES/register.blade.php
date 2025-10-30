<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')

  <!-- Flowbite -->
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <title>Registration Form</title>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 font-[Poppins]">
  <div class="min-h-screen flex items-center justify-center px-4">
    <div
      class="w-full max-w-5xl bg-white shadow-2xl rounded-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2 max-h-screen overflow-y-auto">

      <!-- Left side (welcome / benefits panel) -->
      <div class="bg-gradient-to-br from-indigo-700 to-blue-500 text-white flex flex-col items-center justify-center p-10">
        <h1 class="text-xl font-[Poppins] mb-2">🚨 Emergency Response Portal</h1>
        <p class="text-[12px] text-indigo-100 text-center mb-6">
          Join our platform and be part of a trusted network for fast and reliable emergency response.
        </p>

        <!-- Benefits list -->
        <ul class="space-y-2 text-[12px] text-left w-full max-w-xs">
          <li class="flex items-start gap-2">
            <span class="bg-white/20 rounded-full p-1">✅</span>
            <span>Coordinate quickly with response teams</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="bg-white/20 rounded-full p-1">✅</span>
            <span>Secure and verified communication</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="bg-white/20 rounded-full p-1">✅</span>
            <span>Track and manage emergency resources</span>
          </li>
        </ul>

        <img src="https://cdn-icons-png.flaticon.com/512/3209/3209265.png" alt="Emergency Icon"
          class="w-32 mt-6 drop-shadow-lg">
      </div>

      <!-- Right side (form panel) -->
      <form class="p-8 md:p-10 space-y-6" action="{{ url('/submit-register') }}" method="POST"
        enctype="multipart/form-data">

        @csrf

        <!-- Heading -->
        <div class="text-center">
          <h2 class="text-lg font-semibold text-gray-800">Create Your Account</h2>
          <p class="text-gray-500 text-[12px]">Register now to access emergency services</p>
        </div>

        <!-- Top error summary -->
        @if ($errors->any() || session('error'))
        <div class="bg-red-50 border border-red-400 text-red-600 px-4 py-2 rounded text-xs">
          <ul class="list-disc list-inside">
            @if(session('error'))
            <li>{{ session('error') }}</li>
            @endif
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <!-- Grid fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <!-- Agency -->
          <div class="md:col-span-2">
            <label class="block text-gray-700 mb-1 text-[12px]">Select Agency</label>
            <select name="agency_id"
              class="w-full rounded-lg border {{ $errors->has('agency_id') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} 
               focus:ring-indigo-500 focus:border-indigo-500 text-[12px]">
              <option value="">Choose Agency</option>
              @forelse ($agencies as $agency)
              <option value="{{ $agency->id }}" {{ old('agency_id') == $agency->id ? 'selected' : '' }}>
                {{ $agency->agencyNames }}
              </option>
              @empty
              <option disabled>No Agencies Found</option>
              @endforelse
            </select>
            @error('agency_id')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>
          <!-- Role -->
          <div class="md:col-span-2">
            <label class="block text-gray-700 mb-1 text-[12px]">Select Role</label>
            <select name="user_type"
              class="w-full rounded-lg border {{ $errors->has('user_type') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} 
               focus:ring-indigo-500 focus:border-indigo-500 text-[12px]">
              <option value="">Choose Role</option>
              <option value="Operation Officer" {{ old('user_type') == 'Operation Officer' ? 'selected' : '' }}>Operation Officer</option>
              <option value="Nurse Chief" {{ old('user_type') == 'Nurse Chief' ? 'selected' : '' }}>Nurse Chief</option>
            </select>
            @error('user_type')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Email -->
          <div class="md:col-span-2">
            <label class="block text-gray-700 mb-1 text-[12px]">Email</label>
            <input type="email" id="email" name="email"
              class="w-full rounded-lg border {{ $errors->has('email') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} 
               focus:ring-indigo-500 focus:border-indigo-500 text-[12px]"
              placeholder="name@domain.com" value="{{ old('email') }}" required>
            @error('email')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Password -->
          <div>
            <label class="block text-gray-700 mb-1 text-[12px]">Password</label>
            <input type="password" id="password" name="password"
              class="w-full rounded-lg border {{ $errors->has('password') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} 
               focus:ring-indigo-500 focus:border-indigo-500 text-[12px]" required>
            @error('password')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Confirm Password -->
          <div>
            <label class="block text-gray-700 mb-1 text-[12px]">Confirm Password</label>
            <input type="password" id="confirmPassword" name="password_confirmation"
              class="w-full rounded-lg border {{ $errors->has('password_confirmation') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} 
               focus:ring-indigo-500 focus:border-indigo-500 text-[12px]" required>
            @error('password_confirmation')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Lastname -->
          <div>
            <label class="block text-gray-700 mb-1 text-[12px]">Lastname</label>
            <input type="text" id="lastname" name="lastname"
              class="w-full rounded-lg border {{ $errors->has('lastname') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} 
               focus:ring-indigo-500 focus:border-indigo-500 text-[12px]"
              value="{{ old('lastname') }}" required>
            @error('lastname')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Firstname -->
          <div>
            <label class="block text-gray-700 mb-1 text-[12px]">Firstname</label>
            <input type="text" id="firstname" name="firstname"
              class="w-full rounded-lg border {{ $errors->has('firstname') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} 
               focus:ring-indigo-500 focus:border-indigo-500 text-[12px]"
              value="{{ old('firstname') }}" required>
            @error('firstname')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Gender -->
          <div class="md:col-span-2">
            <span class="block text-gray-700 mb-1 text-[12px]">Gender</span>
            <div class="flex gap-6">
              <label class="flex items-center gap-2">
                <input type="radio" value="m" name="gender" {{ old('gender') == 'm' ? 'checked' : '' }}>
                <span class="text-[12px]">Male</span>
              </label>
              <label class="flex items-center gap-2">
                <input type="radio" value="f" name="gender" {{ old('gender') == 'f' ? 'checked' : '' }}>
                <span class="text-[12px]">Female</span>
              </label>
            </div>
            @error('gender')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Position -->
          <div>
            <label class="block text-gray-700 mb-1 text-[12px]">Position</label>
            <input type="text" name="position"
              class="w-full rounded-lg border {{ $errors->has('position') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} 
               focus:ring-indigo-500 focus:border-indigo-500 text-[12px]"
              value="{{ old('position') }}" required>
            @error('position')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Contact -->
          <div>
            <label class="block text-gray-700 mb-1 text-[12px]">Contact Number</label>
            <input type="text" name="contact_number"
              class="w-full rounded-lg border {{ $errors->has('contact_number') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} 
               focus:ring-indigo-500 focus:border-indigo-500 text-[12px]"
              value="{{ old('contact_number') }}" required>
            @error('contact_number')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <!-- Upload photo -->
          <div class="md:col-span-2">
            <label class="block text-gray-700 mb-1 text-[12px]">Upload Photo</label>
            <input type="file" name="photo" id="photoUpload"
              class="w-full border {{ $errors->has('photo') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} 
               rounded-lg cursor-pointer text-[12px]">
            @error('photo')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
            <div class="mt-3 flex justify-center">
              <img id="photoPreview" src="" alt="Preview will appear here"
                class="hidden w-24 h-24 object-cover rounded-full border-2 border-indigo-400 shadow-md">
            </div>
          </div>
        </div>

        <!-- Submit -->
        <button type="submit"
          class="w-full mt-4 text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg px-5 py-2.5 transition text-[12px]">
          🚑 Register Now
        </button>

        <!-- login redirect -->
        <p class="text-center mt-3">
          <a href="{{ url('/') }}" class="text-indigo-600 hover:underline text-[12px]">Already have an account?</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>