@extends('admin.layouts.main')

@section('admin-content')
<style>
    .stat-card {
        border: none;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
    }

    .calendar-table td {
        height: 45px;
        vertical-align: middle;
    }

    .calendar-table .today {
        background: #0d6efd;
        color: #fff;
        font-weight: bold;
        border-radius: 6px;
    }
</style>
@if (session('success'))
<div class="alert alert-success alert-dismissible mx-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="bs-toast toast fade show bg-danger " role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <i class="bx bx-bell me-2"></i>
        <div class="me-auto fw-medium">Error</div>
        <small>Just now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
<div class="container-fluid py-4">
    <div class="row g-4">

        <!-- LEFT SIDE : STATS + RECENT TABLE -->
        <div class="col-lg-12">

            <!-- STATS CARDS -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card text-center">
                        <div class="card-body">
                            <h6 class="text-muted">Divisions</h6>
                            <h3 class="fw-bold">12</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card text-center">
                        <div class="card-body">
                            <h6 class="text-muted">Sub Divisions</h6>
                            <h3 class="fw-bold">48</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card text-center">
                        <div class="card-body">
                            <h6 class="text-muted">Total Allotty</h6>
                            <h3 class="fw-bold">1,245</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card text-center">
                        <div class="card-body">
                            <h6 class="text-muted">Total Schemes</h6>
                            <h3 class="fw-bold">36</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RECENT ALLOTTY TABLE -->
            <div class="card">
                <div class="card-header fw-bold">
                    Recent Allotty
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Scheme</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Rahul Sharma</td>
                                <td>Housing Scheme A</td>
                                <td>06 Feb 2026</td>
                                <td><span class="badge bg-success">Approved</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Anita Verma</td>
                                <td>Commercial Scheme B</td>
                                <td>05 Feb 2026</td>
                                <td><span class="badge bg-warning text-dark">Pending</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Mohit Singh</td>
                                <td>Residential Scheme C</td>
                                <td>04 Feb 2026</td>
                                <td><span class="badge bg-danger">Rejected</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
       </div>
    </div>
</div>

{{-- @if ($updatePasswordModal) --}}
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" action="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        <small class="form-text text-muted">Password must be at least 8 characters long, and include
                            uppercase, lowercase, and special characters.</small>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="text" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <div id="error-message" class="text-danger"></div>
                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button type="button" class="btn btn-primary" id="submitPasswordChange">Update Password</button>
            </div>
        </div>
    </div>
</div>
{{-- @endif --}}

@endsection

@push('scripts')
<script>
    window.history.pushState(null, '', window.location.href);
        window.onpopstate = function() {
            window.history.go(1);
        };
</script>
@endpush