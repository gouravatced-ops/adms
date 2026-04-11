<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminDetails;
use App\Models\AdminOtpLogs;
use App\Models\Scheme;
use App\Models\Division;
use App\Models\SubDivision;
use App\Models\Allottee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function councilDashboard()
    {
        $user       = auth('admin')->user();
        $divisionId = $user->division_id;

        if ($user->role === 'council_office') {

            $divisionCount    = Division::where('status', 1)->count();
            $subdivisionCount = SubDivision::where('status', 1)->count();
            $schemeCount      = Scheme::where('is_active', 1)->count();
            $allotteeCount    = Allottee::where('is_step_completed', 1)->count();

            $recentAllotteeList = Allottee::with('division:id,name')
                ->where('is_step_completed', 1)
                ->latest()
                ->take(5)
                ->get();

            return view('admin.modules.dashboard.co-dashboard', compact(
                'divisionCount',
                'subdivisionCount',
                'schemeCount',
                'allotteeCount',
                'recentAllotteeList'
            ));
        }

        if ($user->role === 'approver') {

            $allDivisionFileCount = Allottee::where([
                'division_id'       => $divisionId,
                'is_step_completed' => 1,
            ])->count();

            $subdivisionStats = SubDivision::query()
                ->where([
                    'division_id' => $divisionId,
                    'status'      => 1,
                ])
                ->withCount([
                    'allottees as total_files_count' => function ($q) {
                        $q->where('is_step_completed', 1);
                    },

                    'allottees as verified_files_count' => function ($q) {
                        $q->where('is_step_completed', 1)
                            ->where('sub_admin_allottee_verify', 1);
                    },

                    'allottees as approved_files_count' => function ($q) {
                        $q->where('is_step_completed', 1)
                            ->where('divisional_approval', 1);
                    },

                    'allottees as pending_files_count' => function ($q) {
                        $q->where('is_step_completed', 1)
                            ->where(function ($sub) {
                                $sub->whereNull('sub_admin_allottee_verify')
                                    ->orWhere('sub_admin_allottee_verify', '!=', 1);
                            });
                    },
                ])
                ->get()
                ->map(function ($subdivision) {
                    $subdivision->progress_percent = $subdivision->total_files_count > 0
                        ? round(($subdivision->verified_files_count / $subdivision->total_files_count) * 100)
                        : 0;

                    return $subdivision;
                });

            $recentVerifyAllotteeList = Allottee::with([
                'division:id,name',
                'subdivision:id,name'
            ])
                ->where([
                    'division_id'               => $divisionId,
                    'is_step_completed'         => 1,
                    'sub_admin_allottee_verify' => 1,
                ])
                ->latest('sub_admin_checked_date')
                ->take(5)
                ->get();

            $todayApprovedCount = DB::table('allottees')
                ->where('division_id', $divisionId)
                ->where('divisional_approval', 1)
                ->whereDate('divisional_approved_date', Carbon::today())
                ->count();

            $rawData = DB::table('allottees')
                ->selectRaw("DATE(divisional_approved_date) as date, COUNT(*) as total")
                ->where('division_id', $divisionId)
                ->where('divisional_approval', 1)
                ->whereNotNull('divisional_approved_date')
                ->whereDate('divisional_approved_date', '>=', Carbon::now()->subDays(29))
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();

            $dates = collect();

            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $dates->put($date, 0);
            }

            foreach ($rawData as $item) {
                $dates[$item->date] = $item->total;
            }

            $chartData = [
                'labels' => $dates->keys()->map(fn($d) => Carbon::parse($d)->format('d/m'))->values(),
                'data'   => $dates->values(),
            ];

            $startMonth = Carbon::now()->subDays(29)->format('F');
            $endMonth   = Carbon::now()->format('F');

            $monthRange = $startMonth . ' - ' . $endMonth;

            // return [$allDivisionFileCount , $subdivisionStats , $recentVerifyAllotteeList];
            return view('admin.modules.dashboard.co-dashboard', compact(
                'allDivisionFileCount',
                'subdivisionStats',
                'recentVerifyAllotteeList',
                'todayApprovedCount',
                'chartData',
                'monthRange'
            ));
        }

        return view('error.403');
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
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:204', // 200KB
            'newPassword' => 'nullable|confirmed|min:6',
            'designation' => 'nullable|string'
        ]);

        $admin = auth('admin')->user();
        $profilePic = $admin->profile_path ?? null;

        // File upload (only if exists)
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $folderPath = public_path('admin_pic');

            // create folder if not exists
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $file->move($folderPath, $fileName);
            $profilePic = 'admin_pic/' . $fileName;
        }

        // Update or Create
        $adminDetails = Admin::updateOrCreate(
            ['id' => $admin->id],
            [
                'admin_name' => $validated['name'],
                'gender' => $validated['gender'],
                'email_id' => $validated['email'],
                'designation' => $validated['designation'],
                'profile_path' => $profilePic,
            ]
        );

        // Password update (only if provided)
        if (!empty($validated['newPassword'])) {
            $admin->update([
                'password' => Hash::make($validated['newPassword'])
            ]);
        }

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
