<?php

use App\Exports\CertificateGeneratedExport;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Applicant\StudentApplicationController;
use App\Http\Controllers\Admin\LotsController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::get('/admin/two-step-auth', [AuthController::class, 'twoFactorAuthAdmin'])->name('admin.two-step-auth');
Route::get('/admin/forgot-password', [AuthController::class, 'forgotPasswordAdmin'])->name('admin.forgot-password');

Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/forgotPassAdminOtp', [AuthController::class, 'forgotPassAdminOtp'])->name('admin.forgotPassAdminOtp');

Route::post('/admin/AdminResendOtp', [AuthController::class, 'forgotPassAdminOtp'])->name('admin.AdminResendOtp');

Route::post('/admin/forgot-password-verify', [AuthController::class, 'forgotPasswordAdminUpdate'])->name('admin.forgot-password-verify');

Route::post('/admin/verifyOtp', [AuthController::class, 'verifyOtp'])->name('admin.verifyOtp');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::get('/get-courses/{id}', [StudentApplicationController::class, 'getCoursesByType'])->name('get-courses');

Route::prefix('admin')->group(function () {
    Route::middleware(['auth:admin'])->group(function () {

        Route::get('/admin-get-courses/{id}', [AdminController::class, 'getCoursesByType'])->name('admin-get-courses');

        Route::get('/admin-get-college-name', [AdminController::class, 'getInstitute'])->name('admin-get-college-name');

        Route::get('/admin-get-state', [AdminController::class, 'getState'])->name('admin-get-state');

        Route::get('/applicant_af/pdf/{acknowledgment_number}', [AdminRegistrationController::class, 'generateAppPDF'])->name('applicant_af.pdf');

        Route::get('/applicant_ack_slip/pdf/{acknowledgment_number}', [AdminRegistrationController::class, 'generateAckNoPDF'])->name('applicant_ack_slip.pdf');

        Route::post('/admin-upload-single-document', [AdminRegistrationController::class, 'uploadStudentSingleDoc'])->name('admin-upload-single-document');

        Route::put('/application-mark-pending/{id}', [AdminRegistrationController::class, 'applicationMarkPending'])->name('application-mark-pending');

        // Route::get('/get-courses/{id}', [StudentApplicationController::class, 'getCoursesByType'])->name('get-courses');

        Route::get('/profile/my-profile', [AdminController::class, 'getMyProfile'])->name('profile.my-profile');

        Route::get('/profile/my-setting', [AdminController::class, 'getMySetting'])->name('profile.my-setting');

        Route::post('/update/admin-details', [AdminController::class, 'updateAdminDetails'])->name('update.admin-details');

        Route::post('/update/admin-password', [AdminController::class, 'updateAdminpassword'])->name('update.admin-password');
        Route::post('/update/dashboard-password', [AdminController::class, 'updateDashboardPassword'])->name('update.dashboard-password');

        Route::post('/updateAdminOTP/password', [AdminController::class, 'sendChangePassOTP'])->name('updateAdminOTP.password');

        Route::post('/admin-pass-verify-otp', [AdminController::class, 'verifyPassOTP'])->name('admin-pass-verify-otp');

        // operation of lots for admin and sub-admin
        Route::get('file/receiving/list', [LotsController::class, 'receivingIndex'])->name('admin.file.receiving');
        Route::get('file/dataentry/lots/list', [LotsController::class, 'registerLotsList'])->name('admin.file.lots.dataentry');


        Route::get('/profile/security', function () {
            return view('admin.modules.profile.change-password');
        })->name('profile.security');

        //Super Admin
        Route::middleware(['admin.role:superadmin'])->group(function () {
            require base_path('routes/admin/superadmin.php');
        });

        // Subadmin and Approver of Divisional
        Route::middleware(['admin.role:council_office,approver'])->group(function () {
            require base_path('routes/admin/council_office.php');
        });

        // Registar
        Route::middleware(['admin.role:registar'])->group(function () {
            require base_path('routes/admin/registrar.php');
        });
    });
});

