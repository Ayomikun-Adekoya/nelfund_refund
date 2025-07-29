<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\EligibleStudent;
use App\Models\RefundApplication;
use App\Models\LoanApproval;
use Carbon\Carbon;

class RefundController extends Controller
{
    public function showCheckForm()
    {
        return view('check-status');
    }

    public function submitCheckForm(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string',
            'matric_number' => 'required|string',
        ]);

        $loan = LoanApproval::where('tracking_id', $request->tracking_id)
                            ->where('matric', $request->matric_number)
                            ->first();

        if (!$loan) {
            return back()->with('error', 'No matching record found for the provided Tracking ID and Matric Number.');
        }

        $student = EligibleStudent::where('matric_number', $request->matric_number)->first();

        if (!$student) {
            return back()->with('error', 'You are not eligible for a refund.');
        }

        $application = RefundApplication::where('eligible_student_id', $student->id)->first();

        if ($application) {
            return redirect()->route('refund.status', ['student' => $student->id]);
        }

        return redirect()->route('refund.apply', ['student' => $student->id]);
    }

    public function verifyTrackingId(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string',
            'matric_number' => 'required|string',
        ]);

        $loan = LoanApproval::where('tracking_id', $request->tracking_id)
                            ->where('matric', $request->matric_number)
                            ->first();

        if (!$loan) {
            return back()->with('error', 'No matching record found for the provided Tracking ID and Matric Number.');
        }

        $student = EligibleStudent::where('matric_number', $request->matric_number)->first();

        if (!$student) {
            return back()->with('error', 'You are not eligible for a refund.');
        }

        $application = RefundApplication::where('eligible_student_id', $student->id)->latest()->first();

        if ($application && $application->status !== 'declined') {
            return redirect()->route('refund.status', ['student' => $student->id])
                ->with('success', 'You have already applied. Redirected to status page.');
        }

        return view('apply', compact('student'));
    }

    public function showApplicationForm($studentId)
    {
        $student = EligibleStudent::findOrFail($studentId);
        return view('apply', compact('student'));
    }

    public function submitApplication(Request $request, $studentId)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
            'proof_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'hostel' => 'required|string|max:255',
        ]);

        $existing = RefundApplication::where('eligible_student_id', $studentId)
                                     ->where('status', 'submitted')
                                     ->first();

        if ($existing) {
            return redirect()->route('refund.status', $studentId)
                ->with('error', 'You already have a pending application.');
        }

        $student = EligibleStudent::findOrFail($studentId);
        $loan = LoanApproval::where('matric', $student->matric_number)->first();

        if (!$loan) {
            return back()->with('error', 'Loan record not found. Cannot fetch tracking ID.');
        }

        $filePath = $request->file('proof_file')->store('proofs', 'public');

        RefundApplication::create([
            'eligible_student_id' => $studentId,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'proof_file' => $filePath,
            'status' => 'submitted',
            'tracking_id' => $loan->tracking_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'hostel' => $request->hostel,
            'submitted_at' => Carbon::now(), // ✅ timestamp for submission
        ]);

        return redirect()->route('refund.status', $studentId)
            ->with('success', "Application submitted successfully!");
    }
}
