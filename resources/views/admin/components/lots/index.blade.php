@extends('admin.layouts.main')

@section('admin-content')
    @php
        #return getDebugIndex($registrations);
        $currentPage = request()->get('page', 1);
    @endphp
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Lots List</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Lots for Assigne</h5>

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

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <h5 class="mb-0">Lot Assignment List</h5>

                            <ul class="nav nav-pills gap-2" id="assignmentTabs">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active assignment-tab"
                                        data-status="not_assigned">
                                        Not Assigned
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link assignment-tab" data-status="partially_assigned">
                                        Partial Assigned
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link assignment-tab" data-status="fully_assigned">
                                        Fully Assigned
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link assignment-tab" data-status="all">
                                        All
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @php
                        #return getDebugIndex($registrations);
                    @endphp
                    <div class="table-responsive">
                        <table id="adminListTable1" class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Register No</th>
                                    <th>Lot No</th>
                                    <th>Total Files</th>
                                    <th>Assigned</th>
                                    <th>Remaining</th>
                                    <th>Division</th>
                                    <th>Scanned By</th>
                                    <th>Assignment Status</th>
                                    <th>Scanned On</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody id="assignmentTableBody">
                                @forelse ($registrations as $key => $item)
                                    @php
                                        $assignmentStatus = $item->assignment_status ?? 'not_assigned';
                                        $isLocked = in_array($assignmentStatus, ['full_lot', 'fully_assigned']);
                                    @endphp

                                    <tr class="assignment-row {{ !empty($item->highlighted) ? 'table-warning' : '' }}"
                                        data-status="{{ in_array($assignmentStatus, ['full_lot', 'fully_assigned']) ? 'fully_assigned' : $assignmentStatus }}">

                                        <td>{{ $registrations->firstItem() + $key }}</td>

                                        <td class="fw-semibold">
                                            {{ $item->register_no }}
                                        </td>

                                        <td>
                                            <span class="badge bg-primary">{{ $item->lot_no }}</span>
                                        </td>

                                        <td>
                                            <span class="fw-semibold">{{ $item->total_files ?? 0 }}</span>
                                        </td>

                                        <td>
                                            <span class="badge bg-success">{{ $item->total_assigned_files ?? 0 }}</span>
                                        </td>

                                        <td>
                                            <span class="badge bg-danger">{{ $item->remaining_files ?? 0 }}</span>
                                        </td>

                                        <td>
                                            {{ getDivisionName($item->division_id) ?? 'N/A' }}
                                        </td>

                                        <td>{{ $item->scanned_named_by ?? 'System' }}</td>

                                        <td>
                                            @if (in_array($assignmentStatus, ['fully_assigned', 'full_lot']))
                                                <span class="badge bg-success">Fully Assigned</span>
                                            @elseif ($assignmentStatus === 'partially_assigned')
                                                <span class="badge bg-warning text-dark">Partial Assigned</span>
                                            @else
                                                <span class="badge bg-secondary">Not Assigned</span>
                                            @endif
                                        </td>

                                        <td>{{ formatDateTime($item->updated_at) }}</td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                @if ($isLocked)
                                                    <button type="button" class="btn btn-sm btn-primary" disabled
                                                        title="Already fully assigned">
                                                        <i class="bx bx-layer"></i>
                                                    </button>
                                                @else
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-sm btn-primary openAssignModal"
                                                        data-id="{{ $item->id }}" data-lot="{{ $item->lot_no }}"
                                                        data-register="{{ $item->register_no }}" title="Assign Full Lot">
                                                        <i class="bx bx-layer"></i>
                                                    </a>
                                                @endif

                                                @if ($isLocked)
                                                    <button type="button" class="btn btn-sm btn-success" disabled
                                                        title="Already fully assigned">
                                                        <i class="bx bx-list-check"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('admin.lots.assign.file.index', [$item->encoded_register_no, 'page' => request('page', 1)]) }}"
                                                        class="btn btn-sm btn-success" title="Assign Files">
                                                        <i class="bx bx-list-check"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('admin.lots.assign.userlist', base64_encode($item->id)) }}"
                                                    class="btn btn-sm btn-info" title="Assigned User List">
                                                    <i class="bx bx-user-check"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="noDataRow">
                                        <td colspan="10" class="text-center text-muted">
                                            No Lots Found.
                                        </td>
                                    </tr>
                                @endforelse

                                <tr id="filteredEmptyRow" style="display: none;">
                                    <td colspan="10" class="text-center text-muted">
                                        No records found for selected tab.
                                    </td>
                                </tr>
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
    </div>

    <!-- Assign Lot Modal -->
    <div class="modal fade" id="assignLotModal" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header bg-primary" style="padding-top: 12px;padding-bottom: 12px;">
                    <h5 class="modal-title" style="color: #ffffff !important;">Assign Full Lot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('admin.lots.assign.store') }}">
                    @csrf

                    <div class="modal-body">

                        {{-- Hidden Lot ID --}}
                        <input type="hidden" name="lot_id" id="lot_id">

                        {{-- Lot Info --}}
                        <div class="mb-3">
                            <label class="form-label">Register No</label>
                            <input type="text" id="register_no" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lot No</label>
                            <input type="text" id="lot_no" class="form-control" readonly>
                        </div>

                        {{-- User Selection --}}
                        <div class="mb-3">
                            <label class="form-label">Assign To User</label>
                            <select name="assigned_to" class="form-select" required>
                                <option value="">-- Select User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check"></i> Assign Lot
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <style>
        #assignmentTabs .nav-link {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 14px;
            color: #495057;
            background: #f1f3f5;
            border: 1px solid #e9ecef;
        }

        #assignmentTabs .nav-link.active {
            background: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
        }

        #assignmentTabs .nav-link:hover {
            background: #e9ecef;
            color: #212529;
        }

        #assignmentTabs .nav-link.active:hover {
            background: #0d6efd;
            color: #fff;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const modal = new bootstrap.Modal(document.getElementById('assignLotModal'));

            document.querySelectorAll('.openAssignModal').forEach(btn => {
                btn.addEventListener('click', function() {

                    document.getElementById('lot_id').value = this.dataset.id;
                    document.getElementById('lot_no').value = this.dataset.lot;
                    document.getElementById('register_no').value = this.dataset.register;

                    modal.show();
                });
            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.assignment-tab');
            const rows = document.querySelectorAll('.assignment-row');
            const filteredEmptyRow = document.getElementById('filteredEmptyRow');
            const noDataRow = document.getElementById('noDataRow');

            function filterRows(status) {
                let visibleCount = 0;

                rows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status');

                    if (status === 'all' || rowStatus === status) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (filteredEmptyRow) {
                    filteredEmptyRow.style.display = visibleCount === 0 && rows.length > 0 ? '' : 'none';
                }

                if (noDataRow && rows.length > 0) {
                    noDataRow.style.display = 'none';
                }
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const status = this.getAttribute('data-status');
                    filterRows(status);
                });
            });

            filterRows('not_assigned');
        });
    </script>
@endsection
