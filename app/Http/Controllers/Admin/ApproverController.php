<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterAllottee;
use App\Models\RegistrationFile;
use App\Models\SubDivision;
use App\Models\PropertyType;
use App\Models\PropertyCategory;
use App\Models\PropertyMainType;
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

            $divisionId = auth('admin')->user()->division_id;
            $registrations = RegistrationFile::query()
                ->with(['creator:id,name'])
                ->where('status', 'scanned')
                ->whereHas('registerAllottee', function ($q) use ($divisionId) {
                    $q->where('division_id', $divisionId)
                        ->whereHas('allotteeMasterDocuments', function ($doc) {
                            $doc->where('is_checked', 1);
                        });
                })

                ->withCount([
                    'registerAllottee as total_files',
                    'registerAllottee as verified_files_count' => function ($q) {
                        $q->whereHas('allotteeMasterDocuments', function ($doc) {
                            $doc->where('is_checked', 1);
                        });
                    },

                    'registerAllottee as approved_files_count' => function ($q) {
                        $q->whereHas('allotteeMasterDocuments', function ($doc) {

                            $doc->where('is_approved_divisional', 1);
                        });
                    },
                    'registerAllottee as unapproved_files_count' => function ($q) {
                        $q->whereHas('allotteeMasterDocuments', function ($doc) {

                            $doc->where(function ($sub) {

                                $sub->whereNull('is_approved_divisional')
                                    ->orWhere('is_approved_divisional', '!=', 1);
                            });
                        });
                    },
                ])

                ->latest('id')
                ->get()
                ->map(function ($item) {
                    $item->encoded_register_no = base64_encode($item->register_no);
                    $item->created_named_by = $item->creator?->name ?? 'System';
                    $item->current_stage = 'Verified';
                    $item->badge_color = 'success';
                    return $item;
                });

            $pendingfilecount = $registrations->count();

            return view('admin.components.approver.pendingApprovalLots', compact('registrations', 'pendingfilecount'));
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
            $registers = RegistrationFile::where('register_no', $registerNo)->first();
            if (!$registers) {
                return back()->with('error', 'Registration file not found.');
            }

            // Get filter data for dropdowns using helper functions
            $subDivisions = getSubDivisions($registers->division_id);
            $propertyCategories = getPropertyCategory();
            $propertyTypes = PropertyType::all();
            $propertySubCategories = PropertyMainType::all();

            $baseRelations = [
                'division',
                'subDivision',
                'propertyCategory',
                'propertyType',
                'quarterType',
                'parent'
            ];

            $query = Allottee::query()
                ->with($baseRelations)
                ->where('register_id', $registerNo)
                ->where('sub_admin_allottee_verify', 1)
                ->where('divisional_approval', 0);

            $registerAllottee = $query->paginate(50, ['*'], 'page', $page)->through(function ($item) {
                $item->allotteeId = encrypt($item->id);
                $item->encodedId = base64_encode($item->id);
                return $item;
            });

            $files = $registerAllottee;
            $pageNo = $page;

            $allVerified = $query->where('divisional_approval', '!=', 1)->exists() ? 0 : 1;

            $registerId = $registers->id;
            $Lots = $registers->lot_no;
            $encodedId = $encodedId;

            return view('admin.components.approver.pendingApprovalfileindex', compact(
                'files',
                'registerId',
                'pageNo',
                'Lots',
                'registerNo',
                'allVerified',
                'subDivisions',
                'propertyTypes',
                'propertyCategories',
                'propertySubCategories',
                'encodedId'
            ));
        } catch (\Throwable $e) {
            Log::error('File list failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to load file list.');
        }
    }

    public function searchPendingFiles(Request $request)
    {
        try {
            $page = $request->page ?? 1;
            $registerNo = $request->register_no;

            $baseRelations = [
                'division',
                'subDivision',
                'propertyCategory',
                'propertyType',
                'quarterType',
                'parent'
            ];

            $query = Allottee::query()
                ->with($baseRelations)
                ->where('register_id', $registerNo)
                ->where('sub_admin_allottee_verify', 1)
                ->where('divisional_approval', 0);

            // Apply filters
            if (!empty($request->name)) {
                $query->where(function ($q) use ($request) {
                    $q->where('allottee_name', 'LIKE', '%' . $request->name . '%')
                        ->orWhere('allottee_middle_name', 'LIKE', '%' . $request->name . '%')
                        ->orWhere('allottee_surname', 'LIKE', '%' . $request->name . '%')
                        ->orWhereRaw("CONCAT(COALESCE(prefix,''), ' ', COALESCE(allottee_name,''), ' ', COALESCE(allottee_middle_name,''), ' ', COALESCE(allottee_surname,'')) LIKE ?", ['%' . $request->name . '%']);
                });
            }

            if (!empty($request->property_no)) {
                $query->where('property_number', 'LIKE', '%' . $request->property_no . '%');
            }

            if (!empty($request->sub_division)) {
                $query->where('subdivision_id', $request->sub_division);
            }

            if (!empty($request->property_type)) {
                $query->where('property_type_id', $request->property_type);
            }

            if (!empty($request->property_category)) {
                $query->where('pcategory_id', $request->property_category);
            }

            if (!empty($request->property_sub_category)) {
                $query->where('property_subtype_id', $request->property_sub_category);
            }

            $files = $query->paginate(50, ['*'], 'page', $page);

            $files->through(function ($item) {
                $item->allotteeId = encrypt($item->id);
                $item->encodedId = base64_encode($item->id);
                return $item;
            });

            if ($request->ajax()) {
                $html = view('admin.components.approver.partials.pending_files_table', compact('files'))->render();

                return response()->json([
                    'success' => true,
                    'html' => $html,
                    'has_more' => $files->hasMorePages(),
                    'current_page' => $files->currentPage(),
                    'last_page' => $files->lastPage()
                ]);
            }

            return back();
        } catch (\Throwable $e) {
            Log::error('Search failed', ['error' => $e->getMessage()]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to search files.'
                ], 500);
            }

            return back()->with('error', 'Failed to search files.');
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

    public function handoverLotsFiles(Request $request)
    {
        try {
            $user       = auth('admin')->user();
            $divisionId = $user->division_id;
            $registrations = RegistrationFile::query()
                ->with(['approvedBy:id,admin_name'])

                // Only scanned + subadmin approved lots
                ->where('status', 'handover')
                ->where('division_id', $divisionId)
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

                    $item->current_stage = 'Handover';
                    $item->badge_color   = 'success';

                    return $item;
                });
            $approvedfilecount = $registrations->count();
            // return $registrations;
            return view(
                'admin.components.approver.handoverLotindex',
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

    public function handoverAllLotsFiles(Request $request)
    {
        try {
            $user       = auth('admin')->user();
            $divisionId = $user->division_id;
            $registrations = RegistrationFile::query()
                ->with(['approvedBy:id,admin_name'])

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

                    $item->current_stage = 'Handover';
                    $item->badge_color   = 'success';

                    return $item;
                });
            $approvedfilecount = $registrations->count();
            // return $registrations;
            return view(
                'admin.components.approver.handoverLotindex',
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

    public function approverPendingAllLots(Request $request)
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
                'admin.components.approver.allpendingApprovalLots',
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

    public function approverApprovedAllLots(Request $request)
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
                'admin.components.approver.allapprovedLotsindex',
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
}
