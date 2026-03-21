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
                    Data Entry >> Completed Scanned Lots
                </h3>

                <!-- Search Box -->
                <div class="search-container" style="position: relative; width: 300px;">
                    <input type="text" id="searchInput" class="form-control search-input"
                        placeholder="Search by Register No..." style="padding-right: 40px;" autocomplete="off"
                        value="{{ request('search') }}">
                    <button id="searchButton" class="search-button"
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; color: #6c757d;"
                        title="Search">
                        <i class="fas fa-search"></i>
                    </button>
                    <button id="clearSearch" class="clear-search-button"
                        style="display: {{ request('search') ? 'block' : 'none' }}; position: absolute; right: 35px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; color: #6c757d;"
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
                    <thead style="background: #0a4aa1 !important;">
                        <tr>
                            <th class="text-left text-xs font-semibold">Sl. No.</th>
                            <th class="text-left text-xs font-semibold">Lot No.</th>
                            <th class="text-left text-xs font-semibold">Register No.</th>
                            <th class="text-left text-xs font-semibold">Total Files</th>
                            <th class="text-left text-xs font-semibold">Assigned Files</th>
                            <th class="text-left text-xs font-semibold">Completed Files</th>
                            <th class="text-left text-xs font-semibold">Remaining Files</th>
                            <th class="text-left text-xs font-semibold">Assignment Type</th>
                            <th class="text-left text-xs font-semibold">Status</th>
                            <th class="text-left text-xs font-semibold">Scanned On</th>
                            <th class="text-left text-xs font-semibold">View Files</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse ($registrations as $key => $registration)
                            <tr>
                                <td>{{ $registrations->firstItem() + $key }}</td>
                                <td>{{ $registration->lot_no ?? '-' }}</td>
                                <td>
                                    @if (request('search'))
                                        {!! highlightText($registration->register_no, request('search')) !!}
                                    @else
                                        {{ $registration->register_no }}
                                    @endif
                                </td>
                                <td>{{ $registration->total_files ?? 0 }}</td>
                                <td>{{ $registration->assigned_files ?? 0 }}</td>
                                <td>{{ $registration->completed_files ?? 0 }}</td>
                                <td>{{ $registration->remaining_files ?? 0 }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $registration->assignment_status == 'partial' ? 'warning' : 'success' }}">
                                        {{ $registration->assignment_type_label ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>Sanned By <br> {{ $registration->scanned_named_by ?? 'System' }}</td>
                                <td>{{ formatDateTime($registration->updated_at) }}</td>
                                <td>
                                    <a href="{{ route('applicant.dataentry.scanned.lots.files', $registration->encoded_register_no) }}"
                                        class="action-btn action-btn-info" title="View Files">
                                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8 8H20M11 12H20M14 16H20M4 8H4.01M7 12H7.01M10 16H10.01"
                                                stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr id="noDataRow">
                                <td colspan="12" class="text-center py-6 text-gray-500">
                                    No registrations found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Replace your existing pagination section with this -->
                <div id="paginationContainer" class="p-4 border-top" style="border-color: var(--gray-border);">
                    @if ($registrations->hasPages())
                        {{ $registrations->withQueryString()->links('vendor.pagination.custom') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
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

        .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }

        .bg-success {
            background-color: #28a745;
            color: white;
        }

        .bg-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .bg-info {
            background-color: #17a2b8;
            color: white;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if elements exist before using them
            const searchInput = document.getElementById('searchInput');
            const clearBtn = document.getElementById('clearSearch');
            const tableBody = document.getElementById('tableBody');
            const paginationContainer = document.getElementById('paginationContainer');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const searchButton = document.getElementById('searchButton');

            // Exit if critical elements are missing
            if (!tableBody || !paginationContainer) {
                console.error('Required DOM elements not found');
                return;
            }

            let debounceTimer = null;

            function fetchData(page = 1, search = '') {
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'block';
                }

                const url = new URL("{{ route('applicant.dataentry.scanned.files') }}");
                url.searchParams.set('page', page);
                if (search) url.searchParams.set('search', search);

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(response => {
                        // Check if registrations exists in response
                        if (response && response.registrations) {
                            const registrations = response.registrations;

                            if (registrations.data && registrations.data.length > 0) {
                                updateTableBody(registrations.data, search, registrations.current_page,
                                    registrations.per_page);
                                updatePagination(registrations);
                            } else {
                                showNoData();
                                if (paginationContainer) paginationContainer.innerHTML = '';
                            }
                        } else {
                            showNoData();
                            if (paginationContainer) paginationContainer.innerHTML = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError();
                    })
                    .finally(() => {
                        if (loadingIndicator) {
                            loadingIndicator.style.display = 'none';
                        }
                    });
            }

            function updateTableBody(registrations, search, currentPage, perPage) {
                if (!registrations || registrations.length === 0) {
                    showNoData();
                    return;
                }

                let html = '';
                registrations.forEach((item, index) => {
                    const rowNumber = (currentPage - 1) * perPage + index + 1;

                    // Get scanned by name from the nested scanned_by object
                    const scannedByName = item.scanned_by?.name || item.scanned_named_by || 'System';

                    // Format date
                    const scannedOn = item.updated_at ? formatDateTime(item.updated_at) : '-';

                    html += `
                <tr>
                    <td class="text-center">${rowNumber}</td>
                    <td>${escapeHtml(item.lot_no || '-')}</td>
                    <td>${highlightText(escapeHtml(item.register_no || ''), search)}</td>
                    <td class="text-center">${item.total_files || 0}</td>
                    <td class="text-center">${item.assigned_files || 0}</td>
                    <td class="text-center">${item.completed_files || 0}</td>
                    <td class="text-center">${item.remaining_files || 0}</td>
                    <td>
                        <span class="badge ${item.assignment_status === 'partial' ? 'bg-warning' : 'bg-success'}">
                            ${escapeHtml(item.assignment_type_label || 'N/A')}
                        </span>
                    </td>
                    <td>Scanned By <br> ${escapeHtml(scannedByName)}</td>
                    <td>${scannedOn}</td>
                    <td class="text-center">
                        <a href="/applicant/scanned/lots/files/${item.encoded_register_no}" 
                           class="action-btn action-btn-info" title="View Files">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none">
                                <path d="M8 8H20M11 12H20M14 16H20M4 8H4.01M7 12H7.01M10 16H10.01"
                                    stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </td>
                </tr>
            `;
                });

                if (tableBody) {
                    tableBody.innerHTML = html;
                }
            }

            function updatePagination(paginationData) {
                if (!paginationContainer) return;

                if (!paginationData || !paginationData.links || paginationData.links.length <= 3) {
                    paginationContainer.innerHTML = '';
                    return;
                }

                let paginationHtml =
                    '<nav aria-label="Page navigation"><ul class="pagination justify-content-center mb-0">';

                paginationData.links.forEach(link => {
                    const isActive = link.active ? 'active' : '';
                    const isDisabled = !link.url ? 'disabled' : '';
                    const page = getPageFromUrl(link.url);

                    paginationHtml += `
                <li class="page-item ${isActive} ${isDisabled}">
                    <a class="page-link" href="#" data-page="${page || ''}" ${!link.url ? 'tabindex="-1" aria-disabled="true"' : ''}>
                        ${link.label.replace('&laquo;', '«').replace('&raquo;', '»')}
                    </a>
                </li>
            `;
                });

                paginationHtml += '</ul></nav>';
                paginationContainer.innerHTML = paginationHtml;

                // Attach click handlers to pagination links
                attachPaginationHandlers();
            }

            function getPageFromUrl(url) {
                if (!url) return null;
                try {
                    const urlObj = new URL(url);
                    return urlObj.searchParams.get('page');
                } catch (e) {
                    return null;
                }
            }

            function attachPaginationHandlers() {
                if (!paginationContainer) return;

                paginationContainer.querySelectorAll('.page-link[data-page]').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = this.dataset.page;
                        if (page && searchInput) {
                            fetchData(page, searchInput.value.trim());
                        }
                    });
                });
            }

            function highlightText(text, search) {
                if (!search || !text) return text || '-';
                try {
                    const regex = new RegExp(`(${escapeRegExp(search)})`, 'gi');
                    return text.replace(regex, '<span class="highlight">$1</span>');
                } catch (e) {
                    return text;
                }
            }

            function escapeHtml(text) {
                if (!text) return text;
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }

            function capitalizeFirst(string) {
                if (!string) return '';
                return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
            }

            function formatDateTime(datetime) {
                if (!datetime) return '-';
                try {
                    const date = new Date(datetime);
                    return date.toLocaleString('en-IN', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true
                    });
                } catch (e) {
                    return datetime;
                }
            }

            function showNoData() {
                if (!tableBody) return;
                tableBody.innerHTML = `
            <tr>
                <td colspan="12" class="text-center py-6 text-gray-500">
                    No registrations found.
                </td>
            </tr>
        `;
            }

            function showError() {
                if (!tableBody) return;
                tableBody.innerHTML = `
            <tr>
                <td colspan="12" class="text-center text-danger py-4">
                    Error loading data. Please try again.
                </td>
            </tr>
        `;
            }

            // Only attach event listeners if elements exist
            if (searchInput) {
                // Search input with debounce
                searchInput.addEventListener('input', function() {
                    const value = this.value.trim();
                    if (clearBtn) {
                        clearBtn.style.display = value ? 'block' : 'none';
                    }

                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        fetchData(1, value);
                    }, 400);
                });

                // Enter key in search input
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        fetchData(1, this.value.trim());
                    }
                });
            }

            if (searchButton) {
                // Search button click
                searchButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (searchInput) {
                        fetchData(1, searchInput.value.trim());
                    }
                });
            }

            if (clearBtn) {
                // Clear search
                clearBtn.addEventListener('click', function() {
                    if (searchInput) {
                        searchInput.value = '';
                        clearBtn.style.display = 'none';
                        fetchData(1, '');
                    }
                });
            }

            // Initial load - show clear button if search exists
            if (searchInput && searchInput.value.trim()) {
                if (clearBtn) clearBtn.style.display = 'block';
            }
        });
    </script>
@endpush

@php
    function highlightText($text, $search)
    {
        if (!$search || !$text) {
            return e($text);
        }
        $pattern = '/' . preg_quote($search, '/') . '/i';
        return preg_replace($pattern, '<span class="highlight">$0</span>', e($text));
    }
@endphp
