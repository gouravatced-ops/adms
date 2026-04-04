@extends('admin.layouts.main')

@section('admin-content')
    <style>
        .status-completed {
            display: inline-block;
            width: 18px;
            height: 18px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 18px;
            font-size: 14px;
            margin-left: 5px;
        }

        .status-pending {
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
            border-radius: 50%;
            background: #ffc107;
            color: #212529;
            font-size: 12px;
            font-weight: 600;
        }

        .status-rejected {
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
            border-radius: 50%;
            background: #dc3545;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Data Entry Files List / {{ $Lots }} :
                {{ $registerNo }}</span>
        </h6>

        <div class="card mb-4">
            <div class="card-header bg-warning d-flex justify-content-between align-items-center">
                <h5 class="text-white mb-0">Lot Data Entry Files</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                        data-bs-target="#verifyAllLotsModal">
                        <i class="bx bx-check-shield me-1"></i>
                        Verify & Approve Lots
                    </button>
                    &nbsp;
                    <button type="button" class="btn btn-light btn-sm">
                        <a href="{{ route('admin.dataentry.lots.index') }}" class="text-decoration-none text-dark">
                            ← Back
                        </a>
                    </button>
                </div>
            </div>

            {{-- Place outside table / near bottom of page --}}
            <div class="modal fade" id="verifyAllLotsModal" tabindex="-1" aria-labelledby="verifyAllLotsModalLabel"
                aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <form
                            action="{{ route('admin.lots.dataentry.lots.approve', ['registerId' => base64_encode($registerNo)]) }}"
                            method="POST">
                            @csrf

                            <div class="modal-header bg-dark text-white" style="padding:10px !important;">
                                <h5 class="modal-title text-white" id="verifyAllLotsModalLabel">
                                    Verify & Approve All Lots
                                </h5>

                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3 p-3 border rounded bg-light">
                                    <div class="small text-muted mb-1">Register No</div>
                                    <div class="fw-semibold">{{ $Lots }}: {{ $registerNo }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Remarks
                                        <small class="text-muted">(Optional)</small>
                                    </label>

                                    <textarea name="remarks" rows="4" class="form-control" placeholder="Enter verification remarks..."></textarea>
                                </div>

                                <input type="hidden" name="status" value="verified">
                            </div>
                            <hr style="margin:0;">
                            <div class="modal-footer" style="padding:10px !important;">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-dark">
                                    <i class="bx bx-check-circle me-1"></i>
                                    Verify & Approve Lots
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body mt-0 p-3">
                {{-- Alerts --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        {{ session('success') }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        {{ session('error') }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="allLotsListTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sl. no.</th>
                                <th>Allottee & Property</th>
                                <th>Division Details</th>
                                <th>Property Details</th>
                                <th>Remarks</th>
                                <th>Dates</th>
                                <th>Action</th> <!-- Edit file -->
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($files as $key => $item)
                                @php
                                    // Parse JSON pages data if exists
                                    $pagesData = json_decode($item->json_pages, true);
                                    $totalPages = $item->total_pages ?? 0;
                                    $fileCount = $item->no_of_files ?? 1;

                                    // Format property details
                                    $propertyType = $item->property_type->name ?? 'Plot';
                                    $quarterInfo = $item->quarter_type->quarter_code ?? 'MIG';

                                    // Format allottee name
                                    $allotteeName = trim(
                                        ($item->prefix ?? '') .
                                            ' ' .
                                            ($item->allottee_name ?? '') .
                                            ' ' .
                                            ($item->allottee_middle_name ?? '') .
                                            ' ' .
                                            ($item->allottee_surname ?? ''),
                                    );
                                @endphp
                                <tr class="{{ $item->highlighted ? 'table-warning' : '' }}"
                                    data-row-id="{{ $item->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @php
                                            // Current allottee position for same property
                                            $allotteePosition = \App\Models\Allottee::where(
                                                'property_number',
                                                $item->property_number,
                                            )
                                                ->where(function ($q) use ($item) {
                                                    $q->where('id', $item->id)
                                                        ->orWhere('parent_id', $item->parent_id)
                                                        ->orWhere('id', $item->parent_id);
                                                })
                                                ->orderBy('id')
                                                ->pluck('id')
                                                ->search($item->id);

                                            $position = $allotteePosition !== false ? $allotteePosition + 1 : null;

                                            $originalAllottee = trim(
                                                ($item->parent->prefix ?? '') .
                                                    ' ' .
                                                    ($item->parent->allottee_name ?? '') .
                                                    ' ' .
                                                    ($item->parent->allottee_middle_name ?? '') .
                                                    ' ' .
                                                    ($item->parent->allottee_surname ?? ''),
                                            );
                                        @endphp

                                        @php
                                            $badges = [];

                                            $isTransferFile = !is_null($item->parent_id);
                                            $maxStep = $isTransferFile ? 4 : 6;

                                            // Original allottee for transfer files
                                            if ($isTransferFile && $item->parent) {
                                                $originalAllottee = trim(
                                                    ($item->parent->prefix ?? '') .
                                                        ' ' .
                                                        ($item->parent->allottee_name ?? '') .
                                                        ' ' .
                                                        ($item->parent->allottee_middle_name ?? '') .
                                                        ' ' .
                                                        ($item->parent->allottee_surname ?? ''),
                                                );

                                                if ($originalAllottee) {
                                                    $badges[] = [
                                                        'text' => 'Previous: ' . $originalAllottee,
                                                        'class' => 'bg-warning text-dark border',
                                                    ];
                                                }
                                            }

                                            // Main status
                                            if (blank($item->allottee_document_path)) {
                                                $badges[] = [
                                                    'text' => 'Document Not Uploaded',
                                                    'class' => 'bg-dark',
                                                ];
                                            }

                                            if (
                                                (int) ($item->current_step ?? 0) >= $maxStep &&
                                                (int) ($item->is_step_completed ?? 0) === 1
                                            ) {
                                                $badges[] = [
                                                    'text' => 'Completed',
                                                    'class' => 'bg-success',
                                                ];
                                            } else {
                                                $badges[] = [
                                                    'text' => 'Incomplete',
                                                    'class' => 'bg-danger',
                                                ];

                                                $badges[] = [
                                                    'text' => 'Step ' . ($item->current_step ?? 0) . '/' . $maxStep,
                                                    'class' => 'bg-secondary',
                                                ];
                                            }

                                            // EMI status
                                            if (!empty($item->is_emi_active) && $item->is_emi_active == 'true') {
                                                $badges[] = [
                                                    'text' => 'Active EMI',
                                                    'class' => 'bg-info text-white',
                                                ];
                                            }

                                            // Name transfer
                                            if (strtolower($item->name_transfer_status ?? '') === 'yes') {
                                                $badges[] = [
                                                    'text' => 'Name Transfer',
                                                    'class' => 'bg-danger',
                                                ];

                                                if ((int) ($item->is_trans_entry_completed ?? 0) === 0) {
                                                    $badges[] = [
                                                        'text' => 'Transfer Incomplete',
                                                        'class' => 'bg-warning text-dark',
                                                    ];
                                                }
                                            }

                                            // Free hold
                                            if (strtolower($item->free_hold_status ?? '') === 'yes') {
                                                $badges[] = [
                                                    'text' => 'Lease Free Hold',
                                                    'class' => 'bg-success',
                                                ];

                                                if ((int) ($item->is_free_hold_completed ?? 0) === 0) {
                                                    $badges[] = [
                                                        'text' => 'Free Hold Incomplete',
                                                        'class' => 'bg-warning text-dark',
                                                    ];
                                                }
                                            }

                                            if ($position) {
                                                $badges[] = [
                                                    'text' =>
                                                        $position .
                                                        ($position == 1
                                                            ? 'st'
                                                            : ($position == 2
                                                                ? 'nd'
                                                                : ($position == 3
                                                                    ? 'rd'
                                                                    : 'th'))) .
                                                        ' Allottee',
                                                    'class' => 'bg-primary',
                                                ];
                                            }
                                        @endphp
                                        <div class="fw-semibold">{{ $allotteeName ?: 'N/A' }}
                                            @if ($item->sub_admin_allottee_verify == 1)
                                                <span class="status-completed">✓</span>
                                            @elseif($item->sub_admin_allottee_verify == 0)
                                                <span class="status-pending" title="Sub Admin Pending"><i
                                                        class="bx bx-hourglass bx-tada" style="font-size: 10px;"></i></span>
                                            @elseif($item->sub_admin_allottee_verify === 2)
                                                <span class="status-rejected" title="Sub Admin Rejected">✗</span>
                                                Remark: <span
                                                    class="small text-danger">{{ $item->sub_admin_remarks ?? 'No remarks provided' }}</span>
                                            @endif
                                        </div>
                                        <small class="text-muted d-block">Property No:
                                            {{ $item->property_number ?? 'C-52' }}</small>
                                        <small class="text-muted d-block">No. of Files: {{ $fileCount }}</small>
                                        <small class="text-muted d-block">Total Pages: {{ $totalPages }}</small>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach ($badges as $badge)
                                                <span class="badge {{ $badge['class'] }}">
                                                    {{ $badge['text'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $item->division->name ?? 'Ranchi Division' }}</div>
                                        <small class="text-muted d-block">Sub Division:
                                            {{ $item->sub_division->name ?? 'Harnu-Ranchi' }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $item->property_category->name ?? 'Residential' }} – Plot</div>
                                        <small class="text-muted d-block">Quarter: {{ $quarterInfo }}</small>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-warning text-dark">{{ $item->remarks ?? 'Partial Fresh and Old Pages' }}</span>
                                    </td>
                                    <td>
                                        {{ formatDateTime($item->updated_at ?? now()) }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">

                                            {{-- Preview --}}
                                            <a href="{{ route('admin.file.preview', encrypt($item->id)) }}"
                                                class="btn btn-sm btn-primary text-white"
                                                title="Preview {{ $allotteeName }} File" data-bs-toggle="tooltip">

                                                {{-- File Preview SVG --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                    </path>
                                                    <path d="M14 2v6h6"></path>
                                                    <path d="M9 14h6"></path>
                                                    <path d="M9 18h4"></path>
                                                </svg>
                                            </a>

                                            {{-- Approve --}}
                                            @if ($item->allottee_verify == 0)
                                                <a href="javascript:void(0)" class="btn btn-sm btn-success"
                                                    title="Approve File" data-bs-toggle="modal"
                                                    data-bs-target="#approveModal{{ $item->id }}">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M9 12l2 2 4-4"></path>
                                                        <path
                                                            d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            @endif

                                            {{-- Revert --}}
                                            <a href="javascript:void(0)" class="btn btn-sm btn-danger"
                                                title="Revert File" data-bs-toggle="modal"
                                                data-bs-target="#revertModal{{ $item->id }}">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M3 7v6h6"></path>
                                                    <path d="M3 13a9 9 0 1 0 3-7.7L3 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No Lots Found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Place after table / outside .table-responsive --}}
                    @foreach ($files as $item)
                        @php
                            // Format allottee name
                            $allotteeName = trim(
                                ($item->prefix ?? '') .
                                    ' ' .
                                    ($item->allottee_name ?? '') .
                                    ' ' .
                                    ($item->allottee_middle_name ?? '') .
                                    ' ' .
                                    ($item->allottee_surname ?? ''),
                            );
                        @endphp
                        {{-- Approve Modal --}}
                        <div class="modal fade" id="approveModal{{ $item->id }}" tabindex="-1"
                            aria-labelledby="approveModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.lots.dataentry.file.approve', $item->allotteeId) }}"
                                        method="POST">
                                        @csrf

                                        <div class="modal-header bg-success text-white" style="padding:10px !important;">
                                            <h5 class="modal-title text-white" id="approveModalLabel{{ $item->id }}">
                                                Approve File
                                            </h5>

                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3 p-3 border rounded bg-light">
                                                <div class="small text-muted mb-1">Allottee</div>
                                                <div class="fw-semibold">
                                                    {{ $allotteeName ?? 'N/A' }}
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Remarks
                                                    <small class="text-muted">(Optional)</small>
                                                </label>

                                                <textarea name="remarks" rows="4" class="form-control" placeholder="Enter approval remarks..."></textarea>
                                            </div>

                                            <input type="hidden" name="status" value="approved">
                                        </div>
                                        <hr style="margin:0;">
                                        <div class="modal-footer" style="padding:10px !important;">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                Cancel
                                            </button>

                                            <button type="submit" class="btn btn-success">
                                                <i class="bx bx-check-circle me-1"></i>
                                                Approve File
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Revert Modal --}}
                        <div class="modal fade" id="revertModal{{ $item->id }}" tabindex="-1"
                            aria-labelledby="revertModalLabel{{ $item->id }}" aria-hidden="true">

                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.lots.dataentry.file.approve', $item->allotteeId) }}"
                                        method="POST">
                                        @csrf

                                        <div class="modal-header bg-danger text-white" style="padding:10px !important;">
                                            <h5 class="modal-title text-white" id="revertModalLabel{{ $item->id }}">
                                                Revert File
                                            </h5>

                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="bedge mb-3 p-3 border rounded text-dark"
                                                style="background: rgba(253, 253, 140, 0.651);">
                                                This file will be sent back for correction.
                                            </div>
                                            <div class="mb-3 p-3 border rounded bg-light">
                                                <div class="small text-muted mb-1">Allottee</div>
                                                <div class="fw-semibold">
                                                    {{ $allotteeName ?? 'N/A' }}
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Revert Remarks <span class="text-danger">*</span>
                                                </label>

                                                <textarea name="remarks" rows="4" class="form-control" placeholder="Enter reason for revert..." required></textarea>
                                            </div>

                                            <input type="hidden" name="status" value="reverted">
                                        </div>
                                        <hr style="margin:0;">
                                        <div class="modal-footer" style="padding:10px !important;">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                Cancel
                                            </button>

                                            <button type="submit" class="btn btn-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="me-1">
                                                    <path d="M3 7v6h6"></path>
                                                    <path d="M3 13a9 9 0 1 0 3-7.7L3 7"></path>
                                                </svg>
                                                Revert File
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if ($files->hasPages())
                        <div class="p-4 border-top">
                            {{ $files->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.35em 0.65em;
        }

        .btn-group .btn {
            margin-left: 5px;
        }

        #selectedCount {
            font-size: 0.9rem;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
    </style>
@endpush
