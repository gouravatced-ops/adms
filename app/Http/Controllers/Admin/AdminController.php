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
use App\Models\RegisterAllottee;
use App\Models\RegistrationFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function councilDashboard()
    {
        $user = auth('admin')->user();
        $divisionId = $user->division_id;
        $updatePasswordModal = $user->isPasswordExpired();

        $stats = $this->dashboardCounts($user->id);

        switch ($user->role) {

            case 'council_office':
                return view('admin.modules.dashboard.co-dashboard', array_merge($stats, [
                    'divisionCount'    => Division::where('status', 1)->count(),
                    'subdivisionCount' => SubDivision::where('status', 1)->count(),
                    'schemeCount'      => Scheme::where('is_active', 1)->count(),
                    'allotteeCount'    => Allottee::where('is_step_completed', 1)->count(),

                    'recentAllotteeList' => Allottee::with('division:id,name')
                        ->where('is_step_completed', 1)
                        ->latest()
                        ->limit(5)
                        ->get(),

                    'updatePasswordModal' => $updatePasswordModal
                ]));

            case 'approver':
                return view('admin.modules.dashboard.co-dashboard', array_merge(
                    $stats,
                    $this->approverStats($divisionId),
                    ['updatePasswordModal' => $updatePasswordModal]
                ));

            case 'divisional_admin':
                return view('admin.modules.dashboard.co-dashboard', array_merge(
                    $stats,
                    $this->divisionalStats(),
                    ['updatePasswordModal' => $updatePasswordModal]
                ));
        }

        return view('errors.403');
    }

    private function approverStats($divisionId)
    {
        $today = now();

        $subdivisionStats = SubDivision::where([
            'division_id' => $divisionId,
            'status' => 1
        ])
            ->withCount([
                'allottees as total_files_count' => fn($q) => $q->where('is_step_completed', 1),

                'allottees as verified_files_count' => fn($q) =>
                $q->where('is_step_completed', 1)->where('sub_admin_allottee_verify', 1),

                'allottees as approved_files_count' => fn($q) =>
                $q->where('is_step_completed', 1)->where('divisional_approval', 1),

                'allottees as pending_files_count' => fn($q) =>
                $q->where('is_step_completed', 1)
                    ->where(function ($sub) {
                        $sub->whereNull('sub_admin_allottee_verify')
                            ->orWhere('sub_admin_allottee_verify', '!=', 1);
                    }),
            ])
            ->get()
            ->map(fn($item) => tap($item, function ($i) {
                $i->progress_percent = $i->total_files_count > 0
                    ? round(($i->verified_files_count / $i->total_files_count) * 100)
                    : 0;
            }));

        // Chart Data Optimized
        $dates = collect(range(0, 29))->mapWithKeys(fn($i) => [
            now()->subDays($i)->format('Y-m-d') => 0
        ])->reverse();

        $raw = DB::table('allottees')
            ->selectRaw("DATE(divisional_approved_date) as date, COUNT(*) as total")
            ->where('division_id', $divisionId)
            ->where('divisional_approval', 1)
            ->whereNotNull('divisional_approved_date')
            ->whereDate('divisional_approved_date', '>=', now()->subDays(29))
            ->groupBy('date')
            ->pluck('total', 'date');

        $dates = $dates->merge($raw);

        return [
            'allDivisionFileCount' => Allottee::where([
                'division_id' => $divisionId,
                'is_step_completed' => 1
            ])->count(),

            'subdivisionStats' => $subdivisionStats,

            'recentVerifyAllotteeList' => Allottee::with(['division:id,name', 'subdivision:id,name'])
                ->where([
                    'division_id' => $divisionId,
                    'is_step_completed' => 1,
                    'sub_admin_allottee_verify' => 1,
                ])
                ->latest('sub_admin_checked_date')
                ->limit(5)
                ->get(),

            'todayApprovedCount' => Allottee::where('division_id', $divisionId)
                ->where('divisional_approval', 1)
                ->whereDate('divisional_approved_date', $today)
                ->count(),

            'chartData' => [
                'labels' => $dates->keys()->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m')),
                'data'   => $dates->values(),
            ],

            'monthRange' => now()->subDays(29)->format('F') . ' - ' . now()->format('F'),
        ];
    }

    private function divisionalStats()
    {
        return [
            'allDivisionFileCount' => Allottee::where('is_step_completed', 1)->count(),

            'subdivisionStats' => Division::where('status', 1)
                ->withCount([
                    'allottees as total_files_count' => fn($q) => $q->where('is_step_completed', 1),
                    'allottees as verified_files_count' => fn($q) =>
                    $q->where('is_step_completed', 1)->where('sub_admin_allottee_verify', 1),
                    'allottees as approved_files_count' => fn($q) =>
                    $q->where('is_step_completed', 1)->where('divisional_approval', 1),
                ])
                ->get(),

            'recentVerifyAllotteeList' => Allottee::with(['division:id,name', 'subdivision:id,name'])
                ->where('is_step_completed', 1)
                ->where('sub_admin_allottee_verify', 1)
                ->latest('sub_admin_checked_date')
                ->limit(5)
                ->get(),
        ];
    }

    private function dashboardCounts($userId)
    {
        $today = now()->toDateString();

        return [
            'stats' => [
                'totalreceivingFile' => RegisterAllottee::sum(
                    DB::raw("
                    COALESCE(
                        CASE 
                            WHEN parent_id IS NULL 
                                THEN no_of_files + no_of_supplement
                            ELSE 
                                no_of_supplement
                        END
                    ,0)
                ")
                ),

                'totalscannedFile' => RegisterAllottee::whereNotNull('scanned_by')
                    ->sum(DB::raw("
                    CASE 
                        WHEN parent_id IS NULL 
                            THEN COALESCE(no_of_files,0) + COALESCE(no_of_supplement,0)
                        ELSE 
                            COALESCE(no_of_supplement,0)
                    END
                ")),

                'totalAllotteeFile'  => Allottee::whereNotNull('register_file_id')->count(),
                'totalDataentryFile' => Allottee::whereNotNull('register_file_id')->where('is_step_completed', 1)->count(),
                // 'totaltransferFile'  => Allottee::whereNull('register_file_id')
                //     ->whereNotNull('parent_id')->count(),

                'totalcheckedFile'   => Allottee::whereNotNull('register_file_id')->where('sub_admin_allottee_verify', 1)->count(),
                'totalapprovedFile'  => Allottee::whereNotNull('register_file_id')->where('divisional_approval', 1)->count(),

                // 'totalhandoverreadyLots' => RegistrationFile::where('status', 'handover')->count(),
                // 'totallots'              => RegistrationFile::count(),

                // Checked
                'todayChecked' => Allottee::whereNotNull('register_file_id')->where('sub_admin_allottee_verify', 1)
                    ->whereDate('sub_admin_checked_date', $today)
                    ->where('is_step_completed', 1)
                    ->count(),

                'totalChecked' => Allottee::whereNotNull('register_file_id')->where('sub_admin_allottee_verify', 1)
                    ->where('is_step_completed', 1)
                    ->count(),

                // Approved (User Based)
                'todayApproved' => Allottee::whereNotNull('register_file_id')->where('divisional_approval', 1)
                    ->where('divisional_approved_by', $userId)
                    ->whereDate('divisional_approved_date', $today)
                    ->count(),

                'totalApproved' => Allottee::whereNotNull('register_file_id')->where('divisional_approval', 1)
                    ->where('divisional_approved_by', $userId)
                    ->count(),
            ],

            'labels' => [
                'totalreceivingFile' => 'Total Received Files',
                'totalscannedFile'   => 'Scanned Files',

                'totalAllotteeFile'  => 'TATO Files',
                // 'totaltransferFile'  => 'Transferred Files',

                'totalDataentryFile' => 'DTED Files',
                'totalcheckedFile'   => 'Checked Files',
                'totalapprovedFile'  => 'Approved Files',

                // 'totalhandoverreadyLots' => 'Handover Ready',
                // 'totallots'              => 'Total Lots',

                'todayChecked' => 'Today Checked',
                'totalChecked' => 'Total Checked',

                'todayApproved' => 'Today Approved',
                'totalApproved' => 'Total Approved',
            ],

            'icons' => [
                'totalreceivingFile' => '<i class="bx bx-file fs-2 text-primary"></i>',
                'totalscannedFile'   => '<i class="bx bx-scan fs-2 text-warning"></i>',

                'totalAllotteeFile'  => '<i class="bx bx-group fs-2 text-info"></i>',
                // 'totaltransferFile'  => '<i class="bx bx-transfer fs-2 text-purple"></i>',

                'totalDataentryFile' => '<i class="bx bx-edit fs-2 text-secondary"></i>',
                'totalcheckedFile'   => '<i class="bx bx-check-circle fs-2 text-success"></i>',
                'totalapprovedFile'  => '<i class="bx bx-badge-check fs-2 text-success"></i>',

                // 'totalhandoverreadyLots' => '<i class="bx bx-repost fs-2 text-warning"></i>',

                'todayChecked' => '<i class="bx bx-check-double fs-2 text-success"></i>',
                'totalChecked' => '<i class="bx bx-check-shield fs-2 text-success"></i>',

                'todayApproved' => '<i class="bx bx-calendar-check fs-2 text-primary"></i>',
                'totalApproved' => '<i class="bx bx-award fs-2 text-success"></i>',
            ]
        ];
    }

    public function registarDashboard()
    {
        $updatePasswordModal = auth('admin')->user()->isPasswordExpired();

        return view('admin.modules.dashboard.rgtr-dashboard', compact('updatePasswordModal'));
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
        try {

            Log::info('Update Admin Request Received', [
                'request' => $request->all(),
                'admin_id' => auth('admin')->id()
            ]);

            $validated = $request->validate([
                'name'        => 'required|string|max:100',
                'email'       => 'nullable|email',
                'gender'      => 'nullable|string',
                'file'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:204',
                'newPassword' => 'nullable|min:6',
                'newPassword_confirmation' => 'nullable|required_with:newPassword|same:newPassword',
                'designation' => 'nullable|string',
                'captcha'     => 'required|captcha'
            ]);

            Log::info('Validation Passed', $validated);

            $admin = auth('admin')->user();
            $profilePic = $admin->profile_path ?? null;

            // File Upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $folderPath = public_path('admin_pic');

                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                    Log::info('Folder Created', ['path' => $folderPath]);
                }

                $file->move($folderPath, $fileName);
                $profilePic = 'admin_pic/' . $fileName;

                Log::info('File Uploaded', ['file' => $profilePic]);
            }

            // Update Admin
            $adminDetails = Admin::updateOrCreate(
                ['id' => $admin->id],
                [
                    'admin_name'  => $validated['name'],
                    'gender'      => $validated['gender'] ?? null,
                    'email_id'    => $validated['email'] ?? null,
                    'designation' => $validated['designation'] ?? null,
                    'profile_path' => $profilePic,
                ]
            );

            Log::info('Admin Updated', ['admin_id' => $admin->id]);

            // Password Update
            if (!empty($validated['newPassword'])) {
                $admin->update([
                    'password' => Hash::make($validated['newPassword']),
                    'password_created_at' => now(),
                ]);

                Log::info('Password Updated', ['admin_id' => $admin->id]);
            }

            return back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {

            Log::error('Admin Update Failed', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile()
            ]);

            // Debug (only in local)
            if (config('app.debug')) {
                return back()->with('error', $e->getMessage());
            }

            return back()->with('error', 'Something went wrong!');
        }
    }

    public function updateDashboardPassword(Request $request)
    {
        $request->validate([
            'oldPassword' => ['required', 'string', 'min:8'],
            'newPassword' => ['required', 'string', 'min:8', 'confirmed'],
            'captcha' => ['required', 'captcha'],
        ]);

        $admin = auth('admin')->user();

        if (!Hash::check($request->input('oldPassword'), $admin->password)) {
            return redirect()->back()
                ->withErrors(['oldPassword' => 'The old password is incorrect.'])
                ->withInput();
        }

        $admin->password = Hash::make($request->input('newPassword'));
        $admin->password_created_at = now();
        $admin->save();

        return redirect()->back()->with('success', 'Password updated successfully.');
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
