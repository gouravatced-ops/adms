<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\QuarterType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class QuarterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quarterTypes = QuarterType::ordered()->get();

        return view('admin.quarter-types.index', compact('quarterTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.quarter-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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
                ->with('error', 'An error occurred while creating the quarter type. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuarterType $quarterType)
    {
        return view('admin.quarter-types.edit', compact('quarterType'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuarterType $quarterType)
    {
        try {
            // Check if quarter type is being used
            $isUsed = DB::table('properties')->where('quarter_type_id', $quarterType->quarter_id)->exists();

            if ($isUsed) {
                return redirect()
                    ->back()
                    ->with('error', 'Cannot delete quarter type. It is being used by properties.');
            }

            $quarterType->delete();

            // Log the deletion
            Log::info('Quarter Type Deleted', [
                'id' => $quarterType->quarter_id,
                'code' => $quarterType->quarter_code,
                'name' => $quarterType->quarter_name,
                'by' => Auth::user()->id,
            ]);

            return redirect()
                ->route('admin.quarter-types.index')
                ->with('success', 'Quarter type deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting quarter type', [
                'id' => $quarterType->quarter_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'An error occurred while deleting the quarter type. Please try again.');
        }
    }

    /**
     * Toggle status of quarter type.
     */
    public function toggleStatus(QuarterType $quarterType)
    {
        try {
            $quarterType->update([
                'status' => $quarterType->status == 1 ? 0 : 1
            ]);

            $status = $quarterType->status == 1 ? 'activated' : 'deactivated';

            // Log the status change
            Log::info('Quarter Type Status Changed', [
                'id' => $quarterType->quarter_id,
                'code' => $quarterType->quarter_code,
                'status' => $quarterType->status,
                'by' => Auth::user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Quarter type {$status} successfully!",
                'new_status' => $quarterType->status,
                'status_text' => $quarterType->status_text,
                'status_class' => $quarterType->status_class,
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling quarter type status', [
                'id' => $quarterType->quarter_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again.',
            ], 500);
        }
    }

    /**
     * Get quarter type for a specific income (API).
     */
    public function getQuarterForIncome(Request $request)
    {
        $request->validate([
            'income' => 'required|numeric|min:0',
        ]);

        try {
            $quarterType = QuarterType::forIncome($request->income)->first();

            if ($quarterType) {
                return response()->json([
                    'success' => true,
                    'quarter_type' => [
                        'id' => $quarterType->quarter_id,
                        'code' => $quarterType->quarter_code,
                        'name' => $quarterType->quarter_name,
                        'income_range' => $quarterType->income_range,
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No quarter type found for the given income.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting quarter type for income', [
                'income' => $request->income,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
            ], 500);
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

    /**
     * Bulk update display order.
     */
    public function updateDisplayOrder(Request $request)
    {
        try {
            $request->validate([
                'order' => 'required|array',
                'order.*.id' => 'required|exists:quarter_type,quarter_id',
                'order.*.order' => 'required|integer|min:0',
            ]);

            DB::beginTransaction();

            foreach ($request->order as $item) {
                QuarterType::where('quarter_id', $item['id'])
                    ->update(['display_order' => $item['order']]);
            }

            DB::commit();

            Log::info('Quarter Types Display Order Updated', [
                'count' => count($request->order),
                'by' => Auth::user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Display order updated successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error updating display order', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating display order.',
            ], 500);
        }
    }
}
