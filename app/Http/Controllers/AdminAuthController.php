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
        return view('adminLogin');
    }

    /**
     * Handle admin login form submission.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        //$admin = Admin::where('email', $request->email)->first();
        //Log::info('Admin detail '.  $admin);

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // ✅ Store only what you need
            Log::info('Login successful');
            $admin = Admin::where('email', $request->email)->first();
            session([
                'admin'   => 'admin',
                'admin_id'   => $admin->id,
                'admin_name' => $admin->name,
                'admin_role' => $admin->role, // 'approver' or 'viewer'
            ]);

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid login credentials.');
    }

    /**
     * Log the admin out and clear session.
     */
    public function logout()
    {
        session()->forget(['admin_id', 'admin_name', 'admin_role']);
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
