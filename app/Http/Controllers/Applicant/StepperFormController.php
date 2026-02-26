<?php
// app/Http/Controllers/Applicant/StepperFormController.php
namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\RegistrationFile;
use App\Models\RegisterAllottee;
use App\Models\Allottee;
use App\Models\Division;
use App\Models\SubDivision;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
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

    private function generatePassword()
    {
        $year = date('y');
        $month = date('m');
        $password = 'CDHB' . $year . $month;
        return $password;
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

        return view(
            'applicant.components.stepper-form.index',
            compact('applicant', 'getSchemeList', 'registerId')
        );
    }

    public function getStep($step, $applicantId)
    {
        $applicant = Allottee::with(['division', 'subDivision', 'propertyCategory', 'propertyType'])
            ->findOrFail($applicantId);

        $getSchemeList = getSchemeList(
            $applicant->division_id,
            $applicant->subdivision_id,
            $applicant->pcategory_id,
            $applicant->property_type_id,
            $applicant->quarter_id,
        );

        $view = "applicant.components.stepper-form.step{$step}";
        // return $applicant;
        return view($view, compact('applicant', 'getSchemeList'));
    }

    public function saveStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'applicant_id' => 'required',
            'scheme_id' => 'required',
            'application_no' => 'required',
            'application_date' => 'required|date',
            'allotment_no' => 'required',
            'year' => 'required|digits:4',
            'allotment_date' => 'required|date',
            'prefix' => 'required',
            'allottee_name' => 'required',
            'allottee_middle_name' => 'nullable',
            'allottee_surname' => 'nullable',
            'allottee_prefix_hindi' => 'required',
            'allottee_name_hindi' => 'required',
            'allottee_middle_hindi' => 'nullable',
            'allottee_surname_hindi' => 'nullable',
            'relation_prefix' => 'required',
            'relation_name' => 'required',
            'marital_status' => 'required',
            'allottee_gender' => 'required',
            'pan_card_number' => 'nullable|alpha_num|size:10',
            'aadhaar_number' => 'nullable|digits:12',
            'allottee_category' => 'required',
            'date_of_birth' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (Allottee::where('id', $request->applicant_id)->exists()) {
            $applicant = Allottee::where('id', $request->applicant_id)->first();
            // update existing applicant
            $applicant->update([
                'scheme_id' => $request->scheme_id,
                'application_no' => $request->application_no,
                'application_date' => $request->application_date,
                'allotment_no' => $request->allotment_no . '/' . $request->year,
                'allotment_date' => $request->allotment_date,
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
                'aadhar_card_number' => $request->aadhaar_number,
                'allottee_category' => $request->allottee_category,
                'date_of_birth' => $request->date_of_birth,
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
        $applicant->text_password = $password;
        $applicant->scheme_id = $request->scheme_id;
        $applicant->application_no = $request->application_no;
        $applicant->application_date = $request->application_date;
        $applicant->allotment_no = $request->allotment_no . '/' . $request->year;
        $applicant->allotment_date = $request->allotment_date;
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
        $applicant->aadhar_card_number = $request->aadhaar_number;
        $applicant->allottee_category = $request->allottee_category;
        $applicant->date_of_birth = $request->date_of_birth;
        $applicant->no_of_files = $registerAllottee->no_of_files;
        $applicant->no_of_supplement = $registerAllottee->no_of_supplement;
        $applicant->json_pages = $registerAllottee->json_pages;
        $applicant->total_pages = $registerAllottee->total_pages;
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
        // $applicant = Applicant::where('user_id', auth()->id())
        //     ->where('is_completed', false)
        //     ->latest()
        //     ->first();

        // if (!$applicant) {
        //     return response()->json(['error' => 'No application found'], 404);
        // }

        // $validator = Validator::make($request->all(), [
        //     'nominee_name' => 'required',
        //     'nominee_relationship' => 'required',
        //     'nominee_pan_card' => 'required',
        //     'nominee_aadhaar' => 'required|digits:12',
        //     'family_details' => 'required|array',
        //     'bank_name' => 'required',
        //     'bank_account_no' => 'required',
        //     'bank_branch' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        // $applicant->update([
        //     'nominee_name' => $request->nominee_name,
        //     'nominee_relationship' => $request->nominee_relationship,
        //     'nominee_pan_card' => $request->nominee_pan_card,
        //     'nominee_aadhaar' => $request->nominee_aadhaar,
        //     'family_details' => json_encode($request->family_details),
        //     'bank_name' => $request->bank_name,
        //     'bank_account_no' => $request->bank_account_no,
        //     'bank_branch' => $request->bank_branch,
        //     'current_step' => 3
        // ]);

        return response()->json([
            'success' => true,
            'message' => 'Address Details saved successfully',
            'next_step' => 3
        ]);
    }

    public function saveStep3(Request $request)
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
            'message' => 'Property Finanical saved successfully',
            'next_step' => 4
        ]);
    }

    public function saveStep4(Request $request)
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
            'message' => 'Nominee & Banking saved successfully',
            'next_step' => 5
        ]);
    }

    public function saveStep5(Request $request)
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
            'message' => 'Property Details saved successfully',
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
            'message' => 'Documents Uploads Save SuccessFully',
            'next_step' => 7
        ]);
    }

    public function saveStep7(Request $request)
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
}
