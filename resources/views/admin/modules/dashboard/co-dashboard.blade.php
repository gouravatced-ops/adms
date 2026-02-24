@extends('admin.layouts.main')

@section('admin-content')
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
                                    0
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- CARD FOOTER LINK -->
                    <a href="{{ route('view.incomplete-registration') }}" class="card-footer-link bg-primary">
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
                                <div class="fw-semibold">Sub Divisions</div>
                                <span class="badge bg-primary text-primary-fg">
                                    0
                                </span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('view.accepted-registration') }}" class="card-footer-link bg-success">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler">
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
                                    0
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icon-tabler-layers">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 2l8 4l-8 4l-8 -4z" />
                                    <path d="M4 10l8 4l8 -4" />
                                    <path d="M4 14l8 4l8 -4" />
                                </svg>
                            </span>

                            <div>
                                <div class="fw-semibold">Total Schemes</div>
                                <span class="badge bg-primary text-primary-fg">
                                    0
                                </span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('approved-application') }}" class="card-footer-link bg-primary">
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
                                <th>Scheme</th>
                                <th>Created On</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentAllotty ?? [] as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $item->name }}</td>
                                <td>{{ $item->division->name ?? '-' }}</td>
                                <td>{{ $item->scheme->name ?? '-' }}</td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
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
                        <small class="form-text text-muted">Password must be at least 8 characters long, and
                            include
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