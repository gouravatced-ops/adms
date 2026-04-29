@extends('applicant.dashboard_layouts.main')

@section('title', 'Completed Transfer Name – Files')

@section('content')
@if (session('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if (session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@php
#return getDebugIndex($divisions);
@endphp
<div class="card" style="box-shadow:none;">
    <div class="compact-card overflow-hidden">
        <!-- Header with Search -->
        <div class="p-4 border-b" style="border-color: var(--gray-border);">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                        <i class="fas fa-folder-open"></i>
                        Data Entry >> Name Transfer Completed Allottee List
                    </h3>
                    <p class="text-xs text-muted mt-1">Current allottees pending data entry with their transfer history
                    </p>
                </div>
            </div>

            <!-- Search Box with Filters -->
            {{-- <div class="search-container" style="margin-top: 10px;">
                    <div class="row" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-end;">
                        <div class="col" style="flex: 1; min-width: 200px;">
                            <label style="font-size: 1rem; color: #6c757d; margin-bottom: 4px; display: block;">Search
                                Allottee</label>
                            <input type="text" id="searchAllottee" class="form-control search-input"
                                placeholder="Search by name, application no, register id..." style="padding: 8px 12px;"
                                autocomplete="off">
                        </div>

                        <div class="col" style="flex: 1; min-width: 150px;">
                            <label style="font-size: 1rem; color: #6c757d; margin-bottom: 4px; display: block;">Property
                                No</label>
                            <input type="text" id="searchPropertyNo" class="form-control search-input"
                                placeholder="Search property number..." style="padding: 8px 12px;" autocomplete="off">
                        </div>

                        <div class="col" style="flex: 1; min-width: 150px;">
                            <label
                                style="font-size: 1rem; color: #6c757d; margin-bottom: 4px; display: block;">Division</label>
                            <select id="searchDivision" class="form-control search-select" style="padding: 8px 12px;">
                                <option value="">All Divisions</option>
                                @if (isset($divisions) && $divisions->count())
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->name }}">{{ $division->name }}</option>
            @endforeach
            @endif
            </select>
        </div>

        <div class="col" style="width: auto;">
            <button id="searchButton" class="btn"
                style="padding: 8px 16px; white-space: nowrap; background:linear-gradient(135deg, #3b82f6, #2563eb) !important; color:white;">
                <i class="fas fa-search"></i> Search
            </button>
            <button id="clearSearch" class="btn btn-secondary"
                style="padding: 8px 16px; white-space: nowrap; display: none;">
                <i class="fas fa-times"></i> Clear
            </button>
        </div>
    </div>
</div> --}}
</div>

<!-- Loading Indicator -->
<div id="loadingIndicator" style="display: none; text-align: center; padding: 20px;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <p style="margin-top: 10px; color: #6c757d;">Loading data...</p>
</div>

