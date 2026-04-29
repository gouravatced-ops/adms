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
use App\Http\Controllers\Admin\FileManagementController;
use App\Http\Controllers\Admin\ApproverController;
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
    Route::get('/assign/dataentry/list/{encodedId}', [LotsController::class, 'assignedUserList'])->name('assign.userlist');
    Route::get('/assign/files/status/{encodedId}', [LotsController::class, 'assignedFilesStatus'])->name('assign.files.status');
    Route::post('/lots/assign', [LotsController::class, 'assignStore'])->name('assign.store');
    Route::post('/lots/assign/partial', [LotsController::class, 'assignPartialFiles'])->name('assign.partial');
});

// checked Files
Route::get('checked/lots/list', [FileManagementController::class, 'CheckedLotsList'])->name('admin.checked.lots.index');
Route::get('/checked/file/list/{encodedId}/{page}', [FileManagementController::class, 'checkedLotsFileList'])->name('admin.checked.files.index');
Route::get('/revert/file/list/1', [FileManagementController::class, 'revertLotsFileList'])->name('admin.revert.lots.files.index');

// manage Lots
Route::get('manage/lots/list', [FileManagementController::class, 'LotsList'])->name('admin.manage.lots.index');
Route::get('/receiving/lots/list', [FileManagementController::class, 'receivingLotsList'])->name('admin.receiving.lots.index');
Route::get('/receiving/file/list/{encodedId}/{page}', [FileManagementController::class, 'receivingLotsFileList'])->name('admin.receiving.files.index');
Route::get('/receiving/file/exports/{registerId}', [FileManagementController::class, 'receivingfilesExports'])->name('admin.receiving.files.exports');
Route::get('/receiving/file/fetch/{encryptedId}', [FileManagementController::class, 'receivingfileFetch'])->name('admin.receiving.file.fetch');
Route::put('/receiving/file/update/{encryptedId}', [FileManagementController::class, 'receivingfileUpdate'])->name('admin.receiving.file.update');
Route::get('/scanning/lots/list', [FileManagementController::class, 'scannedLotsList'])->name('admin.scanning.lots.index');
Route::get('/scanning/file/list/{encodedId}/{page}', [FileManagementController::class, 'scanningLotsFileList'])->name('admin.scanning.files.index');
Route::get('/scanning/file/fetch/{encryptedId}', [FileManagementController::class, 'scanningfileFetch'])->name('admin.scanning.file.fetch');
Route::put('/scanning/file/update/{encryptedId}', [FileManagementController::class, 'scanningfileUpdate'])->name('admin.scanning.file.update');
Route::get('/dataentry/lots/list', [FileManagementController::class, 'dataentryLotsList'])->name('admin.dataentry.lots.index');
Route::get('/dataentry/file/list/{encodedId}/{page}', [FileManagementController::class, 'dataentryLotsFileList'])->name('admin.dataentry.files.index');
Route::get('/preview/file/{encryptedId}', [FileManagementController::class, 'filePreview'])->name('admin.file.preview');
Route::post('/documents/{id}/mark-read', [FileManagementController::class, 'markAsRead'])->name('admin.documents.mark-read');
Route::post('/masterdocuments/{id}/mark-read', [FileManagementController::class, 'markMasterDocumentAsRead'])->name('admin.masterdocuments.mark-read');
Route::post('/approve/file/{encryptedId}', [FileManagementController::class, 'approveDataEntry'])->name('admin.lots.dataentry.file.approve');
Route::post('/verify/approve/file/lots/{registerId}', [FileManagementController::class, 'approveDataEntryLots'])->name('admin.lots.dataentry.lots.approve');
Route::post('/approve/documentmaster/{encryptedId}', [FileManagementController::class, 'approveMasterDocument'])->name('admin.lots.dataentry.file.approveMasterDocument');

// suadmin handover
Route::get('readyfor/handover/lot/files' , [FileManagementController::class, 'readyforhandover'])->name('admin.handover.lots.index');
Route::get('/handover/files/{encodedId}/{page}', [FileManagementController::class, 'readyforhandoverindexfiles'])->name('admin.handover.files.index');
Route::get('/handover/file/exports/{registerId}', [FileManagementController::class, 'handoverfilesExports'])->name('admin.handover.files.exports');


// approver lists
Route::get('approver/pending/lots/list', [ApproverController::class, 'approverPendingLots'])->name('approver.pending-lots');
Route::get('/pending/approver/file/list/{encodedId}/{page}', [ApproverController::class, 'approverPendingFiles'])->name('admin.pending.files.index');
Route::get('approved/lots/list', [ApproverController::class, 'approverApprovedLots'])->name('approver.approved-lots');
Route::get('/approved/file/list/{encodedId}/{page}', [ApproverController::class, 'approverApprovedLotFiles'])->name('admin.approved.files.index');

// hanover lots
Route::get('handover/lot/files' , [ApproverController::class, 'handoverLotsFiles'])->name('approver.handover-lots');

// Admin approver lists
Route::get('division/pending/lots/list', [ApproverController::class, 'approverPendingAllLots'])->name('approver.admin.pending-lots');
Route::get('/division/approved/lots/list', [ApproverController::class, 'approverApprovedAllLots'])->name('approver.admin.approved-lots');
Route::post('/division/file/approver', [FileManagementController::class, 'approveSelectedFile'])->name('admin.selected.files.approved');

// Admin hanover lots
Route::get('division/handover/lot/files' , [ApproverController::class, 'handoverAllLotsFiles'])->name('approver.admin.handover-lots');

// fetch and update allotee
Route::get('/edit/allottee/setp1/{encryptedId}', [FileManagementController::class, 'fetchallottedetails'])->name('admin.fetch.step1');


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
