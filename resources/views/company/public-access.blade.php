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
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white shadow-lg dark:bg-gray-800 backdrop-blur-sm bg-opacity-90 dark:bg-opacity-90">
        <div class="container px-4 py-4 mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="animate-fadeIn">
                    <h1 class="text-3xl font-bold text-transparent bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text">
                        {{ $company->company_name }}
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Collected CVs Portal</p>
                </div>
                
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                    class="p-2 transition-all bg-gray-100 rounded-lg dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 hover:scale-110">
                    <svg x-show="!darkMode" x-cloak class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container px-4 py-12 mx-auto sm:px-6 lg:px-8">
        
        <!-- Company Info Card -->
        @if($company->participationResponse)
        <div class="p-6 mb-8 bg-white shadow-lg dark:bg-gray-800 rounded-xl animate-fadeIn">
            <div class="flex items-start gap-4">
                <div class="flex items-center justify-center w-16 h-16 text-2xl font-bold text-white rounded-full shadow-md bg-gradient-to-br from-blue-500 to-purple-500">
                    {{ strtoupper(substr($company->company_name, 0, 2)) }}
                </div>
                <div class="flex-1">
                    <h2 class="mb-3 text-xl font-bold text-gray-900 dark:text-gray-100">Company Preferences</h2>
                    <div class="grid grid-cols-2 gap-4 text-sm md:grid-cols-4">
                        @if($company->participationResponse->expected_cvs)
                        <div class="p-3 rounded-lg bg-blue-50 dark:bg-gray-700">
                            <p class="text-xs text-gray-600 dark:text-gray-400">Expected CVs</p>
                            <p class="mt-1 text-lg font-bold text-blue-600 dark:text-blue-400">{{ $company->participationResponse->expected_cvs }}</p>
                        </div>
                        @endif
                        @if($company->participationResponse->intern_positions)
                        <div class="p-3 rounded-lg bg-green-50 dark:bg-gray-700">
                            <p class="text-xs text-gray-600 dark:text-gray-400">Intern Positions</p>
                            <p class="mt-1 text-lg font-bold text-green-600 dark:text-green-400">{{ $company->participationResponse->intern_positions }}</p>
                        </div>
                        @endif
                        @if($company->participationResponse->preferred_timeslot)
                        <div class="col-span-2 p-3 rounded-lg bg-purple-50 dark:bg-gray-700">
                            <p class="text-xs text-gray-600 dark:text-gray-400">Preferred Timeslot</p>
                            <p class="mt-1 text-base font-semibold text-purple-600 dark:text-purple-400">{{ $company->participationResponse->preferred_timeslot }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

      

        <!-- CVs List -->
        <div class="overflow-hidden bg-white shadow-lg dark:bg-gray-800 rounded-xl animate-fadeIn" style="animation-delay: 0.1s;" 
             x-data="{
                 cvs: {{ $cvs->toJson() }},
                 positions: [],
                 selectedPositions: [],
                 gpaCutoff: '',
                 sortByGPA: false,
                 init() {
                     // Extract unique positions
                     this.positions = [...new Set(this.cvs.map(cv => cv.applying_job_position))].sort();
                     // Select all positions by default
                     this.selectedPositions = [...this.positions];
                 },
                 get filteredCVs() {
                     let filtered = this.cvs;
                     
                     // Filter by position
                     if (this.selectedPositions.length > 0) {
                         filtered = filtered.filter(cv => this.selectedPositions.includes(cv.applying_job_position));
                     }
                     
                     // Filter by GPA cutoff
                     if (this.gpaCutoff !== '' && !isNaN(this.gpaCutoff)) {
                         filtered = filtered.filter(cv => {
                             return cv.student && cv.student.gpa && parseFloat(cv.student.gpa) >= parseFloat(this.gpaCutoff);
                         });
                     }
                     
                     // Sort by GPA if enabled
                     if (this.sortByGPA) {
                         filtered = [...filtered].sort((a, b) => {
                             const gpaA = a.student && a.student.gpa ? parseFloat(a.student.gpa) : 0;
                             const gpaB = b.student && b.student.gpa ? parseFloat(b.student.gpa) : 0;
                             return gpaB - gpaA;
                         });
                     }
                     
                     return filtered;
                 }
             }">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Received CVs</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Review and download student CVs requesting your company
                </p>
            </div>

            @if($cvs->isEmpty())
            <div class="p-12 text-center">
                <svg class="w-20 h-20 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">No CVs Received Yet</h3>
                <p class="text-gray-600 dark:text-gray-400">CVs will appear here once the admin assigns them to your company.</p>
            </div>
            @else
            
            <!-- Filters Section -->
            <div class="p-6 space-y-4 border-b border-gray-200 bg-gray-50 dark:bg-gray-900 dark:border-gray-700">
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Position Filter -->
                    <div>
                        <h3 class="mb-3 text-sm font-semibold text-gray-900 dark:text-gray-100">Filter by Position</h3>
                        <div class="space-y-2 overflow-y-auto max-h-40">
                            <template x-for="position in positions" :key="position">
                                <label class="flex items-center gap-2 p-2 transition-colors rounded cursor-pointer hover:bg-white dark:hover:bg-gray-800">
                                    <input type="checkbox" 
                                           :value="position" 
                                           x-model="selectedPositions"
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                                    <span class="text-sm text-gray-700 dark:text-gray-300" x-text="position"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <!-- GPA Filter -->
                    <div class="space-y-4">
                        <div>
                            <h3 class="mb-3 text-sm font-semibold text-gray-900 dark:text-gray-100">Sort & Filter by GPA</h3>
                            <label class="flex items-center gap-2 mb-3 cursor-pointer">
                                <input type="checkbox" 
                                       x-model="sortByGPA"
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Sort by GPA (High to Low)</span>
                            </label>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">GPA Cutoff</label>
                            <div class="flex gap-2">
                                <input type="number" 
                                       x-model="gpaCutoff"
                                       step="0.01" 
                                       min="0" 
                                       max="4.0"
                                       placeholder="e.g., 3.0"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                                <button @click="gpaCutoff = ''" 
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                                    Clear
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Show only CVs with GPA above this value</p>
                        </div>
                    </div>
                </div>

                <!-- Results Counter -->
                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Showing <span class="font-bold text-blue-600 dark:text-blue-400" x-text="filteredCVs.length"></span> of <span class="font-bold" x-text="cvs.length"></span> CVs
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Student</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Position</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">GPA</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Contact</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="cv in filteredCVs" :key="cv.id">
                            <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-10 h-10 font-semibold text-white rounded-full bg-gradient-to-br from-blue-500 to-purple-500">
                                            <span x-text="cv.student.name_with_initials.charAt(0).toUpperCase()"></span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="cv.student.name_with_initials"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="cv.applying_job_position"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="cv.student.gpa ? parseFloat(cv.student.gpa).toFixed(2) : 'N/A'"></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1 text-sm">
                                        <template x-if="cv.student.phone">
                                            <div class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                <span x-text="cv.student.phone"></span>
                                            </div>
                                        </template>
                                        <template x-if="cv.student.uni_email">
                                            <div class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <span class="truncate" x-text="cv.student.uni_email"></span>
                                            </div>
                                        </template>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <div class="flex gap-2">
                                        <a :href="`{{ asset('storage') }}/${cv.cv_file_path}`" 
                                           target="_blank"
                                           class="inline-flex items-center gap-1 px-3 py-2 font-semibold text-white transition-all bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>
                                        <a :href="`{{ url('company-access/' . $company->access_token . '/cv') }}/${cv.id}`"
                                           class="inline-flex items-center gap-1 px-3 py-2 font-semibold text-white transition-all bg-green-600 rounded-lg shadow-md hover:bg-green-700 hover:shadow-lg">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Download All Button -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 dark:bg-gray-900 dark:border-gray-700">
                <a href="{{ route('company.download-all-cvs', ['token' => $company->access_token]) }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-white transition-all bg-purple-600 rounded-lg shadow-lg hover:bg-purple-700 hover:shadow-xl hover:scale-105">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download All CVs ({{ $cvs->count() }})
                </a>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Download all assigned CVs as a ZIP file</p>
            </div>
            @endif
        </div>

        <!-- Security Notice -->
        <div class="p-6 mt-8 bg-white shadow-lg dark:bg-gray-800 rounded-xl animate-fadeIn" style="animation-delay: 0.2s;">
            <div class="flex items-start gap-4">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-amber-100 dark:bg-amber-900/30">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h4 class="mb-2 text-lg font-bold text-gray-900 dark:text-gray-100">Security Notice</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        This is a secure access link. Do not share this URL with others.
                    </p>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="py-8 mt-12 bg-white shadow-lg dark:bg-gray-800">
        <div class="container px-4 mx-auto text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                &copy; {{ date('Y') }} Career Fair DCS | University of Ruhuna
            </p>
        </div>
    </footer>

</body>
</html>
