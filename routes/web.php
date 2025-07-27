<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Models\EligibleStudent;
use App\Models\RefundApplication;

// 🔹 Home
Route::get('/', fn() => view('home'));

// 🔹 Refund Application Flow
Route::get('/apply', fn() => view('apply'))->name('refund.apply.form');
Route::post('/apply/check', [RefundController::class, 'verifyTrackingId'])->name('refund.apply.verify');
Route::get('/apply/{student}', [RefundController::class, 'showApplicationForm'])->name('refund.apply');
Route::post('/apply/{student}', [RefundController::class, 'submitApplication'])->name('refund.submit');

// 🔹 Check Status
Route::get('/check-status', [RefundController::class, 'showCheckForm']);
Route::post('/check-status', [RefundController::class, 'submitCheckForm'])->name('check-status.submit');

// 🔹 View Application Status
Route::get('/status/{student}', function ($student) {
    $student = EligibleStudent::findOrFail($student);
    $application = RefundApplication::where('eligible_student_id', $student->id)->first();
    return view('status', compact('student', 'application'));
})->name('refund.status');

// 🔹 Admin Authentication
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// 🔹 Admin Dashboard & Panel (Protected)
Route::prefix('admin')->middleware('web')->group(function () {

    // 🔸 Dashboard & Refund Management
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('/update/{id}', [AdminController::class, 'updateStatus'])->name('admin.update');
    Route::patch('/disburse/{id}', [AdminController::class, 'markAsDisbursed'])->name('admin.mark.disbursed');
    Route::get('/view/{id}', [AdminController::class, 'view'])->name('admin.view');

    // 🔸 Admin Users Management
    Route::get('/users', [AdminController::class, 'listUsers'])->name('admin.users');
    Route::post('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    // 🔸 Student Upload Page
    Route::get('/upload-students', [AdminController::class, 'uploadStudents'])->name('admin.upload.students');
    Route::post('/upload-students', [AdminController::class, 'uploadStudentsSubmit'])->name('admin.upload.students.submit');

    // 🔸 Download sample Excel upload template
    Route::get('/upload-sample', [AdminController::class, 'downloadSampleTemplate'])->name('admin.upload.sample');

    // 🔸 Reports & Export
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.report');
    Route::get('/reports/export/pdf', [AdminController::class, 'exportReportPDF'])->name('admin.report.export.pdf');
    Route::get('/reports/export/csv', [AdminController::class, 'exportReportCSV'])->name('admin.report.export.csv');
    Route::get('/reports/export/excel', [AdminController::class, 'exportReportExcel'])->name('admin.report.export.excel');

    // 🔸 Mass Actions (Bulk Approve / Disburse) ✅ FIXED
    Route::post('/bulk-action', [AdminController::class, 'handleBulkAction'])->name('admin.bulk.action');
});
