<?php

namespace App\Http\Controllers;

use App\Models\CompanyParticipationResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function submitCompanyInterest(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255|min:2',
            'contact_person' => 'required|string|max:255|min:2',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'required|string|max:20|min:10|regex:/^[0-9+\-\s()]+$/',
            'message' => 'nullable|string|max:1000',
        ], [
            'company_name.required' => 'Company name is required',
            'company_name.min' => 'Company name must be at least 2 characters',
            'contact_person.required' => 'Contact person name is required',
            'contact_person.min' => 'Contact person name must be at least 2 characters',
            'email.required' => 'Email address is required',
            'email.email' => 'Please provide a valid email address',
            'phone.required' => 'Phone number is required',
            'phone.min' => 'Phone number must be at least 10 characters',
            'phone.regex' => 'Please provide a valid phone number',
        ]);

        try {
            CompanyParticipationResponse::create([
                'company_name' => $validated['company_name'],
                'contact_person' => $validated['contact_person'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'message' => $validated['message'] ?? null,
                'interested_to_participate' => true,
                'contacted' => false,
            ]);

            return redirect()->route('home')->with('success', 'Thank you for your interest! We will contact you soon.');

        } catch (\Exception $e) {
            \Log::error('Company interest form submission failed: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Failed to submit your interest. Please try again.',
            ])->withInput();
        }
    }
}
