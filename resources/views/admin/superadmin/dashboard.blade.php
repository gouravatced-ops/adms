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
<style>
    /* CARD FOOTER LINK */
    .card-footer-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        padding: 0.6rem 1rem;
        font-size: 0.85rem;
        font-weight: 500;

        color: #ffffff;
        text-decoration: none;

        border-top: 1px solid rgba(255, 255, 255, 0.3);
        background-color: var(--bs-primary);

        transition: all 0.2s ease;
    }

    /* SVG COLOR */
    .card-footer-link svg {
        stroke: #ffffff;
        transition: transform 0.2s ease;
    }

    /* HOVER EFFECT */
    .card-footer-link:hover {
        background-color: #0b5ed7;
    }

    .card-footer-link:hover svg {
        transform: translateX(4px);
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
<div class="container-xxl flex-grow-1 mt-3">
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card card-sm">

                    <!-- CARD BODY -->
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar flex-shrink-0 text-primary">
                                <!-- SVG KEPT -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icon-tabler-hierarchy">
                                    <path d="M12 5v6" />
                                    <path d="M5 11h14" />
                                    <rect x="3" y="13" width="6" height="6" rx="1" />
                                    <rect x="15" y="13" width="6" height="6" rx="1" />
                                    <rect x="9" y="3" width="6" height="4" rx="1" />
                                </svg>
                            </div>

                            <div>
                                <div class="fw-semibold">Divisions</div>
                                <span class="badge bg-primary text-primary-fg">
                                    {{ $divisionCount }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- CARD FOOTER LINK -->
                    <a href="{{ route('admin.division.index') }}" class="card-footer-link bg-primary">
                        <span>View Details</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card card-sm">

                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar flex-shrink-0 text-success">
                                <!-- SVG UNCHANGED -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icon-tabler-hierarchy">
                                    <path d="M12 5v6" />
                                    <path d="M5 11h14" />
                                    <rect x="3" y="13" width="6" height="6" rx="1" />
                                    <rect x="15" y="13" width="6" height="6" rx="1" />
                                    <rect x="9" y="3" width="6" height="4" rx="1" />
                                </svg>
                            </div>

                            <div>
                                <div class="fw-semibold">Sub Divisions</div>
                                <span class="badge bg-primary text-primary-fg">
                                    {{ $subdivisionCount }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('admin.subdivision.index') }}" class="card-footer-link bg-success">
                        <span>View Details</span>

                    </a>

                </div>

            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card card-sm">

                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar flex-shrink-0 text-danger">
                                <!-- SVG UNCHANGED -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 21h18" />
                                    <path d="M5 21v-14l7 -4l7 4v14" />
                                    <path d="M9 9h2v2h-2z" />
                                    <path d="M13 9h2v2h-2z" />
                                    <path d="M9 13h2v2h-2z" />
                                    <path d="M13 13h2v2h-2z" />
                                    <path d="M11 21v-3h2v3" />
                                </svg>
                            </div>

                            <div>
                                <div class="fw-semibold">Total Allotty</div>
                                <span class="badge bg-primary text-primary-fg">
                                    {{ $allotteeCount }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('view.rejected-registration') }}" class="card-footer-link bg-danger">
                        <span>View Details</span>

                    </a>

                </div>

            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card card-sm">

                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <span class="avatar text-primary">
                                <!-- SVG UNCHANGED -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icon-tabler-layers">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 2l8 4l-8 4l-8 -4z" />
                                    <path d="M4 10l8 4l8 -4" />
                                    <path d="M4 14l8 4l8 -4" />
                                </svg>
                            </span>

                            <div>
                                <div class="fw-semibold">Total Schemes</div>
                                <span class="badge bg-primary text-primary-fg">
                                    {{ $schemeCount }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('admin.schemes.index') }}" class="card-footer-link bg-primary">
                        <span>View Details</span>

                    </a>

                </div>

            </div>
        </div>
    </div>

    <!-- RECENT ALLOTTY TABLE -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                    <h5 class="card-title mb-0 text-white">Recent Added Allotty</h5>
                    <a href="" class="btn btn-sm btn-danger">
                        View All
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Allotty Name</th>
                                <th>Division</th>
                                <th>Created On</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentAllotteeList ?? [] as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td class="fw-semibold">
                                    {{ $item->allottee_name }} {{ $item->allottee_middle_name }}
                                    {{ $item->allottee_surname }}
                                </td>

                                <td>{{ $item->division->name ?? '-' }}</td>

                                <td>{{ $item->created_at->format('d M Y') }}</td>

                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No recent records found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@if ($updatePasswordModal)
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white" style="padding:10px !important;">
                <h5 class="modal-title text-white" id="changePasswordModalLabel">Change Password</h5>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" action="{{ route('update.dashboard-password') }}" method="POST">
                    @csrf
                    <div class="alert1 alert-warning mb-3 p-2">
                        Your password is 30 days old. Please reset your password now to continue.
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="oldPassword">Old Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="oldPassword" name="oldPassword"
                                autocomplete="current-password"
                                class="form-control @error('oldPassword') is-invalid @enderror"
                                placeholder="Enter current password" required>

                            <span class="input-group-text cursor-pointer toggle-password">
                                <i class="bx bx-hide"></i>
                            </span>

                            @error('oldPassword')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label" for="newPassword">New Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="newPassword" name="newPassword"
                                autocomplete="new-password"
                                class="form-control @error('newPassword') is-invalid @enderror"
                                placeholder="Enter new password">

                            <span class="input-group-text cursor-pointer toggle-password">
                                <i class="bx bx-hide"></i>
                            </span>

                            @error('newPassword')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label" for="newPassword_confirmation">Confirm New Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="newPassword_confirmation"
                                name="newPassword_confirmation" class="form-control" required
                                placeholder="Confirm new password">

                            <span class="input-group-text cursor-pointer toggle-password">
                                <i class="bx bx-hide"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="captcha">Captcha</label>
                        </div>

                        <div class="input-group input-group-merge">
                            <!-- Captcha Image -->
                            <span class="input-group-text p-1" id="captcha-image">
                                {!! captcha_img('flat') !!}
                            </span>

                            <!-- Captcha Input -->
                            <input type="text" id="captcha" name="captcha" required
                                class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter captcha"
                                aria-describedby="captcha" autocomplete="off" />

                            <!-- Refresh Button -->
                            <span class="input-group-text cursor-pointer" id="reload-captcha">
                                <i class="bx bx-refresh"></i>
                            </span>
                        </div>

                        @error('captcha')
                        <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    <div id="error-message" class="text-danger"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="changePasswordForm" id="submitPasswordChange">Update Password</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
        myModal.show();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const toggleButtons = document.querySelectorAll(".toggle-password");

        toggleButtons.forEach(function(button) {
            button.addEventListener("click", function() {

                const input = this.closest(".input-group").querySelector("input");
                const icon = this.querySelector("i");

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("bx-hide");
                    icon.classList.add("bx-show");
                } else {
                    input.type = "password";
                    icon.classList.remove("bx-show");
                    icon.classList.add("bx-hide");
                }

            });
        });

    });
</script>
@endif
@endsection

@push('scripts')
<script>
    window.history.pushState(null, '', window.location.href);
    window.onpopstate = function() {
        window.history.go(1);
    };

    document.addEventListener('DOMContentLoaded', function() {
        var changePasswordModalElement = document.getElementById('changePasswordModal');
        if (changePasswordModalElement) {
            var passwordModal = new bootstrap.Modal(changePasswordModalElement, {
                backdrop: 'static',
                keyboard: false,
            });
            passwordModal.show();
        }
    });
</script>
@endpush