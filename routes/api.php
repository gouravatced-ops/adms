<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\RegistrationController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/get-affi-college', [RegistrationController::class, 'getInstituteWeb'])->name('get-affi-college');

