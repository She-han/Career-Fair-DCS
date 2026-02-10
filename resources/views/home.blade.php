@extends('layouts.app')

@section('title', 'Welcome to Career Fair')

@section('content')
<!-- Hero Section with Enhanced Animations -->
<section class="relative overflow-hidden min-h-screen flex items-center bg-gradient-to-br from-blue-50 via-purple-50 to-cyan-50 dark:from-gray-900 dark:via-purple-950 dark:to-blue-950 transition-colors duration-500" x-data="heroAnimation()" x-init="init()">
    <!-- Animated Background Gradient Orbs with Parallax -->
    <div class="absolute inset-0 overflow-hidden" x-ref="background">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-400 via-purple-500 to-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-40 dark:opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-gradient-to-br from-purple-400 via-cyan-500 to-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-40 dark:opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-40 dark:opacity-20 animate-blob animation-delay-4000"></div>
    </div>
    
    <!-- Floating Particles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <template x-for="i in 20" :key="i">
            <div class="absolute w-2 h-2 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full animate-float opacity-20"
                 :style="`left: ${Math.random() * 100}%; top: ${Math.random() * 100}%; animation-delay: ${Math.random() * 5}s; animation-duration: ${3 + Math.random() * 4}s;`"></div>
        </template>
    </div>
    
    <!-- Grid Pattern Overlay with Shimmer -->
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle, rgba(99, 102, 241, 0.4) 1px, transparent 1px); background-size: 30px 30px;"></div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20">
        <div class="max-w-5xl mx-auto text-center">
            <!-- Main Heading with Enhanced Effects -->
            <div class="hero-title animate-fadeIn" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="text-6xl md:text-7xl lg:text-8xl font-extrabold mb-6 leading-tight transform transition-all duration-500 hover:scale-105">
                    <span class="block bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 bg-clip-text text-transparent animate-gradient drop-shadow-2xl" 
                          style="background-size: 200% 200%; animation: gradient 4s ease infinite;">
                        Career Fair 2026
                    </span>
                </h1>
                <p class="text-2xl md:text-3xl bg-gradient-to-r from-blue-800 via-purple-700 to-cyan-700 dark:from-blue-200 dark:via-purple-300 dark:to-cyan-300 bg-clip-text text-transparent mb-4 font-bold animate-pulse" style="animation-duration: 3s;">
                    Bridging Talent with Opportunity
                </p>
                <p class="text-lg md:text-xl text-gray-700 dark:text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed transform transition-all duration-300 hover:scale-105">
                    Connect with innovative companies, showcase your skills, and launch your tech career faster with our vibrant community.
                </p>

                <p class=" mt-6 text-2xl md:text-3xl bg-gradient-to-r from-blue-800 via-purple-700 to-cyan-700 dark:from-blue-200 dark:via-purple-300 dark:to-cyan-300 bg-clip-text text-transparent mb-4 font-bold animate-pulse" style="animation-duration: 3s;">
                    Department of Computer Science
                </p>

                <p class="text-2xl md:text-3xl bg-gradient-to-r from-blue-800 via-purple-700 to-cyan-700 dark:from-blue-200 dark:via-purple-300 dark:to-cyan-300 bg-clip-text text-transparent mb-4 font-bold animate-pulse" style="animation-duration: 3s;">
                    University of Ruhuna
                </p>
            </div>
            
            <!-- CTA Buttons with Enhanced Animations -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center mb-16 animate-fadeIn animation-delay-300" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                @guest
                    <a href="{{ route('register') }}" class="cta-button group relative px-10 py-5 bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 text-white rounded-2xl font-bold text-lg overflow-hidden transform hover:scale-110 transition-all duration-300 shadow-2xl hover:shadow-purple-500/50 animate-glowPulse">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <svg class="w-6 h-6 transform group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Join as Student
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 via-blue-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                        </div>
                    </a>
                    <a href="{{ route('register') }}" class="cta-button group relative px-10 py-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-white border-3 border-blue-600 dark:border-purple-400 rounded-2xl font-bold text-lg hover:bg-blue-50 dark:hover:bg-gray-700 transform hover:scale-110 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-blue-500/30 flex items-center justify-center gap-2 overflow-hidden">
                        <svg class="w-6 h-6 transform group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="relative z-10">Register Company</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
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
            
            <!-- Scroll Indicator with Glow -->
            <div class="animate-bounce mt-12 relative">
                <div class="absolute inset-0 blur-xl bg-gradient-to-r from-blue-500 via-purple-500 to-cyan-500 opacity-50 animate-pulse"></div>
                <svg class="w-8 h-8 mx-auto text-blue-600 dark:text-cyan-400 relative z-10 drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- Trusted Partners Slider -->
