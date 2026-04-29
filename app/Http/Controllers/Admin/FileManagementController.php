<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterAllottee;
use App\Models\RegistrationFile;
use App\Models\AllotteeDocument;
use App\Models\AllotteeMasterDocument;
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
        $date = now()->format('dmy');
        $rand = rand(1000, 9999);

        return $date . $rand;
    }

    public function LotsList(Request $request)
    {
        try {

            $registrations = RegistrationFile::query()
                ->with('creator:id,name')

                ->withCount([
                    'allottees as scanned_count' => fn($q) => $q->where('allottee_status', 'scanned'),
                    'allottees as dataentry_count' => fn($q) => $q->where('allottee_status', 'dataentry'),
                    'allottees as handover_count' => fn($q) => $q->where('allottee_status', 'handover'),
                ])

                ->select('*')
                ->selectSub(function ($q) {
                    $q->from('register_allottees')
                        ->selectRaw("
                            SUM(
                                CASE 
                                    WHEN parent_id IS NULL 
                                        THEN COALESCE(no_of_files,0) + COALESCE(no_of_supplement,0)
                                    ELSE 
                                        COALESCE(no_of_supplement,0)
                                END
                            )
                        ")
                        ->whereColumn('register_allottees.register_id', 'file_registrations.register_no');
                }, 'total_received_files')

                ->latest()
                ->get()

                ->map(function ($item) {

                    // 🎯 Stage logic (FAST)
                    if ($item->handover_count > 0) {
                        $item->current_stage = 'Handover';
                        $item->badge_color = 'success';
                    } elseif ($item->dataentry_count > 0) {
                        $item->current_stage = 'Data Entry';
                        $item->badge_color = 'info';
                    } elseif ($item->scanned_count > 0) {
                        $item->current_stage = 'Scanning';
                        $item->badge_color = 'warning';
                    } else {
                        $item->current_stage = 'Receiving';
                        $item->badge_color = 'secondary';
                    }

                    // 🎯 Other fields
                    $item->encoded_register_no = base64_encode($item->register_no);
                    $item->created_named_by = $item->creator->name ?? 'System';
                    $item->total_received_files = $item->total_received_files ?? 0;

                    return $item;
                });

            // return $registrations;
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

        $registerNo = base64_decode($registerId, true);
        if (!$registerNo) {
            return back()->with('error', 'Invalid register ID');
        }

        $register = RegistrationFile::where('register_no', $registerNo)->firstOrFail();
        $registerDivision = Division::where('id', $register->division_id)->value('name');
        $lotNumber = strtoupper($register->lot_no);
        $lotcreateDate = Carbon::parse($register->created_at)->format('d/m/Y');
        $lotTime = Carbon::parse($register->created_at)->format('h:i A');


        $allRecords = RegisterAllottee::query()
            ->orderBy('created_at', 'asc')
            ->select([
                'id',
                'register_id',
                'property_number',
                'confirm_received',
                'confirm_same_allottee_name',
                'no_of_supplement',
            ])
            ->get();


        $allottees = RegisterAllottee::query()
            ->from('register_allottees as ra')
            ->leftJoin('divisions as d', 'd.id', '=', 'ra.division_id')
            ->leftJoin('sub_divisions as sd', 'sd.id', '=', 'ra.sub_division_id')
            ->leftJoin('property_category as pc', 'pc.id', '=', 'ra.pcategory_id')
            ->leftJoin('property_type as pt', 'pt.id', '=', 'ra.p_type_id')
            ->leftJoin('quarter_type as qt', 'qt.quarter_id', '=', 'ra.quarter_type')
            ->where('ra.register_id', $registerNo)
            ->orderBy('ra.created_at', 'asc')
            ->select([
                'ra.id',
                'ra.property_number',
                'ra.prefix',
                'ra.allottee_name',
                'ra.allottee_middle_name',
                'ra.allottee_surname',
                'ra.confirm_received',
                'ra.confirm_same_allottee_name',
                'ra.no_of_files',
                'ra.no_of_supplement',
                'ra.remarks',
                'd.name as division_name',
                'sd.name as subdivision_name',
                'pc.name as category_name',
                'pt.name as type_name',
                'qt.quarter_code',
            ])
            ->get();

        if ($allottees->isEmpty()) {
            return back()->with('error', 'No records found');
        }

        $fileCounters = [];
        $fileMap = [];

        foreach ($allRecords as $record) {
            $propertyNumber = $record->property_number;

            if (!isset($fileCounters[$propertyNumber])) {
                $fileCounters[$propertyNumber] = 1;
            }
            // Calculate total files for this record
            $totalFiles = 0;

            if ($record->confirm_received === "No" && $record->confirm_same_allottee_name === "No") {
                $totalFiles = 1 + ($record->no_of_supplement ?? 0);
            } elseif ($record->confirm_received === "Yes" && $record->confirm_same_allottee_name === "Yes") {
                $totalFiles = ($record->no_of_supplement ?? 0);
            } elseif ($record->confirm_received === "Yes" && $record->confirm_same_allottee_name === "No") {
                $totalFiles = 1 + ($record->no_of_supplement ?? 0);
            }

            for ($i = 0; $i < $totalFiles; $i++) {
                $fileMap[$record->id][] = 'File ' . $fileCounters[$propertyNumber];
                $fileCounters[$propertyNumber]++;
            }
        }

        $processedRows = [];

        foreach ($allottees as $allottee) {
            $files = $fileMap[$allottee->id] ?? [];

            foreach ($files as $fileLabel) {
                $processedRows[] = [
                    'property_number' => $allottee->property_number ?? '',
                    'prefix' => $allottee->prefix ?? '',
                    'allottee_name' => $allottee->allottee_name ?? '',
                    'allottee_middle_name' => $allottee->allottee_middle_name ?? '',
                    'allottee_surname' => $allottee->allottee_surname ?? '',
                    'full_name' => trim(($allottee->prefix ?? '') . ' ' . ($allottee->allottee_name ?? '') . ' ' . ($allottee->allottee_middle_name ?? '') . ' ' . ($allottee->allottee_surname ?? '')),
                    'file_label' => $fileLabel,
                    'division' => $allottee->division_name ?? '',
                    'subdivision' => $allottee->subdivision_name ?? '',
                    'category' => $allottee->category_name ?? '',
                    'type' => $allottee->type_name ?? '',
                    'quarter_code' => $allottee->quarter_code ?? '',
                    'remarks' => $allottee->remarks ?? '',
                    'no_of_files' => $allottee->no_of_files ?? 0,
                    'no_of_supplement' => $allottee->no_of_supplement ?? 0,
                    'confirm_received' => $allottee->confirm_received ?? 'No',
                    'confirm_same_allottee_name' => $allottee->confirm_same_allottee_name ?? 'No',
                ];
            }
        }

        // If no processed rows (edge case), return error
        if (empty($processedRows)) {
            return back()->with('error', 'No file records to export');
        }

        $data = [
            'title' => 'COMPUTER Ed. - Files Receiving',
            'date' => date('d/m/Y'),
            'allottees' => $processedRows,
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

        // return $data;
        // ============================================================
        // ✅ STEP 6: GENERATE PDF
        // ============================================================
        $pdf = Pdf::loadView('exports.register-allottees', $data)
            ->setPaper('A4', 'portrait')
            ->setOption('defaultFont', 'dejavu sans');

        $todayDate = $this->generateRegisterNo();
        $smallcaseLots = strtolower($lotNumber);
        $filename = $smallcaseLots . '_' . $todayDate . '-ced-jshb-receiving.pdf';

        $directory = public_path("uploads/{$registerNo}/files");

        if (!File::exists($directory)) {
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

    public function CheckedLotsList(Request $request)
    {
        try {
            $registrations = RegistrationFile::query()
                ->with(['creator:id,name'])

                // Only scanned + subadmin approved lots
                ->where('status', 'scanned')
                // ->where('lots_subadmin_approved', 1)

                // Only include lots where at least one allottee is verified
                ->whereHas('registerAllottee', function ($q) {
                    $q->where('sub_admin_allottee_verify', 1);
                })

                ->withCount([
                    // Total allottee files in this lot
                    'registerAllottee as total_files',

                    // Verified files
                    'registerAllottee as verified_files_count' => function ($q) {
                        $q->where('sub_admin_allottee_verify', 1);
                    },
                ])

                ->latest('created_at')
                ->get()

                ->map(function ($item) {
                    $item->encoded_register_no = base64_encode($item->register_no);

                    $item->created_named_by = $item->creator?->name ?? 'System';

                    $item->current_stage = 'Verified';
                    $item->badge_color   = 'success';

                    return $item;
                });
            // return $registrations;
            return view(
                'admin.components.filereceiving.checklotsindex',
                compact('registrations')
            );
        } catch (\Throwable $e) {
            Log::error('Checked lots list failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()->with('error', 'Failed to load checked lots list.');
        }
    }

    public function checkedLotsFileList($encodedId, $page)
    {
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
                ->where('register_id', $registerNo)
                ->where('sub_admin_allottee_verify', 1);

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
            return view('admin.components.filereceiving.checklotsfileindex', compact('files', 'registerId', 'pageNo', 'Lots', 'registerNo'));
        } catch (\Throwable $e) {

            Log::error('File list failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to load file list.');
        }
    }

    public function revertLotsFileList($page = 1)
    {
        try {
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
                ->where('sub_admin_allottee_verify', 2);

            $registerAllottee = $query->paginate(50)->through(function ($item) {
                $item->allotteeId = encrypt($item->id);
                return $item;
            });
            // return $files;
            $files = $registerAllottee;
            $pageNo = $page;
            $revertfilecount = $files->count();
            return view('admin.components.filereceiving.revertlotsfileindex', compact('files', 'revertfilecount', 'pageNo'));
        } catch (\Throwable $e) {

            Log::error('File list failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to load file list.');
        }
    }

    public function dataentryLotsList(Request $request)
    {
        try {
            $registrations = RegistrationFile::query()
                ->with(['creator:id,name'])

                // Only scanned lots
                ->where('status', 'scanned')

                ->withCount([
                    'registerAllotteeDetails as total_register_files',

                    // Total verified files
                    'registerAllottee as total_verified_files' => function ($q) {
                        $q->where('sub_admin_allottee_verify', 1);
                    },

                    'registerAllottee as total_unverified_files' => function ($q) {
                        $q->where('sub_admin_allottee_verify', 0);
                    },

                    'registerAllottee as total_revert_files' => function ($q) {
                        $q->where('sub_admin_allottee_verify', 2);
                    },

                    'lotAssignments as total_assigned_files',

                    'lotAssignments as total_completed_files' => function ($q) {
                        $q->where('status', 'completed');
                    },

                    'lotAssignments as total_pending_files' => function ($q) {
                        $q->where('status', 'pending');
                    },

                    'lotAssignments as total_inprogress_files' => function ($q) {
                        $q->where('status', 'in_progress');
                    },
                ])

                // Show only those lots where at least one file is NOT verified yet
                ->whereHas('registerAllottee', function ($q) {
                    $q->where(function ($sub) {
                        $sub->whereNull('sub_admin_allottee_verify')
                            ->orWhere('sub_admin_allottee_verify', '!=', 1);
                    });
                })

                ->latest('created_at')
                ->get()

                ->map(function ($item) {
                    $item->remaining_verified_files = max(
                        0,
                        $item->total_register_files - $item->total_verified_files
                    );

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
        try {
            $registerNo = base64_decode($encodedId);

            $baseRelations = [
                'division',
                'subDivision',
                'propertyCategory',
                'propertyType',
                'quarterType',
            ];

            // ✅ Step 1: Get finalIds (optimized memory)
            $finalIds = RegisterAllottee::where('register_id', $registerNo)
                ->get()
                ->map(fn($item) => $item->grand_parent_id ?? $item->id)
                ->unique()
                ->values();

            // ✅ Step 2: Single query (normal + transfer files)
            $files = Allottee::query()
                ->with($baseRelations)
                ->where(function ($q) use ($finalIds, $registerNo) {
                    $q->whereIn('register_file_id', $finalIds)
                        ->orWhere(function ($q2) use ($registerNo) {
                            $q2->whereNull('register_file_id')
                                ->where('register_id', $registerNo);
                        });
                })
                ->where('sub_admin_allottee_verify', 0)
                ->paginate(50)
                ->through(function ($item) {
                    $item->allotteeId = encrypt($item->id);
                    return $item;
                });

            // ✅ Step 3: Register info (safe)
            $registers = RegistrationFile::where('register_no', $registerNo)->firstOrFail();
            $allVerified = 0;

            return view('admin.components.filereceiving.dataentryfileindex', [
                'files'      => $files,
                'registerId' => $registers->id,
                'pageNo'     => $page,
                'Lots'       => $registers->lot_no,
                'registerNo' => $registerNo,
                'allVerified' => $allVerified
            ]);
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
                'jointAllottees',
                'masterDocuments'
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

    public function markAsRead($id)
    {
        // return $id;
        try {
            $document = AllotteeDocument::findOrFail($id);
            if (auth('admin')->user()->role == 'approver' || auth('admin')->user()->role == 'divisional_admin') {
                $document->update(['is_divisional_read' => 1, 'divisional_read_date' => date('Y-m-d H:i:s')]);
            } else {
                $document->update(['is_sadmin_read' => 1, 'sadmin_read_date' => date('Y-m-d H:i:s')]);
            }

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Mark document as read failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json(['success' => false], 500);
        }
    }

    public function markMasterDocumentAsRead($id)
    {
        // return $id;
        try {
            $document = AllotteeMasterDocument::findOrFail($id);
            if (auth('admin')->user()->role == 'approver' || auth('admin')->user()->role == 'divisional_admin') {
                $document->update(['is_read_divisional' => 1]);
            } else {
                $document->update(['read_file' => 1]);
            }

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Mark document as read failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json(['success' => false], 500);
        }
    }

    public function approveMasterDocument($encryptedId)
    {
        // return $id;
        try {
            $id = decrypt($encryptedId);
            $document = AllotteeMasterDocument::findOrFail($id);
            $document->update(['is_checked' => 1]);

            return back()->with('success', 'Master document approved successfully.');
        } catch (\Throwable $e) {
            Log::error('Approve master document failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json(['success' => false], 500);
        }
    }

    public function approveDataEntry($encryptedId, Request $request)
    {
        // return $request;
        try {
            $id = decrypt($encryptedId);
            $file = Allottee::where('id', $id)->firstOrFail();
            $registerNo = $file->register_id;
            if ($request->status == 'reverted') {
                $file->update([
                    'sub_admin_allottee_verify' => 2,
                    'sub_admin_remarks' => $request->remarks,
                ]);

                return redirect()->route('admin.dataentry.files.index', ['encodedId' => base64_encode($file->register_id), 'page' => 1])
                    ->with('success', 'Data entry reverted successfully.');
            } else {
                if (auth('admin')->user()->role == 'approver' || auth('admin')->user()->role == 'divisional_admin') {
                    // 1. Approve current file
                    $file->update([
                        'divisional_approval'      => 1,
                        'divisional_remaks'        => null,
                        'divisional_approved_date' => date('Y-m-d H:i:s'),
                        'divisional_approved_by'   => auth('admin')->user()->id
                    ]);

                    // 2. Check remaining unapproved files
                    $remainingCount = Allottee::where('register_id', $registerNo)
                        ->where('sub_admin_allottee_verify', 1)
                        ->where('divisional_approval', 0)
                        ->count();

                    // 3. If last file → update lot
                    if ($remainingCount === 0) {
                        RegistrationFile::where('register_no', $registerNo)
                            ->update([
                                'status'              => 'handover',
                                'divisional_approval' => 1,
                                'divisional_approval_at' => date('Y-m-d H:i:s'),
                                'handover_by' => auth('admin')->user()->id,
                                'handover_at' => date('Y-m-d H:i:s'),
                            ]);
                        if (auth('admin')->user()->role == 'approver') {
                            return redirect()->route('approver.pending-lots')
                                ->with('success', 'Lot successfully marked as ready for handover.');
                        } else {
                            return redirect()->route('approver.admin.pending-lots')
                                ->with('success', 'Lot successfully marked as ready for handover.');
                        }
                    }
                    return redirect()->route('admin.pending.files.index', ['encodedId' => base64_encode($file->register_id), 'page' => 1])
                        ->with('success', 'Data entry approved successfully.');
                } else {
                    $file->update([
                        'sub_admin_allottee_verify' => 1,
                        'sub_admin_remarks' => $request->remarks ?? "checked",
                        'sub_admin_checked_date' => date('Y-m-d H:i:s'),
                    ]);
                    return redirect()->route('admin.dataentry.files.index', ['encodedId' => base64_encode($file->register_id), 'page' => 1])
                        ->with('success', 'Data entry approved successfully.');
                }
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

            Allottee::where('register_id', $registerNo)->where('is_step_completed', 1)->where('divisional_approval', 0)
                ->update([
                    'divisional_approval'      => 1,
                    'divisional_remaks'        => null,
                    'divisional_approved_date' => date('Y-m-d H:i:s'),
                    'divisional_approved_by'   => auth('admin')->user()->id
                ]);

            RegistrationFile::where('register_no', $registerNo)
                ->update([
                    'status'              => 'handover',
                    'divisional_approval' => 1,
                    'divisional_approval_at' => date('Y-m-d H:i:s'),
                    'handover_by' => auth('admin')->user()->id,
                    'handover_at' => date('Y-m-d H:i:s'),
                ]);
            return redirect()->route('approver.admin.pending-lots')
                ->with('success', "Lot successfully marked as ready for handover register no: {$registerNo}.");
        } catch (\Throwable $e) {
            Log::error('Bulk data entry approval failed', [
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to approve data entry for lots.');
        }
    }

    public function approveSelectedFile(Request $request)
    {
        $registerNo = base64_decode($request->encodedIdregister);

        $selectedIds = collect($request->selectedId)
            ->map(function ($id) {
                return base64_decode($id);
            })
            ->filter()
            ->toArray();

        if (empty($selectedIds)) {
            return back()->with('error', 'No records selected');
        }

        Allottee::whereIn('id', $selectedIds)
            ->update([
                'divisional_approval'      => 1,
                'divisional_remaks'        => null,
                'divisional_approved_date' => now(),
                'divisional_approved_by'   => auth('admin')->id(),
            ]);

        $remainingCount = Allottee::where('register_id', $registerNo)
            ->where('sub_admin_allottee_verify', 1)
            ->where('divisional_approval', 0)
            ->count();

        if ($remainingCount === 0) {

            RegistrationFile::where('register_no', $registerNo)
                ->update([
                    'status'                   => 'handover',
                    'divisional_approval'      => 1,
                    'divisional_approval_at'   => now(),
                    'handover_by'              => auth('admin')->id(),
                    'handover_at'              => now(),
                ]);

            return redirect()->route('approver.admin.pending-lots')
                ->with('success', 'All files approved. Lot ready for handover.');
        }
        return back()->with('success', 'Selected files approved successfully.');
    }

    public function fetchallottedetails($encryptedId)
    {
        $id = decrypt($encryptedId);
        $applicant = Allottee::where('id', $id)->firstOrFail();
        return view('admin.components.forms.editstep1', compact('applicant'));
    }

    public function readyforhandover(Request $request)
    {
        try {
            $user       = auth('admin')->user();
            $divisionId = $user->division_id;
            $registrations = RegistrationFile::query()
                ->with(['approvedBy:id,admin_name'])
                ->with(['creator:id,name'])
                ->with(['scannedBy:id,name'])

                // Only scanned + subadmin approved lots
                ->where('status', 'handover')
                ->withCount([
                    // Total allottee files in this lot
                    'registerAllottee as total_files',

                    // Verified files
                    'registerAllottee as verified_files_count' => function ($q) {
                        $q->where('divisional_approval', 1);
                    },
                ])

                ->latest('created_at')
                ->get()

                ->map(function ($item) {
                    $item->encoded_register_no = base64_encode($item->register_no);

                    $item->approved_named_by = $item->approvedBy?->admin_name ?? 'System';
                    $item->recivied_named_by = $item->creator?->name ?? 'System';
                    $item->scanned_named_by = $item->scannedBy?->name ?? 'System';

                    $item->current_stage = 'Handover';
                    $item->badge_color   = 'success';

                    return $item;
                });
            $approvedfilecount = $registrations->count();
            return view(
                'admin.components.handover.readyhandoverLotindex',
                compact('registrations', 'approvedfilecount')
            );
        } catch (\Throwable $e) {
            Log::error('Checked lots list failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()->with('error', 'Failed to load checked lots list.');
        }
    }

    public function readyforhandoverindexfiles($encodedId, $page)
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
            $files = Allottee::query()

                ->with($relationWith)
                ->where('register_id', $Id)

                ->latest()
                ->paginate(50)
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
            return view('admin.components.handover.handoverfilesindex', compact('files', 'registerId', 'pageNo', 'Lots', 'registerNo'));
        } catch (\Throwable $e) {

            Log::error('File list failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to load file list.');
        }
    }

    public function handoverfilesExports($registerId)
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
        $lotcreateDate = Carbon::parse($register->handover_at)->format('d/m/Y');
        $lotTime = Carbon::parse($register->handover_at)->format('h:i A');
        $allottees = Allottee::query()
            ->from('allottees as ra')
            ->leftJoin('divisions as d', 'd.id', '=', 'ra.division_id')
            ->leftJoin('sub_divisions as sd', 'sd.id', '=', 'ra.subdivision_id')
            ->leftJoin('property_category as pc', 'pc.id', '=', 'ra.pcategory_id')
            ->leftJoin('property_type as pt', 'pt.id', '=', 'ra.property_type_id')
            ->leftJoin('quarter_type as qt', 'qt.quarter_id', '=', 'ra.quarter_id')
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
            'title' => 'COMPUTER Ed. - Files Handover',
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

        $pdf = Pdf::loadView('exports.handover-allottees', $data)
            ->setPaper('A4', 'portrait')
            ->setOption('defaultFont', 'dejavu sans');

        $todayDate = $this->generateRegisterNo();
        $smallcaseLots = strtolower($lotNumber);
        $filename = $smallcaseLots . '_' . $todayDate . '-ced-jshb-handover.pdf';

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
