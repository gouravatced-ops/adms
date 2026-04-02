<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SchemeController extends Controller
{
    public function index()
    {
        $schemes = Scheme::with(['creator', 'updater', 'propertyType', 'financial'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $schemes->getCollection()->transform(function ($scheme) {
            $scheme->encoded_id = base64_encode($scheme->id);
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
        $request->validate([

            // Scheme fields
            'division_id' => 'required',
            'sub_division_id' => 'required',
            'pcategory_id' => 'required',
            'p_type_id' => 'required',
            'p_sub_type_id' => 'nullable',
            'scheme_name' => 'required|string|max:255',
            'scheme_code' => 'required|unique:schemes,scheme_code',
            'total_units' => 'required|integer|min:1',

            // Financial
            'property_total_cost' => 'required|numeric|min:0',
            'down_payment_percentage' => 'required|numeric|min:0',
            'emi_count' => 'required|integer|min:1',

            // Quarter Fees
            'quarter_fees' => 'required|array',
            'quarter_fees.*.quarter_type_id' => 'required',
            'quarter_fees.*.application_fee' => 'required|numeric|min:0',
            'quarter_fees.*.emd_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            $scheme = Scheme::create([
                'division_id' => $request->division_id,
                'sub_division_id' => $request->sub_division_id,
                'pcategory_id' => $request->pcategory_id,
                'p_type_id' => $request->p_type_id,
                'p_sub_type_id' => $request->p_sub_type_id,
                'quarter_type_id' => $request->quarter_type_id,
                'scheme_name' => $request->scheme_name,
                'scheme_name_hindi' => $request->scheme_name_hindi,
                'scheme_code' => $request->scheme_code,
                'total_units' => $request->total_units,
                'lease_period' => $request->lease_period,
                'initiation_year' => $request->initiation_year,
                'scheme_start_date' => $request->scheme_start_date,
                'scheme_end_date' => $request->scheme_end_date,
                'created_by' => Auth::id(),
            ]);

            $scheme->financial()->create([
                'property_total_cost' => $request->property_total_cost,
                'down_payment_percentage' => $request->down_payment_percentage,
                'down_payment_amount' => $request->down_payment_amount,
                'balance_amount' => $request->balance_amount,
                'emi_count' => $request->emi_count,
                'normal_interest_rate' => $request->normal_interest_rate,
                'emi_without_penalty' => $request->emi_without_penalty,
                'penalty_interest_rate' => $request->penalty_interest_rate,
                'emi_with_penalty' => $request->emi_with_penalty,
                'admin_charges' => $request->admin_charges,
            ]);

            foreach ($request->quarter_fees as $fee) {

                $scheme->quarterFees()->create([
                    'quarter_type_id' => $fee['quarter_type_id'],
                    'application_fee' => $fee['application_fee'],
                    'emd_amount' => $fee['emd_amount'],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.schemes.index')
                ->with('success', 'Scheme created successfully!');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {   
        DB::beginTransaction();

        try {
            $request->validate([
                // Scheme fields
                'division_id' => 'required',
                'sub_division_id' => 'required',
                'pcategory_id' => 'required',
                'p_type_id' => 'required',
                'p_sub_type_id' => 'nullable',
                'scheme_name' => 'required|string|max:255',
                'scheme_code' => 'required',
                'total_units' => 'required|integer|min:1',

                // Financial
                'property_total_cost' => 'required|numeric|min:0',
                'down_payment_percentage' => 'required|numeric|min:0',
                'emi_count' => 'required|integer|min:1',

                // Quarter Fees
                'quarter_fees' => 'required|array',
                'quarter_fees.*.quarter_type_id' => 'required',
                'quarter_fees.*.application_fee' => 'required|numeric|min:0',
                'quarter_fees.*.emd_amount' => 'required|numeric|min:0',
            ]);

            $scheme = Scheme::findOrFail($id);


            $scheme->update([
                'division_id'        => $request->division_id,
                'sub_division_id'    => $request->sub_division_id,
                'pcategory_id'       => $request->pcategory_id,
                'p_type_id'          => $request->p_type_id,
                'p_sub_type_id'      => $request->p_sub_type_id,
                'quarter_type_id'    => $request->quarter_type_id,
                'scheme_name'        => $request->scheme_name,
                'scheme_name_hindi'  => $request->scheme_name_hindi,
                'scheme_code'        => $request->scheme_code,
                'total_units'        => $request->total_units,
                'lease_period'       => $request->lease_period,
                'initiation_year'    => $request->initiation_year,
                'scheme_start_date'  => $request->scheme_start_date,
                'scheme_end_date'    => $request->scheme_end_date,
                'updated_by' => Auth::id(),
            ]);

            $scheme->financial()->updateOrCreate(
                ['scheme_id' => $scheme->id],
                [
                    'property_total_cost'     => $request->property_total_cost,
                    'down_payment_percentage' => $request->down_payment_percentage,
                    'down_payment_amount'     => $request->down_payment_amount,
                    'balance_amount'          => $request->balance_amount,
                    'emi_count'               => $request->emi_count,
                    'normal_interest_rate'    => $request->normal_interest_rate,
                    'emi_without_penalty'     => $request->emi_without_penalty,
                    'penalty_interest_rate'   => $request->penalty_interest_rate,
                    'emi_with_penalty'        => $request->emi_with_penalty,
                    'admin_charges'           => $request->admin_charges,
                ]
            );

            if ($request->has('quarter_fees')) {

                foreach ($request->quarter_fees as $fee) {

                    $scheme->quarterFees()->updateOrCreate(
                        [
                            'scheme_id'       => $scheme->id,
                            'quarter_type_id' => $fee['quarter_type_id']
                        ],
                        [
                            'application_fee' => $fee['application_fee'] ?? 0,
                            'emd_amount'      => $fee['emd_amount'] ?? 0,
                        ]
                    );
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.schemes.index')
                ->with('success', 'Scheme updated successfully.');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

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

    public function edit($id)
    {
        $scheme = Scheme::with([
            'financial',
            'quarterFees.quarterType'
        ])->findOrFail($id);

        return view('admin.components.schemes.edit', compact('scheme'));
    }



    public function getSchemesForDropdown()
    {
        try {
            $schemes = Scheme::active()
                ->where('status', 'active')
                ->select('id', 'scheme_name', 'scheme_name_hindi', 'scheme_code', 'scheme_value')
                ->orderBy('scheme_name')
                ->get()
                ->map(function ($scheme) {
                    return [
                        'id' => $scheme->id,
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
