@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<!-- Force page reload if accessed via Inertia -->
<script>
    if (window.history && window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<div class="flex items-center justify-center min-h-screen px-4 py-12 sm:px-6 lg:px-8 bg-gradient-to-br from-primary-50 via-secondary-50 to-accent-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="w-full max-w-md space-y-8 animate-fadeIn">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-transparent bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text">
                Welcome Back
            </h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Sign in to your account
            </p>
        </div>

        <div class="p-8 bg-white shadow-2xl dark:bg-gray-800 rounded-2xl">
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Email Address
                    </label>
                    <input type="email" id="email" name="email" required autofocus
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
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
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                        placeholder="Enter your password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500">
                        <label for="remember" class="block ml-2 text-sm text-gray-700 dark:text-gray-300">
                            Remember me
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full px-6 py-3 font-semibold text-white transition-all duration-200 rounded-lg shadow-lg bg-gradient-to-r from-primary-600 via-accent-500 to-secondary-600 hover:shadow-2xl hover:scale-105 hover:from-primary-700 hover:via-accent-600 hover:to-secondary-700">
                     Sign In
                </button>

                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-semibold text-primary-600 dark:text-primary-400 hover:underline">
                            Sign up here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
