<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            return redirect()->route('home')->with('error', 'Student profile not found.');
        }

        // Optimize: Eager load companies to avoid N+1
        $cvs = $student->cvs()
            ->with(['companies' => function($query) {
                $query->select('companies.id', 'companies.company_name');
            }])
            ->latest()
            ->get();

        return view('student.dashboard', compact('cvs'));
    }

    public function showUploadForm()
    {
        return view('student.upload-cv');
    }

    public function uploadCV(Request $request)
    {
        $validated = $request->validate([
            'applying_job_position' => 'required|string|max:255',
            'tech_skills' => 'required|string|max:1000',
            'cv_file' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        $student = auth()->user()->student;

        // Store CV file
        $cvPath = $request->file('cv_file')->store('cvs', 'public');

        try {
            CV::create([
                'student_id' => $student->id,
                'applying_job_position' => $validated['applying_job_position'],
                'tech_skills' => $validated['tech_skills'],
                'cv_file_path' => $cvPath,
                'status' => 'pending',
            ]);

            return redirect()->route('student.dashboard')
                ->with('success', 'CV uploaded successfully! Admin will review and assign it to companies.');

        } catch (\Exception $e) {
            // Delete uploaded file if database insert fails
            Storage::disk('public')->delete($cvPath);
            
            return back()->withErrors([
                'error' => 'Failed to upload CV. Please try again.',
            ])->withInput();
        }
    }

    public function myCVs()
    {
        $student = auth()->user()->student;
        $cvs = $student->cvs()->with('companies')->latest()->get();

        return view('student.my-cvs', compact('cvs'));
    }
}
