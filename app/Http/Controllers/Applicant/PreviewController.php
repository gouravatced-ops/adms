<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllotteesContactDetail;
use App\Models\RegisterAllottee;
use App\Models\Allottee;
use App\Models\StepSkip;
use App\Models\AllotteePropertyFinDetail;
use App\Models\AllotteeNomineeBankDetail;
use App\Models\AllotteeEmiLedger;
use App\Models\AllotteeDocument;
use App\Models\DocumentMaster;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PreviewController extends Controller
{
    public function indexStart($encodedId)
    {
        try {
            $id = decrypt($encodedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid request.');
        }
        $applicant = Allottee::with(['division', 'subDivision', 'propertyCategory', 'propertyType', 'quarterType'])
            ->where('id', $id)
            ->first();

        $registerId = encrypt($applicant->register_id);
        $getSchemeList = getSchemeList(
            $applicant->division_id,
            $applicant->sub_division_id ?? $applicant->subdivision_id,
            $applicant->pcategory_id,
            $applicant->p_type_id ?? $applicant->property_type_id,
            $applicant->quarter_type ?? $applicant->quarter_id,
        );

        // Completed documents
        $completedDocuments = AllotteeDocument::where('allottee_id', $applicant->id)
            ->join('document_master', 'document_master.id', '=', 'allottee_documents.document_id')
            ->get([
                'allottee_documents.*',
                'document_master.id',
                'document_master.document_name as name',
                'document_master.document_key as key',
                'allottee_documents.file_name',
                'allottee_documents.file_path'
            ]);

        $completedIds = $completedDocuments->pluck('id');

        $documents = DocumentMaster::where('document_category', 'basic')
            ->where('status', 1)
            ->whereNotIn('id', $completedIds)
            ->orderBy('sort_order')
            ->get([
                'id',
                'document_name as name',
                'document_key as key'
            ]);

        return view(
            'applicant.components.stepper-form.preview.index',
            compact('applicant', 'getSchemeList', 'registerId', 'documents', 'completedDocuments')
        );
    }

    public function getStep($step, $applicantId)
    {
        $view = "applicant.components.stepper-form.preview.step{$step}";

        $baseRelations = [
            'division',
            'subDivision',
            'propertyCategory',
            'propertyType',
        ];
        // STEP 2
        if ($step == 2) {

            $applicant = AllotteesContactDetail::where('allottee_id', $applicantId)->first();

            if ($applicant) {

                $relationMap = [
                    'father'  => 'पिता',
                    'husband' => 'पति'
                ];

                $applicant->relation_type_hindi = $relationMap[$applicant->relation_type] ?? null;

                $districtFields = [
                    'relation_district',
                    'present_district',
                    'permanent_district',
                    'correspondence_district'
                ];

                foreach ($districtFields as $field) {
                    $applicant->{$field . '_hindi'} = $applicant->$field ?? '';
                }

                $applicant->id = $applicant->allottee_id;

                return view($view, compact('applicant'));
            }
            
            $applicant = Allottee::with($baseRelations)->findOrFail($applicantId);
            return view($view, compact('applicant'));
        }

        // STEP 3
        if ($step == 3) {

            $applicant = AllotteePropertyFinDetail::where('allottee_id', $applicantId)->first();

            if ($applicant) {
                $applicant->id = $applicant->allottee_id;
                return view($view, compact('applicant'));
            }
            
            $applicant = Allottee::with($baseRelations)->findOrFail($applicantId);
            $applicant->plot_number = $applicant->property_number;
            $applicant->allot_day = $applicant->allotment_day;
            $applicant->allot_month = $applicant->allotment_month;
            $applicant->allot_year = $applicant->allotment_year;
            return view($view, compact('applicant'));
        }

        // STEP 4
        if ($step == 4) {

            $applicant = AllotteeNomineeBankDetail::where('allottee_id', $applicantId)->first();

            if ($applicant) {
                $applicant->id = $applicant->allottee_id;
                return view($view, compact('applicant'));
            }
            
            $applicant = Allottee::with($baseRelations)->findOrFail($applicantId);
            return view($view, compact('applicant'));
        }

        // STEP 5
        if ($step == 5) {

            $applicant = Allottee::with(array_merge($baseRelations, ['AllotProFinDetail']))
                ->findOrFail($applicantId);

            $completedDocuments = AllotteeDocument::where('allottee_id', $applicant->id)
                ->join('document_master', 'document_master.id', '=', 'allottee_documents.document_id')
                ->get([
                    'allottee_documents.*',
                    'document_master.id',
                    'document_master.document_name as name',
                    'document_master.document_key as key',
                    'allottee_documents.file_name',
                    'allottee_documents.file_path'
                ]);
            
            return view($view, compact('applicant', 'completedDocuments'));
        }

        // STEP 6
        if ($step == 6) {

            $relations = array_merge($baseRelations, [
                'allotProFinDetail',
                'alloteeAdresses',
                'nomineesBank',
                'accountLedger',
                'documentData'
            ]);

            
            $applicant = Allottee::with($relations)->findOrFail($applicantId);
            return view($view, compact('applicant'));
        }

        // DEFAULT (STEP 1)
        $applicant = Allottee::with($baseRelations)->findOrFail($applicantId);

        $getSchemeList = getSchemeList(
            $applicant->division_id,
            $applicant->subdivision_id,
            $applicant->pcategory_id,
            $applicant->property_type_id,
            $applicant->quarter_id
        );
        return view($view, compact('applicant', 'getSchemeList'));
    }

    public function skipStep(Request $request)
    {
        try {
            $request->validate([
                'applicant_id' => 'required|integer',
                'step' => 'required|integer',
                'remark' => 'required|string|max:500',
                'reason_category' => 'nullable|string|max:100'
            ]);

            // Store the skip record
            $skipRecord = StepSkip::create([
                'applicant_id' => $request->applicant_id,
                'step_number' => $request->step,
                'step_name' => $request->step_name,
                'remark' => $request->remark,
                'reason_category' => $request->reason_category,
                'ip_address' => $request->ip(),
                'skiped_by' => auth()->id(),
                'user_agent' => $request->userAgent(),
                'skipped_at' => now()
            ]);

            // Update applicant's current step (optional)
            $applicant = Allottee::find($request->applicant_id);
            if ($applicant) {
                $applicant->current_step = $request->step + 1; // Move to next step
                $applicant->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Step skipped successfully',
                'next_step' => $request->step + 1,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error skipping step: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveStep1(Request $request)
    {
        $applicant = Allottee::where('id', $request->allottee_id)->first();
        if ($applicant) {
            // update existing applicant
            $applicant->update([
                // Scheme & Application
                'scheme_id' => $request->scheme_id,
                'application_no' => $request->application_no,
                'application_day' => $request->application_day,
                'application_month' => $request->application_month,
                'application_year' => $request->application_year,

                // Allotment
                'allotment_no' => $request->allotment_no . '/' . $request->year,
                'allotment_day' => $request->allotment_day,
                'allotment_month' => $request->allotment_month,
                'allotment_year' => $request->allotment_year,

                // Basic Details
                'prefix' => $request->prefix,
                'allottee_name' => $request->allottee_name,
                'allottee_middle_name' => $request->allottee_middle_name,
                'allottee_surname' => $request->allottee_surname,

                // Hindi Details
                'allottee_prefix_hindi' => $request->allottee_prefix_hindi,
                'allottee_name_hindi' => $request->allottee_name_hindi,
                'allottee_middle_hindi' => $request->allottee_middle_hindi,
                'allottee_surname_hindi' => $request->allottee_surname_hindi,

                // Relation
                'allottee_relation_type' => $request->relation_prefix,
                'relation_name' => $request->relation_name,

                // Personal Info
                'marital_status' => $request->marital_status,
                'allottee_gender' => $request->allottee_gender,
                'pan_card_number' => $request->pan_card_number,
                'aadhar_card_number' => $request->aadhar_card_number,
                'allottee_category' => $request->allottee_category,
                'allottee_religion' => $request->allottee_religion,
                'allottee_nationality' => $request->allottee_nationality,

                // Age Details
                'age_number_of_birth_application' => $request->age_number_of_birth_application,
                'age_number_of_birth_application_hindi' => $request->age_number_of_birth_application_hindi,
                'age_word_of_birth_application' => $request->age_word_of_birth_application,
                'age_word_hindi_of_birth_application' => $request->age_word_hindi_of_birth_application,

                // DOB Split
                'date_of_birth_day' => $request->date_of_birth_day,
                'date_of_birth_month' => $request->date_of_birth_month,
                'date_of_birth_year' => $request->date_of_birth_year,
                'remarks_for_dob' => $request->remarks_for_dob,
                'update_ip_address' => $request->ip() ?? NULL,
                'updated_by' => auth()->id(),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Allottee Details updated successfully',
                'applicant_id' => $applicant->id,
                'next_step' => 2
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Some Issues',
            ]);
        }

    }

    public function saveStep2(Request $request)
    {
        $applicantId = $request->applicant_id;
        $data = $request->all();
        $data['update_ip_address'] = $request->ip();

        if (!$request->filled('id')) {
            $data['create_ip_address'] = $request->ip();
            $data['created_by'] = auth()->id();
        }

        $data['updated_by'] = auth()->id();

        $record = AllotteesContactDetail::updateOrCreate(
            ['allottee_id' => $applicantId],
            $data
        );

        return response()->json([
            'success' => true,
            'message' => 'Address Update saved successfully',
            'data' => $record,
            'next_step' => 3
        ]);
    }

    public function saveStep3(Request $request)
    {
        try {

            $data = $request->except([
                'updated_ip',
                'updated_by'
            ]);

            $record = AllotteePropertyFinDetail::where('allottee_id', $request->allottee_id)->first();

            if ($record) {

                // UPDATE
                $data['updated_ip'] = $request->ip();
                $data['updated_by'] = auth()->id();

                $record->update($data);
            }

            return response()->json([
                'success' => true,
                'message' => 'Property Financial updated successfully',
                'next_step' => 4
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function saveStep4(Request $request)
    {
        $userId = auth()->id();
        $ip = $request->ip();

        $data = $request->only([
            'nominee_prefix',
            'nominee_name',
            'nominee_relationship',
            'nominee_pan_card',
            'nominee_aadhaar',

            'family_name_prefix',
            'family_name',
            'family_gender',
            'family_dob',
            'family_relationship',
            'family_aadhaar',
            'family_pan',

            'bank_name',
            'bank_account_no',
            'bank_branch',
            'bank_ifsc',
            'bank_account_holder'
        ]);

        $allotteeId = $request->allottee_id;

        $record = AllotteeNomineeBankDetail::where('allottee_id', $allotteeId)->first();

        if ($record) {

            // UPDATE
            $data['updated_by'] = $userId;
            $data['update_ip_address'] = $ip;

            $record->update($data);
        }

        StepSkip::where('applicant_id', $allotteeId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Nominee & Banking update successfully',
            'next_step' => 5,
            'data' => $record
        ]);
    }

    public function saveStep5(Request $request)
    {
        $request->validate([
            'allottee_id' => 'required|exists:allottees,id',
            'nametransferValue' => 'nullable|in:yes,no',
            'freeHoldValue' => 'nullable|in:yes,no'
        ]);

        $updateData = [
            'current_step' => 6,
            'name_transfer_status' => $request->nametransferValue,
            'free_hold_status' => $request->freeHoldValue
        ];

        // EMI status only if no_information
        if ($request->emi_status == 'no_information') {
            $updateData['is_emi_active'] = $request->emi_status;
        }

        Allottee::where('id', $request->allottee_id)->update($updateData);


        return response()->json([
            'success' => true,
            'message' => 'All Documents uploaded',
            'next_step' => 6
        ]);
    }

    public function saveStep6(Request $request)
    {
        // return $request;
        if (!$request->final_submission) {
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong',
            ]);
        }

        try {

            DB::beginTransaction();

            $allottee = Allottee::find($request->applicant_id);

            if (!$allottee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Applicant not found',
                ]);
            }

            // Step Completed
            $allottee->is_step_completed = 1;
            $allottee->sub_admin_allottee_verify = 0;
            $allottee->step_remarks = $request->remarks;
            $allottee->save();
            // Update RegisterAllottee
            RegisterAllottee::where('id', $allottee->register_file_id)
                ->update([
                    'allottee_status' => 'dataentry',
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Application Submit Successfully',
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit application',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'allottee_id'   => 'required|exists:allottees,id',
            'document_id'   => 'required|exists:document_master,id',
            'document_file' => 'nullable|file|max:10240',
            'remarks'       => 'required_without:document_file|string|nullable'
        ]);

        $applicant = Allottee::with([
            'division:id,division_code',
            'subDivision:id,subdivision_code',
            'propertyCategory:id,name',
            'propertyType:id,name',
            'quarterType:quarter_id,quarter_code'
        ])->findOrFail($request->allottee_id);

        $division      = $applicant->division->division_code ?? '';
        $subDivision   = $applicant->subDivision->subdivision_code ?? '';
        $category      = $applicant->propertyCategory->name ?? '';
        $type          = $applicant->propertyType->name ?? '';
        $incomeType    = $applicant->quarterType->quarter_code ?? '';
        $year          = $applicant->allotment_year;
        $month         = str_pad($applicant->allotment_month, 2, '0', STR_PAD_LEFT);
        $propertyNo    = preg_replace('/[^A-Za-z0-9]/', '-', $applicant->property_number);

        $documentKey = DocumentMaster::where('id', $request->document_id)->value('document_key');

        $allotteeName = implode('', array_filter([
            $applicant->allottee_name,
            $applicant->allottee_middle_name,
            $applicant->allottee_surname
        ]));

        $folderParts = [
            'documents',
            $division,
            $subDivision,
            $category,
            $year,
            $month,
            $type,
            $incomeType,
            $propertyNo,
            $allotteeName
        ];

        $filePath = null;
        $fileName = null;
        $allotteePath = null;
        if ($request->hasFile('document_file')) {
            $uploadPath = implode('/', array_filter($folderParts));
            $directory = public_path($uploadPath);

            File::ensureDirectoryExists($directory, 0755, true);

            $file = $request->file('document_file');

            $random = rand(1000, 9999);

            $fileName = implode('', [
                $division,
                $subDivision,
                $incomeType,
                $year,
                $month
            ]) . "-{$propertyNo}_{$documentKey}_{$random}." . $file->getClientOriginalExtension();

            $file->move($directory, $fileName);

            $filePath = $uploadPath . '/' . $fileName;
            $allotteePath = $uploadPath;
        }

        // only update if empty (first time only)
        Allottee::where('id', $request->allottee_id)
            ->whereNull('allottee_document_path')
            ->update([
                'allottee_document_path' => $allotteePath
            ]);

        AllotteeDocument::create([
            'allottee_id' => $request->allottee_id,
            'document_id' => $request->document_id,
            'file_path'   => $filePath,
            'file_name'   => $fileName,
            'doc_no'      => $request->doc_no,
            'doc_day'     => $request->doc_day,
            'doc_month'   => $request->doc_month,
            'doc_year'    => $request->doc_year,
            'additional_info' => $request->additional_info,
            'remarks'     => $request->remarks,
            'uploaded_by' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document uploaded successfully'
        ]);
    }

    public function saveEmiLedger(Request $request)
    {
        try {

            $payload = $request->all();

            $config = json_decode($payload['emi_config'], true) ?? [];
            $inputs   = json_decode($payload['emi_data'], true) ?? [];

            if ($payload['emi_status'] == 'yes' && $payload['emi_mode'] == 'manual') {
                $emiData = $inputs['manual'];
                $emiData['withoutPenaltyCount'] = $emiData['completedCount'];
                $emiData['withPenaltyAmount'] = $emiData['penaltyAmount'];
                $emiData['totalRemaining'] = $emiData['totalBalance'];
                $emiData['withPenaltyCount'] = $emiData['lateCount'];
                $emiData['completedCount'] = $emiData['completedCount'] + $emiData['lateCount'];
                $emiData['currentBalance'] = $emiData['totalPaid'];
                $emiData['type'] = 'manual';
            } else if ($payload['emi_status'] == 'yes' && $payload['emi_mode']  == 'auto') {
                $emiData = $inputs['auto'];
                $emiData['withoutPenaltyAmount'] = $config['amountWithoutPenalty'];
                $emiData['withPenaltyAmount'] = $config['amountWithPenalty'];
                $emiData['withoutPenaltyCount'] = $emiData['withoutPenaltyCount'];
                $emiData['withPenaltyCount'] = $emiData['withPenaltyCount'];
                $emiData['type'] = 'auto';
            } else if ($payload['emi_status'] == 'no' && $payload['emi_mode'] == 'manual') {
                $emiData['totalCount'] = $config['totalCount'];
                $emiData['expectedCount'] = $config['totalCount'];
                $emiData['completedCount'] = $config['totalCount'];
                $emiData['lateCount'] = 0;
                $emiData['remainingCount'] = 0;
                $emiData['withPenaltyAmount'] = $config['amountWithPenalty'];
                $emiData['withoutPenaltyAmount'] = $config['amountWithoutPenalty'];
                $emiData['totalPaid'] = $config['totalCount'] * $config['amountWithoutPenalty'];
                $emiData['currentBalance'] = $config['totalCount'] * $config['amountWithoutPenalty'];
                $emiData['status'] = 'Close';
            }

            // return $emiData;
            $data = [

                'allottee_id' => $payload['allottee_id'] ?? null,
                'calculation_type' => $payload['emi_mode'],

                // CONFIG
                'total_amount' => $config['totalAmount'] ?? 0,
                'total_emi_count' => $config['totalCount'] ?? 0,

                'start_month' => $config['startMonth'] ?? null,
                'start_year'  => $config['startYear'] ?? null,

                'last_emi_month' => $config['lastEmiMonth'] ?? null,
                'last_emi_year'  => $config['lastEmiYear'] ?? null,

                'amount_without_penalty' => $emiData['withoutPenaltyAmount'] ?? 0,
                'amount_with_penalty'    => $emiData['withPenaltyAmount'] ?? 0,

                // INPUTS
                'without_penalty_count' => $emiData['withoutPenaltyCount'] ?? 0,
                'with_penalty_count'    => $emiData['withPenaltyCount'] ?? 0,

                // CALCULATED
                'completed_emi' => $emiData['completedCount'] ?? 0,
                'late_emi'      => $emiData['lateCount'] ?? 0,
                'remaining_emi' => $emiData['remainingCount'] ?? 0,

                'total_paid'      => $emiData['totalPaid'] ?? 0,
                'total_remaining' => $emiData['totalRemaining'] ?? 0,
                'current_balance' => $emiData['currentBalance'] ?? 0,

                'emi_status' => $emiData['status'] ?? null,

                'expected_emi' => $calc['expectedCount'] ?? 0,
                'payment_gap'  => $calc['paymentGap'] ?? 0,

                'emi_active' => $payload['emi_status'] ?? false,

                // RAW JSON STORE
                'emi_config'     => json_encode($config),
                'emi_inputs'     => json_encode($inputs),

            ];
            // INSERT OR UPDATE
            $ledger = AllotteeEmiLedger::updateOrCreate(
                ['allottee_id' => $payload['allottee_id']],
                $data
            );

            if ($payload['emi_status'] == 'yes') {
                $emi_status = 'true';
            } else {
                $emi_status = 'false';
            }

            Allottee::where('id', $payload['allottee_id'])->update([
                'is_emi_active' => $emi_status
            ]);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'EMI ledger saved successfully',
                'data' => $ledger
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
