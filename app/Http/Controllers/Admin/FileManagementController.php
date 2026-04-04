<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterAllottee;
use App\Models\RegistrationFile;
use App\Models\AllotteeDocument;
use App\Models\Division;
use App\Models\ExportedFile;
use App\Models\Allottee;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class FileManagementController extends Controller
{
    protected $user;
    protected $id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->id = auth()->id();
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function generateRegisterNo()
    {
        $date = now()->format('dmy'); // 090226
        $rand = rand(1000, 9999);

        return $date . $rand;
    }

    public function LotsList(Request $request)
    {
        try {
            $registrations = RegistrationFile::query()
                ->with(['creator:id,name', 'allottees:id,register_id,allottee_status'])
                ->latest()
                ->get()
                ->map(function ($item) {

                    $statuses = $item->allottees
                        ->pluck('allottee_status')
                        ->map(fn($s) => strtolower(trim($s)))
                        ->toArray();

                    if (!empty($statuses)) {
                        if (in_array('handover', $statuses)) {
                            $item->current_stage = 'Handover';
                            $item->badge_color = 'success';
                        } elseif (in_array('dataentry', $statuses)) {
                            $item->current_stage = 'Data Entry';
                            $item->badge_color = 'info';
                        } elseif (in_array('scanned', $statuses)) {
                            $item->current_stage = 'Scanning';
                            $item->badge_color = 'warning';
                        } else {
                            $item->current_stage = 'Receiving';
                            $item->badge_color = 'secondary';
                        }
                    } else {
                        $item->current_stage = 'Receiving';
                        $item->badge_color = 'secondary';
                    }

                    $item->encoded_register_no = base64_encode($item->register_no);
                    $item->created_named_by = $item->creator->name ?? 'System';

                    return $item;
                });

            return view('admin.components.filereceiving.alllots', compact('registrations'));
        } catch (\Throwable $e) {
            Log::error('Register list failed', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ]);

            return back()->with('error', 'Failed to load register list.');
        }
    }

    public function receivingLotsList(Request $request)
    {
        try {
            $registrations = RegistrationFile::query()
                ->with(['creator:id,name'])
                ->withCount([
                    'allottees as total_files' => function ($q) {
                        $q->where('allottee_status', 'received');
                    },

                ])
                ->where('status', 'received')
                ->whereHas('allottees', function ($q) {
                    $q->where('allottee_status', 'received');
                })
                ->latest()
                ->paginate(25)
                ->through(function ($item) {
                    $item->encoded_register_no = base64_encode($item->register_no);
                    $item->created_named_by = $item->creator->name ?? 'System';
                    return $item;
                });
            // return $registrations;

            return view('admin.components.filereceiving.index', compact('registrations'));
        } catch (\Throwable $e) {
            Log::error('Register list failed', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ]);

            return back()->with('error', 'Failed to load register list.');
        }
    }

    public function receivingLotsFileList($encodedId, $page)
    {
        try {
            $Id = base64_decode($encodedId);
            $relationWith = [
                'division',
                'subDivision',
                'propertyCategory',
                'propertyType',
                'quarterType',
                'registration',
            ];
            $files = RegisterAllottee::query()

                ->with($relationWith)

                ->where('allottee_status', 'received')
                ->where('register_id', $Id)

                ->latest()
                ->paginate(25)
                ->through(function ($item) {

                    $item->register_no = $item->registration->register_no ?? '';
                    $item->encoded_register_no = base64_encode($item->register_no);
                    $item->lot_no = $item->registration->lot_no ?? '';
                    $item->primary_id_encrpted = encrypt($item->id);
                    return $item;
                });
            // return $files;
            $pageNo = $page;
            $registers  = RegistrationFile::where('register_no', $Id)->first();
            $registerId = $registers->id;
            $Lots = $registers->lot_no;
            $registerNo  = $Id;
            return view('admin.components.filereceiving.fileindex', compact('files', 'registerId', 'pageNo', 'Lots', 'registerNo'));
        } catch (\Throwable $e) {

            Log::error('File list failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to load file list.');
        }
    }

    public function receivingfileFetch($encryptedId)
    {
        try {
            $id = decrypt($encryptedId);
            $file = RegisterAllottee::query()
                ->with(['division', 'subDivision', 'propertyCategory', 'propertyType', 'quarterType'])
                ->where('id', $id)
                ->where('allottee_status', 'received')
                ->firstOrFail();
            $file->encoded_register_no = base64_encode($file->register_id);
            $encryptedId;
            $fullName = $file->allottee_name . ' ' . $file->allottee_middle_name . ' ' . $file->allottee_surname;
            $divisions = Division::where('status', 1)->where('id', $file->division_id)->orderBy('name', 'asc')->get();
            return view('admin.components.filereceiving.editfile', compact('file', 'divisions', 'fullName', 'encryptedId'));
        } catch (\Throwable $e) {
            Log::error('File fetch failed', [
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    public function receivingfileUpdate(Request $request, $encryptedId)
    {
        try {
            $id = decrypt($encryptedId);
            $file = RegisterAllottee::where('id', $id)->where('allottee_status', 'received')->firstOrFail();

            $file->update([
                'prefix' => $request->prefix,
                'allottee_name' => $request->allottee_name,
                'allottee_middle_name' => $request->allottee_middle_name,
                'allottee_surname' => $request->allottee_surname,
                'division_id' => $request->division_id,
                'sub_division_id' => $request->sub_division_id,
                'pcategory_id' => $request->pcategory_id,
                'p_type_id' => $request->p_type_id,
                'quarter_type_id' => $request->quarter_type_id,
                'no_of_files' => $request->no_of_files,
                'no_of_supplement' => $request->no_of_supplement,
                'remarks' => $request->remarks,
            ]);

            return redirect()->route('admin.receiving.files.index', ['encodedId' => base64_encode($file->register_id), 'page' => 1])
                ->with('success', 'File updated successfully.');
        } catch (\Throwable $e) {
            Log::error('File update failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update file.');
        }
    }

    public function receivingfilesExports($registerId)
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
        $lotcreateDate = Carbon::parse($register->created_at)->format('d/m/Y');
        $lotTime = Carbon::parse($register->created_at)->format('h:i A');
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
            'lotcreateDate' => $lotcreateDate,
            'lotTime' => $lotTime,
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

    public function scannedLotsList(Request $request)
    {
        try {
            $registrations = RegistrationFile::query()
                ->with(['scannedBy:id,name'])
                ->withCount([
                    'allottees as total_files' => function ($q) {
                        $q->where('allottee_status', 'scanned');
                    },

                ])
                ->where('status', 'scanned')
                ->whereHas('allottees', function ($q) {
                    $q->where('allottee_status', 'scanned');
                })
                ->latest()
                ->paginate(25)
                ->through(function ($item) {
                    $item->encoded_register_no = base64_encode($item->register_no);
                    $item->scanned_named_by = $item->scannedBy->name ?? 'System';
                    return $item;
                });
            // return $registrations;

            return view('admin.components.scanning.index', compact('registrations'));
        } catch (\Throwable $e) {
            Log::error('Register list failed', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ]);

            return back()->with('error', 'Failed to load register list.');
        }
    }

    public function scanningLotsFileList($encodedId, $page)
    {
        try {
            $Id = base64_decode($encodedId);
            $relationWith = [
                'division',
                'subDivision',
                'propertyCategory',
                'propertyType',
                'quarterType',
                'registration',
            ];
            $files = RegisterAllottee::query()

                ->with($relationWith)

                ->where('allottee_status', 'scanned')
                ->where('register_id', $Id)

                ->latest()
                ->paginate(25)
                ->through(function ($item) {

                    $item->register_no = $item->registration->register_no ?? '';
                    $item->encoded_register_no = base64_encode($item->register_no);
                    $item->lot_no = $item->registration->lot_no ?? '';
                    $item->primary_id_encrpted = encrypt($item->id);
                    return $item;
                });
            // return $files;
            $pageNo = $page;
            $registers  = RegistrationFile::where('register_no', $Id)->first();
            $registerId = $registers->id;
            $Lots = $registers->lot_no;
            $registerNo  = $Id;
            return view('admin.components.scanning.fileindex', compact('files', 'registerId', 'pageNo', 'Lots', 'registerNo'));
        } catch (\Throwable $e) {

            Log::error('File list failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to load file list.');
        }
    }

    public function scanningfileFetch($encryptedId)
    {
        try {
            $id = decrypt($encryptedId);
            $file = RegisterAllottee::query()
                ->with(['division', 'subDivision', 'propertyCategory', 'propertyType', 'quarterType'])
                ->where('id', $id)
                ->where('allottee_status', 'scanned')
                ->firstOrFail();
            $file->encoded_register_no = base64_encode($file->register_id);
            $fullName = $file->allottee_name . ' ' . $file->allottee_middle_name . ' ' . $file->allottee_surname;
            $divisions = Division::where('status', 1)->where('id', $file->division_id)->orderBy('name', 'asc')->get();
            return view('admin.components.scanning.editfile', compact('file', 'divisions', 'fullName', 'encryptedId'));
        } catch (\Throwable $e) {
            Log::error('File fetch failed', [
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    public function scanningfileUpdate(Request $request, $encryptedId)
    {
        try {
            $id = decrypt($encryptedId);
            $file = RegisterAllottee::where('id', $id)->where('allottee_status', 'scanned')->firstOrFail();

            $file->update([
                'prefix' => $request->prefix,
                'allottee_name' => $request->allottee_name,
                'allottee_middle_name' => $request->allottee_middle_name,
                'allottee_surname' => $request->allottee_surname,
                'pcategory_id' => $request->pcategory_id,
                'p_type_id' => $request->p_type_id,
                'quarter_type' => $request->quarter_type,
            ]);

            return redirect()->route('admin.scanning.files.index', ['encodedId' => base64_encode($file->register_id), 'page' => 1])
                ->with('success', 'File updated successfully.');
        } catch (\Throwable $e) {
            Log::error('File update failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update file.');
        }
    }

    public function dataentryLotsList(Request $request)
    {
        try {
            $registrations = RegistrationFile::query()
                ->with(['creator:id,name'])
                ->withCount([
                    // Total register files in this lot
                    'registerAllotteeDetails as total_register_files',

                    // Total assigned files against this lot
                    'lotAssignments as total_assigned_files',

                    // Completed files
                    'lotAssignments as total_completed_files' => fn($q) => $q
                        ->where('status', 'completed'),

                    // Pending files
                    'lotAssignments as total_pending_files' => fn($q) => $q
                        ->where('status', 'pending'),

                    // In progress files
                    'lotAssignments as total_inprogress_files' => fn($q) => $q
                        ->where('status', 'in_progress'),
                ])

                // Only those lots where at least one file is still in dataentry stage
                ->whereHas('registerAllotteeDetails', function ($q) {
                    $q->where(function ($sub) {
                        $sub->whereNull('allottee_status')
                            ->orWhereRaw('LOWER(TRIM(allottee_status)) = ?', ['dataentry']);
                    });
                })

                ->latest()
                ->get()

                ->map(function ($item) {
                    $item->not_assigned_files = max(
                        0,
                        $item->total_register_files - $item->total_assigned_files
                    );
                    $item->transfer_file_count = Allottee::query()
                        ->where('register_id', $item->register_no)
                        ->whereNull('register_file_id')
                        ->whereNotNull('parent_id')
                        ->count();
                    $item->encoded_register_no = base64_encode($item->register_no);
                    $item->created_named_by    = $item->creator?->name ?? 'System';
                    $item->current_stage       = 'Data Entry';
                    $item->badge_color         = 'warning';

                    return $item;
                });
            // return $registrations;
            return view(
                'admin.components.filereceiving.dataentryindex',
                compact('registrations')
            );
        } catch (\Throwable $e) {
            Log::error('Data entry lots list failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()->with('error', 'Failed to load lots list.');
        }
    }

    public function dataentryLotsFileList($encodedId, $page)
    {
        // return $this->receivingLotsFileList($encodedId, $page);
        try {
            $registerNo = base64_decode($encodedId);

            $baseRelations = [
                'division',
                'subDivision',
                'propertyCategory',
                'propertyType',
                'quarterType',
            ];
            // return $assignedAllotteeIds;
            $query = Allottee::query()
                ->with($baseRelations)
                ->where('register_id', $registerNo);

            $registerAllottee = $query->paginate(50)->through(function ($item) {
                $item->allotteeId = encrypt($item->id);
                return $item;
            });
            // return $files;
            $files = $registerAllottee;
            $pageNo = $page;
            $registers  = RegistrationFile::where('register_no', $registerNo)->first();
            $registerId = $registers->id;
            $Lots = $registers->lot_no;
            return view('admin.components.filereceiving.dataentryfileindex', compact('files', 'registerId', 'pageNo', 'Lots', 'registerNo'));
        } catch (\Throwable $e) {

            Log::error('File list failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to load file list.');
        }
    }

    public function filePreview($encryptedId)
    {
        try {
            $id = decrypt($encryptedId);
            // return $id;
            $relationWith = [
                'division',
                'subDivision',
                'propertyCategory',
                'propertyType',
                'quarterType',
                'alloteeAdresses',
                'allotProFinDetail',
                'nomineesBank',
                'accountLedger',
                'documentData.document',
                'creator',
                'jointAllottees'
            ];
            $file = Allottee::query()
                ->with($relationWith)
                ->where('id', $id)
                ->firstOrFail();
            $file->encrypted_id = encrypt($file->id);

            $file->documentData = AllotteeDocument::with('document')->where('allottee_id', $file->id)->get();

            $fullName = $file->allottee_name . ' ' . $file->allottee_middle_name . ' ' . $file->allottee_surname;
            // return $file;
            $registration = $file;
            return view('admin.components.filereceiving.previewdata', compact('registration', 'fullName'));
        } catch (\Throwable $e) {
            Log::error('File preview failed', [
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    public function approveDataEntry($encryptedId, Request $request)
    {   
        // return $request;
        try {
            $id = decrypt($encryptedId);
            $file = Allottee::where('id', $id)->firstOrFail();
            if($request->status == 'reverted') {
                $file->update([
                    'sub_admin_allottee_verify' => 2,
                    'sub_admin_remarks' => $request->remarks,
                ]);

                return redirect()->route('admin.dataentry.files.index', ['encodedId' => base64_encode($file->register_id), 'page' => 1])
                    ->with('success', 'Data entry reverted successfully.');
            } else {
                $file->update([
                    'sub_admin_allottee_verify' => 1,
                    'sub_admin_remarks' => $request->remarks,
                ]);
    
                return redirect()->route('admin.dataentry.files.index', ['encodedId' => base64_encode($file->register_id), 'page' => 1])
                    ->with('success', 'Data entry approved successfully.');
            }
        } catch (\Throwable $e) {
            Log::error('Data entry approval failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to approve data entry.');
        }
    }

    public function approveDataEntryLots($registerId, Request $request)
    {
        try {
            $registerNo = base64_decode($registerId);
            if ($registerNo === false) {
                return redirect()->back()->with('error', 'Invalid register ID');
            }
            if ($request->status == 'reverted') {
                RegistrationFile::where('register_no', $registerNo)
                    ->update(['lots_subadmin_approved' => 2, 'status' => 'scanned', 'remarks' => $request->remarks]);

                return redirect()->route('admin.dataentry.lots.index')
                    ->with('success', "Lots reverted successfully by sub-admin for register no: {$registerNo}.");
            } else {
                RegistrationFile::where('register_no', $registerNo)
                    ->update(['lots_subadmin_approved' => 1, 'status' => 'scanned', 'remarks' => $request->remarks]);

                Allottee::where('register_id', $registerNo)->where('is_step_completed', 1)
                    ->update(['allottee_verify' => 1]);

                return redirect()->route('admin.dataentry.lots.index')
                    ->with('success', "Lots approved successfully by sub-admin for register no: {$registerNo}.");
            }
        } catch (\Throwable $e) {
            Log::error('Bulk data entry approval failed', [
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to approve data entry for lots.');
        }
    }
}
