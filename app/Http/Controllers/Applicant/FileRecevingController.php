<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Division;
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

            $query = RegistrationFile::with('creator')
                ->where('created_by', auth()->id())
                ->whereHas('allottees', function ($q) {
                    $q->where('allottee_status', '=', 'received');
                })
                ->orderBy('created_at', 'desc');

            if (!empty($search)) {
                $query->where('register_no', 'like', '%' . $search . '%');
            }

            $registrations = $query->paginate(25)->through(function ($item) use ($search) {

                $item->encoded_register_no = base64_encode($item->register_no);

                // Add creator name safely
                $item->created_by_name = $item->creator->name ?? 'N/A';

                if ($search && strpos(strtolower($item->register_no), strtolower($search)) !== false) {
                    $item->highlighted = true;
                }

                if ($search && strpos(strtolower($item->lot_no), strtolower($search)) !== false) {
                    $item->highlighted = true;
                }

                return $item;
            });

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
                ->where('ra.allottee_status', 'received')
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
                    'ra.no_of_files as total_files'
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
            'register' => $register,
            'divisions' => getDivisions()
        ];

        return view('applicant.components.filereceiving.register', $data);
    }

    public function generateRgistrationFileLimit(Request $request)
    {
        $request->validate([
            'allowed_files' => 'required|integer|min:1|max:35',
            'register_id' => 'required',
            'division_id' => 'required',
        ]);

        $register = Register::where('register_no', $request->register_id)->first();
        $register->allowed_files = $request->allowed_files;
        $register->division_id = $request->division_id;
        $register->save();

        $divisions = Division::where('id', $request->division_id)->get();

        $data = [
            'divisions' => $divisions,
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
        $divisions = Division::where('id', $register->division_id)->get();

        $data = [
            'divisions' => $divisions,
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
                $finalRegistration->status = 'received';
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
            // $exists = RegisterAllottee::where('division_id', $request->division_id)->where('sub_division_id', $request->sub_division_id)->where('property_number', $request->property_number)
            //     ->exists();

            // if ($exists) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'This property number is already added in this registration.',
            //     ]);
            // }

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
                $finalRegistration->lot_no = 'Lot-' . RegistrationFile::max('id') + 1;
                $finalRegistration->register_no = $tempRegister->register_no;
                $finalRegistration->total_files = $tempRegister->total_files + 1;
                $finalRegistration->allowed_files = $tempRegister->allowed_files;
                $finalRegistration->remarks = $tempRegister->remarks;
                $finalRegistration->division_id = $tempRegister->division_id;
                $finalRegistration->status = 'received';
                $finalRegistration->created_by = auth()->id();
                $finalRegistration->created_at = NOW();
                $finalRegistration->save();
            } else {
                // Prevent creating if already 2
                $finalRegistration = RegistrationFile::where('register_no', $request->register_id)->first();
                if ($finalRegistration->total_files >= 35) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maximum file limit (35) reached for this register.',
                    ], 400);
                }
                $finalRegistration->total_files = $finalRegistration->total_files + 1;
                $finalRegistration->updated_at = NOW();
                $finalRegistration->save();
            }

            $data = $request->all();
            if ($data['confirm_same_allottee_name'] == 'Yes') {
                $data['parent_id'] = $data['allottee_exists_id'] ?? null;
            } else {
                $data['parent_id'] = null;
            }
            if (!isset($data['has_supplement']) || $data['has_supplement'] == 'No') {
                $data['no_of_supplement'] = 0;
            }
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
            $allottee->is_active = 0;
            $allottee->save();

            RegistrationFile::where('register_no', $allottee->register_id)
                ->decrement('total_files');

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
        $divisions = Division::where('id', $register->division_id)->get();

        $data = [
            'divisions' => $divisions,
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
            'prefix' => 'required|string',
            'allottee_name' => 'required|string',
            'allottee_middle_name' => 'nullable|string',
            'allottee_surname' => 'nullable|string',
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
            'prefix' => 'required|string',
            'allottee_name' => 'required|string',
            'allottee_middle_name' => 'nullable|string',
            'allottee_surname' => 'nullable|string',
            'no_of_files' => 'required',
            'no_of_supplement' => 'nullable|min:0|max:10',
            'remarks' => 'nullable|string',
        ]);

        // $duplicate = RegisterAllottee::where('division_id', $validated['division_id'])->where('sub_division_id', $validated['sub_division_id'])->where('property_number', $validated['property_number'])
        //     ->where('id', '!=', $validated['allottee_id'])
        //     ->exists();

        // if ($duplicate) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'This property number is already added in this registration.',
        //     ], 422);
        // }

        $allottee = RegisterAllottee::find($validated['allottee_id']);

        $allottee->update([
            'division_id' => $validated['division_id'],
            'sub_division_id' => $validated['sub_division_id'],
            'pcategory_id' => $validated['pcategory_id'],
            'p_type_id' => $validated['p_type_id'],
            'property_number' => $validated['property_number'],
            'quarter_type' => $validated['quarter_type'] ?? null,
            'prefix' => $validated['prefix'],
            'allottee_name' => $validated['allottee_name'],
            'allottee_middle_name' => $validated['allottee_middle_name'],
            'allottee_surname' => $validated['allottee_surname'],
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

    public function checkPropertyNumber(Request $request)
    {
        $validated = $request->validate([
            'division_id'       => ['required', 'integer'],
            'sub_division_id'   => ['required', 'integer'],
            'pcategory_id'      => ['nullable', 'integer'],
            'p_type_id'         => ['nullable', 'integer'],
            'property_number'   => ['required', 'string'],
            'allottee_id'       => ['nullable', 'integer'],
        ]);

        // ✅ Base Query
        $baseQuery = RegisterAllottee::query()
            ->where('division_id', $validated['division_id'])
            ->where('sub_division_id', $validated['sub_division_id'])
            ->where('property_number', $validated['property_number'])
            ->when($validated['pcategory_id'] ?? null, fn($q, $v) => $q->where('pcategory_id', $v))
            ->when($validated['p_type_id'] ?? null, fn($q, $v) => $q->where('p_type_id', $v))
            ->when($validated['allottee_id'] ?? null, fn($q, $v) => $q->where('id', '!=', $v));

        $latest = (clone $baseQuery)
            ->select([
                'id',
                'parent_id',
                'prefix',
                'allottee_name',
                'allottee_middle_name',
                'allottee_surname',
                'no_of_files',
                'no_of_supplement',
            ])
            ->latest()
            ->first();

        if (!$latest) {
            return response()->json([
                'status' => false,
                'message' => 'Property not found',
            ]);
        }

        $rootId = $latest->id;

        while ($parent = RegisterAllottee::where('id', $rootId)->value('parent_id')) {
            $rootId = $parent;
        }

        $ids = [$rootId];
        $queue = [$rootId];

        while (!empty($queue)) {
            $children = RegisterAllottee::whereIn('parent_id', $queue)->pluck('id')->toArray();
            $ids = array_merge($ids, $children);
            $queue = $children;
        }

        $totalSupplement = RegisterAllottee::whereIn('id', $ids)
            ->sum('no_of_supplement');

        return response()->json([
            'status' => true,
            'data' => [
                'id_exits' => $latest->id,
                'prefix' => $latest->prefix,
                'allottee_name' => $latest->allottee_name,
                'allottee_middle_name' => $latest->allottee_middle_name,
                'allottee_surname' => $latest->allottee_surname,
                'no_of_files' => $latest->no_of_files,
                'no_of_supplement' => $totalSupplement,
            ]
        ]);
    }

    public function checkPropertyNumberForRecivingFileAdd(Request $request)
    {
        $validated = $request->validate([
            'property_number' => ['required', 'string']
        ]);

        $collection = RegisterAllottee::with(['division:id,name', 'subDivision:id,name'])
            ->where('property_number', $validated['property_number'])
            ->latest() // same as orderBy('created_at', 'desc')
            ->get();

        // Transform list
        $data = $collection->map(function ($item) {
            return [
                'property_number'   => $item->property_number,
                'allottee_name'     => trim(
                    $item->prefix . ' ' .
                        $item->allottee_name . ' ' .
                        $item->allottee_middle_name . ' ' .
                        $item->allottee_surname
                ),
                'division'          => $item->division->name ?? null,
                'subdivision'       => $item->subDivision->name ?? null,
                'parent_id'         => $item->parent_id,
                'no_of_files'       => $item->no_of_files,
                'no_of_supplement'  => $item->no_of_supplement,
                'creadted_at'       => $item->created_at->format('d-m-Y H:i:s'),
            ];
        });

        // 👉 total rows
        $totalRows = $collection->count();

        // 👉 parent row
        $parent = $collection->firstWhere('parent_id', null);

        // 👉 total_files calculation
        $totalFiles = 0;

        if ($parent) {
            $parentTotal = ($parent->no_of_files ?? 0) + ($parent->no_of_supplement ?? 0);

            $childSupplement = $collection
                ->whereNotNull('parent_id')
                ->sum('no_of_supplement');

            $totalFiles = $parentTotal + $childSupplement;
        }

        return response()->json([
            'status'      => true,
            'exists'      => $data->isNotEmpty(),
            'total_rows'  => $totalRows,
            'total_files' => $totalFiles,
            'data'        => $data->values(),
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

        $register = RegistrationFile::where('register_no', $registerNo)->first();
        $registerDivision = Division::where('id', $register->division_id)->value('name');
        $lotNumber = strtoupper($register->lot_no);
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
            'lotDivision' => $registerDivision,
            'lotNumber' => $lotNumber,
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

        $todayDate = $this->generateRegisterNo();
        $smallcaseLots = strtolower($lotNumber);
        $filename = $smallcaseLots . '_' . $todayDate . '-ced-jshb-receiving.pdf';

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
