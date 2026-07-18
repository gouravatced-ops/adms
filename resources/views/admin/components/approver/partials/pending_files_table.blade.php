@if ($files->count() > 0)
    <table id="allLotsListTable" class="table table-striped table-bordered align-middle">
        <thead class="table-light">
            <tr>
                @if (auth('admin')->user()->role == 'divisional_admin')
                    <th width="40">#</th>
                @endif
                <th>Sl. no.</th>
                <th style="width:25%;">Allottee & Property</th>
                <th>Division / Property Details</th>
                <th>Checked On</th>
                <th>Current Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($files as $key => $item)
                @php
                    $pagesData = json_decode($item->json_pages, true);
                    $totalPages = $item->total_pages ?? 0;
                    $fileCount = $item->no_of_files ?? 1;
                    $propertyType = $item->propertyType->name ?? 'N/A';
                    $quarterInfo = $item->quarterType->quarter_code ?? 'N/A';
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
                <tr class="{{ $item->highlighted ? 'table-warning' : '' }}" data-row-id="{{ $item->id }}">
                    @if (auth('admin')->user()->role == 'divisional_admin')
                        <td>
                            <input type="checkbox" class="form-check-input row-checkbox" value="{{ $item->encodedId }}">
                        </td>
                    @endif
                    <td>{{ $files->firstItem() + $key }}</td>
                    <td>
                        @php
                            $allotteePosition = \App\Models\Allottee::where('property_number', $item->property_number)
                                ->where(function ($q) use ($item) {
                                    $q->where('id', $item->id)
                                        ->orWhere('parent_id', $item->parent_id)
                                        ->orWhere('id', $item->parent_id);
                                })
                                ->orderBy('id')
                                ->pluck('id')
                                ->search($item->id);
                            $position = $allotteePosition !== false ? $allotteePosition + 1 : null;
                            $originalAllottee = trim(
                                ($item->parent->prefix ?? '') .
                                    ' ' .
                                    ($item->parent->allottee_name ?? '') .
                                    ' ' .
                                    ($item->parent->allottee_middle_name ?? '') .
                                    ' ' .
                                    ($item->parent->allottee_surname ?? ''),
                            );
                        @endphp

                        @php
                            $badges = [];
                            $isTransferFile = !is_null($item->parent_id);
                            $maxStep = $isTransferFile ? 4 : 6;

                            if ($isTransferFile && $item->parent && $originalAllottee) {
                                $badges[] = [
                                    'text' => 'Previous: ' . $originalAllottee,
                                    'class' => 'bg-warning text-dark border',
                                ];
                            }

                            if (blank($item->allottee_document_path)) {
                                $badges[] = ['text' => 'Document Not Uploaded', 'class' => 'bg-dark'];
                            }

                            if (
                                (int) ($item->current_step ?? 0) >= $maxStep &&
                                (int) ($item->is_step_completed ?? 0) === 1
                            ) {
                                $badges[] = ['text' => 'Completed', 'class' => 'bg-success'];
                            } else {
                                $badges[] = ['text' => 'Incomplete', 'class' => 'bg-danger'];
                                $badges[] = [
                                    'text' => 'Step ' . ($item->current_step ?? 0) . '/' . $maxStep,
                                    'class' => 'bg-secondary',
                                ];
                            }

                            if (!empty($item->is_emi_active) && $item->is_emi_active == 'true') {
                                $badges[] = ['text' => 'Active EMI', 'class' => 'bg-info text-white'];
                            }

                            if (strtolower($item->name_transfer_status ?? '') === 'yes') {
                                $badges[] = ['text' => 'Name Transfer', 'class' => 'bg-danger'];
                                if ((int) ($item->is_trans_entry_completed ?? 0) === 0) {
                                    $badges[] = ['text' => 'Transfer Incomplete', 'class' => 'bg-warning text-dark'];
                                }
                            }

                            if (strtolower($item->free_hold_status ?? '') === 'yes') {
                                $badges[] = ['text' => 'Lease Free Hold', 'class' => 'bg-success'];
                                if ((int) ($item->is_free_hold_completed ?? 0) === 0) {
                                    $badges[] = ['text' => 'Free Hold Incomplete', 'class' => 'bg-warning text-dark'];
                                }
                            }

                            if ($position) {
                                $badges[] = [
                                    'text' =>
                                        $position .
                                        ($position == 1
                                            ? 'st'
                                            : ($position == 2
                                                ? 'nd'
                                                : ($position == 3
                                                    ? 'rd'
                                                    : 'th'))) .
                                        ' Allottee',
                                    'class' => 'bg-primary',
                                ];
                            }
                        @endphp
                        <div class="fw-semibold">
                            <a href="{{ route('admin.file.preview', encrypt($item->id)) }}" style="color:blue;"
                                title="Preview {{ $allotteeName }} File" data-bs-toggle="tooltip">
                                {{ $allotteeName ?: 'N/A' }}
                            </a>
                            @if ($item->divisional_approval == 1)
                                <span class="status-completed" title="Divisional Approved">✓</span>
                            @elseif($item->divisional_approval == 0)
                                <span class="status-pending" title="Divisional Approval Pending">
                                    <i class="bx bx-hourglass bx-tada" style="font-size: 10px;"></i>
                                </span>
                            @elseif($item->divisional_approval === 2)
                                <span class="status-rejected" title="Divisional Approval Rejected">✗</span>
                            @endif
                        </div>
                        <span class="d-block"><u>Property No: <b>{{ $item->property_number ?? 'N/A' }}</b></u></span>
                        <span class="d-block">No. of Scanned Pages: {{ $fileCount }}</span>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach ($badges as $badge)
                                <span class="badge {{ $badge['class'] }}">{{ $badge['text'] }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div><b>{{ $item->division->name ?? 'N/A' }}</b></div>
                        <div>Sub Division: <b>{{ $item->subDivision->name ?? 'N/A' }}</b></div>
                        <div>Property No: <b>{{ $item->property_number ?? 'N/A' }}</b></div>
                        <hr>
                        <div><b>{{ $item->propertyCategory->name ?? 'N/A' }} – {{ $propertyType }}</b></div>
                        <div class="d-block">Quarter: <b>{{ $quarterInfo }}</b></div>
                    </td>
                    <td>{{ formatDateTime($item->sub_admin_checked_date ?? '-') }}</td>
                    <td><span class="pending-time" data-date="{{ $item->sub_admin_checked_date }}"></span></td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            @php
                                $isCouncilOffice = auth('admin')->user()->role === 'council_office';
                                $label = $isCouncilOffice ? 'View File' : 'View More';
                                $btnColor = $isCouncilOffice ? 'btn-primary' : 'btn-danger';
                            @endphp
                            <a href="{{ route('admin.file.preview', encrypt($item->id)) }}"
                                class="btn btn-sm {{ $btnColor }} text-white"
                                title="{{ $label }} of {{ $allotteeName }} File" data-bs-toggle="tooltip">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                &nbsp; {{ $label }}
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No Lots Files Found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($files->hasPages())
        <div class="p-4 border-top">
            {{ $files->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
    @endif
@else
    <div class="text-center py-5">
        <i class="bx bx-folder-open" style="font-size: 48px; color: #ccc;"></i>
        <h5 class="mt-3 text-muted">No files found matching your criteria</h5>
    </div>
@endif

<script>
    // Reinitialize pending times after AJAX load
    if (typeof updatePendingTimes === 'function') {
        updatePendingTimes();
        setInterval(updatePendingTimes, 1000);
    }
</script>
