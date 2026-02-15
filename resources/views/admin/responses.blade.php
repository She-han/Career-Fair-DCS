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

        <div x-data="{
            responses: {{ $responses->toJson() }},
            searchQuery: '',
            willParticipateFilter: '',
            sortBy: '',
            selectedVacantPositions: [],
            vacantPositions: {{ $vacantPositions->toJson() }},
            get filteredResponses() {
                let filtered = this.responses;
                
                // Filter by search query (company name)
                if (this.searchQuery.trim() !== '') {
                    const query = this.searchQuery.toLowerCase();
                    filtered = filtered.filter(response => 
                        response.company_name.toLowerCase().includes(query)
                    );
                }
                
                // Filter by participation status
                if (this.willParticipateFilter !== '') {
                    const willParticipate = this.willParticipateFilter === '1';
                    filtered = filtered.filter(response => response.will_participate === willParticipate);
                }
                
                // Filter by vacant positions
                if (this.selectedVacantPositions.length > 0) {
                    filtered = filtered.filter(response => {
                        if (!response.vacant_positions) return false;
                        return this.selectedVacantPositions.some(pos => 
                            response.vacant_positions.includes(pos)
                        );
                    });
                }
                
                // Sort
                if (this.sortBy === 'expected_cvs') {
                    filtered = [...filtered].sort((a, b) => 
                        parseInt(b.expected_cvs || 0) - parseInt(a.expected_cvs || 0)
                    );
                } else if (this.sortBy === 'intern_positions') {
                    filtered = [...filtered].sort((a, b) => 
                        parseInt(b.intern_positions || 0) - parseInt(a.intern_positions || 0)
                    );
                }
                
                return filtered;
            },
            get totalResponses() {
                return this.responses.length;
            },
            get willParticipateCount() {
                return this.responses.filter(r => r.will_participate).length;
            }
        }">
            <!-- Stats -->
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
                <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Responses</p>
                    <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400" x-text="totalResponses"></p>
                </div>
                <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Will Participate</p>
                    <p class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400" x-text="willParticipateCount"></p>
                </div>
            </div>

            <!-- Filters & Sorting -->
            <div class="p-6 mb-8 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <h3 class="mb-4 text-lg font-bold text-gray-900 dark:text-gray-100">Filter & Sort Responses</h3>
            
                <div class="space-y-4">
                    <!-- Search Bar -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Search by Company Name</label>
                        <input type="text" 
                               x-model="searchQuery"
                               placeholder="Enter company name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        
                        <!-- Participation Filter -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Participation Status
                            </label>
                            <select x-model="willParticipateFilter"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                                <option value="">All Companies</option>
                                <option value="1">✓ Will Participate</option>
                                <option value="0">✗ Not Participating</option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Sort By
                            </label>
                            <select x-model="sortBy"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                                <option value="">Default (Newest First)</option>
                                <option value="expected_cvs">Expected CVs (High to Low)</option>
                                <option value="intern_positions">Intern Positions (High to Low)</option>
                            </select>
                        </div>
                        
                        <!-- Clear Filters -->
                        <div class="flex items-end">
                            <button @click="searchQuery = ''; willParticipateFilter = ''; sortBy = ''; selectedVacantPositions = []" 
                                    class="w-full px-4 py-2 font-medium text-gray-700 transition-colors bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                Clear All Filters
                            </button>
                        </div>
                    </div>

                    <!-- Vacant Positions Filter -->
                    <div class="mt-4">
                        <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Filter by Vacant Positions
                        </label>
                        <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                            <template x-for="position in vacantPositions" :key="position">
                                <label class="flex items-center gap-2 p-3 transition-all bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:bg-gray-800 dark:border-gray-600 hover:border-blue-500 dark:hover:border-blue-400">
                                    <input type="checkbox" 
                                           :value="position"
                                           x-model="selectedVacantPositions"
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300" x-text="position"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                    
                    <!-- Results Counter -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Showing <span class="font-bold text-blue-600 dark:text-blue-400" x-text="filteredResponses.length"></span> of <span class="font-bold" x-text="totalResponses"></span> responses
                        </p>
                    </div>
                </div>
        </div>

            <!-- Responses Cards -->
            <div class="space-y-6">
            <template x-if="filteredResponses.length === 0">
                <div class="p-12 text-center bg-white shadow-lg dark:bg-gray-800 rounded-xl">
                    <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">No responses match your filters</p>
                </div>
            </template>
            
            <template x-for="(response, index) in filteredResponses" :key="response.id">
                <div class="overflow-hidden transition-all duration-300 bg-white border border-gray-200 shadow-lg dark:bg-gray-800 rounded-xl dark:border-gray-700 hover:shadow-xl" 
                     x-data="{ expanded: false, showDeleteConfirm: false }">
                        
                        <!-- Card Header -->
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-primary-50 to-secondary-50 dark:from-gray-900 dark:to-gray-800 dark:border-gray-700">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-gray-100" x-text="response.company_name"></h3>
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full"
                                              :class="response.will_participate ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200'"
                                              x-text="response.will_participate ? '✓ Will Participate' : '✗ Not Participating'">
                                        </span>
                              
                                        <span x-show="response.consent_to_receive_cvs" class="px-3 py-1 text-xs font-semibold text-purple-800 bg-purple-100 rounded-full dark:bg-purple-900 dark:text-purple-200">
                                            ✓ CV Consent Given
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-3">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Expected CVs:</span>
                                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100" x-text="response.expected_cvs || 'N/A'"></span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Intern Positions:</span>
                                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100" x-text="response.intern_positions || 'N/A'"></span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Preferred Timeslot:</span>
                                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100" x-text="response.preferred_timeslot || 'N/A'"></span>
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
                            <template x-if="response.will_participate">
                                <div>
                                    <!-- Vacant Positions -->
                                    <div class="p-4 mb-6 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                                        <h4 class="mb-3 font-semibold text-blue-900 dark:text-blue-100">Vacant Positions</h4>
                                        <template x-if="response.vacant_positions && response.vacant_positions.length > 0">
                                            <div class="flex flex-wrap gap-2">
                                                <template x-for="position in response.vacant_positions" :key="position">
                                                    <span class="px-3 py-1.5 text-sm bg-white border border-blue-200 rounded-lg dark:bg-gray-700 dark:border-blue-700 font-medium" x-text="position"></span>
                                                </template>
                                            </div>
                                        </template>
                                        <template x-if="!response.vacant_positions || response.vacant_positions.length === 0">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Not specified</p>
                                        </template>
                                    </div>

                                    <!-- Technologies -->
                                    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
                                        <!-- Languages -->
                                        <div class="p-4 rounded-lg bg-purple-50 dark:bg-purple-900/20">
                                            <h4 class="mb-3 font-semibold text-purple-900 dark:text-purple-100">Preferred Languages</h4>
                                            <template x-if="response.preferred_languages && response.preferred_languages.length > 0">
                                                <div class="flex flex-wrap gap-2">
                                                    <template x-for="language in response.preferred_languages" :key="language">
                                                        <span class="px-3 py-1.5 text-sm bg-white border border-purple-200 rounded-lg dark:bg-gray-700 dark:border-purple-700 font-medium" x-text="language"></span>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="!response.preferred_languages || response.preferred_languages.length === 0">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Not specified</p>
                                            </template>
                                        </div>

                                        <!-- Frameworks -->
                                        <div class="p-4 rounded-lg bg-green-50 dark:bg-green-900/20">
                                            <h4 class="mb-3 font-semibold text-green-900 dark:text-green-100">Preferred Frameworks</h4>
                                            <template x-if="response.preferred_frameworks && response.preferred_frameworks.length > 0">
                                                <div class="flex flex-wrap gap-2">
                                                    <template x-for="framework in response.preferred_frameworks" :key="framework">
                                                        <span class="px-3 py-1.5 text-sm bg-white border border-green-200 rounded-lg dark:bg-gray-700 dark:border-green-700 font-medium" x-text="framework"></span>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="!response.preferred_frameworks || response.preferred_frameworks.length === 0">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Not specified</p>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Message -->
                            <template x-if="response.message">
                                <div class="p-4 mb-4 rounded-lg bg-gray-50 dark:bg-gray-900">
                                    <h4 class="mb-2 font-semibold text-gray-900 dark:text-gray-100">Additional Message</h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300" x-text="response.message"></p>
                                </div>
                            </template>

                            <!-- Footer Info -->
                            <div class="flex items-center justify-between pt-4 text-sm text-gray-500 border-t border-gray-200 dark:border-gray-700 dark:text-gray-400">
                                <span>Submitted: <span x-text="new Date(response.created_at).toLocaleString('en-US', {year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true})"></span></span>
                                <span>Last Updated: <span x-text="new Date(response.updated_at).toLocaleString('en-US', {year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true})"></span></span>
                            </div>
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
                                <h3 class="mb-2 text-xl font-bold text-center text-gray-900 dark:text-white">Delete Response</h3>
                                <p class="mb-6 text-center text-gray-600 dark:text-gray-400">
                                    Are you sure you want to delete the response from <strong x-text="response.company_name"></strong>? This action cannot be undone.
                                </p>
                                <div class="flex gap-3">
                                    <button @click="showDeleteConfirm = false" 
                                            class="flex-1 px-4 py-2.5 font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                                        Cancel
                                    </button>
                                    <form :action="`{{ url('admin/responses') }}/${response.id}`" method="POST" class="flex-1">
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
                </template>
            </div>
        </div>
    </div>
</div>
@endsection
