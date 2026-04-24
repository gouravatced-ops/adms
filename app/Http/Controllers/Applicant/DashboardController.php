<?php

namespace App\Http\Controllers\Applicant;

// use App\Models\StudentRegistration;
use App\Models\User;
use App\Models\RegisterAllottee;
use App\Models\RegistrationFile;
use App\Models\Allottee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function index()
    {
        $userId = auth()->id();
        $today = now()->toDateString();

        $stats = [
            // RegisterAllottee
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

            // Allottee
            'totalAllotteeFile' => Allottee::whereNotNull('register_file_id')->count(),
            'totaltransferFile' => Allottee::whereNull('register_file_id')
                ->whereNotNull('parent_id')
                ->count(),
            'totalDataentryFile' => Allottee::whereNotNull('register_file_id')->where('is_step_completed', 1)->count(),
            'totalcheckedFile' => Allottee::whereNotNull('register_file_id')->where('sub_admin_allottee_verify', 1)->count(),
            'totalapprovedFile' => Allottee::whereNotNull('register_file_id')->where('divisional_approval', 1)->count(),

            // RegistrationFile
            'totalhandoverreadyLots' => RegistrationFile::where('status', 'handover')->count(),
            'totallots' => RegistrationFile::count(),

            // User stats
            'todayDataentryCount' => Allottee::whereNotNull('register_file_id')->where('created_by', $userId)
                ->whereDate('created_at', $today)
                ->where('is_step_completed', 1)
                ->count(),

            'totalDataentryByUser' => Allottee::whereNotNull('register_file_id')->where('created_by', $userId)->count(),

            'totalPendingdataentryFile' => Allottee::whereNotNull('register_file_id')->where('created_by', $userId)
                ->where('is_step_completed', 0)
                ->count(),
        ];
        // return $stats;
        return view('applicant.dashboard_components.dashboard', $stats);
    }

    public function accountSettings()
    {
        $studentRegis = User::where('id', auth()->id())->first();
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
