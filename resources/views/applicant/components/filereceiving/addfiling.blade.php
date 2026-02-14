@extends('applicant.dashboard_layouts.main')

@section('title', 'Add Files')

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

        .custom-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 6px;
            color: white;
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 300px;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.3s ease;
        }

        .custom-notification.success {
            background-color: #28a745;
        }

        .custom-notification.error {
            background-color: #dc3545;
        }

        .custom-notification.info {
            background-color: #17a2b8;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
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

        .remove-section {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 12px;
            cursor: pointer;
            font-size: 14px;
        }

        .remove-section:hover {
            background: #c82333;
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

        .readonly-field {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }

        .allottee-counter {
            background: #6c757d;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-size: 12px;
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

        /* Property number label styling */
        .property-number-label {
            transition: all 0.3s ease;
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

        .save-btn.updating {
            background: #ffc107;
            color: #212529;
        }

        .save-btn.updating:hover {
            background: #e0a800;
        }

        .submit-btn {
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 4px 14px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }

        .submit-btn:hover {
            background: #218838;
        }

        .section-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 9px;
            padding-top: 0px;
            border-top: 1px solid #dee2e6;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }

        .status-saved {
            background: #d4edda;
            color: #155724;
        }

        .status-unsaved {
            background: #fff3cd;
            color: #856404;
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
                    <h1 class="header-title">File Receiving Register (REG ID.: {{ $register->register_no }})</h1>
                    <p class="header-subtitle">Complete each allottee form and save individually. Then register the file.
                    </p>
                </div>
                <div class="header-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Delete Registration Button (NEW) -->
        {{-- <div style="text-align: right; padding: 10px 20px;">
            <button type="button" id="deleteRegistrationBtn"
                style="
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        ">
                <svg viewBox="0 0 24 24" width="16" height="16">
                    <path
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        stroke="currentColor" stroke-width="2" fill="none" />
                </svg>
                Delete Registration
            </button>
        </div> --}}

        <!-- Form Body -->
        <form id="fileTrackingForm" action="{{ route('admin.filereceving.store') }}" method="POST" class="form-body">
            @csrf
            <input type="hidden" id="register_id" name="register_id" value="{{ $register->register_no }}">
            <!-- Allottee Sections -->
            <div id="allottee-sections">
                @if (old('allottees') && count(old('allottees')) > 0)
                    @foreach (old('allottees') as $index => $allottee)
                        <div class="dynamic-section" data-index="{{ $index }}" id="section-{{ $index }}">
                            <div class="section-header">
                                <div class="section-title">
                                    <span class="allottee-counter">{{ $index + 1 }}</span>
                                    Allottee File Details
                                    <span class="status-badge status-unsaved" id="status-{{ $index }}">Unsaved</span>
                                </div>
                                @if ($index > 0)
                                    <button type="button" class="remove-section"
                                        onclick="removeSection(this)">Remove</button>
                                @endif
                            </div>

                            <div class="form-grid">
                                <!-- Division -->
                                <div class="field">
                                    <label class="label required">Division</label>
                                    <select name="allottees[{{ $index }}][division_id]"
                                        class="division-select @error('allottees.' . $index . '.division_id') border-red-500 @enderror"
                                        required>
                                        <option value="">Select Division</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}"
                                                {{ $allottee['division_id'] == $division->id ? 'selected' : '' }}>
                                                {{ $division->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('allottees.' . $index . '.division_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sub Division -->
                                <div class="field">
                                    <label class="label required">Sub Division</label>
                                    <select name="allottees[{{ $index }}][sub_division_id]"
                                        class="sub-division-select @error('allottees.' . $index . '.sub_division_id') border-red-500 @enderror"
                                        required>
                                        <option value="">Select Sub Division</option>
                                        @if ($allottee['division_id'])
                                            <!-- Sub-divisions will be loaded via JavaScript -->
                                        @endif
                                    </select>
                                    @error('allottees.' . $index . '.sub_division_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Property Category -->
                                <div class="field">
                                    <label class="label required">Property Category</label>
                                    <select name="allottees[{{ $index }}][pcategory_id]"
                                        class="property-category-select @error('allottees.' . $index . '.pcategory_id') border-red-500 @enderror"
                                        required>
                                        <option value="">Select Category</option>
                                        @foreach ($getPropertyCategory as $PropertyCategory)
                                            <option value="{{ $PropertyCategory->id }}"
                                                {{ $allottee['pcategory_id'] == $PropertyCategory->id ? 'selected' : '' }}>
                                                {{ $PropertyCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('allottees.' . $index . '.pcategory_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Property Type -->
                                <div class="field">
                                    <label class="label required">Property Type</label>
                                    <select name="allottees[{{ $index }}][p_type_id]"
                                        class="property-type-select @error('allottees.' . $index . '.p_type_id') border-red-500 @enderror"
                                        required>
                                        <option value="">Select Property Type</option>
                                        @if ($allottee['pcategory_id'])
                                            <!-- Property types will be loaded via JavaScript -->
                                        @endif
                                    </select>
                                    @error('allottees.' . $index . '.p_type_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Dynamic Property Number Field -->
                                <div class="field">
                                    <label class="label required property-number-label">
                                        @php
                                            // Set initial label based on selected property type
                                            $labelText = 'Property No.';
                                            if (isset($allottee['p_type_id']) && $allottee['p_type_id']) {
                                                $propertyType = \App\Models\PropertyType::find($allottee['p_type_id']);
                                                if ($propertyType) {
                                                    $labelText = $propertyType->name . ' No.';
                                                }
                                            }
                                        @endphp
                                        {{ $labelText }}
                                    </label>
                                    <input type="text" class="property-number-input"
                                        name="allottees[{{ $index }}][property_number]"
                                        placeholder="{{ str_replace(' No.', ' number', $labelText) }}"
                                        value="{{ $allottee['property_number'] }}" required>
                                </div>

                                <!-- Quarter Type -->
                                <div class="field quarter-type-field">
                                    <label class="label required">Quarter type</label>
                                    <select name="allottees[{{ $index }}][quarter_type]"
                                        class="quarter-type-select @error('allottees.' . $index . '.quarter_type') border-red-500 @enderror"
                                        required>
                                        <option value="">Select type</option>
                                        @foreach ($getQuarterType as $quarterType)
                                            <option value="{{ $quarterType->quarter_id }}"
                                                {{ $allottee['quarter_type'] == $quarterType->quarter_id ? 'selected' : '' }}>
                                                {{ $quarterType->quarter_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('allottees.' . $index . '.quarter_type')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Allottee Name -->
                                <div class="field">
                                    <label class="label required">Allottee Name</label>
                                    <input type="text" name="allottees[{{ $index }}][allottee_name]"
                                        placeholder="Enter allottee name" value="{{ $allottee['allottee_name'] }}"
                                        required>
                                </div>

                                <!-- No. of Files -->
                                <div class="field">
                                    <label class="label required">No. of Files</label>
                                    <select name="allottees[{{ $index }}][no_of_files]" required>

                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}"
                                                {{ (isset($allottee['no_of_files']) ? $allottee['no_of_files'] == $i : $i == 1) ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor

                                    </select>
                                </div>

                                <!-- No. of Supplement -->
                                <div class="field">
                                    <label class="label">Additional Supplements Files</label>
                                    <select name="allottees[{{ $index }}][no_of_supplement]">
                                        <option value="">-- Select No. of Supplement --</option>

                                        @for ($i = 0; $i <= 10; $i++)
                                            <option value="{{ $i }}"
                                                {{ (isset($allottee['no_of_supplement']) ? $allottee['no_of_supplement'] == $i : $i == 0) ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor

                                    </select>
                                </div>

                                <!-- Remarks -->
                                <div class="field">
                                    <label class="label">Remarks</label>
                                    <select name="allottees[{{ $index }}][remarks]">
                                        <option value="">-- Select Page Condition --</option>
                                        <option value="All Fresh Pages"
                                            {{ isset($allottee['remarks']) && $allottee['remarks'] == 'All Fresh Pages' ? 'selected' : '' }}>
                                            All Fresh Pages
                                        </option>
                                        <option value="All Old Pages"
                                            {{ isset($allottee['remarks']) && $allottee['remarks'] == 'All Old Pages' ? 'selected' : '' }}>
                                            All Old Pages
                                        </option>
                                        <option value="All Poor Quality Pages"
                                            {{ isset($allottee['remarks']) && $allottee['remarks'] == 'All Poor Quality Pages' ? 'selected' : '' }}>
                                            All Poor Quality Pages
                                        </option>
                                        <option value="Partial Fresh and Old Pages"
                                            {{ isset($allottee['remarks']) && $allottee['remarks'] == 'Partial Fresh and Old Pages' ? 'selected' : '' }}>
                                            Partial Fresh and Old Pages
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Individual Save Button -->
                            <div class="section-actions">
                                <button type="button" class="save-btn" onclick="saveAllottee({{ $index }})"
                                    id="save-btn-{{ $index }}">
                                    <svg viewBox="0 0 24 24" width="16" height="16">
                                        <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" fill="none" />
                                    </svg>
                                    Save
                                </button>
                            </div>
                        </div>
                    @endforeach
                @elseif(isset($existingAllottees) && count($existingAllottees) > 0)
                    @foreach ($existingAllottees as $index => $allottee)
                        <div class="dynamic-section" data-index="{{ $index }}" id="section-{{ $index }}">
                            <div class="section-header">
                                <div class="section-title">
                                    <span class="allottee-counter">{{ $index + 1 }}</span>
                                    Allottee File Details
                                    <span class="status-badge status-saved" id="status-{{ $index }}">Saved</span>
                                </div>
                                @if ($index > 0)
                                    <button type="button" class="remove-section"
                                        onclick="removeSection(this)">Remove</button>
                                @endif
                            </div>

                            <div class="form-grid">
                                <!-- Hidden allottee ID for updates -->
                                <input type="hidden" class="allottee-id-input"
                                    name="allottees[{{ $index }}][id]" value="{{ $allottee->id }}">

                                <!-- Division -->
                                <div class="field">
                                    <label class="label required">Division</label>
                                    <select name="allottees[{{ $index }}][division_id]" class="division-select"
                                        required>
                                        <option value="">Select Division</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}"
                                                {{ $allottee->division_id == $division->id ? 'selected' : '' }}>
                                                {{ $division->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Sub Division -->
                                <div class="field">
                                    <label class="label required">Sub Division</label>
                                    <select name="allottees[{{ $index }}][sub_division_id]"
                                        class="sub-division-select" required>
                                        <option value="">Select Sub Division</option>
                                    </select>
                                </div>

                                <!-- Property Category -->
                                <div class="field">
                                    <label class="label required">Property Category</label>
                                    <select name="allottees[{{ $index }}][pcategory_id]"
                                        class="property-category-select" required>
                                        <option value="">Select Category</option>
                                        @foreach ($getPropertyCategory as $PropertyCategory)
                                            <option value="{{ $PropertyCategory->id }}"
                                                {{ $allottee->pcategory_id == $PropertyCategory->id ? 'selected' : '' }}>
                                                {{ $PropertyCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Property Type -->
                                <div class="field">
                                    <label class="label required">Property Type</label>
                                    <select name="allottees[{{ $index }}][p_type_id]" class="property-type-select"
                                        required>
                                        <option value="">Select Property Type</option>
                                    </select>
                                </div>

                                <!-- Quarter Type (Conditional - Hidden for Plot) -->
                                <div
                                    class="field quarter-type-field {{ $allottee->p_type_id ? (isPlotType($allottee->p_type_id) ? 'hidden-field' : '') : '' }}">
                                    <label class="label required">Quarter type</label>
                                    <select name="allottees[{{ $index }}][quarter_type]"
                                        class="quarter-type-select"
                                        {{ $allottee->p_type_id ? (isPlotType($allottee->p_type_id) ? 'disabled' : 'required') : 'required' }}>
                                        <option value="">Select type</option>
                                        @foreach ($getQuarterType as $quarterType)
                                            <option value="{{ $quarterType->quarter_id }}"
                                                {{ $allottee->quarter_type == $quarterType->quarter_id ? 'selected' : '' }}>
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
                                    <input type="text" class="property-number-input"
                                        name="allottees[{{ $index }}][property_number]"
                                        placeholder="Enter property number" value="{{ $allottee->property_number }}"
                                        required>
                                </div>


                                <!-- Allottee Name -->
                                <div class="field">
                                    <label class="label required">Allottee Name</label>
                                    <input type="text" name="allottees[{{ $index }}][allottee_name]"
                                        placeholder="Enter allottee name" value="{{ $allottee->allottee_name }}"
                                        required>
                                </div>


                                <!-- No. of Files -->
                                <div class="field">
                                    <label class="label required">No. of Files</label>
                                    <select name="allottees[{{ $index }}][no_of_files]" required>

                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}"
                                                {{ (isset($allottee['no_of_files']) ? $allottee['no_of_files'] == $i : $i == 1) ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor

                                    </select>
                                </div>

                                <!-- No. of Supplement -->
                                <div class="field">
                                    <label class="label">Additional Supplements Files</label>
                                    <select name="allottees[{{ $index }}][no_of_supplement]">
                                        <option value="">-- Select No. of Supplement --</option>

                                        @for ($i = 0; $i <= 10; $i++)
                                            <option value="{{ $i }}"
                                                {{ (isset($allottee['no_of_supplement']) ? $allottee['no_of_supplement'] == $i : $i == 0) ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor

                                    </select>
                                </div>

                                <!-- Remarks -->
                                <div class="field">
                                    <label class="label">Remarks</label>
                                    <select name="allottees[{{ $index }}][remarks]">
                                        <option value="">-- Select Page Condition --</option>
                                        <option value="All Fresh Pages"
                                            {{ isset($allottee['remarks']) && $allottee['remarks'] == 'All Fresh Pages' ? 'selected' : '' }}>
                                            All Fresh Pages
                                        </option>
                                        <option value="All Old Pages"
                                            {{ isset($allottee['remarks']) && $allottee['remarks'] == 'All Old Pages' ? 'selected' : '' }}>
                                            All Old Pages
                                        </option>
                                        <option value="All Poor Quality Pages"
                                            {{ isset($allottee['remarks']) && $allottee['remarks'] == 'All Poor Quality Pages' ? 'selected' : '' }}>
                                            All Poor Quality Pages
                                        </option>
                                        <option value="Partial Fresh and Old Pages"
                                            {{ isset($allottee['remarks']) && $allottee['remarks'] == 'Partial Fresh and Old Pages' ? 'selected' : '' }}>
                                            Partial Fresh and Old Pages
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Individual Save Button -->
                            <div class="section-actions">
                                <button type="button" class="save-btn" onclick="saveAllottee({{ $index }})"
                                    id="save-btn-{{ $index }}">
                                    <svg viewBox="0 0 24 24" width="16" height="16">
                                        <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" fill="none" />
                                    </svg>
                                    Update
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Default first section -->
                    <div class="dynamic-section" data-index="0" id="section-0">
                        <div class="section-header">
                            <div class="section-title">
                                <span class="allottee-counter">1</span>
                                Allottee File Details
                                <span class="status-badge status-unsaved" id="status-0">Unsaved</span>
                            </div>
                        </div>

                        <div class="form-grid">
                            <!-- Hidden allottee ID for updates -->
                            <input type="hidden" class="allottee-id-input" name="allottees[0][id]" value="">

                            <!-- Division -->
                            <div class="field">
                                <label class="label required">Division</label>
                                <select name="allottees[0][division_id]" class="division-select" required>
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sub Division -->
                            <div class="field">
                                <label class="label required">Sub Division</label>
                                <select name="allottees[0][sub_division_id]" class="sub-division-select" required>
                                    <option value="">Select Sub Division</option>
                                </select>
                            </div>

                            <!-- Property Category -->
                            <div class="field">
                                <label class="label required">Property Category</label>
                                <select name="allottees[0][pcategory_id]" class="property-category-select" required>
                                    <option value="">Select Category</option>
                                    @foreach ($getPropertyCategory as $PropertyCategory)
                                        <option value="{{ $PropertyCategory->id }}">{{ $PropertyCategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Property Type -->
                            <div class="field">
                                <label class="label required">Property Type</label>
                                <select name="allottees[0][p_type_id]" class="property-type-select" required>
                                    <option value="">Select Property Type</option>
                                </select>
                            </div>

                            <!-- Quarter Type (Conditional - Hidden for Plot) -->
                            <div class="field quarter-type-field">
                                <label class="label required">Quarter type</label>
                                <select name="allottees[0][quarter_type]" class="quarter-type-select" required>
                                    <option value="">Select type</option>
                                    @foreach ($getQuarterType as $quarterType)
                                        <option value="{{ $quarterType->quarter_id }}" >
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
                                <input type="text" class="property-number-input" name="allottees[0][property_number]"
                                    placeholder="Enter property number" required>
                            </div>

                            <!-- Allottee Name -->
                            <div class="field">
                                <label class="label required">Allottee Name</label>
                                <input type="text" name="allottees[0][allottee_name]"
                                    placeholder="Enter allottee name" required>
                            </div>


                            <!-- No. of Files -->
                            <div class="field">
                                <label class="label required">No. of Files</label>
                                <select name="allottees[0][no_of_files]" required>

                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}"
                                            {{ (isset($allottee['no_of_files']) ? $allottee['no_of_files'] == $i : $i == 1) ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- No. of Supplement -->
                            <div class="field">
                                <label class="label">Additional Supplements Files</label>
                                <select name="allottees[0][no_of_supplement]">
                                    <option value="">-- Select No. of Supplement --</option>

                                    @for ($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}"
                                            {{ (isset($allottee['no_of_supplement']) ? $allottee['no_of_supplement'] == $i : $i == 0) ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Remarks -->
                            <div class="field">
                                <label class="label">Remarks</label>
                                <select name="allottees[0][remarks]">
                                    <option value="">-- Select Page Condition --</option>
                                    <option value="All Fresh Pages">
                                        All Fresh Pages
                                    </option>
                                    <option value="All Old Pages">
                                        All Old Pages
                                    </option>
                                    <option value="All Poor Quality Pages">
                                        All Poor Quality Pages
                                    </option>
                                    <option value="Partial Fresh and Old Pages">
                                        Partial Fresh and Old Pages
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Individual Save Button -->
                        <div class="section-actions">
                            <button type="button" class="save-btn" onclick="saveAllottee(0)" id="save-btn-0">
                                <svg viewBox="0 0 24 24" width="16" height="16">
                                    <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" fill="none" />
                                </svg>
                                Save
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Add More Button -->
            <div style="text-align: center; margin: 20px 0;">
                <button type="button" class="submit-btn" onclick="addAllotteeSection()">
                    <svg viewBox="0 0 24 24" width="16" height="16">
                        <path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                    Add More
                </button>
            </div>

            <!-- Form Footer with Submit Button -->
            <div class="form-footer">
                <button type="submit" class="submit-btn">
                    Submit File Records
                    <svg viewBox="0 0 24 24">
                        <path d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const savedAllottees = {}; // Store saved allottee data {index: allotteeId}
            let registerId = document.getElementById('register_id')?.value;
            let hasSavedAnyAllottee = false;

            // Local storage key for tracking registration
            const STORAGE_KEY = 'file_receiving_registration_' + registerId;
            const STORAGE_COUNT_KEY = 'file_receiving_count_' + registerId;

            function toggleQuarterType(propertyTypeSelect) {
                const section = propertyTypeSelect.closest('.dynamic-section');
                if (!section) return;

                const quarterField = section.querySelector('.quarter-type-field');
                const quarterSelect = quarterField?.querySelector('select');
                if (!quarterSelect) return;

                const propertyTypeText =
                    propertyTypeSelect.options[propertyTypeSelect.selectedIndex]?.text
                    ?.toLowerCase() || '';

                const isPlot = propertyTypeText.includes('plot');

                // Loop through all quarter options
                Array.from(quarterSelect.options).forEach(option => {
                    const text = option.text.toLowerCase();

                    if (!option.value) return; // skip "Select type"

                    if (isPlot) {
                        // Show only MIG & HIG
                        if (text.includes('mig') || text.includes('hig')) {
                            option.hidden = false;
                        } else {
                            option.hidden = true;
                            if (option.selected) option.selected = false;
                        }
                    } else {
                        // Show all options
                        option.hidden = false;
                    }
                });

                // Make required always true (since not hiding field)
                quarterSelect.required = true;
            }


            function initializeSections() {
                document.querySelectorAll('.dynamic-section').forEach((section, index) => {
                    const allotteeIdInput = section.querySelector('.allottee-id-input');
                    if (allotteeIdInput && allotteeIdInput.value) {
                        savedAllottees[index] = allotteeIdInput.value;
                        hasSavedAnyAllottee = true;

                        // Update button text for existing allottees
                        const saveBtn = document.getElementById(`save-btn-${index}`);
                        if (saveBtn) {
                            saveBtn.querySelector('span').textContent = 'Update';
                            saveBtn.classList.add('updating');
                        }
                    }

                    // Initialize quarter type visibility
                    const propertyTypeSelect = section.querySelector('.property-type-select');
                    if (propertyTypeSelect) {
                        toggleQuarterType(propertyTypeSelect);
                    }
                });
            }

            initializeSections();

            function setupLocalStorageTracking() {
                if (!registerId) return;

                // Get current attempt count
                let attemptCount = parseInt(localStorage.getItem(STORAGE_COUNT_KEY)) || 0;
                attemptCount++;
                localStorage.setItem(STORAGE_COUNT_KEY, attemptCount.toString());

                // Set initial state in localStorage
                if (!hasSavedAnyAllottee) {
                    localStorage.setItem(STORAGE_KEY, JSON.stringify({
                        registerId: registerId,
                        hasSavedAnyAllottee: false,
                        timestamp: Date.now(),
                        attemptCount: attemptCount
                    }));
                }

                // Check if user should be redirected (5 attempts without saving)
                if (attemptCount >= 5 && !hasSavedAnyAllottee) {
                    showForceRedirectWarning();
                    return;
                }

                // Listen for storage changes (for multi-tab support)
                window.addEventListener('storage', function(e) {
                    if (e.key === STORAGE_KEY) {
                        try {
                            const data = JSON.parse(e.newValue);
                            if (data && data.hasSavedAnyAllottee) {
                                hasSavedAnyAllottee = data.hasSavedAnyAllottee;
                            }
                        } catch (err) {
                            console.error('Error parsing storage data:', err);
                        }
                    }
                });
            }

            function showForceRedirectWarning() {
                // Create warning modal
                const modal = document.createElement('div');
                modal.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0,0,0,0.8);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 100000;
                `;

                modal.innerHTML = `
                    <div style="
                        background: white;
                        padding: 30px;
                        border-radius: 10px;
                        max-width: 500px;
                        width: 90%;
                        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
                        ">
                        <h3 style="color: #dc3545; margin-bottom: 15px;">Registration Cancelled</h3>
                        <p style="margin-bottom: 20px;">
                            You have attempted to create a registration 5 times without saving any allottees.
                            The current registration will be deleted and you will be redirected.
                        </p>
                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button id="forceDeleteBtn" style="
                                background: #dc3545;
                                color: white;
                                border: none;
                                padding: 10px 20px;
                                border-radius: 5px;
                                cursor: pointer;
                            ">Delete Registration & Redirect</button>
                        </div>
                    </div>
                `;

                document.body.appendChild(modal);

                document.getElementById('forceDeleteBtn').addEventListener('click', function() {
                    deleteEmptyRegister().then(() => {
                        localStorage.removeItem(STORAGE_KEY);
                        localStorage.removeItem(STORAGE_COUNT_KEY);
                        window.location.href = '/dashboard'; // Redirect to dashboard
                    });
                });
            }

            function updateLocalStorageState() {
                if (!registerId) return;

                localStorage.setItem(STORAGE_KEY, JSON.stringify({
                    registerId: registerId,
                    hasSavedAnyAllottee: hasSavedAnyAllottee,
                    timestamp: Date.now()
                }));

                // Reset attempt count when user saves something
                if (hasSavedAnyAllottee) {
                    localStorage.removeItem(STORAGE_COUNT_KEY);
                }
            }

            function setupPageLeaveWarning() {
                let beforeUnloadHandler = function(e) {
                    // Only trigger if no allottees saved
                    if (!hasSavedAnyAllottee && registerId) {
                        // Standard browser warning message
                        e.preventDefault();
                        e.returnValue = '';
                        return e.returnValue;
                    }
                };

                window.addEventListener('beforeunload', beforeUnloadHandler);

                // Store reference for later removal
                window.beforeUnloadHandler = beforeUnloadHandler;

                // Also handle visibility change for tab switching
                document.addEventListener('visibilitychange', function() {
                    if (document.visibilityState === 'hidden') {
                        // User switched tabs or minimized browser
                        if (!hasSavedAnyAllottee && registerId) {
                            // Keep the registration in localStorage
                            updateLocalStorageState();
                        }
                    }
                });
            }

            // Initialize localStorage tracking
            setupLocalStorageTracking();

            // Set up page leave warning if no allottees saved
            if (!hasSavedAnyAllottee && registerId) {
                setupPageLeaveWarning();
            }

            function deleteEmptyRegister() {
                if (!registerId) return Promise.resolve(false);

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) return Promise.reject('CSRF token not found');

                return fetch('/filereceving/delete-empty-register', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            register_id: registerId
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Clean up localStorage on successful delete
                            localStorage.removeItem(STORAGE_KEY);
                            localStorage.removeItem(STORAGE_COUNT_KEY);
                            return true;
                        }
                        return false;
                    })
                    .catch(error => {
                        console.error('Error deleting empty register:', error);
                        return false;
                    });
            }


            function setupDeleteButton() {
                const deleteBtn = document.getElementById('deleteRegistrationBtn');
                if (!deleteBtn) return;

                deleteBtn.addEventListener('click', function() {
                    if (!confirm(
                            'Are you sure you want to delete this registration? All unsaved data will be lost.'
                        )) {
                        return;
                    }

                    // Show loading
                    deleteBtn.innerHTML = 'Deleting...';
                    deleteBtn.disabled = true;

                    deleteEmptyRegister().then(success => {
                        if (success) {
                            showNotification('File Receiving', 'Registration deleted successfully!',
                                'success');
                            setTimeout(() => {
                                window.location.href =
                                    '/dashboard'; // Redirect to dashboard
                            }, 1500);
                        } else {
                            showNotification('File Receiving', 'Failed to delete registration.',
                                'error');
                            deleteBtn.innerHTML = 'Delete Registration';
                            deleteBtn.disabled = false;
                        }
                    });
                });
            }

            // Set up delete button
            setupDeleteButton();

            let isLeavingPage = false;
            let pageLeaveConfirmed = false;

            window.addEventListener('beforeunload', function(e) {
                if (!hasSavedAnyAllottee && registerId && !isLeavingPage) {
                    // Store in localStorage that we're showing the warning
                    localStorage.setItem(STORAGE_KEY + '_warning', 'true');
                }
            });

            window.addEventListener('unload', function() {
                // Only delete if no allottees saved AND user confirmed leaving
                if (!hasSavedAnyAllottee && registerId) {
                    // Check if user confirmed leaving (warning was shown)
                    const warningShown = localStorage.getItem(STORAGE_KEY + '_warning');

                    if (warningShown === 'true') {
                        // User saw the warning and still chose to leave
                        deleteEmptyRegister().then(() => {
                            // Clean up localStorage
                            localStorage.removeItem(STORAGE_KEY);
                            localStorage.removeItem(STORAGE_COUNT_KEY);
                            localStorage.removeItem(STORAGE_KEY + '_warning');
                        });
                    }
                }
            });

            // Clean up localStorage warning flag if page stays
            window.addEventListener('pageshow', function() {
                localStorage.removeItem(STORAGE_KEY + '_warning');
            });

            function deleteAllottee(allotteeId, index) {
                if (!allotteeId) return Promise.resolve();

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) return Promise.reject('CSRF token not found');

                return fetch('/filereceving/delete-allottee', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            allottee_id: allotteeId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Remove from savedAllottees
                            delete savedAllottees[index];
                            hasSavedAnyAllottee = Object.keys(savedAllottees).length > 0;

                            // Update localStorage
                            updateLocalStorageState();

                            return true;
                        } else {
                            throw new Error(data.message || 'Failed to delete allottee');
                        }
                    });
            }

            window.saveAllottee = function(index) {
                const section = document.getElementById(`section-${index}`);
                if (!section) {
                    console.error('Section not found for index:', index);
                    alert('Error: Could not find section to save.');
                    return;
                }

                if (!registerId) {
                    alert('Error: Register ID not found.');
                    return;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    alert('CSRF token not found. Please refresh the page and try again.');
                    return;
                }


                let inputs = section.querySelectorAll('input[required], select[required]');

                let isValid = true;
                let firstInvalidInput = null;

                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.style.borderColor = '#dc3545';
                        if (!firstInvalidInput) firstInvalidInput = input;
                        isValid = false;
                    } else {
                        input.style.borderColor = '';
                    }
                });

                if (!isValid) {
                    if (firstInvalidInput) {
                        firstInvalidInput.focus();
                    }
                    alert('Please fill all required fields (marked in red) before saving.');
                    return;
                }

                // Get allottee ID for update
                const allotteeIdInput = section.querySelector('.allottee-id-input');
                const allotteeId = allotteeIdInput ? allotteeIdInput.value : null;
                const isUpdate = !!allotteeId;

                // Prepare form data
                const formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('register_id', registerId);
                if (isUpdate) {
                    formData.append('allottee_id', allotteeId);
                }

                // If plot, don't include quarter type in form data
                section.querySelectorAll('input, select').forEach(el => {
                    if (el.name && el.name.includes('allottees')) {
                        const match = el.name.match(/allottees\[(\d+)\]\[(\w+)\]/);
                        if (match) {
                            const fieldName = match[2];
                            // Don't include the ID field in the form data
                            if (fieldName !== 'id') {
                                formData.append(fieldName, el.value);
                            }
                        }
                    }
                });

                // Show loading state
                const saveBtn = document.getElementById(`save-btn-${index}`);
                if (saveBtn) {
                    const originalText = saveBtn.innerHTML;
                    saveBtn.innerHTML = '<span>Saving...</span>';
                    saveBtn.disabled = true;
                }

                // Determine endpoint and method
                const endpoint = isUpdate ? '/filereceving/individual/update-allottee' :
                    '{{ route('admin.individual.filereceving.store') }}';
                const method = 'POST';

                // Send request
                fetch(endpoint, {
                        method: method,
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {

                        if (!data.success) {
                            // Handle limit reached or validation errors
                            showNotification(
                                'File Receiving',
                                data.message || 'Operation failed.',
                                'error'
                            );
                            return;
                        }

                        // ✅ SUCCESS FLOW
                        const statusBadge = document.getElementById(`status-${index}`);
                        if (statusBadge) {
                            statusBadge.textContent = 'Saved';
                            statusBadge.className = 'status-badge status-saved';
                        }

                        if (data.allottee_id) {
                            savedAllottees[index] = data.allottee_id;
                            if (allotteeIdInput) {
                                allotteeIdInput.value = data.allottee_id;
                            }
                        }

                        hasSavedAnyAllottee = true;

                        if (window.beforeUnloadHandler) {
                            window.removeEventListener('beforeunload', window.beforeUnloadHandler);
                        }

                        updateLocalStorageState();

                        if (saveBtn) {
                            const span = saveBtn.querySelector('span');
                            if (span) span.textContent = 'Update';
                            saveBtn.classList.add('updating');
                        }

                        enableSubmitButton();

                        showNotification(
                            'File Receiving',
                            isUpdate ?
                            'Allottee updated successfully!' :
                            'Allottee saved successfully!',
                            'success'
                        );
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        showNotification(
                            'File Receiving',
                            error.message || 'Unexpected error occurred.',
                            'error'
                        );
                    })

                    .finally(() => {
                        // Restore save button state
                        if (saveBtn) {
                            const buttonText = allotteeIdInput && allotteeIdInput.value ? 'Update' : 'Save';
                            saveBtn.innerHTML = `
                        <svg viewBox="0 0 24 24" width="16" height="16">
                            <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        <span>${buttonText}</span>
                    `;
                            saveBtn.disabled = false;
                            if (allotteeIdInput && allotteeIdInput.value) {
                                saveBtn.classList.add('updating');
                            }
                        }
                    });
            };

            document.getElementById('fileTrackingForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const hasSavedAllottees = Object.keys(savedAllottees).length > 0;

                if (!hasSavedAllottees) {
                    alert('Please save at least one allottee before submitting the form.');
                    return;
                }

                const allotteeSections = document.querySelectorAll('.dynamic-section[id^="section-"]');
                const unsavedSections = [];

                allotteeSections.forEach((section, index) => {
                    const statusBadge = document.getElementById(`status-${index}`);
                    if (statusBadge && statusBadge.textContent === 'Unsaved') {
                        unsavedSections.push(index + 1);
                    }
                });

                if (unsavedSections.length > 0) {
                    const confirmed = confirm(
                        `Allottee(s) ${unsavedSections.join(', ')} are not saved. Do you want to register the file anyway? Unsaved data will be lost.`
                    );

                    if (!confirmed) {
                        return;
                    }
                }

                // Mark that we're leaving the page for registration
                isLeavingPage = true;

                // Submit the form via AJAX to handle response
                const formData = new FormData(this);
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        }
                        throw new Error('Network response was not ok');
                    })
                    .then(data => {
                        if (data.success) {
                            // Clean up localStorage
                            localStorage.removeItem(STORAGE_KEY);
                            localStorage.removeItem(STORAGE_COUNT_KEY);
                            localStorage.removeItem(STORAGE_KEY + '_warning');

                            // Show success message
                            showNotification('File Receiving', 'File registered successfully!',
                                'success');

                            // Redirect after a short delay
                            setTimeout(() => {
                                if (data.redirect_url) {
                                    window.location.href = data.redirect_url;
                                } else {
                                    window.location.href =
                                        '/dashboard'; // Default redirect
                                }
                            }, 1500);
                        } else {
                            showNotification('File Receiving', data.message || 'Registration failed.',
                                'error');
                            isLeavingPage = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('File Receiving', 'An error occurred during registration.',
                            'error');
                        isLeavingPage = false;
                    });
            });

            function cleanupOldStorageEntries() {
                const now = Date.now();
                const oneHour = 60 * 60 * 1000; // 1 hour in milliseconds

                for (let i = 0; i < localStorage.length; i++) {
                    const key = localStorage.key(i);
                    if (key && key.startsWith('file_receiving_registration_')) {
                        try {
                            const data = JSON.parse(localStorage.getItem(key));
                            if (data && data.timestamp) {
                                // Remove entries older than 1 hour
                                if (now - data.timestamp > oneHour) {
                                    localStorage.removeItem(key);
                                    localStorage.removeItem(key + '_warning');
                                    // Also remove corresponding count key
                                    const countKey = key.replace('registration_', 'count_');
                                    localStorage.removeItem(countKey);
                                }
                            }
                        } catch (err) {
                            // If parsing fails, remove the entry
                            localStorage.removeItem(key);
                            localStorage.removeItem(key + '_warning');
                            const countKey = key.replace('registration_', 'count_');
                            localStorage.removeItem(countKey);
                        }
                    }
                }
            }

            // Run cleanup on page load
            cleanupOldStorageEntries();


            function showNotification(title, message, type) {
                showToast('File Receiving', message, type);
            }


            function enableSubmitButton() {
                const submitBtn = document.querySelector('.submit-btn[type="submit"]');
                const hasSavedAllottees = Object.keys(savedAllottees).length > 0;

                if (submitBtn) {
                    submitBtn.disabled = !hasSavedAllottees;
                    if (!hasSavedAllottees) {
                        submitBtn.title = 'Please save at least one allottee before submitting';
                    } else {
                        submitBtn.title = '';
                    }
                }
            }


            function loadSubDivisions(divisionSelect, selectedValue = null) {
                const divisionId = divisionSelect.value;
                const section = divisionSelect.closest('.dynamic-section');
                const subDivisionSelect = section.querySelector('.sub-division-select');

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


            function loadPropertyTypes(categorySelect, selectedValue = null) {
                const categoryId = categorySelect.value;
                const section = categorySelect.closest('.dynamic-section');
                const propertyTypeSelect = section.querySelector('.property-type-select');

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
                        if (selectedValue) {
                            toggleQuarterType(propertyTypeSelect);
                        }
                    });
            }


            function updatePropertyNumberLabel(propertyTypeSelect) {
                const section = propertyTypeSelect.closest('.dynamic-section');
                if (!section) return;

                const label = section.querySelector('.property-number-label');
                const input = section.querySelector('.property-number-input');

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

            function markSectionUnsaved(index) {
                if (index !== null && savedAllottees[index]) {
                    // Don't delete savedAllottees entry, but mark as unsaved
                    const statusBadge = document.getElementById(`status-${index}`);
                    if (statusBadge) {
                        statusBadge.textContent = 'Unsaved';
                        statusBadge.className = 'status-badge status-unsaved';
                    }

                    // Update button text
                    const saveBtn = document.getElementById(`save-btn-${index}`);
                    if (saveBtn) {
                        const span = saveBtn.querySelector('span');
                        if (span) span.textContent = 'Save';
                        saveBtn.classList.remove('updating');
                    }
                }
            }

            function attachEvents(section, index = null) {
                const divisionSelect = section.querySelector('.division-select');
                const categorySelect = section.querySelector('.property-category-select');
                const propertyTypeSelect = section.querySelector('.property-type-select');

                if (divisionSelect) {
                    // Load sub-divisions if division is already selected
                    if (divisionSelect.value) {
                        const subDivisionSelect = section.querySelector('.sub-division-select');
                        const selectedValue = subDivisionSelect ? subDivisionSelect.value : null;
                        loadSubDivisions(divisionSelect, selectedValue);
                    }

                    divisionSelect.addEventListener('change', function() {
                        loadSubDivisions(this);
                        markSectionUnsaved(index);
                    });
                }

                if (categorySelect) {
                    // Load property types if category is already selected
                    if (categorySelect.value) {
                        const ptypeSelect = section.querySelector('.property-type-select');
                        const selectedValue = ptypeSelect ? ptypeSelect.value : null;
                        loadPropertyTypes(categorySelect, selectedValue);
                    }

                    categorySelect.addEventListener('change', function() {
                        loadPropertyTypes(this);
                        const label = section.querySelector('.property-number-label');
                        const input = section.querySelector('.property-number-input');
                        if (label) label.textContent = 'Property No.';
                        if (input) input.placeholder = 'Enter property number';
                        markSectionUnsaved(index);
                    });
                }

                if (propertyTypeSelect) {
                    // Update label if property type is already selected
                    if (propertyTypeSelect.value) {
                        updatePropertyNumberLabel(propertyTypeSelect);
                    }

                    propertyTypeSelect.addEventListener('change', function() {
                        updatePropertyNumberLabel(this);
                        markSectionUnsaved(index);
                    });
                }

                section.querySelectorAll('input, select, textarea').forEach(input => {
                    input.addEventListener('change', () => markSectionUnsaved(index));
                    input.addEventListener('input', () => markSectionUnsaved(index));
                });
            }

            document.querySelectorAll('.dynamic-section').forEach((section, index) => {
                if (section.id.startsWith('section-')) {
                    attachEvents(section, index);
                }
            });

            window.addAllotteeSection = function() {
                const container = document.getElementById('allottee-sections');
                const index = container.querySelectorAll('.dynamic-section[id^="section-"]').length;

                const template = `
                <div class="dynamic-section" data-index="${index}" id="section-${index}">
                    <div class="section-header">
                        <div class="section-title">
                            <span class="allottee-counter">${index + 1}</span>
                            Allottee File Details  
                            <span class="status-badge status-unsaved" id="status-${index}">Unsaved</span>
                        </div>
                        <button type="button" class="remove-section" onclick="removeSection(this)">Remove</button>
                    </div>

                    <div class="form-grid">
                        <!-- Hidden allottee ID for updates -->
                        <input type="hidden" class="allottee-id-input" name="allottees[${index}][id]" value="">

                        <div class="field">
                            <label class="label required">Division</label>
                            <select name="allottees[${index}][division_id]" class="division-select" required>
                                <option value="">Select Division</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label class="label required">Sub Division</label>
                            <select name="allottees[${index}][sub_division_id]" class="sub-division-select" required>
                                <option value="">Select Sub Division</option>
                            </select>
                        </div>

                        <div class="field">
                            <label class="label required">Property Category</label>
                            <select name="allottees[${index}][pcategory_id]" class="property-category-select" required>
                                <option value="">Select Category</option>
                                @foreach ($getPropertyCategory as $PropertyCategory)
                                    <option value="{{ $PropertyCategory->id }}">{{ $PropertyCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label class="label required">Property Type</label>
                            <select name="allottees[${index}][p_type_id]" class="property-type-select" required>
                                <option value="">Select Property Type</option>
                            </select>
                        </div>

                        <div class="field quarter-type-field">
                            <label class="label required">Quarter type</label>
                            <select name="allottees[${index}][quarter_type]" class="quarter-type-select" required>
                                <option value="">Select type</option>
                                @foreach ($getQuarterType as $quarterType)
                                    <option value="{{ $quarterType->quarter_id }}">
                                        {{ $quarterType->quarter_code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label class="label required property-number-label">
                                Property No.
                            </label>
                            <input type="text" class="property-number-input" 
                                name="allottees[${index}][property_number]" 
                                placeholder="Enter property number" 
                                required>
                        </div>

                        <div class="field">
                            <label class="label required">Allottee Name</label>
                            <input type="text" name="allottees[${index}][allottee_name]" 
                                placeholder="Enter allottee name" required>
                        </div>

                        
                                <!-- No. of Files -->
                                <div class="field">
                                    <label class="label required">No. of Files</label>
                                    <select name="allottees[${index}][no_of_files]" required>

                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}"
                                                {{ (isset($allottee['no_of_files']) ? $allottee['no_of_files'] == $i : $i == 1) ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor

                                    </select>
                                </div>

                                <!-- No. of Supplement -->
                                <div class="field">
                                    <label class="label">Additional Supplements Files</label>
                                    <select name="allottees[${index}][no_of_supplement]">
                                        <option value="">-- Select No. of Supplement --</option>

                                        @for ($i = 0; $i <= 10; $i++)
                                            <option value="{{ $i }}"
                                                {{ (isset($allottee['no_of_supplement']) ? $allottee['no_of_supplement'] == $i : $i == 0) ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor

                                    </select>
                                </div>

                                                        <div class="field">
                            <label class="label">Remarks</label>
                                <select name="allottees[${index}][remarks]">
                                    <option value="">-- Select Page Condition --</option>
                                    <option value="All Fresh Pages">
                                        All Fresh Pages
                                    </option>
                                    <option value="All Old Pages">
                                        All Old Pages
                                    </option>
                                    <option value="All Poor Quality Pages">
                                        All Poor Quality Pages
                                    </option>
                                    <option value="Partial Fresh and Old Pages">
                                        Partial Fresh and Old Pages
                                    </option>
                                </select>
                        </div>
                    </div>

                    <div class="section-actions">
                        <button type="button" class="save-btn" onclick="saveAllottee(${index})" id="save-btn-${index}">
                            <svg viewBox="0 0 24 24" width="16" height="16">
                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                            <span>Save</span>
                        </button>
                    </div>
                </div>`;

                container.insertAdjacentHTML('beforeend', template);
                const newSection = container.lastElementChild;
                attachEvents(newSection, index);
            };

            window.removeSection = function(btn) {
                const section = btn.closest('.dynamic-section');
                if (!section) return;

                const sectionId = section.id;
                const index = sectionId.split('-')[1];
                const allotteeIdInput = section.querySelector('.allottee-id-input');
                const allotteeId = allotteeIdInput ? allotteeIdInput.value : null;

                if (allotteeId) {
                    if (!confirm(
                            'This allottee has been saved. Are you sure you want to remove it? This will delete the allottee record.'
                        )) {
                        return;
                    }

                    // Show loading
                    btn.disabled = true;
                    btn.innerHTML = 'Deleting...';

                    // Delete from backend first
                    deleteAllottee(allotteeId, index)
                        .then(() => {
                            // Remove section from DOM
                            section.remove();
                            updateCounters();
                            enableSubmitButton();
                            showNotification('File Receiving', 'Allottee deleted successfully!', 'success');
                        })
                        .catch(error => {
                            console.error('Error deleting allottee:', error);
                            showNotification('File Receiving', 'Failed to delete allottee: ' + error
                                .message, 'error');
                            btn.disabled = false;
                            btn.innerHTML = 'Remove';
                        });
                } else {
                    // Just remove unsaved section
                    section.remove();
                    updateCounters();
                    enableSubmitButton();
                }
            };

            function updateCounters() {
                document.querySelectorAll('.dynamic-section[id^="section-"]').forEach((sec, i) => {
                    sec.dataset.index = i;
                    sec.querySelector('.allottee-counter').innerText = i + 1;

                    sec.querySelectorAll('[name]').forEach(el => {
                        el.name = el.name.replace(/allottees\[\d+\]/, `allottees[${i}]`);
                    });

                    sec.id = `section-${i}`;

                    const statusBadge = sec.querySelector('.status-badge');
                    if (statusBadge) statusBadge.id = `status-${i}`;

                    const saveBtn = sec.querySelector('.save-btn');
                    if (saveBtn) {
                        saveBtn.id = `save-btn-${i}`;
                        saveBtn.setAttribute('onclick', `saveAllottee(${i})`);
                    }
                });
            }

            enableSubmitButton();
        });
    </script>
@endpush