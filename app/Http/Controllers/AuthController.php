<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // Redirect to dashboard if already authenticated
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
        // Redirect to dashboard if already authenticated (in case someone tries to POST to login while logged in)
        if (Auth::guard('employee')->check()) {
            return redirect()->route('dashboard');
        }

        // Validate the request
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to find the employee by username
        $employee = Employee::where('username', $credentials['username'])->first();

        // Check if employee exists, is active, and password matches
        if ($employee && $employee->active_status && Hash::check($credentials['password'], $employee->password)) {
            // Log in the employee
            Auth::guard('employee')->login($employee);

            // Update last login
            $employee->update([
                'last_login' => now()
            ]);

            // Redirect to intended page or dashboard
            return redirect()->intended(route('dashboard'))->with('success', 'Welcome back, ' . $employee->first_name . '!');
        }

        // If authentication fails
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

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Get the guard to be used during authentication.
     */
    protected function guard()
    {
        return Auth::guard('employee');
    }
}