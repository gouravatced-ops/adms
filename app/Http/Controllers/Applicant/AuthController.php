<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\OtpLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function login(Request $request)
    {
        session()->start();
        $request->validate([
            'username' => 'required',
            'password' => 'required|string|min:8',
            'captcha'  => 'required|captcha',
        ]);

        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $loginInput = $request->input('username');

        $student = User::where(function ($query) use ($loginInput) {
            $query->where('mobile_no', $loginInput)
                ->orWhere('email_id', $loginInput);
        })->latest()->first();
        if ($student && Hash::check($request->input('password'), $student->password)) {
            // $emailId = $student->email_id;
            $expirationTime = Carbon::parse($student->otp_verified_at);
            $expirationTime->addHours(2);

            if (Carbon::now()->lessThanOrEqualTo($expirationTime)) {
                $student->last_login = Carbon::now();
                $student->otp_verified_at = Carbon::now();
                $student->last_ip = request()->ip();
                $student->save();

                Auth::login($student);

                return redirect()->route('dashboard');
            } else {
                $student->last_login = Carbon::now();
                $student->otp_verified_at = Carbon::now();
                $student->last_ip = request()->ip();
                $student->save();

                Auth::login($student);

                return redirect()->route('dashboard');
            }
        } else {
            return back()->with('LoginError', 'Invalid credentials');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student-corner');
    }

    public function forgotPassApplicantOtp(Request $request)
    {
        $forgetInput = $request->input('username');
        $stu = User::where(function ($query) use ($forgetInput) {
            $query->where('mobile_no', $forgetInput)
                ->orWhere('email_id', $forgetInput);
        })->latest()->first();
        if ($stu) {
            $emailId = $stu->email_id;
            $this->sendOtp($request, 'reset', $emailId);
            session(['mobile_number' => $forgetInput]);

            return back()->with('success', "OTP sent successfully to your Email-Id ({$emailId}). It is valid for 15 minutes.");
        } else {
            $input = $request->input('username');

            return back()->with('notValid', "No applicant found to your account ({$input}).");
        }
    }

    public function applicantForgotPasswordUpdate(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $mobileNumber = session('mobile_number');
        if (empty($mobileNumber)) {
            return redirect()->route('login')->with('LoginError', 'Your session has expired. Please log in again.');
        }

        $otpLog = OtpLog::where('login_with', $mobileNumber)
            ->where('status', 'pending')
            ->latest('id')
            ->first();
        if ($otpLog) {
            if ($otpLog->otp_expiration < now()) {
                $otpLog->update(['status' => 'expired']);

                return back()->with('verifyError', 'Your OTP has expired. Please request a new one to proceed.');
            }

            if ($otpLog->attempts == '5') {
                $otpLog->update(['status' => 'expired']);

                return back()->with('verifyError', 'You have reached the maximum number of OTP attempts. Please request a new OTP to continue.');
            }

            $secretKey = env('OTP_SECRET_KEY');
            $providedOtpHmac = hash_hmac('sha256', $request->input('otp'), $secretKey);

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=[]{}|;:,.<>?';

            $randPass = substr(str_shuffle(str_repeat($characters, ceil(8 / strlen($characters)))), 1, 8);
            if ($providedOtpHmac === $otpLog->otp_hmac) {
                session()->forget('mobile_number');

                $applicant = User::where(function ($query) use ($mobileNumber) {
                    $query->where('mobile_no', $mobileNumber)
                        ->orWhere('email_id', $mobileNumber);
                })->latest()->first();
                $applicantEmailId = $applicant->email_id;
                $applicant->password = Hash::make($randPass);
                $applicant->password_created_at = Carbon::now();
                // $applicant->prev_password = null;

                $applicant->save();

                $message = view('emails.temp_password', compact('randPass'))->render();
                $this->sendSMS($applicantEmailId, $message, 'Reset Password');

                return redirect()
                    ->route('student-corner')
                    ->with('LoginError', 'Your temporary password has been sent to your registered email Id.');
            } else {
                $otpLog->increment('attempts');

                return back()->with('verifyError', 'Invalid OTP.');
            }
        } else {
            return back()->with('verifyError', 'No OTP found. Please request a new one.');
        }
    }

    public function sendOtp(Request $request, $desc, $emailId)
    {
        $request->validate([
            'username' => 'required',
        ]);

        $otp = random_int(100000, 999999);
        $hashedOtp = Hash::make($otp);

        $secretKey = env('OTP_SECRET_KEY');

        $otpHmac = hash_hmac('sha256', $otp, $secretKey);

        OtpLog::create([
            'login_with' => $request->username,
            'hashed_otp' => $hashedOtp,
            'otp_expiration' => now()->addMinutes(15),
            'send_ip' => request()->ip(),
            'otp_hmac' => $otpHmac,
            'description' => empty($desc) ? 'Login' : 'Reset Password',
        ]);

        // Send OTP via SMS
        $message = view('emails.login_otp', compact('otp'))->render();

        $this->sendSMS($emailId, $message);

        return back()->with('success', "OTP sent successfully to your Email-Id ({$emailId}). It is valid for 15 minutes.");
    }

    public function resendOtp()
    {
        $mobileNumber = session('mobile_number');
        $applicant = User::where(function ($query) use ($mobileNumber) {
            $query->where('mobile_no', $mobileNumber)
                ->orWhere('email_id', $mobileNumber);
        })->latest()->first();

        $emailId = $applicant->email_id;
        if (empty($mobileNumber)) {
            return redirect()->route('login')->with('LoginError', 'Your session has expired. Please log in again.');
        }

        $otp = random_int(100000, 999999);
        $hashedOtp = Hash::make($otp);

        $secretKey = env('OTP_SECRET_KEY');

        $otpHmac = hash_hmac('sha256', $otp, $secretKey);

        OtpLog::create([
            'login_with' => $mobileNumber,
            'hashed_otp' => $hashedOtp,
            'otp_expiration' => now()->addMinutes(15),
            'otp_hmac' => $otpHmac,
        ]);

        $message = view('emails.login_otp', compact('otp'))->render();

        $this->sendSMS($emailId, $message);
        return back()->with(
            'success',
            "A new OTP has been sent successfully to your Email ID ({$emailId}). It is valid for 15 minutes."
        );
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $mobileNumber = session('mobile_number');

        if (empty($mobileNumber)) {
            return redirect()->route('login')->with('LoginError', 'Your session has expired. Please log in again.');
        }

        $loginInput = $mobileNumber; // email or mobile

        $student = User::where(function ($q) use ($loginInput) {
            $q->where('mobile_no', $loginInput)
                ->orWhere('email_id', $loginInput);
        })
            ->latest()
            ->first();

        if (! $student) {
            return back()->with('error', 'Student not found. Please register or contact support.');
        }

        $otpLog = OtpLog::where('login_with', $mobileNumber)
            ->where('status', 'pending')
            ->latest('id')
            ->first();

        if ($otpLog) {
            if ($otpLog->otp_expiration < now()) {
                $otpLog->update(['status' => 'expired']);

                return back()->with('error', 'Your OTP has expired. Please request a new one to proceed.');
            }

            if ($otpLog->attempts == '5') {
                $otpLog->update(['status' => 'expired']);

                return back()->with('error', 'You have reached the maximum number of OTP attempts. Please request a new OTP to continue.');
            }

            $secretKey = env('OTP_SECRET_KEY');
            $providedOtpHmac = hash_hmac('sha256', $request->input('otp'), $secretKey);

            if ($providedOtpHmac === $otpLog->otp_hmac) {
                // if (Hash::check($request->otp, $otpLog->hashed_otp)) {
                $otpLog->update(['status' => 'verified']);
                session()->forget('mobile_number');

                $student->last_login = Carbon::now();
                $student->otp_verified_at = Carbon::now();
                $student->last_ip = request()->ip();
                $student->save();

                Auth::login($student);

                return redirect()->route('dashboard');
            } else {
                $otpLog->increment('attempts');

                return back()->with('error', 'Invalid OTP.');
            }
        } else {
            return back()->with('error', 'No OTP found. Please request a new one.');
        }
    }
    // public function sendSMS($mobileNo, $message)
    // {
    //     $baseUrl = url('/');
    //     $mobileNumbers = ($baseUrl === 'http://127.0.0.1:8000') ? '7979040859' : $mobileNo;

    //     $postData = [
    //         'mobileNumbers' => $mobileNumbers,
    //         'smsContent' => $message,
    //         'senderId' => env('SMS_SENDER_ID'),
    //         'routeId' => '1',
    //         "smsContentType" => 'Unicode'
    //     ];
    //     $data_json = json_encode($postData);

    //     $url = "http://" . env('SMS_SERVER_URL') . "/rest/services/sendSMS/sendGroupSms?AUTH_KEY=" . env('SMS_AUTH_KEY');

    //     $ch = curl_init();

    //     curl_setopt_array(
    //         $ch,
    //         [
    //             CURLOPT_URL => $url,
    //             CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Content-Length: ' . strlen($data_json)],
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_POST => true,
    //             CURLOPT_POSTFIELDS => $data_json,
    //             CURLOPT_SSL_VERIFYHOST => 0,
    //             CURLOPT_SSL_VERIFYPEER => 0
    //         ]
    //     );
    //     //get response
    //     $output = curl_exec($ch);
    //     //Print error if any
    //     if (curl_errno($ch)) {
    //         echo 'error:' . curl_error($ch);
    //     }
    //     curl_close($ch);
    //     return $output;
    // }

    public function sendSMS($emailId, $message, $subject = 'OTP for Login - ADMS')
    {
        $mail = new PHPMailer(true);

        try {
            // SMTP config
            $mail->isSMTP();
            $mail->Host = 'mail.computered.co.in';
            $mail->SMTPAuth = true;
            $mail->Username = 'gourav@computered.co.in';
            $mail->Password = 'India#2026';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender
            $mail->setFrom('gourav@computered.co.in', 'ADMS');

            // Receiver
            $mail->addAddress($emailId);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = 'Your OTP is sent to your email.';

            $mail->send();

            return true;
        } catch (Exception $e) {
            \Log::error('PHPMailer Error: ' . $mail->ErrorInfo);

            return false;
        }
    }
}
