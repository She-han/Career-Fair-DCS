@extends('layouts.student')

@section('title', 'Upload CV')

@section('content')
<div class="min-h-screen py-12 bg-gray-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container px-4 mx-auto sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="mb-2 text-4xl font-bold text-gray-900 dark:text-white">
                    📄 Upload Your CV
                </h1>
                <p class="font-medium text-gray-600 dark:text-gray-400">
                    Share your profile with potential employers
                </p>
            </div>

            <!-- Form -->
            <div class="p-8 bg-white border border-gray-200 shadow-lg dark:bg-gray-800 dark:border-gray-700 rounded-xl">
                <form action="{{ route('student.upload-cv.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label for="applying_job_position" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Applying for Job Position *
                        </label>
                        <input type="text" id="applying_job_position" name="applying_job_position" required
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('applying_job_position') border-red-500 @enderror"
                            placeholder="e.g., Software Engineer, Data Analyst"
                            value="{{ old('applying_job_position') }}">
                        @error('applying_job_position')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tech_skills" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Technical Skills *
                        </label>
                        <textarea id="tech_skills" name="tech_skills" rows="4" required
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('tech_skills') border-red-500 @enderror"
                            placeholder="e.g., Python, JavaScript, React, Node.js, MySQL, Git">{{ old('tech_skills') }}</textarea>
                        @error('tech_skills')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            List your technical skills separated by commas
                        </p>
                    </div>

                    <div>
                        <label for="cv_file" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            CV File (PDF only) *
                        </label>
                        <div class="flex justify-center px-6 pt-5 pb-6 mt-1 transition-colors border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 hover:border-blue-500 dark:hover:border-blue-400">
                            <div class="space-y-1 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label for="cv_file" class="relative font-medium text-blue-600 rounded-md cursor-pointer dark:text-blue-400 hover:text-blue-700 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="cv_file" name="cv_file" type="file" class="sr-only" accept=".pdf" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PDF up to 10MB
                                </p>
                            </div>
                        </div>
                        @error('cv_file')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Student Info (Read-only) -->
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Your Information</h3>
                        
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Name
                                </label>
                                <input type="text" value="{{ auth()->user()->student->name_with_initials }}" disabled
                                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg dark:border-gray-600 bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    SC Number
                                </label>
                                <input type="text" value="{{ auth()->user()->student->sc_number }}" disabled
                                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg dark:border-gray-600 bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Email
                                </label>
                                <input type="text" value="{{ auth()->user()->student->uni_email }}" disabled
                                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg dark:border-gray-600 bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    GPA
                                </label>
                                <input type="text" value="{{ auth()->user()->student->gpa ? number_format(auth()->user()->student->gpa, 2) : 'N/A' }}" disabled
                                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg dark:border-gray-600 bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" class="flex-1 px-6 py-3 font-semibold text-white transition-all bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 hover:shadow-2xl hover:scale-105">
                            Upload CV
                        </button>
                        <a href="{{ route('student.dashboard') }}" class="px-6 py-3 font-semibold text-gray-700 transition-all bg-gray-200 border-2 border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 hover:bg-gray-300 dark:hover:bg-gray-600">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('cv_file');
    const uploadArea = fileInput.closest('.border-dashed');
    
    // File input change handler
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const fileName = file.name;
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            
            // Validate file type
            if (file.type !== 'application/pdf') {
                alert('Please upload a PDF file only.');
                fileInput.value = '';
                return;
            }
            
            // Validate file size (10MB max)
            if (file.size > 10 * 1024 * 1024) {
                alert('File size must be less than 10MB.');
                fileInput.value = '';
                return;
            }
            
            // Show file info
            const infoDiv = document.createElement('div');
            infoDiv.className = 'mt-2 p-2 bg-green-100 dark:bg-green-900/30 border border-green-400 text-green-700 dark:text-green-400 rounded text-sm';
            infoDiv.textContent = `📄 ${fileName} (${fileSize} MB)`;
            
            // Remove any existing info
            const existingInfo = uploadArea.querySelector('.mt-2');
            if (existingInfo) existingInfo.remove();
            
            uploadArea.appendChild(infoDiv);
        }
    });
    
    // Drag and drop handlers
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
        });
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
        });
    });
    
    uploadArea.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            // Trigger change event
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }
    });
});
</script>
@endsection
