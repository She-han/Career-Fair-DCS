@extends('layouts.admin')

@section('title', 'Manage Companies')

@section('content')
<div class="min-h-screen py-8" x-data="{ showDeleteConfirm: false, companyToDelete: null, showRegenerateConfirm: false, companyToRegenerate: null }">
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
                                        <span class="inline-flex px-3 py-1 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-200">
                                            {{ $company->cvs_count }} CVs
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($company->access_token)
                                        <div x-data="{ copied: false, showLink: false }">
                                            <div class="flex items-center gap-2">
                                                <!-- Copy Link Button -->
                                                <button @click="navigator.clipboard.writeText('{{ $company->access_url }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                                    class="flex items-center gap-1 px-2 py-1 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                                                    <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                    </svg>
                                                    <svg x-show="copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span x-text="copied ? 'Copied!' : 'Copy Link'"></span>
                                                </button>

                                                <!-- Regenerate Token -->
                                                <button @click="companyToRegenerate = { id: {{ $company->id }}, name: '{{ $company->company_name }}' }; showRegenerateConfirm = true"
                                                    class="flex items-center gap-1 px-3 py-1 text-white transition-colors rounded-lg bg-amber-600 hover:bg-amber-700">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    Regenerate
                                                </button>

                                                <!-- View Link -->
                                                <button @click="showLink = !showLink" 
                                                    class="px-3 py-1 text-white transition-colors bg-purple-600 rounded-lg hover:bg-purple-700">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>

                                                <!-- Delete Button -->
                                                <button @click="companyToDelete = { id: {{ $company->id }}, name: '{{ $company->company_name }}' }; showDeleteConfirm = true"
                                                    class="px-3 py-1 text-white transition-colors bg-red-600 rounded-lg hover:bg-red-700">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            
                                            <!-- Link Display (appears below buttons) -->
                                            <div x-show="showLink" x-collapse class="p-3 mt-3 text-xs text-gray-900 break-all border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
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

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteConfirm" 
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/30 backdrop-blur-sm backdrop-brightness-50"
             @click.self="showDeleteConfirm = false">
            <div class="w-full max-w-md p-6 bg-white border-2 border-gray-800 rounded-xl dark:border-gray-300 dark:bg-gray-800" @click.stop>
                <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full dark:bg-red-900/20">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-bold text-center text-gray-900 dark:text-white">Delete Company</h3>
                <p class="mb-6 text-center text-gray-600 dark:text-gray-400">
                    Are you sure you want to delete <strong x-text="companyToDelete?.name"></strong>? This action cannot be undone.
                </p>
                <div class="flex gap-3">
                    <button @click="showDeleteConfirm = false" 
                            class="flex-1 px-4 py-2.5 font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <form :action="`{{ url('admin/companies') }}/${companyToDelete?.id}`" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-4 py-2.5 font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 dark:bg-red-600 dark:hover:bg-red-700 transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Regenerate Token Confirmation Modal -->
        <div x-show="showRegenerateConfirm" 
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/30 backdrop-blur-sm backdrop-brightness-50"
             @click.self="showRegenerateConfirm = false">
            <div class="w-full max-w-md p-6 bg-white border-2 border-gray-800 rounded-xl dark:border-gray-300 dark:bg-gray-800" @click.stop>
                <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 rounded-full bg-amber-100 dark:bg-amber-900/20">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-bold text-center text-gray-900 dark:text-white">Regenerate Access Token</h3>
                <p class="mb-6 text-center text-gray-600 dark:text-gray-400">
                    Are you sure you want to regenerate the access token for <strong x-text="companyToRegenerate?.name"></strong>? The old link will stop working.
                </p>
                <div class="flex gap-3">
                    <button @click="showRegenerateConfirm = false" 
                            class="flex-1 px-4 py-2.5 font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <form :action="`{{ url('admin/companies') }}/${companyToRegenerate?.id}/regenerate-token`" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full px-4 py-2.5 font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 dark:bg-amber-600 dark:hover:bg-amber-700 transition-colors">
                            Regenerate
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
