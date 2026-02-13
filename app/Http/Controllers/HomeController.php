<?php

namespace App\Http\Controllers;

use App\Models\CompanyParticipationResponse;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home');
    }

    public function submitCompanyInterest(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255|min:2',
            'will_participate' => 'required|boolean',
            'expected_cvs' => 'nullable|integer|min:1|max:500',
            'intern_positions' => 'nullable|integer|min:0|max:100',
            'vacant_positions' => 'nullable|array',
            'vacant_positions.*' => 'string',
            'preferred_languages' => 'nullable|array',
            'preferred_languages.*' => 'string',
            'preferred_frameworks' => 'nullable|array',
            'preferred_frameworks.*' => 'string',
            'preferred_timeslot' => 'nullable|string',
            'consent_to_receive_cvs' => 'nullable|boolean',
            'message' => 'nullable|string|max:1000',
            'other_positions' => 'nullable|string|max:500',
            'other_languages' => 'nullable|string|max:500',
            'other_frameworks' => 'nullable|string|max:500',
        ], [
            'company_name.required' => 'Company name is required',
            'company_name.min' => 'Company name must be at least 2 characters',
            'will_participate.required' => 'Please indicate if you will participate',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Process "other" fields by merging them into the main arrays
                $vacantPositions = $validated['vacant_positions'] ?? [];
                if (!empty($validated['other_positions'])) {
                    $otherPositions = array_map('trim', explode(',', $validated['other_positions']));
                    $vacantPositions = array_merge($vacantPositions, $otherPositions);
                }

                $preferredLanguages = $validated['preferred_languages'] ?? [];
                if (!empty($validated['other_languages'])) {
                    $otherLanguages = array_map('trim', explode(',', $validated['other_languages']));
                    $preferredLanguages = array_merge($preferredLanguages, $otherLanguages);
                }

                $preferredFrameworks = $validated['preferred_frameworks'] ?? [];
                if (!empty($validated['other_frameworks'])) {
                    $otherFrameworks = array_map('trim', explode(',', $validated['other_frameworks']));
                    $preferredFrameworks = array_merge($preferredFrameworks, $otherFrameworks);
                }

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
                    'vacant_positions' => !empty($vacantPositions) ? $vacantPositions : null,
                    'preferred_languages' => !empty($preferredLanguages) ? $preferredLanguages : null,
                    'preferred_frameworks' => !empty($preferredFrameworks) ? $preferredFrameworks : null,
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
                        'industry' => !empty($vacantPositions) 
                            ? implode(', ', array_slice($vacantPositions, 0, 2))
                            : 'Technology',
                        'description' => $validated['message'] ?? null,
                        'participation_response_id' => $response->id,
                    ]);

                    Log::info("Company auto-registered: {$company->company_name} with token: {$company->access_token}");
                }
            });

            return redirect()->back()->with('success', 'Thank you for your interest! We will contact you soon with your unique access link.');

        } catch (\Exception $e) {
            Log::error('Company interest form submission failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to submit your interest. Please try again.')->withInput();
        }
    }
}
