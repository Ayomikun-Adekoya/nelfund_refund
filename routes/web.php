<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Models\EligibleStudent;
use App\Models\RefundApplication;

// Home page
Route::get('/', fn() => view('home'));

// Application Flow
Route::get('/apply', fn() => view('apply'))->name('refund.apply.form');
Route::post('/apply/check', [RefundController::class, 'verifyTrackingId'])->name('refund.apply.verify');
Route::get('/apply/{student}', [RefundController::class, 'showApplicationForm'])->name('refund.apply');
Route::post('/apply/{student}', [RefundController::class, 'submitApplication'])->name('refund.submit');

// Check Status
Route::get('/check-status', [RefundController::class, 'showCheckForm']);
Route::post('/check-status', [RefundController::class, 'submitCheckForm'])->name('check-status.submit');

// Status Page
Route::get('/status/{student}', function ($student) {
    $student = EligibleStudent::findOrFail($student);
    $application = RefundApplication::where('eligible_student_id', $student->id)->first();
    return view('status', compact('student', 'application'));
})->name('refund.status');

// Admin Login & Auth
Route::get('/admin', [AdminAuthController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'store'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'destroy'])->name('logout');

// Admin routes (manually secured in the controller via session check)
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/applications', fn() => view("admin.application"))->name('admin.applications');
Route::get('/admin/upload', fn() => view("admin.upload"))->name('admin.upload');
Route::patch('/admin/{id}', [AdminController::class, 'updateStatus'])->name('admin.update');
Route::get('/admin/view/{id}', [AdminController::class, 'view'])->name('admin.view');
