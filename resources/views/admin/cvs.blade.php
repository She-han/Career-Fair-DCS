@extends('layouts.admin')

@section('title', 'Manage CVs')

@section('content')
<div class="min-h-screen py-8" x-data="{
    cvs: {{ $cvs->toJson() }},
    positions: [],
    selectedPositions: [],
    gpaCutoff: '',
    searchQuery: '',
    companyCountFilter: 'all',
    showDeleteConfirm: false,
    cvToDelete: null,
    init() {
        this.positions = [...new Set(this.cvs.map(cv => cv.applying_job_position))].sort();
        this.selectedPositions = [...this.positions];
    },
    get filteredCVs() {
        let filtered = this.cvs;
        
        // Filter by position
        if (this.selectedPositions.length > 0) {
            filtered = filtered.filter(cv => this.selectedPositions.includes(cv.applying_job_position));
        }
        
        // Filter by GPA cutoff
        if (this.gpaCutoff !== '' && !isNaN(this.gpaCutoff)) {
            filtered = filtered.filter(cv => {
                return cv.student && cv.student.gpa && parseFloat(cv.student.gpa) >= parseFloat(this.gpaCutoff);
            });
        }
        
        // Filter by search query (name or SC number)
        if (this.searchQuery.trim() !== '') {
            const query = this.searchQuery.toLowerCase();
            filtered = filtered.filter(cv => {
                return cv.student.name_with_initials.toLowerCase().includes(query) || 
                       cv.student.sc_number.toLowerCase().includes(query);
            });
        }
        
        // Filter by company count
        if (this.companyCountFilter !== 'all') {
            const count = parseInt(this.companyCountFilter);
            filtered = filtered.filter(cv => cv.companies.length === count);
        }
        
        return filtered;
    }
}">
    <div class="px-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">
                    Manage CVs
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Assign student CVs to companies
                </p>
            </div>
            <a href="{{ route('admin.upload-cv') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-white transition-all bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 hover:shadow-xl hover:scale-105">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New CV
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total CVs</p>
                <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $cvs->count() }}</p>
            </div>
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Assigned</p>
                <p class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">
                    {{ $cvs->filter(function($cv) { return $cv->companies->count() > 0; })->count() }}
                </p>
            </div>
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Not Assigned</p>
                <p class="mt-2 text-3xl font-bold text-orange-600 dark:text-orange-400">
                    {{ $cvs->filter(function($cv) { return $cv->companies->count() === 0; })->count() }}
                </p>
            </div>
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Companies</p>
                <p class="mt-2 text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $companies->count() }}</p>
            </div>
        </div>

        <!-- CVs Table -->
        <div class="overflow-hidden bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
            @if($cvs->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">No CVs uploaded yet</p>
                </div>
            @else
                <!-- Filters Section -->
                <div class="p-6 space-y-4 border-b border-gray-200 bg-gray-50 dark:bg-gray-900 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Filter CVs</h3>
                    
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                        <!-- Search Filter -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Search by Name or SC Number</label>
                            <input type="text" 
                                   x-model="searchQuery"
                                   placeholder="Enter name or SC number"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                        </div>

                        <!-- Company Count Filter -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Companies Assigned</label>
                            <select x-model="companyCountFilter"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                                <option value="all">All CVs</option>
                                <option value="0">Not Assigned (0)</option>
                                <option value="1">1 Company</option>
                                <option value="2">2 Companies</option>
                                <option value="3">3 Companies</option>
                                <option value="4">4 Companies</option>
                                <option value="5">5 Companies</option>
                                <option value="6">6 Companies</option>
                                <option value="7">7 Companies</option>
                                <option value="8">8 Companies</option>
                                <option value="9">9 Companies</option>
                                <option value="10">10 Companies</option>
                            </select>
                        </div>

                        <!-- GPA Cutoff Filter -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">GPA Cutoff</label>
                            <div class="flex gap-2">
                                <input type="number" 
                                       x-model="gpaCutoff"
                                       step="0.01" 
                                       min="0" 
                                       max="4.0"
                                       placeholder="e.g., 3.0"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                                <button @click="gpaCutoff = ''" 
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                                    Clear
                                </button>
                            </div>
                        </div>

                        <!-- Position Filter -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Filter by Position</label>
                            <div class="p-3 space-y-2 overflow-y-auto bg-white border border-gray-300 rounded-lg max-h-40 dark:bg-gray-800 dark:border-gray-600">
                                <template x-for="position in positions" :key="position">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" 
                                               :value="position" 
                                               x-model="selectedPositions"
                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                                        <span class="text-sm text-gray-700 dark:text-gray-300" x-text="position"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Results Counter -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Showing <span class="font-bold text-blue-600 dark:text-blue-400" x-text="filteredCVs.length"></span> of <span class="font-bold" x-text="cvs.length"></span> CVs
                        </p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Student</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Position</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">GPA</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Skills</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Assigned To</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-for="cv in filteredCVs" :key="cv.id">
                                <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="cv.student.name_with_initials"></div>
                                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            <span x-text="cv.student.sc_number"></span> • <span x-text="cv.student.uni_email"></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100" x-text="cv.applying_job_position"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="cv.student.gpa ? parseFloat(cv.student.gpa).toFixed(2) : 'N/A'"></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-600 dark:text-gray-400" x-text="cv.tech_skills.length > 40 ? cv.tech_skills.substring(0, 40) + '...' : cv.tech_skills"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="cv.companies.length > 0 ? 'text-blue-800 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-200' : 'text-gray-800 bg-gray-100 dark:bg-gray-900 dark:text-gray-200'" 
                                              class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full"
                                              x-text="cv.companies.length > 0 ? cv.companies.length + ' Companies' : 'Unassigned'"></span>
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        <div class="flex gap-2">
                                            <button 
                                                @click="openAssignModal(cv.id, cv.student.name_with_initials, cv.companies.map(c => c.id))"
                                                class="inline-flex items-center gap-1 px-3 py-2 font-semibold text-white transition-all bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Assign
                                            </button>
                                            <a :href="`{{ asset('storage') }}/${cv.cv_file_path}`" 
                                               target="_blank"
                                               class="inline-flex items-center gap-1 px-3 py-2 font-semibold text-white transition-all bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 hover:shadow-lg">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View CV
                                            </a>
                                            <button @click="cvToDelete = cv; showDeleteConfirm = true"
                                                    class="inline-flex items-center gap-1 px-3 py-2 font-semibold text-white transition-all bg-red-600 rounded-lg shadow-md hover:bg-red-700 hover:shadow-lg">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
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
                <h3 class="mb-2 text-xl font-bold text-center text-gray-900 dark:text-white">Delete CV</h3>
                <p class="mb-6 text-center text-gray-600 dark:text-gray-400">
                    Are you sure you want to delete the CV for <strong x-text="cvToDelete?.student.name_with_initials"></strong>? This action cannot be undone.
                </p>
                <div class="flex gap-3">
                    <button @click="showDeleteConfirm = false" 
                            class="flex-1 px-4 py-2.5 font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <form :action="`{{ url('admin/cvs') }}/${cvToDelete?.id}`" method="POST" class="flex-1">
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
</div>

<!-- Assignment Modal -->
<div id="assignModal" class="fixed inset-0 z-50 hidden w-full h-full overflow-y-auto bg-black/30 backdrop-blur-sm backdrop-brightness-50 ">
    <div class="relative w-full max-w-2xl p-5 mx-auto bg-white border shadow-lg top-20 rounded-xl dark:bg-gray-800">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Assign CV to Companies</h3>
            <button onclick="closeAssignModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <p class="mb-2 text-gray-600 dark:text-gray-400">
            Student: <span id="modalStudentName" class="font-semibold text-gray-900 dark:text-gray-100"></span>
        </p>
        <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
            Check companies to assign, uncheck to unassign this CV
        </p>

        <form id="assignForm" method="POST" action="{{ route('admin.assign-cv') }}">
            @csrf
            <input type="hidden" name="cv_id" id="modalCvId">

            <div class="mb-6">
                <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Select Companies
                </label>
                <div class="p-4 space-y-2 overflow-y-auto border border-gray-300 rounded-lg max-h-96 dark:border-gray-600">
                    @foreach($companies as $company)
                        <label class="flex items-center p-3 transition-colors rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                            <input 
                                type="checkbox" 
                                name="company_ids[]" 
                                value="{{ $company->id }}"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded company-checkbox focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            >
                            <div class="flex-1 ml-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $company->company_name }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $company->industry ?? 'No industry' }} • {{ $company->contact_person }}
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3">
                <button 
                    type="button" 
                    onclick="closeAssignModal()"
                    class="px-6 py-3 font-medium text-gray-700 transition-colors bg-gray-200 rounded-lg dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="px-6 py-3 font-medium text-white transition-colors rounded-lg shadow-lg bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700"
                >
                    Assign Selected
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Make functions available globally for Alpine.js
window.openAssignModal = function(cvId, studentName, assignedCompanyIds) {
    document.getElementById('modalCvId').value = cvId;
    document.getElementById('modalStudentName').textContent = studentName;
    
    // Reset all checkboxes
    document.querySelectorAll('.company-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Check already assigned companies
    assignedCompanyIds.forEach(companyId => {
        const checkbox = document.querySelector(`.company-checkbox[value="${companyId}"]`);
        if (checkbox) {
            checkbox.checked = true;
        }
    });
    
    document.getElementById('assignModal').classList.remove('hidden');
};

window.closeAssignModal = function() {
    document.getElementById('assignModal').classList.add('hidden');
};

// Close modal on outside click
document.getElementById('assignModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeAssignModal();
    }
});
</script>
@endsection
