<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Allottee;
use App\Models\AllotteeDocument;
use App\Models\JointAllottee;
use App\Models\AllotteesContactDetail;
use App\Models\AllotteeStepDuration;
use App\Models\Division;
use App\Models\DocumentMaster;
use App\Models\RegisterAllottee;
use App\Models\RegistrationFile;
use App\Models\StepSkip;
use App\Models\SubDivision;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class NameTransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    private function generateUniqueUsername($division, $quarterCode, $subDivision, $date)
    {
        $divisionCode = Division::where('id', $division)->value('division_code');
        $subDivisionCode = SubDivision::where('id', $subDivision)->value('subdivision_code');
        $dateYear = $date;
        $randomString = substr(str_shuffle('0123456789'), 0, 5);

        return "{$divisionCode}{$quarterCode}{$dateYear}{$subDivisionCode}{$randomString}";
    }

    private function generatePassword($length = 12)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $special = '!@#$%^&*()_+-=';

        // Ensure at least one from each required category
        $password = $uppercase[random_int(0, strlen($uppercase) - 1)];
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
            $perPage = $request->input('per_page', 50);

            // Get search params
            $searchParams = [
                'allottee' => $request->query('allottee'),
                'property_no' => $request->query('property_no'),
                'division' => $request->query('division'),
            ];

            $baseRelations = [
                'division',
                'subDivision',
                'propertyCategory',
                'propertyType',
                'quarterType'

            ];

            // Optimized query with selective loading
            $query = Allottee::with($baseRelations)->where('is_trans_entry_completed', 0)
                ->where('name_transfer_status', 'yes');

            // Apply search filters
            if (!empty($searchParams['allottee'])) {
                $query->where(function ($q) use ($searchParams) {
                    $searchTerm = "%{$searchParams['allottee']}%";
                    $q->where('allottee_name', 'LIKE', $searchTerm)
                        ->orWhere('allottee_middle_name', 'LIKE', $searchTerm)
                        ->orWhere('allottee_surname', 'LIKE', $searchTerm)
                        ->orWhere('application_no', 'LIKE', $searchTerm)
                        ->orWhere('register_id', 'LIKE', $searchTerm);
                });
            }

            if (!empty($searchParams['property_no'])) {
                $query->where('property_number', 'LIKE', "%{$searchParams['property_no']}%");
            }

            if (!empty($searchParams['division'])) {
                $query->where('division_id', $searchParams['division']);
            }

            // Paginate with query string preservation
            $transferAllottee = $query->paginate($perPage)->withQueryString();

            // AJAX Response
            if ($request->ajax()) {
                return response()->json([
                    'transferAllottee' => [
                        'data' => $transferAllottee->items(),
                        'current_page' => $transferAllottee->currentPage(),
                        'per_page' => $transferAllottee->perPage(),
                        'total' => $transferAllottee->total(),
                    ],
                    'pagination' => $transferAllottee->links()->toHtml(),
                    'search_params' => $searchParams,
                ]);
            }

            // Cache divisions for better performance
            $divisions = cache()->remember('divisions-list', 3600, function () {
                return Division::orderBy('name')->get(['id', 'name']);
            });

            return view(
                'applicant.components.nametransfer.transferfile',
                compact('transferAllottee', 'divisions')
            );
        } catch (\Throwable $e) {
            Log::error('File index load failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = app()->environment('production')
                ? 'Failed to load files. Please try again.'
                : $e->getMessage();

            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to load files.',
                    'message' => $errorMessage
                ], 500);
            }

            return back()->with('error', $errorMessage);
        }
    }

    public function completedIndex(Request $request)
    {
        try {
            $userId = auth()->id();
            $perPage = $request->input('per_page', 50);

            $transferAllottee = Allottee::selectRaw("
                allottees.*,
                CASE 
                    WHEN name_transfer_status = 'no' 
                         AND is_trans_entry_completed = 0
                    THEN 'Current Allottee'
                    ELSE 'Transfer Allottee'
                END as allottee_type
            ")
                // current / transfer records should always have parent
                ->whereNotNull('parent_id')

                ->where('name_transfer_status', 'no')
                ->where('is_trans_entry_completed', 0)
                ->where('created_by', $userId)

                ->with([
                    'division:id,name',
                    'subDivision:id,name',
                    'propertyCategory:id,name',
                    'propertyType:id,name',
                    'quarterType:quarter_id,quarter_code',

                    // parent history
                    'parent' => function ($q) {

                        $q->selectRaw("
                        allottees.*,
                        'Previous Allottee' as allottee_type
                    ")

                            ->with([
                                'parent' => function ($q2) {

                                    $q2->selectRaw("
                                allottees.*,
                                'First Allottee' as allottee_type
                            ");
                                }
                            ]);
                    }
                ])

                // only CURRENT allottee
                ->where('name_transfer_status', 'no')

                ->where('is_trans_entry_completed', 0)

                ->orderByDesc('id')

                ->paginate($perPage);
            // return response()->json($transferAllottee);
                $divisions = getDivisions();
            return view(
                'applicant.components.nametransfer.completedLots',
                compact('transferAllottee' , 'divisions')
            );
        } catch (\Throwable $e) {

            \Log::error($e);

            return back()->with('error', $e->getMessage());
        }
    }

    public function fileIndex($registerId, Request $request)
    {
        try {

            $registerNo = decrypt($registerId, true);

            if (! $registerNo) {
                return back()->with('error', 'Invalid register reference.');
            }

            $searchAllottee = $request->query('allottee');
            $searchPropertyNo = $request->query('property_no');
            $searchArea = $request->query('area');
            $searchDivision = $request->query('division');

            $query = RegisterAllottee::query()
                ->with('scannedBy')
                ->from('register_allottees as ra')
                ->leftJoin('allottees as a', 'a.register_file_id', '=', 'ra.id')
                ->leftJoin('divisions as d', 'd.id', '=', 'ra.division_id')
                ->leftJoin('sub_divisions as sd', 'sd.id', '=', 'ra.sub_division_id')
                ->leftJoin('property_category as pc', 'pc.id', '=', 'ra.pcategory_id')
                ->leftJoin('property_type as pt', 'pt.id', '=', 'ra.p_type_id')
                ->leftJoin('quarter_type as qt', 'qt.quarter_id', '=', 'ra.quarter_type')

                ->where([
                    ['ra.register_id', $registerNo],
                    ['ra.allottee_status', 'scanned'],
                    ['ra.is_active', 1],
                    ['ra.created_by', auth()->id()],
                ])

                // Hide completed files
                ->where(function ($q) {
                    $q->whereNull('a.id')
                        ->orWhere('a.is_step_completed', '!=', 1);
                })

                ->select([
                    'ra.*',
                    'd.name as dname',
                    'sd.name as subname',
                    'pc.name as cname',
                    'pt.name as pname',
                    'qt.quarter_code',
                    'a.is_step_completed',
                    'a.current_step',
                    DB::raw('(COALESCE(ra.no_of_files,0) + COALESCE(ra.no_of_supplement,0)) as total_files'),
                ])

                ->orderByDesc('ra.created_at');

            /*
        |--------------------------------------------------------------------------
        | Search Filters
        |--------------------------------------------------------------------------
        */

            if ($searchAllottee) {
                $query->where(function ($q) use ($searchAllottee) {
                    $q->where('ra.allottee_name', 'like', "%$searchAllottee%")
                        ->orWhere('ra.allottee_middle_name', 'like', "%$searchAllottee%")
                        ->orWhere('ra.allottee_surname', 'like', "%$searchAllottee%");
                });
            }

            if ($searchPropertyNo) {
                $query->where('ra.property_number', 'like', "%$searchPropertyNo%");
            }

            if ($searchArea) {
                $query->where('ra.area', 'like', "%$searchArea%");
            }

            if ($searchDivision) {
                $query->where('ra.division_id', $searchDivision);
            }

            $registerAllottee = $query->paginate(25);

            /*
        |--------------------------------------------------------------------------
        | Encode Values
        |--------------------------------------------------------------------------
        */

            $encodedRegisterNo = base64_encode($registerNo);

            $registerAllottee->getCollection()->transform(function ($item) use ($encodedRegisterNo) {

                $item->encoded_register_no = $encodedRegisterNo;
                $item->allotteeId = base64_encode($item->id);

                return $item;
            });

            /*
        |--------------------------------------------------------------------------
        | AJAX Response
        |--------------------------------------------------------------------------
        */

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

            $divisions = Division::orderBy('name')->get();

            return view(
                'applicant.components.nametransfer.filesindex',
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

            return back()->with('error', 'Failed to load files.');
        }
    }

    public function CompletedfileIndex($registerId, Request $request)
    {
        try {

            $registerNo = decrypt($registerId, true);

            if (! $registerNo) {
                return back()->with('error', 'Invalid register reference.');
            }

            $searchAllottee = $request->query('allottee');
            $searchPropertyNo = $request->query('property_no');
            $searchArea = $request->query('area');
            $searchDivision = $request->query('division');

            $query = RegisterAllottee::query()
                ->with('scannedBy')
                ->from('register_allottees as ra')

                // only completed
                ->join('allottees as a', 'a.register_file_id', '=', 'ra.id')

                ->leftJoin('divisions as d', 'd.id', '=', 'ra.division_id')
                ->leftJoin('sub_divisions as sd', 'sd.id', '=', 'ra.sub_division_id')
                ->leftJoin('property_category as pc', 'pc.id', '=', 'ra.pcategory_id')
                ->leftJoin('property_type as pt', 'pt.id', '=', 'ra.p_type_id')
                ->leftJoin('quarter_type as qt', 'qt.quarter_id', '=', 'ra.quarter_type')

                ->where([
                    ['ra.register_id', $registerNo],
                    ['ra.allottee_status', 'scanned'],
                    ['ra.is_active', 1],
                    ['ra.created_by', auth()->id()],
                    ['a.is_step_completed', 1],
                ])

                ->select([
                    'ra.*',
                    'd.name as dname',
                    'sd.name as subname',
                    'pc.name as cname',
                    'pt.name as pname',
                    'qt.quarter_code',
                    DB::raw('(COALESCE(ra.no_of_files,0)+COALESCE(ra.no_of_supplement,0)) as total_files'),
                ])

                ->orderByDesc('ra.created_at');

            if ($searchAllottee) {
                $query->where(function ($q) use ($searchAllottee) {
                    $q->where('ra.allottee_name', 'like', "%$searchAllottee%")
                        ->orWhere('ra.allottee_middle_name', 'like', "%$searchAllottee%")
                        ->orWhere('ra.allottee_surname', 'like', "%$searchAllottee%");
                });
            }

            if ($searchPropertyNo) {
                $query->where('ra.property_number', 'like', "%$searchPropertyNo%");
            }

            if ($searchArea) {
                $query->where('ra.area', 'like', "%$searchArea%");
            }

            if ($searchDivision) {
                $query->where('ra.division_id', $searchDivision);
            }

            $registerAllottee = $query->paginate(25);

            $encodedRegisterNo = base64_encode($registerNo);

            $registerAllottee->getCollection()->transform(function ($item) use ($encodedRegisterNo) {

                $item->encoded_register_no = $encodedRegisterNo;
                $item->allotteeId = base64_encode($item->id);

                return $item;
            });

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

            $divisions = Division::orderBy('name')->get();

            return view(
                'applicant.components.nametransfer.completefilesindex',
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

            return back()->with('error', 'Failed to load files.');
        }
    }

    public function trackStepStart($allotteeId, $stepNo)
    {
        $track = AllotteeStepDuration::where([
            'allottee_id' => $allotteeId,
            'step_no' => $stepNo,
        ])->first();

        if (! $track) {

            AllotteeStepDuration::create([
                'allottee_id' => $allotteeId,
                'step_no' => $stepNo,
                'started_at' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_by' => auth()->id(),
            ]);
        } else {

            // agar row hai lekin start time nahi hai
            $track->update([
                'started_at' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_by' => auth()->id(),
            ]);
        }
    }

    public function trackStepEnd($applicantId, $step)
    {

        $row = AllotteeStepDuration::where([
            'allottee_id' => $applicantId,
            'step_no' => $step,
        ])->first();

        if ($row && $row->started_at) {

            $end = now();
            $duration = Carbon::parse($row->started_at)->diffInMinutes($end);

            $row->update([
                'completed_at' => $end,
                'duration_min' => $duration,
            ]);
        }
    }

    public function indexStart($encodedId)
    {
        try {
            $id = decrypt($encodedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid request.');
        }

        // Parent allottee
        $existingapplicant = Allottee::select([
            'id',
            'register_id',
            'division_id',
            'subdivision_id',
            'pcategory_id',
            'property_type_id',
            'is_step_completed',
            'quarter_id',
            'property_number',
            'current_step',
            'is_trans_entry_completed',
            'allotment_year',
        ])
            ->with([
                'division:id,name',
                'subDivision:id,name',
                'propertyCategory:id,name',
                'propertyType:id,name',
                'quarterType:quarter_id,quarter_code'
            ])
            ->findOrFail($id);
        $applicant = $existingapplicant;

        if ($existingapplicant->is_trans_entry_completed == 1) {
            $childApplicant = Allottee::where('parent_id', $existingapplicant->id)
                ->latest('id')
                ->first();

            if ($childApplicant) {
                $applicant = $childApplicant;
                $currentStep = $applicant->current_step;
                $action = 'update';
            }
        } else {
            $currentStep = 1;
            $action = 'create';
        }
        $applicant->current_step = $currentStep;
        $applicant->action = $action;
        $getSchemeList = getSchemeList(
            $existingapplicant->division_id,
            $existingapplicant->sub_division_id ?? $existingapplicant->subdivision_id,
            $existingapplicant->pcategory_id,
            $existingapplicant->p_type_id ?? $existingapplicant->property_type_id,
            $existingapplicant->quarter_type ?? $existingapplicant->quarter_id
        );

        $this->trackStepStart($applicant->id, 1);

        $completedDocuments = AllotteeDocument::where('allottee_id', $applicant->id)
            ->join('document_master', 'document_master.id', '=', 'allottee_documents.document_id')
            ->get([
                'allottee_documents.*',
                'document_master.id',
                'document_master.document_name as name',
                'document_master.document_key as key',
                'allottee_documents.file_name',
                'allottee_documents.file_path',
            ]);

        $completedIds = $completedDocuments->pluck('id');


        $documents = DocumentMaster::where('document_category', 'nameTransfer')
            ->where('status', 1)
            ->whereNotIn('id', $completedIds)
            ->orderBy('sort_order')
            ->get([
                'id',
                'document_name as name',
                'document_key as key',
            ]);

        // return $applicant;

        return view(
            'applicant.components.nametransfer.index',
            compact(
                'existingapplicant',
                'applicant',
                'getSchemeList',
                'documents',
                'completedDocuments'
            )
        );
    }

    public function getStep($step, $applicantId)
    {
        $view = "applicant.components.nametransfer.step{$step}";

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
                    'father' => 'पिता',
                    'husband' => 'पति',
                ];

                $applicant->relation_type_hindi = $relationMap[$applicant->relation_type] ?? null;

                $districtFields = [
                    'relation_district',
                    'present_district',
                    'permanent_district',
                    'correspondence_district',
                ];

                foreach ($districtFields as $field) {
                    $applicant->{$field . '_hindi'} = $applicant->$field ?? '';
                }

                $applicant->id = $applicant->allottee_id;

                return view($view, compact('applicant'));
            }
            $this->trackStepStart($applicantId, $step);
            $applicant = Allottee::with($baseRelations)->findOrFail($applicantId);

            return view($view, compact('applicant'));
        }

        // STEP 3
        if ($step == 3) {

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
                    'allottee_documents.file_path',
                ]);
            $this->trackStepStart($applicantId, $step);

            return view($view, compact('applicant', 'completedDocuments'));
        }

        // STEP 4
        if ($step == 4) {

            $relations = array_merge($baseRelations, [
                'allotProFinDetail',
                'alloteeAdresses',
                'nomineesBank',
                'accountLedger',
                'documentData',
            ]);

            $this->trackStepStart($applicantId, $step);
            $applicant = Allottee::with($relations)->findOrFail($applicantId);

            return view($view, compact('applicant'));
        }

        // DEFAULT (STEP 1)
        $applicant = Allottee::with($baseRelations)->findOrFail($applicantId);
        $applicant->action = 'update';

        $getSchemeList = getSchemeList(
            $applicant->division_id,
            $applicant->subdivision_id,
            $applicant->pcategory_id,
            $applicant->property_type_id,
            $applicant->quarter_id
        );
        // return $applicant;

        return view($view, compact('applicant', 'getSchemeList'));
    }

    public function skipStep(Request $request)
    {
        try {
            $request->validate([
                'applicant_id' => 'required|integer',
                'step' => 'required|integer',
                'remark' => 'required|string|max:500',
                'reason_category' => 'nullable|string|max:100',
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
                'skipped_at' => now(),
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
                'message' => 'Error skipping step: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function saveStep1(Request $request)
    {
        // common fields
        if (isset($request->allotment_no) && isset($request->year)) {
            $allottmentNumber = $request->allotment_no . '/' . $request->year;
        } else {
            $allottmentNumber = $request->allotment_no;
        }

        $data = [
            'scheme_id' => $request->scheme_id,
            'application_no' => $request->application_no,
            'application_day' => $request->application_day,
            'application_month' => $request->application_month,
            'application_year' => $request->application_year,
            'allotment_no' => $allottmentNumber,
            'allotment_day' => $request->allotment_day,
            'allotment_month' => $request->allotment_month,
            'allotment_year' => $request->allotment_year,

            'prefix' => $request->prefix,
            'allottee_name' => $request->allottee_name,
            'allottee_middle_name' => $request->allottee_middle_name,
            'allottee_surname' => $request->allottee_surname,

            'allottee_prefix_hindi' => $request->allottee_prefix_hindi,
            'allottee_name_hindi' => $request->allottee_name_hindi,
            'allottee_middle_hindi' => $request->allottee_middle_hindi,
            'allottee_surname_hindi' => $request->allottee_surname_hindi,

            'allottee_relation_type' => $request->relation_prefix,
            'relation_name' => $request->relation_name,

            'marital_status' => $request->marital_status,
            'allottee_gender' => $request->allottee_gender,
            'pan_card_number' => $request->pan_card_number,
            'aadhar_card_number' => $request->aadhar_card_number,

            'allottee_category' => $request->allottee_category,
            'allottee_religion' => $request->allottee_religion,
            'allottee_nationality' => $request->allottee_nationality,

            'age_number_of_birth_application' => $request->age_number_of_birth_application,
            'age_number_of_birth_application_hindi' => $request->age_number_of_birth_application_hindi,
            'age_word_of_birth_application' => $request->age_word_of_birth_application,
            'age_word_hindi_of_birth_application' => $request->age_word_hindi_of_birth_application,

            'date_of_birth_day' => $request->date_of_birth_day,
            'date_of_birth_month' => $request->date_of_birth_month,
            'date_of_birth_year' => $request->date_of_birth_year,

            'remarks_for_dob' => $request->remarks_for_dob,
        ];

        // return $data;
        $code = preg_replace('/[^A-Za-z]/', '', $request->quarter_income_code);
        $quarterCode = strtoupper(substr($code, 0, 2));
        $username = $this->generateUniqueUsername(
            $request->division_id,
            $quarterCode,
            $request->subdivision_id,
            $request->allotment_year
        );

        $password = $this->generatePassword();
        $applicant = Allottee::create($data + [

            'register_id' => $request->register_id,
            'division_id' => $request->division_id,
            'subdivision_id' => $request->subdivision_id,
            'pcategory_id' => $request->pcategory_id,
            'property_type_id' => $request->property_type_id,
            'quarter_id' => $request->quarter_id,
            'property_number' => $request->property_number,

            'username' => $username,
            'password' => Hash::make($password),
            'cedjshb' => encrypt($password),

            'parent_id' => $request->allottee_id,
            'current_step' => 2,

            'create_ip_address' => $request->ip(),
            'created_by' => auth()->id(),
            'allottee_create_date' => now()
        ]);

        $jointAllottees = [];
        $jointNames = $request->joint_allottee_name ?? [];

        foreach ($jointNames as $index => $firstName) {
            if (blank($firstName)) {
                continue;
            }

            $jointAllottees[] = [
                'allottee_id' => $applicant->id,

                'prefix' => $request->joint_allottee_prefix[$index] ?? 'Shri',
                'first_name' => $firstName,
                'middle_name' => $request->joint_allottee_middle_name[$index] ?? null,
                'last_name' => $request->joint_allottee_surname[$index] ?? null,

                'prefix_hindi' => $request->joint_allottee_prefix_hindi[$index] ?? 'श्री',
                'first_name_hindi' => $request->joint_allottee_name_hindi[$index] ?? null,
                'middle_name_hindi' => $request->joint_allottee_middle_name_hindi[$index] ?? null,
                'last_name_hindi' => $request->joint_allottee_surname_hindi[$index] ?? null,

                'gender' => $request->joint_allottee_gender[$index] ?? 'Male',

                'aadhar_number' => $request->joint_allottee_aadhar[$index] ?? null,
                'pan_number' => $request->joint_allottee_pan[$index] ?? null,

                'other_doc_type' => $request->joint_allottee_doc_type[$index] ?? null,
                'other_doc_number' => $request->joint_allottee_doc_number[$index] ?? null,

                'created_at' => now(),
            ];
        }

        if (!empty($jointAllottees)) {
            JointAllottee::insert($jointAllottees);
        }


        // mark parent allottee transfer completed
        $parent = Allottee::where('id', $applicant->parent_id)->first();
        if ($parent->is_trans_entry_completed == 0) {
            $parent->update([
                'is_trans_entry_completed' => 1,
                'updated_by' => auth()->id(),
                'update_ip_address' => $request->ip()
            ]);
        }

        // step duration update
        $row = AllotteeStepDuration::where([
            'allottee_id' => $request->allottee_id,
            'step_no' => 1
        ])->first();

        if ($row && $row->started_at) {

            $end = now();
            $duration = Carbon::parse($row->started_at)->diffInMinutes($end);

            $row->update([
                'completed_at' => $end,
                'duration_min' => $duration,
                'allottee_id' => $applicant->id
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Allottee Details saved successfully',
            'applicant_id' => $applicant->id,
            'next_step' => 2
        ]);
    }

    public function updateStep1(Request $request)
    {
        // common fields
        if (isset($request->allotment_no) && isset($request->year)) {
            $allottmentNumber = $request->allotment_no . '/' . $request->year;
        } else {
            $allottmentNumber = $request->allotment_no;
        }

        $data = [
            'scheme_id' => $request->scheme_id,
            'application_no' => $request->application_no,
            'application_day' => $request->application_day,
            'application_month' => $request->application_month,
            'application_year' => $request->application_year,
            'allotment_no' => $allottmentNumber,
            'allotment_day' => $request->allotment_day,
            'allotment_month' => $request->allotment_month,
            'allotment_year' => $request->allotment_year,

            'prefix' => $request->prefix,
            'allottee_name' => $request->allottee_name,
            'allottee_middle_name' => $request->allottee_middle_name,
            'allottee_surname' => $request->allottee_surname,

            'allottee_prefix_hindi' => $request->allottee_prefix_hindi,
            'allottee_name_hindi' => $request->allottee_name_hindi,
            'allottee_middle_hindi' => $request->allottee_middle_hindi,
            'allottee_surname_hindi' => $request->allottee_surname_hindi,

            'allottee_relation_type' => $request->relation_prefix,
            'relation_name' => $request->relation_name,

            'marital_status' => $request->marital_status,
            'allottee_gender' => $request->allottee_gender,
            'pan_card_number' => $request->pan_card_number,
            'aadhar_card_number' => $request->aadhar_card_number,

            'allottee_category' => $request->allottee_category,
            'allottee_religion' => $request->allottee_religion,
            'allottee_nationality' => $request->allottee_nationality,

            'age_number_of_birth_application' => $request->age_number_of_birth_application,
            'age_number_of_birth_application_hindi' => $request->age_number_of_birth_application_hindi,
            'age_word_of_birth_application' => $request->age_word_of_birth_application,
            'age_word_hindi_of_birth_application' => $request->age_word_hindi_of_birth_application,

            'date_of_birth_day' => $request->date_of_birth_day,
            'date_of_birth_month' => $request->date_of_birth_month,
            'date_of_birth_year' => $request->date_of_birth_year,

            'remarks_for_dob' => $request->remarks_for_dob,
        ];

        // check if transfer allottee already created
        $existing = Allottee::where('id', $request->allottee_id)->first();

        if ($existing) {

            $existing->update($data + [
                'update_ip_address' => $request->ip(),
                'updated_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Allottee Details Updated successfully',
                'applicant_id' => $existing->id,
                'next_step' => 2
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Allottee Not found',
            ]);
        }
    }

    public function saveStep2(Request $request)
    {
        $applicantId = $request->applicant_id;
        $data = $request->all();
        $data['update_ip_address'] = $request->ip();

        if (! $request->filled('id')) {
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

        $this->trackStepEnd($applicantId, 2);

        return response()->json([
            'success' => true,
            'message' => 'Address Details saved successfully',
            'data' => $record,
            'next_step' => 3,
        ]);
    }

    public function saveStep3(Request $request)
    {
        $request->validate([
            'allottee_id' => 'required|exists:allottees,id',
            'nametransferValue' => 'nullable|in:yes,no',
            'freeHoldValue' => 'nullable|in:yes,no'
        ]);

        Allottee::where('id', $request->allottee_id)
            ->update([
                'current_step' => 6,
                'name_transfer_status' => $request->nametransferValue,
                'free_hold_status' => $request->freeHoldValue
            ]);

        $this->trackStepEnd($request->allottee_id, 5);

        return response()->json([
            'success' => true,
            'message' => 'All Documents uploaded',
            'next_step' => 4,
        ]);
    }

    public function saveStep4(Request $request)
    {
        if (! $request->final_submission) {
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong',
            ]);
        }

        try {

            DB::beginTransaction();

            $allottee = Allottee::find($request->applicant_id);

            if (! $allottee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Applicant not found',
                ]);
            }

            // Step Completed
            $allottee->update([
                'is_step_completed' => 1,
            ]);
            $this->trackStepEnd($request->allottee_id, 6);
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
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'allottee_id' => 'required|exists:allottees,id',
            'document_id' => 'required|exists:document_master,id',
            'document_file' => 'nullable|file|max:10240',
            'remarks' => 'required_without:document_file|string|nullable',
        ]);

        $applicant = Allottee::with([
            'division:id,division_code',
            'subDivision:id,subdivision_code',
            'propertyCategory:id,name',
            'propertyType:id,name',
            'quarterType:quarter_id,quarter_code',
        ])->findOrFail($request->allottee_id);

        $division = $applicant->division->division_code ?? '';
        $subDivision = $applicant->subDivision->subdivision_code ?? '';
        $category = $applicant->propertyCategory->name ?? '';
        $type = $applicant->propertyType->name ?? '';
        $incomeType = $applicant->quarterType->quarter_code ?? '';
        $year = $applicant->allotment_year;
        $month = str_pad($applicant->allotment_month, 2, '0', STR_PAD_LEFT);
        $propertyNo = preg_replace('/[^A-Za-z0-9]/', '-', $applicant->property_number);

        $documentKey = DocumentMaster::where('id', $request->document_id)->value('document_key');

        $allotteeName = implode('', array_filter([
            $applicant->allottee_name,
            $applicant->allottee_middle_name,
            $applicant->allottee_surname,
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
            $allotteeName,
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
                $month,
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
            'file_path' => $filePath,
            'file_name' => $fileName,
            'doc_no' => $request->doc_no,
            'doc_day' => $request->doc_day,
            'doc_month' => $request->doc_month,
            'doc_year' => $request->doc_year,
            'additional_info' => $request->additional_info,
            'remarks' => $request->remarks,
            'uploaded_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document uploaded successfully',
        ]);
    }
}
