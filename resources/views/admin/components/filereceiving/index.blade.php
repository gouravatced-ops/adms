@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Receiving Lots</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Receiving Lots</h5>

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
                                <th>#</th>
                                <th>Register No</th>
                                <th>Lot No</th>
                                <th>Total Files</th>
                                <th>Allowed Files</th>
                                <th>Created By</th>
                                <th>Status</th>
                                <th>Created On</th>
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
                                        <span class="badge bg-primary">{{ $item->lot_no }}</span>
                                    </td>

                                    <td>{{ $item->total_files }}</td>

                                    <td>
                                        <span class="badge bg-info">{{ $item->allowed_files }}</span>
                                    </td>

                                    <td>{{ $item->created_by_name }}</td>

                                    <td>
                                        <span class="badge bg-success">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $item->created_at }}
                                    </td>

                                    <td class="text-center">
                                        <a href="#" class="text-primary me-2" title="View">
                                            <i class="bx bx-show"></i>
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
