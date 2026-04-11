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
        <span class="invert-text-white">Dashboard / Handover Lots</span>
    </h6>

    <div class="card mb-4">
        <h5 class="card-header bg-success text-white bg-info">Handover Lots</h5>

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
                <table {{ $approvedfilecount > 0 ? 'id=allLotsListTable' : '' }} class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th width="12%">Register</th>
                            <th>Lot No</th>
                            <th>Lots File Stats</th>
                            <th>Division</th>
                            <th>Current Status</th>
                            <th width="12%">Activity By</th>
                            <th>Approved At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($registrations as $item)
                        <tr @class(['table-warning'=> $item->highlighted])>
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                <a href="{{ route('admin.approved.files.index', [
                                                'encodedId' => $item->encoded_register_no,
                                                'page' => 1,
                                            ]) }}"
                                    title="View Lot Files"> {{ $item->register_no }}
                                </a>
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
                            <td>
                                <span class="badge bg-{{ $item->badge_color ?: 'secondary' }}">
                                    {{ ucfirst($item->current_stage) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    Approved By : {{ $item->approved_named_by }}
                                </span>
                                <span class="badge bg-primary">
                                    Scanned By : {{ $item->scanned_named_by }}
                                </span>
                                <span class="badge bg-dark">
                                    Received By: {{ $item->recivied_named_by }}
                                </span>
                            </td>
                            <td>{{ formatDateTime($item->divisional_approval_at , 'd/m/Y h:i A') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.handover.files.index', ['encodedId' => $item->encoded_register_no, 'page' => 1]) }}" class="btn btn-primary text-white me-2" title="View Lot Files">
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