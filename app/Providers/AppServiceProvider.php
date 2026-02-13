<?php

namespace App\Providers;

use App\Http\Middleware\AdminAuth;
use App\Models\StudentRegistration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\CheckAdminRole;
use App\Models\ApprovedApplicants;
use Illuminate\Support\Facades\Route;
use App\Models\StudentApplication;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app['router']->aliasMiddleware('admin.auth', AdminAuth::class);

        Route::aliasMiddleware('admin.role', CheckAdminRole::class);

        View::composer('admin.layouts.menus', function ($view) {
            $incompleteCount = StudentApplication::where('status', 'submitted')
                ->where('auth', 'council_office')
                ->where('auth_status', 'incomplete')
                ->count();
            $pendingCount = StudentApplication::where('status', 'submitted')
                ->where('auth_status', 'pending')
                ->where('auth', 'council_office')
                ->count();
            $acceptCount = StudentApplication::where('status', 'submitted')
                ->where('auth', 'council_office')
                ->where('auth_status', 'accept')
                ->count();
            $rejectCount = StudentApplication::where('status', 'submitted')
                ->where('auth', 'council_office')
                ->where('auth_status', 'reject')
                ->count();
            $registeredApplicantCount = StudentRegistration::count();

            $registarRejectCount = StudentApplication::where('status', 'submitted')
                ->where('auth', 'registar')
                ->where('auth_status', 'reject')
                ->count();

            $approvedStudentIds = ApprovedApplicants::pluck('student_application_id');

            $approvedApplicantCount = StudentApplication::where('student_applications.status', 'submitted')
                ->leftJoin('approved_applicants', 'approved_applicants.student_application_id', '=', 'student_applications.id')
                ->where('student_applications.auth', 'registar')
                ->where('student_applications.auth_status', 'approved')
                ->whereNotIn('student_applications.id', $approvedStudentIds)
                ->count();
                // dd($approvedApplicantCount);

            $generatedApplicantCount = StudentApplication::where('student_applications.status', 'submitted')
                ->join('approved_applicants', 'approved_applicants.student_application_id', '=', 'student_applications.id')
                ->where('student_applications.auth', 'registar')
                ->where('student_applications.auth_status', 'approved')
                ->where('approved_applicants.signed_certificate_path', '=', null)
                ->count();
            // dd($approvedApplicantCount);
            $signApplicantCount = StudentApplication::where('student_applications.status', 'submitted')
                ->join('approved_applicants', 'approved_applicants.student_application_id', '=', 'student_applications.id')
                ->where('student_applications.auth', 'registar')
                ->where('student_applications.auth_status', 'approved')
                ->where('approved_applicants.signed_certificate_path', '<>', null)
                ->count();

            $inst = DB::table('institutes')->count();

            $view->with(compact('pendingCount', 'incompleteCount', 'acceptCount', 'rejectCount', 'registeredApplicantCount', 'approvedApplicantCount', 'generatedApplicantCount', 'signApplicantCount', 'registarRejectCount', 'inst'));
        });
    }
}
