<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\RegisterAllottee;
use App\Models\RegistrationFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ScannedController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function index(Request $request)
    {
        try {
            $search = $request->query('search', '');

            $query = RegistrationFile::with('allottees')
                ->where('created_by', auth()->id())
                ->whereHas('allottees', function ($q) {
                    // At least one allottee NOT scanned
                    $q->where('allottee_status', '!=', 'scanned');
                })
                ->orderBy('created_at', 'desc');

            // Search filter
            if (!empty($search)) {
                $query->where('register_no', 'like', '%' . $search . '%');
            }

            $registrations = $query->paginate(25)->through(function ($item) use ($search) {

                $item->encoded_register_no = base64_encode($item->register_no);

                // Check if fully scanned
                $totalAllottees = $item->allottees->count();
                $scannedCount = $item->allottees
                    ->where('allottee_status', 'scanned')
                    ->count();

                $item->is_fully_scanned = ($totalAllottees === $scannedCount);

                // Highlight search
                if ($search && str_contains(strtolower($item->register_no), strtolower($search))) {
                    $item->highlighted = true;
                }

                return $item;
            });

            $totalFullyScanned = RegistrationFile::whereDoesntHave('allottees', function ($q) {
                $q->where('allottee_status', '!=', 'scanned');
            })->count();

            $totalPending = RegistrationFile::whereHas('allottees', function ($q) {
                $q->where('allottee_status', '!=', 'scanned');
            })->count();

            if ($request->ajax()) {
                return response()->json([
                    'registrations' => $registrations,
                    'pagination' => $registrations->links()->toHtml(),
                    'search_term' => $search,
                    'total_fully_scanned' => $totalFullyScanned,
                    'total_pending' => $totalPending,
                ]);
            }

            return view(
                'applicant.components.scanning.index',
                compact(
                    'registrations',
                    'search',
                    'totalFullyScanned',
                    'totalPending'
                )
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

    public function completedScanned(Request $request)
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
                'applicant.components.scanning.completed',
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
                'applicant.components.scanning.filesindex',
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

    public function store(Request $request)
    {
        $request->validate([
            'allottee_id' => 'required|exists:register_allottees,id',
            'file_pages'  => 'required|array',
            'file_pages.*' => 'nullable|integer|min:0|max:999'
        ]);

        try {

            // Clean values (remove empty & convert to int)
            $pages = collect($request->file_pages)
                ->map(fn($value) => (int) $value)
                ->filter(fn($value) => $value > 0)
                ->values();

            // Total pages calculate
            $totalPages = $pages->sum();

            // JSON format store
            $jsonPages = $pages->map(function ($page, $index) {
                return [
                    'file_name' => 'File-' . ($index + 1),
                    'pages'     => $page
                ];
            });

            // Update record
            RegisterAllottee::where('id', $request->allottee_id)
                ->update([
                    'json_pages'  => $jsonPages->toJson(),
                    'total_pages' => $totalPages,
                    'allottee_status' => 'scanned',
                    'scanned_by' => auth()->id()
                ]);

            RegistrationFile::where('register_no', $request->register_no)->update(['status' => 'scanned', 'scanned_by' => auth()->id()]);

            return redirect()->back()->with('success', 'Files Scanned successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
