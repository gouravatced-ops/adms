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
['label' => 'Total Approved', 'field' => 'verified_files_count', 'class' => 'primary', 'always' => true],
];
@endphp

<div class="container-xxl flex-grow-1">
    <h6 class="py-3 mb-2">
        <span class="invert-text-white">Dashboard / Approved Lots</span>
    </h6>

    <div class="card mb-4">
        <h5 class="card-header bg-success text-white bg-info">Approved Lots</h5>

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
                            <th>Created On</th>
                            <th width="150" class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($registrations as $item)
                        <tr @class(['table-warning'=> $item->highlighted])>
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
                                <span class="badge bg-primary">{{ $item->lot_no }}</span>
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

                            <td>{{ formatDate($item->created_at) }}</td>

                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.approved.files.index', [
                                                'encodedId' => $item->encoded_register_no,
                                                'page' => 1,
                                            ]) }}"
                                        class="btn btn-sm btn-primary" title="View Lot Files">
                                        <i class="bx bx-list-ul"></i>
                                    </a>
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
            </div>
        </div>
    </div>
</div>
@endsection