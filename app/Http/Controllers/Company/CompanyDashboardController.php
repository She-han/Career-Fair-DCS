<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CV;
use Illuminate\Http\Request;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        
        if (!$company) {
            return redirect()->route('home')->with('error', 'Company profile not found.');
        }

        // Optimize: Eager load only needed student fields
        $assignedCVs = $company->cvs()
            ->with(['student' => function($query) {
                $query->select('id', 'user_id', 'name_with_initials', 'sc_number', 'gpa', 'uni_email');
            }, 'student.user:id,name,email'])
            ->select('cvs.id', 'cvs.student_id', 'cvs.applying_job_position', 'cvs.tech_skills', 'cvs.status', 'cvs.created_at')
            ->latest()
            ->get();

        return view('company.dashboard', compact('assignedCVs'));
    }

    public function viewCVs()
    {
        $company = auth()->user()->company;
        $assignedCVs = $company->cvs()->with('student')->get();

        return view('company.cvs', compact('assignedCVs'));
    }

    public function markAsViewed(CV $cv)
    {
        $company = auth()->user()->company;

        // Check if this CV is assigned to this company
        if (!$company->cvs()->where('cv_id', $cv->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Update viewed status
        $company->cvs()->updateExistingPivot($cv->id, [
            'viewed_status' => 'viewed'
        ]);

        return response()->json(['success' => true]);
    }
}
