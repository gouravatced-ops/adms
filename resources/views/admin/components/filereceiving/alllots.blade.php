@extends('admin.layouts.main')

@section('admin-content')
<div class="container-xxl flex-grow-1">
    <h6 class="py-3 mb-2">
        <span class="invert-text-white">Dashboard / All Lots</span>
    </h6>

    <div class="card mb-4">
        <h5 class="card-header text-white bg-info">All Lots</h5>

        <div class="card-body mt-2">
            @php
            #return getDebugIndex($registrations);
            @endphp
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
                <table id="allLotsListTable" class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="white-space: nowrap;">Sl. No.</th>
                            <th style="white-space: nowrap;">Register No</th>
                            <th style="white-space: nowrap;">Lot No</th>
                            <th style="white-space: nowrap;">Total Files</th>
                            <th style="white-space: nowrap;">Allowed Files</th>
                            <th style="white-space: nowrap;">Division</th>
                            <th style="white-space: nowrap;">Created By</th>
                            <th style="white-space: nowrap;">Current Stage</th>
                            <th style="white-space: nowrap;">Created On</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @php
                    #getDebugIndex($registrations);
                    @endphp
                    <tbody>
                        @forelse ($registrations as $key => $item)
                        <tr class="{{ $item->highlighted ? 'table-warning' : '' }}">

                            <td>{{ $key + 1 }}</td>

                            <td class="fw-semibold">
                                {{ $item->register_no }}
                            </td>

                            <td>
                                <a
                                    href="javascript:void(0)" onclick="promptExportLimit('{{ route('admin.receiving.files.exports', ['registerId' => base64_encode($item->register_no)]) }}')">
                                    <span class="badge bg-primary">{{ $item->lot_no }}</span>
                                </a>
                            </td>

                            <td>{{ $item->total_received_files }}</td>

                            <td>
                                <span class="badge bg-info">{{ $item->allowed_files }}</span>
                            </td>

                            <td>
                                {{ getDivisionName($item->division_id) }}
                            </td>

                            <td>{{ $item->created_named_by }}</td>

                            <td>
                                <span class="badge bg-{{ $item->badge_color }}">{{ $item->current_stage }}</span>
                            </td>

                            <td>
                                {{ formatDate($item->created_at) }}
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-nowrap">
                                    <a href="{{ route('admin.manage.lots.file.index', ['encodedId' => $item->encoded_register_no, 'page' => 1]) }}"
                                        class="btn btn-primary btn-sm text-white" title="View Lot Files">
                                        <!-- Custom List/File SVG Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M8 6h13"></path>
                                            <path d="M8 12h13"></path>
                                            <path d="M8 18h13"></path>
                                            <path d="M3 6h.01"></path>
                                            <path d="M3 12h.01"></path>
                                            <path d="M3 18h.01"></path>
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" onclick="promptExportLimit('{{ route('admin.receiving.files.exports', ['registerId' => base64_encode($item->register_no)]) }}')"
                                        class="btn btn-danger btn-sm text-white" title="Export Lot PDF">
                                        <!-- PDF File with Download Arrow SVG -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">

                                            <!-- File Shape -->
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <path d="M14 2v6h6"></path>

                                            <!-- Download Arrow -->
                                            <path d="M12 11v6"></path>
                                            <path d="M9.5 14.5L12 17l2.5-2.5"></path>

                                            <!-- Bottom Line -->
                                            <path d="M8 20h8"></path>
                                        </svg>
                                    </a>
                                    @if($item->deleted_count > 0)
                                    <a href="{{ route('admin.deleted.lots.file.index', ['encodedId' => $item->encoded_register_no, 'page' => 1]) }}"
                                        class="btn btn-warning btn-sm text-dark d-flex align-items-center gap-1 px-2" title="History of delete allottee">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 3v18h18" />
                                            <path d="M8 14l3-3 4 4 6-6" />
                                            <path d="M21 9v6h-6" />
                                        </svg>
                                        <span class="badge bg-danger rounded-pill px-1">{{ $item->deleted_count }}</span>
                                    </a>
                                    @endif

                                    <button type="button" class="btn btn-info btn-sm text-white" title="Edit Lot"
                                        onclick="openEditLotModal('{{ $item->encoded_register_no }}', '{{ $item->allowed_files }}', '{{ $item->status }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                No Lots Found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Lot Modal -->
<div class="modal fade" id="editLotModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editLotForm" method="POST" action="{{ route('admin.manage.lots.update') }}">
                @csrf
                <input type="hidden" name="encoded_id" id="editLotId">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Lot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editAllowedFiles" class="form-label">Allowed Files</label>
                        <input type="number" class="form-control" id="editAllowedFiles" name="allowed_files" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-select" id="editStatus" name="status" required>
                            <option value="received">Received</option>
                            <option value="scanned">Scanned</option>
                            <option value="dataentry">Data Entry</option>
                            <option value="handover">Handover</option>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditLotModal(encodedId, allowedFiles, status) {
        document.getElementById('editLotId').value = encodedId;
        document.getElementById('editAllowedFiles').value = allowedFiles;

        let statusSelect = document.getElementById('editStatus');
        let statusOptions = Array.from(statusSelect.options).map(opt => opt.value);

        // If the status is not in the list, add it dynamically
        if (!statusOptions.includes(status) && status) {
            let newOption = new Option(status.charAt(0).toUpperCase() + status.slice(1), status);
            statusSelect.add(newOption);
        }

        document.getElementById('editStatus').value = status;

        var myModal = new bootstrap.Modal(document.getElementById('editLotModal'));
        myModal.show();
    }

    function promptExportLimit(url) {
        let limit = prompt("Enter row limit for PDF (min: 12, max: 20)", "12");
        if (limit !== null) {
            let parsedLimit = parseInt(limit, 10);
            if (isNaN(parsedLimit) || parsedLimit < 12 || parsedLimit > 20) {
                alert("Please enter a valid limit between 12 and 20.");
                return;
            }
            window.location.href = url + '?limit=' + parsedLimit;
        }
    }
</script>
@endsection
