@extends('layouts.app')

@section('title', 'Company Responses')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 via-secondary-50 to-accent-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 animate-fadeIn">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent mb-2">
                        Company Responses
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Public company participation interest submissions
                    </p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 animate-fadeIn border-l-4 border-primary-500">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Responses</p>
                <p class="text-3xl font-bold text-primary-600 dark:text-primary-400 mt-2">{{ $responses->total() }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 animate-fadeIn border-l-4 border-green-500" style="animation-delay: 0.1s;">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Will Participate</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                    {{ $responses->where('will_participate', true)->count() }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 animate-fadeIn border-l-4 border-blue-500" style="animation-delay: 0.2s;">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Confirmed</p>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">
                    {{ $responses->where('status', 'confirmed')->count() }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 animate-fadeIn border-l-4 border-accent-500" style="animation-delay: 0.3s;">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Pending</p>
                <p class="text-3xl font-bold text-accent-600 dark:text-accent-400 mt-2">
                    {{ $responses->where('status', 'pending')->count() }}
                </p>
            </div>
        </div>

        <!-- Responses Cards -->
        <div class="space-y-6">
            @if($responses->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mt-4">No responses yet</p>
                </div>
            @else
                @foreach($responses as $index => $response)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300" 
                         x-data="{ expanded: false }" 
                         style="animation: fadeIn 0.5s ease-out {{ $index * 0.1 }}s both;">
                        
                        <!-- Card Header -->
                        <div class="p-6 bg-gradient-to-r from-primary-50 to-secondary-50 dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $response->company_name }}</h3>
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                            {{ $response->will_participate ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                                            {{ $response->will_participate ? '✓ Will Participate' : '✗ Not Participating' }}
                                        </span>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                            {{ $response->status === 'confirmed' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : 
                                               ($response->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 
                                               'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200') }}">
                                            {{ ucfirst($response->status) }}
                                        </span>
                                        @if($response->consent_to_receive_cvs)
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                                ✓ CV Consent Given
                                            </span>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Contact:</span>
                                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $response->contact_person }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Email:</span>
                                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $response->email }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Phone:</span>
                                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $response->phone }}</span>
                                        </div>
                                    </div>
                                </div>
                                <button @click="expanded = !expanded" 
                                        class="ml-4 p-2 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900 transition-colors">
                                    <svg x-show="!expanded" class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                    <svg x-show="expanded" class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Expanded Details -->
                        <div x-show="expanded" x-collapse class="p-6 bg-white dark:bg-gray-800">
                            @if($response->will_participate)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <!-- Expected CVs & Intern Positions -->
                                    <div class="bg-primary-50 dark:bg-primary-900/20 rounded-lg p-4">
                                        <h4 class="font-semibold text-primary-900 dark:text-primary-100 mb-3">Recruitment Details</h4>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Expected CVs:</span>
                                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $response->expected_cvs ?? 'N/A' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Intern Positions:</span>
                                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $response->intern_positions ?? 'N/A' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Preferred Timeslot:</span>
                                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $response->preferred_timeslot ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vacant Positions -->
                                    <div class="bg-secondary-50 dark:bg-secondary-900/20 rounded-lg p-4">
                                        <h4 class="font-semibold text-secondary-900 dark:text-secondary-100 mb-3">Vacant Positions</h4>
                                        @if($response->vacant_positions)
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($response->vacant_positions as $position)
                                                    <span class="px-2 py-1 bg-white dark:bg-gray-700 rounded-md text-xs border border-secondary-200 dark:border-secondary-700">
                                                        {{ $position }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Not specified</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Technologies -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <!-- Languages -->
                                    <div class="bg-accent-50 dark:bg-accent-900/20 rounded-lg p-4">
                                        <h4 class="font-semibold text-accent-900 dark:text-accent-100 mb-3">Preferred Languages</h4>
                                        @if($response->preferred_languages)
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($response->preferred_languages as $language)
                                                    <span class="px-2 py-1 bg-white dark:bg-gray-700 rounded-md text-xs border border-accent-200 dark:border-accent-700">
                                                        {{ $language }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Not specified</p>
                                        @endif
                                    </div>

                                    <!-- Frameworks -->
                                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                                        <h4 class="font-semibold text-green-900 dark:text-green-100 mb-3">Preferred Frameworks</h4>
                                        @if($response->preferred_frameworks)
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($response->preferred_frameworks as $framework)
                                                    <span class="px-2 py-1 bg-white dark:bg-gray-700 rounded-md text-xs border border-green-200 dark:border-green-700">
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
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 mb-4">
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Additional Message</h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $response->message }}</p>
                                </div>
                            @endif

                            <!-- Footer Info -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400">
                                <span>Submitted: {{ $response->created_at->format('F d, Y \a\t h:i A') }}</span>
                                <span>Last Updated: {{ $response->updated_at->format('F d, Y \a\t h:i A') }}</span>
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
