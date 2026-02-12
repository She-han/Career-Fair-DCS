<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" 
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Link Expired</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="text-gray-900 bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
    
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-md text-center">
            <div class="p-8 bg-white border border-gray-200 shadow-2xl dark:bg-gray-800 rounded-2xl dark:border-gray-700">
                <svg class="w-24 h-24 mx-auto mb-6 text-red-500 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                
                <h1 class="mb-4 text-3xl font-bold">Access Link Expired</h1>
                
                <p class="mb-6 text-gray-600 dark:text-gray-400">
                    The access link for <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $company->company_name }}</span> has expired.
                </p>

                <div class="p-4 mb-6 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        Please contact the Career Fair DCS admin to request a new access link.
                    </p>
                </div>

                <a href="{{ route('home') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-white transition-all rounded-lg bg-gradient-to-r from-primary-600 to-secondary-600 hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Go to Homepage
                </a>
            </div>
        </div>
    </div>

</body>
</html>