<!-- Table -->
<div class="table-responsive">
    <table id="transferTable" class="table table-striped table-bordered align-middle w-full">
        <thead style="background: linear-gradient(135deg, #3b82f6, #2563eb) !important;">
            <tr>
                <th width="50">Sl. no.</th>
                <th>Allottee & Property</th>
                <th>Division Details</th>
                <th>Property Details</th>
                <th>Transfer Chain</th>
                <th>Dates</th>
                <th width="80">Action</th>
            </tr>
        </thead>

        <tbody id="tableBody">
            @forelse ($transferAllottee as $key => $currentAllottee)
            @php
            // Calculate transfer chain count
            $transferCount = 0;
            $parentAllottee = $currentAllottee->parent;
            $grandParentAllottee = null;
            $hasGrandParent = false;

            if ($parentAllottee) {
            $transferCount++;
            if ($parentAllottee->parent) {
            $transferCount++;
            $grandParentAllottee = $parentAllottee->parent;
            $hasGrandParent = true;
            }
            }

            $hasParent = !is_null($currentAllottee->parent_id);
            $rowId = "row-{$currentAllottee->id}";
            $parentRowId = "parent-{$currentAllottee->id}";
            $grandParentRowId = "grandparent-{$currentAllottee->id}";
            @endphp

            <!-- Current Allottee Row (Main Row) -->
            <tr id="{{ $rowId }}" class="hierarchical-row level-0 current-row"
                data-id="{{ $currentAllottee->id }}">
                <td>
                    {{ $key + 1 }}
                </td>
                <td>
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center flex-wrap">
                            <strong class="fw-semibold" style="color:#28a745;">
                                <span class="allottee-name">{{ $currentAllottee->prefix }}
                                    {{ $currentAllottee->allottee_name }}
                                    {{ $currentAllottee->allottee_middle_name }}
                                    {{ $currentAllottee->allottee_surname }}</span>
                                @if ($hasParent && $parentAllottee)
                                <span class="expand-icon"
                                    onclick="toggleParent({{ $currentAllottee->id }})">
                                    <i class="fas fa-plus-circle"></i>
                                </span>
                                @endif
                            </strong>
                            <span class="badge-current ms-2">Current Allottee</span>
                            @if ($transferCount > 0)
                            <span class="badge-transfer-count ms-2">
                                <i class="fas fa-exchange-alt"></i> {{ $transferCount }}
                                Transfer{{ $transferCount > 1 ? 's' : '' }}
                            </span>
                            @endif
                        </div>
                        <span class="text-muted mt-1">
                            <strong>Property No: </strong><span
                                class="property-number">{{ $currentAllottee->property_number }}</span>
                        </span>
                        <div class="mt-1">
                            @if ($currentAllottee->application_no)
                            <span class="text-muted"><strong>App No:</strong>
                                {{ $currentAllottee->application_no }}</span><br>
                            @endif
                            @if ($currentAllottee->allotment_no)
                            <span class="text-muted"><strong>Allotment No:</strong>
                                {{ $currentAllottee->allotment_no }}</span>
                            @endif
                        </div>
                        @if ($currentAllottee->is_emi_active == 'true')
                        <span class="custom-badge badge-info mt-1">EMI Active</span>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="d-flex flex-column">
                        <span class="text-muted"><strong>Division:
                            </strong>{{ $currentAllottee->division->name ?? ($currentAllottee->dname ?? 'N/A') }}</span>
                        <span class="text-muted"><strong>Sub Division:</strong>
                            {{ $currentAllottee->subDivision->name ?? ($currentAllottee->subname ?? 'N/A') }}</span>
                    </div>
                </td>
                <td>
                    <div class="d-flex flex-column">
                        <span><strong>{{ $currentAllottee->propertyCategory->name ?? ($currentAllottee->cname ?? 'N/A') }}</strong>
                            –
                            {{ $currentAllottee->propertyType->name ?? ($currentAllottee->pname ?? 'N/A') }}</span>
                        <span class="text-muted"><strong>Quarter:</strong>
                            <span>{{ $currentAllottee->quarterType->quarter_code ?? ($currentAllottee->quarter_code ?? 'N/A') }}</span></span>
                    </div>
                </td>
                <td>
                    @if ($hasParent && $parentAllottee)
                    <div class="transfer-chain">
                        <span class="text-primary">
                            <i class="fas fa-arrow-right"></i> Transferred from:
                        </span>
                        <strong class="text-dark">{{ $parentAllottee->prefix }}
                            {{ $parentAllottee->allottee_name }}
                            {{ $parentAllottee->allottee_surname }}</strong>
                        @if ($hasGrandParent && $grandParentAllottee)
                        <br>
                        <span class="text-muted ms-3">
                            <i class="fas fa-arrow-left"></i> Originally from:
                            <strong>{{ $grandParentAllottee->prefix }}
                                {{ $grandParentAllottee->allottee_name }}
                                {{ $grandParentAllottee->allottee_surname }}</strong>
                        </span>
                        @endif
                    </div>
                    @else
                    <span class="text-muted">Original allottee</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex flex-column">
                        {{ \Carbon\Carbon::parse($currentAllottee->created_at)->format('d M Y') }}
                        @if ($hasParent && $parentAllottee)
                        <span class="text-muted">Transfer:
                            {{ \Carbon\Carbon::parse($parentAllottee->updated_at)->format('d M Y') }}</span>
                        @endif
                    </div>
                </td>
                <td class="py-2">
                    <div class="flex gap-2">
                        {{-- {{ route('nametransfer.incomplete.apply.index', encrypt($currentAllottee->id)) }} --}}
                        <a href="{{ route('nametransfer.incomplete.apply.index', encrypt($currentAllottee->id)) }}" class="action-btn action-btn-info" title="Data Entry">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="14" height="18" rx="2"></rect>
                                <path d="M6 7h8"></path>
                                <path d="M6 11h6"></path>
                                <path d="M6 15h4"></path>
                                <circle cx="18" cy="17" r="4"></circle>
                                <path d="M18 15v4"></path>
                                <path d="M16 17h4"></path>
                            </svg>
                        </a>
                        <a href="{{ route('nametransfer.documents.upload', encrypt($currentAllottee->id)) }}"
                            class="action-btn action-btn-warning" title="View Documents">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">

                                <!-- File -->
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>

                                <!-- Upload Arrow -->
                                <path d="M12 18V11"></path>
                                <path d="M9 14l3-3 3 3"></path>
                            </svg>
                        </a>
                        @if($currentAllottee->parent_id != NULL)
                        <a href="{{ route('applicant.nametransfer.master.file', encrypt($currentAllottee->id)) }}"
                            class="action-btn badge-not-started"
                            title="Upload Master File">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">

                                <!-- Box -->
                                <rect x="3" y="14" width="18" height="7" rx="2"></rect>

                                <!-- Arrow -->
                                <path d="M12 3v11"></path>
                                <path d="M8 7l4-4 4 4"></path>
                            </svg>
                        </a>
                        @endif
                    </div>
                </td>
            </tr>

            <!-- Parent (Previous Allottee) Row - Expandable Accordion -->
            @if ($hasParent && $parentAllottee)
            <tr id="{{ $parentRowId }}" class="child-row parent-row"
                data-parent="{{ $currentAllottee->id }}" style="display: none;">
                <td colspan="7" style="padding: 0;">
                    <table style="width: 100%; margin: 0; background-color: #f8f9fa;">
                        <tbody>
                            <tr class="hierarchical-row level-1">
                                <td style="width: 50px; padding-left: 30px;">
                                    -
                                </td>
                                <td colspan="6">
                                    <div class="d-flex flex-column p-2">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <strong class="fw-semibold" style="color:#ffc107;">
                                                <span
                                                    class="allottee-name">{{ $parentAllottee->prefix }}
                                                    {{ $parentAllottee->allottee_name }}
                                                    {{ $parentAllottee->allottee_middle_name }}
                                                    {{ $parentAllottee->allottee_surname }}</span>
                                            </strong>
                                            @if ($hasGrandParent)
                                            <span class="expand-icon"
                                                onclick="toggleGrandParent({{ $currentAllottee->id }})">
                                                <i class="fas fa-plus-circle"></i>
                                            </span>
                                            @endif
                                            <span class="badge-previous ms-2">Previous Allottee</span>
                                            <span class="badge-transfer-info ms-2">
                                                <i class="fas fa-calendar-alt"></i> Transferred Out
                                            </span>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <span class="text-muted d-block">
                                                    <strong>Property No:</strong> <span
                                                        class="property-number">{{ $parentAllottee->property_number }}</span>
                                                </span>
                                                @if ($parentAllottee->application_no)
                                                <span class="text-muted d-block mt-1">
                                                    <strong>Application No:</strong>
                                                    {{ $parentAllottee->application_no }}
                                                </span>
                                                @endif
                                                @if ($parentAllottee->allotment_no)
                                                <span class="text-muted d-block mt-1">
                                                    <strong>Allotment No:</strong>
                                                    {{ $parentAllottee->allotment_no }}
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <span class="text-muted d-block">
                                                    <strong>Division:</strong>
                                                    {{ $parentAllottee->division->name ?? ($parentAllottee->dname ?? 'N/A') }}
                                                </span>
                                                <span class="text-muted d-block mt-1">
                                                    <strong>Sub Division:</strong>
                                                    {{ $parentAllottee->subDivision->name ?? ($parentAllottee->subname ?? 'N/A') }}
                                                </span>
                                                <span class="text-muted d-block mt-1">
                                                    <strong>Quarter Type:</strong>
                                                    {{ $parentAllottee->quarterType->quarter_code ?? ($parentAllottee->quarter_code ?? 'N/A') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            @if ($parentAllottee->is_emi_active == 'true')
                                            <span class="custom-badge badge-info">EMI Active</span>
                                            @endif
                                            <span class="text-muted ms-2">
                                                <strong>Transferred On:</strong>
                                                {{ \Carbon\Carbon::parse($parentAllottee->updated_at)->format('d M Y h:i A') }}
                                            </span>
                                        </div>
                                        <div class="flex gap-2">
                                            {{-- {{ route('nametransfer.incomplete.apply.index', encrypt($parentAllottee->id)) }} --}}
                                            <a href="{{ route('nametransfer.incomplete.apply.index', encrypt($parentAllottee->id)) }}" class="action-btn action-btn-info" title="Data Entry">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <rect x="3" y="3" width="14" height="18" rx="2"></rect>
                                                    <path d="M6 7h8"></path>
                                                    <path d="M6 11h6"></path>
                                                    <path d="M6 15h4"></path>
                                                    <circle cx="18" cy="17" r="4"></circle>
                                                    <path d="M18 15v4"></path>
                                                    <path d="M16 17h4"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('nametransfer.documents.upload', encrypt($parentAllottee->id)) }}"
                                                class="action-btn action-btn-warning" title="View Documents">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">

                                                    <!-- File -->
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>

                                                    <!-- Upload Arrow -->
                                                    <path d="M12 18V11"></path>
                                                    <path d="M9 14l3-3 3 3"></path>
                                                </svg>
                                            </a>
                                            @if($parentAllottee->parent_id != NULL)
                                            <a href="{{ route('applicant.nametransfer.master.file', encrypt($parentAllottee->id)) }}"
                                                class="action-btn badge-not-started"
                                                title="Upload Master File">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">

                                                    <!-- Box -->
                                                    <rect x="3" y="14" width="18" height="7" rx="2"></rect>

                                                    <!-- Arrow -->
                                                    <path d="M12 3v11"></path>
                                                    <path d="M8 7l4-4 4 4"></path>
                                                </svg>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            @endif

            <!-- Grand Parent (First Allottee) Row - Expandable Accordion -->
            @if ($hasGrandParent && $grandParentAllottee)
            <tr id="{{ $grandParentRowId }}" class="child-row grandparent-row"
                data-parent="{{ $currentAllottee->id }}" style="display: none;">
                <td colspan="7" style="padding: 0;">
                    <table style="width: 100%; margin: 0; background-color: #f1f3f5;">
                        <tbody>
                            <tr class="hierarchical-row level-2">
                                <td style="width: 50px; padding-left: 60px;">
                                    <i class="fas fa-circle"
                                        style="font-size: 8px; color: #6c757d;"></i>
                                    -
                                </td>
                                <td colspan="6">
                                    <div class="d-flex flex-column p-2">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <strong class="fw-semibold" style="color:#6c757d;">
                                                <span
                                                    class="allottee-name">{{ $grandParentAllottee->prefix }}
                                                    {{ $grandParentAllottee->allottee_name }}
                                                    {{ $grandParentAllottee->allottee_middle_name }}
                                                    {{ $grandParentAllottee->allottee_surname }}</span>
                                            </strong>
                                            <span class="badge-first ms-2">First Allottee</span>
                                            <span class="badge-original ms-2">
                                                <i class="fas fa-star"></i> Original
                                            </span>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <span class="text-muted d-block">
                                                    <strong>Property No:</strong> <span
                                                        class="property-number">{{ $grandParentAllottee->property_number }}</span>
                                                </span>
                                                @if ($grandParentAllottee->application_no)
                                                <span class="text-muted d-block mt-1">
                                                    <strong>Application No:</strong>
                                                    {{ $grandParentAllottee->application_no }}
                                                </span>
                                                @endif
                                                @if ($grandParentAllottee->allotment_no)
                                                <span class="text-muted d-block mt-1">
                                                    <strong>Allotment No:</strong>
                                                    {{ $grandParentAllottee->allotment_no }}
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <span class="text-muted d-block">
                                                    <strong>Division:</strong>
                                                    {{ $grandParentAllottee->division->name ?? ($grandParentAllottee->dname ?? 'N/A') }}
                                                </span>
                                                <span class="text-muted d-block mt-1">
                                                    <strong>Sub Division:</strong>
                                                    {{ $grandParentAllottee->subDivision->name ?? ($grandParentAllottee->subname ?? 'N/A') }}
                                                </span>
                                                <span class="text-muted d-block mt-1">
                                                    <strong>Quarter Type:</strong>
                                                    {{ $grandParentAllottee->quarterType->quarter_code ?? ($grandParentAllottee->quarter_code ?? 'N/A') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            @if ($grandParentAllottee->is_emi_active == 'true')
                                            <span class="custom-badge badge-info">EMI Active</span>
                                            @endif
                                            <span class="text-muted ms-2">
                                                <strong>Original Allotment:</strong>
                                                {{ \Carbon\Carbon::parse($grandParentAllottee->created_at)->format('d M Y') }}
                                            </span>
                                        </div>
                                        <div class="flex gap-2">
                                            {{-- {{ route('nametransfer.incomplete.apply.index', encrypt($grandParentAllottee->id)) }} --}}
                                            <a href="{{ route('nametransfer.incomplete.apply.index', encrypt($grandParentAllottee->id)) }}" class="action-btn action-btn-info" title="Data Entry">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <rect x="3" y="3" width="14" height="18" rx="2"></rect>
                                                    <path d="M6 7h8"></path>
                                                    <path d="M6 11h6"></path>
                                                    <path d="M6 15h4"></path>
                                                    <circle cx="18" cy="17" r="4"></circle>
                                                    <path d="M18 15v4"></path>
                                                    <path d="M16 17h4"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('nametransfer.documents.upload', encrypt($grandParentAllottee->id)) }}"
                                                class="action-btn action-btn-warning" title="View Documents">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">

                                                    <!-- File -->
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>

                                                    <!-- Upload Arrow -->
                                                    <path d="M12 18V11"></path>
                                                    <path d="M9 14l3-3 3 3"></path>
                                                </svg>
                                            </a>
                                            @if($grandParentAllottee->parent_id != NULL)
                                            <a href="{{ route('applicant.nametransfer.master.file', encrypt($grandParentAllottee->id)) }}"
                                                class="action-btn badge-not-started"
                                                title="Upload Master File">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">

                                                    <!-- Box -->
                                                    <rect x="3" y="14" width="18" height="7" rx="2"></rect>

                                                    <!-- Arrow -->
                                                    <path d="M12 3v11"></path>
                                                    <path d="M8 7l4-4 4 4"></path>
                                                </svg>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            @endif
            @empty
            <tr id="noDataRow">
                <td colspan="7" class="text-center text-muted py-4">
                    <div class="py-3">
                        <i class="bx bx-folder-open bx-lg text-muted mb-3"></i>
                        <h6>No Files Found</h6>
                        <p class="mb-0">No current allottees pending data entry found</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    @if ($transferAllottee->hasPages())
    <div id="paginationContainer" class="p-4 border-top">
        @if (method_exists($transferAllottee, 'links'))
        {{ $transferAllottee->links('vendor.pagination.custom') }}
        @endif
    </div>
    @endif
