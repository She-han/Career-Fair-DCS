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

        // Log download
        \Log::info("CV downloaded by company via token", [
            'company_id' => $company->id,
            'cv_id' => $cvId,
            'ip' => $request->ip(),
        ]);

        // Return file for download
        return response()->download(
            storage_path('app/' . $cv->file_path),
            basename($cv->file_path)
        );
    }
}