<section class="py-16 bg-gradient-to-br from-white via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-950 dark:to-gray-900 transition-colors duration-500">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8" x-data="partnerSlider()" x-init="init()">
        <div class="flex items-center justify-between mb-8">
            <div data-aos="fade-right">
                <p class="text-sm font-semibold text-blue-600 dark:text-cyan-400 uppercase tracking-wider animate-pulse">Trusted by Leading Companies</p>
                <h3 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-purple-700 via-blue-600 to-cyan-700 dark:from-purple-300 dark:via-blue-400 dark:to-cyan-300 bg-clip-text text-transparent">Our Hiring Partners</h3>
            </div>
            <div class="flex items-center gap-2">
                <button @click="prev()" class="p-3 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 hover:from-blue-200 hover:to-purple-200 dark:hover:from-blue-800 dark:hover:to-purple-800 text-blue-700 dark:text-blue-200 transform hover:scale-110 transition-all duration-300 shadow-lg hover:shadow-xl">‹</button>
                <button @click="next()" class="p-3 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 hover:from-blue-200 hover:to-purple-200 dark:hover:from-blue-800 dark:hover:to-purple-800 text-blue-700 dark:text-blue-200 transform hover:scale-110 transition-all duration-300 shadow-lg hover:shadow-xl">›</button>
            </div>
        </div>

        <div class="carousel-track" x-ref="track">
            <template x-for="(partner, index) in partners" :key="index">
                <div class="carousel-slide group bg-gradient-to-br from-white via-blue-50 to-purple-50 dark:from-gray-800 dark:via-blue-900/20 dark:to-purple-900/20 rounded-xl shadow-lg hover:shadow-2xl border border-blue-100 dark:border-blue-800 p-6 flex items-center justify-between gap-4 transform hover:scale-105 hover:-translate-y-2 transition-all duration-300">
                    <div>
                        <p class="text-sm text-blue-600 dark:text-cyan-400 font-semibold mb-1 transform group-hover:translate-x-2 transition-transform duration-300" x-text="partner.industry"></p>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 transform group-hover:scale-105 transition-transform duration-300" x-text="partner.name"></h4>
                        <p class="text-sm text-purple-600 dark:text-purple-400 font-medium" x-text="partner.location"></p>
                    </div>
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-cyan-500 text-white flex items-center justify-center text-lg font-bold shadow-lg transform group-hover:rotate-12 group-hover:scale-110 transition-all duration-300">
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
<section class="py-20 bg-gradient-to-br from-white via-purple-50 to-cyan-50 dark:from-gray-900 dark:via-purple-950 dark:to-gray-900 transition-colors duration-500">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12 animate-fadeIn" data-aos="fade-down">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 bg-clip-text text-transparent drop-shadow-lg transform hover:scale-105 transition-transform duration-300">
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
                        <button type="submit" class="group relative w-full px-6 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 text-white rounded-xl font-semibold text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <svg class="w-6 h-6 transform group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Submit Interest Form
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 via-blue-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Want to access student CVs directly? 
                            <a href="{{ route('register') }}" class="text-blue-600 dark:text-cyan-400 font-semibold hover:underline transition-colors duration-200">
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
<section class="py-20 bg-gradient-to-br from-gray-50 via-purple-50 to-blue-50 dark:from-gray-800 dark:via-purple-900/20 dark:to-blue-900/20 transition-colors duration-500">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-blue-700 via-purple-600 to-cyan-600 dark:from-blue-300 dark:via-purple-400 dark:to-cyan-400 bg-clip-text text-transparent drop-shadow-lg">
                Why Choose Career Fair DCS?
            </h2>
            <p class="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto">
                A modern platform connecting talent with opportunity through innovation and excellence
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group feature-card bg-gradient-to-br from-white via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-950 dark:to-purple-950 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 animate-fadeIn border-2 border-blue-200 dark:border-blue-800 hover:border-blue-400 dark:hover:border-blue-600 relative overflow-hidden" data-aos="fade-up" data-aos-delay="0">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 via-purple-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 relative z-10">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-900 dark:text-gray-100 relative z-10 transform group-hover:translate-x-2 transition-transform duration-300">For Companies</h3>
                <p class="text-gray-600 dark:text-gray-400 relative z-10 leading-relaxed">
                    Access to talented students, streamlined CV review process, and efficient candidate selection.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="group feature-card bg-gradient-to-br from-white via-purple-50 to-cyan-50 dark:from-gray-900 dark:via-purple-950 dark:to-cyan-950 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 animate-fadeIn border-2 border-purple-200 dark:border-purple-800 hover:border-purple-400 dark:hover:border-purple-600 relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-cyan-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 via-cyan-500 to-blue-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 relative z-10">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-900 dark:text-gray-100 relative z-10 transform group-hover:translate-x-2 transition-transform duration-300">For Students</h3>
                <p class="text-gray-600 dark:text-gray-400 relative z-10 leading-relaxed">
                    Showcase your skills, upload your CV, and connect with potential employers seamlessly.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="group feature-card bg-gradient-to-br from-white via-cyan-50 to-blue-50 dark:from-gray-900 dark:via-cyan-950 dark:to-blue-950 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 animate-fadeIn border-2 border-cyan-200 dark:border-cyan-800 hover:border-cyan-400 dark:hover:border-cyan-600 relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 via-blue-500 to-purple-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 relative z-10">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-900 dark:text-gray-100 relative z-10 transform group-hover:translate-x-2 transition-transform duration-300">Secure & Efficient</h3>
                <p class="text-gray-600 dark:text-gray-400 relative z-10 leading-relaxed">
                    Enterprise-grade security, role-based access control, and streamlined processes.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 bg-gradient-to-br from-blue-600 via-purple-600 to-cyan-600 text-white relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full filter blur-3xl animate-blob"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-cyan-400/20 rounded-full filter blur-3xl animate-blob animation-delay-2000"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="animate-fadeIn transform hover:scale-110 transition-all duration-300" data-aos="zoom-in">
                <div class="stat-number text-5xl md:text-6xl font-bold mb-2 drop-shadow-2xl bg-gradient-to-r from-white via-cyan-200 to-white bg-clip-text text-transparent" style="animation: pulse 2s ease-in-out infinite;">500+</div>
                <div class="text-xl md:text-2xl opacity-90 font-semibold">Students</div>
            </div>
            <div class="animate-fadeIn transform hover:scale-110 transition-all duration-300" data-aos="zoom-in" data-aos-delay="100">
                <div class="stat-number text-5xl md:text-6xl font-bold mb-2 drop-shadow-2xl bg-gradient-to-r from-white via-purple-200 to-white bg-clip-text text-transparent" style="animation: pulse 2s ease-in-out infinite; animation-delay: 0.2s;">50+</div>
                <div class="text-xl md:text-2xl opacity-90 font-semibold">Companies</div>
            </div>
            <div class="animate-fadeIn transform hover:scale-110 transition-all duration-300" data-aos="zoom-in" data-aos-delay="200">
                <div class="stat-number text-5xl md:text-6xl font-bold mb-2 drop-shadow-2xl bg-gradient-to-r from-white via-blue-200 to-white bg-clip-text text-transparent" style="animation: pulse 2s ease-in-out infinite; animation-delay: 0.4s;">1000+</div>
                <div class="text-xl md:text-2xl opacity-90 font-semibold">CVs</div>
            </div>
            <div class="animate-fadeIn transform hover:scale-110 transition-all duration-300" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-number text-5xl md:text-6xl font-bold mb-2 drop-shadow-2xl bg-gradient-to-r from-white via-cyan-200 to-white bg-clip-text text-transparent" style="animation: pulse 2s ease-in-out infinite; animation-delay: 0.6s;">98%</div>
                <div class="text-xl md:text-2xl opacity-90 font-semibold">Satisfaction</div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        // Hero Animation Component
        Alpine.data('heroAnimation', () => ({
            init() {
                // Add parallax scrolling effect
                window.addEventListener('scroll', () => {
                    const scrolled = window.pageYOffset;
                    if (this.$refs.background) {
                        this.$refs.background.style.transform = `translateY(${scrolled * 0.5}px)`;
                    }
                });
            }
        }));

        // Partner Slider Component
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

    // Add gradient animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
