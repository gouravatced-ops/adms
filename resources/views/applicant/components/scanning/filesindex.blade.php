@extends('applicant.dashboard_layouts.main')

@section('title', 'File Receiving – Files')

@section('content')
    <style>
        <style>.save-btn {
            background: #358202;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            min-width: 80px;
        }

        .save-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Loader circle */
        .btn-loader {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid white;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            margin: auto;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    </style>
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
                <div class="flex items-start justify-between">
                    <div>
                        <!-- Subtitle -->
                        <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <i class="fas fa-folder-open"></i>
                            Scanning >> Make Entries of Allottee's Scanned Files Pages
                        </h3>

                        <!-- Title BELOW subtitle -->
                        <p class="text-xs text-gray-500 mt-1" id="registerNumber">
                            Registration No: {{ $registerNo ?? '-' }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('applicant.scanning.index') }}">
                            <button class="btn btn-info" style="background: rgb(3, 138, 222); color:white;">
                                Back
                            </button>
                        </a>
                        {{--
                    <!-- Generate PDF Button -->
                    <button class="pdf-btn" onclick="openPdfModal()">
                        <svg class="pdf-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M6 2h7l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" />
                            <path d="M13 2v5h5" />
                            <text x="7" y="17" font-size="6" font-weight="700" fill="white">PDF</text>
                        </svg>
                        Download PDF
                    </button> --}}
                    </div>
                </div>

                <!-- Search Box with Filters -->
                {{-- <div class="search-container" style="margin-top: 10px;">
                <div class="row" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-end;">
                    <div class="col" style="flex: 1; min-width: 200px;">
                        <label style="font-size: 12px; color: #6c757d; margin-bottom: 4px; display: block;">Search
                            Allottee</label>
                        <input type="text" id="searchAllottee" class="form-control search-input"
                            placeholder="Search by allottee name..." style="padding: 8px 12px;" autocomplete="off">
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
                        <button id="searchButton" class="btn btn-primary"
                            style="padding: 8px 16px; white-space: nowrap;">
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
                <table id="studentListTable" class="table table-striped table-bordered align-middle w-full">
                    <thead class="table-light" style="background: #f8c904 !important;color: #000000 !important;">
                        <tr>
                            <th width="50">Sl. No.</th>
                            <th>Div./Sub-Div.</th>
                            <th>Prop. Category</th>
                            <th>Prop. No.</th>
                            <th>Allottee Name</th>
                            <th>Total Files</th>
                            <th>Total Scanned Pages</th>
                        </tr>
                    </thead>

                    <tbody id="tableBody">
                        @forelse ($registerAllottee as $key => $file)
                            <tr style="background:#fef5d4;">
                                <!-- SL -->
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $file->dname }}/{{ $file->subname }}</td>

                                <td>{{ $file->cname }}-{{ $file->quarter_code }}</td>

                                <td>{{ $file->property_number }}</td>

                                <td>
                                    <strong class="fw-semibold text-success">
                                        {{ $file->prefix }} {{ $file->allottee_name }} {{ $file->allottee_middle_name }} {{ $file->allottee_surname }}
                                    </strong>
                                </td>

                                <td>
                                    <strong class="fw-semibold">
                                        {{ $file->total_files }}
                                    </strong>
                                </td>
                                <td style="background: #7fffd4 !important;">
                                    <span class="pages-counter"> 0 </span>
                                </td>
                            </tr>

                            {{-- File Pages Inputs Row --}}
                            @if ($file->total_files > 0)
                                <tr style="background:#f3efe5;">
                                    <td colspan="7">
                                        <form action="{{ route('applicant.scanning.store') }}" method="post"
                                            class="scan-form">
                                            @csrf

                                            <input type="hidden" name="allottee_id" value="{{ $file->id }}">
                                            <input type="hidden" name="register_no" value="{{ $registerNo }}">

                                            <div class="d-flex gap-2 flex-wrap align-items-center">

                                                @for ($i = 1; $i <= $file->total_files; $i++)
                                                    <input type="number" name="file_pages[]" value="0"
                                                        class="form-control w-auto page-input"
                                                        style="width: 80px !important;"
                                                        placeholder="File-{{ $i }}" min="1"
                                                        max="999">
                                                @endfor
                                                <button type="submit" class="btn btn-success save-btn"
                                                    style="background:#358202; color:white;">
                                                    <span class="btn-text">Save</span>
                                                    <span class="btn-loader"></span>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endif

                        @empty
                            <tr id="noDataRow">
                                <td colspan="6" class="text-center text-muted py-4">
                                    <div class="py-3">
                                        <i class="bx bx-folder-open bx-lg text-muted mb-3"></i>
                                        <h6>No Files Found</h6>
                                        <p class="mb-0">No Allottee's Scanned Files Pages</p>
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

    <script>
        document.addEventListener("input", function(e) {

            if (e.target.classList.contains("page-input")) {

                let row = e.target.closest("tr").previousElementSibling;
                let inputs = e.target.closest("tr").querySelectorAll(".page-input");

                let total = 0;

                inputs.forEach(function(input) {
                    total += parseInt(input.value) || 0;
                });

                row.querySelector(".pages-counter").textContent = total;
            }

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // When user leaves input → lock it
            document.addEventListener("blur", function(e) {
                if (e.target.classList.contains("page-input")) {

                    let value = parseInt(e.target.value);

                    // Only lock if value is valid and greater than 0
                    if (!isNaN(value) && value > 0) {
                        e.target.setAttribute("readonly", true);
                        e.target.classList.add("bg-light");
                    }
                }
            }, true);

            // Double click to unlock
            document.addEventListener("dblclick", function(e) {
                if (e.target.classList.contains("page-input")) {
                    e.target.removeAttribute("readonly");
                    e.target.classList.remove("bg-light");
                    e.target.focus();
                }
            });

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.querySelectorAll(".scan-form").forEach(function(form) {

                form.addEventListener("submit", function() {

                    let button = form.querySelector(".save-btn");
                    let text = button.querySelector(".btn-text");
                    let loader = button.querySelector(".btn-loader");

                    // Disable button
                    button.disabled = true;

                    // Hide text
                    text.style.display = "none";

                    // Show loader
                    loader.style.display = "inline-block";

                });

            });

        });
    </script>



@endsection
