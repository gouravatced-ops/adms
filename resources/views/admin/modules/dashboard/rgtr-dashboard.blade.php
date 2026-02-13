@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 mt-3">
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar flex-shrink-0 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-license">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                                        <path d="M9 7l4 0" />
                                        <path d="M9 11l4 0" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    Incomplete Registrations <br>
                                    <span class="badge bg-primary text-primary-fg ms-auto">{{ $incompleteCount }}</span>
                                </div>
                                <div class="text-secondary">
                                    <a href="{{ route('view.incomplete-registration') }}"
                                        class="btn btn-outline-primary mt-4">Click
                                        Here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar flex-shrink-0 text-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-license">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                                        <path d="M9 7l4 0" />
                                        <path d="M9 11l4 0" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    Accepted Registrations <br> <span
                                        class="badge bg-primary text-primary-fg ms-auto">{{ $acceptCount }}</span>
                                </div>
                                <div class="text-secondary">
                                    <a href="{{ route('view.accepted-registration') }}" class="btn btn-outline-primary mt-4">Click
                                        Here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar flex-shrink-0 text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-license">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                                        <path d="M9 7l4 0" />
                                        <path d="M9 11l4 0" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    Rejected Registrations <br> <span
                                        class="badge bg-primary text-primary-fg ms-auto">{{ $rejectCount }}</span>
                                </div>
                                <div class="text-secondary">
                                    <a href="{{ route('view.rejected-registration') }}" class="btn btn-outline-primary mt-4">Click
                                        Here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($approveCount > 0)
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-success text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-license">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                                            <path d="M9 7l4 0" />
                                            <path d="M9 11l4 0" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        Approved Registrations <span
                                            class="badge bg-primary text-primary-fg ms-auto">{{ $approveCount }}</span>
                                    </div>
                                    <div class="text-secondary">
                                        <a href="{{ route('approved-application') }}"
                                            class="btn btn-outline-primary mt-4">Click
                                            Here</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
                                <input type="password" class="form-control" id="newPassword" name="newPassword"
                                    required>
                                <small class="form-text text-muted">Password must be at least 8 characters long, and
                                    include
                                    uppercase, lowercase, and special characters.</small>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="text" class="form-control" id="confirmPassword" name="confirmPassword"
                                    required>
                            </div>
                            <div id="error-message" class="text-danger"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitPasswordChange">Update Password</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- @endif --}}
    </div>
@endsection
@push('scripts')
    <script>
        window.history.pushState(null, '', window.location.href);
        window.onpopstate = function() {
            window.history.go(1);
        };
    </script>
@endpush
