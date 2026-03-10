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

    <div class="card" style="box-shadow:none;">
        <div class="compact-card overflow-hidden">
            <!-- Header with Search -->
            <div class="p-4 border-b" style="border-color: var(--gray-border);">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <!-- Subtitle -->
                        <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <i class="fas fa-folder-open"></i>
                            Scanned >> View of Scanned Files
                        </h3>

                        <!-- Title BELOW subtitle -->
                        <p class="text-xs text-gray-500 mt-1" id="registerNumber">
                            Registration No: {{ $registerAllottee->first()->register_id ?? '-' }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('applicant.scanning.completed') }}">
                            <button class="btn btn-info"
                                style="background: linear-gradient(135deg, #3b82f6, #2563eb) !important; color:white;">
                                Back
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table id="studentListTable" class="table table-striped table-bordered align-middle w-full">
                    <thead style="background: linear-gradient(135deg, #3b82f6, #2563eb) !important;">
                        <tr>
                            <th width="50">Sl. No.</th>
                            <th>Allottee & Property</th>
                            <th>Division Details</th>
                            <th>Property Details</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Scanned On (Date & Time)</th>
                        </tr>
                    </thead>
                    @php
                        #return getDebugIndex($registerAllottee);
                        //                         [json_pages] => [{"file_name":"File-1","pages":8},{"file_name":"File-2","pages":36},{"file_name":"File-3","pages":48}]
                        // [total_pages] => 92
                    @endphp
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
                                            {{ $file->allottee_surname }}</strong>
                                        <small class="text-muted">
                                            <strong>Property No: </strong>{{ $file->property_number }}
                                        </small>
                                        <small class="text-muted">
                                            <strong>No.of Files: </strong>{{ $file->total_files }}
                                        </small>
                                    </div>
                                </td>

                                <!-- Division -->
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-muted"><strong>Division: </strong>{{ $file->dname }}</span>
                                        <small class="text-muted"><strong>Sub
                                                Division:</strong>{{ $file->subname }}</small>
                                    </div>
                                </td>

                                <!-- Property Details -->
                                <td>
                                    <div class="d-flex flex-column">
                                        <span>
                                            <strong>{{ $file->cname }}</strong> – {{ $file->pname }}
                                        </span>
                                        <small class="text-muted">
                                            <strong>Quarter:</strong> {{ $file->quarter_code }}
                                        </small>
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

                                <!-- Status -->
                                <td>
                                    Scanned By <br> {{ $file->scannedBy->name }}
                                </td>

                                <!-- Dates -->
                                <td>
                                    <div class="d-flex flex-column">
                                        {{ formatDateTime($file->updated_at) }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" class="p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <tbody>
                                                @php
                                                    $filesData = json_decode($file->json_pages, true) ?? [];
                                                    $totalPages = 0;
                                                @endphp

                                                <tr>
                                                    {{-- Files Loop --}}
                                                    @foreach ($filesData as $index => $fileInfo)
                                                        @php $totalPages += $fileInfo['pages']; @endphp
                                                        <td style="background: #2969ed3b;">
                                                            <strong>File {{ $index + 1 }}</strong> :
                                                            {{ $fileInfo['pages'] }}
                                                        </td>
                                                    @endforeach

                                                    {{-- Total Column (colspan 2 + different background) --}}
                                                    <td colspan="2" style="background:#e6f4ea; font-weight:600;">
                                                        Total : {{ $totalPages }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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

                <!-- Pagination -->
                <div id="paginationContainer" class="p-4 border-t" style="border-color: var(--gray-border);">
                    @if (method_exists($registerAllottee, 'links'))
                        {{ $registerAllottee->links() }}
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- PDF Export Confirmation Modal -->
    <div id="pdfModal" class="modal-overlay">

        <div class="modal modal-top">
            <div class="modal-header">
                <h4>Confirm PDF Generate</h4>
                <button class="modal-close" onclick="closePdfModal()">×</button>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to Download this registration as a PDF?</p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closePdfModal()">Cancel</button>
                <a href="{{ route('admin.filereceving.export', $registerId) }}" class="btn btn-danger">Yes, Download</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search elements
            const searchAllottee = document.getElementById('searchAllottee');
            const searchPropertyNo = document.getElementById('searchPropertyNo');
            const searchDivision = document.getElementById('searchDivision');
            const searchButton = document.getElementById('searchButton');
            const clearSearch = document.getElementById('clearSearch');

            // Table elements
            const tableBody = document.getElementById('tableBody');
            const paginationContainer = document.getElementById('paginationContainer');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const table = document.getElementById('studentListTable');
            const registerNumber = document.getElementById('registerNumber');

            // State variables
            let currentPage = 1;
            let currentSearch = {
                allottee: '',
                property_no: '',
                division: ''
            };
            let isSearching = false;
            let searchTimeout = null;
            let lastSearchParams = {};

            // Get register number from the page
            const registerId = "{{ request()->route('registerId') }}";

            // Function to load data
            function loadData(page = 1, searchParams = {}) {
                if (isSearching) return;

                isSearching = true;
                table.style.opacity = '0.5';
                loadingIndicator.style.display = 'block';
                paginationContainer.style.display = 'none';

                // Build URL with parameters
                const url = new URL('{{ route('admin.filereceving.fileindex', ['registerId' => ':registerId']) }}'
                    .replace(':registerId', registerId));
                url.searchParams.append('page', page);

                // Add search parameters
                if (searchParams.allottee) {
                    url.searchParams.append('allottee', searchParams.allottee);
                }
                if (searchParams.property_no) {
                    url.searchParams.append('property_no', searchParams.property_no);
                }
                if (searchParams.division) {
                    url.searchParams.append('division', searchParams.division);
                }

                // Add AJAX header
                const headers = new Headers({
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                });

                fetch(url, {
                        headers
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Clear existing rows
                        tableBody.innerHTML = '';

                        if (data.registerAllottee && data.registerAllottee.data && data.registerAllottee.data
                            .length > 0) {
                            // Add new rows
                            data.registerAllottee.data.forEach((file, index) => {
                                const row = document.createElement('tr');

                                // Highlight search terms
                                let allotteeName = file.allottee_name + ' ' + file
                                    .allottee_middle_name + ' ' + file.allottee_surname;
                                let propertyNo = file.property_number;

                                // Highlight allottee name if searched
                                if (searchParams.allottee) {
                                    const searchLower = searchParams.allottee.toLowerCase();
                                    const allotteeLower = allotteeName.toLowerCase();
                                    const indexOfSearch = allotteeLower.indexOf(searchLower);

                                    if (indexOfSearch !== -1) {
                                        const before = allotteeName.substring(0, indexOfSearch);
                                        const match = allotteeName.substring(indexOfSearch,
                                            indexOfSearch + searchParams.allottee.length);
                                        const after = allotteeName.substring(indexOfSearch +
                                            searchParams.allottee.length);
                                        allotteeName =
                                            `${before}<span class="highlight">${match}</span>${after}`;
                                    }
                                }

                                // Highlight property number if searched
                                if (searchParams.property_no) {
                                    const searchLower = searchParams.property_no.toLowerCase();
                                    const propertyLower = propertyNo.toLowerCase();
                                    const indexOfSearch = propertyLower.indexOf(searchLower);

                                    if (indexOfSearch !== -1) {
                                        const before = propertyNo.substring(0, indexOfSearch);
                                        const match = propertyNo.substring(indexOfSearch,
                                            indexOfSearch + searchParams.property_no.length);
                                        const after = propertyNo.substring(indexOfSearch + searchParams
                                            .property_no.length);
                                        propertyNo =
                                            `${before}<span class="highlight">${match}</span>${after}`;
                                    }
                                }

                                const slNo = (data.registerAllottee.current_page - 1) * data
                                    .registerAllottee.per_page + index + 1;

                                row.innerHTML = `
                                        <td>${slNo}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong class="fw-semibold" style="color:green;">${file.prefix} ${allotteeName}</strong>
                                                <small class="text-muted">
                                                    <strong>Property No: </strong>${propertyNo}
                                                </small>
                                                <small class="text-muted">
                                                    <strong>No of files: </strong>${file.total_files}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-muted"><strong>Division: </strong>${file.dname || 'N/A'}</span>
                                                <small class="text-muted"><strong>Sub Division:</strong> ${file.subname || 'N/A'}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span>
                                                    <strong>${file.cname || 'N/A'}</strong> – ${file.pname || 'N/A'}
                                                </span>
                                                <small class="text-muted">
                                                    <strong>Quarter:</strong> ${file.quarter_code || 'N/A'}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            ${file.remarks ? file.remarks : 'N/A'}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                ${new Date(file.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}
                                            </div>
                                        </td>
                                        <td class="py-2">
                                            <div class="flex gap-2">
                                                <a href="/filereceving/individual/fetch/${btoa(file.id)}" class="action-btn action-btn-success" title="Edit file">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="/filereceving/allotte/deleted/${btoa(file.id)}" class="action-btn action-btn-danger" title="Delete file">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    `;
                                tableBody.appendChild(row);
                            });

                            // Update pagination
                            if (data.pagination) {
                                paginationContainer.innerHTML = data.pagination;
                                paginationContainer.style.display = 'block';
                            } else {
                                paginationContainer.style.display = 'none';
                            }

                            // Update register number if provided
                            if (data.register_number) {
                                registerNumber.textContent = `Register No: ${data.register_number}`;
                            }
                        } else {
                            // Show no results message
                            const noDataRow = document.createElement('tr');
                            noDataRow.id = 'noDataRow';

                            let message = 'No allottee files available for this register';
                            if (searchParams.allottee || searchParams.property_no || searchParams.division) {
                                message = 'No files found matching your search criteria.';
                            }

                            noDataRow.innerHTML = `
                                <td colspan="7" class="text-center text-muted py-4">
                                    <div class="py-3">
                                        <i class="fas fa-search bx-lg text-muted mb-3"></i>
                                        <h6>No Files Found</h6>
                                        <p class="mb-0">${message}</p>
                                    </div>
                                </td>
                            `;
                            tableBody.appendChild(noDataRow);
                            paginationContainer.style.display = 'none';
                        }

                        // Re-attach pagination listeners
                        attachPaginationListeners();

                        currentPage = page;
                        currentSearch = {
                            ...searchParams
                        };
                        lastSearchParams = {
                            ...searchParams
                        };

                        // Show clear button if any search is active
                        if (searchParams.allottee || searchParams.property_no || searchParams.division) {
                            clearSearch.style.display = 'inline-block';
                        } else {
                            clearSearch.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Show error message
                        const errorRow = document.createElement('tr');
                        errorRow.innerHTML = `
                <td colspan="7" class="text-center py-6 text-danger">
                    <i class="fas fa-exclamation-triangle"></i> Error loading data. Please try again.
                </td>
            `;
                        tableBody.appendChild(errorRow);
                    })
                    .finally(() => {
                        isSearching = false;
                        table.style.opacity = '1';
                        loadingIndicator.style.display = 'none';
                    });
            }

            // Function to attach pagination listeners
            function attachPaginationListeners() {
                const paginationLinks = paginationContainer.querySelectorAll(
                    'a[rel="prev"], a[rel="next"], a.page-link');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();

                        const url = new URL(this.href);
                        const page = url.searchParams.get('page');
                        if (page) {
                            loadData(parseInt(page), currentSearch);
                        }
                    });
                });
            }

            // Function to get current search parameters
            function getSearchParams() {
                return {
                    allottee: searchAllottee.value.trim(),
                    property_no: searchPropertyNo.value.trim(),
                    division: searchDivision.value
                };
            }

            // Function to check if search params have changed
            function searchParamsChanged(newParams, oldParams) {
                return newParams.allottee !== oldParams.allottee ||
                    newParams.property_no !== oldParams.property_no ||
                    newParams.division !== oldParams.division;
            }

            // Debounced search function
            function debounceSearch() {
                const searchParams = getSearchParams();

                // Clear previous timeout
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }

                // Check if any search parameter is active
                const hasSearch = searchParams.allottee || searchParams.property_no || searchParams.division;

                // If no search params and we had search before, load immediately
                if (!hasSearch) {
                    if (Object.values(lastSearchParams).some(val => val)) {
                        loadData(1, {});
                        lastSearchParams = {};
                    }
                    return;
                }

                // If search params changed, search with debounce
                if (searchParamsChanged(searchParams, lastSearchParams)) {
                    searchTimeout = setTimeout(() => {
                        loadData(1, searchParams);
                        lastSearchParams = {
                            ...searchParams
                        };
                    }, 500); // 500ms debounce delay
                }
            }

            // Search button click handler
            searchButton.addEventListener('click', function() {
                const searchParams = getSearchParams();
                if (searchParamsChanged(searchParams, currentSearch)) {
                    loadData(1, searchParams);
                }
            });

            // Keyup handlers for search inputs (real-time search)
            [searchAllottee, searchPropertyNo].forEach(input => {
                input.addEventListener('keyup', function(e) {
                    // Enter key triggers immediate search
                    if (e.key === 'Enter') {
                        const searchParams = getSearchParams();
                        if (searchParamsChanged(searchParams, currentSearch)) {
                            loadData(1, searchParams);
                        }
                        return;
                    }

                    // Debounce for other keys
                    debounceSearch();
                });
            });

            // Input event for select
            searchDivision.addEventListener('change', function() {
                debounceSearch();
            });

            // Clear search handler
            clearSearch.addEventListener('click', function() {
                searchAllottee.value = '';
                searchPropertyNo.value = '';
                searchDivision.value = '';

                if (Object.values(currentSearch).some(val => val)) {
                    loadData(1, {});
                }
                clearSearch.style.display = 'none';

                // Focus on first search input
                searchAllottee.focus();
            });

            // Input events to show/hide clear button
            [searchAllottee, searchPropertyNo].forEach(input => {
                input.addEventListener('input', function() {
                    const searchParams = getSearchParams();
                    if (Object.values(searchParams).some(val => val)) {
                        clearSearch.style.display = 'inline-block';
                    } else if (!searchDivision.value) {
                        clearSearch.style.display = 'none';
                    }
                });
            });

            // Division change event for clear button
            searchDivision.addEventListener('change', function() {
                const searchParams = getSearchParams();
                if (Object.values(searchParams).some(val => val)) {
                    clearSearch.style.display = 'inline-block';
                } else {
                    clearSearch.style.display = 'none';
                }
            });

            // Initial attachment of pagination listeners if pagination exists
            if (paginationContainer.innerHTML.trim()) {
                attachPaginationListeners();
            }

            // Focus on first search input
            searchAllottee.focus();
        });
    </script>
    <script>
        function openPdfModal() {
            document.getElementById('pdfModal').style.display = 'flex';
        }

        function closePdfModal() {
            document.getElementById('pdfModal').style.display = 'none';
        }
    </script>

    <style>
        /* Overlay */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            display: none;
            justify-content: center;
            align-items: flex-start;
            padding-top: 80px;
            /* TOP CENTER spacing */
            z-index: 9999;
        }

        /* Modal box */
        .modal {
            background: #fff;
            width: 100%;
            max-width: 380px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: slideDown 0.25s ease-out;
            overflow: hidden;
        }

        /* Header */
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 16px;
            border-bottom: 1px solid #eee;
        }

        .modal-header h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }

        /* Close button */
        .modal-close {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #6b7280;
        }

        /* Body */
        .modal-body {
            padding: 16px;
            font-size: 13px;
            color: #4b5563;
        }

        /* Footer */
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            padding: 12px 16px;
            border-top: 1px solid #eee;
        }

        /* Buttons */
        .btn {
            padding: 6px 14px;
            font-size: 12px;
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

        .btn-danger {
            background: #b11226;
            /* Cherry red */
            color: #fff;
        }

        .btn-danger:hover {
            background: #8f0e1f;
        }

        /* Animation */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Base PDF Icon */
        .pdf-icon {
            width: 24px;
            height: 24px;
            fill: #830a1a;
            /* Cherry Red */
        }

        /* Outline Version */
        .pdf-icon-outline {
            width: 24px;
            height: 24px;
            color: #0b1c2d;
            /* Navy */
        }

        /* Download Icon */
        .pdf-download-icon {
            width: 20px;
            height: 20px;
            stroke: #000;
            stroke-width: 2;
            fill: none;
        }

        /* Button with PDF icon */
        .pdf-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            background: #b11226;
            color: #fff;
            font-size: 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .pdf-btn:hover {
            background: #2f7003;
        }

        /* Icon animation on hover */
        .pdf-btn:hover svg {
            transform: translateY(-1px);
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

        .btn {
            border: 1px solid transparent;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 5px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
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

        .action-btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .action-btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
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

        .highlight {
            background-color: #fff3cd;
            color: #856404;
            font-weight: bold;
            padding: 0 2px;
            border-radius: 2px;
        }

        .text-danger {
            color: var(--danger-color);
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -5px;
        }

        .col {
            padding: 0 5px;
        }

        .d-flex {
            display: flex;
        }

        .flex-column {
            flex-direction: column;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .table-light {
            background-color: #f8f9fa;
        }
    </style>
@endsection
