<?php

namespace App\Http\Controllers;

use App\Models\CompanyParticipationResponse;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'will_participate' => 'required|boolean',
            'expected_cvs' => 'nullable|integer|min:1|max:500',
            'intern_positions' => 'nullable|integer|min:0|max:100',
            'vacant_positions' => 'required_if:will_participate,1|nullable|array|min:1',
            'vacant_positions.*' => 'string',
            'preferred_languages' => 'required_if:will_participate,1|nullable|array|min:1',
            'preferred_languages.*' => 'string',
            'preferred_frameworks' => 'required_if:will_participate,1|nullable|array|min:1',
            'preferred_frameworks.*' => 'string',
            'preferred_timeslot' => 'required_if:will_participate,1|nullable|string',
            'consent_to_receive_cvs' => 'required_if:will_participate,1|accepted',
            'message' => 'nullable|string|max:1000',
        ], [
            'company_name.required' => 'Company name is required',
            'company_name.min' => 'Company name must be at least 2 characters',
            'will_participate.required' => 'Please indicate if you will participate',
            'vacant_positions.required_if' => 'Please select at least one vacant position',
            'preferred_languages.required_if' => 'Please select at least one preferred language',
            'preferred_frameworks.required_if' => 'Please select at least one preferred framework',
            'preferred_timeslot.required_if' => 'Please select a preferred timeslot',
            'consent_to_receive_cvs.required_if' => 'Consent is required to participate',
            'consent_to_receive_cvs.accepted' => 'You must consent to receive CVs',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Create the participation response
                $response = CompanyParticipationResponse::create([
                    'company_name' => $validated['company_name'],
                    'contact_person' => null,
                    'email' => null,
                    'phone' => null,
                    'message' => $validated['message'] ?? null,
                    'will_participate' => $validated['will_participate'],
                    'expected_cvs' => $validated['expected_cvs'] ?? null,
                    'intern_positions' => $validated['intern_positions'] ?? null,
                    'vacant_positions' => $validated['vacant_positions'] ?? null,
                    'preferred_languages' => $validated['preferred_languages'] ?? null,
                    'preferred_frameworks' => $validated['preferred_frameworks'] ?? null,
                    'preferred_timeslot' => $validated['preferred_timeslot'] ?? null,
                    'consent_to_receive_cvs' => $validated['consent_to_receive_cvs'] ?? false,
                    'interested' => true,
                    'status' => 'pending',
                ]);

                // Auto-create Company if they consented to receive CVs
                if ($validated['will_participate'] && ($validated['consent_to_receive_cvs'] ?? false)) {
                    $company = Company::create([
                        'user_id' => null, // No user login required
                        'company_name' => $validated['company_name'],
                        'contact_person' => null,
                        'email' => null,
                        'phone' => null,
                        'industry' => !empty($validated['vacant_positions']) 
                            ? implode(', ', array_slice($validated['vacant_positions'], 0, 2))
                            : 'Technology',
                        'description' => $validated['message'] ?? null,
                        'participation_response_id' => $response->id,
                    ]);

                    Log::info("Company auto-registered: {$company->company_name} with token: {$company->access_token}");
                }
            });

            return redirect()->route('home')->with('success', 'Thank you for your interest! We will contact you soon with your unique access link.');

        } catch (\Exception $e) {
            Log::error('Company interest form submission failed: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Failed to submit your interest. Please try again.',
            ])->withInput();
        }
    }
}
