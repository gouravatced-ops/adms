@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Lot Files List / {{ $Lots }} : {{ $registerNo }}</span>
        </h6>

        <div class="card mb-4">
            <div class="card-header bg-info d-flex justify-content-between align-items-center">
                <h5 class="text-white mb-0">Lot Files</h5>
                <div class="btn-group">
                    &nbsp;
                    <button type="button" class="btn btn-light btn-sm">
                        <a href="{{ route('admin.manage.lots.index') }}" class="text-decoration-none text-dark">
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
                    <table id="adminListTable1" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sl. no.</th>
                                <th>Allottee & Property</th>
                                <th>Division Details</th>
                                <th>Property Details</th>
                                <th>Remarks</th>
                                <th>Status</th>
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
                                        <div class="fw-semibold">{{ $allotteeName ?: 'N/A' }}</div>
                                        <small class="text-dark d-block">Property No:
                                            {{ $item->property_number ?? 'N/A' }}</small>
                                        <small class="text-dark d-block">No. of Files: {{ $fileCount }}</small>
                                        {{-- <small class="text-dark d-block">Id: {{ $item->id }}</small> --}}
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
                                        <span class="badge bg-warning text-dark">{{ $item->file_remarks ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge
                                                    @if ($item->allottee_status == 'received') bg-primary
                                                    @elseif($item->allottee_status == 'scanned') bg-warning text-dark
                                                    @elseif($item->allottee_status == 'handover') bg-success
                                                    @elseif($item->allottee_status == 'dataentry') bg-info
                                                    @else bg-secondary @endif
                                                ">
                                            {{ ucfirst($item->allottee_status ?? 'N/A') }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ formatDateTime($item->updated_at ?? now()) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.receiving.file.fetch', $item->primary_id_encrpted) }}"
                                            class="btn btn-primary text-white me-2" title="Edit {{ $allotteeName }} File">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                                <path d="M14 2v6h6" />
                                                <path d="M16 13l-5.5 5.5L8 19l.5-2.5L14 11z" />
                                                <path d="M13 12l3 3" />
                                            </svg>
                                        </a>
                                        @if ($item->allottee_status == 'received' || $item->allottee_status == 'scanned')
                                            <a href="{{ route('admin.lots.file.delete', $item->primary_id_encrpted) }}"
                                                class="btn btn-danger text-white me-2"
                                                title="Delete {{ $allotteeName }} File"
                                                onclick="return confirm('Are you sure you want to delete this file?')">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6l-1 14H6L5 6"></path>
                                                    <path d="M10 11v6"></path>
                                                    <path d="M14 11v6"></path>
                                                    <path d="M9 6V4h6v2"></path>

                                                </svg>
                                            </a>
                                        @endif
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
