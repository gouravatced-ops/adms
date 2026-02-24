<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminDetails;
use App\Models\AdminOtpLogs;
use App\Models\Payment;
use App\Models\StudentApplication;
use App\Models\UploadedDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function councilDashboard()
    {

        return view('admin.modules.dashboard.co-dashboard');
    }

    public function registarDashboard()
    {

        return view('admin.modules.dashboard.rgtr-dashboard');
    }

    public function getMyProfile(Request $request)
    {
        $admin = AdminDetails::where('id', auth('admin')->user()->admin_details_id)->first();
        // dd($admin);
        return view('admin.modules.profile.my-profile', compact('admin'));
    }

    public function getMySetting(Request $request)
    {
        $admin = AdminDetails::where('id', auth('admin')->user()->admin_details_id)->first();
        // dd($admin);
        return view('admin.modules.profile.my-setting', compact('admin'));
    }

    public function updateAdminDetails(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email',
            'whatsapp' => 'required|digits:10',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:204', // max 200kB
        ]);
        $FileName = null; // Initialize as null to handle cases where no file is uploaded.

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $folderPath = 'admin_pic/';

            if ($file->move(public_path($folderPath), $fileName)) {
                $FileName = $folderPath . $fileName;
            }
        }

        // dd($FileName);
        $student = AdminDetails::updateOrCreate(
            ['id' => auth('admin')->user()->admin_details_id],
            [
                'name' => $request->name,
                'gender' => $request->gender,
                'email' => $request->email,
                'whatsapp' => $request->whatsapp,
                'profile_pic' => $FileName ?? auth('admin')->user()->adminDetails->profile_pic, // Preserve the current profile picture if no new one is uploaded
            ]
        );

        return back()->with('success', 'Profile updated successfully!');
    }

    public function sendChangePassOTP(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|digits:10',
        ]);

        $mobileNumber = $request->input('mobile_number');

        $exists = AdminDetails::where('mobile_no', $mobileNumber);

        $otp = rand(100000, 999999);

        $secretKey = env('OTP_SECRET_KEY');

        $otpHmac = hash_hmac('sha256', $otp, $secretKey);

        AdminOtpLogs::create([
            'description' => 'Change Password',
            'mobile_number' => $mobileNumber,
            'hashed_otp' => Hash::make($otp),
            'otp_expiration' => now()->addMinutes(15),
            'send_ip' => request()->ip(),
            'otp_hmac' => $otpHmac,
        ]);


        $message = "{$otp} is OTP to reset password.-JSPCRN";

        $this->sendSMS($mobileNumber, $message);
        try {
            return response()->json([
                'type' => 'success',
                'message' => 'OTP sent successfully',
                // 'otp' => $otp
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function verifyPassOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $mobileNumber = $request->mobile_number;
        $otpLog = AdminOtpLogs::where('mobile_number', $mobileNumber)
            ->where('status', 'pending')
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

    public function updateAdminPassword(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'mobileNo' => ['required', 'string', 'size:10'],
            'otp' => 'required|digits:6',
        ]);
        $otpLog = AdminOtpLogs::where('mobile_number', $request->input('mobileNo'))->where('status', 'verified')->latest()->first();

        if ($otpLog) {
            $admin = Admin::where('mobile_no', $request->input('mobileNo'))->latest()->first();

            if ($admin) {
                $admin->prev_password = $admin['password'];
                $admin->password = Hash::make($request->input('newPassword'));
                $admin->password_created_at = now();
                $admin->save();

                back()->with('success', 'Password updated successfully!');
                return response()->json([
                    'type' => 'success',
                ]);
            }
        }

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

    public function viewAffiliatedCollege(Request $request)
    {
        $inst = DB::table('institutes')->get();

        return view('admin.modules.institutes.institute-list', compact('inst'));
    }

    public function editViewAffiliatedCollege($id)
    {
        $data = DB::table('institutes')->where('code', $id)->first();
        // dd($data);
        return view('admin.modules.institutes.edit_institution', compact('data'));
    }

    public function updateAffiliatedCollege(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'pin' => 'nullable|digits:6',
            'state' => 'nullable|string|max:255',
            'primary_mobile_no' => 'nullable|digits:10',
            'alternate_mobile_no' => 'nullable|digits:10',
            'whatsapp_mobile_no' => 'nullable|digits:10',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'principal_name' => 'nullable|string|max:255'
        ]);

        $institution = DB::table('institutes')->where('code', $id)->first();

        DB::table('institutes')->where('code', $id)->update($validated);

        return redirect()->back()->with('success', 'Institution details updated successfully.');
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
}
