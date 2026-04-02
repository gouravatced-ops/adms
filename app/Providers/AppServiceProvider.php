<?php

namespace App\Providers;

use App\Http\Middleware\AdminAuth;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\CheckAdminRole;
use Illuminate\Support\Facades\Route;

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
    }
}
