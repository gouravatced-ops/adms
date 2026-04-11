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

class ApproverController extends Controller
{
    public function approverPendingLots(Request $request)
    {
        try {
            $user       = auth('admin')->user();
            $divisionId = $user->division_id;
            $registrations = RegistrationFile::query()
                ->with(['creator:id,name'])

                // Only scanned + subadmin approved lots
                ->where('status', 'scanned')

                // Only include lots where at least one allottee is verified
                ->whereHas('registerAllottee', function ($q) {
                    $q->where('sub_admin_allottee_verify', 1);
                })

                ->whereHas('registerAllottee', function ($q) use ($divisionId) {
                    $q->where('division_id', $divisionId);
                })

                ->withCount([
                    // Total allottee files in this lot
                    'registerAllottee as total_files',

                    // Verified files
                    'registerAllottee as verified_files_count' => function ($q) {
                        $q->where('sub_admin_allottee_verify', 1);
                    },

                    // Verified files count by approval role
                    'registerAllottee as approved_files_count' => function ($q) {
                        $q->where('divisional_approval', 1);
                    },

                    // Verified files
                    'registerAllottee as unapproved_files_count' => function ($q) {
                        $q->where('divisional_approval', 0);
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
            $pendingfilecount = $registrations->count();
            // return $registrations;
            return view(
                'admin.components.approver.pendingApprovalLots',
                compact('registrations', 'pendingfilecount')
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

    public function approverPendingFiles($encodedId, $page)
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
                ->where('sub_admin_allottee_verify', 1)
                ->where('divisional_approval', 0);

            // return $query->get();

            $registerAllottee = $query->paginate(50)->through(function ($item) {
                $item->allotteeId = encrypt($item->id);
                return $item;
            });
            // return $files;
            $files = $registerAllottee;
            $pageNo = $page;

            // If all rows have divisional_approval == 1 then 1 else 0
            $allVerified = $query->where('divisional_approval', '!=', 1)->exists() ? 0 : 1;

            $registers  = RegistrationFile::where('register_no', $registerNo)->first();
            $registerId = $registers->id;
            $Lots = $registers->lot_no;
            return view('admin.components.approver.pendingApprovalfileindex', compact('files', 'registerId', 'pageNo', 'Lots', 'registerNo', 'allVerified'));
        } catch (\Throwable $e) {

            Log::error('File list failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to load file list.');
        }
    }

    public function approverApprovedLots(Request $request)
    {
        try {
            $user       = auth('admin')->user();
            $divisionId = $user->division_id;
            $registrations = RegistrationFile::query()
                ->with(['creator:id,name'])

                // Only scanned + subadmin approved lots
                ->where('status', 'scanned')

                // Only include lots where at least one allottee is verified
                ->whereHas('registerAllottee', function ($q) {
                    $q->where('divisional_approval', 1);
                })

                ->whereHas('registerAllottee', function ($q) use ($divisionId) {
                    $q->where('division_id', $divisionId);
                })

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

                    $item->created_named_by = $item->creator?->name ?? 'System';

                    $item->current_stage = 'Verified';
                    $item->badge_color   = 'success';

                    return $item;
                });
            $approvedfilecount = $registrations->count();
            // return $registrations;
            return view(
                'admin.components.approver.approvedLotsindex',
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

    public function approverApprovedLotFiles($encodedId, $page)
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
                ->where('divisional_approval', 1);

            // return $query->get();

            $registerAllottee = $query->paginate(50)->through(function ($item) {
                $item->allotteeId = encrypt($item->id);
                return $item;
            });
            // return $files;
            $files = $registerAllottee;
            $pageNo = $page;

            // If all rows have divisional_approval == 1 then 1 else 0
            $allVerified = $query->where('divisional_approval', '!=', 1)->exists() ? 0 : 1;

            $registers  = RegistrationFile::where('register_no', $registerNo)->first();
            $registerId = $registers->id;
            $Lots = $registers->lot_no;
            return view('admin.components.approver.approvedLotfileindex', compact('files', 'registerId', 'pageNo', 'Lots', 'registerNo', 'allVerified'));
        } catch (\Throwable $e) {

            Log::error('File list failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to load file list.');
        }
    }
}
