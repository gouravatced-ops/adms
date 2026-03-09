<?php
// app/Http/Controllers/Applicant/StepperFormController.php
namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllotteesContactDetail;
use App\Models\RegistrationFile;
use App\Models\RegisterAllottee;
use App\Models\Allottee;
use App\Models\Division;
use App\Models\SubDivision;
use App\Models\StepSkip;
use App\Models\AllotteePropertyFinDetail;
use App\Models\AllotteeNomineeBankDetail;
use App\Models\AllotteeDocument;
use App\Models\DocumentMaster;
use Illuminate\Support\Facades\File;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StepperFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    private function generateUniqueUsername($division, $subDivision, $date)
    {
        $divisionCode = Division::where('id', $division)->value('division_code');
        $subDivisionCode = SubDivision::where('id', $subDivision)->value('subdivision_code');
        $dateYear = date('Y', strtotime($date));
        $randomString = substr(str_shuffle('0123456789'), 0, 6);
        return "{$divisionCode}{$dateYear}{$subDivisionCode}{$randomString}";
    }

    private function generatePassword($length = 12)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers   = '0123456789';
        $special   = '!@#$%^&*()_+-=';

        // Ensure at least one from each required category
        $password  = $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $special[random_int(0, strlen($special) - 1)];
        $password .= str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        // Remaining random characters
        $allChars = $uppercase . $lowercase . $numbers . $special;

        while (strlen($password) < $length) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Shuffle to remove pattern
        return str_shuffle($password);
    }

    public function index(Request $request)
    {
        try {
            $search = $request->query('search', '');
            $query = RegistrationFile::with(['allottees', 'scannedBy'])
                ->where('created_by', auth()->id())
                ->whereDoesntHave('allottees', function ($q) {
                    $q->where('allottee_status', '!=', 'scanned');
                })
                ->whereHas('allottees')
                ->orderBy('created_at', 'desc');

            // Search filter
            if (!empty($search)) {
                $query->where('register_no', 'like', '%' . $search . '%');
            }

            // return $query->get();

            $registrations = $query->paginate(25)->through(function ($item) {

                $item->encoded_register_no = base64_encode($item->register_no);

                $item->total_allottees = $item->allottees->count();
                $item->scanned_count = $item->allottees
                    ->where('allottee_status', 'scanned')
                    ->count();

                return $item;
            });
            // return $registrations;
            if ($request->ajax()) {
                return response()->json([
                    'registrations' => $registrations,
                    'pagination' => $registrations->links()->toHtml(),
                    'search_term' => $search,
                ]);
            }
            return view(
                'applicant.components.stepper-form.completed',
                compact('registrations', 'search')
            );
        } catch (\Throwable $e) {

            Log::error('Completed scanned list failed', [
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to load completed scanned list.');
        }
    }

    public function fileIndex($registerId, Request $request)
    {
        try {
            // encrypt to decrypt  register number safely
            $registerNo = decrypt($registerId, true);

            if (! $registerNo) {
                return redirect()
                    ->back()
                    ->with('error', 'Invalid register reference.');
            }

            // Get search parameters
            $searchAllottee = $request->query('allottee', '');
            $searchPropertyNo = $request->query('property_no', '');
            $searchArea = $request->query('area', '');
            $searchDivision = $request->query('division', '');

            // Build query
            $query = RegisterAllottee::query()
                ->with('scannedBy')
                ->from('register_allottees as ra')
                ->leftJoin('divisions as d', 'd.id', '=', 'ra.division_id')
                ->leftJoin('sub_divisions as sd', 'sd.id', '=', 'ra.sub_division_id')
                ->leftJoin('property_category as pc', 'pc.id', '=', 'ra.pcategory_id')
                ->leftJoin('property_type as pt', 'pt.id', '=', 'ra.p_type_id')
                ->leftJoin('quarter_type as qt', 'qt.quarter_id', '=', 'ra.quarter_type')
                ->where('ra.register_id', $registerNo)
                ->where('ra.allottee_status', 'scanned')
                ->where('ra.is_active', 1)
                ->orderByDesc('ra.created_at')
                ->where('created_by', auth()->id())
                ->select([
                    'ra.*',
                    'd.name  as dname',
                    'sd.name as subname',
                    'pc.name as cname',
                    'pt.name as pname',
                    'qt.quarter_code as quarter_code',
                    DB::raw('(COALESCE(ra.no_of_files,0) + COALESCE(ra.no_of_supplement,0)) as total_files')
                ]);

            // Apply search filters
            if (! empty($searchAllottee)) {
                $query->where('ra.allottee_name', 'like', '%' . $searchAllottee . '%')
                    ->orWhere('ra.allottee_middle_name', 'like', '%' . $searchAllottee . '%')
                    ->orWhere('ra.allottee_surname', 'like', '%' . $searchAllottee . '%');
            }

            if (! empty($searchPropertyNo)) {
                $query->where('ra.property_number', 'like', '%' . $searchPropertyNo . '%');
            }

            if (! empty($searchArea)) {
                $query->where('ra.area', 'like', '%' . $searchArea . '%');
            }

            if (! empty($searchDivision)) {
                $query->where('ra.division_id', $searchDivision);
            }

            // Get divisions for dropdown (only if needed for non-AJAX request)
            if (! $request->ajax()) {
                $divisions = \App\Models\Division::orderBy('name')->get();
            }

            // Paginate results
            $registerAllottee = $query->paginate(25);

            // Prepare data for response
            $encodedRegisterNo = base64_encode($registerNo);
            $registerAllottee->each(function ($item) use ($encodedRegisterNo) {
                $item->encoded_register_no = $encodedRegisterNo;
                $encodedallotteeId = base64_encode($item->id);
                $item->allotteeId = $encodedallotteeId;
            });

            // If AJAX request, return JSON
            if ($request->ajax()) {
                return response()->json([
                    'registerAllottee' => $registerAllottee,
                    'pagination' => $registerAllottee->links()->toHtml(),
                    'register_number' => $registerNo,
                    'search_params' => [
                        'allottee' => $searchAllottee,
                        'property_no' => $searchPropertyNo,
                        'area' => $searchArea,
                        'division' => $searchDivision,
                    ],
                ]);
            }

            return view(
                'applicant.components.stepper-form.filesindex',
                compact('registerAllottee', 'registerNo', 'divisions', 'registerId')
            );
        } catch (\Throwable $e) {
            Log::error('File index load failed', [
                'register_id' => $registerId,
                'error' => $e->getMessage(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to load files.',
                    'message' => $e->getMessage(),
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', 'Failed to load files.');
        }
    }

    public function indexStart($encodedId)
    {
        try {
            $id = decrypt($encodedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid request.');
        }

        $applicant = Allottee::with(['division', 'subDivision', 'propertyCategory', 'propertyType'])
            ->where('register_file_id', $id)->first();

        $registerId = RegisterAllottee::whereKey($id)->value('register_id');

        if (!$applicant) {
            $applicant = RegisterAllottee::with([
                'division',
                'subDivision',
                'propertyCategory',
                'propertyType'
            ])
                ->where([
                    ['id', $id],
                    ['allottee_status', 'scanned'],
                    ['is_active', 1],
                ])
                ->firstOrFail();
        }

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


        // Get completed document IDs
        $completedIds = $completedDocuments->pluck('id');

        // Pending documents
        $documents = DocumentMaster::where('document_category', 'basic')
            ->where('status', 1)
            ->whereNotIn('id', $completedIds)
            ->orderBy('sort_order')
            ->get([
                'id',
                'document_name as name',
                'document_key as key'
            ]);

        // return $completedDocuments;
        return view(
            'applicant.components.stepper-form.index',
            compact('applicant', 'getSchemeList', 'registerId', 'documents', 'completedDocuments')
        );
    }

    public function getStep($step, $applicantId)
    {
        $view = "applicant.components.stepper-form.step{$step}";

        // STEP 2 - Contact Detail
        if ($step == 2) {

            $applicant = AllotteesContactDetail::where('allottee_id', $applicantId)->first();

            if ($applicant) {

                $relationMap = [
                    'father'  => 'पिता',
                    'husband' => 'पति'
                ];

                $applicant->relation_type_hindi = $relationMap[$applicant->relation_type] ?? null;

                $applicant->relation_district_hindi       = $applicant->relation_district ?? '';
                $applicant->present_district_hindi        = $applicant->present_district ?? '';
                $applicant->permanent_district_hindi      = $applicant->permanent_district ?? '';
                $applicant->correspondence_district_hindi = $applicant->correspondence_district ?? '';

                // stepper ke liye id match
                $applicant->id = $applicant->allottee_id;

                return view($view, compact('applicant'));
            }
        }

        if ($step == 3) {
            $applicant = AllotteePropertyFinDetail::where('allottee_id', $applicantId)->first();

            if ($applicant) {

                foreach ($applicant->getAttributes() as $key => $value) {
                    $applicant->$key = $value;
                }

                $applicant->id = $applicant->allottee_id;
            }
            return view($view, compact('applicant'));
        }

        if ($step == 4) {
            $applicant = AllotteeNomineeBankDetail::where('allottee_id', $applicantId)->first();

            if ($applicant) {

                foreach ($applicant->getAttributes() as $key => $value) {
                    $applicant->$key = $value;
                }

                $applicant->id = $applicant->allottee_id;
            }
            return view($view, compact('applicant'));
        }

        if ($step == 5) {
            $applicant = Allottee::with([
                'division',
                'subDivision',
                'propertyCategory',
                'propertyType'
            ])->findOrFail($applicantId);
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
            return view($view, compact('applicant' , 'completedDocuments'));
        }

        // Default Applicant Load (Step 1 / Step 2 fallback / Other Steps)
        $applicant = Allottee::with([
            'division',
            'subDivision',
            'propertyCategory',
            'propertyType'
        ])->findOrFail($applicantId);

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
        $applicantExits = Allottee::find($request->allottee_id);
        if ($applicantExits) {
            $applicant = Allottee::where('id', $applicantExits->id)->first();
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
            $registerAllottee = RegisterAllottee::find($request->applicant_id);
            if (!$registerAllottee) {
                return response()->json(['error' => 'Applicant not found'], 404);
            }
        }

        $usersname = $this->generateUniqueUsername($registerAllottee->division_id, $registerAllottee->sub_division_id, $registerAllottee->application_date);
        $password = $this->generatePassword();

        $applicant = new Allottee();
        $applicant->register_file_id = $request->applicant_id;
        $applicant->division_id = $registerAllottee->division_id;
        $applicant->subdivision_id = $registerAllottee->sub_division_id;
        $applicant->pcategory_id = $registerAllottee->pcategory_id;
        $applicant->property_type_id = $registerAllottee->p_type_id;
        $applicant->quarter_id = $registerAllottee->quarter_type;
        $applicant->username = $usersname;
        $applicant->password = Hash::make($password);
        $applicant->cedjshb = encrypt($password);
        $applicant->scheme_id = $request->scheme_id;
        $applicant->application_no = $request->application_no;
        $applicant->application_day = $request->application_day;
        $applicant->application_month = $request->application_month;
        $applicant->application_year = $request->application_year;
        $applicant->allotment_no = $request->allotment_no . '/' . $request->year;
        $applicant->allotment_day = $request->allotment_day;
        $applicant->allotment_month = $request->allotment_month;
        $applicant->allotment_year = $request->allotment_year;
        $applicant->property_number = $registerAllottee->property_number;
        $applicant->prefix = $request->prefix;
        $applicant->allottee_name = $request->allottee_name;
        $applicant->allottee_middle_name = $request->allottee_middle_name;
        $applicant->allottee_surname = $request->allottee_surname;
        $applicant->allottee_prefix_hindi = $request->allottee_prefix_hindi;
        $applicant->allottee_name_hindi = $request->allottee_name_hindi;
        $applicant->allottee_middle_hindi = $request->allottee_middle_hindi;
        $applicant->allottee_surname_hindi = $request->allottee_surname_hindi;
        $applicant->allottee_relation_type = $request->relation_prefix;
        $applicant->relation_name = $request->relation_name;
        $applicant->marital_status = $request->marital_status;
        $applicant->allottee_gender = $request->allottee_gender;
        $applicant->pan_card_number = $request->pan_card_number;
        $applicant->aadhar_card_number = $request->aadhar_card_number;
        $applicant->allottee_category = $request->allottee_category;
        $applicant->allottee_religion = $request->allottee_religion;
        $applicant->allottee_nationality = $request->allottee_nationality;
        $applicant->age_number_of_birth_application = $request->age_number_of_birth_application;
        $applicant->age_number_of_birth_application_hindi = $request->age_number_of_birth_application_hindi;
        $applicant->age_word_of_birth_application = $request->age_word_of_birth_application;
        $applicant->age_word_hindi_of_birth_application = $request->age_word_hindi_of_birth_application;
        $applicant->date_of_birth_day = $request->date_of_birth_day;
        $applicant->date_of_birth_month = $request->date_of_birth_month;
        $applicant->date_of_birth_year = $request->date_of_birth_year;
        $applicant->no_of_files = $registerAllottee->no_of_files;
        $applicant->no_of_supplement = $registerAllottee->no_of_supplement;
        $applicant->json_pages = $registerAllottee->json_pages;
        $applicant->total_pages = $registerAllottee->total_pages;
        $applicant->allottee_create_date  = now();
        $applicant->current_step = 2;
        $applicant->create_ip_address  = $request->ip() ?? NULL;
        $applicant->created_by = auth()->id();
        $applicant->created_at = now();
        $applicant->save();

        return response()->json([
            'success' => true,
            'message' => 'Allottee Details saved successfully',
            'applicant_id' => $applicant->id ?? 1,
            'next_step' => 2
        ]);
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

        // Update applicant's current step (optional)
        $applicant = Allottee::find($applicantId);
        if ($applicant) {
            $applicant->current_step = 3; // Move to next step
            $applicant->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Address Details saved successfully',
            'data' => $record,
            'next_step' => 3
        ]);
    }

    public function saveStep3(Request $request)
    {
        try {

            $data = $request->except([
                'created_ip',
                'updated_ip',
                'created_by',
                'updated_by'
            ]);

            $record = AllotteePropertyFinDetail::where('allottee_id', $request->allottee_id)->first();

            if ($record) {

                // UPDATE
                $data['updated_ip'] = $request->ip();
                $data['updated_by'] = auth()->id();

                $record->update($data);

                $message = 'Property Financial updated successfully';
            } else {

                // CREATE
                $data['created_ip'] = $request->ip();
                $data['created_by'] = auth()->id();

                AllotteePropertyFinDetail::create($data);

                // Update applicant's current step (optional)
                $applicant = Allottee::find($request->allottee_id);
                if ($applicant) {
                    $applicant->current_step = 4; // Move to next step
                    $applicant->save();
                }

                $message = 'Property Financial saved successfully';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
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
        } else {

            // CREATE
            $data['allottee_id'] = $allotteeId;
            $data['created_by'] = $userId;
            $data['create_ip_address'] = $ip;

            $record = AllotteeNomineeBankDetail::create($data);
        }

        StepSkip::where('applicant_id', $allotteeId)->delete();

        Allottee::where('id', $allotteeId)->update([
            'current_step' => 5
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nominee & Banking saved successfully',
            'next_step' => 5,
            'data' => $record
        ]);
    }

    public function saveStep5(Request $request)
    {
        $request->validate([
            'allottee_id' => 'required|exists:allottees,id',
            'nametransferValue' => 'nullable|in:yes,no'
        ]);

        Allottee::where('id', $request->allottee_id)
            ->update([
                'current_step' => 6,
                'name_transfer_status' => $request->nametransferValue
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Documents uploads saved successfully',
            'next_step' => 6
        ]);
    }


    public function saveStep6(Request $request)
    {
        // $applicant = Applicant::where('user_id', auth()->id())
        //     ->where('is_completed', false)
        //     ->latest()
        //     ->first();

        // if (!$applicant) {
        //     return response()->json(['error' => 'No application found'], 404);
        // }

        // $validator = Validator::make($request->all(), [
        //     'division_office' => 'required',
        //     'property_location' => 'required',
        //     'yojana_name' => 'required',
        //     'property_area' => 'required',
        //     'payment_details' => 'required|array',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        // $applicant->update([
        //     'division_office' => $request->division_office,
        //     'property_location' => $request->property_location,
        //     'yojana_name' => $request->yojana_name,
        //     'property_area' => $request->property_area,
        //     'payment_details' => json_encode($request->payment_details),
        //     'current_step' => 4,
        //     'is_completed' => true
        // ]);

        return response()->json([
            'success' => true,
            'message' => 'Application Submit SuccessFully',
        ]);
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
        $propertyNo    = $applicant->property_number;

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
        }


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

    public function saveEmiDetails(Request $request)
    {
        // return $request;
        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Document uploaded successfully',
            'document' => [
                'id' => 1,
                'document_id' => 1,
                'document_type' => 'pdf',
                'file_name' => 'applicant fee',
                'has_file' => 'admin/upoads',
                'doc_no' => '4234',
                'document_date' => '4234',
                'remarks' => '4324'
            ]
        ]);
    }

    public function saveAllotteeDetails(Request $request)
    {
        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'New allotted',
            'data' => [
                'id' => 2,
                'allottee_name' => 'india',
                'mobile' => '234324234',
                'email' => '423432',
                'created_at' => ''
            ]
        ]);
    }
}