</div>
</div>
</div>

<style>
    /* Hierarchical Row Styles */
    .hierarchical-row {
        transition: background-color 0.2s ease;
    }

    .hierarchical-row.level-0 {
        background-color: #ffffff;
    }

    .hierarchical-row.level-1 {
        background-color: #f8f9fa;
    }

    .hierarchical-row.level-2 {
        background-color: #f1f3f5;
    }

    .hierarchical-row:hover {
        background-color: #e9ecef !important;
    }

    .current-row {
        border-left: 4px solid #28a745;
    }

    .parent-row {
        border-left: 4px solid #ffc107;
    }

    .grandparent-row {
        border-left: 4px solid #6c757d;
    }

    .expand-icon {
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 4px;
        transition: all 0.2s ease;
        color: #3b82f6;
        margin-right: 5px;
    }

    .expand-icon:hover {
        background-color: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        transform: scale(1.1);
    }

    .expand-icon i {
        transition: transform 0.2s ease;
        font-size: 14px;
    }

    .expand-icon.expanded i {
        transform: rotate(45deg);
    }

    .child-row {
        display: none;
    }

    .badge-current {
        background-color: #28a745;
        color: white;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-block;
    }

    .badge-previous {
        background-color: #ffc107;
        color: #000;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-block;
    }

    .badge-first {
        background-color: #6c757d;
        color: white;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-block;
    }

    .badge-transfer-count {
        background-color: #e9ecef;
        color: #495057;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-block;
    }

    .badge-transfer-info {
        background-color: #fff3cd;
        color: #856404;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-block;
    }

    .badge-original {
        background-color: #d4edda;
        color: #155724;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-block;
    }

    .badge-info {
        background-color: #17a2b8;
        color: white;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-block;
    }

    .btn {
        padding: 6px 14px;
        font-size: 1rem;
        border-radius: 6px;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #111827;
    }

    .btn-secondary:hover {
        background: #d1d5db;
    }

    .search-input,
    .search-select {
        border: 1px solid var(--gray-border);
        border-radius: 4px;
        width: 100%;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .search-input:focus,
    .search-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(var(--primary-rgb), 0.1);
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 4px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .action-btn-info {
        background-color: #17a2b8;
        color: white;
    }

    .action-btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .highlight {
        background-color: #fff3cd;
        color: #856404;
        font-weight: bold;
        padding: 0 2px;
        border-radius: 2px;
    }

    .spinner-border {
        display: inline-block;
        width: 2rem;
        height: 2rem;
        border: 0.25em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border .75s linear infinite;
    }

    @keyframes spinner-border {
        to {
            transform: rotate(360deg);
        }
    }

    .visually-hidden {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -5px;
    }

    .col {
        padding: 0 5px;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .d-flex {
        display: flex;
    }

    .flex-column {
        flex-direction: column;
    }

    .align-items-center {
        align-items: center;
    }

    .flex-wrap {
        flex-wrap: wrap;
    }

    .fw-semibold {
        font-weight: 600;
    }

    .text-muted {
        color: #44484d !important;
    }

    .text-primary {
        color: #3b82f6 !important;
    }

    .text-dark {
        color: #212529 !important;
    }

    table {
        border-collapse: collapse;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .custom-badge {
        display: inline-block;
        padding: 2px 8px;
        font-size: 10px;
        font-weight: 500;
        border-radius: 20px;
    }

    .mt-1 {
        margin-top: 4px;
    }

    .mt-2 {
        margin-top: 8px;
    }

    .ms-2 {
        margin-left: 8px;
    }

    .ms-3 {
        margin-left: 16px;
    }

    .p-2 {
        padding: 8px;
    }

    .d-block {
        display: block;
    }

    .transfer-chain {
        font-size: 1rem;
    }

    .transfer-chain i {
        font-size: 10px;
    }
</style>

<script>
    (function() {
        'use strict';

        // Cache DOM elements
        const elements = {
            searchAllottee: document.getElementById('searchAllottee'),
            searchPropertyNo: document.getElementById('searchPropertyNo'),
            searchDivision: document.getElementById('searchDivision'),
            searchButton: document.getElementById('searchButton'),
            clearButton: document.getElementById('clearSearch'),
            tableBody: document.getElementById('tableBody'),
            paginationContainer: document.getElementById('paginationContainer'),
            loadingIndicator: document.getElementById('loadingIndicator'),
            table: document.getElementById('transferTable')
        };

        // State
        let currentPage = 1;
        let currentSearch = {
            allottee: elements.searchAllottee?.value || '',
            property_no: elements.searchPropertyNo?.value || '',
            division: elements.searchDivision?.value || ''
        };
        let isSearching = false;
        let searchTimeout;

        // Utility functions
        const utils = {
            debounce(func, wait) {
                return function(...args) {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => func.apply(this, args), wait);
                };
            },

            getSearchParams() {
                return {
                    allottee: elements.searchAllottee?.value.trim() || '',
                    property_no: elements.searchPropertyNo?.value.trim() || '',
                    division: elements.searchDivision?.value || ''
                };
            },

            hasActiveSearch(params) {
                return params.allottee || params.property_no || params.division;
            },

            toggleLoading(show) {
                isSearching = show;
                if (elements.loadingIndicator) {
                    elements.loadingIndicator.style.display = show ? 'block' : 'none';
                }
                if (elements.table) {
                    elements.table.style.opacity = show ? '0.5' : '1';
                }
            },

            highlightText(text, searchTerm) {
                if (!searchTerm || !text) return text;
                try {
                    const regex = new RegExp(`(${searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
                    return String(text).replace(regex, '<span class="highlight">$1</span>');
                } catch {
                    return text;
                }
            },

            formatDate(dateString) {
                if (!dateString) return 'N/A';
                try {
                    return new Date(dateString).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                } catch {
                    return dateString;
                }
            },

            applyHighlights(searchTerm) {
                if (!searchTerm) return;

                document.querySelectorAll('.allottee-name').forEach(el => {
                    const originalText = el.textContent;
                    const highlighted = this.highlightText(originalText, searchTerm);
                    if (highlighted !== originalText) {
                        el.innerHTML = highlighted;
                    }
                });

                document.querySelectorAll('.property-number').forEach(el => {
                    const originalText = el.textContent;
                    const highlighted = this.highlightText(originalText, searchTerm);
                    if (highlighted !== originalText) {
                        el.innerHTML = highlighted;
                    }
                });
            }
        };

        // Toggle functions for accordion (Plus button)
        window.toggleParent = function(currentId) {
            const parentRow = document.getElementById(`parent-${currentId}`);
            const expandIcon = document.querySelector(`#row-${currentId} .expand-icon i`);

            if (parentRow) {
                if (parentRow.style.display === 'none' || !parentRow.style.display) {
                    parentRow.style.display = 'table-row';
                    if (expandIcon) {
                        expandIcon.classList.remove('fa-plus-circle');
                        expandIcon.classList.add('fa-minus-circle');
                    }
                    // Close grandparent if open when opening parent
                    const grandParentRow = document.getElementById(`grandparent-${currentId}`);
                    if (grandParentRow && grandParentRow.style.display === 'table-row') {
                        grandParentRow.style.display = 'none';
                        const grandParentIcon = document.querySelector(`#parent-${currentId} .expand-icon i`);
                        if (grandParentIcon) {
                            grandParentIcon.classList.remove('fa-minus-circle');
                            grandParentIcon.classList.add('fa-plus-circle');
                        }
                    }
                } else {
                    parentRow.style.display = 'none';
                    if (expandIcon) {
                        expandIcon.classList.remove('fa-minus-circle');
                        expandIcon.classList.add('fa-plus-circle');
                    }
                    // Also close grandparent when closing parent
                    const grandParentRow = document.getElementById(`grandparent-${currentId}`);
                    if (grandParentRow) {
                        grandParentRow.style.display = 'none';
                        const grandParentIcon = document.querySelector(`#parent-${currentId} .expand-icon i`);
                        if (grandParentIcon) {
                            grandParentIcon.classList.remove('fa-minus-circle');
                            grandParentIcon.classList.add('fa-plus-circle');
                        }
                    }
                }
            }
        };

        window.toggleGrandParent = function(currentId) {
            const grandParentRow = document.getElementById(`grandparent-${currentId}`);
            const expandIcon = document.querySelector(`#parent-${currentId} .expand-icon i`);

            if (grandParentRow) {
                if (grandParentRow.style.display === 'none' || !grandParentRow.style.display) {
                    grandParentRow.style.display = 'table-row';
                    if (expandIcon) {
                        expandIcon.classList.remove('fa-plus-circle');
                        expandIcon.classList.add('fa-minus-circle');
                    }
                } else {
                    grandParentRow.style.display = 'none';
                    if (expandIcon) {
                        expandIcon.classList.remove('fa-minus-circle');
                        expandIcon.classList.add('fa-plus-circle');
                    }
                }
            }
        };

        // Load data function for AJAX search
        async function loadData(page = 1, searchParams = null) {
            if (isSearching) return;

            const params = searchParams || utils.getSearchParams();

            if (params.allottee && params.allottee.length < 2) return;

            utils.toggleLoading(true);

            try {
                const url = new URL(window.location.href);
                url.searchParams.set('page', page);

                Object.entries(params).forEach(([key, value]) => {
                    if (value) url.searchParams.set(key, value);
                });

                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                if (data.transferAllottee?.data?.length) {
                    // For AJAX, we need to reload the page or use a similar rendering approach
                    // Since the template is complex, we'll reload the page with the search params
                    window.location.href = url.toString();
                } else {
                    showEmptyState(params);
                    if (elements.paginationContainer) {
                        elements.paginationContainer.style.display = 'none';
                    }
                }

                currentSearch = {
                    ...params
                };

                if (elements.clearButton) {
                    elements.clearButton.style.display = utils.hasActiveSearch(params) ? 'inline-block' :
                        'none';
                }

            } catch (error) {
                console.error('Error:', error);
                showError();
            } finally {
                utils.toggleLoading(false);
            }
        }

        function showEmptyState(searchParams) {
            if (!elements.tableBody) return;
            const message = utils.hasActiveSearch(searchParams) ? 'No files match your search criteria.' :
                'No current allottees pending data entry found';
            elements.tableBody.innerHTML =
                `<tr><td colspan="7" class="text-center text-muted py-4"><div class="py-3"><i class="bx bx-folder-open bx-lg text-muted mb-3"></i><h6>No Files Found</h6><p class="mb-0">${message}</p></div></td></tr>`;
        }

        function showError() {
            if (!elements.tableBody) return;
            elements.tableBody.innerHTML =
                `<tr><td colspan="7" class="text-center py-4 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Error loading data. Please try again.</td></tr>`;
        }

        function attachPaginationListeners() {
            if (!elements.paginationContainer) return;
            const paginationLinks = elements.paginationContainer.querySelectorAll(
                'a[rel="prev"], a[rel="next"], a.page-link');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    const page = url.searchParams.get('page');
                    if (page) loadData(page, currentSearch);
                });
            });
        }

        // Debounced search
        const debouncedSearch = utils.debounce(() => {
            const params = utils.getSearchParams();
            if (JSON.stringify(params) !== JSON.stringify(currentSearch)) loadData(1, params);
        }, 500);

        // Event listeners
        if (elements.searchButton) elements.searchButton.addEventListener('click', () => loadData(1, utils
            .getSearchParams()));
        if (elements.clearButton) {
            elements.clearButton.addEventListener('click', () => {
                if (elements.searchAllottee) elements.searchAllottee.value = '';
                if (elements.searchPropertyNo) elements.searchPropertyNo.value = '';
                if (elements.searchDivision) elements.searchDivision.value = '';
                if (utils.hasActiveSearch(currentSearch)) loadData(1, {});
                elements.clearButton.style.display = 'none';
                elements.searchAllottee?.focus();
            });
        }

        [elements.searchAllottee, elements.searchPropertyNo].forEach(input => {
            if (input) {
                input.addEventListener('keyup', (e) => {
                    if (e.key === 'Enter') loadData(1, utils.getSearchParams());
                    else debouncedSearch();
                });
                input.addEventListener('input', () => {
                    if (elements.clearButton) elements.clearButton.style.display = utils
                        .hasActiveSearch(utils.getSearchParams()) ? 'inline-block' : 'none';
                });
            }
        });
        if (elements.searchDivision) elements.searchDivision.addEventListener('change', debouncedSearch);
        if (elements.paginationContainer?.innerHTML.trim()) attachPaginationListeners();
        if (elements.searchAllottee) elements.searchAllottee.focus();
    })();
</script>
@endsection