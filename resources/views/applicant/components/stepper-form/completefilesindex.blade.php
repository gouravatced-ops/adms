@extends('applicant.dashboard_layouts.main')

@section('title', 'File Receiving – Files')

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
        #return getDebugIndex($registerAllottee);
    @endphp
    <div class="card" style="box-shadow:none;">
        <div class="compact-card overflow-hidden">
            <!-- Header with Search -->
            <div class="p-4 border-b" style="border-color: var(--gray-border);">
                <div class="flex items-start justify-between">
                    <div>
                        <!-- Subtitle -->
                        <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <i class="fas fa-folder-open"></i>
                            Data Entry >> Allottee List Have Data Entry Completed
                        </h3>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('applicant.dataentry.completed.lot') }}">
                            <button class="btn btn-info"
                                style="background: linear-gradient(135deg, #3b82f6, #2563eb) !important; color:white;">
                                Back
                            </button>
                        </a>
                    </div>
                </div>
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
                <table id="studentListTable" class="table table-striped table-bordered align-middle w-full">
                    <thead style="background: linear-gradient(135deg, #3b82f6, #2563eb) !important;">
                        <tr>
                            <th width="50">Sl. no.</th>
                            <th>Allottee & Property</th>
                            <th>Division Details</th>
                            <th>Property Details</th>
                            <th>Remarks</th>
                            <th>Dates</th>
                            <th class="text-center">Preview</th>
                        </tr>
                    </thead>

                    <tbody id="tableBody">
                        @forelse ($registerAllottee as $key => $file)
                            <tr>
                                <!-- SL -->
                                <td>{{ $key + 1 }}</td>

                                <!-- Allottee & Property -->
                                <td>
                                    <div class="d-flex flex-column">
                                        <strong class="fw-semibold" style="color:#3b82f6;">{{ $file->prefix }}
                                            {{ $file->allottee_name }} {{ $file->allottee_middle_name }}
                                            {{ $file->allottee_surname }}</strong><br>
                                        <small class="text-muted">
                                            <strong>Property No: </strong>{{ $file->property_number }}
                                        </small>
                                        <div class="row" style="gap: 10px;margin-top:3px;">
                                            <?php if($file->name_transfer_status == 'yes') { ?>
                                            <span class="custom-badge badge-not-started"> Property Transfer </span>
                                            <?php } ?>
                                            <?php if($file->is_emi_active == 'true') { ?>
                                            <span class="custom-badge badge-info"> EMI Active </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- Division -->
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-muted"><strong>Division:
                                            </strong>{{ $file->division->name }}</span> <br>
                                        <strong>Sub
                                            Division:</strong> {{ $file->subDivision->name }}
                                    </div>
                                </td>

                                <!-- Property Details -->
                                <td>
                                    <div class="d-flex flex-column">
                                        <span>
                                            <strong>{{ $file->propertyCategory->name }}</strong> –
                                            {{ $file->propertyType->name }}
                                        </span><br>
                                        <strong>Quarter:</strong> <span>{{ $file->quarterType->quarter_code }}</span>
                                    </div>
                                </td>

                                <!-- Remarks -->
                                <td>
                                    @if ($file->remarks)
                                        {{ $file->remarks }}
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <!-- Dates -->
                                <td>
                                    <div class="d-flex flex-column">
                                        {{ \Carbon\Carbon::parse($file->created_at)->format('d M Y') }}
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="py-2">
                                    <div class="flex gap-2">
                                        <!-- View -->
                                        <a href="{{ route('preview.apply.index', $file->allotteeId) }}"
                                            class="action-btn action-btn-info" title="Open File Data Entry">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">

                                                <!-- File / Form -->
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <path d="M14 2v6h6"></path>
                                                <path d="M8 13h8"></path>
                                                <path d="M8 17h5"></path>

                                                <!-- Pencil -->
                                                <path d="M16.5 11.5l2 2"></path>
                                                <path d="M15 13l4-4 2 2-4 4-3 1z"></path>
                                            </svg>
                                        </a>

                                        <a href="{{ route('applicant.documents.upload', $file->allotteeId) }}"
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
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="noDataRow">
                                <td colspan="7" class="text-center text-muted py-4">
                                    <div class="py-3">
                                        <i class="bx bx-folder-open bx-lg text-muted mb-3"></i>
                                        <h6>No Files Found</h6>
                                        <p class="mb-0">No allottee files available for this register</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
