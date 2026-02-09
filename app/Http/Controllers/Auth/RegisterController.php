<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Base validation
        $baseRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|in:student,company_user',
        ];

        // Role-specific validation
        if ($request->role === 'student') {
            // Validate university email
            $baseRules['email'] = [
                'required',
                'email',
                'unique:users,email',
                'regex:/@(.*\.edu|university|uni|ac\.lk)/i' // Accept .edu or university domains
            ];
            $baseRules['sc_number'] = 'required|string|unique:students,sc_number';
            $baseRules['gpa'] = 'nullable|numeric|min:0|max:4.0';
            $baseRules['phone'] = 'nullable|string|max:20';
        } elseif ($request->role === 'company_user') {
            $baseRules['company_name'] = 'required|string|max:255';
            $baseRules['contact_person'] = 'required|string|max:255';
            $baseRules['company_phone'] = 'required|string|max:20';
            $baseRules['website'] = 'nullable|url|max:255';
            $baseRules['description'] = 'nullable|string|max:1000';
        }

        $validated = $request->validate($baseRules, [
            'email.regex' => 'Students must register with a university email address.',
        ]);

        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'is_active' => true,
            ]);

            // Create role-specific profile
            if ($validated['role'] === 'student') {
                Student::create([
                    'user_id' => $user->id,
                    'sc_number' => $validated['sc_number'],
                    'name_with_initials' => $validated['name'],
                    'uni_email' => $validated['email'],
                    'gpa' => $validated['gpa'] ?? null,
                    'phone' => $validated['phone'] ?? null,
                ]);
            } elseif ($validated['role'] === 'company_user') {
                Company::create([
                    'user_id' => $user->id,
                    'company_name' => $validated['company_name'],
                    'contact_person' => $validated['contact_person'],
                    'email' => $validated['email'],
                    'phone' => $validated['company_phone'],
                    'website' => $validated['website'] ?? null,
                    'description' => $validated['description'] ?? null,
                ]);
            }

            DB::commit();

            // Log the user in
            Auth::login($user);

            return redirect()->route($user->getDashboardRoute())
                ->with('success', 'Registration successful! Welcome to Career Fair DCS.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Registration failed. Please try again.',
            ])->withInput();
        }
    }
}
