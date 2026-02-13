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

class AuthController extends Controller
{
    // Show the login form
    public function twoFactorAuthAdmin()
    {
        $mobileNumber = session('mobile_number');

        if (empty($mobileNumber)) {
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
        $admin = Admin::where('mobile_no', $request->mobile_no)->first();
        if ($admin) {
            $this->sendOtp($request, 'reset');
            session(['mobile_number' => $request->mobile_no]);
            session(['success' => "OTP sent successfully to your mobile number ({$request->mobile_no}). It is valid for 15 minutes."]);
            return back()->with('success', "OTP sent successfully to your mobile number ({$request->mobile_no}). It is valid for 15 minutes.");
        } else {
            return back()->with('notValid', "No applicant found to your mobile number ({$request->mobileNumber}).");
        }
    }

    public function AdminResendOtp(Request $request)
    {
        $admin = Admin::where('mobile_no', $request->mobile_number)->first();

        if ($admin) {
            session(['mobile_number' => $request->mobile_no]);
            $this->resendOtp($request);
            session(['success' => "OTP sent successfully to your mobile number ({$request->mobile_no}). It is valid for 15 minutes."]);
            return back()->with('success', "OTP sent successfully to your mobile number ({$request->mobile_no}). It is valid for 15 minutes.");
        } else {
            return back()->with('notValid', "No applicant found to your mobile number ({$request->mobileNumber}).");
        }
    }
    public function forgotPasswordAdminUpdate(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $mobileNumber = session('mobile_number');
        // dd($mobileNumber);
        if (empty($mobileNumber)) {
            return redirect()->route('admin.login')->with('LoginError', 'Your session has expired. Please log in again.');
        }

        $otpLog = AdminOtpLogs::where('mobile_number', $mobileNumber)
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
                session()->forget('mobile_number');

                $admin = Admin::where('mobile_no', $mobileNumber)->first();
                $admin->password = Hash::make($randPass);
                $admin->password_created_at = Carbon::now();
                $admin->prev_password = null;

                $admin->save();

                $message = "{$randPass} is your temporary password.-JSPCRN";
                $this->sendSMS($mobileNumber, $message);

                return redirect()->route('admin.login')->with('LoginError', 'Your Temporary password sent to mobile use this password to login.');

                // Auth::login($admin);
                // return match ($admin->role) {
                //     'superadmin' => redirect()->route('superadmin.dashboard'),
                //     'council_office' => redirect()->route('council_office.dashboard'),
                //     'registar' => redirect()->route('registrar.dashboard'),
                //     default => redirect()->route('admin.login')->with('verifyError', 'Invalid role'),
                // };
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
            'mobile_no' => 'required|numeric',
            'password' => 'required|string',
            'mobileType' => 'required|in:primary,alternate',
        ]);

        $credentials = ($request->mobileType == 'primary')
            ? ['mobile_no' => $request->mobile_no, 'password' => $request->password]
            : ['alt_mobile_no' => $request->mobile_no, 'password' => $request->password];
        // dd(Auth::guard('admin'));
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $admin = Admin::where('mobile_no', $request->mobile_no)->first();

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            $expirationTime = Carbon::parse($admin->otp_verified_at);
            $expirationTime->addHours(2);

            if (Carbon::now()->lessThanOrEqualTo($expirationTime)) {
                $admin->last_login = Carbon::now();
                $admin->last_ip = request()->ip();
                $admin->save();

                // $request->session()->regenerate();

                Auth::login($admin);
                return match ($admin->role) {
                    'superadmin' => redirect()->route('superadmin.dashboard'),
                    'council_office' => redirect()->route('council_office.dashboard'),
                    'registar' => redirect()->route('registrar.dashboard'),
                    default => redirect()->route('admin.login')->with('error', 'Invalid role'),
                };
            } else {
                $this->sendOtp($request);
                session(['mobile_number' => $request->mobile_no]);
                return redirect()->route('admin.two-step-auth');
            }
        }

        return back()->withErrors([
            'mobile_no' => 'The provided credentials do not match our records.',
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

        // Send OTP via SMS
        $message = view('emails.login_otp', compact('otp'))->render();

        $this->sendSMS($emailId, $message);

    }

    public function resendOtp(Request $request)
    {
        dd(session());
        $mobileNumber = session('mobile_number');

        if (empty($mobileNumber)) {
            return redirect()->route('login')->with('LoginError', 'Your session has expired. Please log in again.');
        }

        $otp = random_int(100000, 999999);
        $hashedOtp = Hash::make($otp);

        $secretKey = env('OTP_SECRET_KEY');

        $otpHmac = hash_hmac('sha256', $otp, $secretKey);

        OtpLog::create([
            'mobile_number' => $mobileNumber,
            'hashed_otp' => $hashedOtp,
            'otp_expiration' => now()->addMinutes(15),
            'otp_hmac' => $otpHmac,
            'description' => 'Resend OTP'
        ]);

        // Send OTP via SMS
        $message = "{$otp} is OTP for Login-JSPCRN";

        $this->sendSMS($mobileNumber, $message);
        $this->sendSMS('7979040859', $message);

        // return back()->with('success', 'A new OTP has been sent to your mobile number ({$request->mobileNumber}). It is valid for 15 minutes.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $mobileNumber = session('mobile_number');

        if (empty($mobileNumber)) {
            return redirect()->route('admin.login')->with('LoginError', 'Your session has expired. Please log in again.');
        }

        $otpLog = AdminOtpLogs::where('mobile_number', $mobileNumber)
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
                session()->forget('mobile_number');

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
    public function sendSMS($mobileNo, $message)
    {
        $postData = [
            'mobileNumbers' => $mobileNo,
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
