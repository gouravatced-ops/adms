{{-- resources/views/admin/components/lots/assigned-files-status.blade.php --}}

@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <div>
                <h4 class="mb-1 fw-bold text-primary">Assigned Files Status</h4>
                <p class="text-muted mb-0">
                    Lot ID : <span class="fw-semibold">#{{ $lotId }}</span>
                </p>
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Back
            </a>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Stats Cards --}}
        @php
            $totalAssignments = $assignedfiles->count();
            $completedCount = $assignedfiles->where('status', 'completed')->count();
            $pendingCount = $assignedfiles->where('status', 'pending')->count();
            $progressCount = $assignedfiles->where('status', 'in_progress')->count();
            $notStartedCount = $assignedfiles->whereNotIn('status', ['completed', 'pending', 'in_progress'])->count();
        @endphp

        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-white small">Total Assignments</span>
                            <h2 class="mb-0 mt-1 text-white fw-bold">{{ $totalAssignments }}</h2>
                        </div>
                        <i class="bx bx-folder fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-white small">Completed</span>
                            <h2 class="mb-0 mt-1 text-white fw-bold">{{ $completedCount }}</h2>
                        </div>
                        <i class="bx bx-check-circle fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-warning h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-dark small">Pending</span>
                            <h2 class="mb-0 mt-1 fw-bold text-dark">{{ $pendingCount }}</h2>
                        </div>
                        <i class="bx bx-time-five fs-1 text-dark opacity-75"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-info text-white h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-white small">In Progress</span>
                            <h2 class="mb-0 mt-1 text-white fw-bold">{{ $progressCount }}</h2>
                        </div>
                        <i class="bx bx-loader-circle fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom-0 pb-0">
                <ul class="nav nav-tabs card-header-tabs" id="assignmentTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active fw-semibold" data-bs-toggle="tab" data-bs-target="#allTab"
                            type="button">
                            All
                            <span class="badge bg-primary ms-1">{{ $totalAssignments }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#pendingTab"
                            type="button">
                            Pending
                            <span class="badge bg-warning text-dark ms-1">{{ $pendingCount }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#progressTab"
                            type="button">
                            In Progress
                            <span class="badge bg-info ms-1">{{ $progressCount }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#completedTab"
                            type="button">
                            Completed
                            <span class="badge bg-success ms-1">{{ $completedCount }}</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-0">
                <div class="tab-content">

                    @php
                        $tabs = [
                            'allTab' => $assignedfiles,
                            'pendingTab' => $assignedfiles->where('status', 'pending'),
                            'progressTab' => $assignedfiles->where('status', 'in_progress'),
                            'completedTab' => $assignedfiles->where('status', 'completed'),
                        ];
                    @endphp

                    @foreach ($tabs as $tabId => $rows)
                        <div class="tab-pane fade {{ $tabId === 'allTab' ? 'show active' : '' }}"
                            id="{{ $tabId }}">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">Sl No.</th>
                                            <th>Allottee</th>
                                            <th>Register ID</th>
                                            <th>Assigned To</th>
                                            <th>Assigned By</th>
                                            <th>Status</th>
                                            <th>Assigned On</th>
                                            <th width="100" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($rows as $index => $file)
                                            @php
                                                $allottee = $file->registerallottee;
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="fw-semibold">{{ $allottee->prefix }}
                                                        {{ $allottee->allottee_name }} {{ $allottee->allottee_surname }}
                                                    </div>
                                                    <div class="small text-muted">Prop: {{ $allottee->property_number }}
                                                    </div>
                                                </td>
                                                <td>{{ $allottee->register_id }}</td>
                                                <td>
                                                    <span
                                                        class="fw-semibold">{{ $file->assignedUser->name ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-muted">{{ $file->assigner->admin_name ?? 'System' }}</span>
                                                </td>
                                                <td>
                                                    @if ($file->status === 'completed')
                                                        <span class="badge bg-success">Completed</span>
                                                    @elseif($file->status === 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @elseif($file->status === 'in_progress')
                                                        <span class="badge bg-info">In Progress</span>
                                                    @else
                                                        <span class="badge bg-secondary">Not Started</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="small">
                                                        {{ \Carbon\Carbon::parse($file->assigned_at)->format('d-m-Y') }}
                                                    </div>
                                                    <div class="small text-muted">
                                                        {{ \Carbon\Carbon::parse($file->assigned_at)->format('h:i A') }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-primary rounded-pill"
                                                        data-bs-toggle="modal" data-bs-target="#timelineModal"
                                                        data-id="{{ $file->id }}"
                                                        data-allottee="{{ $allottee->prefix }} {{ $allottee->allottee_name }} {{ $allottee->allottee_surname }}"
                                                        data-register-id="{{ $allottee->register_id }}"
                                                        data-property="{{ $allottee->property_number }}"
                                                        data-assigned-to="{{ $file->assignedUser->name ?? 'N/A' }}"
                                                        data-assigned-by="{{ $file->assigner->admin_name ?? 'System' }}"
                                                        data-status="{{ $file->status }}"
                                                        data-assigned-at="{{ \Carbon\Carbon::parse($file->assigned_at)->format('d-m-Y h:i A') }}"
                                                        data-completed-at="{{ $file->completed_at ? \Carbon\Carbon::parse($file->completed_at)->format('d-m-Y h:i A') : 'Not completed' }}">
                                                        <i class="bx bx-show"></i> View
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-5 text-muted">No records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Single Timeline Modal --}}
    <div class="modal fade" id="timelineModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white">
                        <i class="bx bx-timeline me-2"></i> Assignment Timeline
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="assignment_id" id="assignmentId">

                    {{-- Basic Info Table --}}
                    <table class="table table-bordered mb-4">
                        <tbody>
                            <tr>
                                <th width="35%" class="bg-light">Allottee</th>
                                <td id="modalAllottee">-</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Register ID</th>
                                <td id="modalRegisterId">-</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Property</th>
                                <td id="modalProperty">-</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Assigned To</th>
                                <td id="modalAssignedTo">-</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Assigned By</th>
                                <td id="modalAssignedBy">-</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Assigned At</th>
                                <td id="modalAssignedAt">-</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Completed At</th>
                                <td id="modalCompletedAt">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('timelineModal');
            // When modal opens, populate data
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');
                const allottee = button.getAttribute('data-allottee');
                const registerId = button.getAttribute('data-register-id');
                const property = button.getAttribute('data-property');
                const assignedTo = button.getAttribute('data-assigned-to');
                const assignedBy = button.getAttribute('data-assigned-by');
                const status = button.getAttribute('data-status');
                const assignedAt = button.getAttribute('data-assigned-at');
                const completedAt = button.getAttribute('data-completed-at');


                // Set values in modal
                document.getElementById('assignmentId').value = id;
                document.getElementById('modalAllottee').innerText = allottee;
                document.getElementById('modalRegisterId').innerText = registerId;
                document.getElementById('modalProperty').innerText = property;
                document.getElementById('modalAssignedTo').innerHTML =
                    '<i class="bx bx-user text-primary me-1"></i> ' + assignedTo;
                document.getElementById('modalAssignedBy').innerHTML =
                    '<i class="bx bx-user-check text-success me-1"></i> ' + assignedBy;
                document.getElementById('modalAssignedAt').innerHTML =
                    '<i class="bx bx-calendar me-1"></i> ' + assignedAt;
                document.getElementById('modalCompletedAt').innerHTML =
                    '<i class="bx bx-check-circle me-1"></i> ' + completedAt;
            });
        });
    </script>
@endsection
