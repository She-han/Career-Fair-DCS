@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen py-12 bg-gradient-to-br from-primary-50 via-secondary-50 to-accent-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container px-4 mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 animate-fadeIn" data-aos="fade-down" data-aos-duration="800">
            <h1 class="mb-2 text-4xl font-bold text-transparent bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text">
                Admin Dashboard
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Manage and oversee Career Fair DCS
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
            <div class="p-6 bg-white shadow-lg dark:bg-gray-800 rounded-xl card-hover shine-effect" data-aos="fade-up" data-aos-delay="0">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Students</p>
                        <p class="mt-2 text-3xl font-bold text-primary-600 dark:text-primary-400">
                            {{ $totalStudents }}
                        </p>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-primary-100 dark:bg-primary-900">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white shadow-lg dark:bg-gray-800 rounded-xl card-hover shine-effect" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Companies</p>
                        <p class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">
                            {{ $totalCompanies }}
                        </p>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg dark:bg-green-900">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white shadow-lg dark:bg-gray-800 rounded-xl card-hover shine-effect" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total CVs</p>
                        <p class="mt-2 text-3xl font-bold text-secondary-600 dark:text-secondary-400">
                            {{ $totalCVs }}
                        </p>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-secondary-100 dark:bg-secondary-900">
                        <svg class="w-6 h-6 text-secondary-600 dark:text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white shadow-lg dark:bg-gray-800 rounded-xl card-hover shine-effect" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Responses</p>
                        <p class="mt-2 text-3xl font-bold text-accent-600 dark:text-accent-400">
                            {{ $pendingResponses }}
                        </p>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-accent-100 dark:bg-accent-900">
                        <svg class="w-6 h-6 text-accent-600 dark:text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
            <a href="{{ route('admin.responses') }}" class="p-6 bg-white shadow-lg dark:bg-gray-800 rounded-xl card-hover shine-effect" data-aos="zoom-in" data-aos-delay="0">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-primary-100 dark:bg-primary-900">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">View Responses</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Public company responses</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.companies') }}" class="p-6 bg-white shadow-lg dark:bg-gray-800 rounded-xl card-hover shine-effect" data-aos="zoom-in" data-aos-delay="100">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg dark:bg-green-900">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manage Companies</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Registered companies</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.cvs') }}" class="p-6 bg-white shadow-lg dark:bg-gray-800 rounded-xl card-hover shine-effect" data-aos="zoom-in" data-aos-delay="200">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-secondary-100 dark:bg-secondary-900">
                        <svg class="w-6 h-6 text-secondary-600 dark:text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manage CVs</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Assign CVs to companies</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Activity -->
        <div class="overflow-hidden bg-white shadow-lg dark:bg-gray-800 rounded-xl" data-aos="fade-up" data-aos-delay="300">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Recent CVs</h2>
                <p class="mt-1 text-gray-600 dark:text-gray-400">Latest CV submissions</p>
            </div>

            @if($recentCVs->isEmpty())
                <div class="p-12 text-center">
                    <p class="text-lg text-gray-600 dark:text-gray-400">No CVs uploaded yet</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Student</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Position</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">GPA</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Status</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Uploaded</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($recentCVs as $cv)
                                <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $cv->student->name_with_initials }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $cv->student->sc_number }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $cv->applying_job_position }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $cv->student->gpa ? number_format($cv->student->gpa, 2) : 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-200">
                                            {{ ucfirst($cv->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ $cv->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        <a href="{{ route('admin.cvs') }}" class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300">
                                            Manage
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
