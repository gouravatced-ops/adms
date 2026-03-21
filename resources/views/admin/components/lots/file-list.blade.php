@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Lot Files List / {{ $Lots }} : {{ $registerNo }}</span>
        </h6>

        <div class="card mb-4">
            <div class="card-header bg-info d-flex justify-content-between align-items-center">
                <h5 class="text-white mb-0">Lot Files for Assign</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-dark btn-sm" id="selectAllEven">Select All Even</button>
                    &nbsp;
                    <button type="button" class="btn btn-dark btn-sm" id="selectAllOdd">Select All Odd</button>
                    &nbsp;
                    <button type="button" class="btn btn-danger btn-sm" id="clearAllBtn">
                        Clear All
                    </button>
                    &nbsp;
                    <button type="button" class="btn btn-light btn-sm">
                        <a href="{{ route('admin.lots.aasign.index', ['page' => $pageNo]) }}">
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

                {{-- Bulk Assign Button --}}
                <div class="mb-3">
                    <button type="button" class="btn btn-primary" id="bulkAssignBtn" disabled>
                        <i class="bx bx-user-plus"></i> Assign Selected
                    </button>
                    <span class="text-muted ms-2" id="selectedCount">0 items selected</span>
                </div>

                <div class="table-responsive">
                    <table id="adminListTable1" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="40">
                                    <input type="checkbox" class="form-check-input" id="selectAllCheckbox">
                                </th>
                                <th>Sl. no.</th>
                                <th>Allottee & Property</th>
                                <th>Division Details</th>
                                <th>Property Details</th>
                                <th>Remarks</th>
                                <th>Dates</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($files as $key => $item)
                                @php
                                    // Parse JSON pages data if exists
                                    $pagesData = json_decode($item->json_pages, true);
                                    $totalPages = $item->total_pages ?? 0;
                                    $fileCount = $item->no_of_files ?? 1;

                                    // Format property details
                                    $propertyType = $item->property_type->name ?? 'Plot';
                                    $quarterInfo = $item->quarter_type->quarter_code ?? 'MIG';

                                    // Format allottee name
                                    $allotteeName = trim(
                                        ($item->prefix ?? '') .
                                            ' ' .
                                            ($item->allottee_name ?? '') .
                                            ' ' .
                                            ($item->allottee_middle_name ?? '') .
                                            ' ' .
                                            ($item->allottee_surname ?? ''),
                                    );
                                @endphp
                                <tr class="{{ $item->highlighted ? 'table-warning' : '' }}"
                                    data-row-id="{{ $item->id }}">
                                    <td>
                                        <input type="checkbox" class="form-check-input row-checkbox"
                                            value="{{ $item->id }}">
                                    </td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $allotteeName ?: 'N/A' }}</div>
                                        <small class="text-muted d-block">Property No:
                                            {{ $item->property_number ?? 'C-52' }}</small>
                                        <small class="text-muted d-block">No. of Files: {{ $fileCount }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $item->division->name ?? 'Ranchi Division' }}</div>
                                        <small class="text-muted d-block">Sub Division:
                                            {{ $item->sub_division->name ?? 'Harnu-Ranchi' }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $item->property_category->name ?? 'Residential' }} – Plot</div>
                                        <small class="text-muted d-block">Quarter: {{ $quarterInfo }}</small>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-warning text-dark">{{ $item->remarks ?? 'Partial Fresh and Old Pages' }}</span>
                                    </td>
                                    <td>
                                        {{ formatDateTime($item->updated_at ?? now()) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No Lots Found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($files->hasPages())
                        <div class="p-4 border-top">
                            {{ $files->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Files Modal -->
    <div class="modal fade" id="assignFilesModal" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding-top: 12px;padding-bottom: 12px;">
                    <h5 class="modal-title" style="color: #ffffff !important;">Assign Selected Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('admin.lots.assign.partial') }}" id="assignForm">
                    @csrf

                    <div class="modal-body">
                        <input type="hidden" name="file_ids" id="file_ids">
                        <input type="hidden" name="lots_id" id="lots_id" value="{{ $registerId }}">

                        <div id="bulkLotInfo">
                            <div class="alert alert-info">
                                <i class="bx bx-info-circle"></i>
                                <span id="bulkCount"></span> file(s) will be assigned to the selected user.
                            </div>
                        </div>

                        {{-- User Selection --}}
                        <div class="mb-3">
                            <label class="form-label">Assign To User</label>
                            <select name="assigned_to" class="form-select" required>
                                <option value="">-- Select User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ ucfirst($user->role) }})
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
                            <i class="bx bx-check"></i> Assign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get modal element
            const assignModalElement = document.getElementById('assignFilesModal');
            const assignModal = assignModalElement ? new bootstrap.Modal(assignModalElement) : null;

            // Checkbox selection handling
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');
            const bulkAssignBtn = document.getElementById('bulkAssignBtn');
            const selectedCountSpan = document.getElementById('selectedCount');

            // Safety check - if elements don't exist, exit
            if (!selectAllCheckbox || !bulkAssignBtn || !selectedCountSpan) {
                console.warn('Required elements not found');
                return;
            }

            // Select All Even button
            const selectAllEvenBtn = document.getElementById('selectAllEven');
            if (selectAllEvenBtn) {
                selectAllEvenBtn.addEventListener('click', function() {
                    rowCheckboxes.forEach((checkbox, index) => {
                        if ((index + 1) % 2 === 0) { // Even rows (1-based index)
                            checkbox.checked = true;
                        } else {
                            checkbox.checked = false;
                        }
                    });
                    updateSelectedCount();
                    updateSelectAllCheckbox();
                });
            }

            // Select All Odd button
            const selectAllOddBtn = document.getElementById('selectAllOdd');
            if (selectAllOddBtn) {
                selectAllOddBtn.addEventListener('click', function() {
                    rowCheckboxes.forEach((checkbox, index) => {
                        if ((index + 1) % 2 === 1) { // Odd rows (1-based index)
                            checkbox.checked = true;
                        } else {
                            checkbox.checked = false;
                        }
                    });
                    updateSelectedCount();
                    updateSelectAllCheckbox();
                });
            }

            // Clear All button
            const clearAllBtn = document.getElementById('clearAllBtn');
            if (clearAllBtn) {
                clearAllBtn.addEventListener('click', function() {
                    rowCheckboxes.forEach(cb => cb.checked = false);
                    updateSelectedCount();
                    updateSelectAllCheckbox();
                });
            }

            // Select All checkbox
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    rowCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateSelectedCount();
                });
            }

            // Individual row checkboxes
            rowCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedCount();
                    updateSelectAllCheckbox();
                });
            });

            // Update selected count and bulk button state
            function updateSelectedCount() {
                const selected = document.querySelectorAll('.row-checkbox:checked');
                const count = selected.length;
                selectedCountSpan.textContent = count + ' item' + (count !== 1 ? 's' : '') + ' selected';
                bulkAssignBtn.disabled = count === 0;
            }

            // Update select all checkbox state
            function updateSelectAllCheckbox() {
                if (!selectAllCheckbox) return;

                const total = rowCheckboxes.length;
                const checked = document.querySelectorAll('.row-checkbox:checked').length;

                if (checked === 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                } else if (checked === total) {
                    selectAllCheckbox.checked = true;
                    selectAllCheckbox.indeterminate = false;
                } else {
                    selectAllCheckbox.indeterminate = true;
                }
            }

            // Bulk assign button click
            if (bulkAssignBtn) {
                bulkAssignBtn.addEventListener('click', function() {
                    const selected = document.querySelectorAll('.row-checkbox:checked');
                    const selectedIds = Array.from(selected).map(cb => cb.value);

                    if (selectedIds.length === 0 || !assignModal) return;

                    // Set the file IDs in the modal
                    const fileIdsInput = document.getElementById('file_ids');
                    if (fileIdsInput) {
                        fileIdsInput.value = selectedIds.join(',');
                    }

                    // Update bulk count
                    const bulkCountSpan = document.getElementById('bulkCount');
                    if (bulkCountSpan) {
                        bulkCountSpan.textContent = selectedIds.length;
                    }

                    // Show the modal
                    assignModal.show();
                });
            }

            // Reset modal when hidden
            if (assignModalElement) {
                assignModalElement.addEventListener('hidden.bs.modal', function() {
                    const form = document.getElementById('assignForm');
                    if (form) form.reset();
                });
            }

            // Initial count update
            updateSelectedCount();
        });
    </script>
@endsection

@push('styles')
    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.35em 0.65em;
        }

        .btn-group .btn {
            margin-left: 5px;
        }

        #selectedCount {
            font-size: 0.9rem;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
    </style>
@endpush
