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
        <span class="invert-text-white">Dashboard / Missing Master Files List / {{ $Lots }} :
            {{ $registerNo }}</span>
    </h6>

    <div class="card mb-4">
        <div class="card-header bg-danger d-flex justify-content-between align-items-center">
            <h5 class="text-white mb-0">Missing Master Files in Lot</h5>
            <div class="btn-group">
                <button type="button" class="btn btn-light btn-sm">
                    <a href="{{ route('admin.master.missing.lots') }}" class="text-decoration-none text-dark">
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
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($files as $key => $item)
                        @php
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
                                $badges = [];
                                $badges[] = [
                                    'text' => 'Missing Master File',
                                    'class' => 'bg-danger text-white border',
                                ];
                                @endphp
                                <div class="fw-semibold">{{ $allotteeName ?: 'N/A' }}</div>
                                <small class="text-dark d-block">Property No:
                                    {{ $item->property_number ?? 'N/A' }}</small>
                                <div class="d-flex flex-wrap gap-1 mt-1">
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
                                    No Files Found missing Master Document.
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
