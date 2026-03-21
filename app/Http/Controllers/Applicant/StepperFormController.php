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
use App\Models\AllotteeEmiLedger;
use App\Models\AllotteeDocument;
use App\Models\AllotteeStepDuration;
use App\Models\DocumentMaster;
use App\Models\QuarterType;
use App\Models\LotAssignment;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class StepperFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    private function generateUniqueUsername($division, $incomeTypeId, $subDivision, $date)
    {
        $divisionCode = Division::where('id', $division)->value('division_code');
        $subDivisionCode = SubDivision::where('id', $subDivision)->value('subdivision_code');
        $incomeCode = QuarterType::where('quarter_id', $incomeTypeId)->value('quarter_code');
        $code = preg_replace('/[^A-Za-z]/', '', $incomeCode);
        $quarterCode = strtoupper(substr($code, 0, 2));
        $dateYear = $date;
        $randomString = substr(str_shuffle('0123456789'), 0, 5);
        return "{$divisionCode}{$quarterCode}{$dateYear}{$subDivisionCode}{$randomString}";
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
            $search  = trim($request->query('search'));
            $userId  = auth()->id();

            $query = RegistrationFile::query()
                ->with(['scannedBy:id,name'])
                ->withCount([
                    'allottees as total_files' => function ($q) {
                        $q->where('allottee_status', 'scanned');
                    },

                    'allottees as completed_files' => function ($q) {
                        $q->where('allottee_status', 'dataentry');
                    },

                    'lotAssignments as full_lot_assignment_count' => function ($q) use ($userId) {
                        $q->where('assigned_to', $userId)
                            ->where('assignment_type', 'full_lot');
                    },

                    'lotAssignments as assigned_files_count' => function ($q) use ($userId) {
                        $q->where('assigned_to', $userId)
                            ->where('assignment_type', 'partial')
                            ->whereNotNull('allottee_id');
                    },
                ])
                ->where('status', 'scanned')
                ->whereHas('allottees', function ($q) {
                    $q->where('allottee_status', 'scanned');
                })
                ->whereHas('lotAssignments', function ($q) use ($userId) {
                    $q->where('assigned_to', $userId);
                })
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($sub) use ($search) {
                        $sub->where('register_no', 'like', "%{$search}%")
                            ->orWhere('lot_no', 'like', "%{$search}%");
                    });
                })
                ->latest();

            $registrations = $query->paginate(25)
                ->through(function ($item) {
                    $item->encoded_register_no = encrypt($item->register_no);
                    $item->scanned_named_by    = $item->scannedBy->name ?? 'System';

                    $isFullLotAssigned = (int) ($item->full_lot_assignment_count ?? 0) > 0;

                    $item->assigned_files = $isFullLotAssigned
                        ? (int) ($item->total_files ?? 0)
                        : (int) ($item->assigned_files_count ?? 0);

                    $item->remaining_files = max(
                        0,
                        (int) ($item->assigned_files ?? 0) - (int) ($item->completed_files ?? 0)
                    );

                    $item->assignment_type_label = $isFullLotAssigned ? 'Full Lot' : 'Partial';

                    $item->assignment_status = match (true) {
                        $isFullLotAssigned => 'full_lot',
                        ($item->assigned_files ?? 0) > 0 => 'partial',
                        default => 'not_assigned',
                    };

                    return $item;
                })
                ->withQueryString();
            // return $registrations;
            if ($request->ajax()) {
                return response()->json([
                    'registrations' => $registrations,
                    'pagination'    => $registrations->links()->toHtml(),
                    'search_term'   => $search,
                ]);
            }

            return view(
                'applicant.components.stepper-form.completed',
                compact('registrations', 'search')
            );
        } catch (\Throwable $e) {
            Log::error('Assigned register list failed', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ]);

            return back()->with('error', 'Failed to load assigned lot list.');
        }
    }

    public function completedIndex(Request $request)
    {
        try {

            $search = $request->query('search');

            $query = RegistrationFile::query()
                ->whereHas('registerAllottee') // register me allottee hona chahiye

                ->whereDoesntHave('registerAllottee', function ($q) {
                    $q->where('is_step_completed', '!=', 1);
                })

                ->with([
                    'registerAllottee' => function ($q) {
                        $q->select('id', 'register_id', 'created_by', 'is_step_completed');
                    },
                    'registerAllottee.Usercreator:id,name' // created_by user name
                ])

                ->withCount([
                    'registerAllottee as total_files',
                    'registerAllottee as completed_files' => function ($q) {
                        $q->where('is_step_completed', 1);
                    }
                ])

                ->latest();

            if ($search) {
                $query->where('register_no', 'like', "%{$search}%");
            }

            $registrations = $query->paginate(25);

            $registrations->getCollection()->transform(function ($item) {
                $item->encoded_register_no = base64_encode($item->register_no);
                return $item;
            });

            if ($request->ajax()) {
                return response()->json([
                    'registrations' => $registrations,
                    'pagination' => $registrations->links()->toHtml(),
                    'search_term' => $search
                ]);
            }

            return view(
                'applicant.components.stepper-form.completedLots',
                compact('registrations', 'search')
            );
        } catch (\Throwable $e) {

            Log::error('Register list failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with(
                'error',
                'Failed to load register list.'
            );
        }
    }

    public function fileIndex($registerId, Request $request)
    {
        try {
            $registerNo = decrypt($registerId, true);

            if (!$registerNo) {
                return back()->with('error', 'Invalid register reference.');
            }

            $userId = auth()->id();

            $searchAllottee   = trim($request->query('allottee'));
            $searchPropertyNo = trim($request->query('property_no'));
            $searchArea       = trim($request->query('area'));
            $searchDivision   = $request->query('division');

            $registration = RegistrationFile::query()
                ->select('id', 'register_no', 'lot_no')
                ->where('register_no', $registerNo)
                ->first();

            if (!$registration) {
                return back()->with('error', 'Register not found.');
            }

            $lotId = $registration->id;

            $hasFullLotAssignment = LotAssignment::query()
                ->where('lot_id', $lotId)
                ->where('assigned_to', $userId)
                ->where('assignment_type', 'full_lot')
                ->exists();

            $assignedAllotteeIds = LotAssignment::query()
                ->where('lot_id', $lotId)
                ->where('assigned_to', $userId)
                ->where('assignment_type', 'partial')
                ->whereNotNull('allottee_id')
                ->pluck('allottee_id')
                ->unique()
                ->values();

            if (!$hasFullLotAssignment && $assignedAllotteeIds->isEmpty()) {
                return back()->with('error', 'You are not assigned to this lot.');
            }

            $query = RegisterAllottee::query()
                ->from('register_allottees as ra')
                ->with('scannedBy:id,name')
                ->leftJoin('allottees as a', 'a.register_file_id', '=', 'ra.id')
                ->leftJoin('divisions as d', 'd.id', '=', 'ra.division_id')
                ->leftJoin('sub_divisions as sd', 'sd.id', '=', 'ra.sub_division_id')
                ->leftJoin('property_category as pc', 'pc.id', '=', 'ra.pcategory_id')
                ->leftJoin('property_type as pt', 'pt.id', '=', 'ra.p_type_id')
                ->leftJoin('quarter_type as qt', 'qt.quarter_id', '=', 'ra.quarter_type')
                ->where([
                    ['ra.register_id', '=', $registerNo],
                    ['ra.allottee_status', '=', 'scanned'],
                    ['ra.is_active', '=', 1],
                ])
                ->where(function ($q) {
                    $q->whereNull('a.id')
                        ->orWhere('a.is_step_completed', '!=', 1);
                })
                ->when(!$hasFullLotAssignment, function ($q) use ($assignedAllotteeIds) {
                    $q->whereIn('ra.id', $assignedAllotteeIds);
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

            if ($searchAllottee) {
                $query->where(function ($q) use ($searchAllottee) {
                    $q->where('ra.allottee_name', 'like', "%{$searchAllottee}%")
                        ->orWhere('ra.allottee_middle_name', 'like', "%{$searchAllottee}%")
                        ->orWhere('ra.allottee_surname', 'like', "%{$searchAllottee}%");
                });
            }

            if ($searchPropertyNo) {
                $query->where('ra.property_number', 'like', "%{$searchPropertyNo}%");
            }

            if ($searchArea) {
                $query->where('ra.area', 'like', "%{$searchArea}%");
            }

            if ($searchDivision) {
                $query->where('ra.division_id', $searchDivision);
            }

            $registerAllottee = $query->paginate(25)->withQueryString();

            $encodedRegisterNo = base64_encode($registerNo);

            $registerAllottee->getCollection()->transform(function ($item) use ($encodedRegisterNo, $hasFullLotAssignment) {
                $item->encoded_register_no = $encodedRegisterNo;
                $item->allotteeId = encrypt($item->id);
                $item->assignment_type = $hasFullLotAssignment ? 'full_lot' : 'partial';

                return $item;
            });

            if ($request->ajax()) {
                return response()->json([
                    'registerAllottee' => $registerAllottee,
                    'pagination'       => $registerAllottee->links()->toHtml(),
                    'register_number'  => $registerNo,
                    'assignment_type'  => $hasFullLotAssignment ? 'full_lot' : 'partial',
                    'search_params'    => [
                        'allottee'    => $searchAllottee,
                        'property_no' => $searchPropertyNo,
                        'area'        => $searchArea,
                        'division'    => $searchDivision,
                    ],
                ]);
            }

            $divisions = Division::orderBy('name')->get();

            return view(
                'applicant.components.stepper-form.filesindex',
                compact(
                    'registerAllottee',
                    'registerNo',
                    'divisions',
                    'registerId',
                    'hasFullLotAssignment'
                )
            );
        } catch (\Throwable $e) {
            Log::error('Assigned file index load failed', [
                'register_id' => $registerId,
                'error'       => $e->getMessage(),
                'line'        => $e->getLine(),
                'file'        => $e->getFile(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'error'   => 'Failed to load files.',
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

            if (!$registerNo) {
                return back()->with('error', 'Invalid register reference.');
            }

            $baseRelations = [
                'division',
                'subDivision',
                'propertyCategory',
                'propertyType',
                'quarterType'
            ];

            $registerAllottee = Allottee::with($baseRelations)->where('register_id', $registerNo)->where('is_step_completed', 1)->get();
            return view(
                'applicant.components.stepper-form.completefilesindex',
                compact('registerAllottee', 'registerNo', 'registerId')
            );
        } catch (\Throwable $e) {

            Log::error('File index load failed', [
                'register_id' => $registerId,
                'error'       => $e->getMessage(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'error'   => 'Failed to load files.',
                    'message' => $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Failed to load files.');
        }
    }

    function trackStepStart($allotteeId, $stepNo)
    {
        $track = AllotteeStepDuration::where([
            'allottee_id' => $allotteeId,
            'step_no'     => $stepNo
        ])->first();

        if (!$track) {

            AllotteeStepDuration::create([
                'allottee_id' => $allotteeId,
                'step_no'     => $stepNo,
                'started_at'  => now(),
                'ip_address'  => request()->ip(),
                'user_agent'  => request()->userAgent(),
                'created_by'  => auth()->id(),
            ]);
        } else {

            // agar row hai lekin start time nahi hai
            $track->update([
                'started_at' => now(),
                'ip_address'  => request()->ip(),
                'user_agent'  => request()->userAgent(),
                'created_by'  => auth()->id(),
            ]);
        }
    }

    function trackStepEnd($applicantId, $step)
    {

        $row = AllotteeStepDuration::where([
            'allottee_id' => $applicantId,
            'step_no' => $step
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
        $applicant = Allottee::with(['division', 'subDivision', 'propertyCategory', 'propertyType', 'quarterType'])
            ->where('register_file_id', $id)
            ->first();

        $registerId = RegisterAllottee::whereKey($id)->value('register_id');

        if (!$applicant) {
            $applicant = RegisterAllottee::with([
                'division',
                'subDivision',
                'propertyCategory',
                'propertyType',
                'quarterType'
            ])
                ->where([
                    ['id', $id],
                    ['allottee_status', 'scanned'],
                    ['is_active', 1],
                ])
                ->firstOrFail();
            $applicant->register_file_id = $applicant->id;
            $this->trackStepStart($applicant->id, 1);
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
            'applicant.components.stepper-form.index',
            compact('applicant', 'getSchemeList', 'registerId', 'documents', 'completedDocuments')
        );
    }

    public function getStep($step, $applicantId)
    {
        $view = "applicant.components.stepper-form.step{$step}";

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
            $this->trackStepStart($applicantId, $step);
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
            $this->trackStepStart($applicantId, $step);
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
            $this->trackStepStart($applicantId, $step);
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
            $this->trackStepStart($applicantId, $step);
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

            $this->trackStepStart($applicantId, $step);
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
        $applicantExits = Allottee::where('register_file_id', $request->allottee_id)->first();
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
            $registerAllottee = RegisterAllottee::find($request->applicant_id);
            if (!$registerAllottee) {
                return response()->json(['error' => 'Applicant not found'], 404);
            }
        }

        $usersname = $this->generateUniqueUsername($registerAllottee->division_id, $registerAllottee->quarter_type, $registerAllottee->sub_division_id, $request->allotment_year);
        $password = $this->generatePassword();

        $applicant = new Allottee();
        $applicant->register_id = $request->register_id;
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
        $applicant->date_of_birth_year = $request->date_of_birth_year;
        $applicant->remarks_for_dob = $registerAllottee->remarks_for_dob;
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

        $row = AllotteeStepDuration::where([
            'allottee_id' => $request->applicant_id,
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

        $registerId = RegistrationFile::where('register_no', $request->register_id)->value('id');
        $updateAssigned = LotAssignment::where('lot_id', $registerId)->where('allottee_id', $request->applicant_id)->first();
        $updateAssigned->status = 'in_progress';
        $updateAssigned->updated_at = now();
        $updateAssigned->save();

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

        $this->trackStepEnd($applicantId, 2);

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
                $this->trackStepEnd($request->allottee_id, 3);
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
        $this->trackStepEnd($request->allottee_id, 4);

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

        $updateData = [
            'current_step' => 6,
            'name_transfer_status' => $request->nametransferValue
        ];

        // EMI status only if no_information
        if ($request->emi_status == 'no_information') {
            $updateData['is_emi_active'] = $request->emi_status;
        }

        Allottee::where('id', $request->allottee_id)->update($updateData);

        $this->trackStepEnd($request->allottee_id, 5);

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
            $allottee->step_remarks = $request->remarks;
            $allottee->save();

            $this->trackStepEnd($request->applicant_id, 6);
            // Update RegisterAllottee
            RegisterAllottee::where('id', $allottee->register_file_id)
                ->update([
                    'allottee_status' => 'dataentry',
                ]);

            $registerId = RegistrationFile::where('register_no', $allottee->register_id)->value('id');
            $updateAssigned = LotAssignment::where('lot_id', $registerId)->where('allottee_id', $allottee->register_file_id)->first();
            $updateAssigned->status = 'completed';
            $updateAssigned->completed_at = now();
            $updateAssigned->save();

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
