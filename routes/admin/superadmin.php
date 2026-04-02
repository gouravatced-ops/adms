<?php

use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Admin\DivisionsController;
use App\Http\Controllers\Admin\SubDivisionController;
use App\Http\Controllers\Admin\PropertyCategoryController;
use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\PropertyMainTypeController;
use App\Http\Controllers\Admin\QuarterTypeController;
use App\Http\Controllers\Admin\SchemeController;
use App\Http\Controllers\Admin\SchemeBlockController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/dashboard', [SuperAdminController::class, 'superadminDashboard'])->name('superadmin.dashboard');

Route::get('/divisions/list', [DivisionsController::class, 'index'])->name('admin.division.index');
Route::get('/divisions/create', [DivisionsController::class, 'createPage'])->name('admin.division.create');
Route::post('/divisions/store', [DivisionsController::class, 'store'])->name('admin.division.store');
Route::get('/divisions/fetch/{encode_id}', [DivisionsController::class, 'fetch'])->name('admin.division.fetch');
Route::put('/divisions/update/{encode_id}', [DivisionsController::class, 'update'])->name('admin.division.update');
Route::get('/divisions/{encode_id}', [DivisionsController::class, 'destroy'])->name('admin.division.delete');

Route::get('/subdivision/list', [SubDivisionController::class, 'index'])->name('admin.subdivision.index');
Route::get('/subdivision/create', [SubDivisionController::class, 'createPage'])->name('admin.subdivision.create');
Route::post('/subdivision/store', [SubDivisionController::class, 'store'])->name('admin.subdivision.store');
Route::get('/subdivision/fetch/{encode_id}', [SubDivisionController::class, 'fetch'])->name('admin.subdivision.fetch');
Route::put('/subdivision/update/{encode_id}', [SubDivisionController::class, 'update'])->name('admin.subdivision.update');
Route::get('/subdivision/{encode_id}', [SubDivisionController::class, 'destroy'])->name('admin.subdivision.delete');

Route::get('pcategory/list', [PropertyCategoryController::class, 'index'])->name('admin.pcategory.index');
Route::get('/pcategory/create', [PropertyCategoryController::class, 'createPage'])->name('admin.pcategory.create');
Route::post('/pcategory/store', [PropertyCategoryController::class, 'store'])->name('admin.pcategory.store');
Route::get('/pcategory/fetch/{encode_id}', [PropertyCategoryController::class, 'fetch'])->name('admin.pcategory.fetch');
Route::put('/pcategory/update/{encode_id}', [PropertyCategoryController::class, 'update'])->name('admin.pcategory.update');
Route::get('/pcategory/{encode_id}', [PropertyCategoryController::class, 'destroy'])->name('admin.pcategory.delete');

Route::get('/pcategorytype/list', [PropertyTypeController::class, 'index'])->name('admin.pcategorytype.index');
Route::get('/pcategorytype/create', [PropertyTypeController::class, 'createPage'])->name('admin.pcategorytype.create');
Route::post('/pcategorytype/store', [PropertyTypeController::class, 'store'])->name('admin.pcategorytype.store');
Route::get('/pcategorytype/fetch/{encode_id}', [PropertyTypeController::class, 'fetch'])->name('admin.pcategorytype.fetch');
Route::put('/pcategorytype/update/{encode_id}', [PropertyTypeController::class, 'update'])->name('admin.pcategorytype.update');
Route::get('/pcategorytype/{encode_id}', [PropertyTypeController::class, 'destroy'])->name('admin.pcategorytype.delete');

