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
    public function index()
    {
        return view('auth.index');
    }

    /**
     * Handle admin login form submission.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required']
        ]);

        // dd($credentials);
        //$admin = Admin::where('email', $request->email)->first();
        //Log::info('Admin detail '.  $admin);

        // if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        //     // ✅ Store only what you need
        //     Log::info('Login successful');
        //     $admin = Admin::where('email', $request->email)->first();
        //     session([
        //         'admin'   => 'admin',
        //         'admin_id'   => $admin->id,
        //         'admin_name' => $admin->name,
        //         'admin_role' => $admin->role, // 'approver' or 'viewer'
        //     ]);

        //     return redirect()->route('admin.dashboard');
        // }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return dd("Login");
        }

        return back()->with('error', 'Invalid login credentials.');
    }

    /**
     * Log the admin out and clear session.
     */
    public function destroy()
    {
        session()->forget(['admin_id', 'admin_name', 'admin_role']);
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
