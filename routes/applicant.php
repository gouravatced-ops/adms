<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\RegistrationController;
use App\Http\Controllers\Applicant\AuthController;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\StudentApplicationController;
use App\Http\Controllers\Applicant\FileRecevingController;
use App\Http\Controllers\Applicant\ScannedController;
use App\Http\Controllers\Applicant\StepperFormController;
use App\Http\Controllers\Applicant\NameTransferController;


Route::middleware('guest')->group(function () {
    Route::get('/', [RegistrationController::class, 'showRegistrationForm'])->middleware('guest')->name('student-corner');
    Route::get('/login', [RegistrationController::class, 'showLoginForm'])->middleware('guest')->name('login');
    Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
    Route::post('/student-registration', [RegistrationController::class, 'register'])->name('student-registration');
    Route::post('/send-otp', [RegistrationController::class, 'sendOTP'])->name('send.otp');
    Route::post('/verify-otp', [RegistrationController::class, 'verifyOTP'])->name('verify.otp');

    Route::post('/forgotPassApplicantOtp', [AuthController::class, 'forgotPassApplicantOtp'])->name('forgotPassApplicantOtp');
    Route::post('/applicant-forgot-password-verify', [AuthController::class, 'applicantForgotPasswordUpdate'])->name('applicant-forgot-password-verify');
    Route::get('/reload-captcha', function () {
        return response()->json([
            'captcha' => captcha_img('flat')
        ]);
    })->name('captcha.reload');
    Route::get('/forgot-password', function () {
        return view('applicant.auth_components.forgot-password');
    })->name('forgot-password');
});


