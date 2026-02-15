<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\TemporaryPasswordMail;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send temporary password to admin user's email
     */
    public function sendTemporaryPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists
        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->withInput();
        }

        // Check if user is an admin
        if ($user->role !== 'admin') {
            return back()->withErrors([
                'email' => 'Password reset is only available for admin users. Please contact your administrator.',
            ])->withInput();
        }

        // Check if user account is active
        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'This account has been deactivated. Please contact the system administrator.',
            ])->withInput();
        }

        // Generate temporary password (8 characters: letters + numbers)
        $temporaryPassword = Str::random(4) . rand(1000, 9999);

        // Update user's password
        $user->password = Hash::make($temporaryPassword);
        $user->save();

        // Send email with temporary password
        try {
            Mail::to($user->email)->send(new TemporaryPasswordMail($user, $temporaryPassword));

            return back()->with('success', 
                'Temporary password has been sent to your email address. Please check your inbox (and spam folder) and use it to login. Remember to change your password immediately after logging in.'
            );
        } catch (\Exception $e) {
            // If email fails, revert password change
            return back()->withErrors([
                'email' => 'Failed to send email. Please contact the system administrator. Error: ' . $e->getMessage(),
            ])->withInput();
        }
    }
}
