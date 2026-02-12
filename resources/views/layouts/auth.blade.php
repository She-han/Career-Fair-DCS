<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>{{ config('app.name', 'Career Fair DCS') }} - @yield('title', 'Authentication')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Theme initialization -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
                if (!savedTheme) {
                    localStorage.setItem('theme', 'light');
                }
            }
        })();
    </script>

    <!-- Alpine Styles -->
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-gray-900 transition-colors duration-200 bg-white dark:bg-gray-900 dark:text-gray-100" 
    x-data="{ 
        isDark: localStorage.getItem('theme') === 'dark',
        toggleTheme() {
            this.isDark = !this.isDark;
            if (this.isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
    }">
    
    <!-- Theme Toggle Button (Top Right) -->
    <div class="fixed z-50 top-4 right-4">
        <button @click="toggleTheme()" 
            class="p-3 transition-all duration-200 rounded-full shadow-lg bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm hover:shadow-xl hover:scale-110"
            title="Toggle theme">
            <svg x-show="!isDark" x-cloak class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
            <svg x-show="isDark" x-cloak class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </button>
    </div>

    <!-- Logo Link (Top Left) -->
    <div class="fixed z-50 top-4 left-4">
        <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
            <div class="flex items-center justify-center w-10 h-10 transition-transform duration-200 transform rounded-lg shadow-lg bg-gradient-to-br from-primary-500 via-secondary-500 to-accent-500 group-hover:scale-110">
                <span class="text-xl font-bold text-white">CF</span>
            </div>
            <span class="hidden text-lg font-bold text-transparent sm:inline bg-gradient-to-r from-primary-600 via-secondary-600 to-accent-600 bg-clip-text">
                Career Fair DCS
            </span>
        </a>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

</body>
</html>
