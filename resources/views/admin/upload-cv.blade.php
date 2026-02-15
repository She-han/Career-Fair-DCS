@extends('layouts.admin')

@section('title', 'Upload CV')

@section('content')
<div class="min-h-screen py-8">
    <div class="px-6">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">
                    Upload Student CV
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Upload a CV for a student
                </p>
            </div>

            <!-- Form -->
            <div class="p-8 bg-white border border-gray-200 shadow-lg dark:bg-gray-800 dark:border-gray-700 rounded-xl">
                <form action="{{ route('admin.upload-cv.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                            List technical skills separated by commas
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

                    <!-- Student Info (Editable) -->
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Student Information</h3>
                        
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Name with Initials *
                                </label>
                                <input type="text" name="name_with_initials" required
                                    value="{{ old('name_with_initials') }}"
                                    class="w-full px-4 py-3 text-gray-900 bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name_with_initials') border-red-500 @enderror"
                                    placeholder="e.g., A.B.C. Perera">
                                @error('name_with_initials')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    SC Number *
                                </label>
                                <input type="text" name="sc_number" required
                                    value="{{ old('sc_number') }}"
                                    class="w-full px-4 py-3 text-gray-900 bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sc_number') border-red-500 @enderror"
                                    placeholder="e.g., SC/2022/12345">
                                @error('sc_number')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Email *
                                </label>
                                <input type="email" name="uni_email" required
                                    value="{{ old('uni_email') }}"
                                    class="w-full px-4 py-3 text-gray-900 bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('uni_email') border-red-500 @enderror"
                                    placeholder="e.g., student@dcs.ruh.ac.lk">
                                @error('uni_email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Phone *
                                </label>
                                <input type="text" name="phone" required
                                    value="{{ old('phone') }}"
                                    class="w-full px-4 py-3 text-gray-900 bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                                    placeholder="e.g., 0771234567">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    GPA
                                </label>
                                <input type="number" name="gpa" step="0.01" min="0" max="4.0"
                                    value="{{ old('gpa') }}"
                                    class="w-full px-4 py-3 text-gray-900 bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gpa') border-red-500 @enderror"
                                    placeholder="e.g., 3.50">
                                @error('gpa')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" class="flex-1 px-6 py-3 font-semibold text-white transition-all bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 hover:shadow-2xl hover:scale-105">
                            Upload CV
                        </button>
                        <a href="{{ route('admin.cvs') }}" class="px-6 py-3 font-semibold text-gray-700 transition-all bg-gray-200 border-2 border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 hover:bg-gray-300 dark:hover:bg-gray-600">
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
            infoDiv.className = 'p-2 mt-2 text-sm text-green-700 border border-green-400 rounded bg-green-100 dark:bg-green-900/30 dark:text-green-400';
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
