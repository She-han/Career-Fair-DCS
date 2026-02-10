@extends('layouts.app')

@section('title', 'Upload CV')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-100 via-secondary-100 to-accent-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-fadeIn">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-primary-600 via-accent-600 to-secondary-600 bg-clip-text text-transparent mb-2">
                    📄 Upload Your CV
                </h1>
                <p class="text-gray-700 dark:text-gray-400 font-medium">
                    Share your profile with potential employers
                </p>
            </div>

            <!-- Form -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 animate-fadeIn" style="animation-delay: 0.2s;">
                <form action="{{ route('student.upload-cv.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label for="applying_job_position" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Applying for Job Position *
                        </label>
                        <input type="text" id="applying_job_position" name="applying_job_position" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('applying_job_position') border-red-500 @enderror"
                            placeholder="e.g., Software Engineer, Data Analyst"
                            value="{{ old('applying_job_position') }}">
                        @error('applying_job_position')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tech_skills" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Technical Skills *
                        </label>
                        <textarea id="tech_skills" name="tech_skills" rows="4" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('tech_skills') border-red-500 @enderror"
                            placeholder="e.g., Python, JavaScript, React, Node.js, MySQL, Git">{{ old('tech_skills') }}</textarea>
                        @error('tech_skills')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            List your technical skills separated by commas
                        </p>
                    </div>

                    <div>
                        <label for="cv_file" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            CV File (PDF only) *
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-primary-500 dark:hover:border-primary-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label for="cv_file" class="relative cursor-pointer rounded-md font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500 focus-within:outline-none">
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
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Your Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Name
                                </label>
                                <input type="text" value="{{ auth()->user()->student->name_with_initials }}" disabled
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    SC Number
                                </label>
                                <input type="text" value="{{ auth()->user()->student->sc_number }}" disabled
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email
                                </label>
                                <input type="text" value="{{ auth()->user()->student->uni_email }}" disabled
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    GPA
                                </label>
                                <input type="text" value="{{ auth()->user()->student->gpa ? number_format(auth()->user()->student->gpa, 2) : 'N/A' }}" disabled
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-primary-600 via-accent-500 to-secondary-600 text-white rounded-lg font-semibold shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-200 hover:from-primary-700 hover:via-accent-600 hover:to-secondary-700">
                            ⬆️ Upload CV
                        </button>
                        <a href="{{ route('student.dashboard') }}" class="px-6 py-3 bg-gradient-to-r from-gray-200 to-gray-300 dark:bg-gradient-to-r dark:from-gray-700 dark:to-gray-600 text-gray-800 dark:text-gray-200 rounded-lg font-semibold hover:from-gray-300 hover:to-gray-400 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all border-2 border-gray-400 dark:border-gray-500">
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
            uploadArea.classList.add('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/20');
        });
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.remove('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/20');
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
