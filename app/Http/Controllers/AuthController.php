<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        if (Auth::guard('employee')->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        if (Auth::guard('employee')->check()) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $key = 'login:'.$request->ip();
        $maxAttempts = 5;
        $decaySeconds = 30; 

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            return back()
                ->withErrors(['username' => 'Too many failed login attempts.'])
                ->with('lockout_seconds', $seconds)
                ->withInput($request->only('username'));
        }

        $employee = Employee::where('username', $request->input('username'))->first();

        if ($employee && $employee->active_status && Hash::check($request->input('password'), $employee->password)) {
            RateLimiter::clear($key);

            Auth::guard('employee')->login($employee);
            $employee->update(['last_login' => now()]);

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Welcome back, '.$employee->first_name.'!');
        }

        RateLimiter::hit($key, $decaySeconds);

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('username'));
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Get the guard to be used during authentication.
     */
    protected function guard()
    {
        return Auth::guard('employee');
    }
}