@extends('layouts.admin')

@section('title', 'Manage CVs')

@section('content')
<div class="min-h-screen py-8">
    <div class="px-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">
                Manage CVs
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Assign student CVs to companies
            </p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total CVs</p>
                <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $cvs->count() }}</p>
            </div>
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending</p>
                <p class="mt-2 text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                    {{ $cvs->where('status', 'pending')->count() }}
                </p>
            </div>
            <div class="p-6 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Approved</p>
                <p class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">
                    {{ $cvs->where('status', 'approved')->count() }}
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
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Student</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Position</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">GPA</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Skills</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Assigned To</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Status</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($cvs as $cv)
                                <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $cv->student->name_with_initials }}
                                        </div>
                                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
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
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-200">
                                                {{ $cv->companies->count() }} Companies
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 text-gray-800 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-gray-200">
                                                Unassigned
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($cv->status === 'pending')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-200">
                                                Pending
                                            </span>
                                        @elseif($cv->status === 'approved')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-200">
                                                Approved
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full dark:bg-red-900 dark:text-red-200">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        <button 
                                            onclick="openAssignModal({{ $cv->id }}, '{{ $cv->student->name_with_initials }}', {{ $cv->companies->pluck('id')->toJson() }})"
                                            class="mr-3 font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"
                                        >
                                            Assign
                                        </button>
                                        <a href="{{ asset('storage/' . $cv->cv_file_path) }}" target="_blank" class="font-medium text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300">
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
<div id="assignModal" class="fixed inset-0 z-50 hidden w-full h-full overflow-y-auto bg-gray-600 bg-opacity-50">
    <div class="relative w-full max-w-2xl p-5 mx-auto bg-white border shadow-lg top-20 rounded-xl dark:bg-gray-800">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Assign CV to Companies</h3>
            <button onclick="closeAssignModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <p class="mb-6 text-gray-600 dark:text-gray-400">
            Student: <span id="modalStudentName" class="font-semibold text-gray-900 dark:text-gray-100"></span>
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
                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded company-checkbox text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
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
