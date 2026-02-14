@extends('layouts.auth')

@section('title', 'Register')

@section('content')<!-- Force page reload if accessed via Inertia -->
<script>
    if (window.history && window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<div class="flex items-center justify-center min-h-screen px-4 py-12 bg-gray-50 dark:bg-gray-900 sm:px-6 lg:px-8">
    <div class="w-full max-w-2xl space-y-8">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white">
                Student Registration
            </h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Join the Career Fair 2026
            </p>
        </div>

        <div class="p-8 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl shadow-sm">
            <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="role" value="student">

                <!-- Student Registration Fields -->
                <div>
                    <label for="name" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Full Name *
                    </label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                        placeholder="Enter your full name"
                        value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        University Email * (must be .edu or university domain)
                    </label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                        placeholder="Enter your email"
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="password" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Password *
                        </label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                            placeholder="Enter password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Confirm Password *
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-3 text-gray-900 transition-all bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Confirm password">
                    </div>
                </div>

                <!-- Student Information Section -->
                <div class="pt-4 space-y-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Student Information</h3>
                    
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="sc_number" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                SC Number *
                            </label>
                            <input type="text" id="sc_number" name="sc_number" required
                                class="w-full px-4 py-3 text-gray-900 transition-all bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="SC/XXXX/XXXXX"
                                value="{{ old('sc_number') }}">
                            @error('sc_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="gpa" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                GPA
                            </label>
                            <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="4"
                                class="w-full px-4 py-3 text-gray-900 transition-all bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="3.50"
                                value="{{ old('gpa') }}">
                            @error('gpa')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Phone Number
                        </label>
                        <input type="tel" id="phone" name="phone"
                            class="w-full px-4 py-3 text-gray-900 transition-all bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="+94 XX XXX XXXX"
                            value="{{ old('phone') }}">
                    </div>
                </div>

                <button type="submit" class="w-full px-6 py-4 text-lg font-semibold text-white transition-all duration-200 rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                    ✨ Create Account
                </button>

                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                            Sign in here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
