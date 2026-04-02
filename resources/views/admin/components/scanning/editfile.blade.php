@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Edit File : {{ $fullName }}</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">
                <i class="bx bx-pencil me-2"></i>Edit Reciving Allottee File
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
                    #return getDebugIndex($file);
                @endphp
                @php
                    $quarterTypes = getQuarterType();
                    $getPropertyCategory = getPropertyCategory();
                    $subdivision = getSubDivisions($file->division_id);
                    $propertyType = getPropertyType($file->pcategory_id);
                    $propertySubtype = getPropertySubType($file->p_type_id);
                @endphp
                <form action="{{ route('admin.scanning.file.update', ['encryptedId' => $encryptedId]) }}" method="POST" class="row g-3 align-items-end"
                    id="schemeForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="encoded_register_no" value="{{ $file->encoded_register_no }}">
                    <input type="hidden" name="encryptedId" value="{{ $encryptedId }}">

                     <!-- Register No. -->
                     <div class="col-md-3">
                        <label for="register_no" class="form-label">
                            Register No. <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" id="register_no" name="register_no" value="{{ $file->register_id }}" disabled>
                    </div>

                    <!-- Division Name -->
                    <div class="col-md-3">
                        <label class="form-label">Division <small class="text-danger">*</small></label>
                        <select name="division_id" id="division_id"
                            class="form-select @error('division_id') is-invalid @enderror" disabled>
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
                    <div class="col-md-3">
                        <label class="form-label">Sub Division <small class="text-danger">*</small></label>
                        <select name="sub_division_id" id="sub_division_id" class="form-select" disabled>
                            @foreach ($subdivision as $division)
                                <option value="{{ $division->id }}"
                                    {{ $division->id == $file->sub_division_id ? 'selected' : '' }}>
                                    {{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Property Category -->
                    <div class="col-md-3">
                        <label class="form-label">Property Category <small class="text-danger">*</small></label>
                        <select name="pcategory_id" id="property_category" class="form-select" disabled>
                            <option value="">Select Category</option>
                            @foreach ($getPropertyCategory as $PropertyCategory)
                                <option value="{{ $PropertyCategory->id }}"
                                    {{ $PropertyCategory->id == $file->pcategory_id ? 'selected' : '' }}>
                                    {{ $PropertyCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Property Type <small class="text-danger">*</small></label>
                        <select name="p_type_id" id="property_type" class="form-select" disabled>
                            @foreach ($propertyType as $ptype)
                                <option value="{{ $ptype->id }}"
                                    {{ $ptype->id == $file->p_type_id ? 'selected' : '' }}>
                                    {{ $ptype->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3" id="quarter_type_div">
                        <label class="form-label">Quarter Type <small class="text-danger">*</small></label>
                        <select name="quarter_type" id="quarter_type" class="form-select" disabled>
                            @foreach ($quarterTypes as $qt)
                                <option value="{{ $qt->quarter_id }}"
                                    {{ $qt->quarter_id == $file->quarter_type ? 'selected' : '' }}>
                                    {{ $qt->quarter_code }} - {{ $qt->quarter_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="property_number" class="form-label">
                            Property Number
                        </label>
                        <input type="text" class="form-control" id="property_number" name="property_number"
                            value="{{ $file->property_number }}" placeholder="Enter Property Number" disabled>
                    </div>

                                        
                    {{-- Remarks --}}
                    <div class="col-md-3">
                        <label for="remarks" class="form-label">
                            Remarks
                        </label>
                        <select name="remarks" id="remarks" class="form-select" disabled>
                            <option value="">-- Select Page Condition --</option>
                            <option value="All Fresh Pages" {{ $file->remarks == 'All Fresh Pages' ? 'selected' : '' }}>All Fresh Pages</option>
                            <option value="All Old Pages" {{ $file->remarks == 'All Old Pages' ? 'selected' : '' }}>All Old Pages</option>
                            <option value="All Poor Quality Pages" {{ $file->remarks == 'All Poor Quality Pages' ? 'selected' : '' }}>All Poor Quality Pages</option>
                            <option value="Partial Fresh and Old Pages" {{ $file->remarks == 'Partial Fresh and Old Pages' ? 'selected' : '' }}>Partial Fresh and Old Pages</option>
                        </select>
                    </div>
                    <hr>
                    <div class="col-md-3">
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

                    <div class="col-md-3">
                        <label for="allottee_name" class="form-label">
                            First Name <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" id="allottee_name" name="allottee_name"
                            value="{{ $file->allottee_name }}" placeholder="Enter First Name" required>
                    </div>

                    <div class="col-md-3">
                        <label for="allottee_middle_name" class="form-label">
                            Middle Name
                        </label>
                        <input type="text" class="form-control" id="allottee_middle_name" name="allottee_middle_name"
                            value="{{ $file->allottee_middle_name }}" placeholder="Enter Middle Name">
                    </div>

                    <div class="col-md-3">
                        <label for="allottee_surname" class="form-label">
                            Surname
                        </label>
                        <input type="text" class="form-control" id="allottee_surname" name="allottee_surname"
                            value="{{ $file->allottee_surname }}" placeholder="Enter Surname">
                    </div>

                    <hr>
                    <br>
                    <span><strong>No. of Files : </strong>{{ $file->no_of_files }}</span>
                    <span><strong>Additional Supplement Files : </strong>{{ $file->no_of_supplement }}</span>
                    <span><strong>Total Pages : </strong>{{ $file->total_pages }}</span>

                    <!-- Create Box of files pages -->
                    {{-- [json_pages] => [{"file_name":"File-1","pages":242},{"file_name":"File-2","pages":71}] --}}
                    @if ($file->json_pages)
                        @php
                            $pagesData = json_decode($file->json_pages, true);
                        @endphp
                        <div class="col-12">
                            <label class="form-label fw-bold text-primary">Files & Pages Details</label>
                            <div class="card mb-3">
                                <div class="card-body p-0">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>File Name</th>
                                                <th>Number of Pages</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pagesData as $index => $fileData)
                                                <tr>
                                                    <td>{{ $fileData['file_name'] ?? 'File-' . ($index + 1) }}</td>
                                                    <td>{{ $fileData['pages'] ?? 0 }}</td>
                                                </tr>
                                            @endforeach
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

                        <a href="{{ route('admin.scanning.files.index', ['encodedId' => $file->encoded_register_no, 'page' => 1]) }}" class="btn btn-outline-danger ms-auto">
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
                        // Plot select hone par sirf MIG aur HIG show
                        if (optionText.includes('mig') || optionText.includes('hig')) {
                            option.hidden = false;
                        } else {
                            option.hidden = true;
                        }
                    } else {
                        // Plot nahi hai to sab option show
                        option.hidden = false;
                    }
                });

                // Agar current selected option hidden ho gaya to reset
                if (quarterSelect.selectedOptions.length &&
                    quarterSelect.selectedOptions[0].hidden) {
                    quarterSelect.value = '';
                }
            }

            propertyType.addEventListener('change', filterQuarterOptions);

            // Page load pe bhi check kare
            filterQuarterOptions();
        });
    </script>
@endsection
