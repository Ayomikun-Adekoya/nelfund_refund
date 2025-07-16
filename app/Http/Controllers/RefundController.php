<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\EligibleStudent;
use App\Models\RefundApplication;
use App\Models\LoanApproval;

class RefundController extends Controller
{
    // Show the check-status page
    public function showCheckForm()
    {
        return view('check-status');
    }

    // Handle tracking ID from check-status page
  public function submitCheckForm(Request $request)
{
    $request->validate([
        'tracking_id'   => 'required|string',
        'matric_number' => 'required|string',
    ]);

    // Look up refund application using both tracking ID and student matric number
    $application = RefundApplication::where('tracking_id', $request->tracking_id)
        ->whereHas('student', function ($query) use ($request) {
            $query->where('matric_number', $request->matric_number);
        })
        ->first();

    if (!$application) {
        return back()->with('error', 'No matching application found for the provided Tracking ID and Matric Number.');
    }

    return redirect()->route('refund.status', ['student' => $application->eligible_student_id]);
}


    // ✅ New: verifyTrackingId before allowing application
    public function verifyTrackingId(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string',
        ]);

        $loan = LoanApproval::where('tracking_id', $request->tracking_id)->first();

        if (!$loan) {
            return back()->with('error', 'Tracking ID not found.');
        }

        $student = EligibleStudent::where('matric_number', $loan->matric)->first();

        if (!$student) {
            return back()->with('error', 'You are not eligible for a refund.');
        }

        $application = RefundApplication::where('eligible_student_id', $student->id)->first();

        if ($application) {
            return redirect()->route('refund.status', ['student' => $student->id])
                ->with('success', 'You have already applied. Redirected to status page.');
        }

        return view('apply', compact('student'));
    }

    // Show application form if passed from status check
    public function showApplicationForm($studentId)
    {
        $student = EligibleStudent::findOrFail($studentId);
        return view('apply', compact('student'));
    }

    // Submit refund application
    public function submitApplication(Request $request, $studentId)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
            'proof_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filePath = $request->file('proof_file')->store('proofs', 'public');

        $trackingId = 'REF-' . strtoupper(Str::random(10));

        RefundApplication::create([
            'eligible_student_id' => $studentId,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'proof_file' => $filePath,
            'status' => 'submitted',
            'tracking_id' => $trackingId,
        ]);

        return redirect()->route('refund.status', $studentId)
            ->with('success', "Application submitted successfully! Your Tracking ID is: $trackingId");
    }
}
