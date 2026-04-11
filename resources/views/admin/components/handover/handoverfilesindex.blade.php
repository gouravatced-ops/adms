@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Handover Lot Files List / {{ $Lots }} : {{ $registerNo }}</span>
        </h6>

        <div class="card mb-4">
            <div class="card-header bg-info d-flex justify-content-between align-items-center">
                <h5 class="text-white mb-0">Lot Handover Files List</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-dark btn-sm">
                        <a href="{{ route('admin.handover.files.exports', ['registerId' => base64_encode($registerNo)]) }}"
                            class="text-decoration-none text-white">
                            Export Files
                        </a>
                    </button>
                    &nbsp;
                    <button type="button" class="btn btn-light btn-sm">
                        <a href="{{ route('admin.handover.lots.index') }}" class="text-decoration-none text-dark">
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
                    <table id="adminListTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sl. no.</th>
                                <th>Allottee & Property</th>
                                <th>Division /Property Details</th>
                                <th>Remarks</th>
                                <th>Checked At</th>
                                <th>Approved At</th>
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
                                        <div class="fw-semibold text-primary">{{ $allotteeName ?: 'N/A' }}</div>
                                        <span class="text-dark d-block"><u><b>Property No:
                                            <span class="text-danger">{{ $item->property_number ?? 'N/A' }}</span></b></u></span>
                                        <span class="text-dark d-block">No. of Files: {{ $fileCount }}</span>
                                    </td>
                                    <td>
                                        <div>{{ $item->division->name ?? 'N/A' }}</div>
                                        <span class="text-dark d-block">Sub Division:
                                            <b>{{ $item->subDivision->name ?? 'N/A' }}</b></span>
                                        <hr>
                                        <div><b>{{ $item->propertyCategory->name ?? 'N/A' }} – {{ $propertyType }}</b></div>
                                        <span class="text-dark d-block">Quarter: <b> {{ $quarterInfo }}</b></span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-warning text-dark">{{ $item->file_remarks ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        {{ formatDateTime($item->sub_admin_checked_date ?? '-') }}
                                    </td>
                                    <td>
                                        {{ formatDateTime($item->divisional_approved_date ?? '-') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-dark">
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
