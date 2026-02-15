@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<!-- Force page reload if accessed via Inertia -->
<script>
    if (window.history && window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<div class="flex items-center justify-center min-h-screen px-4 py-12 bg-gray-50 dark:bg-gray-900 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white">
                Welcome Back
            </h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Sign in to your account
            </p>
        </div>

        <div class="p-8 bg-white border border-gray-200 shadow-sm dark:border-gray-700 dark:bg-gray-800 rounded-xl">
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Email Address
                    </label>
                    <input type="email" id="email" name="email" required autofocus
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                        placeholder="Enter your email"
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Password
                    </label>
                    <div class="relative" x-data="{ showPassword: false }">
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                            class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                            placeholder="Enter your password">
                        <button type="button" @click="showPassword = !showPassword" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="remember" class="block ml-2 text-sm text-gray-700 dark:text-gray-300">
                            Remember me
                        </label>
                    </div>
                    <div>
                        <a href="{{ route('forgot-password') }}" class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                            Forgot Password?
                        </a>
                    </div>
                </div>

                <button type="submit" class="w-full px-6 py-3 font-semibold text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                     Sign In
                </button>

   
            </form>
        </div>
    </div>
</div>
@endsection
