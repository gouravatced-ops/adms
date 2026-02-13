@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Scheme Master / Add New Scheme</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">
                <i class="bx bx-plus me-2"></i>Add New Scheme
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
                @endphp
                <form action="{{ route('admin.schemes.store') }}" method="POST" class="row g-3 align-items-end"
                    id="schemeForm">
                    @csrf

                    <!-- Division Name -->
                    <div class="col-md-6">
                        <label class="form-label">Division <small class="text-danger">*</small></label>
                        <select name="division_id" id="division_id"
                            class="form-select @error('division_id') is-invalid @enderror" required>
                            <option value="">Select Division</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
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
                            <option value="">Select Sub Division</option>
                        </select>
                    </div>

                    <!-- Property Category -->
                    <div class="col-md-6">
                        <label class="form-label">Property Category <small class="text-danger">*</small></label>
                        <select name="pcategory_id" id="property_category" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($getPropertyCategory as $PropertyCategory)
                                <option value="{{ $PropertyCategory->id }}">{{ $PropertyCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Property Type <small class="text-danger">*</small></label>
                        <select name="p_type_id" id="property_type" class="form-select" required>
                            <option value="">Select Property Type</option>
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label">Property Sub Type </label>
                        <select name="p_sub_type_id" id="property_sub_type" class="form-select">
                            <option value="">Select Sub Type</option>
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label">Quarter Type <small class="text-danger">*</small></label>
                        <select name="quarter_type_id" class="form-select" required>
                            <option value="">Select Quarter Type</option>
                            @foreach ($quarterTypes as $qt)
                                <option value="{{ $qt->quarter_id }}">
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
                            id="scheme_name" name="scheme_name" value="{{ old('scheme_name') }}"
                            placeholder="Enter Scheme Name" required>
                        @error('scheme_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Scheme Name -->
                    <div class="col-md-12">
                        <label for="scheme_name" class="form-label">
                            Scheme Name (Hindi) </label>
                        <input type="text" class="krutidev form-control @error('scheme_name_hindi') is-invalid @enderror"
                            id="scheme_name_hindi" name="scheme_name_hindi" value="{{ old('scheme_name_hindi') }}"
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
                            id="scheme_code" name="scheme_code" value="{{ old('scheme_code') }}"
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
                            id="total_units" name="total_units" value="{{ old('total_units', 1) }}"
                            placeholder="Enter Total Units" min="1" required>
                        @error('total_units')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Total Units</small>
                    </div>

                    <!-- Area in Square Feet -->
                    @php
                        $subNames = ['first', 'second', 'third', 'fourth', 'fifth'];
                    @endphp

                    @foreach ($subNames as $key)
                        <div class="col-md-3">
                            <label class="form-label">
                                Scheme Sub Name ({{ ucfirst($key) }})
                                @if ($key === 'first')
                                    <small class="text-danger">*</small>
                                @endif
                            </label>

                            <input type="text" class="form-control @error(" subname.$key") is-invalid @enderror"
                                name="subname[{{ $key }}]" value="{{ old(" subname.$key") }}"
                                placeholder="Enter {{ $key }} name">

                            @error("subname.$key")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach

                    <!-- Dimensions -->
                    <div class="col-12 mt-4">
                        <h6 class="border-bottom pb-2 mb-3" style="color: #269809 !important;">
                            <i class="bx bx-ruler me-1"></i> Dimensions
                        </h6>
                    </div>
                    <div class="row">
                        <!-- Area in Square Feet -->
                        <div class="col-md-3">
                            <label for="area_sqft" class="form-label">
                                Area (Square Feet) <small class="text-danger">*</small>
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('area_sqft') is-invalid @enderror"
                                    id="area_sqft" name="area_sqft" value="{{ old('area_sqft') }}"
                                    placeholder="Enter Area" step="0.01" min="1" required>
                                <span class="input-group-text">sq. ft.</span>
                            </div>
                            @error('area_sqft')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="dimensions_east" class="form-label">
                                East Side <small class="text-danger">*</small>
                            </label>
                            <input type="text" class="form-control @error('dimensions.east') is-invalid @enderror"
                                id="dimensions_east" name="dimensions[east]" value="{{ old('dimensions.east') }}"
                                placeholder="e.g., 30 ft" required>
                            @error('dimensions.east')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="dimensions_west" class="form-label">
                                West Side <small class="text-danger">*</small>
                            </label>
                            <input type="text" class="form-control @error('dimensions.west') is-invalid @enderror"
                                id="dimensions_west" name="dimensions[west]" value="{{ old('dimensions.west') }}"
                                placeholder="e.g., 30 ft" required>
                            @error('dimensions.west')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="dimensions_north" class="form-label">
                                North Side <small class="text-danger">*</small>
                            </label>
                            <input type="text" class="form-control @error('dimensions.north') is-invalid @enderror"
                                id="dimensions_north" name="dimensions[north]" value="{{ old('dimensions.north') }}"
                                placeholder="e.g., 40 ft" required>
                            @error('dimensions.north')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="dimensions_south" class="form-label">
                                South Side <small class="text-danger">*</small>
                            </label>
                            <input type="text" class="form-control @error('dimensions.south') is-invalid @enderror"
                                id="dimensions_south" name="dimensions[south]" value="{{ old('dimensions.south') }}"
                                placeholder="e.g., 40 ft" required>
                            @error('dimensions.south')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="arms_east_to_west_north_side" class="form-label">
                                East-West (North Side) <small class="text-danger">*</small>
                            </label>
                            <input type="text"
                                class="form-control @error('arms.east_to_west_north_side') is-invalid @enderror"
                                id="arms_east_to_west_north_side" name="arms[east_to_west_north_side]"
                                value="{{ old('arms.east_to_west_north_side', '4 ft') }}" placeholder="e.g., 4 ft"
                                required>
                            @error('arms.east_to_west_north_side')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="arms_east_to_west_south_side" class="form-label">
                                East-West (South Side) <small class="text-danger">*</small>
                            </label>
                            <input type="text"
                                class="form-control @error('arms.east_to_west_south_side') is-invalid @enderror"
                                id="arms_east_to_west_south_side" name="arms[east_to_west_south_side]"
                                value="{{ old('arms.east_to_west_south_side', '4 ft') }}" placeholder="e.g., 4 ft"
                                required>
                            @error('arms.east_to_west_south_side')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="arms_north_to_south_east_side" class="form-label">
                                North-South (East Side) <small class="text-danger">*</small>
                            </label>
                            <input type="text"
                                class="form-control @error('arms.north_to_south_east_side') is-invalid @enderror"
                                id="arms_north_to_south_east_side" name="arms[north_to_south_east_side]"
                                value="{{ old('arms.north_to_south_east_side', '4 ft') }}" placeholder="e.g., 4 ft"
                                required>
                            @error('arms.north_to_south_east_side')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="arms_north_to_south_west_side" class="form-label">
                                North-South (West Side) <small class="text-danger">*</small>
                            </label>
                            <input type="text"
                                class="form-control @error('arms.north_to_south_west_side') is-invalid @enderror"
                                id="arms_north_to_south_west_side" name="arms[north_to_south_west_side]"
                                value="{{ old('arms.north_to_south_west_side', '4 ft') }}" placeholder="e.g., 4 ft"
                                required>
                            @error('arms.north_to_south_west_side')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                                id="scheme_value" name="scheme_value" value="{{ old('scheme_value') }}"
                                placeholder="Enter Scheme Value" step="0.01" min="1000" required>
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
                                value="{{ old('down_payment_percentage', 25.0) }}" placeholder="Enter Percentage"
                                step="0.01" min="0" max="100" required>
                            <span class="input-group-text">%</span>
                        </div>
                        @error('down_payment_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Application Deposit Percentage -->
                    <div class="col-md-4">
                        <label for="application_deposit_percentage" class="form-label">
                            Application Deposit  <small class="text-danger">*</small>
                        </label>
                        <div class="input-group">
                            <input type="number"
                                class="form-control @error('application_deposit_percentage') is-invalid @enderror"
                                id="application_deposit_percentage" name="application_deposit_percentage"
                                value="{{ old('application_deposit_percentage') }}" placeholder="Enter Deposit Amount"
                                 required>
                        </div>
                        @error('application_deposit_percentage')
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
                                id="extra_amount" name="extra_amount" value="{{ old('extra_amount', 0.0) }}"
                                placeholder="Extra Charges" step="0.01" min="0">
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
                                value="{{ old('registry_time_deposit') }}" placeholder="Enter Amount" step="0.01"
                                min="0" required>
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
                            id="emi_count" name="emi_count" value="{{ old('emi_count', 60) }}"
                            placeholder="Enter EMI Count" min="1" max="240" required>
                        @error('emi_count')
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
                                value="{{ old('compound_interest_rate', 13.5) }}" placeholder="Enter Rate"
                                step="0.01" min="0" max="100" required>
                            <span class="input-group-text">% p.a.</span>
                        </div>
                        @error('compound_interest_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Annual compound interest rate</small>
                    </div>

                    <div class="col-md-6">
                        <label for="late_compound_interest_rate" class="form-label">
                            Late Payment Interest Rate (%) <small class="text-danger">*</small>
                        </label>
                        <div class="input-group">
                            <input type="number"
                                class="form-control @error('late_compound_interest_rate') is-invalid @enderror"
                                id="late_compound_interest_rate" name="late_compound_interest_rate"
                                value="{{ old('late_compound_interest_rate', 2.5) }}" placeholder="Enter Rate"
                                step="0.01" min="0" max="100" required>
                            <span class="input-group-text">% p.a.</span>
                        </div>
                        @error('late_compound_interest_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Additional interest for late payments</small>
                    </div>

                    <div class="col-md-6" id="administrativeChargesSection">
                        <label for="administrative_charges" class="form-label">
                            Administrative Charges (₹) <small class="text-danger">*</small>
                        </label>

                        <input type="number" class="form-control @error('administrative_charges') is-invalid @enderror"
                            id="administrative_charges" name="administrative_charges"
                            value="{{ old('administrative_charges', 5) }}" min="0" step="0.01">

                        @error('administrative_charges')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">According to HIG/MIG/LIG/EWS</small>
                    </div>

                    <!-- Dates -->
                    <div class="col-12 mt-4">
                        <h6 class="border-bottom pb-2 mb-3 text-info">
                            <i class="bx bx-calendar me-1"></i> Dates
                        </h6>
                    </div>

                    <div class="col-md-6">
                        <label for="scheme_start_date" class="form-label">
                            Scheme Start Date <small class="text-danger">*</small>
                        </label>
                        <input type="date" class="form-control @error('scheme_start_date') is-invalid @enderror"
                            id="scheme_start_date" name="scheme_start_date" value="{{ old('scheme_start_date') }}"
                            required>
                        @error('scheme_start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="scheme_end_date" class="form-label">
                            Scheme End Date
                        </label>
                        <input type="date" class="form-control @error('scheme_end_date') is-invalid @enderror"
                            id="scheme_end_date" name="scheme_end_date" value="{{ old('scheme_end_date') }}">
                        @error('scheme_end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Calculation Preview -->
                    {{-- <div class="col-12 mt-4">
                    <div class="card border-info">
                        <div class="card-header bg-info bg-opacity-10 text-info">
                            <i class="bx bx-calculator me-1"></i> Calculation Preview
                        </div>
                        <div class="card-body">
                            <div class="row" id="calculationPreview">
                                <div class="col-md-4 text-center">
                                    <h6 class="text-muted mb-1">Down Payment</h6>
                                    <h5 id="downPaymentPreview" class="text-primary">₹0.00</h5>
                                    <small class="text-muted" id="downPaymentPercent">0%</small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <h6 class="text-muted mb-1">Monthly EMI</h6>
                                    <h5 id="emiAmountPreview" class="text-success">₹0.00</h5>
                                    <small class="text-muted" id="emiCountPreview">0 months</small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <h6 class="text-muted mb-1">Total Payable</h6>
                                    <h5 id="totalPayablePreview" class="text-danger">₹0.00</h5>
                                    <small class="text-muted">Including all charges</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                    <!-- ACTION BUTTONS -->
                    <div class="col-12 d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i> Create Scheme
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
            // Elements
            const schemeValueInput = document.getElementById('scheme_value');
            const downPaymentPercentInput = document.getElementById('down_payment_percentage');
            const emiCountInput = document.getElementById('emi_count');
            const extraAmountInput = document.getElementById('extra_amount');

            // Preview elements
            const downPaymentPreview = document.getElementById('downPaymentPreview');
            const downPaymentPercent = document.getElementById('downPaymentPercent');
            const emiAmountPreview = document.getElementById('emiAmountPreview');
            const emiCountPreview = document.getElementById('emiCountPreview');
            const totalPayablePreview = document.getElementById('totalPayablePreview');

            // Calculate and update preview
            function updateCalculationPreview() {
                const schemeValue = parseFloat(schemeValueInput.value) || 0;
                const downPaymentPercent = parseFloat(downPaymentPercentInput.value) || 0;
                const emiCount = parseInt(emiCountInput.value) || 0;
                const extraAmount = parseFloat(extraAmountInput.value) || 0;

                if (schemeValue > 0 && downPaymentPercent > 0 && emiCount > 0) {
                    // Calculations
                    const downPaymentAmount = schemeValue * (downPaymentPercent / 100);
                    const remainingAmount = schemeValue - downPaymentAmount;
                    const emiAmount = remainingAmount / emiCount;
                    const totalPayable = downPaymentAmount + (emiAmount * emiCount) + extraAmount;

                    // Update preview
                    document.getElementById('downPaymentPreview').textContent = '₹' + downPaymentAmount
                        .toLocaleString('en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                    document.getElementById('downPaymentPercent').textContent = downPaymentPercent + '%';

                    document.getElementById('emiAmountPreview').textContent = '₹' + emiAmount.toLocaleString(
                        'en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                    document.getElementById('emiCountPreview').textContent = emiCount + ' months';

                    document.getElementById('totalPayablePreview').textContent = '₹' + totalPayable.toLocaleString(
                        'en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                } else {
                    // Reset preview
                    downPaymentPreview.textContent = '₹0.00';
                    downPaymentPercent.textContent = '0%';
                    emiAmountPreview.textContent = '₹0.00';
                    emiCountPreview.textContent = '0 months';
                    totalPayablePreview.textContent = '₹0.00';
                }
            }

            // Add event listeners for calculation
            [schemeValueInput, downPaymentPercentInput, emiCountInput, extraAmountInput].forEach(input => {
                input.addEventListener('input', updateCalculationPreview);
                input.addEventListener('change', updateCalculationPreview);
            });

            // Initial calculation
            updateCalculationPreview();

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

            // Form submission validation
            const form = document.getElementById('schemeForm');
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to create this scheme?')) {
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
@endsection
