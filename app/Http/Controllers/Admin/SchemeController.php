<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchemeMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SchemeController extends Controller
{
    public function index()
    {
        $schemes = SchemeMaster::with(['creator', 'updater', 'propertyType'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $schemes->getCollection()->transform(function ($scheme) {
            $scheme->encoded_id = base64_encode($scheme->scheme_id);
            return $scheme;
        });
        return view('admin.components.schemes.index', compact('schemes'));
    }

    public function create()
    {
        return view('admin.components.schemes.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make(
                $request->all(),
                SchemeMaster::validationRules()
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Process JSON fields
            $data = $request->all();

            // Handle dimensions and arms
            $data['dimensions'] = json_encode($request->dimensions);
            $data['arms'] = json_encode($request->arms);

            // $schemeValue = (float) ($data['scheme_value'] ?? 0);
            // $downPaymentPercent = (float) ($data['down_payment_percentage'] ?? 0);

            // $data['down_payment_amount'] = ($schemeValue * $downPaymentPercent) / 100;

            // $principal = $schemeValue - $data['down_payment_amount'];
            // $annualRate = $data['compound_interest_rate'];       // %
            // $months = $data['emi_count'];             // n

            // $monthlyRate = $annualRate / (12 * 100); // r
            // $data['monthlyrate'] = $monthlyRate;
            // $calculationRate = pow(1 + $monthlyRate, $months);
            // $data['calculationRate'] =  round($calculationRate , 2);
            // $emi = ($principal * $monthlyRate * $calculationRate) /
            //     ($calculationRate - 1);

            // $emi = round($emi, 2);

            // $data['emi_amount'] = $emi;

            // Set default status if not provided
            if (!isset($data['status'])) {
                $data['status'] = 'draft';
            }

            // Set is_active if not provided
            if (!isset($data['is_active'])) {
                $data['is_active'] = true;
            }

            // Set created_by
            $data['created_by'] = Auth::id();
            $scheme = SchemeMaster::create($data);

            DB::commit();

            Log::info('Scheme created successfully', [
                'scheme_id' => $scheme->scheme_id,
                'scheme_name' => $scheme->scheme_name,
                'created_by' => Auth::id(),
            ]);

            return redirect()
                ->route('admin.schemes.index')
                ->with('success', "Scheme created successfully!");
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error creating scheme', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, SchemeMaster $scheme)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), SchemeMaster::validationRules($scheme->scheme_id));

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Process JSON fields
            $data = $request->all();

            // Handle dimensions and arms
            $data['dimensions'] = json_encode($request->dimensions);
            $data['arms'] = json_encode($request->arms);

            // // Handle subnames
            // if ($request->has('subname')) {
            //     $data['subnames'] = json_encode($request->subname);
            // } else {
            //     $data['subnames'] = null;
            // }

            // $schemeValue = (float) ($data['scheme_value'] ?? 0);
            // $downPaymentPercent = (float) ($data['down_payment_percentage'] ?? 0);

            // $data['down_payment_amount'] = ($schemeValue * $downPaymentPercent) / 100;

            // $principal = $schemeValue - $data['down_payment_amount'];
            // $annualRate = $data['compound_interest_rate'];       // %
            // $months = $data['emi_count'];             // n

            // $monthlyRate = $annualRate / (12 * 100); // r
            // $data['monthlyrate'] = $monthlyRate;
            // $calculationRate = pow(1 + $monthlyRate, $months);
            // $data['calculationRate'] =  round($calculationRate , 2);
            // $emi = ($principal * $monthlyRate * $calculationRate) /
            //     ($calculationRate - 1);

            // $emi = round($emi, 2);

            // $data['emi_amount'] = $emi;

            // Set updated_by
            $data['updated_by'] = Auth::id();

            $scheme->update($data);

            DB::commit();

            Log::info('Scheme updated successfully', [
                'scheme_id' => $scheme->scheme_id,
                'scheme_name' => $scheme->scheme_name,
                'updated_by' => Auth::id(),
            ]);

            return redirect()
                ->route('admin.schemes.index')
                ->with('success', "Scheme updated successfully!");
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error updating scheme', [
                'scheme_id' => $scheme->scheme_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function edit(SchemeMaster $scheme)
    {
        // return $scheme; die();
        return view('admin.components.schemes.edit', compact('scheme'));
    }

    public function destroy(SchemeMaster $scheme)
    {
        try {
            if ($scheme->is_active == 1) {
                // Inactivate
                $scheme->update(['is_active' => 0]);

                $action = 'Inactivated';
            } else {
                // Activate
                $scheme->update(['is_active' => 1]);

                $action = 'Activated';
            }
            $schemeName = $scheme->scheme_name;
            Log::info("Scheme {$action} successfully", [
                'scheme_id' => $scheme->scheme_id,
                'scheme_name' => $schemeName,
                'deleted_by' => Auth::user()->id,
            ]);

            return redirect()
                ->route('admin.schemes.index')
                ->with('success', "Scheme {$action} successfully!");
        } catch (\Exception $e) {

            Log::error('Scheme Status Toggle Error', [
                'id'    => $scheme->quarter_id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function changeStatus(Request $request, SchemeMaster $scheme)
    {
        try {
            $request->validate([
                'status' => 'required|in:draft,active,completed,cancelled'
            ]);

            $oldStatus = $scheme->status;
            $scheme->update([
                'status' => $request->status,
                'updated_by' => Auth::user()->id
            ]);

            Log::info('Scheme status changed', [
                'scheme_id' => $scheme->scheme_id,
                'old_status' => $oldStatus,
                'new_status' => $scheme->status,
                'changed_by' => Auth::user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Scheme status updated successfully!',
                'new_status' => $scheme->status,
                'status_badge' => $scheme->status_badge
            ]);
        } catch (\Exception $e) {
            Log::error('Error changing scheme status', [
                'scheme_id' => $scheme->scheme_id,
                'error' => $e->getMessage(),
                'user_id' => Auth::user()->id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the status.'
            ], 500);
        }
    }

    public function toggleActive(SchemeMaster $scheme)
    {
        try {
            $newStatus = !$scheme->is_active;
            $scheme->update([
                'is_active' => $newStatus,
                'updated_by' => Auth::user()->id
            ]);

            Log::info('Scheme active status toggled', [
                'scheme_id' => $scheme->scheme_id,
                'is_active' => $newStatus,
                'changed_by' => Auth::user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => $newStatus ? 'Scheme activated successfully!' : 'Scheme deactivated successfully!',
                'is_active' => $newStatus
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling scheme active status', [
                'scheme_id' => $scheme->scheme_id,
                'error' => $e->getMessage(),
                'user_id' => Auth::user()->id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the scheme.'
            ], 500);
        }
    }

    public function getSchemeDetails(SchemeMaster $scheme)
    {
        return response()->json([
            'success' => true,
            'scheme' => [
                'scheme_id' => $scheme->scheme_id,
                'scheme_name' => $scheme->scheme_name,
                'scheme_name_hindi' => $scheme->scheme_name_hindi,
                'scheme_code' => $scheme->scheme_code,
                'total_units' => $scheme->total_units,
                'area_sqft' => $scheme->area_sqft,
                'dimensions' => $scheme->dimensions,
                'arms' => $scheme->arms,
                'scheme_value' => $scheme->scheme_value,
                'down_payment_percentage' => $scheme->down_payment_percentage,
                'down_payment_amount' => $scheme->down_payment_amount,
                'application_deposit_percentage' => $scheme->application_deposit_percentage,
                'application_deposit_amount' => $scheme->application_deposit_amount,
                'extra_amount' => $scheme->extra_amount,
                'registry_time_deposit' => $scheme->registry_time_deposit,
                'emi_count' => $scheme->emi_count,
                'emi_amount' => $scheme->emi_amount,
                'compound_interest_rate' => $scheme->compound_interest_rate,
                'late_compound_interest_rate' => $scheme->late_compound_interest_rate,
                'administrative_charges' => $scheme->administrative_charges,
                'scheme_start_date' => $scheme->scheme_start_date->format('Y-m-d'),
                'scheme_end_date' => $scheme->scheme_end_date?->format('Y-m-d'),
                'status' => $scheme->status,
                'is_active' => $scheme->is_active,
                'total_payable' => $scheme->total_payable,
                'remaining_amount' => $scheme->remaining_amount,
                'created_by_name' => $scheme->creator?->name,
                'created_at' => $scheme->created_at->format('d M Y, h:i A'),
                'updated_at' => $scheme->updated_at->format('d M Y, h:i A'),
            ]
        ]);
    }

    public function getSchemesForDropdown()
    {
        try {
            $schemes = SchemeMaster::active()
                ->where('status', 'active')
                ->select('scheme_id', 'scheme_name', 'scheme_name_hindi', 'scheme_code', 'scheme_value')
                ->orderBy('scheme_name')
                ->get()
                ->map(function ($scheme) {
                    return [
                        'id' => $scheme->scheme_id,
                        'text' => $scheme->scheme_name . ' - ₹' . number_format($scheme->scheme_value, 2),
                        'texthindi' => $scheme->scheme_name_hindi . ' - ₹' . number_format($scheme->scheme_value, 2),
                        'scheme_value' => $scheme->scheme_value,
                        'scheme_code' => $scheme->scheme_code
                    ];
                });

            return response()->json([
                'success' => true,
                'schemes' => $schemes
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching schemes for dropdown', [
                'error' => $e->getMessage(),
                'user_id' => Auth::user()->id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching schemes.'
            ], 500);
        }
    }

    public function calculateEmi(Request $request)
    {
        try {
            $request->validate([
                'scheme_value' => 'required|numeric|min:1000',
                'down_payment_percentage' => 'required|numeric|min:0|max:100',
                'emi_count' => 'required|integer|min:1|max:240',
            ]);

            $schemeValue = $request->scheme_value;
            $downPaymentPercentage = $request->down_payment_percentage;
            $emiCount = $request->emi_count;

            $downPaymentAmount = $schemeValue * ($downPaymentPercentage / 100);
            $remainingAmount = $schemeValue - $downPaymentAmount;
            $emiAmount = $remainingAmount / $emiCount;

            return response()->json([
                'success' => true,
                'calculations' => [
                    'down_payment_amount' => round($downPaymentAmount, 2),
                    'remaining_amount' => round($remainingAmount, 2),
                    'emi_amount' => round($emiAmount, 2),
                    'total_payable' => round($downPaymentAmount + ($emiAmount * $emiCount), 2)
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error calculating EMI', [
                'error' => $e->getMessage(),
                'input' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while calculating EMI.'
            ], 500);
        }
    }
}
