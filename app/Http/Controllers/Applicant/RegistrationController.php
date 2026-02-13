<?php

namespace App\Http\Controllers\Applicant;

use Illuminate\Http\Request;
use App\Models\OtpLog;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentRegistration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }
    public function showRegistrationForm()
    {
        return view('applicant.auth_components.register');
    }

    public function showLoginForm()
    {
        return view('applicant.auth_components.login');
    }

    public function register(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female,Other',
            'category' => 'required|in:General,OBC,SC,ST',
            'aadhaar' => [
                'required',
                'string',
                'size:12',
                Rule::unique('student_registrations', 'aadhaar_no'), // Unique constraint
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

            'mobile_no' => 'required|string|size:10|unique:student_registrations,mobile_no',
            'dob' => 'required',
            'date',
            'before_or_equal:' . now()->subYears(14)->format('Y-m-d'),
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]).+$/',
                'confirmed'
            ],
            'otp' => 'required|digits:6',
        ]);

        $inputOTP = $request->input('otp');
        $mobileNumber = $request->input('mobile_no');

        $otpRecord = OTPLog::where('mobile_number', $mobileNumber)->where('status', 'verified')->latest()->first();

        if (Hash::check($inputOTP, $otpRecord->hashed_otp)) {
            $otpRecord->status = 'verified';
            $otpRecord->save();

            // Store a session variable to indicate that OTP is verified
            session(['otp_verified' => true]);

            $student = StudentRegistration::create([
                'name' => $request->name,
                'gender' => $request->gender,
                'category' => $request->category,
                'aadhaar_no' => $request->aadhaar,
                'date_of_birth' => $request->dob,
                // 'result_date' => $request->resultDate,
                'last_login' => Carbon::now(),
                'otp_verified_at' => Carbon::now(),
                'last_ip' => request()->ip(),
                'mobile_no' => $request->mobile_no,
                'password' => Hash::make($request->password),
            ]);
            // Log the user in
            Auth::login($student);

            // Redirect to the dashboard
            return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome to your dashboard.');

            // return redirect()->route('dashboard');
            // return back()->with('success', 'Registration Ccompleted successful!');
        } else {
            return back()->withInput()->withErrors(['otp' => 'Invalid OTP or OTP has expired.']);
        }
    }

    public function sendOTP(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|digits:10',
        ]);

        $mobileNumber = $request->input('mobile_number');

        $exists = StudentRegistration::where('mobile_no', $mobileNumber);
        if ($exists->count() > 0) {
            return response()->json([
                'type' => 'exists',
                'message' => 'The Mobile No. has already been taken.',
            ]);
        }

        $otp = rand(100000, 999999);

        $secretKey = env('OTP_SECRET_KEY');

        $otpHmac = hash_hmac('sha256', $otp, $secretKey);

        OtpLog::create([
            'mobile_number' => $mobileNumber,
            'hashed_otp' => Hash::make($otp),
            'otp_expiration' => now()->addMinutes(15),
            'send_ip' => request()->ip(),
            'otp_hmac' => $otpHmac,
        ]);


        $message = "Dear Applicant, {$otp} is OTP for Online Registration - JSPCRN";

        $this->sendSMS($mobileNumber, $message);
        // $this->sendSMS('7979040859', $message);
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

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'mobile_number' => 'required|digits:10',
        ]);

        $inputOTP = $request->input('otp');
        $mobileNumber = $request->input('mobile_number');

        $otpRecord = OTPLog::where('mobile_number', $mobileNumber)->where('status', 'pending')->latest('id')->first();

        if ($otpRecord) {

            if ($otpRecord->otp_expiration < now()) {
                $otpRecord->update(['status' => 'expired']);
                return response()->json([
                    'type' => 'error',
                    'message' => "Your OTP is no longer valid. Please request a new one to proceed."
                ], 400);
            }

            if ($otpRecord->attempts == '5') {
                $otpRecord->update(['status' => 'expired']);
                return response()->json([
                    'type' => 'error',
                    'message' => "You have reached the maximum number of OTP attempts. Please request a new OTP to continue."
                ], 400);
            }

            $secretKey = env('OTP_SECRET_KEY');
            $providedOtpHmac = hash_hmac('sha256', $inputOTP, $secretKey);

            // if ($providedOtpHmac === $otpRecord->otp_hmac) {
            if (Hash::check($inputOTP, $otpRecord->hashed_otp)) {
                $otpRecord->update(['status' => 'verified', 'veified_ip' => request()->ip()]);
                return response()->json([
                    'type' => 'success',
                    'message' => 'Mobile number verified successfully!'
                ]);
            } else {
                $otpRecord->increment('attempts');
                return response()->json([
                    'type' => 'error',
                    'message' => "You have entered wrong OTP. Please enter correct OTP to continue."
                ], 400);
            }
        } else {
            return response()->json([
                'type' => 'error',
                'message' => "No OTP found. Please request a new one."
            ], 400);
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
    public function getInstitute()
    {
        $institutes = DB::table('institutes')->select('name', 'district', 'address', 'primary_mobile_no', 'email')->get();
        return response()->json($institutes);
    }

       public function getInstituteWeb()
    {
        $institutes = DB::table('institutes_web')->select('name', 'district', 'address', 'primary_mobile_no', 'email')->get();
        return response()->json($institutes);
    }
}

