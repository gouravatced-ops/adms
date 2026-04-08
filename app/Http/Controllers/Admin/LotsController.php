<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterAllottee;
use App\Models\RegistrationFile;
use App\Models\LotAssignment;
use App\Models\LotAssignmentLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class LotsController extends Controller
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
    public function receivingIndex(Request $request)
    {
        try {
            $registrations = RegistrationFile::with('creator')
                ->whereHas('allottees', function ($q) {
                    $q->where('allottee_status', 'received');
                })
                ->latest()
                ->paginate(25)
                ->through(function ($item) {

                    $item->encoded_register_no = base64_encode($item->register_no);

                    // cleaner null-safe access
                    $item->created_by_name = $item->creator->name ?? 'N/A';

                    return $item;
                });

            return view('admin.components.filereceiving.index', compact('registrations'));
        } catch (\Throwable $e) {

            Log::error('Registration index failed', [
                'error' => $e->getMessage(),
                'user_id' => $this->id
            ]);

            return back()->with('error', 'Failed to load registrations.');
        }
    }

    public function registerLotsList(Request $request)
    {
        try {
            $registrations = RegistrationFile::query()
                ->with(['scannedBy:id,name'])
                ->withCount([
                    'allottees as total_files',
                    'lotAssignments as total_assigned_files' => function ($q) {
                        $q->whereNotNull('allottee_id');
                    },

                    'lotAssignments as full_lot_assigned_count' => function ($q) {
                        $q->where('assignment_type', 'full_lot');
                    },

                    'lotAssignments as total_completed' => function ($q) {
                        $q->where('status', 'completed');
                    },
                ])
                ->where('status', 'scanned')
                ->latest()
                ->paginate(25)
                ->through(function ($item) {
                    $item->encoded_register_no = base64_encode($item->register_no);
                    $item->scanned_named_by = $item->scannedBy->name ?? 'System';

                    $item->remaining_files = max(
                        0,
                        $item->total_files - $item->total_assigned_files
                    );

                    $item->is_partial_assigned = $item->total_assigned_files > 0;
                    $item->assignment_status = match (true) {
                        ($item->full_lot_assigned_count ?? 0) > 0 => 'full_lot',
                        ($item->total_assigned_files ?? 0) == 0 => 'not_assigned',
                        ($item->remaining_files ?? 0) == 0 => 'fully_assigned',
                        default => 'partially_assigned',
                    };

                    return $item;
                });
            // return $registrations;
            $users = getUsers();

            return view('admin.components.lots.index', compact('registrations', 'users'));
        } catch (\Throwable $e) {
            Log::error('Register list failed', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ]);

            return back()->with('error', 'Failed to load register list.');
        }
    }

    public function registerLotsFileList($encodedId, $page)
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
                'scannedBy'
            ];
            $files = RegisterAllottee::query()

                ->with($relationWith)

                ->where('allottee_status', 'scanned')
                ->where('register_id', $Id)

                ->whereDoesntHave('lotAssignments', function ($q) {
                    $q->where('assignment_type', 'partial');
                })

                ->latest()
                ->paginate(25)
                ->through(function ($item) {

                    $item->register_no = $item->registration->register_no ?? '';
                    $item->lot_no = $item->registration->lot_no ?? '';
                    $item->scanned_named_by = $item->scannedBy->name ?? "System";

                    return $item;
                });
            // return $files;
            $pageNo = $page;
            $registers  = RegistrationFile::where('register_no', $Id)->first();
            $registerId = $registers->id;
            $Lots = $registers->lot_no;
            $registerNo  = $Id;
            $users = getUsers();
            return view('admin.components.lots.file-list', compact('files', 'users', 'registerId', 'pageNo', 'Lots', 'registerNo'));
        } catch (\Throwable $e) {

            Log::error('File list failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to load file list.');
        }
    }

    public function assignStore(Request $request)
    {
        $request->validate([
            'lot_id'       => 'required|exists:file_registrations,id',
            'assigned_to'  => 'required|exists:users,id',
        ]);

        try {
            $assignedBy = auth()->id();
            $now = now();
            $registerNo = RegistrationFile::where('id', $request->lot_id)->value('register_no');
            $allotteeIds = RegisterAllottee::query()
                ->where('register_id', $registerNo)
                ->where('allottee_status', 'scanned')
                ->where('is_active', 1)
                ->pluck('id');

            if ($allotteeIds->isEmpty()) {
                return back()->with('error', 'No scanned files found for this lot.');
            }

            $alreadyAssignedIds = LotAssignment::query()
                ->where('lot_id', $request->lot_id)
                ->whereIn('allottee_id', $allotteeIds)
                ->pluck('allottee_id')
                ->toArray();

            $newAllotteeIds = $allotteeIds
                ->reject(fn($id) => in_array($id, $alreadyAssignedIds))
                ->values();

            if ($newAllotteeIds->isEmpty()) {
                return back()->with('error', 'All files of this lot are already assigned.');
            }

            foreach ($newAllotteeIds as $allotteeId) {
                $assignment = LotAssignment::create([
                    'lot_id'          => $request->lot_id,
                    'allottee_id'     => $allotteeId,
                    'assigned_to'     => $request->assigned_to,
                    'assigned_by'     => $assignedBy,
                    'assignment_type' => 'full_lot',
                    'status'          => 'pending',
                    'assigned_at'     => $now,
                ]);

                LotAssignmentLog::create([
                    'assignment_id' => $assignment->id,
                    'action'        => 'assigned',
                    'user_id'       => $assignedBy,
                    'created_at'    => $now,
                ]);
            }

            return back()->with('success', 'Full lot assigned successfully!');
        } catch (\Throwable $e) {
            Log::error('Full lot assign failed', [
                'lot_id'      => $request->lot_id,
                'assigned_to' => $request->assigned_to,
                'error'       => $e->getMessage(),
                'line'        => $e->getLine(),
                'file'        => $e->getFile(),
            ]);

            return back()->with('error', 'Failed to assign full lot.');
        }
    }

    public function assignedUserList($encodedId)
    {
        try {

            $lotId = base64_decode($encodedId);

            if (!$lotId) {
                return back()->with('error', 'Invalid lot reference.');
            }

            $assignedUsers = LotAssignment::query()
                ->from('lot_assignments as la')
                ->join('users as u', 'u.id', '=', 'la.assigned_to')
                ->where('la.lot_id', $lotId)

                ->select([
                    'la.assigned_to',
                    'u.name',
                    'u.email_id as uemail',
                    DB::raw('COUNT(la.allottee_id) as total_assigned_files'),
                    DB::raw("SUM(CASE WHEN la.status='completed' THEN 1 ELSE 0 END) as completed_files"),
                    DB::raw("SUM(CASE WHEN la.status!='completed' THEN 1 ELSE 0 END) as pending_files"),
                    DB::raw("MAX(la.assignment_type) as assignment_type"),
                    DB::raw("MIN(la.assigned_at) as assigned_at")
                ])

                ->groupBy('la.assigned_to', 'u.name', 'uemail')
                ->orderBy('assigned_at', 'desc')
                ->get();

            return view(
                'admin.components.lots.assigned-users',
                compact('assignedUsers', 'lotId')
            );
        } catch (\Throwable $e) {

            Log::error('Assigned user list failed', [
                'encodedId' => $encodedId,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to load assigned users.');
        }
    }

    public function assignedFilesStatus(string $encodedId)
    {
        try {
            $lotId = base64_decode($encodedId, true);

            if (!$lotId || !is_numeric($lotId)) {
                return back()->with('error', 'Invalid lot reference.');
            }

            $assignedfiles = LotAssignment::query()
                ->with([
                    'assignedUser:id,name',
                    'registerallottee',
                    'assigner:id,admin_name',
                ])
                ->where('lot_id', (int) $lotId)
                ->latest()
                ->get();
            // return $assignedfiles;
            return view(
                'admin.components.lots.assigned-files-status',
                compact('assignedfiles', 'lotId')
            );
        } catch (\Throwable $e) {
            Log::error('Assigned files status load failed', [
                'encoded_id' => $encodedId,
                'lot_id'     => $lotId ?? null,
                'message'    => $e->getMessage(),
                'file'       => $e->getFile(),
                'line'       => $e->getLine(),
            ]);

            return back()->with('error', 'Failed to load assigned files status.');
        }
    }

    public function assignPartialFiles(Request $request)
    {
        // return $request;
        $request->validate([
            'file_ids'    => 'required',
            'lots_id'      => 'required',
            'assigned_to' => 'required',
        ]);
        // return [1];
        $assignedBy = $this->id;

        $fileIds = collect(explode(',', $request->file_ids))
            ->map(fn($id) => (int) trim($id))
            ->filter()
            ->unique()
            ->values();

        if ($fileIds->isEmpty()) {
            return back()->with('error', 'No valid files selected.');
        }

        $now = now();

        DB::beginTransaction();

        try {

            $existingFileIds = LotAssignment::where('lot_id', $request->lots_id)
                ->whereIn('allottee_id', $fileIds)
                ->pluck('allottee_id')
                ->toArray();

            $newFileIds = $fileIds->diff($existingFileIds);

            if ($newFileIds->isEmpty()) {
                return back()->with('error', 'All selected files are already assigned.');
            }

            // return $request->lots_id;
            foreach ($newFileIds as $fileId) {
                $assignment = LotAssignment::create([
                    'lot_id'          => $request->lots_id,
                    'allottee_id'     => $fileId,
                    'assigned_to'     => $request->assigned_to,
                    'assigned_by'     => $assignedBy,
                    'assignment_type' => 'partial',
                    'status'          => 'pending',
                    'assigned_at'     => $now,
                ]);

                LotAssignmentLog::create([
                    'assignment_id' => $assignment->id,
                    'action'        => 'assigned',
                    'user_id'       => $assignedBy,
                    'created_at'    => $now,
                ]);
            }

            DB::commit();

            return back()->with('success', 'Files assigned successfully!');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Partial assignment failed', [
                'error' => $e->getMessage(),
                'file_ids' => $fileIds,
                'lot_id' => $request->lots_id,
                'assigned_to' => $request->assigned_to,
            ]);

            return back()->with('error', 'Failed to assign files.');
        }
    }
}
