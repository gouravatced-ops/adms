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
    </style>
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Data Entry Files List / {{ $Lots }} :
                {{ $registerNo }}</span>
        </h6>

        <div class="card mb-4">
            <div class="card-header bg-info d-flex justify-content-between align-items-center">
                <h5 class="text-white mb-0">Lot Data Entry Files</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-dark btn-sm">
                        <a href="{{ route('admin.lots.dataentry.lots.approve', ['registerId' => base64_encode($registerNo)]) }}"
                            class="text-decoration-none text-white">
                            Verify & Apporved Lots
                        </a>
                    </button>
                    &nbsp;
                    <button type="button" class="btn btn-light btn-sm">
                        <a href="{{ route('admin.dataentry.lots.index') }}" class="text-decoration-none text-dark">
                            ← Back
                        </a>
                    </button>
                </div>
            </div>

            <div class="card-body mt-2">
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
                                            @if ($item->allottee_verify == 1)
                                                <span class="status-completed">✓</span>
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
                                        <!-- Preview Allottee file button -->
                                        <a href="{{ route('admin.file.preview', encrypt($item->id)) }}"
                                            class="btn btn-primary text-white me-2"
                                            title="Preview {{ $allotteeName }} File">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                                <path d="M14 2v6h6" />
                                                <path d="M16 13l-5.5 5.5L8 19l.5-2.5L14 11z" />
                                                <path d="M13 12l3 3" />
                                            </svg>
                                        </a>
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
