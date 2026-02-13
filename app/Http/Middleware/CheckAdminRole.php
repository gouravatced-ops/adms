<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckAdminRole
{

    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth('admin')->check()) {
            return redirect('admin/login');
        }

        $admin = auth('admin')->user();

        if (in_array($admin->role, $roles)) {
            return $next($request);
        }

        // Log the attempt
        // Log::info('Admin ID: ' . $admin->id);
        // Log::info('Admin role: ' . $admin->role);
        // Log::info('Required roles: ' . implode(', ', $roles));

        abort(403, 'Unauthorized action.');
    }
}
