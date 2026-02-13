<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use Illuminate\Support\Facades\Route;


Route::get('/registrar/dashboard', [AdminController::class, 'registarDashboard'])->name('registrar.dashboard');

Route::get('/registar/applicant-details/{id}', [AdminRegistrationController::class, 'getAcceptedApplicantDetail'])->name('registar.applicant-details');

Route::get('/view/registar/pending-forms', [AdminRegistrationController::class, 'showCouncilAcceptedRegistrationForm'])->name('view.registar.pending-forms');

Route::get('/view/council-office/rejected-registration', [AdminRegistrationController::class, 'showRejectedCouncilRegistrationForm'])->name('view.council-office.rejected-registration');

Route::get('/view/registar/rejected-registration', [AdminRegistrationController::class, 'showRegistarRejectedRegistrationForm'])->name('view.registar.rejected-registration');

Route::post('/registar/aplication-change-status', [AdminRegistrationController::class, 'applicationChangeStatusByRegistar'])->name('registar.aplication-change-status');

Route::get('/view/registar/approved-registration', [AdminRegistrationController::class, 'showCouncilApprovedRegistrationForm'])->name('view.registar.approved-registration');

Route::get('/view/registar/generate-certificate', [AdminRegistrationController::class, 'showCouncilApprovedRegistrationForm'])->name('view.registar.generate-certificate');

Route::post('/registar/generate-certificate', [AdminRegistrationController::class, 'generateCertificate'])->name('registar.generate-certificate');

Route::post('/registar/generate-certificate-send-otp', [AdminRegistrationController::class, 'generateCertificateSendOTP'])->name('registar.generate-certificate-send-otp');

Route::get('/view/registar/view-generated-certificate', [AdminRegistrationController::class, 'viewRegistarUnsignedCertificate'])->name('view.registar.view-generated-certificate');

Route::get('/view/registar/show-signed-certificate', [AdminRegistrationController::class, 'viewRegistarSignedCertificate'])->name('view.registar.show-signed-certificate');

Route::post('/certi-verify-otp', [AdminRegistrationController::class, 'verifyCertificateOTP'])->name('certi-verify-otp');
