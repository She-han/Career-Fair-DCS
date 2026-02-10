@extends('layouts.app')

@section('title', 'Welcome to Career Fair')

@section('content')
<!-- Hero Section with Enhanced Animations -->
<section class="relative overflow-hidden min-h-screen flex items-center bg-gradient-to-br from-primary-100 via-secondary-100 to-accent-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)">
    <!-- Animated Background Gradient Orbs -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 dark:opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-gradient-to-br from-secondary-400 to-accent-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 dark:opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-accent-400 to-primary-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 dark:opacity-20 animate-blob animation-delay-4000"></div>
    </div>
    
    <!-- Grid Pattern Overlay -->
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20">
        <div class="max-w-5xl mx-auto text-center">
            <!-- Main Heading with Typing Effect -->
            <div class="hero-title animate-fadeIn" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="text-6xl md:text-7xl lg:text-8xl font-extrabold mb-6 leading-tight">
                    <span class="block bg-gradient-to-r from-primary-600 via-accent-600 to-secondary-600 bg-clip-text text-transparent animate-gradient drop-shadow-lg">
                        Career Fair DCS
                    </span>
                </h1>
                <p class="text-2xl md:text-3xl bg-gradient-to-r from-primary-800 via-secondary-700 to-accent-700 dark:from-primary-200 dark:via-secondary-300 dark:to-accent-300 bg-clip-text text-transparent mb-4 font-bold">
                    Bridging Talent with Opportunity
                </p>
                <p class="text-lg md:text-xl text-gray-700 dark:text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                    Connect with innovative companies, showcase your skills, and launch your tech career faster with our vibrant community.
                </p>
            </div>
            
            <!-- CTA Buttons with Enhanced Animations -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center mb-16 animate-fadeIn animation-delay-300" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                @guest
                    <a href="{{ route('register') }}" class="cta-button group relative px-10 py-5 bg-gradient-to-r from-primary-600 via-accent-500 to-secondary-600 text-white rounded-2xl font-bold text-lg overflow-hidden transform hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-primary-500/50 animate-glowPulse">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Join as Student
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-accent-600 via-primary-600 to-secondary-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                    <a href="{{ route('register') }}" class="cta-button group px-10 py-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-white border-3 border-primary-600 dark:border-primary-400 rounded-2xl font-bold text-lg hover:bg-primary-50 dark:hover:bg-gray-700 transform hover:scale-105 transition-all duration-300 shadow-xl flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Register Company
                    </a>
                @else
                    <a href="{{ route(auth()->user()->getDashboardRoute()) }}" class="group relative px-10 py-5 bg-gradient-to-r from-primary-600 to-secondary-600 text-white rounded-2xl font-bold text-lg overflow-hidden transform hover:scale-105 transition-all duration-300 shadow-2xl">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Go to Dashboard
                        </span>
                    </a>
                @endguest
            </div>
            
            <!-- Scroll Indicator -->
            <div class="animate-bounce mt-12">
                <svg class="w-8 h-8 mx-auto text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- Trusted Partners Slider -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8" x-data="partnerSlider()" x-init="init()">
        <div class="flex items-center justify-between mb-8">
            <div data-aos="fade-right">
                <p class="text-sm font-semibold text-primary-600 dark:text-primary-400 uppercase tracking-wider">Trusted by Leading Companies</p>
                <h3 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-secondary-700 to-accent-700 dark:from-secondary-300 dark:to-accent-300 bg-clip-text text-transparent">Our Hiring Partners</h3>
            </div>
            <div class="flex items-center gap-2">
                <button @click="prev()" class="p-2 rounded-full bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">‹</button>
                <button @click="next()" class="p-2 rounded-full bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">›</button>
            </div>
        </div>

        <div class="carousel-track" x-ref="track">
            <template x-for="(partner, index) in partners" :key="index">
                <div class="carousel-slide bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-primary-600 dark:text-primary-300 font-semibold" x-text="partner.industry"></p>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100" x-text="partner.name"></h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400" x-text="partner.location"></p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary-500 via-accent-500 to-secondary-500 text-white flex items-center justify-center text-lg font-bold">
                        <span x-text="partner.initials"></span>
                    </div>
                </div>
            </template>
        </div>

        <div class="flex justify-center gap-2 mt-6">
            <template x-for="(partner, index) in partners" :key="index">
                <span class="dot" :class="{ 'active': index === current, 'dark-mode': isDark }" @click="goTo(index)"></span>
            </template>
        </div>
    </div>
