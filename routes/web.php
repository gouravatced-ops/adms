<?php
use Illuminate\Support\Facades\Route;
// Applicant Routes
require base_path('routes/applicant.php');

// Admins Routes
require base_path('routes/admin-routes.php');

Route::get('/get-sub-divisions/{division}', function ($division) {
    return response()->json(getSubDivisions($division));
});

Route::get('/get-property-types/{category}', function ($category) {
    return response()->json(getPropertyType($category));
});

Route::get('/get-property-sub-types/{typeId}', function ($typeId) {
    return response()->json(getPropertySubType($typeId));
});

