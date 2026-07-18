@extends('admin.layouts.main')

@section('admin-content')
    <style>
        .status-completed {
            display: inline-block;
            width: 18px;
            height: 18px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 18px;
            font-size: 14px;
            margin-left: 5px;
        }

        .status-pending {
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
            border-radius: 50%;
            background: #ffc107;
            color: #212529;
            font-size: 12px;
            font-weight: 600;
        }

        .status-rejected {
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
            border-radius: 50%;
            background: #dc3545;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
        }

        .pending-days {
            color: #dc2626;
            font-weight: 600;
        }

        .pending-hours {
            color: #f59e0b;
            font-weight: 600;
        }

        .pending-mins {
            color: #16a34a;
            font-weight: 600;
        }

        .pending-secs {
            color: #2563eb;
            font-weight: 600;
        }

        .not-pending {
            color: #6b7280;
            font-style: italic;
        }

        #searchLoadingOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.35em 0.65em;
        }
    </style>

    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Pending for Approval Files / {{ $Lots }} :
                {{ $registerNo }}</span>
        </h6>

        @php
            $isApprover = auth('admin')->user()->role === 'approver';
        @endphp

        <div class="card mb-4">
            <div
                class="card-header {{ $isApprover ? 'bg-secondary' : 'bg-info' }} d-flex justify-content-between align-items-center">
                <h5 class="text-white mb-0">Pending for Approval Files</h5>
                <div class="btn-group">
                    @if (auth('admin')->user()->role == 'approver')
                        <button type="button" class="btn btn-light btn-sm">
                            <a href="{{ route('approver.pending-lots') }}" class="text-decoration-none text-dark">
                                ← Back
                            </a>
                        </button>
                    @endif
                    @if (auth('admin')->user()->role == 'divisional_admin')
                        <button type="button" class="btn btn-dark btn-sm" id="selectAll">Select All</button>
                        &nbsp;
                        <button type="button" class="btn btn-light btn-sm">
                            <a href="{{ route('approver.admin.pending-lots') }}" class="text-decoration-none text-dark">
                                ← Back
                            </a>
                        </button>
                    @endif
                </div>
            </div>

            <div class="card-body mt-0 p-3">
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

                {{-- Search Filters Section --}}
                <div class="card mb-3 border">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="bx bx-search-alt me-1"></i> Search Filters
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control search-filter" id="searchName"
                                    placeholder="Search by name..." autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Property No</label>
                                <input type="text" class="form-control search-filter" id="searchPropertyNo"
                                    placeholder="Search property no..." autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sub Division</label>
                                <select class="form-select search-filter" id="searchSubDivision">
                                    <option value="">All Sub Divisions</option>
                                    @foreach ($subDivisions ?? [] as $subDivision)
                                        <option value="{{ $subDivision->id }}">{{ $subDivision->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Property Category</label>
                                <select class="form-select search-filter" id="searchPropertyCategory">
                                    <option value="">All Categories</option>
                                    @foreach ($propertyCategories ?? [] as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Property Type</label>
                                <select class="form-select search-filter" id="searchPropertyType">
                                    <option value="">All Property Types</option>
                                    @foreach ($propertyTypes ?? [] as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Property Sub Categories</label>
                                <select class="form-select search-filter" id="searchSubCategory">
                                    <option value="">All Sub Categories</option>
                                    @foreach ($propertySubCategories ?? [] as $subCategory)
                                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-secondary w-100" id="resetFilters">
                                    <i class="bx bx-reset"></i> Reset Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Loading Overlay --}}
                <div id="searchLoadingOverlay">
                    <div class="text-center bg-white p-4 rounded shadow">
                        <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <h6>Searching files...</h6>
                    </div>
                </div>

                @if (auth('admin')->user()->role == 'divisional_admin')
                    <form id="bulkForm" action="{{ route('admin.selected.files.approved') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" id="bulkAssignBtn" disabled>
                                <i class="bx bx-check"></i> Approved Selected
                            </button>
                            <input type="hidden" name="encodedIdregister" value="{{ base64_encode($registerNo) }}">
                            <span class="text-muted ms-2" id="selectedCount">0 items selected</span>
                        </div>
                        <div id="selectedInputs"></div>
                    </form>
                @endif

                <div class="table-responsive" id="tableContainer">
                    <div id="tableContent">
                        {{-- Table content will be loaded here --}}
                        @include('admin.components.approver.partials.pending_files_table')
                    </div>
                </div>

                {{-- Verify Modal --}}
                <div class="modal fade" id="verifyDataEntryLotModal" tabindex="-1"
                    aria-labelledby="verifyDataEntryLotModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.lots.dataentry.lots.approve', ['registerId' => $registerNo]) }}"
                                method="POST">
                                @csrf
                                <div class="modal-header bg-success text-white" style="padding: 10px !important;">
                                    <h5 class="modal-title text-white">Verify & Approve Lot</h5>
                                    <button type="button" class="btn-close btn-close-white"
                                        data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3 p-3 border rounded bg-light">
                                        <strong>Register:</strong> {{ $registerNo }} <br>
                                        <strong>Lot No:</strong> {{ $Lots }}
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Remarks
                                            <small class="text-muted">(Optional)</small>
                                        </label>
                                        <textarea name="remarks" rows="4" class="form-control" placeholder="Enter approval remarks..."></textarea>
                                    </div>
                                    <input type="hidden" name="status" value="verified">
                                </div>
                                <hr style="margin:0;">
                                <div class="modal-footer" style="padding: 10px !important;">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bx bx-check-circle me-1"></i> Verify & Approve
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let searchTimeout;
        let currentPage = 1;
        let isLoading = false;

        function showLoading(show) {
            const overlay = document.getElementById('searchLoadingOverlay');
            if (overlay) {
                overlay.style.display = show ? 'flex' : 'none';
                isLoading = show;
            }
        }

        function getFilterValues() {
            return {
                name: document.getElementById('searchName')?.value || '',
                property_no: document.getElementById('searchPropertyNo')?.value || '',
                sub_division: document.getElementById('searchSubDivision')?.value || '',
                property_type: document.getElementById('searchPropertyType')?.value || '',
                property_category: document.getElementById('searchPropertyCategory')?.value || '',
                property_sub_category: document.getElementById('searchSubCategory')?.value || '',
                page: currentPage,
                register_no: '{{ $registerNo ?? '' }}',
                encoded_id: '{{ $encodedId ?? '' }}'
            };
        }

        async function performSearch() {
            if (isLoading) return;

            showLoading(true);

            try {
                const filters = getFilterValues();
                const url = `{{ route('admin.pending.files.search') }}`;

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(filters)
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                if (data.success) {
                    const tableContainer = document.getElementById('tableContent');
                    if (tableContainer) {
                        tableContainer.innerHTML = data.html;
                    }

                    // Update URL without reload
                    const urlParams = new URLSearchParams(window.location.search);
                    Object.keys(filters).forEach(key => {
                        if (filters[key] && key !== 'page' && key !== 'register_no' && key !== 'encoded_id') {
                            urlParams.set(key, filters[key]);
                        } else if (!filters[key] && key !== 'page' && key !== 'register_no' && key !==
                            'encoded_id') {
                            urlParams.delete(key);
                        }
                    });
                    urlParams.set('page', currentPage);
                    const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
                    window.history.pushState({}, '', newUrl);

                    reinitializeComponents();
                }
            } catch (error) {
                console.error('Search error:', error);
                const tableContainer = document.getElementById('tableContent');
                if (tableContainer) {
                    tableContainer.innerHTML =
                        '<div class="alert alert-danger m-3">Error loading data. Please try again.</div>';
                }
            } finally {
                showLoading(false);
            }
        }

        function reinitializeComponents() {
            // Reinitialize checkboxes
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const selectAllBtn = document.getElementById('selectAll');
            const bulkBtn = document.getElementById('bulkAssignBtn');
            const selectedCount = document.getElementById('selectedCount');
            const selectedInputs = document.getElementById('selectedInputs');
            const bulkForm = document.getElementById('bulkForm');

            function updateSelection() {
                let selected = [];
                document.querySelectorAll('.row-checkbox').forEach(cb => {
                    if (cb.checked) selected.push(cb.value);
                });

                if (selectedCount) selectedCount.innerText = selected.length + ' items selected';
                if (bulkBtn) bulkBtn.disabled = selected.length === 0;

                if (selectedInputs) {
                    selectedInputs.innerHTML = '';
                    selected.forEach(id => {
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selectedId[]';
                        input.value = id;
                        selectedInputs.appendChild(input);
                    });
                }
            }

            if (checkboxes.length) {
                checkboxes.forEach(cb => cb.addEventListener('change', updateSelection));
            }

            if (selectAllBtn) {
                let allSelected = false;
                const newSelectAllBtn = selectAllBtn.cloneNode(true);
                selectAllBtn.parentNode.replaceChild(newSelectAllBtn, selectAllBtn);

                newSelectAllBtn.addEventListener('click', function() {
                    allSelected = !allSelected;
                    document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = allSelected);
                    this.innerText = allSelected ? 'Unselect All' : 'Select All';
                    updateSelection();
                });
            }

            if (bulkBtn && bulkForm) {
                const newBulkBtn = bulkBtn.cloneNode(true);
                bulkBtn.parentNode.replaceChild(newBulkBtn, bulkBtn);

                newBulkBtn.addEventListener('click', function() {
                    if (confirm('Are you sure to approve selected records?')) {
                        bulkForm.submit();
                    }
                });
            }

            updateSelection();

            // Reinitialize pending times
            updatePendingTimes();
        }

        function updatePendingTimes() {
            document.querySelectorAll('.pending-time').forEach(el => {
                const rawDate = el.dataset.date;
                if (!rawDate || rawDate === 'null') {
                    el.innerHTML = '<span class="not-pending">Not Pending</span>';
                    return;
                }
                const date = new Date(rawDate);
                if (isNaN(date.getTime())) {
                    el.innerHTML = '<span class="not-pending">Not Pending</span>';
                    return;
                }
                const now = new Date();
                let diff = Math.floor((now - date) / 1000);
                if (diff <= 0) {
                    el.innerHTML = '<span class="not-pending">Not Pending</span>';
                    return;
                }
                const days = Math.floor(diff / 86400);
                diff %= 86400;
                const hours = Math.floor(diff / 3600);
                diff %= 3600;
                const mins = Math.floor(diff / 60);
                const secs = diff % 60;
                let html = 'Pending for Approval Since <br>';
                if (days) html += `<span class="pending-days">${days} day${days > 1 ? 's' : ''}</span> `;
                if (hours) html += `<span class="pending-hours">${hours} hr${hours > 1 ? 's' : ''}</span> `;
                if (mins) html += `<span class="pending-mins">${mins} min${mins > 1 ? 's' : ''}</span> `;
                html += `<span class="pending-secs">${secs} sec${secs > 1 ? 's' : ''}</span>`;
                el.innerHTML = html;
            });
        }

        function debouncedSearch() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentPage = 1;
                performSearch();
            }, 500);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Category → Type cascade
            const categorySelect = document.getElementById('searchPropertyCategory');
            if (categorySelect) {
                categorySelect.addEventListener('change', function() {
                    const categoryId = this.value;
                    const typeSelect = document.getElementById('searchPropertyType');
                    const subCategorySelect = document.getElementById('searchSubCategory');
                    
                    if (typeSelect) {
                        typeSelect.innerHTML = '<option value="">Loading...</option>';
                        typeSelect.value = '';
                    }
                    if (subCategorySelect) {
                        subCategorySelect.innerHTML = '<option value="">All Sub Categories</option>';
                        subCategorySelect.value = '';
                    }
                    
                    if (!categoryId) {
                        if (typeSelect) {
                            typeSelect.innerHTML = '<option value="">All Property Types</option>';
                        }
                        return;
                    }
                    
                    fetch(`/get-property-types/${categoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            let options = '<option value="">All Property Types</option>';
                            data.forEach(item => {
                                options += `<option value="${item.id}">${item.name}</option>`;
                            });
                            if (typeSelect) {
                                typeSelect.innerHTML = options;
                            }
                        })
                        .catch(() => {
                            if (typeSelect) {
                                typeSelect.innerHTML = '<option value="">Error loading data</option>';
                            }
                        });
                });
            }

            // Type → Sub Category cascade
            const typeSelect = document.getElementById('searchPropertyType');
            if (typeSelect) {
                typeSelect.addEventListener('change', function() {
                    const typeId = this.value;
                    const subCategorySelect = document.getElementById('searchSubCategory');
                    
                    if (subCategorySelect) {
                        subCategorySelect.innerHTML = '<option value="">Loading...</option>';
                        subCategorySelect.value = '';
                    }
                    
                    if (!typeId) {
                        if (subCategorySelect) {
                            subCategorySelect.innerHTML = '<option value="">All Sub Categories</option>';
                        }
                        return;
                    }
                    
                    fetch(`/get-property-sub-types/${typeId}`)
                        .then(response => response.json())
                        .then(data => {
                            let options = '<option value="">All Sub Categories</option>';
                            data.forEach(item => {
                                options += `<option value="${item.id}">${item.name}</option>`;
                            });
                            if (subCategorySelect) {
                                subCategorySelect.innerHTML = options;
                            }
                        })
                        .catch(() => {
                            if (subCategorySelect) {
                                subCategorySelect.innerHTML = '<option value="">Error loading data</option>';
                            }
                        });
                });
            }

            const searchInputs = ['searchName', 'searchPropertyNo', 'searchSubDivision',
                'searchPropertyType', 'searchPropertyCategory', 'searchSubCategory'
            ];

            searchInputs.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', debouncedSearch);
                    element.addEventListener('change', debouncedSearch);
                }
            });

            const resetBtn = document.getElementById('resetFilters');
            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    searchInputs.forEach(id => {
                        const element = document.getElementById(id);
                        if (element) {
                            if (element.tagName === 'SELECT') {
                                element.value = '';
                            } else {
                                element.value = '';
                            }
                        }
                    });
                    currentPage = 1;
                    performSearch();
                });
            }

            // Pagination handling
            document.getElementById('tableContent')?.addEventListener('click', function(e) {
                const paginationLink = e.target.closest('.pagination a');
                if (paginationLink && !isLoading) {
                    e.preventDefault();
                    const url = new URL(paginationLink.href);
                    const page = url.searchParams.get('page');
                    if (page) {
                        currentPage = parseInt(page);
                        performSearch();
                    }
                }
            });

            // Load filters from URL
            const urlParams = new URLSearchParams(window.location.search);
            let hasFilters = false;
            searchInputs.forEach(id => {
                const element = document.getElementById(id);
                const paramName = id.replace('search', '').toLowerCase();
                const paramValue = urlParams.get(paramName);
                if (element && paramValue) {
                    element.value = paramValue;
                    hasFilters = true;
                }
            });

            const pageParam = urlParams.get('page');
            if (pageParam) currentPage = parseInt(pageParam);

            if (hasFilters) performSearch();

            updatePendingTimes();
            setInterval(updatePendingTimes, 1000);
        });
    </script>
@endsection
