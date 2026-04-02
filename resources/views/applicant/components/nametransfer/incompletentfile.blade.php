@extends('applicant.dashboard_layouts.main')

@section('title', 'Incomplete Name Transfer – Files')

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
        #return getDebugIndex($transferAllottee);
    @endphp
    <div class="card" style="box-shadow:none;">
        <div class="compact-card overflow-hidden">
            <!-- Header with Search -->
            <div class="p-4 border-b" style="border-color: var(--gray-border);">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <!-- Subtitle -->
                        <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <i class="fas fa-folder-open"></i>
                            Data Entry >> Incomplete Name Transfer File
                        </h3>
                    </div>
                </div>

                <!-- Search Box with Filters -->
                <div class="search-container" style="margin-top: 10px;">
                    <div class="row" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-end;">
                        <div class="col" style="flex: 1; min-width: 200px;">
                            <label style="font-size: 12px; color: #6c757d; margin-bottom: 4px; display: block;">Search
                                Allottee</label>
                            <input type="text" id="searchAllottee" class="form-control search-input"
                                placeholder="Search by register_id , first_name , middle_name , surname ,  application_no"
                                style="padding: 8px 12px;" autocomplete="off">
                        </div>

                        <div class="col" style="flex: 1; min-width: 150px;">
                            <label style="font-size: 12px; color: #6c757d; margin-bottom: 4px; display: block;">Property
                                No</label>
                            <input type="text" id="searchPropertyNo" class="form-control search-input"
                                placeholder="Search property number..." style="padding: 8px 12px;" autocomplete="off">
                        </div>

                        <div class="col" style="flex: 1; min-width: 150px;">
                            <label
                                style="font-size: 12px; color: #6c757d; margin-bottom: 4px; display: block;">Division</label>
                            <select id="searchDivision" class="form-control search-select" style="padding: 8px 12px;">
                                <option value="">All Divisions</option>
                                @if (isset($divisions) && $divisions->count())
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
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
                            <th>Dates</th>
                            <th>Action</th>
                            {{-- <th class="text-center">Data Entry</th> --}}
                        </tr>
                    </thead>

                    <tbody id="tableBody">
                        @forelse ($transferAllottee as $key => $file)
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
                                            </strong>{{ $file->division->name }}</span>
                                        <small class="text-muted">
                                            <strong>Sub Division:</strong> {{ $file->subDivision->name }}
                                        </small>
                                    </div>
                                </td>

                                <!-- Property Details -->
                                <td>
                                    <div class="d-flex flex-column">
                                        <span>
                                            <strong>{{ $file->propertyCategory->name }}</strong> –
                                            {{ $file->propertyType->name }}
                                        </span>
                                        <small class="text-muted">
                                            <strong>Quarter:</strong> <span>{{ $file->quarterType->quarter_code }}</span>
                                        </small>
                                    </div>
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

                                        <a href="{{ route('nametransfer.incomplete.apply.index', encrypt($file->id)) }}"
                                            class="action-btn action-btn-info" title="Assign New Allottee">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">

                                                <!-- Person -->
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M3 21c0-4 3-7 6-7s6 3 6 7"></path>

                                                <!-- Plus -->
                                                <line x1="19" y1="8" x2="19" y2="14">
                                                </line>
                                                <line x1="16" y1="11" x2="22" y2="11">
                                                </line>

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
                                        <p class="mb-0">Transfer Files Not found</p>
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
                table: document.getElementById('studentListTable')
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
                }
            };

            // Load data function
            async function loadData(page = 1, searchParams = null) {
                if (isSearching) return;

                const params = searchParams || utils.getSearchParams();

                // Don't search if too short
                if (params.allottee && params.allottee.length < 2) return;

                utils.toggleLoading(true);

                try {
                    const url = new URL('{{ route('nametransfer.dataentry.files') }}');
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
                        renderRows(data.transferAllottee.data, params, data.transferAllottee.current_page, data
                            .transferAllottee.per_page);
                        if (data.pagination && elements.paginationContainer) {
                            elements.paginationContainer.innerHTML = data.pagination;
                            elements.paginationContainer.style.display = 'block';
                            attachPaginationListeners();
                        }
                    } else {
                        showEmptyState(params);
                        if (elements.paginationContainer) {
                            elements.paginationContainer.style.display = 'none';
                        }
                    }

                    currentPage = page;
                    currentSearch = {
                        ...params
                    };

                    // Update clear button visibility
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

            // Render rows function - UPDATED to match your new tbody structure
            function renderRows(files, searchParams, currentPage, perPage) {
                if (!elements.tableBody) return;

                elements.tableBody.innerHTML = files.map((file, index) => {
                    const slNo = ((currentPage - 1) * perPage) + index + 1;
                    const allotteeName = [file.prefix, file.allottee_name, file.allottee_middle_name, file
                            .allottee_surname
                        ]
                        .filter(Boolean).join(' ').trim();

                    const highlightedName = utils.highlightText(allotteeName, searchParams.allottee);
                    const highlightedProperty = utils.highlightText(file.property_number, searchParams
                        .property_no);

                    // Get related data with null checks
                    const divisionName = file.division?.name || file.dname || 'N/A';
                    const subDivisionName = file.sub_division?.name || file.subname || 'N/A';
                    const categoryName = file.property_category?.name || file.cname || 'N/A';
                    const typeName = file.property_type?.name || file.pname || 'N/A';
                    const quarterCode = file.quarter_type?.quarter_code || file.quarter_code || 'N/A';

                    return `
                <tr>
                    <!-- SL -->
                    <td>${slNo}</td>

                    <!-- Allottee & Property -->
                    <td>
                        <div class="d-flex flex-column">
                            <strong class="fw-semibold" style="color:#3b82f6;">${highlightedName}</strong>
                            <small class="text-muted">
                                <strong>Property No: </strong>${highlightedProperty}
                            </small>
                            <div class="row" style="gap: 10px; margin-top:3px;">
                                ${file.name_transfer_status === 'yes' ? 
                                    '<span class="custom-badge badge-not-started">Property Transfer</span>' : ''}
                                ${file.is_emi_active === 'true' ? 
                                    '<span class="custom-badge badge-info">EMI Active</span>' : ''}
                            </div>
                        </div>
                    </td>

                    <!-- Division -->
                    <td>
                        <div class="d-flex flex-column">
                            <span class="text-muted">
                                <strong>Division: </strong>${divisionName}
                            </span>
                            <small class="text-muted">
                                <strong>Sub Division:</strong> ${subDivisionName}
                            </small>
                        </div>
                    </td>

                    <!-- Property Details -->
                    <td>
                        <div class="d-flex flex-column">
                            <span>
                                <strong>${categoryName}</strong> – ${typeName}
                            </span>
                            <small class="text-muted">
                                <strong>Quarter:</strong> <span>${quarterCode}</span>
                            </small>
                        </div>
                    </td>

                    <!-- Dates -->
                    <td>
                        <div class="d-flex flex-column">
                            ${utils.formatDate(file.created_at)}
                        </div>
                    </td>

                    <!-- Actions -->
                    <td class="py-2">
                        <div class="flex gap-2">
                            <!-- View -->
                            <a href="/applicant/apply/${btoa(file.id)}" 
                            class="action-btn action-btn-info" 
                            title="Data Entry for this file">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="14" height="18" rx="2"></rect>
                                    <path d="M6 7h8"></path>
                                    <path d="M6 11h6"></path>
                                    <path d="M6 15h4"></path>
                                    <circle cx="18" cy="17" r="4"></circle>
                                    <path d="M18 15v4"></path>
                                    <path d="M16 17h4"></path>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            `;
                }).join('');
            }

            // Show empty state - UPDATED message
            function showEmptyState(searchParams) {
                if (!elements.tableBody) return;

                const message = utils.hasActiveSearch(searchParams) ?
                    'No files match your search criteria.' :
                    'Transfer Files Not found';

                elements.tableBody.innerHTML = `
                    <tr id="noDataRow">
                        <td colspan="7" class="text-center text-muted py-4">
                            <div class="py-3">
                                <i class="bx bx-folder-open bx-lg text-muted mb-3"></i>
                                <h6>No Files Found</h6>
                                <p class="mb-0">${message}</p>
                            </div>
                        </td>
                    </tr>
                `;
            }

            // Show error state - Keeping your existing structure
            function showError() {
                if (!elements.tableBody) return;
                elements.tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-4 text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Error loading data. Please try again.
                        </td>
                    </tr>
                `;
            }

            // Attach pagination listeners
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
                            loadData(page, currentSearch);
                        }
                    });
                });
            }

            // Debounced search
            const debouncedSearch = utils.debounce(() => {
                const params = utils.getSearchParams();
                if (JSON.stringify(params) !== JSON.stringify(currentSearch)) {
                    loadData(1, params);
                }
            }, 500);

            // Event listeners
            if (elements.searchButton) {
                elements.searchButton.addEventListener('click', () => {
                    loadData(1, utils.getSearchParams());
                });
            }

            if (elements.clearButton) {
                elements.clearButton.addEventListener('click', () => {
                    if (elements.searchAllottee) elements.searchAllottee.value = '';
                    if (elements.searchPropertyNo) elements.searchPropertyNo.value = '';
                    if (elements.searchDivision) elements.searchDivision.value = '';

                    if (utils.hasActiveSearch(currentSearch)) {
                        loadData(1, {});
                    }

                    elements.clearButton.style.display = 'none';
                    elements.searchAllottee?.focus();
                });
            }

            // Input listeners
            [elements.searchAllottee, elements.searchPropertyNo].forEach(input => {
                if (input) {
                    input.addEventListener('keyup', (e) => {
                        if (e.key === 'Enter') {
                            loadData(1, utils.getSearchParams());
                        } else {
                            debouncedSearch();
                        }
                    });

                    input.addEventListener('input', () => {
                        const params = utils.getSearchParams();
                        if (elements.clearButton) {
                            elements.clearButton.style.display = utils.hasActiveSearch(params) ?
                                'inline-block' : 'none';
                        }
                    });
                }
            });

            if (elements.searchDivision) {
                elements.searchDivision.addEventListener('change', debouncedSearch);
            }

            // Initial setup
            if (elements.paginationContainer?.innerHTML.trim()) {
                attachPaginationListeners();
            }

            if (elements.searchAllottee) {
                elements.searchAllottee.focus();
            }

        })();
    </script>

    <style>
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