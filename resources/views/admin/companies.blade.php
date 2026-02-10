@extends('layouts.app')

@section('title', 'Manage Companies')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 via-secondary-50 to-accent-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 animate-fadeIn">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent mb-2">
                        Manage Companies
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Registered companies and their CV assignments
                    </p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 animate-fadeIn">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Companies</p>
                <p class="text-3xl font-bold text-primary-600 dark:text-primary-400 mt-2">{{ $companies->count() }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.1s;">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">With User Accounts</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                    {{ $companies->filter(fn($c) => $c->user_id)->count() }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.15s;">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Token Access Only</p>
                <p class="text-3xl font-bold text-accent-600 dark:text-accent-400 mt-2">
                    {{ $companies->filter(fn($c) => !$c->user_id)->count() }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.2s;">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Assignments</p>
                <p class="text-3xl font-bold text-secondary-600 dark:text-secondary-400 mt-2">
                    {{ $companies->sum('cvs_count') }}
                </p>
            </div>
        </div>

        <!-- Companies Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden animate-fadeIn" style="animation-delay: 0.3s;">
            @if($companies->isEmpty())
                <div class="p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mt-4">No companies registered yet</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Industry</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">CVs</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Access Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($companies as $company)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($company->company_name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $company->company_name }}
                                                </div>
                                                @if($company->website)
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                        <a href="{{ $company->website }}" target="_blank" class="hover:text-primary-600 dark:hover:text-primary-400">
                                                            {{ Str::limit($company->website, 30) }}
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $company->contact_person ?? 'N/A' }}
                                        </div>
                                        @if($company->email)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $company->email }}</div>
                                        @endif
                                        @if($company->phone)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $company->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $company->industry ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200">
                                            {{ $company->cvs_count }} CVs
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($company->user_id)
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                User Login
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-accent-100 dark:bg-accent-900 text-accent-800 dark:text-accent-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                </svg>
                                                Token Only
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($company->access_token)
                                        <div class="flex items-center gap-2" x-data="{ copied: false, showLink: false }">
                                            <!-- Copy Link Button -->
                                            <button @click="navigator.clipboard.writeText('{{ $company->access_url }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                                class="px-3 py-1 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors flex items-center gap-1">
                                                <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                </svg>
                                                <svg x-show="copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span x-text="copied ? 'Copied!' : 'Copy Link'"></span>
                                            </button>

                                            <!-- Regenerate Token -->
                                            <form action="{{ route('admin.company.regenerate-token', $company->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Regenerate access token? Old link will stop working.')" 
                                                    class="px-3 py-1 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition-colors flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    Regenerate
                                                </button>
                                            </form>

                                            <!-- View Link -->
                                            <button @click="showLink = !showLink" 
                                                class="px-3 py-1 bg-secondary-600 hover:bg-secondary-700 text-white rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            
                                            <!-- Link Display (collapsible) -->
                                            <div x-show="showLink" x-collapse class="absolute z-10 mt-2 p-3 bg-gray-900 text-white text-xs rounded-lg shadow-xl max-w-md break-all">
                                                {{ $company->access_url }}
                                            </div>
                                        </div>
                                        @else
                                        <span class="text-sm text-gray-500 dark:text-gray-400 italic">Token not generated</span>
                                        @endif
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
