@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">
                <a href="{{ route('admin.schemes.index') }}">Dashboard / Scheme Master</a> / Edit Scheme
            </span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">
                <i class="bx bx-edit me-2"></i>Edit Scheme
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
                    $divisions = getDivisions();
                    $quarterTypes = getQuarterType();
                    $getPropertyCategory = getPropertyCategory();
                    $subdivision = getSubDivisions($scheme->division_id);
                    $propertyType = getPropertyType($scheme->pcategory_id);
                    $propertySubtype = getPropertySubType($scheme->p_type_id);
                    // print_r($scheme); die();
                @endphp

                <form action="{{ route('admin.schemes.update', $scheme->scheme_id) }}" method="POST"
                    class="row g-3 align-items-end" id="schemeForm">
                    @csrf
                    @method('PUT')

                    <!-- Division Name -->
                    <div class="col-md-6">
                        <label class="form-label">Division <small class="text-danger">*</small></label>
                        <select name="division_id" id="division_id"
                            class="form-select @error('division_id') is-invalid @enderror" required>
                            <option value="">Select Division</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ $division->id == $scheme->division_id ? 'selected' : '' }}>{{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('division_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <!-- Sub Division Name -->
                    <div class="col-md-6">
                        <label class="form-label">Sub Division <small class="text-danger">*</small></label>
                        <select name="sub_division_id" id="sub_division_id" class="form-select" required>
                            @foreach ($subdivision as $division)
                                <option value="{{ $division->id }}"
                                    {{ $division->id == $scheme->sub_division_id ? 'selected' : '' }}>
                                    {{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Property Category -->
                    <div class="col-md-6">
                        <label class="form-label">Property Category <small class="text-danger">*</small></label>
                        <select name="pcategory_id" id="property_category" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($getPropertyCategory as $PropertyCategory)
                                <option value="{{ $PropertyCategory->id }}"
                                    {{ $PropertyCategory->id == $scheme->pcategory_id ? 'selected' : '' }}>
                                    {{ $PropertyCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Property Type <small class="text-danger">*</small></label>
                        <select name="p_type_id" id="property_type" class="form-select" required>
                            @foreach ($propertyType as $ptype)
                                <option value="{{ $ptype->id }}"
                                    {{ $ptype->id == $scheme->p_type_id ? 'selected' : '' }}>
                                    {{ $ptype->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label">Property Sub Type </label>
                        <select name="p_sub_type_id" id="property_sub_type" class="form-select">
                            @foreach ($propertySubtype as $subptype)
                                <option value="{{ $subptype->id }}"
                                    {{ $subptype->id == $scheme->p_sub_type_id ? 'selected' : '' }}>
                                    {{ $subptype->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-6" id="quarter_type_div">
                        <label class="form-label">Quarter Type <small class="text-danger">*</small></label>
                        <select name="quarter_type_id" id="quarter_type" class="form-select" required>
                            <option value="">Select Quarter Type</option>
                            @foreach ($quarterTypes as $qt)
                                <option value="{{ $qt->quarter_id }}"
                                    {{ $qt->quarter_id == $scheme->quarter_type_id ? 'selected' : '' }}>
                                    {{ $qt->quarter_code }} - {{ $qt->quarter_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Scheme Name -->
                    <div class="col-md-12">
                        <label for="scheme_name" class="form-label">
                            Scheme Name (English)<small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control @error('scheme_name') is-invalid @enderror"
                            id="scheme_name" name="scheme_name" value="{{ old('scheme_name', $scheme->scheme_name) }}"
                            placeholder="Enter Scheme Name" required>
                        @error('scheme_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Scheme Name -->
                    <div class="col-md-12">
                        <label for="scheme_name" class="form-label">
                            Scheme Name (Krutidev) </label>
                        <input type="text" class="krutidev form-control @error('scheme_name_hindi') is-invalid @enderror"
                            id="scheme_name_hindi" name="scheme_name_hindi"
                            value="{{ old('scheme_name_hindi', $scheme->scheme_name_hindi) }}"
                            placeholder="Enter Scheme Name" style="font-size: 24px;">
                        @error('scheme_name_hindi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Scheme Code -->
                    <div class="col-md-6">
                        <label for="scheme_code" class="form-label">
                            Scheme Code
                        </label>
                        <input type="text" class="form-control @error('scheme_code') is-invalid @enderror"
                            id="scheme_code" name="scheme_code" value="{{ old('scheme_code', $scheme->scheme_code) }}"
                            placeholder="Enter Scheme Code (e.g., SCHEME-001)">
                        @error('scheme_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Optional short code for reference</small>
                    </div>

                    <!-- Total Units -->
                    <div class="col-md-6">
                        <label for="total_units" class="form-label">
                            Total Units <small class="text-danger">*</small>
                        </label>
                        <input type="number" class="form-control @error('total_units') is-invalid @enderror"
                            id="total_units" name="total_units" value="{{ old('total_units', $scheme->total_units) }}"
                            placeholder="Enter Total Units" min="1" required>
                        @error('total_units')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Total Units</small>
                    </div>

                    <!-- Financial Details -->
                    <div class="col-12 mt-4">
                        <h6 class="border-bottom pb-2 mb-3" style="color: #aa7700 !important;">
                            <i class="bx bx-money me-1"></i> Properties Financial Details
                        </h6>
                    </div>

                    <!-- Scheme Value -->
                    <div class="col-md-4">
                        <label for="scheme_value" class="form-label">
                            Scheme Value (₹) <small class="text-danger">*</small>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control @error('scheme_value') is-invalid @enderror"
                                id="scheme_value" name="scheme_value"
                                value="{{ old('scheme_value', $scheme->scheme_value) }}" placeholder="Enter Scheme Value"
                                step="0.01" min="1000" required>
                        </div>
                        @error('scheme_value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Down Payment Percentage -->
                    <div class="col-md-4">
                        <label for="down_payment_percentage" class="form-label">
                            Down Payment (%) <small class="text-danger">*</small>
                        </label>
                        <div class="input-group">
                            <input type="number"
                                class="form-control @error('down_payment_percentage') is-invalid @enderror"
                                id="down_payment_percentage" name="down_payment_percentage"
                                value="{{ old('down_payment_percentage', $scheme->down_payment_percentage) }}"
                                placeholder="Enter Percentage" step="0.01" min="0" max="100" required>
                            <span class="input-group-text">%</span>
                        </div>
                        @error('down_payment_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Down Payment Percentage -->
                    <div class="col-md-4">
                        <label for="down_payment_amount" class="form-label">
                            Down Payment Amount (₹) <small class="text-danger">*</small>
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('down_payment_amount') is-invalid @enderror"
                                id="down_payment_amount" name="down_payment_amount"
                                value="{{ old('down_payment_amount', $scheme->down_payment_amount) }}"
                                placeholder="Enter Percentage">
                        </div>
                        @error('down_payment_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Application Deposit Percentage -->
                    <div class="col-md-4">
                        <label for="application_deposit_amount" class="form-label">
                            Application Deposit (₹) <small class="text-danger">*</small>
                        </label>
                        <div class="input-group">
                            <input type="text"
                                class="form-control @error('application_deposit_amount') is-invalid @enderror"
                                id="application_deposit_amount" name="application_deposit_amount"
                                value="{{ old('application_deposit_amount', $scheme->application_deposit_amount) }}"
                                placeholder="Enter Percentage" required>
                        </div>
                        @error('application_deposit_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Extra Amount -->
                    <div class="col-md-4">
                        <label for="extra_amount" class="form-label">
                            Extra Amount (₹)
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control @error('extra_amount') is-invalid @enderror"
                                id="extra_amount" name="extra_amount"
                                value="{{ old('extra_amount', $scheme->extra_amount) }}" placeholder="Extra Charges"
                                step="0.01" min="0">
                        </div>
                        @error('extra_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Registry Time Deposit -->
                    <div class="col-md-4">
                        <label for="registry_time_deposit" class="form-label">
                            Registry Time Deposit (₹) <small class="text-danger">*</small>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number"
                                class="form-control @error('registry_time_deposit') is-invalid @enderror"
                                id="registry_time_deposit" name="registry_time_deposit"
                                value="{{ old('registry_time_deposit', $scheme->registry_time_deposit) }}"
                                placeholder="Enter Amount" step="0.01" min="0" required>
                        </div>
                        @error('registry_time_deposit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- EMI Count -->
                    <div class="col-md-4">
                        <label for="emi_count" class="form-label">
                            Number of EMI <small class="text-danger">*</small>
                        </label>
                        <input type="number" class="form-control @error('emi_count') is-invalid @enderror"
                            id="emi_count" name="emi_count" value="{{ old('emi_count', $scheme->emi_count) }}"
                            placeholder="Enter EMI Count" min="1" max="240" required>
                        @error('emi_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- EMI Amount -->
                    <div class="col-md-4">
                        <label for="emi_amount" class="form-label">
                            EMI Amount <small class="text-danger">*</small>
                        </label>
                        <input type="number" class="form-control @error('emi_amount') is-invalid @enderror"
                            id="emi_amount" name="emi_amount" value="{{ old('emi_amount', $scheme->emi_amount) }}"
                            placeholder="Enter EMI Count">
                        @error('emi_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Interest Rates -->
                    <div class="col-12 mt-4">
                        <h6 class="border-bottom pb-2 mb-3" style="color: #8803ec !important;">
                            <i class="bx bx-percentage me-1"></i> Interest Rates
                        </h6>
                    </div>

                    <div class="col-md-6">
                        <label for="compound_interest_rate" class="form-label">
                            Compound Interest Rate (%) <small class="text-danger">*</small>
                        </label>
                        <div class="input-group">
                            <input type="number"
                                class="form-control @error('compound_interest_rate') is-invalid @enderror"
                                id="compound_interest_rate" name="compound_interest_rate"
                                value="{{ old('compound_interest_rate', $scheme->compound_interest_rate) }}"
                                placeholder="Enter Rate" step="0.01" min="0" max="100" required>
                            <span class="input-group-text">% p.a.</span>
                        </div>
                        @error('compound_interest_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="late_compound_interest_rate" class="form-label">
                            Late Payment Interest Rate (%) <small class="text-danger">*</small>
                        </label>
                        <div class="input-group">
                            <input type="number"
                                class="form-control @error('late_compound_interest_rate') is-invalid @enderror"
                                id="late_compound_interest_rate" name="late_compound_interest_rate"
                                value="{{ old('late_compound_interest_rate', $scheme->late_compound_interest_rate) }}"
                                placeholder="Enter Rate" step="0.01" min="0" max="100" required>
                            <span class="input-group-text">% p.a.</span>
                        </div>
                        @error('late_compound_interest_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6" id="administrativeChargesSection">
                        <label for="administrative_charges" class="form-label">
                            Administrative Charges (₹) <small class="text-danger">*</small>
                        </label>

                        <input type="number" class="form-control @error('administrative_charges') is-invalid @enderror"
                            id="administrative_charges" name="administrative_charges"
                            value="{{ old('administrative_charges', $scheme->administrative_charges) }}" min="0"
                            step="0.01">

                        @error('administrative_charges')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">According to HIG/MIG/LIG/EWS</small>
                    </div>

                    <!-- Dates -->
                    <div class="col-12 mt-4">
                        <h6 class="border-bottom pb-2 mb-3 text-info">
                            <i class="bx bx-calendar me-1"></i> Lease Details & Dates
                        </h6>
                    </div>

                    <div class="col-md-6">
                        <label for="lease_period" class="form-label">
                            Lease Period
                        </label>

                        <select class="form-select @error('lease_period') is-invalid @enderror" id="lease_period"
                            name="lease_period">

                            <option value="">-- Select Lease Period --</option>
                            <option value="90"
                                {{ old('lease_period', $scheme->lease_period) == '90' ? 'selected' : '' }}>
                                90 Years
                            </option>
                            <option value="99"
                                {{ old('lease_period', $scheme->lease_period) == '99' ? 'selected' : '' }}>
                                99 Years
                            </option>
                        </select>

                        @error('lease_period')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="scheme_start_date" class="form-label">
                            Scheme Start Date <small class="text-danger">*</small>
                        </label>
                        <input type="date" class="form-control @error('scheme_start_date') is-invalid @enderror"
                            id="scheme_start_date" name="scheme_start_date"
                            value="{{ old('scheme_start_date', $scheme->scheme_start_date->format('Y-m-d')) }}" required>
                        @error('scheme_start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="scheme_end_date" class="form-label">
                            Scheme End Date
                        </label>
                        <input type="date" class="form-control @error('scheme_end_date') is-invalid @enderror"
                            id="scheme_end_date" name="scheme_end_date"
                            value="{{ old('scheme_end_date', $scheme->scheme_end_date ? $scheme->scheme_end_date->format('Y-m-d') : '') }}">
                        @error('scheme_end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="col-12 d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i> Update Scheme
                        </button>

                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="bx bx-reset me-1"></i> Reset
                        </button>

                        <a href="{{ route('admin.schemes.index') }}" class="btn btn-outline-danger ms-auto">
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

        .bg-light {
            background-color: #f8f9fa !important;
            cursor: not-allowed;
        }

        .form-control[readonly] {
            background-color: #f8f9fa;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Date validation
            const startDateInput = document.getElementById('scheme_start_date');
            const endDateInput = document.getElementById('scheme_end_date');

            if (startDateInput && endDateInput) {
                startDateInput.addEventListener('change', function() {
                    if (endDateInput.value && new Date(endDateInput.value) < new Date(this.value)) {
                        alert('End date cannot be before start date');
                        endDateInput.value = '';
                    }
                    endDateInput.min = this.value;
                });
            }

            // Auto-calculate down payment amount
            const schemeValueInput = document.getElementById('scheme_value');
            const downPaymentPercentInput = document.getElementById('down_payment_percentage');

            function calculateDownPayment() {
                const schemeValue = parseFloat(schemeValueInput.value) || 0;
                const downPaymentPercent = parseFloat(downPaymentPercentInput.value) || 0;
                const downPaymentAmount = schemeValue * (downPaymentPercent / 100);

                // You can display this in a readonly field if needed
                // document.getElementById('down_payment_amount').value = downPaymentAmount.toFixed(2);
            }

            if (schemeValueInput && downPaymentPercentInput) {
                schemeValueInput.addEventListener('input', calculateDownPayment);
                downPaymentPercentInput.addEventListener('input', calculateDownPayment);
            }

            // Form submission confirmation
            const form = document.getElementById('schemeForm');
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to update this scheme?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
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
