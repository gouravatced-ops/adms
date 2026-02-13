<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CertificateGeneratedExport;
use App\Http\Controllers\Controller;
use App\Models\AdminDetails;
use App\Models\AdminOtpLogs;
use App\Models\ApprovedApplicants;
use App\Models\StudentRegistration;
use Illuminate\Http\Request;
use App\Models\StudentApplication;
use App\Models\Payment;
use App\Models\StudentCertificateHistory;
use App\Models\UploadedDocument;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AdminRegistrationController extends Controller
{
    public function generateAppPDF($id)
    {
        $application = StudentApplication::where('acknowledgment_no', $id)
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

        $documentData = [];
        foreach ($uploadedDocuments as $document) {
            $documentData[$document->document_name] = $document;
        }
        $app = [
            'payment' => $payment,
            'studentApplication' => $application,
            'document' => $documentData,
            'resState' => $resState,
            'passState' => $passState
        ];

        $pdf = PDF::loadView('applicant.dashboard_components.wizardComponent.application-pdf', compact('app'));

        return $pdf->download("AF_{$application->acknowledgment_no}_{$application->name}.pdf");
    }
    public function generateAckNoPDF($id)
    {
        $application = StudentApplication::where('acknowledgment_no', $id)
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
            // 'course' => $course,
            // 'institutes' => $institutes,
            // 'resState' => $resState,
            'passState' => $passState
        ];

        $pdf = PDF::loadView('applicant.dashboard_components.wizardComponent.acknowledgement-pdf', compact('app'));

        return $pdf->download("Acknowledgement_Slip_{$application->acknowledgment_no}_{$application->name}.pdf");
    }

    public function viewEditApplicantFormDetails($id)
    {
        $application = StudentApplication::where('acknowledgment_no', $id)
            ->where('status', 'submitted')
            ->join('courses', 'student_applications.course_id', '=', 'courses.id')
            ->join('student_registrations', 'student_applications.student_id', '=', 'student_registrations.id')
            ->leftJoin('institutes', 'student_applications.college_name', '=', 'institutes.institute_id')
            ->select('student_applications.*', 'courses.course_name', 'institutes.name as inst_name', 'student_registrations.category')
            ->latest()
            ->first();

        $payment = Payment::where('student_application_id', $application['id'])->first();

        $uploadedDocuments = UploadedDocument::where('student_application_id', $application['id'])->get();

        // $data = [];
        foreach ($uploadedDocuments as $document) {
            $data[$document->document_name] = $document;
        }

        return view('admin.modules.applicant-registration.show-edit-applicant-form-details', compact('application', 'payment', 'data'));

    }

    public function viewApplicantRegistration(Request $request)
    {
        // Fetch all admins with their details
        $applicant = StudentRegistration::get();

        // Pass the data to the view
        return view('admin.modules.applicant-registration.show-registered-applicant', compact('applicant'));
    }

    public function editApplicantRegistration(Request $request, $id)
    {
        // dd($id);
        $request->validate([
            'name' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female,Other',
            'category' => 'required|in:General,OBC,SC,ST',
            'aadhaar_no' => [
                'required',
                'string',
                'size:12',
                Rule::unique('student_registrations', 'aadhaar_no')->ignore($id), // Unique constraint
                function ($attribute, $value, $fail) {
                    // Regex for detecting repeating digits (e.g., 111111111111)
                    if (preg_match('/^(\d)\1{11}$/', $value)) {
                        $fail('The :attribute cannot be a repeating number.');
                    }
                    // Regex for detecting alternating patterns (e.g., 121212121212)
                    elseif (preg_match('/^(\d)(\d)\1\2\1\2\1\2\1\2\1\2$/', $value)) {
                        $fail('The :attribute cannot be an alternating pattern.');
                    }
                }
            ],

            'mobile_no' => [
                'required',
                'string',
                'size:10',
                Rule::unique('student_registrations', 'mobile_no')->ignore($id), // Unique constraint ignoring the current record
            ],
            'date_of_birth' => 'required',
            'date',
            'before_or_equal:' . now()->subYears(14)->format('Y-m-d'),
        ]);

        StudentRegistration::updateOrCreate(
            ['id' => $id],
            [
                'name' => $request->name,
                'gender' => $request->gender,
                'category' => $request->category,
                'aadhaar_no' => $request->aadhaar_no,
                'date_of_birth' => $request->date_of_birth,
                'mobile_no' => $request->mobile_no,
            ]
        );

        StudentApplication::where('student_id', $id)->update(['name' => $request->name]);


        back()->with('success', 'Applicant updated successfully!');
        return response()->json([
            'message' => 'Applicant updated successfully!',

        ], 201);
    }

    public function showPendingRegistrationForm()
    {
        $regisStuList = StudentApplication::query()
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "pending")
            ->where("uploaded_documents.document_name", 'applicant_photo')
            ->select('student_applications.name', 'student_applications.acknowledgment_no', 'student_applications.course_type', 'student_applications.other_course', 'payments.passing_state', 'student_applications.college_name', 'student_applications.jh_other_college_name', 'uploaded_documents.document_path', 'institutes.name as institute_name', "courses.course_name", "indian_states.name as state_name")
            ->get();

        return view("admin.modules.applicant-registration.show-pending-applicant", compact("regisStuList"));
    }
    public function showIncompleteRegistrationForm()
    {
        $regisStuList = StudentApplication::query()
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "incomplete")
            // ->where("uploaded_documents.status", "Revert")
            ->select(
                'student_applications.id', // Including id for grouping
                'student_applications.name',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'payments.passing_state',
                'student_applications.college_name',
                'institutes.name as institute_name',
                'courses.course_name',
                'student_applications.jh_other_college_name',
                'indian_states.name as state_name',
                DB::raw("GROUP_CONCAT(DISTINCT uploaded_documents.stu_revert_date SEPARATOR ', ') AS stu_revert_date"),

                // 'uploaded_documents.stu_revert_date',
                // DB::raw("GROUP_CONCAT(uploaded_documents.document_name SEPARATOR ', ') AS doc_names") // Concatenate documents
                DB::raw("
                    GROUP_CONCAT(
                        CASE
                            WHEN uploaded_documents.status = 'Revert' THEN uploaded_documents.document_name
                            ELSE NULL
                        END
                        SEPARATOR ', '
                    ) AS doc_names "),

                DB::raw("
                    GROUP_CONCAT(
                        CASE
                            WHEN payments.doc_status = 'Revert' THEN 'payment_receipt'
                            ELSE NULL
                        END
                        SEPARATOR ', '
                    ) AS pay_revert "),
            )
            ->groupBy(
                'student_applications.id',  // Grouping by unique student_application fields
                'student_applications.name',
                // 'uploaded_documents.stu_revert_date',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'student_applications.jh_other_college_name',
                'payments.passing_state',
                'student_applications.college_name',
                'institutes.name',
                'courses.course_name',
                'indian_states.name'
            )
            ->get();
        // ->toSql();

        // $sql = $query->toSql();

        // Output the SQL query
        // die($regisStuList);
        return view("admin.modules.applicant-registration.show-incomplete-applicant", compact("regisStuList"));
    }
    public function showAcceptedRegistrationForm()
    {
        $regisStuList = StudentApplication::query()
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->join("admins", "admins.id", "=", "student_applications.auth_id")
            ->join("admin_details", "admin_details.id", "=", "admins.admin_details_id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "accept")
            ->where("uploaded_documents.document_name", "applicant_photo")
            ->select(
                'student_applications.id', // Including id for grouping
                'student_applications.name',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'student_applications.accepted_datetime',
                'payments.passing_state',
                'admin_details.name as user',
                'student_applications.jh_other_college_name',
                'student_applications.college_name',
                'institutes.name as institute_name',
                'courses.course_name',
                'indian_states.name as state_name',
                'uploaded_documents.stu_revert_date',
                DB::raw("GROUP_CONCAT(uploaded_documents.document_name SEPARATOR ', ') AS doc_names") // Concatenate documents
            )
            ->groupBy(
                'admin_details.name',
                'student_applications.accepted_datetime',
                'student_applications.id',  // Grouping by unique student_application fields
                'student_applications.name',
                'student_applications.jh_other_college_name',
                'uploaded_documents.stu_revert_date',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'payments.passing_state',
                'student_applications.college_name',
                'institutes.name',
                'courses.course_name',
                'indian_states.name'
            )
            ->get();
        return view("admin.modules.applicant-registration.show-accepted-applicant", compact("regisStuList"));
    }

    public function showCouncilAcceptedRegistrationForm()
    {
        $regisStuList = StudentApplication::query()
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->join("admins", "admins.id", "=", "student_applications.auth_id")
            ->join("admin_details", "admin_details.id", "=", "admins.admin_details_id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "accept")
            ->where("uploaded_documents.document_name", "applicant_photo")
            ->select(
                'student_applications.id', // Including id for grouping
                'student_applications.name',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'student_applications.accepted_datetime',
                'payments.passing_state',
                'admin_details.name as user',
                'student_applications.jh_other_college_name',
                'student_applications.college_name',
                'institutes.name as institute_name',
                'courses.course_name',
                'indian_states.name as state_name',
            )
            ->groupBy(
                'admin_details.name',
                'student_applications.accepted_datetime',
                'student_applications.id',  // Grouping by unique student_application fields
                'student_applications.name',
                'student_applications.jh_other_college_name',
                'uploaded_documents.stu_revert_date',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'payments.passing_state',
                'student_applications.college_name',
                'institutes.name',
                'courses.course_name',
                'indian_states.name'
            )
            ->get();
        return view("admin.modules.registar.show-council-accepted-applicant", compact("regisStuList"));
    }

    public function showRegistarRejectedRegistrationForm()
    {
        $regisStuList = StudentApplication::query()
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->join("admins", "admins.id", "=", "student_applications.auth_id")
            ->join("admin_details", "admin_details.id", "=", "admins.admin_details_id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "reject")
            ->where("student_applications.auth", "registar")
            ->where("uploaded_documents.document_name", "applicant_photo")
            ->select(
                'student_applications.id', // Including id for grouping
                'student_applications.name',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'student_applications.auth_action_date',
                'student_applications.auth_reject_reason',
                'student_applications.jh_other_college_name',
                'student_applications.auth_status',
                'payments.passing_state',
                'admin_details.name as user',
                'student_applications.college_name',
                'institutes.name as institute_name',
                'courses.course_name',
                'indian_states.name as state_name',
                'uploaded_documents.stu_revert_date',
                DB::raw("GROUP_CONCAT(uploaded_documents.document_name SEPARATOR ', ') AS doc_names") // Concatenate documents
            )
            ->groupBy(
                'admin_details.name',
                'student_applications.id',  // Grouping by unique student_application fields
                'student_applications.name',
                'student_applications.auth_action_date',
                'student_applications.auth_reject_reason',
                'student_applications.auth_status',
                'student_applications.jh_other_college_name',
                'uploaded_documents.stu_revert_date',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'payments.passing_state',
                'student_applications.college_name',
                'institutes.name',
                'courses.course_name',
                'indian_states.name'
            )
            ->get();

        return view("admin.modules.applicant-registration.show-rejected-applicant", compact("regisStuList"));
    }

    public function showRejectedRegistrationForm()
    {
        $regisStuList = StudentApplication::query()
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->join("admins", "admins.id", "=", "student_applications.auth_id")
            ->join("admin_details", "admin_details.id", "=", "admins.admin_details_id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "reject")
            ->where("uploaded_documents.document_name", "applicant_photo")
            ->select(
                'student_applications.id', // Including id for grouping
                'student_applications.name',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'student_applications.auth_action_date',
                'student_applications.auth_reject_reason',
                'student_applications.jh_other_college_name',
                'payments.passing_state',
                'admin_details.name as user',
                'student_applications.college_name',
                'institutes.name as institute_name',
                'courses.course_name',
                'indian_states.name as state_name',
                'uploaded_documents.stu_revert_date',
                DB::raw("GROUP_CONCAT(uploaded_documents.document_name SEPARATOR ', ') AS doc_names") // Concatenate documents
            )
            ->groupBy(
                'admin_details.name',
                'student_applications.id',  // Grouping by unique student_application fields
                'student_applications.name',
                'student_applications.auth_action_date',
                'student_applications.auth_reject_reason',
                'student_applications.jh_other_college_name',
                'uploaded_documents.stu_revert_date',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'payments.passing_state',
                'student_applications.college_name',
                'institutes.name',
                'courses.course_name',
                'indian_states.name'
            )
            ->get();
        return view("admin.modules.applicant-registration.show-rejected-applicant", compact("regisStuList"));
    }

    public function showRejectedCouncilRegistrationForm()
    {
        $regisStuList = StudentApplication::query()
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->join("admins", "admins.id", "=", "student_applications.auth_id")
            ->join("admin_details", "admin_details.id", "=", "admins.admin_details_id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "reject")
            ->where("student_applications.auth", "council_office")
            ->where("uploaded_documents.document_name", "applicant_photo")
            ->select(
                'student_applications.id', // Including id for grouping
                'student_applications.name',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'student_applications.auth_action_date',
                'student_applications.auth_reject_reason',
                'student_applications.jh_other_college_name',
                'payments.passing_state',
                'admin_details.name as user',
                'student_applications.college_name',
                'institutes.name as institute_name',
                'courses.course_name',
                'indian_states.name as state_name',
                'uploaded_documents.stu_revert_date',
                DB::raw("GROUP_CONCAT(uploaded_documents.document_name SEPARATOR ', ') AS doc_names") // Concatenate documents
            )
            ->groupBy(
                'admin_details.name',
                'student_applications.id',  // Grouping by unique student_application fields
                'student_applications.name',
                'student_applications.auth_action_date',
                'student_applications.auth_reject_reason',
                'student_applications.jh_other_college_name',
                'uploaded_documents.stu_revert_date',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'payments.passing_state',
                'student_applications.college_name',
                'institutes.name',
                'courses.course_name',
                'indian_states.name'
            )
            ->get();
        return view("admin.modules.applicant-registration.show-rejected-applicant", compact("regisStuList"));
    }
    public function getApplicantDetail($id)
    {
        $applicantApplication = StudentApplication::query()
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->leftJoin('indian_states as res_state', 'res_state.id', '=', 'student_applications.state')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "pending")
            ->where("student_applications.acknowledgment_no", (string) $id)
            ->select('student_applications.*', 'student_applications.id as app_id', 'payments.*', 'uploaded_documents.*', 'institutes.name as institute_name', "courses.course_name", "indian_states.name as pay_other_state_name", "res_state.name as res_other_state_name")
            ->get();

        $certificateHistory = StudentCertificateHistory::where('student_application_id', $applicantApplication[0]['app_id'])->get();

        $prevApplications = StudentRegistration::query()
            ->join("student_applications", "student_applications.student_id", "=", "student_registrations.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("approved_applicants", "approved_applicants.student_application_id", "=", "student_applications.id")
            ->where("student_registrations.id", $applicantApplication[0]['student_id'])
            ->where("student_applications.acknowledgment_no", "<>", (string) $id)
            ->select("student_applications.*", "payments.*", "approved_applicants.alloted_regn_no", "approved_applicants.alloted_regn_no", "courses.course_name")
            ->get();

        return view("admin.modules.applicant-registration.show-applicant-details", compact("applicantApplication", "certificateHistory", "prevApplications"));

    }
    public function getAcceptedApplicantDetail($id)
    {
        $applicantApplication = StudentApplication::query()
            ->join("student_registrations", "student_applications.student_id", "=", "student_registrations.id")
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->leftJoin('indian_states as res_state', 'res_state.id', '=', 'student_applications.state')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "accept")
            ->where("student_applications.acknowledgment_no", (string) $id)
            ->select('student_applications.*', 'student_applications.id as app_id', 'payments.*', 'student_registrations.date_of_birth', 'uploaded_documents.*', 'institutes.name as institute_name', "courses.course_name", "indian_states.name as pay_other_state_name", "res_state.name as res_other_state_name")
            ->get();

        $certificateHistory = StudentCertificateHistory::where('student_application_id', $applicantApplication[0]->app_id)->get();

        $prevApplications = StudentRegistration::query()
            ->join("student_applications", "student_applications.student_id", "=", "student_registrations.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("approved_applicants", "approved_applicants.student_application_id", "=", "student_applications.id")
            ->where("student_registrations.id", $applicantApplication[0]['student_id'])
            ->where("student_applications.acknowledgment_no", "<>", (string) $id)
            ->select("student_applications.*", "payments.*", "approved_applicants.alloted_regn_no", "approved_applicants.alloted_regn_no", "courses.course_name")
            ->get();

        return view("admin.modules.registar.show-applicant-details", compact("applicantApplication", "certificateHistory", "prevApplications"));

    }

    public function getIncompleteApplicantDetail($id)
    {
        $applicantApplication = StudentApplication::query()
            ->join("student_registrations", "student_applications.student_id", "=", "student_registrations.id")
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->leftJoin('indian_states as res_state', 'res_state.id', '=', 'student_applications.state')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "incomplete")
            ->where("student_applications.acknowledgment_no", (string) $id)
            ->select('student_applications.*', 'student_applications.id as app_id', 'payments.*', 'date_of_birth', 'uploaded_documents.*', 'institutes.name as institute_name', "courses.course_name", "indian_states.name as pay_other_state_name", "res_state.name as res_other_state_name")
            ->get();

        $certificateHistory = StudentCertificateHistory::where('student_application_id', $applicantApplication[0]->app_id)->get();

        $prevApplications = StudentRegistration::query()
            ->join("student_applications", "student_applications.student_id", "=", "student_registrations.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("approved_applicants", "approved_applicants.student_application_id", "=", "student_applications.id")
            ->where("student_registrations.id", $applicantApplication[0]['student_id'])
            ->where("student_applications.acknowledgment_no", "<>", (string) $id)
            ->select("student_applications.*", "payments.*", "approved_applicants.alloted_regn_no", "approved_applicants.alloted_regn_no", "courses.course_name")
            ->get();

        return view("admin.modules.applicant-registration.show-incomplete-applicant-details", compact("applicantApplication", "prevApplications", "certificateHistory"));

    }
    public function submitIncompleteReason(Request $request)
    {
        $this->validate($request, [
            'reason' => 'required|string',
            'ack_no' => 'numeric|required',
            'document_name' => 'string|required'
        ]);

        $uploadedDocument = UploadedDocument::join('student_applications', 'uploaded_documents.student_application_id', '=', 'student_applications.id')
            ->where('student_applications.acknowledgment_no', $request->ack_no)
            ->where('uploaded_documents.document_name', $request->document_name)
            ->where('student_applications.status', '=', 'submitted')
            ->select('uploaded_documents.*')
            ->latest()
            ->first();

        if ($uploadedDocument) {
            $uploadedDocument->status = 'Revert';
            $uploadedDocument->reason = $request->reason;
            $uploadedDocument->stu_revert_date = null;
            $uploadedDocument->auth_id = auth('admin')->user()->id;
            $uploadedDocument->save();

            return response()->json(['success' => 'Document marked incomplete'], 200);
        } else {
            return response()->json(['error' => 'Document not found'], 404);
        }
    }

    public function acceptDocuments(Request $request)
    {
        $this->validate($request, [
            'ack_no' => 'numeric|required',
            'document_name' => 'string|required'
        ]);

        $uploadedDocument = UploadedDocument::join('student_applications', 'uploaded_documents.student_application_id', '=', 'student_applications.id')
            ->where('student_applications.acknowledgment_no', $request->ack_no)
            ->where('uploaded_documents.document_name', $request->document_name)
            ->where('student_applications.status', '=', 'submitted')
            ->select('uploaded_documents.*')
            ->latest()
            ->first();

        if ($uploadedDocument) {
            $uploadedDocument->status = 'Accept';
            $uploadedDocument->auth_id = auth('admin')->user()->id;
            $uploadedDocument->actionDate = now();
            $uploadedDocument->reason = null;
            $uploadedDocument->save();

            return response()->json(['success' => 'Document marked Accept'], 200);
        } else {
            return response()->json(['error' => 'Document not found'], 404);
        }
    }

    public function submitPaymentAction(Request $request)
    {
        if (isset($request->reason_pay)) {
            $this->validate($request, [
                'reason_pay' => 'required|string',
                'ack_no' => 'numeric|required',
                'document_name' => 'string|required'
            ]);
            $doc_status = 'Revert';
        } else {
            $this->validate($request, [
                'ack_no' => 'numeric|required',
                'document_name' => 'string|required'
            ]);
            $doc_status = 'Accept';
        }

        $paymentDoc = Payment::join('student_applications', 'payments.student_application_id', '=', 'student_applications.id')
            ->where('student_applications.acknowledgment_no', $request->ack_no)
            ->where('student_applications.status', '=', 'submitted')
            ->select('payments.*')
            ->latest()
            ->first();

        if ($paymentDoc) {
            $paymentDoc->doc_status = $doc_status;
            $paymentDoc->revert_by = auth('admin')->user()->id;
            $paymentDoc->revert_reason = $request->reason_pay ?? null;
            $paymentDoc->stu_revert_date = $request->reason_pay ? null : $paymentDoc->stu_revert_date;
            $paymentDoc->actionDate = now();
            $paymentDoc->save();
            if ($doc_status == 'Accept') {
                return back()->with('success', 'Payment Document Marked Accept successful!');
            } else {
                return back()->with('success', 'Payment Document Marked Revert successful!');
            }
        } else {
            return response()->json(['error' => 'Document not found'], 404);
        }
    }

    public function applicationChangeStatus(Request $request)
    {
        $stuApp = StudentApplication::where('acknowledgment_no', $request->ack_no)
            ->where('status', '=', 'submitted')
            ->latest()
            ->first();
        if ($request->has('verified')) {

            if ($stuApp) {
                $message = "Dear {$stuApp->name}, your application is accepted.-JSPCRN";
                $this->sendSMS($stuApp->mobile_no, $message);
                // $this->sendSMS('7979040859', $message);

                $stuApp->auth_status = 'accept';
                $stuApp->auth_id = auth('admin')->user()->id;
                $stuApp->auth = auth('admin')->user()->role;
                $stuApp->accepted_datetime = now();
                $stuApp->save();
            }
        } elseif ($request->has('incompleteBtn')) {
            if ($stuApp) {

                $message = "Dear {$stuApp->name}, your application is incomplete, please login your account-JSPCRN";
                $this->sendSMS($stuApp->mobile_no, $message);
                // $this->sendSMS('7979040859', $message);

                $stuApp->auth_status = 'incomplete';
                $stuApp->auth_id = auth('admin')->user()->id;
                $stuApp->auth = auth('admin')->user()->role;
                $stuApp->auth_action_date = now();
                $stuApp->save();
            }
        } elseif ($request->has('rejectBtn')) {
            $this->validate($request, [
                'reject_reason' => 'string|required'
            ]);

            if ($stuApp) {
                $message = "Dear {$stuApp->name}, your application is rejected.-JSPCRN";
                $this->sendSMS($stuApp->mobile_no, $message);
                // $this->sendSMS('7979040859', $message);

                $stuApp->auth_status = 'reject';
                $stuApp->auth_id = auth('admin')->user()->id;
                $stuApp->auth = auth('admin')->user()->role;
                $stuApp->auth_action_date = now();
                $stuApp->auth_reject_reason = $request->reject_reason;
                $stuApp->save();
            }
        }
        return redirect()->route('view.pending-registration')->with('success', 'Application status updated successfully!');
    }

    public function applicationChangeStatusByRegistar(Request $request)
    {
        $stuApp = StudentApplication::where('acknowledgment_no', $request->ack_no)
            ->where('status', '=', 'submitted')
            ->latest()
            ->first();
        if ($request->has('verified')) {

            if ($stuApp) {
                $stuApp->auth_status = 'approved';
                $stuApp->auth_id = auth('admin')->user()->id;
                $stuApp->auth = auth('admin')->user()->role;
                $stuApp->approved_date = now();
                $stuApp->save();
            }
        } elseif ($request->has('rejectBtn')) {
            $this->validate($request, [
                'reject_reason' => 'string|required'
            ]);

            if ($stuApp) {
                $message = "Dear {$stuApp->name}, your application is rejected.-JSPCRN";
                $this->sendSMS($stuApp->mobile_no, $message);
                // $this->sendSMS('7979040859', $message);

                $stuApp->auth_status = 'reject';
                $stuApp->auth_id = auth('admin')->user()->id;
                $stuApp->auth = auth('admin')->user()->role;
                $stuApp->auth_action_date = now();
                $stuApp->auth_reject_reason = $request->reject_reason;
                $stuApp->save();
            }
        }
        return redirect()->route('view.registar.pending-forms')->with('success', 'Application status updated successfully!');
    }

    public function showCouncilApprovedRegistrationForm(Request $request)
    {
        $approvedStudentIds = ApprovedApplicants::where('certificate_path', '<>', null)->pluck('student_application_id');

        $approvedApplicantApplication = StudentApplication::query()
            ->join("student_certificate_histories", function ($join) {
                $join->on("student_certificate_histories.student_application_id", '=', "student_applications.id")
                    ->whereRaw('student_certificate_histories.id =(
                        SELECT id FROM student_certificate_histories
                        WHERE student_application_id = student_applications.id
                        ORDER BY cert_expiry_date DESC
                        LIMIT 1
                    )');
            })
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->join("admins", "admins.id", "=", "student_applications.auth_id")
            ->join("admin_details", "admin_details.id", "=", "admins.admin_details_id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->leftJoin('approved_applicants', 'approved_applicants.student_application_id', '=', 'student_applications.id')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "approved")
            ->whereNotIn('student_applications.id', $approvedStudentIds)
            ->where("uploaded_documents.document_name", "applicant_photo")
            ->select(
                'student_applications.id', // Including id for grouping
                'student_applications.name',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'student_applications.approved_date',
                'payments.passing_state',
                'admin_details.name as user',
                'student_applications.jh_other_college_name',
                'student_applications.college_name',
                'institutes.name as institute_name',
                'courses.course_name',
                'approved_applicants.certificate_path',
                'approved_applicants.created_at',
                'indian_states.name as state_name',
                'student_certificate_histories.cert_start_date',
                'student_certificate_histories.cert_expiry_date',
                'uploaded_documents.document_path'
            )
            ->groupBy(
                'admin_details.name',
                'student_applications.approved_date',
                'student_applications.id',  // Grouping by unique student_application fields
                'student_applications.name',
                'student_applications.jh_other_college_name',
                'uploaded_documents.stu_revert_date',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'payments.passing_state',
                'student_applications.college_name',
                'institutes.name',
                'courses.course_name',
                'indian_states.name',
                'approved_applicants.certificate_path',
                'approved_applicants.created_at',
                'student_certificate_histories.cert_start_date',
                'student_certificate_histories.cert_expiry_date',
                 'uploaded_documents.document_path'
            )
            ->get();

        return view("admin.modules.registar.show-registar-approved-applicants", compact("approvedApplicantApplication"));

    }

    public function generateCertificate(Request $request)
    {
        $mobileNumber = auth('admin')->user()->mobile_no;

        $otpLog = AdminOtpLogs::where('mobile_number', $mobileNumber)
            ->where('status', 'verified')
            ->where('description', $request->stu_app_id)
            ->latest('id')
            ->first();

        if ($otpLog) {

            $checkFirstHistory = StudentCertificateHistory::where('student_application_id', $request->stu_app_id)->first();

            $checkLatestHistory = StudentCertificateHistory::where('student_application_id', $request->stu_app_id)->latest('cert_expiry_date')->first();

            $getStartDate = ($checkFirstHistory['cert_start_date'] === $checkLatestHistory['cert_start_date']) ? date('d-m', strtotime($checkFirstHistory['cert_start_date'])) . '-' . date('Y', strtotime($checkFirstHistory['cert_expiry_date'])) : date('d-m', strtotime($checkLatestHistory['cert_start_date'])) . '-' . date('Y', strtotime($checkLatestHistory['cert_expiry_date']));

            $latestDiff = date('Y') - date('Y', strtotime($checkLatestHistory['cert_expiry_date']));

            $noOfCertificate = $latestDiff == 0 ? 1 : ceil($latestDiff / 5);

            // dd($getStartDate);

            for ($n = 0; $n < $noOfCertificate; $n++) {

                $getStartDate;

                $expiryDate = \Carbon\Carbon::parse($getStartDate)
                    ->addYears(5)
                    ->subDay()
                    ->format('d-m-Y');

                $existingApprStudentCertificate = ApprovedApplicants::where('allotted_certificate_no', $request->stu_app_id)->first();

                // dd($existingApprStudentCertificate['allotted_certificate_no']);

                do {
                    // Gwnerate a random 16-digit certificate number
                    $certificateNo = sprintf(mt_rand(1000000000000000, 9999999999999999));

                    // Check if this certificate number already exists in the database
                    $existingCertificate = ApprovedApplicants::where('allotted_certificate_no', $certificateNo)->first();

                } while ($existingCertificate);  // Keep generating a new number until it's unique

                $certificateNo;

                $stuApp = StudentApplication::where("student_applications.id", $request->stu_app_id)
                    ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
                    ->join("payments", "payments.student_application_id", "=", "student_applications.id")
                    ->join("courses", "courses.id", "=", "student_applications.course_id")
                    ->join("indian_states", "indian_states.id", "=", "student_applications.state")
                    ->leftJoin("indian_states as ins", "ins.id", "=", "payments.other_state")

                    ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
                    ->whereIn('uploaded_documents.document_name', ['applicant_photo', 'applicant_signature'])
                    ->select(
                        'student_applications.name',
                        'student_applications.father_name',
                        'student_applications.course_type',
                        'student_applications.pin_code',
                        'institutes.code as inst_code',
                        'courses.code as course_code',
                        'student_applications.name',
                        'student_applications.city',
                        'indian_states.name as state',
                        'ins.name as other_passing_state',
                        'payments.passing_state',
                        'payments.registration_no',
                        'student_applications.college_name',
                        'student_applications.jh_other_college_name',
                        'institutes.name as inst_college_name',
                        'institutes.address as inst_addr',
                        'institutes.city as inst_city',
                        'student_applications.other_course',
                        'student_applications.address',
                        'uploaded_documents.document_path',
                        'courses.course_name as course'
                    )
                    ->orderBy("uploaded_documents.document_name", "asc")
                    ->get();

                if ($stuApp[0]->passing_state == 'Other') {
                    $college = ucfirst(trans($stuApp[0]->college_name)) . ', ' . ucfirst(trans($stuApp[0]->other_passing_state));
                } else {
                    $college = ($stuApp[0]->college_name == '999' ? ucfirst(trans($stuApp[0]->jh_other_college_name)) : ucfirst(trans($stuApp[0]->inst_college_name)) . ', ' . ucfirst(trans($stuApp[0]->inst_city)));
                }

                if ($existingApprStudentCertificate) {

                    $dateString = trim($existingApprStudentCertificate['certficate_valid_from_date']);

                    $certificateNo = $existingApprStudentCertificate['allotted_certificate_no'];
                    $registrationNo = $stuApp[0]->registration_no;

                    $userDetails = [
                        'certificate' => $certificateNo,
                        'registration' => $registrationNo,
                        'name' => $stuApp[0]->name,
                        'guardian_type' => $stuApp[0]->guardian_type,
                        'father_name' => $stuApp[0]->father_name,
                        'appl_photo' => $stuApp[0]->document_path,
                        'appl_sign' => $stuApp[1]->document_path,
                        'address' => $stuApp[0]->address,
                        'city' => $stuApp[0]->city,
                        'state' => $stuApp[0]->state,
                        'pin_code' => $stuApp[0]->pin_code,
                        'other_passing_state' => $stuApp[0]->pass_state,
                        'qualification' => $stuApp[0]->course == 'Other' ? $stuApp[0]->other_course : $stuApp[0]->course,
                        'course_type' => $stuApp[0]->course_type,
                        // 'college' => $stuApp[0]->college_name == '999' ? ucfirst(trans($stuApp[0]->jh_other_college_name)) : ucfirst(trans($stuApp[0]->inst_college_name)) . ', ' . ucfirst(trans($stuApp[0]->inst_city)),
                        'college' => $college,
                        'validity_from' => \Carbon\Carbon::parse($existingApprStudentCertificate['certficate_valid_from_date'])->format('d-m-Y'),
                        'validity_to' => \Carbon\Carbon::parse($existingApprStudentCertificate['certficate_valid_from_date'])->addYears(5)->subDay()->format('d-m-Y'),

                        // 'validity_from' => \Carbon\Carbon::now()->format('d-m-Y'),
                        // 'validity_to' => \Carbon\Carbon::now()->addYears(5)->subDay()->format('d-m-Y')
                    ];
                } else {
                    if (count($stuApp) > 0) {

                        $registrationNo = $stuApp[0]->registration_no;

                        $userDetails = [
                            'certificate' => $certificateNo,
                            'registration' => $registrationNo,
                            'name' => $stuApp[0]->name,
                            'guardian_type' => $stuApp[0]->guardian_type,
                            'father_name' => $stuApp[0]->father_name,
                            'appl_photo' => $stuApp[0]->document_path,
                            'appl_sign' => $stuApp[1]->document_path,
                            'address' => $stuApp[0]->address,
                            'city' => $stuApp[0]->city,
                            'state' => $stuApp[0]->state,
                            'pin_code' => $stuApp[0]->pin_code,
                            'qualification' => $stuApp[0]->course == 'Other' ? $stuApp[0]->other_course : $stuApp[0]->course,
                            'course_type' => $stuApp[0]->course_type,
                            // 'college' => $stuApp[0]->college_name == '999' ? ucfirst(trans($stuApp[0]->jh_other_college_name)).', '.ucfirst(trans($stuApp[0]->pass_state)) : ucfirst(trans($stuApp[0]->inst_college_name)).', '. ucfirst(trans($stuApp[0]->inst_addr)) .', '. ucfirst(trans($stuApp[0]->inst_city)),
                            // 'college' => ($stuApp[0]->college_name == '999' ? ucfirst(trans($stuApp[0]->jh_other_college_name)) : ucfirst(trans($stuApp[0]->inst_college_name))) . ', ' . ucfirst(trans($stuApp[0]->inst_city)),
                            'college' => $college,
                            'validity_from' => $getStartDate,
                            'validity_to' => $expiryDate
                        ];
                    }
                }

                // Generate the PDF file name

                $fileName = "Certificate_$certificateNo.pdf";

                // Get current year and month for folder path
                $yearMonth = date('ym');

                // Define folder path in the public directory
                $folderPath = "admin_uploads/{$yearMonth}/sys_certificate_generated/";

                // Ensure the directory exists (create it if not)
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }

                // Full path for the PDF including the file name
                $fullFilePath = "$folderPath$fileName";

                $pdf = Pdf::loadView('admin.modules.registar.pdf.certificate', compact('userDetails'))->setPaper('a4', 'landscape');

                // Save the generated PDF to the storage path
                if ($pdf->save($fullFilePath)) {
                    $student = ApprovedApplicants::create(
                        // ['student_application_id' => $request->stu_app_id],
                        [
                            'student_application_id' => $request->stu_app_id,
                            'allotted_certificate_no' => $certificateNo,
                            'alloted_regn_no' => $stuApp[0]->registration_no,
                            'certificate_path' => $fullFilePath,
                            'certficate_valid_from_date' => date('Y-m-d', strtotime($getStartDate)),
                            'created_by' => auth('admin')->user()->id,
                        ]
                    );
                }


                // Update start date for next iteration (expiry date + 1 day)
                $getStartDate = \Carbon\Carbon::parse($getStartDate)
                    ->addYears(5)
                    ->format('d-m-Y');
            }

            // echo 'Last Start Date: ' . date('d-m-Y', strtotime($getStartDate));
            // dd();

            return back()->with('success', "Applicant Certificate No. : $noOfCertificate generated successfully!");

        } else {
            return back()->with('error', 'Invalid OTP');
        }
    }

    public function viewRegistarUnsignedCertificate(Request $request)
    {
        $records = StudentApplication::query()
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->join("approved_applicants", "approved_applicants.student_application_id", "=", "student_applications.id")
            ->leftJoin("admins", "admins.id", "=", "approved_applicants.signed_uploaded_by")
            ->leftJoin("admin_details", "admin_details.id", "=", "admins.admin_details_id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "approved")
            ->where("uploaded_documents.document_name", "applicant_photo")
            ->where("approved_applicants.signed_certificate_path", '=', null)
            ->select(
                'approved_applicants.id', // Including id for grouping
                'student_applications.name',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'student_applications.jh_other_college_name',
                'student_applications.college_name',
                'approved_applicants.allotted_certificate_no',
                'approved_applicants.alloted_regn_no',
                'approved_applicants.certificate_path',
                'approved_applicants.signed_certificate_path',
                // 'approved_applicants.certificate_path',
                'approved_applicants.signed_uploaded_at',
                'approved_applicants.created_at',
                'payments.passing_state',
                'uploaded_documents.document_path',
                'admin_details.name as user',
                'institutes.name as institute_name',
                'courses.course_name',
                'indian_states.name as state_name',
            )
            ->groupBy(
                'approved_applicants.id', // Including id for grouping
                'student_applications.name',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'student_applications.jh_other_college_name',
                'student_applications.college_name',
                'approved_applicants.signed_uploaded_at',
                'approved_applicants.allotted_certificate_no',
                'approved_applicants.alloted_regn_no',
                'approved_applicants.certificate_path',
                'approved_applicants.signed_certificate_path',
                'approved_applicants.created_at',
                'uploaded_documents.document_path',
                'payments.passing_state',
                'admin_details.name',
                'institutes.name',
                'courses.course_name',
                'indian_states.name',
            )
            ->get();

        return view("admin.modules.registar.show-generated-certificate", compact('records'));
    }
    public function viewRegistarSignedCertificate(Request $request)
    {
        $records = StudentApplication::query()
            ->join("uploaded_documents", "uploaded_documents.student_application_id", "=", "student_applications.id")
            ->join("payments", "payments.student_application_id", "=", "student_applications.id")
            ->join("approved_applicants", "approved_applicants.student_application_id", "=", "student_applications.id")
            ->leftJoin("admins", "admins.id", "=", "approved_applicants.signed_uploaded_by")
            ->leftJoin("admin_details", "admin_details.id", "=", "admins.admin_details_id")
            ->leftJoin("courses", "courses.id", "=", "student_applications.course_id")
            ->leftJoin("institutes", "institutes.institute_id", "=", "student_applications.college_name")
            ->leftJoin('indian_states', 'indian_states.id', '=', 'payments.other_state')
            ->where("student_applications.status", "submitted")
            ->where("student_applications.auth_status", "approved")
            ->where("uploaded_documents.document_name", "applicant_photo")
            ->where("approved_applicants.signed_certificate_path", '<>', null)
            ->select(
                'approved_applicants.id', // Including id for grouping
                'student_applications.name',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'student_applications.jh_other_college_name',
                'student_applications.college_name',
                'approved_applicants.allotted_certificate_no',
                'approved_applicants.alloted_regn_no',
                'approved_applicants.certificate_path',
                'approved_applicants.signed_certificate_path',
                'approved_applicants.created_at',
                'approved_applicants.signed_uploaded_at',
                'payments.passing_state',
                'payments.payment_receipt',
                'uploaded_documents.document_path',
                'admin_details.name as user',
                'institutes.name as institute_name',
                'courses.course_name',
                'indian_states.name as state_name',
            )
            ->groupBy(
                'approved_applicants.id', // Including id for grouping
                'student_applications.name',
                'student_applications.acknowledgment_no',
                'student_applications.course_type',
                'student_applications.other_course',
                'student_applications.jh_other_college_name',
                'student_applications.college_name',
                'approved_applicants.allotted_certificate_no',
                'approved_applicants.alloted_regn_no',
                'approved_applicants.certificate_path',
                'approved_applicants.signed_certificate_path',
                'approved_applicants.created_at',
                'approved_applicants.signed_uploaded_at',
                'uploaded_documents.document_path',
                'payments.passing_state',
                'payments.payment_receipt',
                'admin_details.name',
                'institutes.name',
                'courses.course_name',
                'indian_states.name',
            )
            ->get();
        // dd($records);
        return view("admin.modules.registar.show-signed-certificate", compact('records'));
    }
    public function councilSignedCertificateUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "upload" => "required|file|mimes:pdf|max:2420"
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $existingFile = ApprovedApplicants::where('approved_applicants.id', $request->id)
            ->join('student_applications', 'student_applications.id', '=', 'approved_applicants.student_application_id')
            ->first();

        if ($existingFile) {

            $file = $request->file('upload');

            // Get the existing file's folder path
            $fileId = $existingFile['allotted_certificate_no'];
            $filePath = $existingFile->certificate_path;
            $folderPath = dirname($filePath) . '/';

            // Generate a new file name based on the old file's name
            $fileName = 'signed_Certificate_' . $fileId . '.' . $file->getClientOriginalExtension();

            // Move the uploaded file to the target folder
            if ($file->move(public_path($folderPath), $fileName)) {
                // Construct the new file path
                $docFileName = "$folderPath$fileName";

                ApprovedApplicants::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'signed_certificate_path' => $docFileName,
                        'signed_uploaded_at' => now(),
                        'signed_uploaded_by' => auth('admin')->user()->id,
                    ]
                );

                $message = "Dear {$existingFile['name']}, your Registration No. issued, visit JSPC office-JSPCRN";
                $this->sendSMS($existingFile['mobile_no'], $message);

                return back()->with('success', 'Applicant Signed Certificate uploaded successfully!');
            } else {
                return back()->with('success', 'Applicant Signed Certificate uploaded failed!');
            }
        }
    }
    public function generateCertificateSendOTP(Request $request)
    {
        $mobileNumber = auth('admin')->user()->mobile_no;

        $exists = AdminDetails::where('mobile_no', $mobileNumber);

        $otp = rand(100000, 999999);

        $secretKey = env('OTP_SECRET_KEY');

        $otpHmac = hash_hmac('sha256', $otp, $secretKey);

        AdminOtpLogs::create([
            'description' => $request->stu_app_id,
            'mobile_number' => $mobileNumber,
            'hashed_otp' => Hash::make($otp),
            'otp_expiration' => now()->addMinutes(15),
            'send_ip' => request()->ip(),
            'otp_hmac' => $otpHmac,
        ]);

        $message = "{$otp} is OTP to generate certificate.-JSPCRN";

        $this->sendSMS($mobileNumber, $message);
        // $this->sendSMS('8092213051', $message);

        return back()->with("showOTP", $request->stu_app_id);
    }

    public function verifyCertificateOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $mobileNumber = auth('admin')->user()->mobile_no;

        $otpLog = AdminOtpLogs::where('mobile_number', $mobileNumber)
            ->where('status', 'pending')
            ->where('description', $request->stu_app_id)
            ->latest('id')
            ->first();

        if ($otpLog) {
            if ($otpLog->otp_expiration < now()) {
                $otpLog->update(['status' => 'expired']);
                return response()->json([
                    'type' => 'error',
                    'message' => 'Your OTP has expired. Please request a new one to proceed.',
                ]);
            }

            if ($otpLog->attempts == '5') {
                $otpLog->update(['status' => 'expired']);
                return response()->json([
                    'type' => 'error',
                    'message' => 'You have reached the maximum number of OTP attempts. Please request a new OTP to continue.',
                ]);
            }

            $secretKey = env('OTP_SECRET_KEY');
            $providedOtpHmac = hash_hmac('sha256', $request->input('otp'), $secretKey);

            if ($providedOtpHmac === $otpLog->otp_hmac) {
                // if (Hash::check($request->otp, $otpLog->hashed_otp)) {
                $otpLog->update(['status' => 'verified']);
                session()->forget('mobile_number');
                return response()->json([
                    'type' => 'success',
                ]);
            } else {
                $otpLog->increment('attempts');
                return response()->json([
                    'type' => 'error',
                    'message' => 'Invalid OTP.',
                ]);
            }
        } else {
            return response()->json([
                'type' => 'error',
                'message' => 'No OTP found. Please request a new one.',
            ]);
        }
    }

    public function getCheckOtherPassningState(Request $request)
    {
        $checkOtherPassningState = Payment::where('id', $request->pay_id)->first();

        if ($checkOtherPassningState['passing_state'] === 'Other') {
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

    public function updatePaymentDeatailsByCouncil(Request $request, $id)
    {
        // dd($request->all());
        try {
            $existingPayment = Payment::findOrFail($id);

            $request->validate([
                'payment_receipt_no' => [
                    'required',
                    'string',
                    Rule::unique('payments', 'payment_receipt_no')->ignore(optional($existingPayment)->id), // Ignore uniqueness for the current payment if updating
                ],
                'amount' => 'required|numeric',
                'dated' => 'required|date|before_or_equal:today',
                'passing_state' => 'in:Jharkhand,Other',
                'other_state' => 'required_if:state,Other',
                'result_date' => 'required|date|before_or_equal:today'
            ]);

            $existingPayment->update($request->all());

            return redirect()->back()->with('success', 'Payment details updated successfully.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'There was an issue updating the payment details.');
        }
    }

    public function updateApplicantDeatailsByCouncil(Request $request, $id)
    {
        // dd($id);
        // $studentApplication = StudentApplication::find($id);
        // $validatedData = $request->except('_token');
        // $validatedData = [
        //     'course_type' => 'required|string',
        //     'course_id' => [
        //         'required',
        //         'string',
        //         'max:150',
        //         Rule::unique('student_applications', 'course_id')
        //             ->where(function ($query) use ($id) {
        //                 return $query->where('student_id', $id);
        //             })
        //             ->whereNull('other_course')->ignore(optional($studentApplication)->id),
        //     ],
        //     'college_name' => 'required|string|max:150',
        //     'jh_other_college_name' => 'required_if:college_name,999|string|max:150',
        //     'course_registration_no' => 'required|string|max:50',
        //     'father_name' => 'required|string|max:150',
        //     'address' => 'required|string|max:150',
        //     'city' => 'required|string|max:30',
        //     'pin_code' => 'required|integer|digits:6',
        //     'state' => 'required|string|max:20',
        //     'alternate_mobile_no' => 'nullable|string|size:10',
        //     'whatsapp_no' => 'nullable|string|size:10',
        //     'email' => 'required|email|max:50',
        // ];

        // try {
        //     $existingApplicant = StudentApplication::where('id',$id);

        //     $existingApplicant->update($validatedData);

        // } catch (\Exception $e) {
        //     dd($e);
        //     return redirect()->back()->with('error', 'There was an issue updating the Applicant details.');
        // }

        $validatedData = $request->validate([
            'course_type' => 'required|string',
            'course_id' => [
                'required',
                'string',
                'max:150',
                Rule::unique('student_applications', 'course_id')
                    ->where(function ($query) use ($id) {
                        return $query->where('id', $id);
                    })
                    ->whereNull('other_course')->ignore($id),
            ],
            'college_name' => 'required|string|max:150',
            'jh_other_college_name' => 'required_if:college_name,999|string|max:150',
            'course_registration_no' => 'required|string|max:50',
            'father_name' => 'required|string|max:150',
            'address' => 'required|string|max:150',
            'city' => 'required|string|max:30',
            'pin_code' => 'required|integer|digits:6',
            'state' => 'required|string|max:20',
            'alternate_mobile_no' => 'nullable|string|size:10',
            'whatsapp_no' => 'nullable|string|size:10',
            'email' => 'required|email|max:50',
        ]);

        // Find the existing applicant
        $existingApplicant = StudentApplication::where('id', $id);

        // Update the record
        $existingApplicant->update($validatedData);
        return redirect()->back()->with('success', 'Applicant details updated successfully.');
    }

    private function sendSMS($mobileNo, $message)
    {
        $baseUrl = url('/');
        $mobileNumbers = ($baseUrl === 'http://127.0.0.1:8000') ? '7979040859' : $mobileNo;

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

    public function viewGenerateApprovedStuExcel(Request $request)
    {
        return view("admin.modules.applicant-registration.show-generate-excel");
    }

    public function rangeCertificateExcelGen(Request $request)
    {
        $query = ApprovedApplicants::query()
            ->select(
                'approved_applicants.alloted_regn_no',
                'student_applications.name',
                'student_applications.father_name',
                'student_applications.address',
                'student_applications.city',
                'indian_states.name AS state',
                'student_applications.mobile_no',
                'approved_applicants.certficate_valid_from_date',
                'uploaded_documents.document_path as appl_photo',
                'approved_applicants.allotted_certificate_no',
                DB::raw("
                CASE
                    WHEN courses.course_name = 'Other'
                        THEN CONCAT(student_applications.course_type, ' in ', student_applications.other_course)
                    ELSE CONCAT(student_applications.course_type, ' in ', courses.course_name)
                END AS course"),

                DB::raw("
                GROUP_CONCAT(
                    CASE
                        WHEN student_applications.college_name = '999' THEN student_applications.jh_other_college_name
                        WHEN student_applications.college_name REGEXP '^[0-9]+$' THEN CONCAT(institutes.name, ', ',institutes.city)
                        ELSE student_applications.college_name
                    END
                ) AS inst "),
            )
            ->join('student_applications', 'student_applications.id', '=', 'approved_applicants.student_application_id')
            ->join('uploaded_documents', 'student_applications.id', '=', 'uploaded_documents.student_application_id')
            ->join('courses', 'courses.id', '=', 'student_applications.course_id')
            ->leftJoin('indian_states', 'indian_states.id', '=', 'student_applications.state')
            ->leftJoin('institutes', 'institutes.institute_id', '=', 'student_applications.college_name')
            ->where('uploaded_documents.document_name', 'applicant_photo');

        if ($request->has('cert_from') && $request->has('cert_to')) {

            $request->validate([
                'cert_from' => 'required|integer|min:11769',
                'cert_to' => 'required|integer|min:11770',
            ]);

            $query->whereBetween('approved_applicants.alloted_regn_no', [$request->cert_from, $request->cert_to]);
        }
        $query = $query->groupBy('approved_applicants.student_application_id')
            ->groupBy('student_applications.city')
            ->groupBy('student_applications.state')
            ->groupBy('indian_states.name')
            ->groupBy('courses.course_name')
            ->groupBy('approved_applicants.alloted_regn_no')
            ->groupBy('approved_applicants.allotted_certificate_no')
            ->groupBy('student_applications.course_type')
            ->groupBy('student_applications.other_course')
            ->groupBy('student_applications.name')
            ->groupBy('student_applications.father_name')
            ->groupBy('student_applications.address')
            ->groupBy('student_applications.mobile_no')
            ->groupBy('approved_applicants.certficate_valid_from_date')
            ->groupBy('uploaded_documents.document_path')
            ->orderBy('approved_applicants.alloted_regn_no')
            ->get();

        return Excel::download(new CertificateGeneratedExport($query), 'Certificate_Generated_Applicants_Range_' . $request->cert_from . ' to ' . $request->cert_to . '.xlsx');

    }

    public function uploadStudentSingleDoc(Request $request)
    {
        switch ($request->input('field_name')) {
            case 'payment_receipt':
                $request->validate([
                    'documents.*' => 'required|file|mimes:jpeg,jpg,pdf|max:1000',
                ]);
                break;
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

        $userId = $request->input('app_id');

        $studentApplication = StudentApplication::where('id', $userId)->latest()->first();

        // dd($studentApplication);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fieldName = $request->input('field_name');

            $yearMonth = date('ym');
            $folderPath = "uploads/{$yearMonth}/{$fieldName}/";
            $fileName = $studentApplication->acknowledgment_no . '-admin.' . $file->getClientOriginalExtension();

            // Move the file to the desired directory
            if ($file->move(public_path($folderPath), $fileName)) {
                // Save file path in the database
                $docFileName = "$folderPath$fileName";

                if ($fieldName == 'payment_receipt') {
                    Payment::where('student_application_id', $studentApplication->id)
                        ->update(['payment_receipt' => $docFileName]);
                } else {
                    $uploadedDocs = UploadedDocument::where('student_application_id', $studentApplication->id)->where('document_name', $fieldName)->first();
                    $uploadedDocs['user_uploaded_document_path'] = $uploadedDocs['document_path'];
                    $uploadedDocs['document_path'] = $docFileName;
                    $uploadedDocs->save();

                    // UploadedDocument::updateOrCreate(
                    //     ['student_application_id' => $studentApplication->id, 'document_name' => $fieldName],
                    //     ['document_path' => $docFileName]
                    // );
                }

                return response()->json(['success' => true, 'file_path' => asset($docFileName)], 200);
            } else {
                return response()->json(['error' => false, 'message' => 'File Not uploaded']);
            }
        }

        return response()->json(['error' => false, 'message' => 'No file uploaded']);
    }

    public function applicationMarkPending(Request $request, $id)
    {
        $application = StudentApplication::where('acknowledgment_no', $id)->first();

        $application['auth_status'] = 'Pending';
        $application['auth'] = 'council_office';
        $application->save();

        return redirect()->back()->with('success', "Acknowledgement No. $id successfully sent to Pending Forms.");
    }
}
