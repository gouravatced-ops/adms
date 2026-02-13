<?php

namespace App\Http\Controllers\Applicant;

use App\Models\StudentRegistration;
use App\Models\ApprovedApplicants;
use Illuminate\Http\Request;
use App\Models\StudentApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }
    public function index()
    {
        $incompleteCount = StudentApplication::where('status', 'submitted')
            ->where('auth_status', 'incomplete')
            ->where('student_id', auth()->id())
            ->count();
        $acceptCount = StudentApplication::where('status', 'submitted')
            ->where('auth_status', 'accept')
            ->where('student_id', auth()->id())
            ->count();
        $rejectCount = StudentApplication::where('status', 'submitted')
            ->where('auth_status', 'reject')
            ->where('student_id', auth()->id())
            ->count();
        $approveCount = StudentApplication::where('status', 'submitted')
            ->where('auth_status', 'approved')
            ->where('student_id', auth()->id())
            ->count();

        return view('applicant.dashboard_components.dashboard', compact('incompleteCount', 'acceptCount', 'rejectCount', 'approveCount'));
    }


    public function incompleteApplication()
    {
        $studentApplications = StudentApplication::where('student_id', auth()->id())
            ->where('status', '=', 'submitted')
            ->where('auth_status', '=', 'incomplete')
            ->join('payments', 'student_applications.id', '=', 'payments.student_application_id')
            ->join('courses', 'student_applications.course_id', '=', 'courses.id')
            ->leftJoin('indian_states', 'payments.other_state', '=', 'indian_states.id')
            ->select(
                'student_applications.*',
                'payments.payment_receipt_no',
                'payments.passing_state',
                'payments.amount',
                'payments.dated',
                'courses.course_name',
                'indian_states.name as state',
            )->get();
        return view('applicant.dashboard_components.incomplete-application', compact('studentApplications'));
    }

    public function acceptedApplication()
    {
        $studentApplications = StudentApplication::where('student_id', auth()->id())
            ->where('status', '=', 'submitted')
            ->where('auth_status', '=', 'accept')
            ->join('payments', 'student_applications.id', '=', 'payments.student_application_id')
            ->join('courses', 'student_applications.course_id', '=', 'courses.id')
            ->leftJoin('indian_states', 'payments.other_state', '=', 'indian_states.id')
            ->select(
                'student_applications.*',
                'payments.payment_receipt_no',
                'payments.passing_state',
                'payments.amount',
                'payments.dated',
                'courses.course_name',
                'indian_states.name as state',
            )->get();
        return view('applicant.dashboard_components.accepted-application', compact('studentApplications'));
    }

    public function revertedDocumentsView($ack_no)
    {
        $stuAppId = StudentApplication::where('student_id', auth()->id())
            ->where('acknowledgment_no', $ack_no)
            ->value('id');

        $studentApplications = StudentApplication::where('student_id', auth()->id())
            ->where('acknowledgment_no', $ack_no)
            ->where('uploaded_documents.status', 'Revert')
            ->join('uploaded_documents', 'uploaded_documents.student_application_id', 'student_applications.id')
            ->get();

        $studentPayApplications = StudentApplication::where('student_id', auth()->id())
            ->where('acknowledgment_no', $ack_no)
            ->where('payments.doc_status', 'Revert')
            ->join('payments', 'payments.student_application_id', 'student_applications.id')
            ->get();

        return view('applicant.dashboard_components.incomplete-form-view', compact('studentApplications', 'studentPayApplications', 'stuAppId'));
    }

    public function trackApplication()
    {
        $studentApplications = StudentApplication::where('student_id', auth()->id())
            ->where('status', 'submitted')
            ->join('payments', 'student_applications.id', '=', 'payments.student_application_id')
            ->join('courses', 'student_applications.course_id', '=', 'courses.id')
            ->leftJoin('indian_states', 'payments.other_state', '=', 'indian_states.id')
            ->select(
                'student_applications.*',
                'payments.payment_receipt_no',
                'payments.passing_state',
                'payments.amount',
                'payments.dated',
                'courses.course_name',
                'indian_states.name as state',
            )
            ->get();

        return view('applicant.dashboard_components.track-application', compact('studentApplications'));
    }

    public function approvedApplication()
    {
        $studentApplications = StudentApplication::where('student_id', auth()->id())
            ->where('status', 'submitted')
            ->where('auth_status', 'approved')
            ->join('payments', 'student_applications.id', '=', 'payments.student_application_id')
            ->join('courses', 'student_applications.course_id', '=', 'courses.id')
            ->leftJoin('indian_states', 'payments.other_state', '=', 'indian_states.id')
            ->leftJoin('approved_applicants', 'student_applications.id', '=', 'approved_applicants.student_application_id')
            ->select(
                'student_applications.*',
                'payments.payment_receipt_no',
                'payments.passing_state',
                'payments.amount',
                'payments.dated',
                'courses.course_name',
                'indian_states.name as state',
                'approved_applicants.signed_certificate_path',
                'approved_applicants.allotted_certificate_no'
            )
            ->get();

        // dd($studentApplications);
        return view('applicant.dashboard_components.approved-application', compact('studentApplications'));
    }

    public function downloadCertificatePdf($id)
    {
        // Get the record from database
        $document = ApprovedApplicants::where('allotted_certificate_no', $id)->first();

        // dd($document);

        $filePath = public_path($document->signed_certificate_path);

        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, 'Certificate_' . $document->allotted_certificate_no . '.pdf');

        // Return the binary content as a download response
        return response($filePath)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"{$document->allotted_certificate_no}\"");
    }
    public function rejectedApplication()
    {
        $studentApplications = StudentApplication::where('student_id', auth()->id())
            ->where('status', 'submitted')
            ->where('auth_status', 'reject')
            ->join('payments', 'student_applications.id', '=', 'payments.student_application_id')
            ->join('courses', 'student_applications.course_id', '=', 'courses.id')
            ->leftJoin('indian_states', 'payments.other_state', '=', 'indian_states.id')
            ->select(
                'student_applications.*',
                'payments.payment_receipt_no',
                'payments.passing_state',
                'payments.amount',
                'payments.dated',
                'courses.course_name',
                'indian_states.name as state',
            )
            ->get();

        return view('applicant.dashboard_components.rejected-application', compact('studentApplications'));
    }

    public function accountSettings()
    {
        $studentRegis = StudentRegistration::where('student_registrations.id', auth()->id())
            // ->where('uploaded_documents.document_name', 'applicant_photo')
            // ->join('student_applications', 'student_applications.student_id', '=', 'student_registrations.id')
            // ->join('uploaded_documents', 'uploaded_documents.student_application_id', '=', 'student_applications.id')
            ->select(
                'student_registrations.*',
                // 'uploaded_documents.*',
            )
            ->first();
        // dd($studentRegis['document_path']);
        return view('applicant.dashboard_components.settings', compact('studentRegis'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'newPassword' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]).+$/',
            ]
        ]);

        $user = Auth::user();

        if (!$user) {
            return back()->with('error', 'User not authenticated.');
        }

        $user->password = Hash::make($request->newPassword);
        $user->password_created_at = now();
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
