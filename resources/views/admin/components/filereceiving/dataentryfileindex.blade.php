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
                <button type="button" class="btn btn-light btn-sm">
                    <a href="{{ route('admin.dataentry.lots.index') }}" class="text-decoration-none text-dark">
                        ← Back
                    </a>
                </button>
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
                        $propertyType = $item->propertyType->name ?? 'N/A';
                        $quarterInfo = $item->quarterType->quarter_code ?? 'N/A';

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
                                    @endif
                                </div>
                                <small class="text-dark d-block">Property No:
                                    {{ $item->property_number ?? 'N/A' }}</small>
                                <!-- <small class="text-dark d-block">No. of Files: {{ $fileCount }}</small> -->
                                <!-- <small class="text-dark d-block">Total Pages: {{ $totalPages }}</small> -->
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach ($badges as $badge)
                                    <span class="badge {{ $badge['class'] }}">
                                        {{ $badge['text'] }}
                                    </span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div>{{ $item->division->name ?? 'N/A' }}</div>
                                <small class="text-dark d-block">Sub Division:
                                    {{ $item->subDivision->name ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <div>{{ $item->propertyCategory->name ?? 'N/A' }} – {{ $propertyType }}</div>
                                <small class="text-dark d-block">Quarter: {{ $quarterInfo }}</small>
                            </td>
                            <td>
                                <span
                                    class="badge bg-warning text-dark">{{ $item->file_remarks ?? 'N/A' }}</span>
                            </td>
                            <td>
                                {{ formatDateTime($item->updated_at ?? '--') }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">

                                    {{-- Preview --}}
                                    <a href="{{ route('admin.file.preview', encrypt($item->id)) }}"
                                        class="btn btn-sm btn-primary text-white"
                                        title="Preview {{ $allotteeName }} File" data-bs-toggle="tooltip">

                                        {{-- Eye Preview SVG --}}
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-dark">
                                    No Lots Files Found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Verify Buttons --}}
                <!-- @if ($allVerified && $allVerified == 1)
                <div class="d-flex justify-content-center gap-2 my-4 flex-wrap">
                    <button type="button"
                        class="btn btn-primary btn-md"
                        data-bs-toggle="modal"
                        data-bs-target="#verifyDataEntryLotModal">
                        <i class="bx bx-check-shield me-1"></i>
                        Verify Lots
                    </button>
                </div>
                @endif -->

                @if ($files->hasPages())
                <div class="p-4 border-top">
                    {{ $files->links('vendor.pagination.custom') }}
                </div>
                @endif
            </div>


            <div class="modal fade" id="verifyDataEntryLotModal" tabindex="-1"
                aria-labelledby="verifyDataEntryLotModalLabel" aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <form
                            action="{{ route('admin.lots.dataentry.lots.approve', ['registerId' => $registerNo]) }}"
                            method="POST">
                            @csrf

                            <div class="modal-header bg-success text-white" style="padding: 10px !important;">
                                <h5 class="modal-title text-white" id="verifyModalLabel">
                                    Verify & Approve Lot
                                </h5>

                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3 p-3 border rounded bg-light">
                                    <strong>Register:</strong> {{ $registerNo }} <br>
                                    <strong>Lot No:</strong> {{ $Lots }}
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Remarks
                                        <small class="text-dark">(Optional)</small>
                                    </label>

                                    <textarea name="remarks" rows="4" class="form-control" placeholder="Enter approval remarks..."></textarea>
                                </div>

                                <input type="hidden" name="status" value="verified">
                            </div>
                            <hr style="margin:0;">
                            <div class="modal-footer" style="padding: 10px; !important;">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-success">
                                    <i class="bx bx-check-circle me-1"></i>
                                    Verify & Approve
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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