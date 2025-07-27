<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\RefundApplication;
use App\Models\Admin;
use App\Models\EligibleStudent;
use Barryvdh\DomPDF\Facade\Pdf;
use Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;



class AdminController extends Controller
{
    // 🔹 Dashboard
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $applications = $this->filterApplications($request);
        return view('admin.admin', compact('applications'));
    }

    // 🔹 View individual application
    public function view($id)
    {
        $this->authorizeAdmin();

        $application = RefundApplication::with('student')->findOrFail($id);
        return view('admin.view', compact('application'));
    }

public function uploadStudentsSubmit(Request $request)
{
    $this->authorizeAdmin();

    $request->validate([
        'student_file' => 'required|file|mimes:csv,xlsx,xls,txt|max:5120',
    ]);

    $file = $request->file('student_file');
    $extension = $file->getClientOriginalExtension();
    $inserted = 0;

    // Common expected headers
    $expected = ['matric_number', 'full_name', 'department', 'level', 'faculty', 'loanamount', 'levies', 'amountpaid', 'paymentmode'];

    if (in_array($extension, ['xlsx', 'xls'])) {
        // Handle Excel
        $spreadsheet = IOFactory::load($file);
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $header = array_map('strtolower', array_map('trim', $rows[1] ?? []));

        if (array_diff($expected, $header)) {
            return back()->with('error', 'Excel headers must include: ' . implode(', ', $expected));
        }

        unset($rows[1]);

        foreach ($rows as $row) {
            $data = array_combine($header, array_map('trim', array_values($row)));

            $validator = Validator::make($data, [
                'full_name' => 'required|string',
                'matric_number' => 'required|string|unique:eligible_students,matric_number',
                'department' => 'required|string',
                'faculty' => 'required|string',
                'level' => 'required|string',
                'loanamount' => 'required|numeric',
                'levies' => 'required|numeric',
                'amountpaid' => 'required|numeric',
                'paymentmode' => 'nullable|string',
            ]);

            if ($validator->fails()) continue;

            EligibleStudent::create($data);
            $inserted++;
        }

    } else {
        // Handle CSV
        $rows = array_map('str_getcsv', file($file));
        $header = array_map('strtolower', array_map('trim', $rows[0]));

        if (array_diff($expected, $header)) {
            return back()->with('error', 'CSV headers must include: ' . implode(', ', $expected));
        }

        unset($rows[0]);

        foreach ($rows as $row) {
            $data = array_combine($header, array_map('trim', $row));

            $validator = Validator::make($data, [
                'full_name' => 'required|string',
                'matric_number' => 'required|string|unique:eligible_students,matric_number',
                'department' => 'required|string',
                'faculty' => 'required|string',
                'level' => 'required|string',
                'loanamount' => 'required|numeric',
                'levies' => 'required|numeric',
                'amountpaid' => 'required|numeric',
                'paymentmode' => 'nullable|string',
            ]);

            if ($validator->fails()) continue;

            EligibleStudent::create($data);
            $inserted++;
        }
    }

    return back()->with('success', "$inserted students uploaded successfully.");
}


