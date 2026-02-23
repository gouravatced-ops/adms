<?php
// app/Http/Controllers/Applicant/StepperFormController.php
namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\RegistrationFile;
use App\Models\RegisterAllottee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StepperFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
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

    // public function index()
    // {
    //     // Check if there's an existing application in progress
    //     $applicant = Applicant::where('user_id', auth()->id())
    //         ->where('is_completed', false)
    //         ->latest()
    //         ->first();

    //     return view('applicant.components.stepper-form.index', compact('applicant'));
    // }

    public function getStep($step)
    {
        $applicant = Applicant::where('user_id', auth()->id())
            ->where('is_completed', false)
            ->latest()
            ->first();

        return view("applicant.components.stepper-form.step{$step}", compact('applicant'));
    }

    public function saveStep1(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        //     'marital_status' => 'required',
        //     'gender' => 'required',
        //     'pan_card_number' => 'required',
        //     'aadhar_card_number' => 'required',
        //     'email' => 'required|email',
        //     'login_id' => 'required',
        //     'date_of_birth' => 'required|date',
        //     'fathers_name' => 'required',
        //     'full_name_hindi' => 'required',
        //     'annual_income' => 'required',
        //     'present_address' => 'required',
        //     'post_office' => 'required',
        //     'police_station' => 'required',
        //     'state' => 'required',
        //     'district' => 'required',
        //     'pin_code' => 'required|digits:6',
        //     'mobile_number' => 'required|digits:10',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        // $applicant = Applicant::updateOrCreate(
        //     [
        //         'user_id' => auth()->id(),
        //         'current_step' => 1,
        //         'is_completed' => false
        //     ],
        //     array_merge($request->all(), [
        //         'application_number' => 'JSHBA-' . time(),
        //         'current_step' => 2
        //     ])
        // );

        return response()->json([
            'success' => true,
            'message' => 'Step 1 saved successfully',
            'applicant_id' => 1,
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
            'message' => 'Step 2 saved successfully',
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
            'message' => 'Step 3 saved successfully',
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
            'message' => 'Application submitted successfully',
            'next_step' => 5
        ]);
    }
}
