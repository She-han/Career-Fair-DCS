<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Company;
use App\Models\CV;
use App\Models\CompanyParticipationResponse;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalCompanies = Company::count();
        $totalCVs = CV::count();
        $pendingResponses = CompanyParticipationResponse::where('status', 'pending')->count();
        
        // Optimize: Only load necessary fields and limit results
        $recentCVs = CV::with(['student' => function($query) {
            $query->select('id', 'user_id', 'name_with_initials', 'sc_number');
        }])
        ->select('id', 'student_id', 'applying_job_position', 'status', 'created_at')
        ->latest()
        ->limit(10)
        ->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalCompanies',
            'totalCVs',
            'pendingResponses',
            'recentCVs'
        ));
    }

    public function companyResponses()
    {
        $responses = CompanyParticipationResponse::latest()->paginate(20);
        return view('admin.responses', compact('responses'));
    }

    public function companies()
    {
        // Eager load relationships, handle nullable user_id
        $companies = Company::with(['participationResponse'])
            ->withCount('cvs')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Ensure all companies have access tokens
        foreach ($companies as $company) {
            if (empty($company->access_token)) {
                $company->access_token = Company::generateUniqueToken();
                $company->save();
            }
        }
        
        return view('admin.companies', compact('companies'));
    }

    public function cvs()
    {
        $cvs = CV::with('student', 'companies')->orderBy('created_at', 'desc')->get();
        $companies = Company::orderBy('company_name')->get();
        return view('admin.cvs', compact('cvs', 'companies'));
    }

    public function assignCV(Request $request)
    {
        $request->validate([
            'cv_id' => 'required|exists:cvs,id',
            'company_ids' => 'required|array',
            'company_ids.*' => 'exists:companies,id'
        ]);

        $cv = CV::findOrFail($request->cv_id);
        
        // Attach with timestamp
        foreach ($request->company_ids as $companyId) {
            $cv->companies()->syncWithoutDetaching([
                $companyId => ['assigned_at' => now()]
            ]);
        }

        // Clear company cache
        $companies = Company::whereIn('id', $request->company_ids)->get();
        foreach ($companies as $company) {
            \Cache::forget("company:token:{$company->access_token}");
        }

        return back()->with('success', 'CV assigned to ' . count($request->company_ids) . ' company/companies successfully!');
    }

    /**
     * Generate/regenerate access token for a company
     */
    public function regenerateCompanyToken(Request $request, int $companyId)
    {
        $company = Company::findOrFail($companyId);
        
        // Clear old token from cache
        \Cache::forget("company:token:{$company->access_token}");
        
        // Generate new token
        $company->access_token = Company::generateUniqueToken();
        $company->save();

        \Log::info("Token regenerated for company: {$company->company_name}");

        return back()->with('success', "New access link generated for {$company->company_name}");
    }

    /**
     * Get company access link (for copying)
     */
    public function getCompanyAccessLink(int $companyId)
    {
        $company = Company::findOrFail($companyId);
        
        return response()->json([
            'success' => true,
            'link' => $company->access_url,
            'token' => $company->access_token,
            'company_name' => $company->company_name,
        ]);
    }

    public function addStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'sc_number' => 'required|string|unique:students,sc_number',
            'name_with_initials' => 'required|string',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'phone' => 'required|string'
        ]);

        \DB::transaction(function () use ($request) {
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
                'role' => 'student',
                'is_active' => true,
            ]);

            Student::create([
                'user_id' => $user->id,
                'sc_number' => $request->sc_number,
                'name_with_initials' => $request->name_with_initials,
                'uni_email' => $request->email,
                'gpa' => $request->gpa,
                'phone' => $request->phone,
            ]);
        });

        return back()->with('success', 'Student added successfully!');
    }
}
