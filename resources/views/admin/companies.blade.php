@extends('layouts.admin')

@section('title', 'Manage Companies')

@section('content')
<div class="min-h-screen py-8">
    <div class="px-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">
                Manage Companies
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Registered companies and their CV assignments
            </p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Companies</p>
                <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $companies->count() }}</p>
            </div>
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">With Vacant Positions</p>
                <p class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">
                    {{ $companies->filter(fn($c) => $c->participationResponse && $c->participationResponse->vacant_positions)->count() }}
                </p>
            </div>
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Will Participate</p>
                <p class="mt-2 text-3xl font-bold text-orange-600 dark:text-orange-400">
                    {{ $companies->filter(fn($c) => $c->participationResponse && $c->participationResponse->will_participate)->count() }}
                </p>
            </div>
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Assignments</p>
                <p class="mt-2 text-3xl font-bold text-purple-600 dark:text-purple-400">
                    {{ $companies->sum('cvs_count') }}
                </p>
            </div>
        </div>

        <!-- Companies Table -->
        <div class="overflow-hidden bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
            @if($companies->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">No companies registered yet</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Company</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Contact</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Vacant Positions</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">CVs</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($companies as $company)
                                <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center w-10 h-10 font-bold text-white rounded-full bg-gradient-to-br from-blue-500 to-purple-500">
                                                {{ strtoupper(substr($company->company_name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $company->company_name }}
                                                </div>
                                                @if($company->website)
                                                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
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
                                    <td class="px-6 py-4">
                                        @if($company->participationResponse && $company->participationResponse->vacant_positions)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($company->participationResponse->vacant_positions as $position)
                                                    <span class="inline-flex px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-900/30 dark:text-blue-200">
                                                        {{ $position }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500 dark:text-gray-400">No positions specified</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200">
                                            {{ $company->cvs_count }} CVs
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        @if($company->access_token)
                                        <div class="flex items-center gap-2" x-data="{ copied: false, showLink: false }">
                                            <!-- Copy Link Button -->
                                            <button @click="navigator.clipboard.writeText('{{ $company->access_url }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                                class="flex items-center gap-1 px-3 py-1 text-white transition-colors rounded-lg bg-blue-600 hover:bg-blue-700">
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
                                                    class="flex items-center gap-1 px-3 py-1 text-white transition-colors rounded-lg bg-amber-600 hover:bg-amber-700">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    Regenerate
                                                </button>
                                            </form>

                                            <!-- View Link -->
                                            <button @click="showLink = !showLink" 
                                                class="px-3 py-1 text-white transition-colors rounded-lg bg-purple-600 hover:bg-purple-700">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            
                                            <!-- Link Display (collapsible) -->
                                            <div x-show="showLink" x-collapse class="absolute z-10 max-w-md p-3 mt-2 text-xs text-white break-all bg-gray-900 rounded-lg shadow-xl">
                                                {{ $company->access_url }}
                                            </div>
                                        </div>
                                        @else
                                        <span class="text-sm italic text-gray-500 dark:text-gray-400">Token not generated</span>
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
