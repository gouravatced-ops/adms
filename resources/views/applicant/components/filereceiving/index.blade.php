@extends('applicant.dashboard_layouts.main')

@section('title', 'File Receiving')

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
            <div class="p-4 border-b flex items-center justify-between" style="border-color: var(--gray-border);">
                <h3 class="flex items-center gap-2 text-sm font-semibold">
                    <i class="fas fa-folder-open"></i>
                    Files Received by JSHB
                </h3>

                <!-- Search Box -->
                <div class="search-container" style="position: relative; width: 300px;">
                    <input type="text" id="searchInput" class="form-control search-input"
                        placeholder="Search by Register No..." style="padding-right: 40px;" autocomplete="off">
                    <button id="searchButton" class="search-button"
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; color: #6c757d;"
                        title="Search">
                        <i class="fas fa-search"></i>
                    </button>
                    <button id="clearSearch" class="clear-search-button"
                        style="display: none; position: absolute; right: 35px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; color: #6c757d;"
                        title="Clear search">
                        <i class="fas fa-times"></i>
                    </button>
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
            <div class="overflow-x-auto">
                <table id="studentListTable" class="table table-striped table-bordered align-middle w-full">
                    <thead>
                        <tr>
                            <th class="text-left text-xs font-semibold">Sl. No.</th>
                            <th class="text-left text-xs font-semibold">Lot No.</th>
                            <th class="text-left text-xs font-semibold">Register No.</th>
                            <th class="text-left text-xs font-semibold">No. of Files Received</th>
                            <th class="text-left text-xs font-semibold">Division</th>
                            <th class="text-left text-xs font-semibold">Status</th>
                            <th class="text-left text-xs font-semibold">Created on (Date & Time)</th>
                            <th class="text-left text-xs font-semibold">View Register</th>
                        </tr>
                    </thead>
                    @php
                        #return getDebugIndex($registrations);
                    @endphp
                    <tbody id="tableBody">
                        @forelse ($registrations as $key => $registration)
                            <tr class="border-t">
                                <td>{{ $key + 1 }}</td>
                                <td class="py-2">
                                    {{ $registration->lot_no }}
                                </td>
                                <td class="py-2">
                                    <a href="{{ route('admin.filereceving.fileindex', $registration->encoded_register_no) }}"
                                        style="text-decoration: underline;color: blue;">
                                        {{ $registration->register_no }}
                                    </a>
                                </td>

                                <td class="py-2">
                                    {{ $registration->total_files }}
                                </td>

                                <td class="py-2">
                                    {{ getDivisionName($registration->division_id) ?? 'N/A' }}
                                </td>

                                <td class="py-2">{{ ucfirst($registration->status) }} by <br>
                                    {{ $registration->creator->name ?? 'System' }}
                                </td>

                                <td class="py-2">
                                    {{ formatDateTime($registration->created_at) }}
                                </td>
                                <!-- ACTION BUTTONS -->
                                <td class="py-2">
                                    <div class="flex gap-2">
                                        @php
                                            $total = (int) ($registration->total_files ?? 0);
                                            $allowed = (int) ($registration->allowed_files ?? 0);
                                        @endphp

                                        @if ($total < $allowed)
                                            <!-- Add File -->
                                            <a href="{{ route('admin.filereceving.addmore', $registration->encoded_register_no) }}"
                                                class="action-btn action-btn-success" title="Add File">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        @endif
                                        <!-- View Files -->
                                        <a href="{{ route('admin.filereceving.fileindex', $registration->encoded_register_no) }}"
                                            class="action-btn action-btn-info" title="View Files">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="noDataRow">
                                <td colspan="7" class="text-center py-6 text-gray-500">
                                    No registrations found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div id="paginationContainer" class="p-4 border-t" style="border-color: var(--gray-border);">
                    {{ $registrations->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');
            const clearSearch = document.getElementById('clearSearch');
            const tableBody = document.getElementById('tableBody');
            const paginationContainer = document.getElementById('paginationContainer');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const table = document.getElementById('studentListTable');

            let currentPage = 1;
            let currentSearch = '';
            let isSearching = false;
            let searchTimeout = null;
            let lastSearchTerm = '';

            // Function to load data
            function loadData(page = 1, search = '') {
                if (isSearching) return;

                isSearching = true;
                table.style.opacity = '0.5';
                loadingIndicator.style.display = 'block';
                paginationContainer.style.display = 'none';

                const url = new URL('{{ route('admin.filereceving.index') }}');
                url.searchParams.append('page', page);
                if (search) {
                    url.searchParams.append('search', search);
                }

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Clear existing rows except the header
                        const rows = tableBody.querySelectorAll('tr');
                        rows.forEach(row => row.remove());

                        if (data.registrations.data && data.registrations.data.length > 0) {
                            // Add new rows
                            data.registrations.data.forEach((registration, index) => {
                                const row = document.createElement('tr');
                                row.className = 'border-t';

                                // Highlight search term in register_no
                                let registerNo = registration.register_no;
                                if (search) {
                                    const searchLower = search.toLowerCase();
                                    const registerLower = registerNo.toLowerCase();
                                    const indexOfSearch = registerLower.indexOf(searchLower);

                                    if (indexOfSearch !== -1) {
                                        const before = registerNo.substring(0, indexOfSearch);
                                        const match = registerNo.substring(indexOfSearch,
                                            indexOfSearch + search.length);
                                        const after = registerNo.substring(indexOfSearch + search
                                            .length);

                                        registerNo =
                                            `${before}<span class="highlight">${match}</span>${after}`;
                                    }
                                }

                                row.innerHTML = `
                                <td>${(data.registrations.current_page - 1) * data.registrations.per_page + index + 1}</td>
                                <td class="py-2">${registration.lot_no}</td>
                                <td class="py-2"><a href="/filereceving/item/list/${btoa(registration.register_no)}" title="View Files" style="text-decoration: underline;color: blue;">
                                            ${registerNo}
                                        </a></td>
                                <td class="py-2">${registration.total_files}</td>
                                <td class="py-2">${registration.status.charAt(0).toUpperCase() + registration.status.slice(1)}</td>
                                <td class="py-2">${registration.created_at}</td>
                                <td class="py-2">
                                    <div class="flex gap-2">
                                        <a href="/filereceving/item/list/${btoa(registration.register_no)}"
                                            class="action-btn action-btn-info" title="View Files">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            `;
                                tableBody.appendChild(row);
                            });

                            // Update pagination
                            paginationContainer.innerHTML = data.pagination;
                            paginationContainer.style.display = 'block';
                        } else {
                            // Show no results message
                            const noDataRow = document.createElement('tr');
                            noDataRow.id = 'noDataRow';
                            noDataRow.innerHTML = `
                                <td colspan="7" class="text-center py-6 text-gray-500">
                                    ${search ? 'No registrations found for "' + search + '"' : 'No registrations found.'}
                                </td>
                            `;
                            tableBody.appendChild(noDataRow);
                            paginationContainer.style.display = 'none';
                        }

                        // Re-attach pagination event listeners
                        attachPaginationListeners();

                        currentPage = page;
                        currentSearch = search;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Show error message in table
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
                            loadData(page, currentSearch);
                        }
                    });
                });
            }

            // Debounced search function
            function debounceSearch() {
                const searchTerm = searchInput.value.trim();

                // Clear previous timeout
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }

                // If search term is empty, load immediately
                if (searchTerm === '') {
                    if (lastSearchTerm !== '') {
                        loadData(1, '');
                        lastSearchTerm = '';
                    }
                    return;
                }

                // If search term changed, search with debounce
                if (searchTerm !== lastSearchTerm) {
                    searchTimeout = setTimeout(() => {
                        loadData(1, searchTerm);
                        lastSearchTerm = searchTerm;
                    }, 500); // 500ms debounce delay
                }
            }

            // Search button click handler
            searchButton.addEventListener('click', function() {
                const searchTerm = searchInput.value.trim();
                if (searchTerm !== currentSearch) {
                    loadData(1, searchTerm);
                    if (searchTerm) {
                        clearSearch.style.display = 'block';
                    }
                }
            });

            // Keyup handler for search (real-time search)
            searchInput.addEventListener('keyup', function(e) {
                // Still allow Enter key for immediate search
                if (e.key === 'Enter') {
                    const searchTerm = searchInput.value.trim();
                    if (searchTerm !== currentSearch) {
                        loadData(1, searchTerm);
                        if (searchTerm) {
                            clearSearch.style.display = 'block';
                        }
                    }
                    return;
                }

                // Debounce for other keys
                debounceSearch();
            });

            // Input event for immediate UI feedback
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.trim();

                // Show/hide clear button
                if (searchTerm) {
                    clearSearch.style.display = 'block';
                } else {
                    clearSearch.style.display = 'none';
                    // If input is cleared, search immediately
                    if (lastSearchTerm !== '') {
                        loadData(1, '');
                        lastSearchTerm = '';
                    }
                }
            });

            // Clear search handler
            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                clearSearch.style.display = 'none';
                if (currentSearch) {
                    loadData(1, '');
                    lastSearchTerm = '';
                }
                searchInput.focus();
            });

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function() {
                const urlParams = new URLSearchParams(window.location.search);
                const searchParam = urlParams.get('search') || '';
                const pageParam = urlParams.get('page') || '1';

                if (searchParam !== currentSearch) {
                    searchInput.value = searchParam;
                    if (searchParam) {
                        clearSearch.style.display = 'block';
                    }
                    loadData(parseInt(pageParam), searchParam);
                }
            });

            // Initial attachment of pagination listeners
            attachPaginationListeners();

            // Focus search input on page load for better UX
            searchInput.focus();
        });
    </script>

    <style>
        .search-input {
            border: 1px solid var(--gray-border);
            border-radius: 4px;
            padding: 8px 12px;
            width: 100%;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(var(--primary-rgb), 0.1);
        }

        .search-input.searching {
            border-color: var(--info-color);
            box-shadow: 0 0 0 2px rgba(var(--info-rgb), 0.1);
        }

        .clear-search-button:hover {
            color: var(--danger-color);
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

        .action-btn-info {
            background-color: var(--info-color);
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

        /* Search loading indicator */
        @keyframes pulse {
            0% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.6;
            }
        }

        .search-loading .fa-search {
            animation: pulse 1.5s infinite;
        }
    </style>
@endsection