<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\ExportedFile;
use App\Models\Register;
use App\Models\RegisterAllottee;
use App\Models\RegistrationFile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FileRecevingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function generateRegisterNo()
    {
        $date = now()->format('dmy'); // 090226
        $rand = rand(1000, 9999);

        return $date . $rand;
    }

    public function index(Request $request)
    {
        try {
            $search = $request->query('search', '');

            $query = RegistrationFile::query()
                ->orderBy('created_at', 'desc');

            // Apply search filter
            if (! empty($search)) {
                $query->where('register_no', 'like', '%' . $search . '%');
            }

            $registrations = $query->paginate(10)->through(function ($item) use ($search) {
                $item->encoded_register_no = base64_encode($item->register_no);

                // Highlight search term in response (optional)
                if ($search && strpos(strtolower($item->register_no), strtolower($search)) !== false) {
                    $item->highlighted = true;
                }

                return $item;
            });

            // If AJAX request, return JSON
            if ($request->ajax()) {
                return response()->json([
                    'registrations' => $registrations,
                    'pagination' => $registrations->links()->toHtml(),
                    'search_term' => $search,
                ]);
            }

            return view(
                'applicant.components.filereceiving.index',
                compact('registrations', 'search')
            );
        } catch (\Throwable $e) {
            Log::error('Registration index failed', [
                'error' => $e->getMessage(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to load registrations.',
                    'message' => $e->getMessage(),
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', 'Failed to load registrations.');
        }
    }

    public function fileIndex(string $registerId, Request $request)
    {
        try {
            // Decode register number safely
            $registerNo = base64_decode($registerId, true);

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
                ->orderByDesc('ra.created_at')
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
                $query->where('ra.allottee_name', 'like', '%' . $searchAllottee . '%');
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
            $registerAllottee = $query->paginate(10);

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
                'applicant.components.filereceiving.filesindex',
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

    // In your controller
    public function createPage()
    {
        // Get data for dropdowns
        $register = Register::create([
            'register_no' => $this->generateRegisterNo(),
        ]);

        $data = [
            'divisions' => getDivisions(),
            'quarterTypes' => getQuarterType(),
            'getPropertyCategory' => getPropertyCategory(),
            'getQuarterType' => getQuarterType(),
            'register' => $register,
        ];

        return view('applicant.components.filereceiving.create', $data);
    }

    // In your controller
    public function addFilesPage($registerId)
    {
        $registerNo = base64_decode($registerId);
        // Get data for dropdowns
        $register = RegistrationFile::where('register_no', $registerNo)->first();

        $data = [
            'divisions' => getDivisions(),
            'quarterTypes' => getQuarterType(),
            'getPropertyCategory' => getPropertyCategory(),
            'getQuarterType' => getQuarterType(),
            'register' => $register,
        ];

        return view('applicant.components.filereceiving.addfiling', $data);
    }

    public function store(Request $request)
    {
        try {
            $tempRegister = Register::where('register_no', $request->register_id)->first();
            if (! $tempRegister) {
                return response()->json([
                    'success' => false,
                    'message' => 'Register not found',
                ], 404);
            }

            if ($tempRegister->total_files > 0) {
                // update
                $finalRegistration = RegistrationFile::where('register_no', $request->register_id)->first();
                $finalRegistration->register_no = $tempRegister->register_no;
                $finalRegistration->total_files = $tempRegister->total_files;
                $finalRegistration->remarks = $tempRegister->remarks;
                $finalRegistration->status = 'submitted';
                $finalRegistration->created_by = auth()->id();
                $finalRegistration->created_at = NOW();
                $finalRegistration->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Allottee saved successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No allottee saved. Cannot register file.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeIndividual(Request $request)
    {
        try {
            $exists = RegisterAllottee::where('property_number', $request->property_number)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This property number is already added in this registration.',
                ]);
            }

            $exists = RegistrationFile::where('register_no', $request->register_id)->exists();
            if (! $exists) {
                $tempRegister = Register::where('register_no', $request->register_id)->first();

                if (! $tempRegister) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Register not found',
                    ], 404);
                }

                $finalRegistration = new RegistrationFile;
                $finalRegistration->register_no = $tempRegister->register_no;
                $finalRegistration->total_files = $tempRegister->total_files + 1;
                $finalRegistration->remarks = $tempRegister->remarks;
                $finalRegistration->status = 'submitted';
                $finalRegistration->created_by = auth()->id();
                $finalRegistration->created_at = NOW();
                $finalRegistration->save();
            } else {
                // Prevent creating if already 2
                $finalRegistration = RegistrationFile::where('register_no', $request->register_id)->first();
                if ($finalRegistration->total_files >= 15) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maximum file limit (15) reached for this register.',
                    ], 400);
                }
                $finalRegistration->total_files = $finalRegistration->total_files + 1;
                $finalRegistration->updated_at = NOW();
                $finalRegistration->save();
            }

            $data = $request->all();
            $data['created_by'] = auth()->id();
            $data['ip_address'] = $request->ip();
            $allottee = RegisterAllottee::create($data);

            Register::where('register_no', $request->register_id)
                ->increment('total_files');

            return response()->json([
                'success' => true,
                'allottee_id' => $allottee->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('storeIndividual failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // In your controller
    public function deleteEmptyRegister(Request $request)
    {
        $request->validate([
            'register_id' => 'required|string',
        ]);

        $register = Register::where('register_no', $request->register_id)
            ->whereDoesntHave('allottees')
            ->first();

        if ($register) {
            $register->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Register not found or has allottees']);
    }

    public function deleteAllottee(Request $request)
    {
        $request->validate([
            'allottee_id' => 'required',
        ]);

        $allottee = RegisterAllottee::find($request->allottee_id);
        if ($allottee->register_id) {
            $register = Register::where('register_no', $allottee->register_id)->first();

            if ($register) {
                $register->total_files = max(0, $register->total_files - 1);
                $register->save();
            }
        }
        if ($allottee) {
            $allottee->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Allottee not found']);
    }

    public function ScannerdeleteAllottee($Id)
    {
        $encodedId = base64_decode($Id);
        $allottee = RegisterAllottee::find($encodedId);
        if ($allottee->register_id) {
            $register = RegistrationFile::where('register_no', $allottee->register_id)->first();

            if ($register) {
                $register->total_files = max(0, $register->total_files - 1);
                $register->save();
            }
        }
        if ($allottee) {
            $allottee->delete();

            return redirect()
                ->back()
                ->with('success', 'Allottee Successfully Deteled of This file');
        }

        return redirect()
            ->back()
            ->with('error', 'Failed to load registrations.');
    }

    public function FetchAllotesDetails($allotteeId)
    {
        $encodedId = base64_decode($allotteeId);
        $allottee = RegisterAllottee::find($encodedId);        // Get data for dropdowns
        $register = RegistrationFile::where('register_no', $allottee->register_id)->first();

        $data = [
            'divisions' => getDivisions(),
            'quarterTypes' => getQuarterType(),
            'getPropertyCategory' => getPropertyCategory(),
            'getQuarterType' => getQuarterType(),
            'register' => $register,
            'allottes' => $allottee,
        ];

        return view('applicant.components.filereceiving.editfiles', $data);
    }

    public function updateAllottee(Request $request)
    {
        $request->validate([
            'allottee_id' => 'required|integer',
            'division_id' => 'required',
            'sub_division_id' => 'required',
            'pcategory_id' => 'required',
            'p_type_id' => 'required',
            'property_number' => 'required|string',
            'allottee_name' => 'required|string',
            'no_of_files' => 'required',
            'no_of_supplement' => 'nullable|min:0|max:10',
            'remarks' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['updated_by'] = auth()->id();
        $data['ip_address'] = $request->ip();
        $allottee = RegisterAllottee::find($data['allottee_id']);

        if ($allottee) {
            $allottee->update($data);

            return response()->json([
                'success' => true,
                'allottee_id' => $allottee->id,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Allottee not found']);
    }

    public function updateAllotteeDetails(Request $request)
    {
        $validated = $request->validate([
            'allottee_id' => 'required',
            'division_id' => 'required',
            'sub_division_id' => 'required',
            'pcategory_id' => 'required',
            'p_type_id' => 'required',
            'quarter_type' => 'nullable',
            'property_number' => 'required|string',
            'allottee_name' => 'required|string',
            'no_of_files' => 'required',
            'no_of_supplement' => 'nullable|min:0|max:10',
            'remarks' => 'nullable|string',
        ]);

        $duplicate = RegisterAllottee::where('property_number', $validated['property_number'])
            ->where('id', '!=', $validated['allottee_id'])
            ->exists();

        if ($duplicate) {
            return response()->json([
                'success' => false,
                'message' => 'This property number is already added in this registration.',
            ], 422);
        }

        $allottee = RegisterAllottee::find($validated['allottee_id']);

        $allottee->update([
            'division_id' => $validated['division_id'],
            'sub_division_id' => $validated['sub_division_id'],
            'pcategory_id' => $validated['pcategory_id'],
            'p_type_id' => $validated['p_type_id'],
            'property_number' => $validated['property_number'],
            'quarter_type' => $validated['quarter_type'] ?? null,
            'allottee_name' => $validated['allottee_name'],
            'remarks' => $validated['remarks'] ?? null,
            'no_of_files' => $validated['no_of_files'],
            'no_of_supplement' => $validated['no_of_supplement'] ?? '0',
            'ip_address' => $request->ip() ?? NULL,
            'updated_by' => auth()->id() ?? null,
        ]);

        return response()->json([
            'success' => true,
            'allottee_id' => $allottee->id,
        ]);
    }

    public function filesExports($registerId)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $registerNo = base64_decode($registerId, true);

        if ($registerNo === false) {
            return redirect()->back()->with('error', 'Invalid register ID');
        }

        $allottees = RegisterAllottee::query()
            ->from('register_allottees as ra')
            ->leftJoin('divisions as d', 'd.id', '=', 'ra.division_id')
            ->leftJoin('sub_divisions as sd', 'sd.id', '=', 'ra.sub_division_id')
            ->leftJoin('property_category as pc', 'pc.id', '=', 'ra.pcategory_id')
            ->leftJoin('property_type as pt', 'pt.id', '=', 'ra.p_type_id')
            ->leftJoin('quarter_type as qt', 'qt.quarter_id', '=', 'ra.quarter_type')
            ->where('ra.register_id', $registerNo)
            ->orderByDesc('ra.created_at')
            ->select([
                'ra.*',
                'd.name  as dname',
                'sd.name as subname',
                'pc.name as cname',
                'pt.name as pname',
                'qt.quarter_code as quarter_code',
            ])
            ->get();

        if ($allottees->isEmpty()) {
            return redirect()->back()->with('error', 'No records found');
        }

        $data = [
            'title' => 'COMPUTER Ed. - Files Receiving',
            'date' => date('d/m/Y'),
            'allottees' => $allottees,
            'registerNo' => $registerNo,
            'logo1' => public_path('assets/indian-bank.png'),
            'logo2' => public_path('assets/insta-logo.jpg'),
            'logo3' => public_path('assets/applicant/auth/images/jspc_logo_in.png'),
            'copies' => [
                'OFFICE COPY - COMPUTER Ed.',
                'OFFICE COPY - JHARKHAND STATE HOUSING BOARD',
                'OFFICE COPY - INDIAN BANK HARMU COLONY RANCHI BRANCH',
            ],
        ];

        $pdf = Pdf::loadView('exports.register-allottees', $data)
            ->setPaper('A4', 'portrait')
            ->setOption('defaultFont', 'dejavu sans');

        $filename = 'Files-Receiving-' . $registerNo . '-' . time() . '.pdf';

        $directory = public_path("uploads/{$registerNo}/files");

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filePath = $directory . '/' . $filename;
        file_put_contents($filePath, $pdf->output());

        $fileSize = filesize($filePath);

        ExportedFile::create([
            'register_no' => $registerNo,
            'file_name' => $filename,
            'file_path' => "uploads/{$registerNo}/files/{$filename}",
            'file_size' => $fileSize,
        ]);

        return response()->download($filePath);
    }
}