Route::group(['middleware' => ['web']], function () {
    // Login route
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // OTP routes
    Route::prefix('otp')->group(function () {
        Route::get('/form', function () {
            return view('applicant.auth_components.otp-form');
        })->name('otp.form');

        Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');
        Route::post('/verify', [AuthController::class, 'verifyOtp'])->name('verifyLogin.otp');
    });
});


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/account-settings', [DashboardController::class, 'accountSettings'])->name('account-settings');

    Route::post('/update-password', [DashboardController::class, 'updatePassword'])->name('password.update');

    Route::get('/application-success', [StudentApplicationController::class, 'submittedApplication'])->name('application-success');

    Route::get('/track-application', [DashboardController::class, 'trackApplication'])->name('track-application');

    Route::get('/incomplete-application', [DashboardController::class, 'incompleteApplication'])->name('incomplete-application');

    Route::get('/reverted-from/{id}', [DashboardController::class, 'revertedDocumentsView'])->name('reverted-from');

    Route::post('/submit-reverted-form', [StudentApplicationController::class, 'submitRevertedDocuments'])->name('submit-reverted-form');

    Route::get('/approved-application', [DashboardController::class, 'approvedApplication'])->name('approved-application');

    Route::get('/rejected-application', [DashboardController::class, 'rejectedApplication'])->name('rejected-application');

    Route::get('/accepted-application', [DashboardController::class, 'acceptedApplication'])->name('accepted-application');

    Route::match(['get', 'post'], '/apply-new-licence/{step?}', [StudentApplicationController::class, 'handleApplication'])->name('apply-new-licence');

    Route::post('/upload-single-document', [StudentApplicationController::class, 'uploadSingle'])->name('upload-single-document');

    Route::get('/get-courses/{id}', [StudentApplicationController::class, 'getCoursesByType'])->name('get-courses');

    Route::get('/get-college-name', [StudentApplicationController::class, 'getInstitute'])->name('get-college-name');

    Route::get('/get-state', [StudentApplicationController::class, 'getState'])->name('get-state');

    Route::get('/get-check-other', [StudentApplicationController::class, 'getCheckOtherPassningState'])->name('get-check-other');

    Route::post('/submit-application', [StudentApplicationController::class, 'submitApplication'])->name('submit-application');

    Route::get('/application/pdf/{acknowledgment_number}', [StudentApplicationController::class, 'generateAppPDF'])->name('application.pdf');

    Route::get('/ack_slip/pdf/{acknowledgment_number}', [StudentApplicationController::class, 'generateAckNoPDF'])->name('ack_slip.pdf');

    Route::get('/certificate/pdf/{certificate_number}', [DashboardController::class, 'downloadCertificatePdf'])->name('certificate.pdf');

    // filerecieving
    Route::get('/filereceving/listing', [FileRecevingController::class, 'index'])->name('admin.filereceving.index');
    Route::get('/filereceving/item/list/{registerId}', [FileRecevingController::class, 'fileIndex'])->name('admin.filereceving.fileindex');
    Route::get('/filereceving/register/create', [FileRecevingController::class, 'createPage'])->name('admin.filereceving.create');
    // Route::get('/filereceving/create', [FileRecevingController::class, 'createPage'])->name('admin.filereceving.create');
    Route::post('/filereceving/create', [FileRecevingController::class, 'generateRgistrationFileLimit'])->name('admin.filereceving.limitset');
    Route::get('/filereceving/add/file/{registerId}', [FileRecevingController::class, 'addFilesPage'])->name('admin.filereceving.addmore');
    Route::post('/filereceving/store', [FileRecevingController::class, 'store'])->name('admin.filereceving.store');
    Route::post('/filereceving/individual/store', [FileRecevingController::class, 'storeIndividual'])->name('admin.individual.filereceving.store');
    Route::get('/filereceving/individual/fetch/{allotteeId}', [FileRecevingController::class, 'FetchAllotesDetails'])->name('admin.individual.filereceving.fetch');
    Route::post('/filereceving/delete-empty-register', [FileRecevingController::class, 'deleteEmptyRegister'])->name('filereceving.delete-empty-register');
    Route::delete('/filereceving/delete-allottee', [FileRecevingController::class, 'deleteAllottee'])->name('filereceving.delete-allottee');
    Route::get('/filereceving/allotte/deleted/{Id}', [FileRecevingController::class, 'ScannerdeleteAllottee'])->name('scanner.filereceving.delete-allottee');
    Route::post('/filereceving/individual/update-allottee', [FileRecevingController::class, 'updateAllottee'])->name('filereceving.update-allottee');
    Route::post('/filereceving/update-details', [FileRecevingController::class, 'updateAllotteeDetails'])->name('filereceving.update-details');

    // Automatic file receiving
    Route::post('/filereceving/check-property-number', [FileRecevingController::class, 'checkPropertyNumber'])->name('admin.automatic.filereceving.check-property-number');

    // filinlingExport
    Route::get('/filereceving/export/{registerId}', [FileRecevingController::class, 'filesExports'])->name('admin.filereceving.export');

    // allottee files scanning
    Route::get('/register/list', [ScannedController::class, 'index'])->name('applicant.scanning.index');
    Route::get('/lot/scanned/list', [ScannedController::class, 'completedScanned'])->name('applicant.scanning.completed');
    Route::get('/register/item/list/{registerId}', [ScannedController::class, 'fileIndex'])->name('applicant.scanning.fileindex');
    Route::get('/scanned/item/list/{encodedId}', [ScannedController::class, 'completedScannedfileIndex'])->name('applicant.scanning.completed.fileindex');
    Route::delete('/allottee/file/delete/{encodedId}/{id}', [ScannedController::class, 'destroy'])->name('applicant.scanning.delete');
    Route::get('/allottee/view/{encodedId}/{id}', [ScannedController::class, 'show'])->name('applicant.scanning.show');
    Route::post('/allottee/store', [ScannedController::class, 'store'])->name('applicant.scanning.store');

    // data entry 
    Route::prefix('applicant')->name('applicant.')->group(function () {
        // Stepper Form Routes
        Route::get('/dataentry/start/{encodedId}', [StepperFormController::class, 'indexStart'])->name('apply.index');
        Route::get('/apply/step/{step}/{applicantId}', [StepperFormController::class, 'getStep'])->name('apply.step');

        // AJAX Save Routes
        Route::get('/scanned/list', [StepperFormController::class, 'index'])->name('dataentry.scanned.files');
        Route::get('/completed/lot/list', [StepperFormController::class, 'completedIndex'])->name('dataentry.completed.lot');
        Route::get('/scanned/lots/files/{encodedId}', [StepperFormController::class, 'fileIndex'])->name('dataentry.scanned.lots.files');
        Route::get('/completed/lots/files/{encodedId}', [StepperFormController::class, 'CompletedfileIndex'])->name('dataentry.completed.lots.files');
        Route::post('/apply/step1/save', [StepperFormController::class, 'saveStep1'])->name('apply.step1.save');
        Route::post('/apply/step2/save', [StepperFormController::class, 'saveStep2'])->name('apply.step2.save');
        Route::post('/apply/step3/save', [StepperFormController::class, 'saveStep3'])->name('apply.step3.save');
        Route::post('/apply/step4/save', [StepperFormController::class, 'saveStep4'])->name('apply.step4.save');
        Route::post('/apply/step5/save', [StepperFormController::class, 'saveStep5'])->name('apply.step5.save');
        Route::post('/apply/step6/save', [StepperFormController::class, 'saveStep6'])->name('apply.step6.save');
        Route::post('/apply/step7/save', [StepperFormController::class, 'saveStep7'])->name('apply.step7.save');
        Route::post('/documents/store', [StepperFormController::class, 'store'])->name('documents.store');
        Route::post('/save-allottee-details', [StepperFormController::class, 'saveAllotteeDetails'])->name('save.new.store');
        Route::post('/save-emi-ledger', [StepperFormController::class, 'saveEmiLedger'])->name('applicant.save.emi.details');
        Route::post('/skip-step', [StepperFormController::class, 'skipStep'])->name('applicant.skip.step');
        Route::get('/documents/configs', [StepperFormController::class, 'getDocumentConfigs'])->name('applicant.document.basic');
        Route::get('/documents/list/{allotteeId}', [StepperFormController::class, 'getDocumentsList'])->name('applicant.document.list');
    });

    // data entry of file transfer
    Route::prefix('nametransfer')->name('nametransfer.')->group(function () {
        // AJAX Save Routes
        Route::get('/start/{encodedId}', [NameTransferController::class, 'indexStart'])->name('apply.index');
        Route::get('/apply/step/{step}/{applicantId}', [NameTransferController::class, 'getStep'])->name('apply.step');
        Route::get('/files/list', [NameTransferController::class, 'index'])->name('dataentry.files');
        Route::get('/completed/files', [NameTransferController::class, 'completedIndex'])->name('dataentry.completed');
        Route::post('/apply/step1/save', [NameTransferController::class, 'saveStep1'])->name('apply.step1.save');
        Route::post('/apply/step1/update', [NameTransferController::class, 'updateStep1'])->name('apply.step1.update');
        Route::post('/apply/step2/save', [NameTransferController::class, 'saveStep2'])->name('apply.step2.save');
        Route::post('/apply/step3/save', [NameTransferController::class, 'saveStep3'])->name('apply.step3.save');
        Route::post('/apply/step4/save', [NameTransferController::class, 'saveStep4'])->name('apply.step4.save');
        Route::post('/documents/store', [NameTransferController::class, 'store'])->name('documents.store');
        Route::post('/save-emi-ledger', [NameTransferController::class, 'saveEmiLedger'])->name('applicant.save.emi.details');
        Route::post('/skip-step', [NameTransferController::class, 'skipStep'])->name('applicant.skip.step');
        Route::get('/documents/configs', [NameTransferController::class, 'getDocumentConfigs'])->name('applicant.document.basic');
        Route::get('/documents/list/{allotteeId}', [NameTransferController::class, 'getDocumentsList'])->name('applicant.document.list');
    });

    // Add to your routes file
    Route::post('/applicant/documents/skip', [ScannedController::class, 'skip'])->name('applicant.documents.skip');
});