</section>

<!-- Company Interest Form Section -->
<section class="py-20 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12 animate-fadeIn" data-aos="fade-down">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-primary-600 via-secondary-600 to-accent-600 bg-clip-text text-transparent drop-shadow-sm">
                    Companies: Join Our Career Fair
                </h2>
                <p class="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto">
                    Interested in participating? Fill out this comprehensive form and we'll get in touch with you!
                </p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-lg animate-fadeIn" x-data="{ show: true }" x-show="show">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-green-600 hover:text-green-800 dark:text-green-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg animate-fadeIn" x-data="{ show: true }" x-show="show">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-red-800 dark:text-red-200 font-medium">Please correct the following errors:</p>
                            </div>
                            <ul class="ml-9 list-disc text-sm text-red-700 dark:text-red-300">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show = false" class="text-red-600 hover:text-red-800 dark:text-red-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl shadow-2xl p-8 md:p-10 animate-fadeIn" style="animation-delay: 0.2s;" x-data="{ willParticipate: {{ old('will_participate') ? 'true' : 'false' }} }">
                <form action="{{ route('company-interest.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Company Basic Info -->
                    <div>
                        <label for="company_name" class="block text-sm font-semibold text-primary-700 dark:text-primary-300 mb-2">
                            Company Name *
                        </label>
                        <input type="text" id="company_name" name="company_name" required
                            class="w-full px-4 py-3 rounded-lg border-2 border-primary-300 dark:border-primary-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-600 transition-all"
                            placeholder="Enter your company name"
                            value="{{ old('company_name') }}">
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Participation Question -->
                    <div class="border-t-2 border-secondary-200 dark:border-secondary-800 pt-6">
                        <label class="block text-sm font-semibold text-secondary-700 dark:text-secondary-300 mb-3">
                            Will you participate in the Career Fair? *
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center cursor-pointer px-4 py-2 rounded-lg border-2 border-primary-300 dark:border-primary-700 hover:bg-primary-50 dark:hover:bg-primary-900/30 transition-all">
                                <input type="radio" name="will_participate" value="1" x-model="willParticipate" 
                                    class="w-4 h-4 text-primary-600 focus:ring-primary-500" {{ old('will_participate') == '1' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-800 dark:text-gray-200 font-medium">Yes</span>
                            </label>
                            <label class="flex items-center cursor-pointer px-4 py-2 rounded-lg border-2 border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                <input type="radio" name="will_participate" value="0" x-model="willParticipate"
                                    class="w-4 h-4 text-accent-600 focus:ring-accent-500" {{ old('will_participate') == '0' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-800 dark:text-gray-200 font-medium">No</span>
                            </label>
                        </div>
                        @error('will_participate')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Conditional Fields: Show only if participating -->
                    <div x-show="willParticipate == '1'" x-collapse class="space-y-6 border-t-2 border-accent-200 dark:border-accent-800 pt-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gradient-to-br from-primary-50 to-secondary-50 dark:from-primary-950 dark:to-secondary-950 p-4 rounded-xl border border-primary-200 dark:border-primary-800">
                                <label for="expected_cvs" class="block text-sm font-semibold text-primary-700 dark:text-primary-300 mb-2">
                                    How many CVs do you hope to receive?
                                </label>
                                <input type="number" id="expected_cvs" name="expected_cvs" min="1" max="500"
                                    class="w-full px-4 py-3 rounded-lg border-2 border-primary-300 dark:border-primary-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-600 transition-all"
                                    placeholder="50"
                                    value="{{ old('expected_cvs') }}">
                                @error('expected_cvs')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-gradient-to-br from-secondary-50 to-accent-50 dark:from-secondary-950 dark:to-accent-950 p-4 rounded-xl border border-secondary-200 dark:border-secondary-800">
                                <label for="intern_positions" class="block text-sm font-semibold text-secondary-700 dark:text-secondary-300 mb-2">
                                    How many intern positions can you provide?
                                </label>
                                <input type="number" id="intern_positions" name="intern_positions" min="0" max="100"
                                    class="w-full px-4 py-3 rounded-lg border-2 border-secondary-300 dark:border-secondary-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-secondary-500 focus:border-secondary-600 transition-all"
                                    placeholder="5"
                                    value="{{ old('intern_positions') }}">
                                @error('intern_positions')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Vacant Positions -->
                        <div class="bg-gradient-to-br from-accent-50 to-primary-50 dark:from-accent-950 dark:to-primary-950 p-6 rounded-xl border-2 border-accent-200 dark:border-accent-800">
                            <label class="block text-sm font-semibold text-accent-800 dark:text-accent-200 mb-3">
                                What positions have vacancies? * <span class="text-xs text-accent-600 dark:text-accent-400">(Select all that apply)</span>
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @php
                                    $positions = ['Software Engineer', 'QA Engineer', 'AI Engineer', 'Product Manager', 'DevOps Engineer', 'UI/UX Designer', 'Data Scientist', 'Business Analyst', 'Cybersecurity Specialist'];
                                @endphp
                                @foreach($positions as $position)
                                <label class="flex items-center p-3 rounded-lg border-2 border-primary-200 dark:border-primary-800 hover:bg-white dark:hover:bg-gray-900 hover:border-primary-400 dark:hover:border-primary-600 cursor-pointer transition-all bg-white/50 dark:bg-gray-900/50">
                                    <input type="checkbox" name="vacant_positions[]" value="{{ $position }}" 
                                        class="w-4 h-4 text-primary-600 focus:ring-primary-500 rounded"
                                        {{ in_array($position, old('vacant_positions', [])) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm font-medium text-gray-800 dark:text-gray-200">{{ $position }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('vacant_positions')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preferred Languages -->
                        <div class="bg-gradient-to-br from-secondary-50 to-accent-50 dark:from-secondary-950 dark:to-accent-950 p-6 rounded-xl border-2 border-secondary-200 dark:border-secondary-800">
                            <label class="block text-sm font-semibold text-secondary-800 dark:text-secondary-200 mb-3">
                                Preferred Programming Languages * <span class="text-xs text-secondary-600 dark:text-secondary-400">(Select all that apply)</span>
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @php
                                    $languages = ['Java', 'Python', 'C', 'C++', 'C#', 'JavaScript', 'Rust', 'Go', 'PHP', 'Dart', 'TypeScript', 'Kotlin'];
                                @endphp
                                @foreach($languages as $language)
                                <label class="flex items-center p-3 rounded-lg border-2 border-secondary-200 dark:border-secondary-800 hover:bg-white dark:hover:bg-gray-900 hover:border-secondary-400 dark:hover:border-secondary-600 cursor-pointer transition-all bg-white/50 dark:bg-gray-900/50">
                                    <input type="checkbox" name="preferred_languages[]" value="{{ $language }}" 
                                        class="w-4 h-4 text-secondary-600 focus:ring-secondary-500 rounded"
                                        {{ in_array($language, old('preferred_languages', [])) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm font-medium text-gray-800 dark:text-gray-200">{{ $language }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('preferred_languages')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preferred Frameworks -->
                        <div class="bg-gradient-to-br from-primary-50 to-secondary-50 dark:from-primary-950 dark:to-secondary-950 p-6 rounded-xl border-2 border-primary-200 dark:border-primary-800">
                            <label class="block text-sm font-semibold text-primary-800 dark:text-primary-200 mb-3">
                                Preferred Frameworks/Technologies * <span class="text-xs text-primary-600 dark:text-primary-400">(Select all that apply)</span>
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @php
                                    $frameworks = ['Spring Boot', 'React', 'Angular', 'Next.js', 'Django', '.NET', 'Flutter', 'Vue.js', 'Node.js', 'TensorFlow', 'PyTorch', 'Laravel'];
                                @endphp
                                @foreach($frameworks as $framework)
                                <label class="flex items-center p-3 rounded-lg border-2 border-accent-200 dark:border-accent-800 hover:bg-white dark:hover:bg-gray-900 hover:border-accent-400 dark:hover:border-accent-600 cursor-pointer transition-all bg-white/50 dark:bg-gray-900/50">
                                    <input type="checkbox" name="preferred_frameworks[]" value="{{ $framework }}" 
                                        class="w-4 h-4 text-accent-600 focus:ring-accent-500 rounded"
                                        {{ in_array($framework, old('preferred_frameworks', [])) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm font-medium text-gray-800 dark:text-gray-200">{{ $framework }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('preferred_frameworks')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preferred Timeslot -->
                        <div class="bg-gradient-to-br from-accent-50 to-secondary-50 dark:from-accent-950 dark:to-secondary-950 p-6 rounded-xl border-2 border-accent-200 dark:border-accent-800">
                            <label for="preferred_timeslot" class="block text-sm font-semibold text-accent-800 dark:text-accent-200 mb-2">
                                Preferred Time Slot (Career Fair Day - Online) *
                            </label>
                            <select id="preferred_timeslot" name="preferred_timeslot"
                                class="w-full px-4 py-3 rounded-lg border-2 border-accent-300 dark:border-accent-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent-500 focus:border-accent-600 transition-all">
                                <option value="">Select a time slot</option>
                                <option value="9:00 AM - 11:00 AM" {{ old('preferred_timeslot') == '9:00 AM - 11:00 AM' ? 'selected' : '' }}>9:00 AM - 11:00 AM</option>
                                <option value="11:00 AM - 1:00 PM" {{ old('preferred_timeslot') == '11:00 AM - 1:00 PM' ? 'selected' : '' }}>11:00 AM - 1:00 PM</option>
                                <option value="1:00 PM - 3:00 PM" {{ old('preferred_timeslot') == '1:00 PM - 3:00 PM' ? 'selected' : '' }}>1:00 PM - 3:00 PM</option>
                                <option value="3:00 PM - 5:00 PM" {{ old('preferred_timeslot') == '3:00 PM - 5:00 PM' ? 'selected' : '' }}>3:00 PM - 5:00 PM</option>
                                <option value="5:00 PM - 7:00 PM" {{ old('preferred_timeslot') == '5:00 PM - 7:00 PM' ? 'selected' : '' }}>5:00 PM - 7:00 PM</option>
                            </select>
                            @error('preferred_timeslot')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Consent Checkbox -->
                        <div class="bg-primary-50 dark:bg-primary-900/20 rounded-lg p-4 border border-primary-200 dark:border-primary-700">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" name="consent_to_receive_cvs" value="1" required
                                    class="w-5 h-5 mt-0.5 text-primary-600 focus:ring-primary-500 rounded"
                                    {{ old('consent_to_receive_cvs') ? 'checked' : '' }}>
                                <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                    I consent to receive CVs from the Career Fair portal and understand that student information will be shared with our company for recruitment purposes. *
                                </span>
                            </label>
                            @error('consent_to_receive_cvs')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Message Field -->
                    <div class="border-t-2 border-primary-200 dark:border-primary-800 pt-6">
                        <label for="message" class="block text-sm font-semibold text-primary-700 dark:text-primary-300 mb-2">
                            Additional Message (Optional)
                        </label>
                        <textarea id="message" name="message" rows="4"
                            class="w-full px-4 py-3 rounded-lg border-2 border-primary-300 dark:border-primary-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-600 transition-all"
                            placeholder="Tell us about your requirements...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="w-full px-6 py-4 bg-gradient-to-r from-primary-600 via-secondary-600 to-accent-600 text-white rounded-lg font-semibold text-lg hover:shadow-xl hover:scale-105 transition-all duration-200 hover:from-primary-700 hover:via-secondary-700 hover:to-accent-700">
                            Submit Interest Form
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Want to access student CVs directly? 
                            <a href="{{ route('register') }}" class="text-primary-600 dark:text-primary-400 font-semibold hover:underline">
                                Register as a company →
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-primary-700 via-secondary-600 to-accent-600 dark:from-primary-300 dark:via-secondary-400 dark:to-accent-400 bg-clip-text text-transparent">
                Why Choose Career Fair DCS?
            </h2>
            <p class="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto">
                A modern platform connecting talent with opportunity through innovation and excellence
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="feature-card bg-white dark:bg-gray-900 rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fadeIn border border-primary-100 dark:border-primary-900" data-aos="fade-up" data-aos-delay="0">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-lg flex items-center justify-center mb-6 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-gray-100">For Companies</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Access to talented students, streamlined CV review process, and efficient candidate selection.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="feature-card bg-white dark:bg-gray-900 rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fadeIn border border-secondary-100 dark:border-secondary-900" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-gradient-to-br from-secondary-500 to-accent-500 rounded-lg flex items-center justify-center mb-6 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-gray-100">For Students</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Showcase your skills, upload your CV, and connect with potential employers seamlessly.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="feature-card bg-white dark:bg-gray-900 rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fadeIn border border-accent-100 dark:border-accent-900" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-gradient-to-br from-accent-500 to-primary-500 rounded-lg flex items-center justify-center mb-6 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-gray-100">Secure & Efficient</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Enterprise-grade security, role-based access control, and streamlined processes.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 bg-gradient-to-br from-primary-600 via-accent-600 to-secondary-600 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="animate-fadeIn" data-aos="zoom-in">
                <div class="stat-number text-5xl md:text-6xl font-bold mb-2 drop-shadow-lg">500</div>
                <div class="text-xl md:text-2xl opacity-90 font-semibold">Students</div>
            </div>
            <div class="animate-fadeIn" data-aos="zoom-in" data-aos-delay="100">
                <div class="stat-number text-5xl md:text-6xl font-bold mb-2 drop-shadow-lg">50</div>
                <div class="text-xl md:text-2xl opacity-90 font-semibold">Companies</div>
            </div>
            <div class="animate-fadeIn" data-aos="zoom-in" data-aos-delay="200">
                <div class="stat-number text-5xl md:text-6xl font-bold mb-2 drop-shadow-lg">1000</div>
                <div class="text-xl md:text-2xl opacity-90 font-semibold">CVs</div>
            </div>
            <div class="animate-fadeIn" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-number text-5xl md:text-6xl font-bold mb-2 drop-shadow-lg">98</div>
                <div class="text-xl md:text-2xl opacity-90 font-semibold">Satisfaction</div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('partnerSlider', () => ({
            partners: [
                { name: 'TechNova Labs', industry: 'Software', location: 'Colombo, LK', initials: 'TN' },
                { name: 'BlueWave Analytics', industry: 'Data & AI', location: 'Remote', initials: 'BW' },
                { name: 'CyanCloud Systems', industry: 'Cloud', location: 'Singapore', initials: 'CC' },
                { name: 'PurplePeak Solutions', industry: 'FinTech', location: 'London, UK', initials: 'PP' },
                { name: 'NovaHire', industry: 'Talent', location: 'San Francisco, US', initials: 'NH' },
            ],
            current: 0,
            intervalId: null,
            isDark: document.documentElement.classList.contains('dark'),
            init() {
                this.observeTheme();
                this.start();
            },
            start() {
                this.stop();
                this.intervalId = setInterval(() => this.next(), 4500);
            },
            stop() {
                if (this.intervalId) clearInterval(this.intervalId);
            },
            next() {
                this.current = (this.current + 1) % this.partners.length;
                this.scrollToCurrent();
            },
            prev() {
                this.current = (this.current - 1 + this.partners.length) % this.partners.length;
                this.scrollToCurrent();
            },
            goTo(index) {
                this.current = index;
                this.scrollToCurrent();
                this.start();
            },
            scrollToCurrent() {
                const track = this.$refs.track;
                const child = track.children[this.current];
                if (child) {
                    track.scrollTo({ left: child.offsetLeft, behavior: 'smooth' });
                }
            },
            observeTheme() {
                const observer = new MutationObserver(() => {
                    this.isDark = document.documentElement.classList.contains('dark');
                });
                observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            }
        }));
    });
</script>
@endpush
