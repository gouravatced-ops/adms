<?php

use App\Http\Controllers\Admin\SuperAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/superadmin/dashboard', function () {
    return view('admin.superadmin.dashboard');
})->name('superadmin.dashboard');
Route::post('/admins/create', [SuperAdminController::class, 'createAdmin'])->name('admins.store');
Route::get('/admins/create', function () {
    return view('admin.superadmin.create-admin');
})->name('admins.create');

Route::get('/admins/view-admins', [SuperAdminController::class, 'showAdmins'])->name('admins.view-admins');
Route::put('/admins/{id}', [SuperAdminController::class, 'update'])->name('admins.update');
