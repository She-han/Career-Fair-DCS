@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="flex items-center justify-center min-h-screen px-4 py-12 bg-gray-50 dark:bg-gray-900 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 bg-blue-100 rounded-full dark:bg-blue-900/30">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white">
                Forgot Password?
            </h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                No worries! Enter your email and we'll send you a temporary password.
            </p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="p-4 bg-green-100 border border-green-400 rounded-lg dark:bg-green-900/30 dark:border-green-700">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-3 text-green-600 dark:text-green-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-green-800 dark:text-green-300">Success!</p>
                        <p class="mt-1 text-sm text-green-700 dark:text-green-400">{{ session('success') }}</p>
                        <div class="mt-3">
                            <a href="{{ route('login') }}" 
                               class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Proceed to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Card -->
        <div class="p-8 bg-white border border-gray-200 shadow-sm dark:border-gray-700 dark:bg-gray-800 rounded-xl">
            <form action="{{ route('forgot-password.post') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Admin Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           required 
                           autofocus
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                           placeholder="Enter your admin email"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Instructions -->
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <strong>What happens next:</strong>
                    </p>
                    <ol class="mt-2 space-y-1 text-sm text-gray-600 list-decimal list-inside dark:text-gray-400">
                        <li>We'll verify your admin account</li>
                        <li>A temporary password will be sent to your email</li>
                        <li>Use it to login and change your password immediately</li>
                    </ol>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full px-6 py-3 font-semibold text-white transition-all duration-200 bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                    Send Temporary Password
                </button>

                <!-- Back to Login -->
                <div class="pt-4 text-center border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Remember your password?
                        <a href="{{ route('login') }}" class="font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                            Back to Login
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Security Notice -->
        <div class="p-4 border border-yellow-200 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 dark:border-yellow-800">
            <div class="flex items-start">
                <svg class="w-5 h-5 mr-2 text-yellow-600 dark:text-yellow-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="text-sm text-yellow-800 dark:text-yellow-300">
                    <strong>Security Tip:</strong> Never share your temporary password with anyone. Change it immediately after logging in.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