Route::get('/propertysubtypes/list', [PropertyMainTypeController::class, 'index'])->name('admin.propertysubtypes.index');
Route::get('/propertysubtypes/create', [PropertyMainTypeController::class, 'createPage'])->name('admin.propertysubtypes.create');
Route::post('/propertysubtypes/store', [PropertyMainTypeController::class, 'store'])->name('admin.propertysubtypes.store');
Route::get('/propertysubtypes/fetch/{encode_id}', [PropertyMainTypeController::class, 'fetch'])->name('admin.propertysubtypes.fetch');
Route::put('/propertysubtypes/update/{encode_id}', [PropertyMainTypeController::class, 'update'])->name('admin.propertysubtypes.update');
Route::get('/propertysubtypes/{encode_id}', [PropertyMainTypeController::class, 'destroy'])->name('admin.propertysubtypes.delete');

// Quarter Type Routes
Route::prefix('quarter-types')->name('admin.quarter-types.')->group(function () {
    Route::get('/list', [QuarterTypeController::class, 'index'])->name('index');
    Route::get('/create', [QuarterTypeController::class, 'create'])->name('create');
    Route::post('/store', [QuarterTypeController::class, 'store'])->name('store');
    Route::get('/{quarterType}/edit', [QuarterTypeController::class, 'edit'])->name('edit');
    Route::put('/{quarterType}', [QuarterTypeController::class, 'update'])->name('update');
    Route::post('/{quarterType}', [QuarterTypeController::class, 'toggleStatus'])->name('destroy');
    
    // Additional routes
    Route::post('/{quarterType}/toggle-status', [QuarterTypeController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/update-display-order', [QuarterTypeController::class, 'updateDisplayOrder'])->name('update-display-order');
    Route::get('/get-for-income', [QuarterTypeController::class, 'getQuarterForIncome'])->name('get-for-income');
    Route::get('/dropdown', [QuarterTypeController::class, 'getQuarterTypesDropdown'])->name('dropdown');
});

// Scheme Master Routes
Route::prefix('schemes')->name('admin.schemes.')->group(function () {
    // Main CRUD routes
    Route::get('/list', [SchemeController::class, 'index'])->name('index');
    Route::get('/create', [SchemeController::class, 'create'])->name('create');
    Route::post('/store', [SchemeController::class, 'store'])->name('store');
    Route::get('/{scheme}/edit', [SchemeController::class, 'edit'])->name('edit');
    Route::put('/{scheme}', [SchemeController::class, 'update'])->name('update');
    Route::delete('/{scheme}', [SchemeController::class, 'destroy'])->name('destroy');    
    
    // Status Management routes
    Route::post('/{scheme}/change-status', [SchemeController::class, 'changeStatus'])->name('change-status');
    Route::post('/{scheme}/toggle-active', [SchemeController::class, 'toggleActive'])->name('toggle-active');
    
    // API/Utility routes
    Route::get('/{scheme}/details', [SchemeController::class, 'getSchemeDetails'])->name('details');
    Route::get('/dropdown', [SchemeController::class, 'getSchemesForDropdown'])->name('dropdown');
    Route::post('/calculate-emi', [SchemeController::class, 'calculateEmi'])->name('calculate-emi');
});

// Scheme Master Routes
Route::prefix('schemes')->name('admin.schemes.')->group(function () {
    Route::get('/blocks/list/{schemeId}', [SchemeBlockController::class, 'index'])->name('blocks.manage');
    Route::get('/blocks/create/page', [SchemeBlockController::class, 'createPage'])->name('blocks.create.page');
    Route::post('/blocks/create', [SchemeBlockController::class, 'createBlocks'])->name('blocks.create');
    Route::get('/blocks/add/{schemeId}', [SchemeBlockController::class, 'addBlocksPage'])->name('blocks.add.page');
    Route::post('/blocks/individual/store', [SchemeBlockController::class, 'individualAdd'])->name('blocks.individual.store');
    Route::post('/blocks/individual/update', [SchemeBlockController::class, 'individualUpdate'])->name('blocks.individual.update');
    Route::post('/blocks/delete/{blockId}', [SchemeBlockController::class, 'schemeBlockDelete'])->name('blocks.individual.delete');
});
