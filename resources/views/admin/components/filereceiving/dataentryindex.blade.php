@extends('admin.layouts.main')

@section('admin-content')
    <style>
        .status-completed {
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
            border-radius: 50%;
            background: #28a745;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
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

    @php
        $defaultBadges = [
            ['label' => 'Total', 'field' => 'total_register_files', 'class' => 'primary', 'always' => true],
            ['label' => 'Assigned', 'field' => 'total_assigned_files', 'class' => 'info', 'always' => true],
            ['label' => 'Completed', 'field' => 'total_completed_files', 'class' => 'success', 'always' => true],
            ['label' => 'Transfer Files', 'field' => 'transfer_file_count', 'class' => 'dark', 'always' => true],
            ['label' => 'Pending', 'field' => 'total_pending_files', 'class' => 'warning text-dark'],
            ['label' => 'In Progress', 'field' => 'total_inprogress_files', 'class' => 'secondary'],
            ['label' => 'Not Assigned', 'field' => 'not_assigned_files', 'class' => 'danger'],
        ];
    @endphp

    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Data Entry Lots</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Data Entry Lots</h5>

            <div class="card-body mt-2">

                @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
                    @if (session($key))
                        <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                            {{ session($key) }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                @endforeach

                <div class="table-responsive">
                    <table id="allLotsListTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th width="12%">Register</th>
                                <th>Lot No</th>
                                <th>File Counts</th>
                                <th>Division</th>
                                <th>Created By</th>
                                <th>Stage</th>
                                <th>Created On</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($registrations as $item)
                                @php
                                    $modalId = "verifyModal{$item->id}";
                                @endphp

                                <tr @class(['table-warning' => $item->highlighted])>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="fw-semibold">
                                        {{ $item->register_no }}

                                        @if ($item->lots_subadmin_approved == 1)
                                            <span class="status-completed" title="Sub Admin Approved">✓</span>
                                        @elseif($item->lots_subadmin_approved == 0)
                                            <span class="status-pending" title="Sub Admin Pending"><i class="bx bx-hourglass bx-tada" style="font-size: 10px;"></i></span>
                                        @elseif($item->lots_subadmin_approved === 2)
                                            <span class="status-rejected" title="Sub Admin Rejected">✗</span>
                                            Remark: <span class="small text-danger">{{ $item->remarks ?? 'No remarks provided' }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge bg-info">{{ $item->lot_no }}</span>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-column gap-1 small">

                                            @foreach ($defaultBadges as $badge)
                                                @php
                                                    $count = $item->{$badge['field']};
                                                @endphp

                                                @if (($badge['always'] ?? false) || $count > 0)
                                                    <div
                                                        class="d-flex align-items-center justify-content-between border rounded px-2 py-1 bg-light">
                                                        <span class="text-dark fw-semibold">
                                                            {{ $badge['label'] }}
                                                        </span>

                                                        <span class="badge rounded-pill bg-{{ $badge['class'] }} px-2 py-1 fw-bold" title="{{ $badge['label'] }}: {{ $count }}" style="font-size: 12px;">
                                                            {{ $count }}
                                                        </span>
                                                    </div>
                                                @endif
                                            @endforeach

                                        </div>
                                    </td>

                                    <td>{{ getDivisionName($item->division_id) }}</td>

                                    <td>{{ $item->created_named_by }}</td>

                                    <td>
                                        <span class="badge bg-{{ $item->badge_color ?: 'secondary' }}">
                                            {{ ucfirst($item->current_stage) }}
                                        </span>
                                    </td>

                                    <td>{{ formatDate($item->created_at) }}</td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('admin.dataentry.files.index', [
                                                'encodedId' => $item->encoded_register_no,
                                                'page' => 1,
                                            ]) }}"
                                                class="btn btn-sm btn-primary" title="View Lot Files">
                                                <i class="bx bx-list-ul"></i>
                                            </a>

                                            <a href="{{ route('admin.lots.assign.files.status', base64_encode($item->id)) }}"
                                                class="btn btn-sm btn-secondary" title="Assigned Files Status">
                                                <i class="bx bx-check-circle"></i>
                                            </a>

                                            {{-- Verify / Approve --}}
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#verifyModal{{ $item->id }}" title="Verify & Approve">
                                                <i class="bx bx-check-shield"></i>
                                            </button>

                                            {{-- Revert --}}
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#revertModal{{ $item->id }}" title="Revert Lot">
                                                <i class="bx bx-undo"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        No Lots Found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- Put below table / outside .table-responsive --}}
                    @foreach ($registrations as $item)
                        {{-- Verify Modal --}}
                        @php
                            $registerNo = base64_encode($item->register_no);
                        @endphp
                        <div class="modal fade" id="verifyModal{{ $item->id }}" tabindex="-1"
                            aria-labelledby="verifyModalLabel{{ $item->id }}" aria-hidden="true">

                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form
                                        action="{{ route('admin.lots.dataentry.lots.approve', ['registerId' => $registerNo]) }}"
                                        method="POST">
                                        @csrf

                                        <div class="modal-header bg-success text-white" style="padding: 10px !important;">
                                            <h5 class="modal-title text-white" id="verifyModalLabel{{ $item->id }}">
                                                Verify & Approve Lot
                                            </h5>

                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3 p-3 border rounded bg-light">
                                                <strong>Register:</strong> {{ $item->register_no }} <br>
                                                <strong>Lot No:</strong> {{ $item->lot_no }}
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Remarks
                                                    <small class="text-muted">(Optional)</small>
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

                        {{-- Revert Modal --}}
                        <div class="modal fade" id="revertModal{{ $item->id }}" tabindex="-1"
                            aria-labelledby="revertModalLabel{{ $item->id }}" aria-hidden="true">

                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form
                                        action="{{ route('admin.lots.dataentry.lots.approve', ['registerId' => $registerNo]) }}"
                                        method="POST">
                                        @csrf

                                        <div class="modal-header bg-danger text-white" style="padding: 10px !important;">
                                            <h5 class="modal-title text-white" id="revertModalLabel{{ $item->id }}">
                                                Revert Lot
                                            </h5>

                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="bedge mb-3 p-3 border rounded text-dark"
                                                style="background: rgba(253, 253, 140, 0.651);">
                                                This action will revert the verified lot back for correction.
                                            </div>

                                            <div class="mb-3 p-3 border rounded bg-light">
                                                <strong>Register:</strong> {{ $item->register_no }} <br>
                                                <strong>Lot No:</strong> {{ $item->lot_no }}
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
                                        <div class="modal-footer" style="padding: 10px; !important;">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                Cancel
                                            </button>

                                            <button type="submit" class="btn btn-danger">
                                                <i class="bx bx-undo me-1"></i>
                                                Revert Lot
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
