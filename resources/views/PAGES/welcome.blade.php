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

  <title>Emergency Response Login</title>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 font-[Poppins] text-[12px]">
  <div class="min-h-screen flex items-center justify-center px-4">
    <div
      class="w-full max-w-4xl bg-white shadow-2xl rounded-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

      <!-- Left side (welcome / benefits panel) -->
      <div class="bg-gradient-to-br from-indigo-700 to-blue-500 text-white flex flex-col items-center justify-center p-10 font-[Poppins]">
        <h1 class="text-xl font-semibold mb-2">🚨 Emergency Response Portal</h1>
        <p class="text-[12px] text-indigo-100 text-center mb-6">
          Securely log in to access real-time emergency response tools.
        </p>

        <!-- Benefits list -->
        <ul class="space-y-2 text-[12px] text-left w-full max-w-xs">
          <li class="flex items-start gap-2">
            <span class="bg-white/20 rounded-full p-1">✅</span>
            <span>Instant alerts and notifications</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="bg-white/20 rounded-full p-1">✅</span>
            <span>Coordinate with your agency in seconds</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="bg-white/20 rounded-full p-1">✅</span>
            <span>Access secure, verified resources</span>
          </li>
        </ul>

        <img src="https://cdn-icons-png.flaticon.com/512/3209/3209265.png" alt="Emergency Icon"
          class="w-32 mt-6 drop-shadow-lg">
      </div>

      <!-- Right side (login form) -->
      <form class="p-8 md:p-10 space-y-6" action="{{ url('/submit-login') }}" method="POST">
        @csrf

        <!-- Heading -->
        <div class="text-center">
          <h2 class="text-lg font-semibold text-gray-800 font-[Poppins]">Welcome Back</h2>
          <p class="text-gray-500 text-[12px] font-[Poppins]">Login to continue your mission</p>
        </div>

        <!-- Error / Success -->
        @if ($errors->any())
        <div class="bg-red-50 border border-red-400 text-red-600 px-4 py-2 rounded text-xs">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        @if (session('status'))
        <div class="bg-green-50 border border-green-400 text-green-600 px-4 py-2 rounded text-xs">
          {{ session('status') }}
        </div>
        @endif

        <!-- Email -->
        <div>
          <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Email</label>
          <input type="email" name="email"
            class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-[12px] font-[Poppins]"
            placeholder="name@domain.com" required>
        </div>

        <!-- Password -->
        <div>
          <label class="block text-gray-700 mb-1 text-[12px] font-[Poppins]">Password</label>
          <input type="password" name="password"
            class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-[12px] font-[Poppins]" required>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
          <label class="flex items-center gap-2 text-gray-600">
            <input type="checkbox" name="remember" class="text-indigo-600 rounded">
            <span>Remember me</span>
          </label>
          <a href="{{ url('/forgot-password') }}" class="text-indigo-600 hover:underline">Forgot Password?</a>
        </div>

        <!-- Submit -->
        <button type="submit"
          class="w-full mt-4 text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg px-5 py-2.5 transition">
          🚑 Login Now
        </button>

        <!-- Register redirect -->
        <p class="text-center mt-3">
          <a href="{{ url('/register') }}" class="text-indigo-600 hover:underline font-[Poppins] text-[12px]">Don’t have an account? Register</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>
