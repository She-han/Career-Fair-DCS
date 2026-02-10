@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-primary-100 via-secondary-100 to-accent-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-2xl w-full space-y-8 animate-fadeIn">
        <div class="text-center">
            <h2 class="text-4xl font-bold bg-gradient-to-r from-primary-600 via-secondary-600 to-accent-600 bg-clip-text text-transparent">
                Create Your Account
            </h2>
            <p class="mt-2 text-gray-700 dark:text-gray-400 font-medium">
                Join our career fair platform
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl p-8" x-data="{ role: 'student' }">
            <!-- Role Selection -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                    I am registering as:
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <button type="button" @click="role = 'student'"
                        :class="role === 'student' ? 'bg-gradient-to-r from-primary-600 via-accent-500 to-secondary-600 text-white shadow-lg' : 'bg-gradient-to-r from-gray-100 to-gray-200 dark:bg-gradient-to-r dark:from-gray-700 dark:to-gray-600 text-gray-800 dark:text-gray-200 border-2 border-gray-300 dark:border-gray-600'"
                        class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 hover:scale-105 hover:shadow-xl">
                        👨‍🎓 Student
                    </button>
                    <button type="button" @click="role = 'company_user'"
                        :class="role === 'company_user' ? 'bg-gradient-to-r from-primary-600 via-accent-500 to-secondary-600 text-white shadow-lg' : 'bg-gradient-to-r from-gray-100 to-gray-200 dark:bg-gradient-to-r dark:from-gray-700 dark:to-gray-600 text-gray-800 dark:text-gray-200 border-2 border-gray-300 dark:border-gray-600'"
                        class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 hover:scale-105 hover:shadow-xl">
                        🏢 Company
                    </button>
                </div>
            </div>

            <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="role" :value="role">

                <!-- Common Fields -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Full Name *
                    </label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                        placeholder="Enter your full name"
                        value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <span x-show="role === 'student'">University Email * (must be .edu or university domain)</span>
                        <span x-show="role === 'company_user'">Company Email *</span>
                    </label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                        placeholder="Enter your email"
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Password *
                        </label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                            placeholder="Enter password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Confirm Password *
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                            placeholder="Confirm password">
                    </div>
                </div>

                <!-- Student Specific Fields -->
                <div x-show="role === 'student'" x-collapse>
                    <div class="space-y-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Student Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="sc_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    SC Number *
                                </label>
                                <input type="text" id="sc_number" name="sc_number"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                    placeholder="SC/XXXX/XXXXX"
                                    value="{{ old('sc_number') }}">
                                @error('sc_number')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gpa" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    GPA
                                </label>
                                <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="4"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                    placeholder="3.50"
                                    value="{{ old('gpa') }}">
                                @error('gpa')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Phone Number
                            </label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="+94 XX XXX XXXX"
                                value="{{ old('phone') }}">
                        </div>
                    </div>
                </div>

                <!-- Company Specific Fields -->
                <div x-show="role === 'company_user'" x-collapse>
                    <div class="space-y-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Company Information</h3>
                        
                        <div>
                            <label for="company_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Company Name *
                            </label>
                            <input type="text" id="company_name" name="company_name"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="Enter company name"
                                value="{{ old('company_name') }}">
                            @error('company_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="contact_person" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Contact Person *
                                </label>
                                <input type="text" id="contact_person" name="contact_person"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                    placeholder="John Doe"
                                    value="{{ old('contact_person') }}">
                            </div>

                            <div>
                                <label for="company_phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Phone Number *
                                </label>
                                <input type="tel" id="company_phone" name="company_phone"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                    placeholder="+94 XX XXX XXXX"
                                    value="{{ old('company_phone') }}">
                            </div>
                        </div>

                        <div>
                            <label for="website" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Company Website
                            </label>
                            <input type="url" id="website" name="website"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="https://www.company.com"
                                value="{{ old('website') }}">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Company Description
                            </label>
                            <textarea id="description" name="description" rows="3"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="Brief description of your company...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full px-6 py-4 bg-gradient-to-r from-primary-600 via-accent-500 to-secondary-600 text-white rounded-lg font-semibold text-lg shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-200 hover:from-primary-700 hover:via-accent-600 hover:to-secondary-700">
                    ✨ Create Account
                </button>

                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary-600 dark:text-primary-400 font-semibold hover:underline">
                            Sign in here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
