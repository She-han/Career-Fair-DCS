@extends('layouts.admin')

@section('title', 'Manage CVs')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 via-secondary-50 to-accent-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 animate-fadeIn">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent mb-2">
                        Manage CVs
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Assign student CVs to companies
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
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total CVs</p>
                <p class="text-3xl font-bold text-primary-600 dark:text-primary-400 mt-2">{{ $cvs->count() }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.1s;">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Pending</p>
                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">
                    {{ $cvs->where('status', 'pending')->count() }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.2s;">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Approved</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                    {{ $cvs->where('status', 'approved')->count() }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.3s;">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Companies</p>
                <p class="text-3xl font-bold text-accent-600 dark:text-accent-400 mt-2">{{ $companies->count() }}</p>
            </div>
        </div>

        <!-- CVs Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden animate-fadeIn" style="animation-delay: 0.4s;">
            @if($cvs->isEmpty())
                <div class="p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mt-4">No CVs uploaded yet</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Position</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">GPA</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Skills</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Assigned To</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($cvs as $cv)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $cv->student->name_with_initials }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $cv->student->sc_number }} • {{ $cv->student->uni_email }}
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
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-600 dark:text-gray-400">
                                            {{ Str::limit($cv->tech_skills, 40) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($cv->companies->isNotEmpty())
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200">
                                                {{ $cv->companies->count() }} Companies
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                                Unassigned
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($cv->status === 'pending')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                                Pending
                                            </span>
                                        @elseif($cv->status === 'approved')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                Approved
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button 
                                            onclick="openAssignModal({{ $cv->id }}, '{{ $cv->student->name_with_initials }}', {{ $cv->companies->pluck('id')->toJson() }})"
                                            class="text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300 font-medium mr-3"
                                        >
                                            Assign
                                        </button>
                                        <a href="{{ asset('storage/' . $cv->cv_file_path) }}" target="_blank" class="text-accent-600 dark:text-accent-400 hover:text-accent-900 dark:hover:text-accent-300 font-medium">
                                            View CV
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

<!-- Assignment Modal -->
<div id="assignModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-xl bg-white dark:bg-gray-800">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Assign CV to Companies</h3>
            <button onclick="closeAssignModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Student: <span id="modalStudentName" class="font-semibold text-gray-900 dark:text-gray-100"></span>
        </p>

        <form id="assignForm" method="POST" action="{{ route('admin.assign-cv') }}">
            @csrf
            <input type="hidden" name="cv_id" id="modalCvId">

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                    Select Companies
                </label>
                <div class="max-h-96 overflow-y-auto space-y-2 border border-gray-300 dark:border-gray-600 rounded-lg p-4">
                    @foreach($companies as $company)
                        <label class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg cursor-pointer transition-colors">
                            <input 
                                type="checkbox" 
                                name="company_ids[]" 
                                value="{{ $company->id }}"
                                class="company-checkbox w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            >
                            <div class="ml-3 flex-1">
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
                    class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-medium"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white rounded-lg hover:from-primary-700 hover:to-secondary-700 transition-colors font-medium shadow-lg"
                >
                    Assign Selected
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAssignModal(cvId, studentName, assignedCompanyIds) {
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
}

function closeAssignModal() {
    document.getElementById('assignModal').classList.add('hidden');
}

// Close modal on outside click
document.getElementById('assignModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeAssignModal();
    }
});
</script>
@endsection
