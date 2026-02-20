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
                    Scanning >> Completed Scanned Lots
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
                    <thead style="background: #0a4aa1 !important;">
                        <tr>
                            <th class="text-left text-xs font-semibold">Sl. No.</th>
                            <th class="text-left text-xs font-semibold">Lot No.</th>
                            <th class="text-left text-xs font-semibold">Register No.</th>
                            <th class="text-left text-xs font-semibold">No. of Files Scanned</th>
                            <th class="text-left text-xs font-semibold">Total Pages</th>
                            <th class="text-left text-xs font-semibold">Status</th>
                            <th class="text-left text-xs font-semibold">Scanned on (Date & Time)</th>
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
                                    {{ $registration->register_no }}
                                </td>

                                <td class="py-2">
                                    {{ $registration->scanned_count ?? 0 }}
                                </td>

                                <td class="py-2">
                                    {{ $registration->allottees->sum('total_pages') ?? 0 }}
                                </td>
                                <td class="py-2">
                                    {{ ucfirst($registration->status ?? 'Unknown') }} by
                                    {{ $registration->scanned_by->name ?? 'System' }}
                                </td>
                                <td class="py-2">
                                    {{ formatDateTime($registration->updated_at) }}
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
            const clearBtn = document.getElementById('clearSearch');
            const tableBody = document.getElementById('tableBody');
            const paginationContainer = document.getElementById('paginationContainer');
            const loadingIndicator = document.getElementById('loadingIndicator');

            let debounceTimer = null;

            function fetchData(page = 1, search = '') {

                loadingIndicator.style.display = 'block';

                const url = new URL("{{ route('applicant.scanning.completed') }}");
                url.searchParams.set('page', page);
                if (search) url.searchParams.set('search', search);

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {

                        tableBody.innerHTML = '';

                        if (data.registrations.data.length === 0) {
                            tableBody.innerHTML = `
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">
                                    No registrations found.
                                </td>
                            </tr>`;
                            paginationContainer.innerHTML = '';
                            return;
                        }

                        data.registrations.data.forEach((item, index) => {

                            const rowNumber =
                                (data.registrations.current_page - 1) *
                                data.registrations.per_page + index + 1;

                            tableBody.innerHTML += `
                            <tr>
                                <td>${rowNumber}</td>
                                <td>${item.lot_no ?? '-'}</td>
                                <td>
                                    ${highlight(item.register_no, search)}
                                </td>
                                <td>${item.scanned_count ?? 0}</td>
                                <td>
                                    ${item.status ? `${item.status.charAt(0).toUpperCase() + item.status.slice(1)} by ${item.scanned_by ? item.scanned_by.name : 'System'}` : 'Unknown'}
                                </td>
                                <td>${item.updated_at ? new Date(item.updated_at).toLocaleString() : '-'}</td>
                            </tr>
                            `;
                        });

                        paginationContainer.innerHTML = data.pagination;

                        attachPagination();

                    })
                    .catch(() => {
                        tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-danger py-4">
                        Error loading data.
                    </td>
                </tr>`;
                    })
                    .finally(() => {
                        loadingIndicator.style.display = 'none';
                    });
            }

            function highlight(text, search) {
                if (!search) return text;
                const regex = new RegExp(`(${search})`, 'gi');
                return text.replace(regex, '<span class="highlight">$1</span>');
            }

            function attachPagination() {
                document.querySelectorAll('#paginationContainer a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = new URL(this.href).searchParams.get('page');
                        fetchData(page, searchInput.value.trim());
                    });
                });
            }

            // Debounced Search
            searchInput.addEventListener('input', function() {

                const value = this.value.trim();
                clearBtn.style.display = value ? 'block' : 'none';

                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetchData(1, value);
                }, 400);
            });

            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                clearBtn.style.display = 'none';
                fetchData();
            });

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
