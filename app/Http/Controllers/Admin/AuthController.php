<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminOtpLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\OtpLog;
use App\Models\StudentApplication;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class AuthController extends Controller
{
    // Show the login form
    public function twoFactorAuthAdmin()
    {
        $username = session('username');

        if (empty($username)) {
            return redirect()->route('admin.login')->with('LoginError', 'Your session has expired. Please log in again.');
        }
        return view('admin.auth.two-step-auth');
    }

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();

            $expirationTime = Carbon::parse($admin->otp_verified_at);
            $expirationTime->addHours(2);

            if (Carbon::now()->lessThanOrEqualTo($expirationTime)) {

                return match ($admin->role) {
                    'superadmin' => redirect()->route('superadmin.dashboard'),
                    'council_office' => redirect()->route('council_office.dashboard'),
                    'registrar' => redirect()->route('registrar.dashboard'),
                    default => redirect()->route('admin.login')->with('error', 'Unauthorized access.'),
                };
            }
        }

        if (Auth::guard('web')->check()) {
            return redirect()->back();
        }
        return view('admin.auth.login');
    }

    public function forgotPasswordAdmin(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();

            $expirationTime = Carbon::parse($admin->otp_verified_at);
            $expirationTime->addHours(2);

            if (Carbon::now()->lessThanOrEqualTo($expirationTime)) {

                return match ($admin->role) {
                    'superadmin' => redirect()->route('superadmin.dashboard'),
                    'council_office' => redirect()->route('council_office.dashboard'),
                    'registrar' => redirect()->route('registrar.dashboard'),
                    default => redirect()->route('admin.login')->with('error', 'Unauthorized access.'),
                };
            }
        }

        if (Auth::guard('web')->check()) {
            return redirect()->back();
        }
        return view('admin.auth.forgot-password');
    }
    public function forgotPassAdminOtp(Request $request)
    {
        $admin = Admin::where('email_id', $request->username)->first();
        if ($admin) {
            $this->sendOtp($request, 'reset' , $request->username);
            session(['username' => $request->username]);
            session(['success' => "OTP sent successfully to your Email Id ({$request->username}). It is valid for 15 minutes."]);
            return back()->with('success', "OTP sent successfully to your Email Id ({$request->username}). It is valid for 15 minutes.");
        } else {
            return back()->with('notValid', "No applicant found to your Email Id ({$request->username}).");
        }
    }

    public function AdminResendOtp(Request $request)
    {
        $admin = Admin::where('username', $request->username)->first();

        if ($admin) {
            session(['username' => $request->username]);
            $this->resendOtp($request);
            session(['success' => "OTP sent successfully to your Email Id ({$request->username}). It is valid for 15 minutes."]);
            return back()->with('success', "OTP sent successfully to your Email Id ({$request->username}). It is valid for 15 minutes.");
        } else {
            return back()->with('notValid', "No applicant found to your Email Id ({$request->username}).");
        }
    }
    public function forgotPasswordAdminUpdate(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $username = session('username');
        // dd($username);
        if (empty($username)) {
            return redirect()->route('admin.login')->with('LoginError', 'Your session has expired. Please log in again.');
        }

        $otpLog = AdminOtpLogs::where('login_with', $username)
            ->where('status', 'pending')
            ->latest('id')
            ->first();

        if ($otpLog) {
            if ($otpLog->otp_expiration < now()) {
                $otpLog->update(['status' => 'expired']);
                return back()->with('verifyError', "Your OTP has expired. Please request a new one to proceed.");
            }

            if ($otpLog->attempts == '5') {
                $otpLog->update(['status' => 'expired']);
                return back()->with('verifyError', "You have reached the maximum number of OTP attempts. Please request a new OTP to continue.");
            }

            $secretKey = env('OTP_SECRET_KEY');
            $providedOtpHmac = hash_hmac('sha256', $request->input('otp'), $secretKey);

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=[]{}|;:,.<>?';

            $randPass = substr(str_shuffle(str_repeat($characters, ceil(8 / strlen($characters)))), 1, 8);

            if ($providedOtpHmac === $otpLog->otp_hmac) {
                session()->forget('username');

                $admin = Admin::where('email_id', $username)->first();
                $adminEmailId = $admin->email_id;
                $admin->password = Hash::make($randPass);
                $admin->password_created_at = Carbon::now();
                $admin->prev_password = null;

                $admin->save();

                $message = view('emails.temp_password', compact('randPass'))->render();
                $this->sendSMS($adminEmailId, $message, 'Reset Password');

                return redirect()->route('admin.login')->with('LoginError', 'Your temporary password has been sent to your registered email Id.');
            } else {
                $otpLog->increment('attempts');
                return back()->with('verifyError', 'Invalid OTP.');
            }
        } else {
            return back()->with('verifyError', 'No OTP found. Please request a new one.');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|string',
            'captcha'  => 'required|captcha',
        ]);

        $credentials = ['email_id' => $request->username, 'password' => $request->password];

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        
        $loginInput = $request->username;
        $admin = Admin::where(function ($query) use ($loginInput) {
            $query->where('mobile_no', $loginInput)
                ->orWhere('email_id', $loginInput);
        })->latest()->first();

        if (Auth::guard('admin')->attempt($credentials)) {
            $emailId = $admin->email_id;
            $admin = Auth::guard('admin')->user();
            $expirationTime = Carbon::parse($admin->otp_verified_at);
            $expirationTime->addHours(2);

            if (Carbon::now()->lessThanOrEqualTo($expirationTime)) {
                    $admin = Auth::guard('admin')->user();

                    $admin->last_login = Carbon::now();
                    $admin->otp_verified_at = Carbon::now();
                    $admin->last_ip = request()->ip();
                    $admin->save();

                    Auth::login($admin);
                    return match ($admin->role) {
                        'superadmin' => redirect()->route('superadmin.dashboard'),
                        'council_office' => redirect()->route('council_office.dashboard'),
                        'registar' => redirect()->route('registrar.dashboard'),
                        default => redirect()->route('admin.login')->with('error', 'Invalid role'),
                    };
            } else {
                $admin = Auth::guard('admin')->user();

                $admin->last_login = Carbon::now();
                $admin->otp_verified_at = Carbon::now();
                $admin->last_ip = request()->ip();
                $admin->save();

                Auth::login($admin);
                return match ($admin->role) {
                    'superadmin' => redirect()->route('superadmin.dashboard'),
                    'council_office' => redirect()->route('council_office.dashboard'),
                    'registar' => redirect()->route('registrar.dashboard'),
                    default => redirect()->route('admin.login')->with('error', 'Invalid role'),
                };
            }
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
    public function sendOtp(Request $request, $type = '' , $emailId)
    {
        $request->validate([
            'username' => 'required',
        ]);

        $otp = random_int(100000, 999999);
        $hashedOtp = Hash::make($otp);

        $secretKey = env('OTP_SECRET_KEY');

        $otpHmac = hash_hmac('sha256', $otp, $secretKey);

        AdminOtpLogs::create([
            'login_with' => $request->username,
            'hashed_otp' => $hashedOtp,
            'otp_expiration' => now()->addMinutes(15),
            'send_ip' => request()->ip(),
            'otp_hmac' => $otpHmac,
            'description' => empty($type) ? "Login" : "Reset Password",
        ]);

        $message = view('emails.login_otp', compact('otp'))->render();
        $this->sendSMS($emailId, $message , $type);

    }

    public function resendOtp(Request $request)
    {
        dd(session());
        $username = session('username');

        $admin = Admin::where(function ($query) use ($username) {
            $query->where('mobile_no', $username)
                ->orWhere('email_id', $username);
        })->latest()->first();

        if (empty($username)) {
            return redirect()->route('login')->with('LoginError', 'Your session has expired. Please log in again.');
        }

        $emailId = $admin->email_id;
        $otp = random_int(100000, 999999);
        $hashedOtp = Hash::make($otp);

        $secretKey = env('OTP_SECRET_KEY');

        $otpHmac = hash_hmac('sha256', $otp, $secretKey);

        OtpLog::create([
            'login_with' => $username,
            'hashed_otp' => $hashedOtp,
            'otp_expiration' => now()->addMinutes(15),
            'otp_hmac' => $otpHmac,
            'description' => 'Resend OTP'
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

        $username = session('username');

        if (empty($username)) {
            return redirect()->route('admin.login')->with('LoginError', 'Your session has expired. Please log in again.');
        }

        $otpLog = AdminOtpLogs::where('login_with', $username)
            ->where('status', 'pending')
            ->latest('id')
            ->first();

        if ($otpLog) {
            if ($otpLog->otp_expiration < now()) {
                $otpLog->update(['status' => 'expired']);
                return back()->with('error', "Your OTP has expired. Please request a new one to proceed.");
            }

            if ($otpLog->attempts == '5') {
                $otpLog->update(['status' => 'expired']);
                return back()->with('error', "You have reached the maximum number of OTP attempts. Please request a new OTP to continue.");
            }

            $secretKey = env('OTP_SECRET_KEY');
            $providedOtpHmac = hash_hmac('sha256', $request->input('otp'), $secretKey);

            if ($providedOtpHmac === $otpLog->otp_hmac) {
                // if (Hash::check($request->otp, $otpLog->hashed_otp)) {
                $otpLog->update(['status' => 'verified']);
                session()->forget('username');

                $admin = Auth::guard('admin')->user();

                $admin->last_login = Carbon::now();
                $admin->otp_verified_at = Carbon::now();
                $admin->last_ip = request()->ip();
                $admin->save();

                Auth::login($admin);
                return match ($admin->role) {
                    'superadmin' => redirect()->route('superadmin.dashboard'),
                    'council_office' => redirect()->route('council_office.dashboard'),
                    'registar' => redirect()->route('registrar.dashboard'),
                    default => redirect()->route('admin.login')->with('error', 'Invalid role'),
                };
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

    public function sendSMS($emailId, $message, $subject = 'OTP for Admin Login - JSHB')
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
            $mail->setFrom('gourav@computered.co.in', 'JSHB');

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
