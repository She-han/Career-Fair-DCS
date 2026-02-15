<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = auth()->user();

            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account has been deactivated. Please contact admin.',
                ]);
            }

            // Redirect to role-specific dashboard with explicit route
            $dashboardRoute = $user->getDashboardRoute();
            $dashboardUrl = route($dashboardRoute);
            
            // Store success message in session
            session()->flash('success', 'Welcome back, ' . $user->name . '!');
            
            // Return a view with JavaScript redirect to force full page load
            return response()->view('auth.redirect', [
                'url' => $dashboardUrl
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }
}
