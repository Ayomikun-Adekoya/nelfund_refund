<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefundApplication;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // dd("here");

        // ✅ Check for admin session
        if (!session()->has('admin')) {
            return redirect()->route('admin.login')->with('error', 'Unauthorized access. Please login.');
        }

        // ✅ Search, filter, and list applications
        $query = RefundApplication::with('student');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('matric_number', 'like', "%$search%");
            })->orWhere('tracking_id', 'like', "%$search%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $applications = $query->latest()->get();

        return view('admin.dashboard', compact('applications'));
    }

    public function updateStatus(Request $request, $id)
    {
        // ✅ Admin session check again for extra safety
        if (!session()->has('admin')) {
            return redirect()->route('admin.login')->with('error', 'Unauthorized access.');
        }

        $request->validate(['action' => 'required|in:approve,decline']);

        $application = RefundApplication::findOrFail($id);
        $application->status = $request->action === 'approve' ? 'approved' : 'declined';
        $application->save();

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }
    public function view($id)
    {
        $application = RefundApplication::with('student')->findOrFail($id);
        return view('admin.view', compact('application'));
    }
}
