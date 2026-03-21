<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\HeadquarterController;
use App\Http\Controllers\Admin\DivisionsController;
use App\Http\Controllers\Admin\QuarterTypeController;
use App\Http\Controllers\Admin\SubDivisionController;
use App\Http\Controllers\Admin\PropertyCategoryController;
use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\PropertyMainTypeController;
use App\Http\Controllers\Admin\SchemeController;
use App\Http\Controllers\Admin\LotsController;
use App\Http\Controllers\Admin\SchemeBlockController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [AdminController::class, 'councilDashboard'])->name('council_office.dashboard');

Route::get('/headquarters', [HeadquarterController::class, 'index'])->name('headquarters.index');
Route::get('/headquarters/create', [HeadquarterController::class, 'createPage'])->name('admin.headquarters.create');
Route::post('/headquarters', [HeadquarterController::class, 'store'])->name('headquarters.store');
Route::put('/headquarters/{id}', [HeadquarterController::class, 'update'])->name('headquarters.update');
Route::delete('/headquarters/{id}', [HeadquarterController::class, 'destroy'])->name('headquarters.destroy');

// divisions
Route::get('/divisions', [DivisionsController::class, 'index'])->name('sub-admin.division.index');

// subdivisions
Route::get('/subdivision', [SubDivisionController::class, 'index'])->name('sub-admin.subdivision.index');

// Property Category Routes

Route::get('pcategory/', [PropertyCategoryController::class, 'index'])->name('sub-admin.pcategory.index');

// Property Type Routes
Route::get('/pcategorytype', [PropertyTypeController::class, 'index'])->name('sub-admin.pcategorytype.index');

// Property Main Type
Route::get('/propertysubtypes', [PropertyMainTypeController::class, 'index'])->name('sub-admin.propertysubtypes.index');

// Quarter Type
Route::get('/quarter-types', [QuarterTypeController::class, 'index'])->name('sub-admin.quarter-types.index');

// Scheme Type
Route::get('/schemes', [SchemeController::class, 'index'])->name('sub-admin.schemes.index');

// Assigned Lots 
Route::prefix('lots')->name('admin.lots.')->group(function () {
    Route::get('/list', [LotsController::class, 'registerLotsList'])->name('aasign.index');
    Route::get('file/list/{encodedId}/{page}', [LotsController::class, 'registerLotsFileList'])
        ->name('assign.file.index');
    Route::post('/lots/assign', [LotsController::class, 'assignStore'])->name('assign.store');
    Route::post('/lots/assign/partial', [LotsController::class, 'assignPartialFiles'])->name('assign.partial');
});


Route::get('/view/pending-registration', [AdminRegistrationController::class, 'showPendingRegistrationForm'])->name('view.pending-registration');

Route::get('/view/incomplete-registration', [AdminRegistrationController::class, 'showIncompleteRegistrationForm'])->name('view.incomplete-registration');

Route::get('/view/accepted-registration', [AdminRegistrationController::class, 'showAcceptedRegistrationForm'])->name('view.accepted-registration');

Route::get('/view/rejected-registration', [AdminRegistrationController::class, 'showRejectedRegistrationForm'])->name('view.rejected-registration');

Route::get('/applicant-details/{id}', [AdminRegistrationController::class, 'getApplicantDetail'])->name('applicant-details');

Route::get('/incomplete-applicant-details/{id}', [AdminRegistrationController::class, 'getIncompleteApplicantDetail'])->name('incomplete-applicant-details');

Route::post('/submit-incomplete-reason', [AdminRegistrationController::class, 'submitIncompleteReason'])->name('submit-incomplete-reason');

Route::post('/submit-accept-doc', [AdminRegistrationController::class, 'acceptDocuments'])->name('submit-accept-doc');

Route::post('/payment-action', [AdminRegistrationController::class, 'submitPaymentAction'])->name('payment-action');

Route::post('/aplication-change-status', [AdminRegistrationController::class, 'applicationChangeStatus'])->name('aplication-change-status');

Route::get('edit/applicant-form-dtl/{acknowledgment_number}', [AdminRegistrationController::class, 'viewEditApplicantFormDetails'])->name('edit.applicant-form-dtl');

Route::get('/view/registered-applicant', [AdminRegistrationController::class, 'viewApplicantRegistration'])->name('view.registered-applicant');

Route::put('/edit/registered-applicant/{id}', [AdminRegistrationController::class, 'editApplicantRegistration'])->name('edit.registered-applicant');

Route::get('/view/affiliated-college', [AdminController::class, 'viewAffiliatedCollege'])->name('view.affiliated-college');

Route::get('/view/generate-excel', [AdminRegistrationController::class, 'viewGenerateApprovedStuExcel'])->name('view.generate-excel');

Route::post('/range-cert-excel', [AdminRegistrationController::class, 'rangeCertificateExcelGen'])->name('range-cert-excel');

Route::get('/edit/affiliated-college/{id}', [AdminController::class, 'editViewAffiliatedCollege'])->name('edit.affiliated-college');

Route::put('/update/affiliated-college/{id}', [AdminController::class, 'updateAffiliatedCollege'])->name('update.affiliated-college');

Route::get('/view/registrar-generated-certificate', [AdminRegistrationController::class, 'viewRegistarUnsignedCertificate'])->name('view.registrar-generated-certificate');

Route::get('/view/upload-signed-generated-certificate', [AdminRegistrationController::class, 'viewRegistarUnsignedCertificate'])->name('view.upload-signed-generated-certificate');

Route::get('/view/registrar-signed-certificate', [AdminRegistrationController::class, 'viewRegistarSignedCertificate'])->name('view.registrar-signed-certificate');

Route::post('/signed-cert-upload', [AdminRegistrationController::class, 'councilSignedCertificateUpload'])->name('signed-cert-upload');

Route::post('/admin-get-check-other', [AdminRegistrationController::class, 'getCheckOtherPassningState'])->name('admin-get-check-other');

Route::put('/payment/update/{id}', [AdminRegistrationController::class, 'updatePaymentDeatailsByCouncil'])->name('payment.update');
Route::put('/applicant/update/{id}', [AdminRegistrationController::class, 'updateApplicantDeatailsByCouncil'])->name('applicant.update');
