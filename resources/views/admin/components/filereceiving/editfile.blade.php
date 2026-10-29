@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">

        @php
            $statusStage = $statusStage ?? 'N/A';

            $statusClasses = [
                'received' => 'bg-primary',
                'scanned'  => 'bg-warning text-dark',
                'handover' => 'bg-success',
                'dataentry' => 'bg-info',
            ];
        @endphp

        <h6 class="py-3 mb-2">
            <span class="invert-text-white">
                Dashboard / Edit File: {{ $fullName }} /

                <span @class([
                    'badge',
                    $statusClasses[$statusStage] ?? 'bg-secondary',
                ])>
                    {{ ucfirst($statusStage) }}
                </span>
            </span>
        </h6>


        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">
                <i class="bx bx-pencil me-2"></i>Edit Allottee File
            </h5>
            <div class="card-body mt-2">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @php
                    $quarterTypes = getQuarterType();
                    $getPropertyCategory = getPropertyCategory();
                    $subdivision = getSubDivisions($file->division_id);
                    $propertyType = getPropertyType($file->pcategory_id);
                    $propertySubtype = getPropertySubType($file->p_type_id);
                @endphp
                <form action="{{ route('admin.receiving.file.update', ['encryptedId' => $encryptedId]) }}" method="POST" class="row g-3 align-items-end"
                    id="schemeForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="encoded_register_no" value="{{ $file->encoded_register_no }}">
                    <input type="hidden" name="encryptedId" value="{{ $encryptedId }}">

                     <!-- Register No. -->
                     <div class="col-md-4">
                        <label for="register_no" class="form-label">
                            Register No. <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" id="register_no" name="register_no" value="{{ $file->register_id }}" disabled>
                    </div>

                    <!-- Division Name -->
                    <div class="col-md-4">
                        <label class="form-label">Division <small class="text-danger">*</small></label>
                        <select name="division_id" id="division_id"
                            class="form-select @error('division_id') is-invalid @enderror" required>
                             @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ $division->id == $file->division_id ? 'selected' : '' }}>{{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('division_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <!-- Sub Division Name -->
                    <div class="col-md-4">
                        <label class="form-label">Sub Division <small class="text-danger">*</small></label>
                        <select name="sub_division_id" id="sub_division_id" class="form-select" required>
                            @foreach ($subdivision as $division)
                                <option value="{{ $division->id }}"
                                    {{ $division->id == $file->sub_division_id ? 'selected' : '' }}>
                                    {{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Property Category -->
                    <div class="col-md-4">
                        <label class="form-label">Property Category <small class="text-danger">*</small></label>
                        <select name="pcategory_id" id="property_category" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($getPropertyCategory as $PropertyCategory)
                                <option value="{{ $PropertyCategory->id }}"
                                    {{ $PropertyCategory->id == $file->pcategory_id ? 'selected' : '' }}>
                                    {{ $PropertyCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Property Type <small class="text-danger">*</small></label>
                        <select name="p_type_id" id="property_type" class="form-select" required>
                            @foreach ($propertyType as $ptype)
                                <option value="{{ $ptype->id }}"
                                    {{ $ptype->id == $file->p_type_id ? 'selected' : '' }}>
                                    {{ $ptype->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-4" id="quarter_type_div">
                        <label class="form-label">Quarter Type <small class="text-danger">*</small></label>
                        <select name="quarter_type" id="quarter_type" class="form-select" required>
                            @foreach ($quarterTypes as $qt)
                                <option value="{{ $qt->quarter_id }}"
                                    {{ $qt->quarter_id == $file->quarter_type ? 'selected' : '' }}>
                                    {{ $qt->quarter_code }} - {{ $qt->quarter_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="property_number" class="form-label">
                            Property Number <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" id="property_number" name="property_number"
                            value="{{ $file->property_number }}" placeholder="Enter Property Number" required>
                    </div>

                    <div class="col-md-4">
                        <label for="prefix" class="form-label">
                            Prefix
                        </label>
                         @php $prefixes = ['Shri', 'Smt.', 'Miss', 'Dr.', 'Md.', 'Late', 'M/S' , 'Maj.' , 'Capt.']; @endphp
                        <select name="prefix" id="prefix" class="form-select">
                            <option value="">Select Prefix</option>
                            @foreach ($prefixes as $prefix)
                                <option value="{{ $prefix }}"
                                    {{ $file->prefix == $prefix ? 'selected' : '' }}>
                                    {{ $prefix }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="allottee_name" class="form-label">
                            First Name <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" id="allottee_name" name="allottee_name"
                            value="{{ $file->allottee_name }}" placeholder="Enter First Name" required>
                    </div>

                    <div class="col-md-4">
                        <label for="allottee_middle_name" class="form-label">
                            Middle Name
                        </label>
                        <input type="text" class="form-control" id="allottee_middle_name" name="allottee_middle_name"
                            value="{{ $file->allottee_middle_name }}" placeholder="Enter Middle Name">
                    </div>

                    <div class="col-md-4">
                        <label for="allottee_surname" class="form-label">
                            Surname
                        </label>
                        <input type="text" class="form-control" id="allottee_surname" name="allottee_surname"
                            value="{{ $file->allottee_surname }}" placeholder="Enter Surname">
                    </div>

                    {{-- No. of Files --}}
                    <div class="col-md-4">
                        <label for="no_of_files" class="form-label">
                            No. of Files <small class="text-danger">*</small>
                        </label>
                        <select name="no_of_files" required="" class="form-select">
                            <option value="1" {{ $file->no_of_files == 1 ? 'selected' : '' }}>1</option>
                            <!-- <option value="2" {{ $file->no_of_files == 2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $file->no_of_files == 3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ $file->no_of_files == 4 ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $file->no_of_files == 5 ? 'selected' : '' }}>5</option>
                            <option value="6" {{ $file->no_of_files == 6 ? 'selected' : '' }}>6</option>
                            <option value="7" {{ $file->no_of_files == 7 ? 'selected' : '' }}>7</option>
                            <option value="8" {{ $file->no_of_files == 8 ? 'selected' : '' }}>8</option> -->
                        </select>
                    </div>

                    {{-- Additional Supplements Files --}}
                    <div class="col-md-4">
                        <label for="no_of_supplement" class="form-label">
                            Additional Supplement Files
                        </label>
                        <select name="no_of_supplement" id="no_of_supplement" class="form-select">
                            <option value="0" {{ $file->no_of_supplement == 0 ? 'selected' : '' }}>0</option>
                            <option value="1" {{ $file->no_of_supplement == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $file->no_of_supplement == 2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $file->no_of_supplement == 3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ $file->no_of_supplement == 4 ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $file->no_of_supplement == 5 ? 'selected' : '' }}>5</option>
                            <option value="6" {{ $file->no_of_supplement == 6 ? 'selected' : '' }}>6</option>
                        </select>
                    </div>

                    {{-- Remarks --}}
                    <div class="col-md-4">
                        <label for="remarks" class="form-label">
                            Remarks
                        </label>
                        <select name="remarks" id="remarks" class="form-select">
                            <option value="">-- Select Page Condition --</option>
                            <option value="All Fresh Pages" {{ $file->remarks == 'All Fresh Pages' ? 'selected' : '' }}>All Fresh Pages</option>
                            <option value="All Old Pages" {{ $file->remarks == 'All Old Pages' ? 'selected' : '' }}>All Old Pages</option>
                            <option value="All Poor Quality Pages" {{ $file->remarks == 'All Poor Quality Pages' ? 'selected' : '' }}>All Poor Quality Pages</option>
                            <option value="Partial Fresh and Old Pages" {{ $file->remarks == 'Partial Fresh and Old Pages' ? 'selected' : '' }}>Partial Fresh and Old Pages</option>
                        </select>
                    </div>

                    @php
                        $pagesData = $file->json_pages ? json_decode($file->json_pages, true) : [];
                        if (!is_array($pagesData)) {
                            $pagesData = [];
                        }
                        $totalFilesCount = 1 + (int) ($file->no_of_supplement ?? 0);
                    @endphp

                    @if($statusStage == 'scanned')
                        <hr>
                        <br>
                        <span><strong>No. of Files : </strong><span id="display_no_of_files">{{ $file->no_of_files ?? 1 }}</span></span>
                        <span><strong>Additional Supplement Files : </strong><span id="display_no_of_supplement">{{ $file->no_of_supplement ?? 0 }}</span></span>
                        <span><strong>Total Pages : </strong><span id="display_total_pages">{{ $file->total_pages ?? 0 }}</span></span>

                        <!-- Create Box of files pages -->
                        {{-- [json_pages] => [{"file_name":"File-1","pages":242},{"file_name":"File-2","pages":71}] --}}
                        <input type="hidden" name="total_pages" id="total_pages_input" value="{{ $file->total_pages ?? 0 }}">
                        <input type="hidden" name="json_pages" id="json_pages_input" value="{{ $file->json_pages }}">

                        <div class="col-12">
                            <label class="form-label fw-bold text-primary">Files & Pages Details</label>
                            <div class="card mb-3">
                                <div class="card-body p-0">
                                    <table class="table table-bordered mb-0" id="filesPagesTable">
                                        <thead>
                                            <tr>
                                                <th style="width: 50%;">File Name</th>
                                                <th style="width: 50%;">Number of Pages</th>
                                            </tr>
                                        </thead>
                                        <tbody id="filesPagesTbody">
                                            @for ($i = 0; $i < $totalFilesCount; $i++)
                                                @php
                                                    $fileName = $pagesData[$i]['file_name'] ?? 'File-' . ($i + 1);
                                                    $pageCount = $pagesData[$i]['pages'] ?? 0;
                                                    $fileLabel = $i === 0 ? $fileName . ' (Main File)' : $fileName . ' (Supplement ' . $i . ')';
                                                @endphp
                                                <tr>
                                                    <td class="align-middle">
                                                        <span class="fw-semibold">{{ $fileLabel }}</span>
                                                        <input type="hidden" name="file_pages[{{ $i }}][file_name]" class="file-name-input" value="{{ $fileName }}">
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            name="file_pages[{{ $i }}][pages]"
                                                            class="form-control page-count-input"
                                                            min="1"
                                                            value="{{ $pageCount }}"
                                                            placeholder="Enter pages for {{ $fileName }}"
                                                            required>
                                                    </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    @endif

                    <!-- ACTION BUTTONS -->
                    <div class="col-12 d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i> Update File
                        </button>

                        <a href="{{ route('admin.manage.lots.file.index', ['encodedId' => $file->encoded_register_no, 'page' => 1]) }}" class="btn btn-outline-danger ms-auto">
                            <i class="bx bx-x me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .input-group-text {
            background-color: #f8f9fa;
        }

        .card.border-info {
            border-left: 4px solid #0dcaf0;
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .text-success {
            color: #198754 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Division → Sub Division
            document.getElementById('division_id').addEventListener('change', function() {
                const divisionId = this.value;
                const typeSelect = document.getElementById('sub_division_id');
                typeSelect.innerHTML = '<option value="">Loading...</option>';
                fetch(`/get-sub-divisions/${divisionId}`)
                    .then(res => res.json())
                    .then(data => {
                        let sub = document.getElementById('sub_division_id');
                        sub.innerHTML = '<option value="">Select Sub Division</option>';
                        data.forEach(item => {
                            sub.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                        });
                    });
            });


            document.getElementById('property_category').addEventListener('change', function() {

                const category = this.value;
                const typeSelect = document.getElementById('property_type');
                typeSelect.innerHTML = '<option value="">Loading...</option>';
                if (!category) {
                    typeSelect.innerHTML = '<option value="">Select Property Type</option>';
                    return;
                }
                fetch(`/get-property-types/${category}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">Select Property Type</option>';

                        data.forEach(item => {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        });

                        typeSelect.innerHTML = options;
                    })
                    .catch(() => {
                        typeSelect.innerHTML = '<option value="">Error loading data</option>';
                    });
            });

            document.getElementById('property_type').addEventListener('change', function() {

                const typeId = this.value;
                const typeSelect = document.getElementById('property_sub_type');
                typeSelect.innerHTML = '<option value="">Loading...</option>';
                if (!typeId) {
                    typeSelect.innerHTML = '<option value="">Select Sub Property Type</option>';
                    return;
                }
                fetch(`/get-property-sub-types/${typeId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">Select Sub Property Type</option>';

                        data.forEach(item => {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        });

                        typeSelect.innerHTML = options;
                    })
                    .catch(() => {
                        typeSelect.innerHTML = '<option value="">Error loading data</option>';
                    });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const propertyType = document.getElementById('property_type');
            const quarterSelect = document.getElementById('quarter_type');

            function filterQuarterOptions() {

                const text = propertyType.options[propertyType.selectedIndex]?.text.toLowerCase();

                Array.from(quarterSelect.options).forEach(option => {

                    const optionText = option.text.toLowerCase();

                    if (text.includes('plot')) {
                        // Plot select MIG or LIG or HIG show
                        if (optionText.includes('mig') || optionText.includes('hig') || optionText.includes('lig')) {
                            option.hidden = false;
                        } else {
                            option.hidden = true;
                        }
                    } else {
                        // Plot option show
                        option.hidden = false;
                    }
                });

                // current selected option hidden
                if (quarterSelect.selectedOptions.length &&
                    quarterSelect.selectedOptions[0].hidden) {
                    quarterSelect.value = '';
                }
            }

            propertyType.addEventListener('change', filterQuarterOptions);

            // Page load
            filterQuarterOptions();

            // Dynamic Supplement Files & Pages handler (only when scanned / table exists)
            const supplementSelect = document.getElementById('no_of_supplement');
            const tbody = document.getElementById('filesPagesTbody');
            const displaySupplement = document.getElementById('display_no_of_supplement');
            const displayTotalPages = document.getElementById('display_total_pages');
            const totalPagesInput = document.getElementById('total_pages_input');
            const jsonPagesInput = document.getElementById('json_pages_input');

            if (tbody && supplementSelect) {
                // Store initial/edited pages by index so switching back and forth doesn't lose values
                const savedPages = {};
                const initialPagesData = @json($pagesData ?? []);
                if (Array.isArray(initialPagesData)) {
                    initialPagesData.forEach((item, idx) => {
                        savedPages[idx] = parseInt(item.pages, 10) || 0;
                    });
                }

                function syncTotalsAndJson() {
                    let totalPages = 0;
                    const jsonArray = [];
                    const rows = tbody.querySelectorAll('tr');

                    rows.forEach((row, index) => {
                        const fileName = `File-${index + 1}`;
                        const pageInput = row.querySelector('.page-count-input');
                        const pages = parseInt(pageInput.value, 10) || 0;
                        savedPages[index] = pages;
                        totalPages += pages;

                        jsonArray.push({
                            file_name: fileName,
                            pages: pages
                        });
                    });

                    displayTotalPages.textContent = totalPages;
                    totalPagesInput.value = totalPages;
                    jsonPagesInput.value = JSON.stringify(jsonArray);
                }

                function renderFileRows() {
                    const supplementCount = parseInt(supplementSelect.value, 10) || 0;
                    const totalRows = 1 + supplementCount; // 1 Main File + N Supplements

                    displaySupplement.textContent = supplementCount;

                    // Save current input values before re-rendering
                    tbody.querySelectorAll('tr').forEach((row, idx) => {
                        const input = row.querySelector('.page-count-input');
                        if (input) {
                            savedPages[idx] = parseInt(input.value, 10) || 0;
                        }
                    });

                    tbody.innerHTML = '';

                    for (let i = 0; i < totalRows; i++) {
                        const fileName = `File-${i + 1}`;
                        const fileLabel = i === 0 ? `${fileName} (Main File)` : `${fileName} (Supplement ${i})`;
                        const pageVal = savedPages[i] !== undefined ? savedPages[i] : '';

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="align-middle">
                                <span class="fw-semibold">${fileLabel}</span>
                                <input type="hidden" name="file_pages[${i}][file_name]" class="file-name-input" value="${fileName}">
                            </td>
                            <td>
                                <input type="number"
                                    name="file_pages[${i}][pages]"
                                    class="form-control page-count-input"
                                    min="1"
                                    value="${pageVal}"
                                    placeholder="Enter pages for ${fileName}"
                                    required>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    }

                    syncTotalsAndJson();
                }

                supplementSelect.addEventListener('change', renderFileRows);

                tbody.addEventListener('input', function(e) {
                    if (e.target.classList.contains('page-count-input')) {
                        syncTotalsAndJson();
                    }
                });

                // Initial sync on page load
                syncTotalsAndJson();
            }
        });
    </script>
@endsection
