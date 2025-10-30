<!-- ✅ Success Toast -->
@if (session('success'))
<div id="toast-success"
    class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-green-100 divide-x divide-gray-200 rounded-lg shadow-sm"
    role="alert">
    <!-- Success Icon -->
    <svg class="w-5 h-5 text-green-700 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
        <path
            d="M12 0a12 12 0 1 0 12 12A12.013 12.013 0 0 0 12 0Zm6.707 8.707-7.364 7.364a1 1 0 0 1-1.414 0L5.293 11.435a1 1 0 1 1 1.414-1.414l3.222 3.222 6.657-6.657a1 1 0 1 1 1.414 1.414Z" />
    </svg>
    <div class="ps-4 text-sm font-[Poppins] font-normal text-gray-800">{{ session('success') }}</div>
    <div class="absolute bottom-0 left-0 h-1 bg-blue-600 animate-toastbar"></div>
</div>
@endif

<!-- ❌ Error Toast -->
@if (session('error'))
<div id="toast-error"
    class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-red-100 divide-x divide-gray-200 rounded-lg shadow-sm"
    role="alert">
    <!-- Error Icon -->
    <svg class="w-5 h-5 text-red-700 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
        <path
            d="M12 0a12 12 0 1 0 12 12A12.013 12.013 0 0 0 12 0Zm4.243 15.071a1 1 0 1 1-1.414 1.414L12 13.414l-2.829 3.071a1 1 0 1 1-1.414-1.414L10.586 12 7.757 9.171a1 1 0 1 1 1.414-1.414L12 10.586l2.829-2.829a1 1 0 1 1 1.414 1.414L13.414 12l2.829 3.071Z" />
    </svg>
    <div class="ps-4 text-sm font-[Poppins] font-normal text-gray-800">{{ session('error') }}</div>
    <div class="absolute bottom-0 left-0 h-1 bg-blue-600 animate-toastbar"></div>
</div>
@endif
