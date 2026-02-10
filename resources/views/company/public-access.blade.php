<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" 
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $company->company_name }} - Assigned CVs</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">
                        {{ $company->company_name }}
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Assigned CVs Portal</p>
                </div>
                
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                    class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    <svg x-show="!darkMode" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Company Info Card -->
        @if($company->participationResponse)
        <div class="bg-gradient-to-br from-primary-50 to-secondary-50 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-lg p-6 mb-8 border border-primary-100 dark:border-gray-600">
            <div class="flex items-start gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    {{ strtoupper(substr($company->company_name, 0, 2)) }}
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold mb-2">Company Preferences</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        @if($company->participationResponse->expected_cvs)
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Expected CVs:</span>
                            <span class="font-semibold ml-1">{{ $company->participationResponse->expected_cvs }}</span>
                        </div>
                        @endif
                        @if($company->participationResponse->intern_positions)
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Intern Positions:</span>
                            <span class="font-semibold ml-1">{{ $company->participationResponse->intern_positions }}</span>
                        </div>
                        @endif
                        @if($company->participationResponse->preferred_timeslot)
                        <div class="col-span-2">
                            <span class="text-gray-600 dark:text-gray-400">Preferred Timeslot:</span>
                            <span class="font-semibold ml-1">{{ $company->participationResponse->preferred_timeslot }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total CVs Assigned</p>
                        <p class="text-3xl font-bold text-primary-600 dark:text-primary-400">{{ $cvs->count() }}</p>
                    </div>
                    <svg class="w-12 h-12 text-primary-300 dark:text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Viewed CVs</p>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                            {{ $cvs->where('pivot.viewed_status', true)->count() }}
                        </p>
                    </div>
                    <svg class="w-12 h-12 text-green-300 dark:text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Pending Review</p>
                        <p class="text-3xl font-bold text-accent-600 dark:text-accent-400">
                            {{ $cvs->where('pivot.viewed_status', false)->count() }}
                        </p>
                    </div>
                    <svg class="w-12 h-12 text-accent-300 dark:text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- CVs List -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold">Assigned CVs</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Review and download student CVs assigned to your company
                </p>
            </div>

            @if($cvs->isEmpty())
            <div class="p-12 text-center">
                <svg class="w-20 h-20 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">No CVs Assigned Yet</h3>
                <p class="text-gray-600 dark:text-gray-400">CVs will appear here once the admin assigns them to your company.</p>
            </div>
            @else
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($cvs as $cv)
                <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                    {{ $cv->student->name_with_initials }}
                                </h3>
                                @if($cv->pivot->viewed_status)
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full">
                                    Viewed
                                </span>
                                @else
                                <span class="px-2 py-1 bg-accent-100 dark:bg-accent-900/30 text-accent-700 dark:text-accent-300 text-xs font-semibold rounded-full">
                                    New
                                </span>
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-3">
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">SC Number:</span>
                                    <span class="font-semibold ml-1">{{ $cv->student->sc_number }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Position:</span>
                                    <span class="font-semibold ml-1">{{ $cv->applying_job_position }}</span>
                                </div>
                                @if($cv->student->gpa)
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">GPA:</span>
                                    <span class="font-semibold ml-1">{{ number_format($cv->student->gpa, 2) }}</span>
                                </div>
                                @endif
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Assigned:</span>
                                    <span class="font-semibold ml-1">{{ $cv->pivot->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            @if($cv->student->phone || $cv->student->uni_email)
                            <div class="flex gap-4 text-sm">
                                @if($cv->student->phone)
                                <div class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $cv->student->phone }}
                                </div>
                                @endif
                                @if($cv->student->uni_email)
                                <div class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $cv->student->uni_email }}
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>

                        <a href="{{ route('company.download-cv', ['token' => $company->access_token, 'cv' => $cv->id]) }}" 
                           class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 text-white rounded-lg font-semibold transition-all shadow-md hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download CV
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Security Notice -->
        <div class="mt-8 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <h4 class="font-semibold text-amber-800 dark:text-amber-300 mb-1">Security Notice</h4>
                    <p class="text-sm text-amber-700 dark:text-amber-400">
                        This is a secure access link. Do not share this URL with others. All access is logged for security purposes.
                    </p>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="mt-12 py-6 border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 text-center text-sm text-gray-600 dark:text-gray-400">
            <p>&copy; {{ date('Y') }} Career Fair DCS. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
