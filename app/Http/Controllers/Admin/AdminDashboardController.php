<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\Company;
use App\Models\CV;
use App\Models\CompanyParticipationResponse;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalCompanies = Company::count();
        $totalCVs = CV::count();
        $pendingResponses = CompanyParticipationResponse::where('status', 'pending')->count();
        
        // Latest 3 Company Responses
        $latestResponses = CompanyParticipationResponse::latest()
            ->limit(3)
            ->get();
        
        // Latest 3 CV Submissions
        $recentCVs = CV::with(['student' => function($query) {
            $query->select('id', 'user_id', 'name_with_initials', 'sc_number', 'gpa');
        }])
        ->select('id', 'student_id', 'applying_job_position', 'status', 'created_at')
        ->latest()
        ->limit(3)
        ->get();

        return view('admin.dashboard', compact(
            'totalCompanies',
            'totalCVs',
            'pendingResponses',
            'latestResponses',
            'recentCVs'
        ));
    }

    public function companyResponses(Request $request)
    {
        // Get all responses for client-side filtering
        $responses = CompanyParticipationResponse::latest()->get();

        // Get all unique vacant positions for filter checkboxes
        $vacantPositions = CompanyParticipationResponse::whereNotNull('vacant_positions')
            ->get()
            ->pluck('vacant_positions')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return view('admin.responses', compact('responses', 'vacantPositions'));
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
            'company_ids' => 'array',
            'company_ids.*' => 'exists:companies,id'
        ]);

        $cv = CV::findOrFail($request->cv_id);
        
        // Use sync() to properly handle both assign and unassign
        // This will remove companies that are not in the array
        $companyIds = $request->company_ids ?? [];
        $syncData = [];
        
        foreach ($companyIds as $companyId) {
            $syncData[$companyId] = ['assigned_at' => now()];
        }
        
        $cv->companies()->sync($syncData);

        // Clear company cache for affected companies
        $allAffectedCompanies = Company::whereIn('id', 
            array_merge($companyIds, $cv->companies()->pluck('companies.id')->toArray())
        )->get();
        
        foreach ($allAffectedCompanies as $company) {
            \Cache::forget("company:token:{$company->access_token}");
        }

        $count = count($companyIds);
        if ($count > 0) {
            return back()->with('success', "CV assigned to {$count} company/companies successfully!");
        } else {
            return back()->with('success', 'CV unassigned from all companies successfully!');
        }
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

    public function showUploadCVForm()
    {
        return view('admin.upload-cv');
    }

    public function uploadCV(Request $request)
    {
        $validated = $request->validate([
            'name_with_initials' => 'required|string|max:255',
            'sc_number' => 'required|string|max:50',
            'uni_email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'gpa' => 'nullable|numeric|min:0|max:4.0',
            'applying_job_position' => 'required|string|max:255',
            'tech_skills' => 'required|string|max:1000',
            'cv_file' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        // Store CV file
        $cvPath = $request->file('cv_file')->store('cvs', 'public');

        try {
            // Find or create student
            $student = Student::where('sc_number', $validated['sc_number'])->first();
            
            if (!$student) {
                // Create user account for student
                $user = \App\Models\User::create([
                    'name' => $validated['name_with_initials'],
                    'email' => $validated['uni_email'],
                    'password' => \Hash::make('password123'), // Default password
                    'role' => 'student',
                    'is_active' => true,
                ]);

                // Create student profile
                $student = Student::create([
                    'user_id' => $user->id,
                    'sc_number' => $validated['sc_number'],
                    'name_with_initials' => $validated['name_with_initials'],
                    'uni_email' => $validated['uni_email'],
                    'gpa' => $validated['gpa'],
                    'phone' => $validated['phone'],
                ]);
            }

            // Create CV
            CV::create([
                'student_id' => $student->id,
                'applying_job_position' => $validated['applying_job_position'],
                'tech_skills' => $validated['tech_skills'],
                'cv_file_path' => $cvPath,
                'status' => 'approved', // Admin uploaded CVs are approved by default
            ]);

            return redirect()->route('admin.cvs')
                ->with('success', 'CV uploaded successfully!');

        } catch (\Exception $e) {
            // Delete uploaded file if database insert fails
            \Storage::disk('public')->delete($cvPath);
            
            return back()->withErrors([
                'error' => 'Failed to upload CV. Please try again.',
            ])->withInput();
        }
    }

    public function deleteCV($id)
    {
        try {
            $cv = CV::findOrFail($id);
            
            // Delete the CV file from storage
            if ($cv->cv_file_path) {
                \Storage::disk('public')->delete($cv->cv_file_path);
            }
            
            // Delete CV record
            $cv->delete();
            
            return back()->with('success', 'CV deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete CV.');
        }
    }

    public function deleteCompany($id)
    {
        try {
            $company = Company::findOrFail($id);
            $companyName = $company->company_name;
            
            // Detach all CV assignments
            $company->cvs()->detach();
            
            // Delete participation response if exists
            if ($company->participationResponse) {
                $company->participationResponse->delete();
            }
            
            // Delete company record
            $company->delete();
            
            return back()->with('success', "Company '{$companyName}' deleted successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete company.');
        }
    }

    public function destroyResponse($id)
    {
        $response = CompanyParticipationResponse::findOrFail($id);
        $companyName = $response->company_name;
        
        $response->delete();

        return redirect()->route('admin.responses')->with('success', "Response from {$companyName} has been deleted successfully.");
    }

    public function showChangePasswordForm()
    {
        return view('admin.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.change-password')->with('success', 'Password changed successfully!');
    }
}