public function downloadSampleTemplate()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Student Template');

    $headers = [
        'matric_number', 'full_name', 'department', 'level', 'faculty',
        'loanamount', 'levies', 'amountpaid', 'paymentmode'
    ];

    $sheet->fromArray($headers, null, 'A1');

    // Optional sample row
    $sheet->fromArray([
        'UI/21/1234', 'John Doe', 'Computer Science', '400', 'Science',
        50000, 1000, 20000, 'Bank Transfer'
    ], null, 'A2');

    // Auto-size columns
    foreach (range('A', $sheet->getHighestColumn()) as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'sample_student_upload.xlsx';
    $tempFile = tempnam(sys_get_temp_dir(), $filename);
    $writer->save($tempFile);

    return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
}

    // 🔹 Update application status
    public function updateStatus(Request $request, $id)
    {
        $this->authorizeAdmin();

        $request->validate(['action' => 'required|in:approve,decline']);
        $application = RefundApplication::findOrFail($id);
        $application->status = $request->action === 'approve' ? 'approved' : 'declined';
        $application->save();

        return redirect()->back()->with('success', 'Application status updated.');
    }

    // 🔹 Reports Page
    public function reports(Request $request)
    {
        $this->authorizeAdmin();

        $applications = $this->filterApplications($request);
        return view('admin.report', compact('applications'));
    }

    // 🔹 Export to Excel
    public function exportReportExcel(Request $request)
    {
        $this->authorizeAdmin();
        $applications = $this->filterApplications($request);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Refund Report');

        $headers = [
            'Full Name', 'Matric Number', 'Department', 'Faculty', 'Level',
            'Loan Amount (₦)', 'Levies (₦)', 'Amount Paid (₦)', 'Refund Amount (₦)',
            'Tracking ID', 'Account Name', 'Account Number', 'Bank',
            'Status', 'Submitted On'
        ];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        foreach ($applications as $app) {
            $sheet->fromArray([
                strtoupper($app->student->full_name),
                $app->student->matric_number,
                ucwords($app->student->department),
                ucwords($app->student->faculty),
                $app->student->level,
                number_format($app->student->loanamount, 2),
                number_format($app->student->levies, 2),
                number_format($app->student->amountpaid, 2),
                number_format($app->student->refund_amount, 2),
                $app->tracking_id,
                $app->account_name,
                $app->account_number,
                $app->bank_name,
                strtoupper($app->status),
                $app->created_at->format('d M Y, h:i A')
            ], null, 'A' . $row++);
        }

        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'refund-report.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    // 🔹 Export to PDF
    public function exportReportPDF(Request $request)
    {
        $applications = $this->filterApplications($request);
        $pdf = Pdf::loadView('admin.report-pdf', compact('applications'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('loan_refund_full_report.pdf');
    }

    // 🔹 Export to CSV
    public function exportReportCSV()
    {
        $applications = RefundApplication::with('student')->latest()->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=refund-report.csv",
        ];

        $callback = function () use ($applications) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Full Name', 'Matric Number', 'Tracking ID', 'Refund Amount',
                'Status', 'Submitted On'
            ]);

            foreach ($applications as $app) {
                fputcsv($file, [
                    $app->student->full_name,
                    $app->student->matric_number,
                    $app->tracking_id,
                    number_format($app->student->refund_amount, 2),
                    $app->status,
                    $app->created_at->format('d M Y, h:i A')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 🔹 Admin Users
    public function listUsers()
    {
        $this->authorizeApprover();

        $admins = Admin::all();
        return view('admin.users', compact('admins'));
    }

  public function createUser(Request $request)
{
    $this->authorizeApprover();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email',
        'password' => 'required|string|min:6',
        'role' => 'required|in:viewer,approver,disburser', // ✅ Fixed here
    ]);

    Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('admin.users')->with('success', 'Admin created successfully.');
}


    public function deleteUser($id)
    {
        $this->authorizeApprover();

        if (session('admin_id') == $id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.users')->with('success', 'Admin deleted successfully.');
    }

    // 🔹 Upload Students View
    public function uploadStudents()
    {
        $this->authorizeAdmin();
        return view('admin.upload');

    }



    // 🔹 Shared Utility: Application Filter
    private function filterApplications(Request $request)
    {
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

        return $query->latest()->get();
    }

    // 🔹 Auth Helpers
private function authorizeAdmin()
{
    if (!session()->has('admin')) {
        // Redirect instead of aborting
        redirect()->route('admin.login')->send(); // ✅ This forces redirect to login page
    }
}


    private function authorizeApprover()
    {
        $this->authorizeAdmin();
        if (session('admin_role') !== 'approver') {
            abort(403, 'Insufficient permission.');
        }
    } 

    private function authorizeDisburser()
{
    $this->authorizeAdmin();
    if (session('admin_role') !== 'disburser') {
        abort(403, 'Only disbursers can perform this action.');
    }
}


    public function markAsDisbursed($id)
{
    $this->authorizeDisburser();

    $application = RefundApplication::findOrFail($id);
    if ($application->status !== 'approved') {
        return back()->with('error', 'Only approved applications can be marked as disbursed.');
    }

    $application->status = 'disbursed';
    $application->save();

    return back()->with('success', 'Application marked as disbursed.');
}

public function handleBulkAction(Request $request)
{
if ($request->action === 'approve') {
    $this->authorizeApprover();
} elseif ($request->action === 'disburse') {
    $this->authorizeDisburser();
}

    $request->validate([
        'ids' => 'required|array',
        'action' => 'required|in:approve,disburse',
    ]);

    $updated = 0;

    foreach ($request->ids as $id) {
        Log::info("Processing application ID: $id");
        $application = RefundApplication::find($id);

        if (!$application) continue;

        if ($request->action === 'approve' && $application->status === 'submitted') {
            $application->status = 'approved';
            $application->save();
            $updated++;
        }

        if ($request->action === 'disburse' && $application->status === 'approved') {
            $application->status = 'disbursed';
            $application->save();
            $updated++;
        }
    }

    return back()->with('success', "$updated applications updated successfully.");
}



}
