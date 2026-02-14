@extends('layouts.admin')

@section('title', 'Company Responses')

@section('content')
<div class="min-h-screen py-8">
    <div class="px-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">
                Company Responses
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Public company participation interest submissions
            </p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Responses</p>
                <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $responses->total() }}</p>
            </div>
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Will Participate</p>
                <p class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">
                    {{ $responses->where('will_participate', true)->count() }}
                </p>
            </div>
        </div>

        <!-- Filters & Sorting -->
        <div class="p-6 mb-8 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl" 
             x-data="{ 
                 showFilters: {{ request()->hasAny(['will_participate', 'vacant_positions', 'sort']) ? 'true' : 'false' }},
                 activeFiltersCount: {{ 
                     (request('will_participate') !== null ? 1 : 0) + 
                     (request('vacant_positions') ? count(request('vacant_positions')) : 0) + 
                     (request('sort') ? 1 : 0) 
                 }}
             }">
            
            <!-- Filter Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Filters & Sorting</h2>
                    <span x-show="activeFiltersCount > 0" 
                          class="px-3 py-1 text-sm font-semibold rounded-full bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200"
                          x-text="activeFiltersCount + ' active'"></span>
                </div>
                <button @click="showFilters = !showFilters" 
                        class="flex items-center gap-2 px-4 py-2 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                    <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
                    <svg x-show="!showFilters" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg x-show="showFilters" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </button>
            </div>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('admin.responses') }}" x-show="showFilters" x-collapse>
                <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-3">
                    
                    <!-- Participation Filter -->
                    <div class="p-4 rounded-lg bg-purple-50 dark:bg-purple-950">
                        <label class="block mb-3 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            <svg class="inline w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Participation Status
                        </label>
                        <select name="will_participate" 
                                class="w-full transition-all border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">All Companies</option>
                            <option value="1" {{ request('will_participate') === '1' ? 'selected' : '' }}>✓ Will Participate</option>
                            <option value="0" {{ request('will_participate') === '0' ? 'selected' : '' }}>✗ Not Participating</option>
                        </select>
                    </div>

                    <!-- Sort By -->
                    <div class="p-4 rounded-lg bg-purple-50 dark:bg-purple-950">
                        <label class="block mb-3 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            <svg class="inline w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                            </svg>
                            Sort By
                        </label>
                        <select name="sort" 
                                class="w-full transition-all border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-accent-500 focus:border-transparent">
                            <option value="">Default (Newest First)</option>
                            <option value="expected_cvs" {{ request('sort') === 'expected_cvs' ? 'selected' : '' }}>Expected CVs (High to Low)</option>
                            <option value="intern_positions" {{ request('sort') === 'intern_positions' ? 'selected' : '' }}>Intern Positions (High to Low)</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-3">
                        <button type="submit" 
                                class="flex items-center justify-center gap-2 px-6 py-3 font-semibold transition-all transform bg-purple-200 rounded-lg dark:bg-gray-600 dark:text-white hover:bg-purple-400 dark:hover:bg-gray-500 hover:scale-105">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Apply Filters
                        </button>
                        <a href="{{ route('admin.responses') }}" 
                           class="flex items-center justify-center gap-2 px-6 py-3 font-semibold text-center text-gray-700 transition-all bg-gray-200 rounded-lg dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 dark:text-gray-300">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear All
                        </a>
                    </div>
                </div>

                <!-- Vacant Positions Filter -->
                <div class="p-4 rounded-lg bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                    <label class="block mb-3 text-sm font-semibold text-gray-900 dark:text-gray-100">
                        <svg class="inline w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Filter by Vacant Positions
                    </label>
                    <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                        @foreach($vacantPositions as $position)
                            <label class="flex items-center gap-2 p-3 transition-all bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:bg-gray-800 dark:border-gray-600 hover:border-primary-500 dark:hover:border-primary-400 group">
                                <input type="checkbox" 
                                       name="vacant_positions[]" 
                                       value="{{ $position }}"
                                       {{ in_array($position, (array)request('vacant_positions', [])) ? 'checked' : '' }}
                                       class="rounded text-primary-600 focus:ring-primary-500 focus:ring-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-primary-600 dark:group-hover:text-primary-400">
                                    {{ $position }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>

        <!-- Responses Cards -->
        <div class="space-y-6">
            @if($responses->isEmpty())
                <div class="p-12 text-center bg-white shadow-lg dark:bg-gray-800 rounded-xl">
                    <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">No responses yet</p>
                </div>
            @else
                @foreach($responses as $index => $response)
                    <div class="overflow-hidden transition-all duration-300 bg-white border border-gray-200 shadow-lg dark:bg-gray-800 rounded-xl dark:border-gray-700 hover:shadow-xl" 
                         x-data="{ expanded: false, showDeleteConfirm: false }" 
                         style="animation: fadeIn 0.5s ease-out {{ $index * 0.1 }}s both;">
                        
                        <!-- Card Header -->
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-primary-50 to-secondary-50 dark:from-gray-900 dark:to-gray-800 dark:border-gray-700">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-gray-100">{{ $response->company_name }}</h3>
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                            {{ $response->will_participate ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                                            {{ $response->will_participate ? '✓ Will Participate' : '✗ Not Participating' }}
                                        </span>
                              
                                        @if($response->consent_to_receive_cvs)
                                            <span class="px-3 py-1 text-xs font-semibold text-purple-800 bg-purple-100 rounded-full dark:bg-purple-900 dark:text-purple-200">
                                                ✓ CV Consent Given
                                            </span>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-3">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Expected CVs:</span>
                                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $response->expected_cvs ?? 'N/A' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Intern Positions:</span>
                                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $response->intern_positions ?? 'N/A' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Preferred Timeslot:</span>
                                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $response->preferred_timeslot ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 ml-4">
                                    <button @click="showDeleteConfirm = true" 
                                            class="p-2 text-red-600 transition-colors rounded-lg hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20"
                                            title="Delete Response">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    <button @click="expanded = !expanded" 
                                            class="p-2 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <svg x-show="!expanded" class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        <svg x-show="expanded" class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Expanded Details -->
                        <div x-show="expanded" x-collapse class="p-6 bg-white dark:bg-gray-800">
                            @if($response->will_participate)
                                <!-- Vacant Positions -->
                                <div class="p-4 mb-6 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                                    <h4 class="mb-3 font-semibold text-blue-900 dark:text-blue-100">Vacant Positions</h4>
                                    @if($response->vacant_positions)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($response->vacant_positions as $position)
                                                <span class="px-3 py-1.5 text-sm bg-white border border-blue-200 rounded-lg dark:bg-gray-700 dark:border-blue-700 font-medium">
                                                    {{ $position }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Not specified</p>
                                    @endif
                                </div>

                                <!-- Technologies -->
                                <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
                                    <!-- Languages -->
                                    <div class="p-4 rounded-lg bg-purple-50 dark:bg-purple-900/20">
                                        <h4 class="mb-3 font-semibold text-purple-900 dark:text-purple-100">Preferred Languages</h4>
                                        @if($response->preferred_languages)
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($response->preferred_languages as $language)
                                                    <span class="px-3 py-1.5 text-sm bg-white border border-purple-200 rounded-lg dark:bg-gray-700 dark:border-purple-700 font-medium">
                                                        {{ $language }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Not specified</p>
                                        @endif
                                    </div>

                                    <!-- Frameworks -->
                                    <div class="p-4 rounded-lg bg-green-50 dark:bg-green-900/20">
                                        <h4 class="mb-3 font-semibold text-green-900 dark:text-green-100">Preferred Frameworks</h4>
                                        @if($response->preferred_frameworks)
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($response->preferred_frameworks as $framework)
                                                    <span class="px-3 py-1.5 text-sm bg-white border border-green-200 rounded-lg dark:bg-gray-700 dark:border-green-700 font-medium">
                                                        {{ $framework }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Not specified</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Message -->
                            @if($response->message)
                                <div class="p-4 mb-4 rounded-lg bg-gray-50 dark:bg-gray-900">
                                    <h4 class="mb-2 font-semibold text-gray-900 dark:text-gray-100">Additional Message</h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $response->message }}</p>
                                </div>
                            @endif

                            <!-- Footer Info -->
                            <div class="flex items-center justify-between pt-4 text-sm text-gray-500 border-t border-gray-200 dark:border-gray-700 dark:text-gray-400">
                                <span>Submitted: {{ $response->created_at->format('F d, Y \a\t h:i A') }}</span>
                                <span>Last Updated: {{ $response->updated_at->format('F d, Y \a\t h:i A') }}</span>
                            </div>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div x-show="showDeleteConfirm" 
                             x-cloak
                             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50"
                             @click.self="showDeleteConfirm = false">
                            <div class="w-full max-w-md p-6 bg-white rounded-xl dark:bg-gray-800" @click.stop>
                                <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full dark:bg-red-900/20">
                                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-xl font-bold text-center text-gray-900 dark:text-white">Delete Response</h3>
                                <p class="mb-6 text-center text-gray-600 dark:text-gray-400">
                                    Are you sure you want to delete the response from <strong>{{ $response->company_name }}</strong>? This action cannot be undone.
                                </p>
                                <div class="flex gap-3">
                                    <button @click="showDeleteConfirm = false" 
                                            class="flex-1 px-4 py-2.5 font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                                        Cancel
                                    </button>
                                    <form action="{{ route('admin.responses.destroy', $response->id) }}" method="POST" class="flex-1">
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
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $responses->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
