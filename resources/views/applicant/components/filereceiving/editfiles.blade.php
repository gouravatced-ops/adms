@extends('applicant.dashboard_layouts.main')

@section('title', 'Edit Allottee')

@section('content')
    <style>
        .dynamic-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 20px;
            position: relative;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #dee2e6;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #495057;
        }

        .add-section-btn {
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            margin: 10px 0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .add-section-btn:hover {
            background: #218838;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }

        /* Base select styling */
        select {
            width: 100%;
            padding: 10px 12px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background-color: #fff;
            color: #111827;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='%236b7280' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
        }

        select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        select:disabled {
            background-color: #f3f4f6;
            cursor: not-allowed;
        }

        select.border-red-500 {
            border-color: #ef4444;
        }

        .field select {
            margin-top: 4px;
        }

        /* Button styling */
        .save-btn {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            margin: 10px 5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }

        .save-btn:hover {
            background: #0056b3;
        }

        .save-btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        .section-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 9px;
            padding-top: 0px;
            border-top: 1px solid #dee2e6;
        }

        .form-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
        }

        .hidden-field {
            display: none;
        }

        /* Highlight for Property Type Plot */
        .plot-selected .quarter-type-field {
            display: none !important;
        }

        /* Smooth transition for field hiding */
        .quarter-type-field {
            transition: all 0.3s ease;
        }

        /* Make quarter type field visually distinct when shown */
        .quarter-type-field:not(.hidden-field) {
            opacity: 1;
            max-height: 100px;
            overflow: hidden;
        }

        .back-btn {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            margin: 10px 5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: #545b62;
        }
    </style>

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

    <!-- Form Card -->
    <div class="card">
        <!-- Form Header -->
        <div class="modern-card-header">
            <div class="header-flex">
                <div>
                    <h1 class="header-title">Edit Allottee Details</h1>
                    <p class="header-subtitle">File Receiving Register (REG ID.: {{ $register->register_no }})</p>
                </div>
                <div class="header-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <form id="editAllotteeForm" action="{{ route('filereceving.update-details') }}" method="POST" class="form-body">
            @csrf
            <input type="hidden" name="register_id" value="{{ $register->register_no }}">
            <input type="hidden" name="allottee_id" value="{{ $allottes->id }}">

            <!-- Single Allottee Section -->
            <div class="dynamic-section">
                <div class="section-header">
                    <div class="section-title">
                        Edit Allottee Details
                    </div>
                </div>

                <div class="form-grid">
                    <!-- Division -->
                    <div class="field">
                        <label class="label required">Division</label>
                        <select name="division_id" class="division-select" required>
                            <option value="">Select Division</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ $allottes->division_id == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sub Division -->
                    <div class="field">
                        <label class="label required">Sub Division</label>
                        <select name="sub_division_id" class="sub-division-select" required>
                            <option value="">Select Sub Division</option>
                        </select>
                    </div>

                    <!-- Area -->
                    <div class="field">
                        <label class="label">Area </label>
                        <input type="text" name="area" value="{{ $allottes->area }}" placeholder="Enter area">
                    </div>

                    <!-- Property Category -->
                    <div class="field">
                        <label class="label required">Property Category</label>
                        <select name="pcategory_id" class="property-category-select" required>
                            <option value="">Select Category</option>
                            @foreach ($getPropertyCategory as $PropertyCategory)
                                <option value="{{ $PropertyCategory->id }}"
                                    {{ $allottes->pcategory_id == $PropertyCategory->id ? 'selected' : '' }}>
                                    {{ $PropertyCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Property Type -->
                    <div class="field">
                        <label class="label required">Property Type</label>
                        <select name="p_type_id" class="property-type-select" required>
                            <option value="">Select Property Type</option>
                        </select>
                    </div>


                    <!-- Quarter Type (Conditional - Hidden for Plot) -->
                    <div class="field quarter-type-field">
                        <label class="label required">Quarter type</label>
                        <select name="quarter_type" class="quarter-type-select" required>
                            <option value="">Select type</option>
                            @foreach ($getQuarterType as $quarterType)
                                <option value="{{ $quarterType->quarter_id }}"
                                    {{ $allottes->quarter_type == $quarterType->quarter_id ? 'selected' : '' }}>
                                    {{ $quarterType->quarter_code }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dynamic Property Number Field -->
                    <div class="field">
                        <label class="label required property-number-label">
                            Property No.
                        </label>
                        <input type="text" class="property-number-input" name="property_number"
                            value="{{ $allottes->property_number }}" placeholder="Enter property number" required>
                    </div>

                    <!-- Allottee Name -->
                    <div class="field">
                        <label class="label required">Allottee Name</label>
                        <input type="text" name="allottee_name" value="{{ $allottes->allottee_name }}"
                            placeholder="Enter allottee name" required>
                    </div>

                    <!-- Remarks -->
                    <div class="field">
                        <label class="label">Remarks</label>
                        <select name="remarks">
                            <option value="">-- Select Page Condition --</option>
                            <option value="All Fresh Pages"
                                {{ isset($allottes->remarks) && $allottes->remarks == 'All Fresh Pages' ? 'selected' : '' }}>
                                All Fresh Pages
                            </option>
                            <option value="All Old Pages"
                                {{ isset($allottes->remarks) && $allottes->remarks == 'All Old Pages' ? 'selected' : '' }}>
                                All Old Pages
                            </option>
                            <option value="All Poor Quality Pages"
                                {{ isset($allottes->remarks) && $allottes->remarks == 'All Poor Quality Pages' ? 'selected' : '' }}>
                                All Poor Quality Pages
                            </option>
                            <option value="Partial Fresh and Old Pages"
                                {{ isset($allottes->remarks) && $allottes->remarks == 'Partial Fresh and Old Pages' ? 'selected' : '' }}>
                                Partial Fresh and Old Pages
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="section-actions">
                    <button type="button" class="back-btn" onclick="window.history.back()">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                            <path d="M19 12H5m0 0l6-6m-6 6l6 6" stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                        Back
                    </button>
                    <button type="submit" class="save-btn">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                            <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                        Update Allottee
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to load sub-divisions based on selected division
            function loadSubDivisions(divisionSelect, selectedValue = null) {
                const divisionId = divisionSelect.value;
                const subDivisionSelect = document.querySelector('.sub-division-select');

                subDivisionSelect.innerHTML = '<option value="">Select Sub Division</option>';

                if (!divisionId) return;

                fetch(`/get-sub-divisions/${divisionId}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.name;
                            if (selectedValue && selectedValue == item.id) {
                                option.selected = true;
                            }
                            subDivisionSelect.appendChild(option);
                        });
                    });
            }

            // Function to load property types based on selected category
            function loadPropertyTypes(categorySelect, selectedValue = null) {
                const categoryId = categorySelect.value;
                const propertyTypeSelect = document.querySelector('.property-type-select');

                propertyTypeSelect.innerHTML = '<option value="">Select Property Type</option>';

                if (!categoryId) return;

                fetch(`/get-property-types/${categoryId}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.name;
                            if (selectedValue && selectedValue == item.id) {
                                option.selected = true;
                            }
                            propertyTypeSelect.appendChild(option);
                        });

                        // After loading, check if we need to toggle quarter type
                        toggleQuarterType(propertyTypeSelect);
                    });
            }

            // Function to toggle quarter type field visibility
            function toggleQuarterType(propertyTypeSelect) {
                const quarterField = document.querySelector('.field.quarter-type-field');
                if (!quarterField) return;

                const propertyTypeText = propertyTypeSelect.options[propertyTypeSelect.selectedIndex]?.text
                    .toLowerCase() || '';

                // If property type contains "plot", hide quarter type
                if (propertyTypeText.includes('plot') || propertyTypeText.includes('shop')) {
                    quarterField.style.display = 'none';
                    const quarterSelect = quarterField.querySelector('select');
                    if (quarterSelect) quarterSelect.required = false;
                } else {
                    // Show quarter type for non-plot properties
                    quarterField.style.display = 'block';
                    const quarterSelect = quarterField.querySelector('select');
                    if (quarterSelect) quarterSelect.required = true;
                }
            }

            // Function to update property number label based on property type
            function updatePropertyNumberLabel(propertyTypeSelect) {
                const label = document.querySelector('.property-number-label');
                const input = document.querySelector('.property-number-input');

                if (!label || !input) return;

                const selectedOption = propertyTypeSelect.options[propertyTypeSelect.selectedIndex];

                if (!selectedOption || selectedOption.value === '') {
                    label.textContent = 'Property No.';
                    input.placeholder = 'Enter property number';
                    return;
                }

                const typeName = selectedOption.textContent.trim();
                label.textContent = `${typeName} No.`;
                input.placeholder = `Enter ${typeName.toLowerCase()} number`;

                // Also toggle quarter type when property type changes
                toggleQuarterType(propertyTypeSelect);
            }

            // Initialize the form with existing data
            function initializeForm() {
                // Get existing values
                const divisionId = {{ $allottes->division_id ?? 'null' }};
                const subDivisionId = {{ $allottes->sub_division_id ?? 'null' }};
                const categoryId = {{ $allottes->pcategory_id ?? 'null' }};
                const propertyTypeId = {{ $allottes->p_type_id ?? 'null' }};

                // Load sub-divisions if division is selected
                const divisionSelect = document.querySelector('.division-select');
                if (divisionSelect && divisionId) {
                    loadSubDivisions(divisionSelect, subDivisionId);
                }

                // Load property types if category is selected
                const categorySelect = document.querySelector('.property-category-select');
                if (categorySelect && categoryId) {
                    loadPropertyTypes(categorySelect, propertyTypeId);
                }

                // Set property type and update label
                const propertyTypeSelect = document.querySelector('.property-type-select');
                if (propertyTypeSelect && propertyTypeId) {
                    // Set the value after options are loaded
                    setTimeout(() => {
                        propertyTypeSelect.value = propertyTypeId;
                        updatePropertyNumberLabel(propertyTypeSelect);
                    }, 500); // Wait for options to load
                }

                // Initialize quarter type visibility
                if (propertyTypeSelect) {
                    toggleQuarterType(propertyTypeSelect);
                }
            }

            // Set up event listeners
            function setupEventListeners() {
                const divisionSelect = document.querySelector('.division-select');
                const categorySelect = document.querySelector('.property-category-select');
                const propertyTypeSelect = document.querySelector('.property-type-select');

                if (divisionSelect) {
                    divisionSelect.addEventListener('change', function() {
                        loadSubDivisions(this);
                    });
                }

                if (categorySelect) {
                    categorySelect.addEventListener('change', function() {
                        loadPropertyTypes(this);
                        const label = document.querySelector('.property-number-label');
                        const input = document.querySelector('.property-number-input');
                        if (label) label.textContent = 'Property No.';
                        if (input) input.placeholder = 'Enter property number';
                    });
                }

                if (propertyTypeSelect) {
                    propertyTypeSelect.addEventListener('change', function() {
                        updatePropertyNumberLabel(this);
                    });
                }
            }

            document.getElementById('editAllotteeForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const form = this;
                const saveBtn = form.querySelector('.save-btn');
                const originalText = saveBtn.innerHTML;

                // Detect Plot type
                const propertyTypeSelect = document.querySelector('.property-type-select');
                const isPlot = propertyTypeSelect?.selectedOptions[0]?.text
                    ?.toLowerCase()
                    .includes('plot');

                // Required fields validation
                let inputs = [...form.querySelectorAll('input[required], select[required]')];

                // Exclude quarter type if Plot
                if (isPlot) {
                    inputs = inputs.filter(input => !input.closest('.quarter-type-field'));
                }

                let firstInvalid = null;

                inputs.forEach(input => {
                    const isEmpty = !input.value.trim();
                    input.classList.toggle('is-invalid', isEmpty);
                    if (isEmpty && !firstInvalid) firstInvalid = input;
                });

                if (firstInvalid) {
                    firstInvalid.focus();
                    showToast('Allottees', 'Please fill all required fields.', 'warning');
                    return;
                }

                // Loading state
                saveBtn.innerHTML = 'Updating...';
                saveBtn.disabled = true;

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'X-HTTP-Method-Override': 'POST'
                        },
                        body: new FormData(form)
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        showToast('Allottees', data.message || 'Update failed.', 'warning');
                    } else {
                        showToast('Allottees', 'Details updated successfully.', 'success');
                        saveBtn.innerHTML = 'Updated';
                    }
                } catch (error) {
                    console.error(error);
                    showToast('Allottees', 'Something went wrong. Please try again.', 'warning');
                } finally {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalText;
                }
            });


            // Initialize the form
            initializeForm();
            setupEventListeners();
        });
    </script>
@endpush
