<?php

namespace App\Http\Controllers\Applicant;

use App\Models\StudentCertificateHistory;
use Illuminate\Http\Request;
use App\Models\StudentApplication;
use App\Models\Payment;
use App\Models\UploadedDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use PDF;
use Illuminate\Support\Facades\Validator;

class StudentApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }
    public function handleApplication(Request $request, $step = null)
    {   
        $formData = [];
        $formData['divisions'] = DB::select("
                SELECT id, name 
                FROM divisions 
                ORDER BY name ASC
            ");
        // Load the view for the current step
        return view('applicant.dashboard_components.newForm', ['data' => $formData]);
    }

    protected function getStudentApplication()
    {
        $studentApplication = StudentApplication::where('student_id', auth()->id())
            ->leftJoin('courses', 'courses.id', '=', 'student_applications.course_id')
            ->where('status', '!=', 'submitted')
            ->select('student_applications.*', 'courses.course_name')
            ->latest()
            ->first();
        if (!$studentApplication) {
            return null;
        }

        return $studentApplication;
    }
    protected function getStudentPayment()
    {
        $stu = $this->getStudentApplication();

        $payment = $stu ? Payment::where('student_application_id', $stu->id)
            ->latest()
            ->first() : null;

        // Add studentCertificateHistory if $stu has data
        $certificateHistory = $stu ? StudentCertificateHistory::where('student_application_id', $stu->id)
            ->orderBy('cert_start_date', 'asc')
            ->get() : collect();

        return [
            'payment' => $payment,
            'certificate_history' => $certificateHistory,
        ];
    }
    protected function getStudentDocuments()
    {
        $stu = $this->getStudentApplication();

        $doc = $stu ? UploadedDocument::where('student_application_id', $stu->id)
            ->get() : null;
        return $doc;
    }
    protected function determineInitialStep($step, $stuApp)
    {
        $steps = $this->getStepsViews();

        if ($stuApp) {
            if ($stuApp && $stuApp['status'] === 'pending_personal') {
                $currentStep = "applicant-information";
            } elseif ($stuApp && $stuApp['status'] === 'pending_documents') {
                $currentStep = "upload-documents";
            } elseif ($stuApp && $stuApp['status'] === 'review') {
                $currentStep = "review";
            } else {
                $currentStep = 'payment-information';
            }
        } else {
            $currentStep = 'payment-information';
        }

        if ($step && array_search($step, $steps) > array_search($currentStep, $steps)) {
            return $currentStep;
        }

        return $step ?: $currentStep;
    }
    protected function getStepsViews()
    {
        return [
            'payment-information',
            'applicant-information',
            'upload-documents',
            'review'
        ];
    }
    protected function handleNextStep(Request $request, $step)
    {
        switch ($step) {
            case 'payment-information':
                $this->savePaymentInformation($request);
                break;
            case 'applicant-information':
                $this->validateSaveApplicantInformation($request);
                break;
            case 'upload-documents':
                $this->validateUploadDocuments($request);
                $this->saveUploadDocuments($request);
                break;
            case 'review':
                $this->submitApplication($request);
                break;
        }

        $stepsViews = $this->getStepsViews();
        $currentStepIndex = array_search($step, $stepsViews);

        $nextStepView = $stepsViews[$currentStepIndex + 1];

        $formData = $this->getFormDataForStep($nextStepView);

        // dd($stepsViews[$currentStepIndex + 1]);
        return redirect()->route('apply-new-licence', $stepsViews[$currentStepIndex + 1]);
        // return view('applicant.dashboard_components.newForm', ['step' => $nextStepView, 'data' => $formData]);
    }
    protected function handlePreviousStep($step)
    {
        $stepsViews = $this->getStepsViews();
        $currentStepIndex = array_search($step, $stepsViews);

        $previousStep = ($currentStepIndex > 0) ? $stepsViews[$currentStepIndex - 1] : $stepsViews[0];

        $formData = $this->getFormDataForStep($previousStep);

        return redirect()->route('apply-new-licence', $previousStep);
    }
    protected function getFormDataForStep($step)
    {
        $stuApp = $this->getStudentApplication();

        switch ($step) {
            case 'payment-information':
                return $this->getStudentPayment();
            case 'applicant-information':
                return $stuApp;
            case 'upload-documents':
                $uploadedDocuments = $this->getStudentDocuments();
                $payment = $this->getStudentPayment()['payment'];

                $documentData = [];
                $documentData['course_type'] = $stuApp['course_type'];
                $documentData['passState'] = $payment['passing_state'];
                foreach ($uploadedDocuments as $document) {
                    $documentData[$document->document_name] = $document;
                }
                return $documentData;
            case 'review':
                $uploadedDocuments = $this->getStudentDocuments();
                $documentData = [];
                foreach ($uploadedDocuments as $document) {
                    $documentData[$document->document_name] = $document;
                }

                $payment = $this->getStudentPayment()['payment'];

                $history = $this->getStudentPayment()['certificate_history'];

                // dd($history);

                $resState = DB::table('indian_states')->select('name')->where('id', $stuApp['state'])->first();

                $jhCollege = DB::table('institutes')->select('name')->where('institute_id', $stuApp['college_name'])->first();

                return [
                    'payment' => $payment,
                    'studentApplication' => $stuApp,
                    'document' => $documentData,
                    'passState' => DB::table('indian_states')->select('name')->where('id', $payment['other_state'])->first(),
                    'resState' => $resState,
                    'jhCollege' => $jhCollege,
                    'certificateHistory' => $history
                ];

            default:
                return null;
        }
    }

    function getOrdinal($num)
    {
        $ordinals = [
            1 => '1st',
            2 => '2nd',
            3 => '3rd',
            4 => '4th',
            5 => '5th',
            6 => '6th',
            7 => '7th',
            8 => '8th',
            9 => '9th',
            10 => '10th',
            11 => '11th',
            12 => '12th',
            13 => '13th',
            14 => '14th',
            15 => '15th'
        ];

        if (isset($ordinals[$num])) {
            return $ordinals[$num];
        }

        // For numbers beyond 15, use standard rules
        $lastDigit = $num % 10;
        $lastTwoDigits = $num % 100;

        if ($lastTwoDigits >= 11 && $lastTwoDigits <= 13) {
            return $num . 'th';
        }

        switch ($lastDigit) {
            case 1:
                return $num . 'st';
            case 2:
                return $num . 'nd';
            case 3:
                return $num . 'rd';
            default:
                return $num . 'th';
        }
    }

    public function savePaymentInformation(Request $request)
    {
        $userId = auth()->id();

        $studentApplication = $this->getStudentApplication();

        $resultYear = date('Y', strtotime($request->resultDate));
        $currentYear = date('Y');

        $limit = floor(($currentYear - $resultYear) / 5) + 1;

        if ($studentApplication) {
            $existingPayment = Payment::where('student_application_id', $studentApplication->id)->latest()->first();

            $receiptFileRule = $existingPayment && $existingPayment->payment_receipt
                ? 'nullable|file|mimes:pdf,jpg|max:200'
                : 'required|file|mimes:pdf,jpg|max:200';

            $acknowledgmentNo = $studentApplication->acknowledgment_no ?? date('ym') . sprintf('%06d', mt_rand(1, 999999));

        } else {
            $acknowledgmentNo = date('ym') . sprintf('%06d', mt_rand(1, 999999));
            $studentApplication = new StudentApplication([
                'student_id' => $userId,
                'acknowledgment_no' => $acknowledgmentNo,
                'status' => 'pending_personal',
            ]);
            // $studentApplication->save();
            $existingPayment = null;
            $receiptFileRule = 'required|file|mimes:pdf,jpg|max:200';
        }

        $request->validate([
            'receipt_no' => [
                'required',
                'string',
                'max:25',
                Rule::unique('payments', 'payment_receipt_no')->ignore(optional($existingPayment)->id),
            ],
            'registrationNo' => [
                'required',
                'numeric',
                Rule::unique('payments', 'registration_no')->ignore(optional($existingPayment)->id)
            ],
            'amount' => 'required|numeric',
            'dated' => 'required|date|before_or_equal:today',
            'receipt_file' => $receiptFileRule,
            'state' => 'in:Jharkhand,Other',
            'otherState' => 'required_if:state,Other',
            'resultDate' => 'required|date|before_or_equal:today',
        ]);

        $studentApplication->save();

        $receiptFileName = $existingPayment->payment_receipt ?? null;

        // Handle file upload
        if ($request->hasFile('receipt_file')) {
            $file = $request->file('receipt_file');
            $yearMonth = date('ym');
            $folderPath = "uploads/{$yearMonth}/payment_receipt/";
            $fileName = $acknowledgmentNo . '.' . $file->getClientOriginalExtension();

            $file->move(public_path($folderPath), $fileName);

            $receiptFileName = "$folderPath$fileName";
        }

        Payment::updateOrCreate(
            ['student_application_id' => $studentApplication->id],
            [
                'passing_state' => $request->state,
                'other_state' => $request->otherState,
                'registration_no' => $request->registrationNo,
                'result_date' => $request->resultDate,
                'payment_receipt_no' => $request->receipt_no,
                'category' => auth()->user()->category,
                'amount' => $request->amount,
                'dated' => $request->dated,
                'payment_receipt' => $receiptFileName,
            ]
        );

        $existingIds = [];

        for ($i = 1; $i <= $limit; $i++) {
            $ordinal = $this->getOrdinal($i);
            $certificateType = $i == 1 ? "$ordinal Certificate" : "$ordinal Renewal Certificate";

            $startDate = $request->input("cert_start_date{$i}");
            $expiryDate = $request->input("cert_expiry_date{$i}");

            // Only create/update if both dates are provided
            if ($startDate && $expiryDate) {
                $record = StudentCertificateHistory::updateOrCreate(
                    [
                        'student_application_id' => $studentApplication->id,
                        'certificate_type' => $certificateType
                    ],
                    [
                        'cert_start_date' => $startDate,
                        'cert_expiry_date' => $expiryDate,
                    ]
                );
                $existingIds[] = $record->id;
            }
        }

        // Delete records that weren't in the submitted form
        StudentCertificateHistory::where('student_application_id', $studentApplication->id)
            ->whereNotIn('id', $existingIds)
            ->delete();
    }
    private function validateSaveApplicantInformation(Request $request)
    {
        $userId = auth()->id();

        $payment = $this->getStudentPayment()['payment'];

        $studentApplication = $this->getStudentApplication();

        $validationRules = [
            'course_type' => 'required|string',
            'course_name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('student_applications', 'course_id')
                    ->where(function ($query) use ($userId) {
                        return $query->where('student_id', $userId);
                    })
                    ->whereNull('other_course')->ignore(optional($studentApplication)->id),
            ],
            'college_name' => 'required|string|max:150',
            'jh_other_college_name' => 'required_if:college_name,999|string|max:150',
            'course_registration_no' => 'required|string|max:50',
            'applicant_name' => 'required|string|max:150',
            'guardian_type' => 'required|in:father,husband',
            'fathers_name' => 'required|string|max:150',
            'gender' => 'required|in:Male,Female,Other',
            'category' => 'required|in:General,ST,SC,OBC',
            'address' => 'required|string|max:150',
            'city' => 'required|string|max:30',
            'pin' => 'required|string|size:6',
            'state' => 'required|string|max:20',
            'country' => 'required|string|max:20',
            'mobile_no' => 'required|string|size:10',
            'alternate_mobile_no' => 'nullable|string|size:10',
            'whatsapp' => 'nullable|string|size:10',
            'email' => 'required|email|max:50',
            'aadhaar' => 'required|string|size:12',
        ];

        $checkOtherCourse = DB::table('courses')->select('course_name')->where('id', $request->course_name)->first();

        if ($checkOtherCourse && $checkOtherCourse->course_name == 'Other') {
            // $validationRules['other_course'] = 'required|string';
            $validationRules['other_course'] = [
                'required',
                'string',
                Rule::unique('student_applications', 'other_course')
                    ->where(function ($query) use ($userId) {
                        return $query->where('student_id', $userId);
                    })->ignore(optional($studentApplication)->id),
            ];
        }

        // If passing_state is "Other", add additional validation rules
        if ($payment['passing_state'] == 'Other') {
            $validationRules['council_regn'] = 'required|string';
            $validationRules['noc_council'] = 'required|string';
        }

        $customMessages = [
            'council_regn.required' => 'The State Council Registration Document No. field is required.',
            'noc_council.required' => 'The NOC from the State Council Document No. field is required.',
            'address.required' => 'The Address for Correspondence field is required.',
            'other_course.required' => 'The Other Course Name field is required.',
            'jh_other_college_name' => 'The Name of Other College field is required when Others College is selected.'
        ];

        $validatedData = $request->validate($validationRules, $customMessages);

        StudentApplication::updateOrCreate(
            ['acknowledgment_no' => $studentApplication['acknowledgment_no']],
            [
                'status' => 'pending_documents',      // Set the status
                'course_type' => $validatedData['course_type'],
                'course_id' => $validatedData['course_name'],
                'other_course' => $validatedData['other_course'] ?? null,
                'college_name' => $validatedData['college_name'],
                'jh_other_college_name' => $validatedData['jh_other_college_name'] ?? null,
                'course_registration_no' => $validatedData['course_registration_no'],
                'name' => $validatedData['applicant_name'],
                'guardian_type' => $validatedData['guardian_type'],
                'father_name' => $validatedData['fathers_name'],
                'gender' => $validatedData['gender'],
                'category' => $validatedData['category'],
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'pin_code' => $validatedData['pin'],
                'state' => $validatedData['state'],
                'country' => $validatedData['country'],
                'mobile_no' => $validatedData['mobile_no'],
                'alternate_mobile_no' => $validatedData['alternate_mobile_no'],
                'whatsapp_no' => $validatedData['whatsapp'],
                'email' => $validatedData['email'],
                'aadhaar' => $validatedData['aadhaar'],
                'noc_state_council' => $validatedData['noc_council'] ?? null,
                'council_regn_no' => $validatedData['council_regn'] ?? null,
            ]
        );
    }
    private function validateUploadDocuments(Request $request)
    {
        $request->validate([
            'documents.*' => 'required|file|mimes:jpeg,png,pdf',
        ]);
    }
    public function uploadSingle(Request $request)
    {
        switch ($request->input('field_name')) {
            case 'applicant_photo':
                $request->validate([
                    'documents.*' => 'required|file|mimes:jpeg,jpg|max:100',
                ]);
                break;
            case 'applicant_signature':
                $request->validate([
                    'documents.*' => 'required|file|mimes:jpeg,jpg|max:50',
                ]);
                break;
            // case 'attested_applicant_photo':
            //     $request->validate([
            //         'documents.*' => 'required|file|mimes:jpeg,jpg|max:200',
            //     ]);
            //     break;
            case 'aadhaar_card':
                $request->validate([
                    'documents.*' => 'required|file|mimes:jpeg,jpg|max:200',
                ]);
                break;
            default:
                $request->validate([
                    'documents.*' => 'required|file|mimes:jpeg,jpg|max:250',
                ]);
                break;
        }


        $userId = auth()->id();

        $studentApplication = StudentApplication::where('student_id', $userId)->latest()->first();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fieldName = $request->input('field_name');

            $yearMonth = date('ym');
            $folderPath = "uploads/{$yearMonth}/{$fieldName}/";
            $fileName = $studentApplication->acknowledgment_no . '.' . $file->getClientOriginalExtension();

            // Move the file to the desired directory
            if ($file->move(public_path($folderPath), $fileName)) {
                // Save file path in the database
                $docFileName = "$folderPath$fileName";

                UploadedDocument::updateOrCreate(
                    ['student_application_id' => $studentApplication->id, 'document_name' => $fieldName],
                    ['document_path' => $docFileName]
                );

                return response()->json(['success' => true, 'file_path' => asset($docFileName)], 200);
            } else {
                return response()->json(['error' => false, 'message' => 'File Not uploaded']);
            }
        }

        return response()->json(['error' => false, 'message' => 'No file uploaded']);
    }

    private function saveUploadDocuments(Request $request)
    {
        $stuApp = $this->getStudentApplication();

        $payment = $this->getStudentPayment()['payment'];

        // 10th or 12th
        $isc_mat = ($stuApp['course_type'] == 'Certificate') ? 'tenth_certificate' : 'twelfth_certificate';

        // Caste Certificate
        $caste = '';
        if (auth()->user()->category == 'SC' || auth()->user()->category == 'ST') {
            $caste = 'caste_certificate';
        }

        // Admit Card/ Marksheet
        $admit_cards = [];
        $marksheets = [];

        switch ($stuApp['course_type']) {
            case 'Certificate':
                $admit_cards[] = 'admit_card_1';
                $marksheets[] = 'marksheet_1';
                break;
            case 'Diploma':
                // $admit_cards = ['admit_card_1', 'admit_card_2'];
                // $marksheets = ['marksheet_1', 'marksheet_2'];
                $admit_cards[] = 'admit_card_1';
                $marksheets[] = 'marksheet_1';
                break;
            default:
                $admit_cards = ['admit_card_1', 'admit_card_2', 'admit_card_3'];
                $marksheets = ['marksheet_1', 'marksheet_2', 'marksheet_3'];
                break;
        }

        // Passing State
        $passState = [];
        // Passing State check
        if ($payment['passing_state'] == 'Other') {
            $passState = ['state_council_noc', 'state_council_registration'];
        }

        // List of mandatory files to check
        $mandatoryFiles = array_merge(
            ['applicant_photo', 'applicant_signature', 'aadhaar_card', $isc_mat],
            array_filter([$caste]),  // Only include caste if it's set
            $passState,
            $admit_cards,
            $marksheets,
            ['provisional_1', 'last_issued_certificate']
        );

        // Define validation rules
        $validationRules = [];

        // Get uploaded documents for the student
        $uploadedDocuments = $this->getStudentDocuments();

        // Loop through each mandatory file
        foreach ($mandatoryFiles as $file) {
            // Flag to check if the document exists
            $exists = false;

            // Loop through each uploaded document to check if the file exists
            foreach ($uploadedDocuments as $document) {
                if ($document->document_name === $file) {
                    $exists = true;
                    break; // Break the loop once the file is found
                }
            }
            // If the file doesn't exist in the table, make it required
            if (!$exists) {
                $validationRules[$file] = 'required';
            }
        }
        // dd($validationRules);
        // Validate the request based on dynamically built rules
        $request->validate($validationRules);

        StudentApplication::updateOrCreate(
            ['acknowledgment_no' => $stuApp->acknowledgment_no],
            [
                'status' => 'review',
            ]
        );
    }

    public function submitApplication(Request $request)
    {
        $request->validate([
            'declaration' => 'accepted',
        ]);

        // Retrieve the student application
        $studentApplication = $this->getStudentApplication();

        // Update the status to 'submitted'
        $studentApplication->update([
            'status' => 'submitted',
            'form-submission-date' => now()
        ]);

        $message = "{$studentApplication['acknowledgment_no']} is your Acknowledgement no. & application under verification.-JSPCRN";

        $mobileNumber = auth()->user()->mobile_no;
        $this->sendSMS($mobileNumber, $message);
        // $this->sendSMS('7979040859', $message);

        return redirect()->route('application-success');
    }
    public function submittedApplication()
    {
        $application = StudentApplication::where('student_id', auth()->id())
            ->where(
                'status',
                'submitted',
            )->latest()->first();
        return view('applicant.dashboard_components.submitted-form', ['acknowledgment_number' => $application['acknowledgment_no'],]);
    }
    public function submitRevertedDocuments(Request $request)
    {

        // Find existing payment record with 'Revert' status
        $existingPayFile = Payment::where('student_application_id', $request->applicant)
            ->where('doc_status', 'Revert')->where('stu_revert_date', null)
            ->first();

        $existingOtherFile = UploadedDocument::where('student_application_id', $request->applicant)
            ->where('status', 'Revert')->where('stu_revert_date', null)
            ->first();

        if (!empty($existingPayFile)) {
            $file = $request->file('payDocs');

            $request->validate([
                'payDocs' => 'required|file|mimes:jpeg,pdf',
            ]);

            if ($existingPayFile) {
                $filePath = $existingPayFile->payment_receipt;

                $folderPath = dirname($filePath) . '/';
                $fileId = pathinfo($filePath, PATHINFO_FILENAME);
                $newFileName = $fileId . '.' . $file->getClientOriginalExtension();

                // Check if the folder exists, create if not
                if (!File::exists(public_path($folderPath))) {
                    File::makeDirectory(public_path($folderPath), 0755, true);
                }

                // Delete the old file if it exists
                if (File::exists(public_path($filePath))) {
                    File::delete(public_path($filePath));
                }

                // Move the uploaded file to the destination folder
                $newFilePath = $folderPath . $newFileName;
                // dd( $request->applicant);
                if ($file->move(public_path($folderPath), $newFileName)) {
                    Payment::updateOrCreate(
                        ['student_application_id' => $request->applicant],
                        [
                            'payment_receipt' => $newFilePath,
                            'stu_revert_date' => now()
                        ]
                    );
                } else {
                    return back()->with('error', 'Failed to move the uploaded file.');
                }
            }

        }

        if (!empty($existingOtherFile)) {
            $documents = $request->file('docs');

            if (empty($documents)) {
                return back()->with('error', 'Reverted Documents are required to Revert Back to Council Office.');
            }

            foreach ($documents as $documentName => $file) {

                $validator = Validator::make($request->all(), [
                    "docs.$documentName" => "required|file|mimes:jpeg,jpg|max:250"
                ]);

                if ($validator->fails()) {
                    return back()->withErrors($validator);
                }

                $existingFile = UploadedDocument::where('student_application_id', $request->applicant)
                    ->where('document_name', $documentName)
                    ->where('status', 'Revert')
                    ->first();

                if ($existingFile) {
                    $filePath = $existingFile->document_path;
                    $folderPath = dirname($filePath) . '/';
                    $fileId = pathinfo($filePath, PATHINFO_FILENAME);
                    $fileName = $fileId . '.' . $file->getClientOriginalExtension();

                    if (file_exists(public_path($filePath))) {
                        unlink(public_path($filePath));
                    }

                    if ($file->move(public_path($folderPath), $fileName)) {
                        $docFileName = "$folderPath$fileName";

                        UploadedDocument::updateOrCreate(
                            ['student_application_id' => $request->applicant, 'document_name' => $documentName],
                            [
                                'document_path' => $docFileName,
                                'stu_revert_date' => now()
                            ]
                        );
                    }
                }
            }
        }
        return back()->with('success', 'Documents Reverted successfully.');
    }
    public function getCoursesByType($id)
    {
        $courses = DB::table('courses')->select('id', 'course_name')->where('type', $id)->get();
        return response()->json(
            [
                'course_names' => $courses,
            ]
        );
    }
    public function getInstitute()
    {
        $institutes = DB::table('institutes')->select('institute_id', 'name')->get();
        return response()->json(
            [
                'institutes' => $institutes,
            ]
        );
    }
    public function getState()
    {
        $states = DB::table('indian_states')->select('id', 'name')->get();
        return response()->json(
            [
                'states' => $states,
            ]
        );
    }
    public function getCheckOtherPassningState()
    {
        $checkOtherPassningState = $this->getStudentPayment();

        if ($checkOtherPassningState['payment']['passing_state'] === 'Other') {
            return response()->json(
                [
                    'status' => true,
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                ]
            );
        }
    }
    public function generateAppPDF($id)
    {
        $application = StudentApplication::where('student_id', auth()->id())
            ->where('acknowledgment_no', $id)
            ->where('status', 'submitted')
            ->join('courses', 'student_applications.course_id', '=', 'courses.id')
            ->leftJoin('institutes', 'student_applications.college_name', '=', 'institutes.institute_id')
            ->select('student_applications.*', 'courses.course_name', 'institutes.name as inst_name')
            ->latest()
            ->first();
        $resState = DB::table('indian_states')->select('name')->where('id', $application['state'])->first();

        $payment = Payment::where('student_application_id', $application['id'])->first();

        $passState = ($payment['passing_state'] == 'Jharkhand') ? "Jharkhand" : DB::table('indian_states')->select('name')->where('id', $payment['other_state'])->first();

        $uploadedDocuments = UploadedDocument::where('student_application_id', $application['id'])->get();

        $certificateHistory = StudentCertificateHistory::where('student_application_id', $application['id'])
            ->orderBy('cert_start_date', 'asc')
            ->get();

        $documentData = [];
        foreach ($uploadedDocuments as $document) {
            $documentData[$document->document_name] = $document;
        }
        $app = [
            'payment' => $payment,
            'studentApplication' => $application,
            'document' => $documentData,
            'resState' => $resState,
            'passState' => $passState,
            'certificateHistory' => $certificateHistory
        ];

        // dd($app['certificateHistory']);
        $pdf = PDF::loadView('applicant.dashboard_components.wizardComponent.application-pdf', compact('app'));

        return $pdf->download("AF_{$application->acknowledgment_no}_{$application->name}.pdf");
    }
    public function generateAckNoPDF($id)
    {
        $application = StudentApplication::where('student_id', auth()->id())
            ->where('acknowledgment_no', $id)
            ->where('status', 'submitted')
            ->join('courses', 'student_applications.course_id', '=', 'courses.id')
            ->leftJoin('institutes', 'student_applications.college_name', '=', 'institutes.institute_id')
            ->select('student_applications.*', 'courses.course_name', 'institutes.name as inst_name')
            ->latest()
            ->first();

        $payment = Payment::where('student_application_id', $application['id'])->first();

        $passState = ($payment['passing_state'] == 'Jharkhand') ? "Jharkhand" : DB::table('indian_states')->select('name')->where('id', $payment['other_state'])->first();

        $uploadedDocuments = UploadedDocument::where('student_application_id', $application['id'])->get();

        $documentData = [];
        foreach ($uploadedDocuments as $document) {
            $documentData[$document->document_name] = $document;
        }
        $app = [
            'payment' => $payment,
            'studentApplication' => $application,
            'document' => $documentData,
            'passState' => $passState
        ];

        $pdf = PDF::loadView('applicant.dashboard_components.wizardComponent.acknowledgement-pdf', compact('app'));

        return $pdf->download("Acknowledgement_Slip_{$application->acknowledgment_no}_{$application->name}.pdf");
    }
    private function sendSMS($mobileNo, $message)
    {
        $baseUrl = url('/');
        $mobileNumbers = ($baseUrl === 'http://127.0.0.1:8000') ? '79790408590' : $mobileNo;

        $postData = [
            'mobileNumbers' => $mobileNumbers,
            'smsContent' => $message,
            'senderId' => env('SMS_SENDER_ID'),
            'routeId' => '1',
            "smsContentType" => 'Unicode'
        ];
        $data_json = json_encode($postData);

        $url = "http://" . env('SMS_SERVER_URL') . "/rest/services/sendSMS/sendGroupSms?AUTH_KEY=" . env('SMS_AUTH_KEY');

        $ch = curl_init();

        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Content-Length: ' . strlen($data_json)],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data_json,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            ]
        );
        //get response
        $output = curl_exec($ch);
        //Print error if any
        if (curl_errno($ch)) {
            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
        return $output;
    }
}
