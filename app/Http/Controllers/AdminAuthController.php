<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.adminLogin');
    }

    /**
     * Handle admin login form submission.
     */
    public function login(Request $request)
    {
        // Validate form input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Use input() instead of dynamic properties to avoid linter warnings
        $email = $request->input('email');
        $password = $request->input('password');

        // Attempt login
        if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password])) {
            Log::info('Login successful');

            // Fetch the authenticated admin user
            $admin = Admin::where('email', $email)->first();

            // Set session data
            session([
                'admin'       => 'admin',
                'admin_id'    => $admin->id,
                'admin_name'  => $admin->name,
                'admin_role'  => $admin->role, // e.g., 'approver' or 'disburser'
            ]);

            return redirect()->route('admin.dashboard');
        }

        // If login fails
        return back()->with('error', 'Invalid login credentials.');
    }

    /**
     * Log the admin out and clear session.
     */
    public function logout()
    {
        // Clear admin session
        session()->forget(['admin', 'admin_id', 'admin_name', 'admin_role']);

        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
