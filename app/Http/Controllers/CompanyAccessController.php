<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class CompanyAccessController extends Controller
{
    /**
     * View CVs assigned to a company using secure token
     */
    public function viewAssignedCVs(Request $request, string $token)
    {
        // Rate limiting to prevent brute force attacks
        $key = 'company-access:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 10)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->view('errors.429', ['seconds' => $seconds], 429);
        }

        RateLimiter::hit($key, 60); // 10 attempts per minute

        // Validate token format
        if (strlen($token) !== 64) {
            abort(404);
        }

        // Use caching to reduce database queries
        $company = Cache::remember("company:token:{$token}", 3600, function () use ($token) {
            return Company::where('access_token', $token)
                ->with(['participationResponse'])
                ->first();
        });

        if (!$company) {
            abort(404, 'Invalid access link.');
        }

        // Check if token is expired
        if ($company->isTokenExpired()) {
            return view('company.token-expired', compact('company'));
        }

        // Eager load relationships to optimize performance
        $cvs = $company->cvs()
            ->with(['student' => function($query) {
                $query->select('id', 'user_id', 'name_with_initials', 'sc_number', 'gpa', 'phone', 'uni_email');
            }])
            ->orderBy('cv_company.created_at', 'desc')
            ->get();

        // Log access for audit trail
        \Log::info("Company {$company->company_name} accessed CVs via token", [
            'company_id' => $company->id,
            'ip' => $request->ip(),
            'cv_count' => $cvs->count(),
        ]);

        return view('company.public-access', compact('company', 'cvs'));
    }

    /**
     * Download a specific CV (with authorization check)
     */
    public function downloadCV(Request $request, string $token, int $cvId)
    {
        // Rate limiting
        $key = 'cv-download:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 20)) {
            abort(429, 'Too many download attempts. Please try again later.');
        }

        RateLimiter::hit($key, 60);

        // Validate token and get company
        $company = Company::where('access_token', $token)->firstOrFail();

        if ($company->isTokenExpired()) {
            abort(403, 'Access link has expired.');
        }

        // Check if CV is assigned to this company
        $cv = $company->cvs()->where('cvs.id', $cvId)->firstOrFail();

        // Mark as viewed
        $company->cvs()->updateExistingPivot($cvId, [
            'viewed_status' => true,
        ]);

        // Check if CV file exists (stored in public disk)
        $filePath = storage_path('app/public/' . $cv->cv_file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'CV file not found. Please contact the administrator.');
        }

        // Log download
        \Log::info("CV downloaded by company via token", [
            'company_id' => $company->id,
            'cv_id' => $cvId,
            'ip' => $request->ip(),
        ]);

        // Return file for download
        return response()->download(
            $filePath,
            basename($cv->cv_file_path)
        );
    }

    /**
     * Download all CVs assigned to a company as a ZIP file
     */
    public function downloadAllCVs(Request $request, string $token)
    {
        // Rate limiting
        $key = 'cv-download-all:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            abort(429, 'Too many download attempts. Please try again later.');
        }

        RateLimiter::hit($key, 120); // 5 attempts per 2 minutes

        // Validate token and get company
        $company = Company::where('access_token', $token)->firstOrFail();

        if ($company->isTokenExpired()) {
            abort(403, 'Access link has expired.');
        }

        // Get all CVs assigned to this company
        $cvs = $company->cvs()->with('student')->get();

        if ($cvs->isEmpty()) {
            abort(404, 'No CVs available to download.');
        }

        // Create a unique temporary directory for this download
        $tempDir = storage_path('app/temp/cv-zips/' . uniqid('company_', true));
        
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        // Copy all CV files to temp directory with student names
        foreach ($cvs as $cv) {
            $filePath = storage_path('app/public/' . $cv->cv_file_path);
            
            if (file_exists($filePath)) {
                $extension = pathinfo($cv->cv_file_path, PATHINFO_EXTENSION);
                $studentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $cv->student->name_with_initials);
                $newFileName = $studentName . '_' . $cv->applying_job_position . '.' . $extension;
                copy($filePath, $tempDir . '/' . $newFileName);
            }
        }

        // Create ZIP file
        $zipFileName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $company->company_name) . '_CVs_' . date('Y-m-d') . '.zip';
        $zipFilePath = storage_path('app/temp/' . $zipFileName);

        $zip = new \ZipArchive();
        
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            // Add all files from temp directory to ZIP
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($tempDir),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = basename($filePath);
                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();
        } else {
            // Cleanup and error
            $this->cleanupTempDirectory($tempDir);
            abort(500, 'Failed to create ZIP file.');
        }

        // Log download
        \Log::info("All CVs downloaded by company via token", [
            'company_id' => $company->id,
            'cv_count' => $cvs->count(),
            'ip' => $request->ip(),
        ]);

        // Cleanup temp directory
        $this->cleanupTempDirectory($tempDir);

        // Return ZIP file and delete after sending
        return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
    }

    /**
     * Helper method to cleanup temporary directory
     */
    private function cleanupTempDirectory(string $dir)
    {
        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                $filePath = $dir . '/' . $file;
                is_dir($filePath) ? $this->cleanupTempDirectory($filePath) : unlink($filePath);
            }
            rmdir($dir);
        }
    }
}
