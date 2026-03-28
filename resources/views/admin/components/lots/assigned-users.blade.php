{{-- resources/views/admin/components/lots/assigned-users.blade.php --}}

@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Lot Files Assigned User List</span>
        </h6>

        <div class="card mb-4">
            <div class="card-header bg-info d-flex justify-content-between align-items-center">
                <h5 class="text-white mb-0">Assigned Users</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-light btn-sm">
                        <a href="{{ url()->previous() }}">
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
                                <th>#</th>
                                <th>User</th>
                                <th>Total Assigned</th>
                                <th>Completed</th>
                                <th>Pending</th>
                                <th>Assignment Type</th>
                                <th>Assigned On</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($assignedUsers as $key => $user)
                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </td>

                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $user->total_assigned_files }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-success">
                                            {{ $user->completed_files }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-danger">
                                            {{ $user->pending_files }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($user->assignment_type === 'full_lot')
                                            <span class="badge bg-success">Full Lot</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Partial</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ formatDateTime($user->assigned_at) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No assigned users found.
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
