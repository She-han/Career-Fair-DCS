@extends('layouts.admin')

@section('title', 'Change Password')

@section('content')
<div class="min-h-screen py-8">
    <div class="px-6 mx-auto max-w-3xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">
                Change Password
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Update your account password to keep it secure
            </p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg dark:bg-green-900/30 dark:border-green-700 dark:text-green-400">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Password Change Form -->
        <div class="overflow-hidden bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Security Settings</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Logged in as: <strong>{{ auth()->user()->email }}</strong></p>
            </div>

            <form action="{{ route('admin.change-password.post') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Current Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 @error('current_password') border-red-500 @enderror"
                           placeholder="Enter your current password">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="new_password" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        New Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="new_password" 
                           name="new_password" 
                           required
                           minlength="8"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 @error('new_password') border-red-500 @enderror"
                           placeholder="Enter new password (minimum 8 characters)">
                    @error('new_password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Must be at least 8 characters long</p>
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="new_password_confirmation" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Confirm New Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="new_password_confirmation" 
                           name="new_password_confirmation" 
                           required
                           minlength="8"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                           placeholder="Re-enter new password">
                </div>

                <!-- Password Requirements -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900/20 dark:border-blue-800">
                    <h3 class="text-sm font-semibold text-blue-800 dark:text-blue-300 mb-2">Password Requirements:</h3>
                    <ul class="text-sm text-blue-700 dark:text-blue-400 space-y-1">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            At least 8 characters long
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Use a unique password (not used elsewhere)
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Mix of letters, numbers, and symbols recommended
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-6 py-2.5 font-medium text-gray-700 transition-colors bg-gray-200 rounded-lg dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 font-medium text-white transition-colors rounded-lg shadow-lg bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Tips -->
        <div class="mt-6 p-4 bg-gray-100 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Security Tips
            </h3>
            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1 ml-7">
                <li>• Change your password regularly (every 3-6 months)</li>
                <li>• Never share your password with anyone</li>
                <li>• Use a password manager to generate and store strong passwords</li>
                <li>• Log out when using shared or public computers</li>
            </ul>
        </div>
    </div>
</div>
@endsection
