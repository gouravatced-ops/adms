<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterAllottee;
use App\Models\INDBNKBill;
use App\Models\INDBNKBillItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class IndBnkBillingController extends Controller
{
    public function billingList()
    {
        //  Total Allottee
        $totalAllottee = RegisterAllottee::where('is_active', 1)->whereNotNull('scanned_by')
            ->sum(DB::raw("
                    CASE
                        WHEN parent_id IS NULL
                            THEN COALESCE(no_of_files,0) + COALESCE(no_of_supplement,0)
                        ELSE
                            COALESCE(no_of_supplement,0)
                    END
                "));

        // Generated Bills Count
        $generatedAllottee = RegisterAllottee::where('is_bill_generated', 1)
            ->where('is_active', 1)
            ->whereNotNull('scanned_by')
            ->sum(DB::raw("
            CASE
                WHEN parent_id IS NULL
                    THEN COALESCE(no_of_files,0) + COALESCE(no_of_supplement,0)
                ELSE
                    COALESCE(no_of_supplement,0)
            END
        "));

        // Remaining Allottee
        $remainingAllottee = $totalAllottee - $generatedAllottee;

        // Next Billing Start
        $nextStart = $generatedAllottee + 1;

        // Billing List
        $billingList = INDBNKBill::latest()->get();
        return view('admin.components.billing.index', compact(
            'totalAllottee',
            'generatedAllottee',
            'remainingAllottee',
            'nextStart',
            'billingList'
        ));
    }

    public function generateBilling(Request $request)
    {
        $request->validate([
            'total_files' => 'required|integer|min:1',
            'start_from' => 'required|integer|min:1',
            'end_at' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            // Requested Values
            $requiredFiles = (int) $request->total_files;
            $startFrom = (int) $request->start_from;
            $endAt = (int) $request->end_at;

            // Get Pending Allottees
            $allottees = RegisterAllottee::from('register_allottees as ra')
                ->where('ra.is_active', 1)
                ->whereNotNull('ra.scanned_by')
                ->where(function ($q) {
                    $q->whereNull('ra.is_bill_generated')
                        ->orWhere('ra.is_bill_generated', 0);
                })

                ->leftJoin('divisions as d', 'd.id', '=', 'ra.division_id')
                ->leftJoin('file_registrations as fr', 'fr.register_no', '=', 'ra.register_id')
                ->leftJoin('sub_divisions as sd', 'sd.id', '=', 'ra.sub_division_id')
                ->leftJoin('property_category as pc', 'pc.id', '=', 'ra.pcategory_id')
                ->leftJoin('property_type as pt', 'pt.id', '=', 'ra.p_type_id')
                ->leftJoin('quarter_type as qt', 'qt.quarter_id', '=', 'ra.quarter_type')

                ->orderBy('ra.created_at')

                ->select(
                    'ra.id',
                    'ra.property_number',
                    'ra.register_id as registerNo',
                    'ra.prefix',
                    'ra.allottee_name',
                    'ra.allottee_middle_name',
                    'ra.allottee_surname',
                    'ra.confirm_received',
                    'ra.confirm_same_allottee_name',
                    'ra.no_of_files',
                    'ra.no_of_supplement',
                    'ra.remarks',
                    'fr.lot_no',
                    'd.name as division_name',
                    'sd.name as subdivision_name',
                    'pc.name as category_name',
                    'pt.name as type_name',
                    'qt.quarter_code'
                )

                ->get();

            $selectedAllottees = [];
            $currentFiles = 0;

            foreach ($allottees as $allottee) {

                // File Count Logic
                $fileCount = 0;

                if (
                    $allottee->confirm_received === "No" &&
                    $allottee->confirm_same_allottee_name === "No"
                ) {

                    $fileCount =
                        1 + ($allottee->no_of_supplement ?? 0);
                } elseif (
                    $allottee->confirm_received === "Yes" &&
                    $allottee->confirm_same_allottee_name === "Yes"
                ) {

                    $fileCount =
                        ($allottee->no_of_supplement ?? 0);
                } elseif (
                    $allottee->confirm_received === "Yes" &&
                    $allottee->confirm_same_allottee_name === "No"
                ) {

                    $fileCount =
                        1 + ($allottee->no_of_supplement ?? 0);
                }

                // Stop If Limit Cross
                if (($currentFiles + $fileCount) > $requiredFiles) {
                    break;
                }

                $selectedAllottees[] = $allottee;

                $currentFiles += $fileCount;
            }

            // No Allottee Found
            if (count($selectedAllottees) == 0) {

                return redirect()->back()
                    ->with('error', 'No allottee available for billing.');
            }

            // Generate Bill Number
            $billNo = 'INDBNK-' . date('Ymd') . '-' . rand(1000, 9999);

            // Create Bill
            $bill = INDBNKBill::create([
                'bill_no' => $billNo,
                'start_from' => $startFrom,
                'end_at' => $endAt,
                'total_allottee' => $currentFiles,
                'generated_by' => auth()->id(),
            ]);

            // Save Bill Items
            foreach ($selectedAllottees as $allottee) {

                INDBNKBillItem::create([
                    'bill_id' => $bill->id,
                    'allottee_id' => $allottee->id,
                ]);

                $allottee->update([
                    'is_bill_generated' => 1,
                    'bill_id' => $bill->id,
                    'bill_generated_at' => now(),
                ]);
            }

            // Generate Billing PDF
            $pdfData = $this->generateBillingPdf(
                $bill,
                $selectedAllottees,
                $currentFiles
            );

            // Update Bill PDF
            $bill->update([
                'generated_pdf_name' => $pdfData['pdf_name'],
                'generated_pdf_path' => $pdfData['pdf_path'],
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Billing generated successfully.');
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    // Generate Billing PDF
    private function generateBillingPdf($bill, $selectedAllottees, $currentFiles)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');

        $processedRows = [];

        foreach ($selectedAllottees as $allottee) {

            // File Count Logic
            $fileCount = 0;

            if (
                $allottee->confirm_received === "No" &&
                $allottee->confirm_same_allottee_name === "No"
            ) {

                $fileCount =
                    1 + ($allottee->no_of_supplement ?? 0);
            } elseif (
                $allottee->confirm_received === "Yes" &&
                $allottee->confirm_same_allottee_name === "Yes"
            ) {

                $fileCount =
                    ($allottee->no_of_supplement ?? 0);
            } elseif (
                $allottee->confirm_received === "Yes" &&
                $allottee->confirm_same_allottee_name === "No"
            ) {

                $fileCount =
                    1 + ($allottee->no_of_supplement ?? 0);
            }

            // Generate File Labels
            for ($i = 1; $i <= $fileCount; $i++) {

                $processedRows[] = [
                    'property_number' => $allottee->property_number ?? '',
                    'lotname' => $allottee->lot_no ?? '',
                    'registerNo' => $allottee->registerNo ?? '',
                    'prefix' => $allottee->prefix ?? '',
                    'allottee_name' => $allottee->allottee_name ?? '',
                    'allottee_middle_name' => $allottee->allottee_middle_name ?? '',
                    'allottee_surname' => $allottee->allottee_surname ?? '',
                    'full_name' => trim(($allottee->prefix ?? '') . ' ' . ($allottee->allottee_name ?? '') . ' ' . ($allottee->allottee_middle_name ?? '') . ' ' . ($allottee->allottee_surname ?? '')),
                    'file_label' => 'File ' . $i,
                    'division' => $allottee->division_name ?? '',
                    'subdivision' => $allottee->subdivision_name ?? '',
                    'category' => $allottee->category_name ?? '',
                    'type' => $allottee->type_name ?? '',
                    'quarter_code' => $allottee->quarter_code ?? '',
                    'remarks' => $allottee->remarks ?? '',
                    'no_of_files' => $allottee->no_of_files ?? 0,
                    'no_of_supplement' => $allottee->no_of_supplement ?? 0,
                    'confirm_received' => $allottee->confirm_received ?? 'No',
                    'confirm_same_allottee_name' => $allottee->confirm_same_allottee_name ?? 'No',
                ];
            }
        }

        // PDF Data
        $data = [
            'totalFiles' => $currentFiles,
            'title' => 'COMPUTER Ed. - Files Receiving',
            'date' => date('d/m/Y'),
            'BillTime' => now()->format('h:i A'),
            'allottees' => $processedRows,
            'billNumber' => $bill->bill_no,
            'logo1' => public_path('assets/indian-bank.png'),
            'logo2' => public_path('assets/insta-logo.jpg'),
            'logo3' => public_path('assets/applicant/auth/images/jspc_logo_in.png'),
            'copies' => [
                'OFFICE COPY - COMPUTER Ed.',
            ],
        ];

        // Generate PDF
        $pdf = Pdf::loadView(
            'exports.billing-pdf',
            $data
        )->setPaper('A4', 'portrait');

        // PDF Name
        $pdfName = $bill->bill_no . '.pdf';

        // PDF Path
        $pdfPath = 'bills/indbnk-bills/' . $pdfName;

        // Create Directory
        $directory = public_path('bills/indbnk-bills');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filePath = $directory . '/' . $pdfName;
        file_put_contents($filePath, $pdf->output());

        return [
            'pdf_name' => $pdfName,
            'pdf_path' => $pdfPath,
        ];
    }

    public function deleteBilling($encryptedId)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($encryptedId);
            // Get Bill
            $bill = INDBNKBill::findOrFail($id);

            // Get Bill Items
            $billItems = INDBNKBillItem::where('bill_id', $bill->id)->get();

            // Reset Allottee Billing Status
            foreach ($billItems as $item) {

                RegisterAllottee::where('id', $item->allottee_id)
                    ->update([
                        'is_bill_generated' => 0,
                        'bill_id' => null,
                        'bill_generated_at' => null,
                    ]);
            }

            // Delete PDF File
            if (
                !empty($bill->generated_pdf_path) &&
                File::exists(public_path($bill->generated_pdf_path))
            ) {

                File::delete(public_path($bill->generated_pdf_path));
            }

            // Delete Bill Items
            INDBNKBillItem::where('bill_id', $bill->id)->delete();

            // Delete Bill
            $bill->delete();

            DB::commit();

            return redirect()->back()
                ->with('success', 'Billing deleted successfully.');
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}