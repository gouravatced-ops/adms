<?php

namespace App\Http\Controllers\Applicant;

// use App\Models\StudentRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }
    public function index()
    {
        return view('applicant.dashboard_components.dashboard');
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
