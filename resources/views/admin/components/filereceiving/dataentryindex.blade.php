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
            <span class="invert-text-white">Dashboard / Data Entry Lots</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Data Entry Lots</h5>

            <div class="card-body mt-2">
                @php
                    #return getDebugIndex($registrations);
                @endphp
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
                                <th width="12%">Register</th>
                                <th>Lot No</th>
                                <th>Files Counts</th>
                                <th>Division</th>
                                <th>Crt. By</th>
                                <th>Stage</th>
                                <th>Created On</th>
                                <th colspan="2" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($registrations as $key => $item)
                                <tr class="{{ $item->highlighted ? 'table-warning' : '' }}">

                                    <td>{{ $key + 1 }}</td>

                                    <td class="fw-semibold">
                                        {{ $item->register_no }}
                                        @if ($item->lots_subadmin_approved == 1)
                                            <span class="status-completed" title="Sub Admin Approved">✓</span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge bg-info">{{ $item->lot_no }}</span>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <span class="badge bg-primary px-2 py-1">
                                                Total
                                                <span class="ms-1 fw-bold">{{ $item->total_register_files }}</span>
                                            </span>
                                            <span class="badge bg-info px-2 py-1">
                                                Assigned
                                                <span class="ms-1 fw-bold">{{ $item->total_assigned_files }}</span>
                                            </span>
                                            <span class="badge bg-success px-2 py-1">
                                                Completed
                                                <span class="ms-1 fw-bold">{{ $item->total_completed_files }}</span>
                                            </span>
                                            @if ($item->total_pending_files > 0)
                                                <span class="badge bg-warning text-dark px-2 py-1">
                                                    Pending
                                                    <span class="ms-1 fw-bold">{{ $item->total_pending_files }}</span>
                                                </span>
                                            @endif
                                            @if ($item->total_inprogress_files > 0)
                                                <span class="badge bg-secondary px-2 py-1">
                                                    In Progress
                                                    <span class="ms-1 fw-bold">{{ $item->total_inprogress_files }}</span>
                                                </span>
                                            @endif
                                            @if ($item->not_assigned_files > 0)
                                                <span class="badge bg-danger px-2 py-1">
                                                    Not Assigned
                                                    <span class="ms-1 fw-bold">{{ $item->not_assigned_files }}</span>
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        {{ getDivisionName($item->division_id) }}
                                    </td>

                                    <td>{{ $item->created_named_by }}</td>

                                    <td>
                                        <span class="badge bg-{{ $item->badge_color ?? 'secondary' }}">
                                            {{ ucfirst($item->current_stage) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ formatDate($item->created_at) }}
                                    </td>

                                    <td colspan="2" class="text-center">
                                        <a href="{{ route('admin.dataentry.files.index', ['encodedId' => $item->encoded_register_no, 'page' => 1]) }}"
                                            class="btn btn-primary text-white" title="View Lot Files">
                                            <!-- Custom List/File SVG Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M8 6h13"></path>
                                                <path d="M8 12h13"></path>
                                                <path d="M8 18h13"></path>
                                                <path d="M3 6h.01"></path>
                                                <path d="M3 12h.01"></path>
                                                <path d="M3 18h.01"></path>
                                            </svg>
                                        </a>
                                    </td>
                                    <td>
                                        {{-- Assigned Files Status Checked  --}}
                                        <a href="{{ route('admin.lots.assign.files.status', base64_encode($item->id)) }}"
                                            class="btn btn-sm btn-secondary" title="Assigned Files Status">
                                            <i class="bx bx-check-circle"></i>
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
                </div>
            </div>
        </div>
    </div>
@endsection
