@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Scanning Lots</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Scanning Lots</h5>

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
                    <table id="adminListTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sl. no.</th>
                                <th>Register No</th>
                                <th>Lot No</th>
                                <th>Total Files</th>
                                <th>Allowed Files</th>
                                <th>Division</th>
                                <th>Scanned By</th>
                                <th>Status</th>
                                <th>Scanned On</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($registrations as $key => $item)
                                <tr class="{{ $item->highlighted ? 'table-warning' : '' }}">

                                    <td>{{ $key + 1 }}</td>

                                    <td class="fw-semibold">
                                        {{ $item->register_no }}
                                    </td>

                                    <td>
                                        <span class="badge bg-warning">{{ $item->lot_no }}</span>
                                    </td>

                                    <td>{{ $item->total_files }}</td>

                                    <td>
                                        <span class="badge bg-info">{{ $item->allowed_files }}</span>
                                    </td>

                                    <td>
                                        {{ getDivisionName($item->division_id) }}
                                    </td>

                                    <td>{{ $item->scanned_named_by }}</td>

                                    <td>
                                        <span class="badge bg-success">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $item->updated_at }}
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.scanning.files.index', ['encodedId' => $item->encoded_register_no, 'page' => 1]) }}" class="btn btn-primary text-white me-2" title="View Lot Files">
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
                                    <td colspan="9" class="text-center text-muted">
                                        No Lots Found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($registrations->hasPages())
                        <div class="p-4 border-top">
                            {{ $registrations->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
