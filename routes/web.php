<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Company\CompanyDashboardController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\CompanyAccessController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/company-interest', [HomeController::class, 'submitCompanyInterest'])->name('company-interest.submit');

// Public Company Access (No Login Required) - Using secure token
Route::prefix('company-access')->name('company.')->group(function () {
    Route::get('/{token}', [CompanyAccessController::class, 'viewAssignedCVs'])->name('access');
    Route::get('/{token}/cv/{cv}', [CompanyAccessController::class, 'downloadCV'])->name('download-cv');
    Route::get('/{token}/download-all', [CompanyAccessController::class, 'downloadAllCVs'])->name('download-all-cvs');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/responses', [AdminDashboardController::class, 'companyResponses'])->name('responses');
    Route::delete('/responses/{id}', [AdminDashboardController::class, 'destroyResponse'])->name('responses.destroy');
    Route::get('/companies', [AdminDashboardController::class, 'companies'])->name('companies');
    Route::get('/cvs', [AdminDashboardController::class, 'cvs'])->name('cvs');
    Route::post('/assign-cv', [AdminDashboardController::class, 'assignCV'])->name('assign-cv');
    Route::post('/student/add', [AdminDashboardController::class, 'addStudent'])->name('student.add');
    
    // Admin CV Upload
    Route::get('/upload-cv', [AdminDashboardController::class, 'showUploadCVForm'])->name('upload-cv');
    Route::post('/upload-cv', [AdminDashboardController::class, 'uploadCV'])->name('upload-cv.post');
    Route::delete('/cvs/{id}', [AdminDashboardController::class, 'deleteCV'])->name('cvs.delete');
    
    // Company Token Management
    Route::post('/company/{company}/regenerate-token', [AdminDashboardController::class, 'regenerateCompanyToken'])->name('company.regenerate-token');
    Route::get('/company/{company}/access-link', [AdminDashboardController::class, 'getCompanyAccessLink'])->name('company.get-link');
    
    // Company Management
    Route::delete('/companies/{id}', [AdminDashboardController::class, 'deleteCompany'])->name('companies.delete');
    
    // Password Management
    Route::get('/change-password', [AdminDashboardController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [AdminDashboardController::class, 'changePassword'])->name('change-password.post');
});

// Company Routes (For companies that still want to login - optional)
Route::middleware(['auth', 'role:company_user'])->prefix('company')->name('company.')->group(function () {
    Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');
    Route::get('/cvs', [CompanyDashboardController::class, 'viewCVs'])->name('cvs');
    Route::post('/cv/{cv}/view', [CompanyDashboardController::class, 'markAsViewed'])->name('cv.viewed');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/upload-cv', [StudentDashboardController::class, 'showUploadForm'])->name('upload-cv');
    Route::post('/upload-cv', [StudentDashboardController::class, 'uploadCV'])->name('upload-cv.post');
    Route::get('/my-cvs', [StudentDashboardController::class, 'myCVs'])->name('my-cvs');
});
