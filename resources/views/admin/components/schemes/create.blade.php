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


                    <div class="col-md-6" id="quarter_type_div">
                        <label class="form-label">Quarter Type <small class="text-danger">*</small></label>
                        <select name="quarter_type_id" id="quarter_type" class="form-select" required>
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
                            placeholder="Enter Scheme Name">
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

                    <div class="row g-3">

                        <!-- ===================================================== -->
                        <!-- HEADER -->
                        <!-- ===================================================== -->

                        <div class="col-12 mt-4">
                            <div class="d-flex align-items-center p-3 rounded shadow-sm"
                                style="background: linear-gradient(90deg, #aa7700, #ffb703); color: #fff;">
                                <i class="bx bx-money me-2"></i>
                                <h5 class="mb-0 fw-semibold text-white">Properties Financial Details</h5>
                            </div>
                        </div>

                        <!-- ===================================================== -->
                        <!-- STEP 1 : INITIAL DEPOSIT -->
                        <!-- ===================================================== -->
                        <div class="col-12 mt-4">
                            <div class="d-flex align-items-center p-3 rounded shadow-sm"
                                style="background: #f6def7; border-left: 5px solid #e100ff;">
                                <h6 class="mb-0 fw-semibold" style="color:#e100ff;">
                                    <i class="bx bx-wallet me-2"></i>
                                    Step 1 : Initial Deposit
                                </h6>
                            </div>
                        </div>

                        <!-- Application Form Fee -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Application Form Fee (₹)</label>
                            <div class="row g-2">
                                @foreach ($quarterTypes as $qt)
                                    <div class="col-md-3">

                                        <input type="hidden" name="quarter_fees[{{ $qt->quarter_id }}][quarter_type_id]"
                                            value="{{ $qt->quarter_id }}">

                                        <input type="number" class="form-control"
                                            name="quarter_fees[{{ $qt->quarter_id }}][application_fee]"
                                            placeholder="{{ $qt->quarter_code }} - {{ strtoupper($qt->quarter_name) }}"
                                            required>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- EMD -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">EMD (Earnest Money Deposit) (₹)</label>
                            <div class="row g-2">
                                @foreach ($quarterTypes as $qt)
                                    <div class="col-md-3">
                                        <input type="hidden" name="quarter_fees[{{ $qt->quarter_id }}][quarter_type_id]"
                                            value="{{ $qt->quarter_id }}">

                                        <input type="number" class="form-control"
                                            name="quarter_fees[{{ $qt->quarter_id }}][emd_amount]"
                                            placeholder="{{ $qt->quarter_code }} - {{ strtoupper($qt->quarter_name) }}"
                                            required>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="d-flex align-items-center p-3 rounded shadow-sm"
                                style="background: #e8f0f7; border-left: 5px solid #0d4cc2;">
                                <h6 class="mb-0 fw-semibold text-info">
                                    <i class="bx bx-building-house me-2"></i>
                                    Step 2 : At the Time of Allotment
                                </h6>
                            </div>
                        </div>


                        <!-- Property Total Cost -->
                        <div class="col-md-4">
                            <label class="form-label">Property Total Cost (₹)</label>
                            <input type="number" id="total_cost" name="property_total_cost"
                                placeholder="Enter Property Total Cost" class="form-control" required>
                        </div>

                        <!-- Down Payment % -->
                        <div class="col-md-4">
                            <label class="form-label">Down Payment (%)</label>
                            <input type="number" id="down_percent" name="down_payment_percentage"
                                placeholder="Enter Down Payment Percenetage" class="form-control" required>
                        </div>

                        <!-- Down Payment Amount -->
                        <div class="col-md-4">
                            <label class="form-label">Down Payment Amount (₹)</label>
                            <input type="number" id="down_amount" name="down_payment_amount"
                                placeholder="Enter Down Payment Amount" class="form-control" required>
                        </div>

                        <!-- ===================================================== -->
                        <!-- STEP 3 : AT AGREEMENT -->
                        <!-- ===================================================== -->

                        <div class="col-12 mt-4">
                            <div class="p-3 rounded shadow-sm"
                                style="background: #e8f7ee; border-left: 5px solid #28a745;">
                                <h6 class="mb-0 fw-semibold text-success">
                                    <i class="bx bx-file me-2"></i>
                                    Step 3 : At the Time of Agreement
                                </h6>
                            </div>
                        </div>


                        <!-- Balance Amount -->
                        <div class="col-md-4">
                            <label class="form-label">Balance Amount (₹)</label>
                            <input type="number" id="balance_amount" name="balance_amount" placeholder="Balance Amount"
                                class="form-control" required>
                        </div>

                        <!-- EMI Count -->
                        <div class="col-md-4">
                            <label class="form-label">No. of EMIs</label>
                            <input type="number" id="emi_count" name="emi_count" placeholder="Enter EMI Counts"
                                class="form-control" required>
                        </div>


                        <!-- Admin Charges -->
                        <div class="col-md-4">
                            <label>Admin Charges (₹)</label>
                            <input type="number" name="admin_charges" placeholder="Admin Charges" class="form-control">
                        </div>


                        <!-- EMI Calculation Section -->
                        <div class="col-12 mt-4">
                            <div class="p-3 rounded shadow-sm" style="background:#f8f9fa;">
                                <h6 class="mb-3 fw-semibold">
                                    EMI Calculation Details
                                </h6>

                                <div class="row g-4">

                                    <!-- WITHOUT PENALTY -->
                                    <div class="col-md-6">
                                        <div class="p-3" style="background:#eef4ff; border-left:4px solid #0d6efd;">
                                            <h6 class="fw-bold text-primary mb-3">
                                                Without Penalty
                                            </h6>

                                            <div class="mb-3">
                                                <label class="form-label">Interest Rate (%)</label>
                                                <input type="number" id="normal_interest" name="normal_interest_rate"
                                                    value="13.5" class="form-control" required>
                                            </div>

                                            <div>
                                                <label class="form-label">
                                                    Monthly EMI (₹)
                                                    <small class="text-danger">/ Month</small>
                                                </label>
                                                <input type="number" id="emi_normal" name="emi_without_penalty"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- WITH PENALTY -->
                                    <div class="col-md-6">
                                        <div class="p-3" style="background:#fff1f1; border-left:4px solid #dc3545;">
                                            <h6 class="fw-bold text-danger mb-3">
                                                With Penalty
                                            </h6>

                                            <div class="mb-3">
                                                <label class="form-label">Penalty Rate (%) </label>
                                                <input type="number" id="penalty_rate" name="penalty_interest_rate"
                                                    value="2.5" class="form-control" required>
                                            </div>

                                            <div>
                                                <label class="form-label">
                                                    Monthly EMI (₹)
                                                    <small class="text-danger">/ Month </small> &nbsp; (Interest Rate +
                                                    Penalty Rate) of balance Amount
                                                </label>
                                                <input type="number" id="emi_penalty" name="emi_with_penalty"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-4">
                            <div class="d-flex align-items-center p-3 rounded shadow-sm"
                                style="background: linear-gradient(90deg, #0dcaf0, #3a86ff); color: #fff;">
                                <i class="bx bx-calendar me-2"></i>
                                <h5 class="mb-0 fw-semibold text-white">Lease Details</h5>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label>Lease Period</label>
                            <select name="lease_period" class="form-select" required>
                                <option value="90" selected>90 Years</option>
                                <option value="99">99 Years</option>
                            </select>
                        </div>

                        @php
                            $currentYear = date('Y');
                        @endphp

                        <div class="col-md-4">
                            <label for="initiation_year" class="form-label">
                                Year of Initiation
                            </label>

                            <select name="initiation_year" id="initiation_year"
                                class="form-select @error('initiation_year') is-invalid @enderror" required>

                                <option value="">-- Select Initiation Year --</option>

                                @for ($year = 1950; $year <= $currentYear; $year++)
                                    <option value="{{ $year }}"
                                        {{ old('initiation_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>

                            @error('initiation_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label>Scheme Start Date</label>
                            <input type="date" name="scheme_start_date" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label>Scheme End Date</label>
                            <input type="date" name="scheme_end_date" class="form-control">
                        </div>

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
        const total_cost = document.getElementById('total_cost');
        const down_percent = document.getElementById('down_percent');
        const down_amount = document.getElementById('down_amount');
        const balance_amount = document.getElementById('balance_amount');
        const emi_count = document.getElementById('emi_count');
        const normal_interest = document.getElementById('normal_interest');
        const penalty_rate = document.getElementById('penalty_rate');
        const emi_normal = document.getElementById('emi_normal');
        const emi_penalty = document.getElementById('emi_penalty');

        function calculateAll(changedField = null) {

            let total = parseFloat(total_cost.value) || 0;
            let percent = parseFloat(down_percent.value) || 0;
            let amount = parseFloat(down_amount.value) || 0;

            // =============================
            // Down Payment Logic
            // =============================

            if (changedField === "percent") {
                down_amount.value = Math.ceil((total * percent) / 100);
            }

            if (changedField === "amount") {
                down_percent.value = total > 0 ?
                    Math.ceil((amount / total) * 100) :
                    0;
            }

            let finalDown = parseFloat(down_amount.value) || 0;

            // Balance
            balance_amount.value = Math.ceil(total - finalDown);

            // =============================
            // EMI Logic
            // =============================

            let P = parseFloat(balance_amount.value) || 0;
            let N = parseFloat(emi_count.value) || 1;
            let R = parseFloat(normal_interest.value) || 0;
            let penalty = parseFloat(penalty_rate.value) || 0;

            // Normal EMI
            let monthlyRate = R / 12 / 100;

            if (monthlyRate > 0 && N > 0) {
                let emi = (P * monthlyRate * Math.pow(1 + monthlyRate, N)) /
                    (Math.pow(1 + monthlyRate, N) - 1);
                emi_normal.value = Math.ceil(emi);
            } else {
                emi_normal.value = N > 0 ? Math.ceil(P / N) : 0;
            }

            // Penalty EMI
            let penaltyRate = (R + penalty) / 12 / 100;

            if (penaltyRate > 0 && N > 0) {
                let emiPen = (P * penaltyRate * Math.pow(1 + penaltyRate, N)) /
                    (Math.pow(1 + penaltyRate, N) - 1);
                emi_penalty.value = Math.ceil(emiPen);
            } else {
                emi_penalty.value = N > 0 ? Math.ceil(P / N) : 0;
            }
        }

        // =============================
        // Auto Trigger on Any Change
        // =============================

        total_cost.addEventListener('input', () => calculateAll());
        down_percent.addEventListener('input', () => calculateAll('percent'));
        down_amount.addEventListener('input', () => calculateAll('amount'));
        emi_count.addEventListener('input', () => calculateAll());
        normal_interest.addEventListener('input', () => calculateAll());
        penalty_rate.addEventListener('input', () => calculateAll());
    </script>


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
