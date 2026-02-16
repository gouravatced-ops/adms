<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuarterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class QuarterTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quarterTypes = QuarterType::get();
        return view('admin.components.quarter-types.index', compact('quarterTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.components.quarter-types.create');
    }


    public function store(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), QuarterType::validationRules());

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }


            // Create quarter type
            $quarterType = QuarterType::create([
                'quarter_code' => strtoupper(trim($request->quarter_code)),
                'quarter_name' => trim($request->quarter_name),
                'quarter_full_name' => $request->filled('quarter_full_name') ? trim($request->quarter_full_name) : null,
                'min_income' => $request->filled('min_income') ? $request->min_income : null,
                'max_income' => $request->filled('max_income') ? $request->max_income : null,
                'display_order' => $request->filled('display_order') ? $request->display_order : 0,
                'status' => $request->status,
            ]);

            // Log the creation
            Log::info('Quarter Type Created', [
                'id' => $quarterType->quarter_id,
                'code' => $quarterType->quarter_code,
                'name' => $quarterType->quarter_name,
                'by' => Auth::user()->id,
            ]);

            return redirect()
                ->route('admin.quarter-types.index')
                ->with('success', 'Quarter type created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating quarter type', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function edit(QuarterType $quarterType)
    {
        return view('admin.components.quarter-types.edit', compact('quarterType'));
    }


    public function update(Request $request, QuarterType $quarterType)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), QuarterType::validationRules($quarterType->quarter_id));

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }


            // Update quarter type
            $quarterType->update([
                'quarter_code' => strtoupper(trim($request->quarter_code)),
                'quarter_name' => trim($request->quarter_name),
                'quarter_full_name' => $request->filled('quarter_full_name') ? trim($request->quarter_full_name) : null,
                'min_income' => $request->filled('min_income') ? $request->min_income : null,
                'max_income' => $request->filled('max_income') ? $request->max_income : null,
                'display_order' => $request->filled('display_order') ? $request->display_order : 0,
                'status' => $request->status,
            ]);

            // Log the update
            Log::info('Quarter Type Updated', [
                'id' => $quarterType->quarter_id,
                'code' => $quarterType->quarter_code,
                'name' => $quarterType->quarter_name,
                'by' => Auth::user()->id,
            ]);

            return redirect()
                ->route('admin.quarter-types.index')
                ->with('success', 'Quarter type updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating quarter type', [
                'id' => $quarterType->quarter_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'An error occurred while updating the quarter type. Please try again.')
                ->withInput();
        }
    }

    public function toggleStatus(QuarterType $quarterType)
    {
        try {
            if ($quarterType->status == 1) {
                // Inactivate
                $quarterType->update(['status' => 0]);

                $action = 'Inactivated';
            } else {
                // Activate
                $quarterType->update(['status' => 1]);

                $action = 'Activated';
            }

            Log::info("Quarter Type {$action}", [
                'id'   => $quarterType->quarter_id,
                'code' => $quarterType->quarter_code,
                'name' => $quarterType->quarter_name,
                'by'   => Auth::user()->id,
            ]);

            return redirect()
                ->route('admin.quarter-types.index')
                ->with('success', "Quarter type {$action} successfully!");
        } catch (\Exception $e) {

            Log::error('Quarter Type Status Toggle Error', [
                'id'    => $quarterType->quarter_id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }



    /**
     * Get quarter types for dropdown (API).
     */
    public function getQuarterTypesDropdown()
    {
        try {
            $quarterTypes = QuarterType::active()
                ->ordered()
                ->get(['quarter_id', 'quarter_code', 'quarter_name', 'income_range']);

            return response()->json([
                'success' => true,
                'data' => $quarterTypes
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching quarter types dropdown', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching quarter types.',
            ], 500);
        }
    }
}