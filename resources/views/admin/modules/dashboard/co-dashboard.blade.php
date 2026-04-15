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
<style>
    .custom-card {
        border-radius: 10px;
        color: #1f2937;
        /* dark text */
    }

    /* Different soft background colors */
    .bg-soft-green {
        background-color: #e6f9f0;
    }

    .bg-soft-blue {
        background-color: #e7f1ff;
    }

    .bg-soft-yellow {
        background-color: #fff8e6;
    }

    .bg-soft-orange {
        background-color: #feefdd;
    }

    .bg-soft-pink {
        background-color: #ffeef3;
    }

    .bg-soft-purple {
        background-color: #f3e8ff;
    }
</style>
<div class="container-xxl flex-grow-1 mt-3">
    <div class="row">
        <h5><i class="menu-icon tf-icons bx bx-layer"></i>Digitilization Stats</h5>
        @php
            $bgClasses = [
            'bg-soft-green',
            'bg-soft-blue',
            'bg-soft-yellow',
            'bg-soft-pink',
            'bg-soft-purple',
            'bg-soft-orange'
            ];
        @endphp

        @php
            $role = auth('admin')->user()->role;
            $allowedStats = ['totalreceivingFile', 'totalscannedFile' , 'totalAllotteeFile' , 'totaltransferFile' , 'totalDataentryFile', 'totalcheckedFile' , 'totalapprovedFile', 'totalhandoverreadyLots'];
        @endphp

        @foreach($stats as $key => $value)
            @if(!in_array($key, $allowedStats))
                @continue
            @endif

            @php
                $bgClass = $bgClasses[$loop->index % count($bgClasses)];
            @endphp
        <div class="col-sm-4 col-xl-4 mb-4">
            <div class="card custom-card {{ $bgClass }} border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar avatar-lg bg-primary-lt text-primary me-3">
                        {!! $icons[$key] ?? '' !!}
                    </div>

                    <div>
                        <div class="text-uppercase">{{ $labels[$key] ?? $key }}</div>
                        <h2 class="mb-0 fw-bold">{{ $value }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <h5>
            <i class="menu-icon tf-icons bx bx-layer"></i> Users Statistics
        </h5>

        @php
        $role = auth('admin')->user()->role;

        $allowedstats = $role == 'council_office'
        ? ['todayChecked', 'totalChecked']
        : ['todayApproved', 'totalApproved'];

        $filteredStats = array_intersect_key($stats, array_flip($allowedstats));
        @endphp

        <div class="row">
            @foreach($filteredStats as $key => $value)
            @php
            $bgClass = $bgClasses[$loop->index % count($bgClasses)];
            @endphp
            <div class="col-sm-4 col-xl-4 mb-4">
                <div class="card custom-card {{$bgClass}} border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">

                        <div class="avatar avatar-lg bg-primary-lt text-primary me-3">
                            {!! $icons[$key] ?? '' !!}
                        </div>

                        <div>
                            <div class="text-uppercase">
                                {{ $labels[$key] ?? $key }}
                            </div>
                            <h2 class="mb-0 fw-bold">
                                {{ $value }}
                            </h2>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @if (auth('admin')->user()->role == 'council_office')
    <!-- RECENT ALLOTTY TABLE -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                    <h5 class="card-title mb-0 text-white">Recent Added Allotty</h5>
                    <!-- <a href="" class="btn btn-sm btn-danger">
                        View All
                    </a> -->
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
    @endif
    @if (auth('admin')->user()->role == 'approver')
    <div class="row">
        @foreach ($subdivisionStats as $item)
        <div class="col-sm-3 col-xl-4 mb-4">
            <div class="card custom-card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1 fw-bold">{{ $item->sub_division_name ?? $item->name }}</h5>
                            <small class="text-muted">
                                {{ $item->sub_division_code ?? $item->code ?? 'Subdivision' }}
                            </small>
                        </div>

                        <!-- <span class="badge bg-primary">
                            {{ $item->progress_percent }}%
                        </span> -->
                    </div>

                    <div class="row text-center mb-3">
                        <div class="col-3 border-end">
                            <div class="fw-bold fs-4 text-dark">
                                {{ $item->total_files_count }}
                            </div>
                            <small class="text-muted">Total</small>
                        </div>

                        <div class="col-3 border-end">
                            <div class="fw-bold fs-4 text-primary">
                                {{ $item->verified_files_count }}
                            </div>
                            <small class="text-muted">Checked</small>
                        </div>

                        <div class="col-3 border-end">
                            <div class="fw-bold fs-4 text-success">
                                {{ $item->approved_files_count }}
                            </div>
                            <small class="text-muted">Approved</small>
                        </div>

                        <div class="col-3">
                            <div class="fw-bold fs-4 text-warning">
                                {{ $item->pending_files_count }}
                            </div>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>

                    <!-- <div class="progress progress-sm mb-2" style="height: 8px;">
                        <div class="progress-bar bg-success"
                            role="progressbar"
                            style="width: {{ $item->progress_percent }}%"
                            aria-valuenow="{{ $item->progress_percent }}"
                            aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div> -->

                    <!-- <div class="d-flex justify-content-between">
                        <small class="text-muted">
                            {{ $item->verified_files_count }} verified of {{ $item->total_files_count }}
                        </small>

                        <small class="fw-semibold text-success">
                            {{ $item->progress_percent }}% Completed
                        </small>
                    </div> -->
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-sm-3 col-xl-4 mb-4">
            <div class="card custom-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar avatar-lg bg-primary-lt text-primary me-3">
                        <i class="bx bx-folder-open fs-2"></i>
                    </div>

                    <div>
                        <div class="text-uppercase">Division Files</div>
                        <h2 class="mb-0 fw-bold">{{ $allDivisionFileCount }}</h2>
                        <small class="text-muted">Total completed files in your division</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-xl-12 mb-4">
            <div class="card custom-card border-0 shadow-sm h-100">
                <div class="card-body">

                    <!-- Header -->
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <div class="text-muted small text-uppercase">Approved Files </div>
                            <h6 class="fw-bold mb-0">Last 30 Days ({{$monthRange}})</h6>
                        </div>
                        <div class="avatar avatar-md bg-success-lt text-success">
                            <i class="bx bx-line-chart fs-4"></i>
                        </div>
                    </div>

                    <!-- Chart -->
                    <canvas id="approvedFilesChart" height="50"></canvas>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('approvedFilesChart');
        const chartData = @json($chartData);
        new Chart(ctx, {
            type: 'line', // change to 'bar' if needed
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Approved Files',
                    data: chartData.data,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    {{-- Recent verified files --}}
    <div class="row mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success  d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 text-white">Recently Checked Files</h5>
                        <small class="opacity-95 text-white">Latest checked files from your division</small>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Allottee Name</th>
                                <th>Property No.</th>
                                <th>Subdivision</th>
                                <th>Verified On</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($recentVerifyAllotteeList as $index => $file)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ trim($file->allottee_name . ' ' . $file->allottee_middle_name . ' ' . $file->allottee_surname) }}
                                    </div>
                                    <small class="text-dark">
                                        {{ $file->division->name ?? '-' }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge bg-secondary-lt text-primary">
                                        <b>{{ $file->property_number ?? '-' }}</b>
                                    </span>
                                </td>

                                <td>
                                    {{ $file->subdivision->name ?? '-' }}
                                </td>

                                <td>
                                    {{ formatDateTime($file->sub_admin_checked_date , 'd/m/Y') }}
                                    <br>
                                    <small class="text-dark">
                                        {{ formatDateTime($file->sub_admin_checked_date , 'h:i A') }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge bg-success">
                                        <i class="bx bx-check-circle me-1"></i>
                                        Verified
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bx bx-folder-open fs-1 d-block mb-2"></i>
                                    No verified files found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (auth('admin')->user()->role == 'divisional_admin')
    <div class="row">
        <div class="col-sm-3 col-xl-4 mb-4">
            <div class="card custom-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar avatar-lg bg-primary-lt text-primary me-3">
                        <i class="bx bx-folder-open fs-2"></i>
                    </div>

                    <div>
                        <div class="text-uppercase">All Files</div>
                        <h2 class="mb-0 fw-bold">{{ $allDivisionFileCount }}</h2>
                        <small class="text-muted">Total completed files in your division</small>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($subdivisionStats as $item)
        <div class="col-sm-3 col-xl-4 mb-4">
            <div class="card custom-card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1 fw-bold">{{ $item->sub_division_name ?? $item->name }}</h5>
                            <small class="text-muted">
                                Division
                            </small>
                        </div>

                        <!-- <span class="badge bg-primary">
                            {{ $item->progress_percent }}%
                        </span> -->
                    </div>

                    <div class="row text-center mb-3">
                        <div class="col-3 border-end">
                            <div class="fw-bold fs-4 text-dark">
                                {{ $item->total_files_count }}
                            </div>
                            <small class="text-muted">Total</small>
                        </div>

                        <div class="col-3 border-end">
                            <div class="fw-bold fs-4 text-primary">
                                {{ $item->verified_files_count }}
                            </div>
                            <small class="text-muted">Checked</small>
                        </div>

                        <div class="col-3 border-end">
                            <div class="fw-bold fs-4 text-success">
                                {{ $item->approved_files_count }}
                            </div>
                            <small class="text-muted">Approved</small>
                        </div>

                        <div class="col-3">
                            <div class="fw-bold fs-4 text-warning">
                                {{ $item->pending_files_count }}
                            </div>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Recent verified files --}}
    <div class="row mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success  d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 text-white">Recently Checked Files</h5>
                        <small class="opacity-95 text-white">Latest checked files from your division</small>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Allottee Name</th>
                                <th>Property No.</th>
                                <th>Subdivision</th>
                                <th>Verified On</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($recentVerifyAllotteeList as $index => $file)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ trim($file->allottee_name . ' ' . $file->allottee_middle_name . ' ' . $file->allottee_surname) }}
                                    </div>
                                    <small class="text-dark">
                                        {{ $file->division->name ?? '-' }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge bg-secondary-lt text-primary">
                                        <b>{{ $file->property_number ?? '-' }}</b>
                                    </span>
                                </td>

                                <td>
                                    {{ $file->subdivision->name ?? '-' }}
                                </td>

                                <td>
                                    {{ formatDateTime($file->sub_admin_checked_date , 'd/m/Y') }}
                                    <br>
                                    <small class="text-dark">
                                        {{ formatDateTime($file->sub_admin_checked_date , 'h:i A') }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge bg-success">
                                        <i class="bx bx-check-circle me-1"></i>
                                        Verified
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bx bx-folder-open fs-1 d-block mb-2"></i>
                                    No verified files found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
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
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
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
</div>
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