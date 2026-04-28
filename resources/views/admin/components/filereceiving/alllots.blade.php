@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / All Lots</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">All Lots</h5>

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
                                <th style="white-space: nowrap;">Sl. No.</th>
                                <th style="white-space: nowrap;">Register No</th>
                                <th style="white-space: nowrap;">Lot No</th>
                                <th style="white-space: nowrap;">Total Files</th>
                                <th style="white-space: nowrap;">Allowed Files</th>
                                <th style="white-space: nowrap;">Division</th>
                                <th style="white-space: nowrap;">Created By</th>
                                <th style="white-space: nowrap;">Current Stage</th>
                                <th style="white-space: nowrap;">Created On</th>
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
                                        <a href="{{ route('admin.receiving.files.exports', ['registerId' => base64_encode($item->register_no)]) }}">
                                            <span class="badge bg-primary">{{ $item->lot_no }}</span>
                                        </a>
                                    </td>

                                    <td>{{ $item->total_received_files }}</td>

                                    <td>
                                        <span class="badge bg-info">{{ $item->allowed_files }}</span>
                                    </td>

                                    <td>
                                        {{ getDivisionName($item->division_id) }}
                                    </td>

                                    <td>{{ $item->created_named_by }}</td>

                                    <td>
                                        <span class="badge bg-{{ $item->badge_color }}">{{ $item->current_stage }}</span>
                                    </td>

                                    <td>
                                        {{ formatDate($item->created_at) }}
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.receiving.files.exports', ['registerId' => base64_encode($item->register_no)]) }}"
                                            class="btn btn-danger text-white me-2" title="View Lot Files">
                                            <!-- PDF File with Download Arrow SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">

                                                <!-- File Shape -->
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <path d="M14 2v6h6"></path>

                                                <!-- Download Arrow -->
                                                <path d="M12 11v6"></path>
                                                <path d="M9.5 14.5L12 17l2.5-2.5"></path>

                                                <!-- Bottom Line -->
                                                <path d="M8 20h8"></path>
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
                </div>
            </div>
        </div>
    </div>
@endsection
