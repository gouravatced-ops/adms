@extends('applicant.dashboard_layouts.main')

@section('title', 'Add Files')

@section('content')
    <style>
        /* Your existing styles remain the same */
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

        .input-group {
            display: flex;
            width: 100%;
        }

        .prefix-select {
            width: 55px;
            border: 1px solid #ccc;
            border-right: none;
            padding: 14px 12px;
            border-radius: 6px 0 0 6px;
            background: #f9f9f9;
        }

        .input-group input {
            flex: 1;
            border: 1px solid #ccc;
            padding: 14px 12px;
            border-radius: 0 6px 6px 0;
        }

        .input-group select:focus,
        .input-group input:focus {
            outline: none;
            border-color: #2563eb;
        }

        .floating-counter {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 9999;
        }

        .counter-cube {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 15px;
            border-radius: 6px;
            background: linear-gradient(135deg, #4e73df, #1c8cc8);
            color: #fff;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.18), inset 0 0 10px rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(6px);
            transition: all 0.3s ease;
        }

        .counter-cube:hover {
            transform: translateY(-5px) scale(1.06);
            box-shadow:
                0 18px 35px rgba(0, 0, 0, 0.28),
                inset 0 0 12px rgba(255, 255, 255, 0.3);
        }

        .counter-icon {
            width: 24px;
            height: 24px;
        }

        #sectionCounter {
            font-size: 17px;
            letter-spacing: 1px;
        }

        /* NEW PREVIEW MODE STYLES */
        .mode-toggle {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            gap: 10px;
        }

        .mode-btn {
            padding: 10px 24px;
            border: none;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #e9ecef;
            color: #495057;
        }

        .mode-btn.active {
            background: #007bff;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }

        .mode-btn.preview-mode.active {
            background: #17a2b8;
        }

        /* Preview Card Styles */
        .preview-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .preview-header {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 16px 20px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .preview-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #495057;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .preview-badge {
            background: #6c757d;
            color: white;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
        }

        .preview-content {
            padding: 20px;
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }

        .preview-item {
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }

        .preview-label {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 4px;
            display: block;
        }

        .preview-value {
            font-size: 15px;
            font-weight: 500;
            color: #212529;
            display: block;
            word-break: break-word;
        }

        .preview-value.editable {
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .preview-value.editable:hover {
            background: #e9ecef;
            color: #007bff;
        }

        .preview-value.editable:after {
            content: "✎";
            margin-left: 6px;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .preview-value.editable:hover:after {
            opacity: 0.7;
        }

        .preview-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 18px;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
        }

        .back-to-edit-btn {
            background: #6c757d;
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
            transition: background 0.3s;
        }

        .back-to-edit-btn:hover {
            background: #5a6268;
        }

        .final-submit-btn {
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .final-submit-btn:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(40, 167, 69, 0.4);
        }

        .preview-summary {
            background: #f1f9ff;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            border: 1px solid #b8e2ff;
        }

        .summary-stats {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .stat-item {
            background: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .stat-label {
            font-size: 12px;
            color: #6c757d;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: #007bff;
        }

        /* Preview Mode Styles */
        .preview-mode .dynamic-section {
            background: #fff;
            border: 2px solid #28a745;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.1);
        }

        .preview-mode .save-btn {
            display: none;
        }

        .preview-mode .remove-section {
            display: none;
        }

        .preview-mode .add-section-btn {
            display: none;
        }

        .preview-mode select,
        .preview-mode input {
            background-color: #f8f9fa;
            border-color: #28a745;
        }

        .edit-mode-btn {
            background: #ffc107;
            color: #212529;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }

        .edit-mode-btn:hover {
            background: #e0a800;
        }

        .preview-header {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid #28a745;
        }

        .preview-title {
            font-size: 18px;
            font-weight: 600;
            color: #28a745;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .preview-title svg {
            width: 24px;
            height: 24px;
        }

        .mode-toggle {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .mode-btn {
            padding: 10px 20px;
            border: 1px solid #dee2e6;
            background: #f8f9fa;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s;
        }

        .mode-btn.active {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }

        .mode-btn:first-child {
            border-radius: 6px 0 0 6px;
        }

        .mode-btn:last-child {
            border-radius: 0 6px 6px 0;
        }

        .edit-indicator {
            font-size: 12px;
            color: #ffc107;
            margin-left: 10px;
            font-weight: normal;
        }

        .summary-card {
            background: #fff;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .summary-cards {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .summary-title {
            font-size: 16px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #28a745;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
        }

        .summary-item {
            display: flex;
            flex-direction: column;
        }

        .summary-label {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 14px;
            font-weight: 500;
            color: #212529;
        }

        .summary-value.editable {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
            text-decoration-style: dashed;
        }

        .summary-value.editable:hover {
            color: #0056b3;
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

    @if ($register->total_files > 0)
        <script>
            setTimeout(function() {
                window.location.href = "{{ route('admin.filereceving.index') }}";
            }, 2000);
        </script>
    @endif

    <div class="floating-counter">
        <div class="counter-cube">
            <svg class="counter-icon" viewBox="0 0 24 24" fill="none">
                <path d="M3 7L12 2L21 7V17L12 22L3 17V7Z" stroke="white" stroke-width="2" />
                <path d="M12 22V12" stroke="white" stroke-width="2" />
                <path d="M21 7L12 12L3 7" stroke="white" stroke-width="2" />
            </svg>
            <span id="sectionCounter">0/0</span>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <!-- Form Header -->
        <div class="modern-card-header">
            <div class="header-flex">
                <div>
                    <h1 class="header-title">File Receiving Register (REG ID.: {{ $register->register_no }})</h1>
                    <p class="header-subtitle">Complete each allottee form and save individually. Then preview before final
                        submission.</p>
                </div>
                <div class="header-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>
        @php
            $remainingFiles = max(0, (int) ($register->allowed_files ?? 0) - (int) ($register->total_files ?? 0));
        @endphp

        <!-- EDIT MODE CONTAINER -->
        <div id="editModeContainer">
            <form id="fileTrackingForm" action="{{ route('admin.filereceving.store') }}" method="POST" class="form-body">
                @csrf
                <input type="hidden" id="register_id" name="register_id" value="{{ $register->register_no }}">
                <input type="hidden" id="files_allowed" name="files_allowed" value="{{ $remainingFiles }}">

                <!-- Allottee Sections -->
                <div id="allottee-sections">
                    @if (old('allottees') && count(old('allottees')) > 0)
                        @foreach (old('allottees') as $index => $allottee)
                            <div class="dynamic-section" data-index="{{ $index }}" id="section-{{ $index }}">
                                <!-- ... (keep existing section content) ... -->
                                <div class="section-header">
                                    <div class="section-title">
                                        <span class="allottee-counter">{{ $index + 1 }}</span>
                                        Allottee File Details
                                        <span class="status-badge status-unsaved"
                                            id="status-{{ $index }}">Unsaved</span>
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
                                        </select>
                                        @error('allottees.' . $index . '.p_type_id')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Dynamic Property Number Field -->
                                    <div class="field">
                                        <label class="label required property-number-label">
                                            Property No.
                                        </label>
                                        <input type="text" class="property-number-input"
                                            name="allottees[{{ $index }}][property_number]"
                                            placeholder="Enter property number" value="{{ $allottee['property_number'] }}"
                                            required>
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
                                        <div class="input-group">
                                            @php $prefixes = ['Shri', 'Smt.', 'Miss', 'Dr.', 'Late', 'M/S']; @endphp
                                            <select name="allottees[{{ $index }}][prefix]" class="prefix-select">
                                                @foreach ($prefixes as $prefix)
                                                    <option value="{{ $prefix }}"
                                                        {{ ($allottee['prefix'] ?? '') === $prefix ? 'selected' : '' }}>
                                                        {{ $prefix }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="allottees[{{ $index }}][allottee_name]"
                                                placeholder="Enter allottee name"
                                                value="{{ $allottee['allottee_name'] }}">
                                        </div>
                                    </div>

                                    <!-- No. of Files -->
                                    <div class="field">
                                        <label class="label required">No. of Files</label>
                                        <select name="allottees[{{ $index }}][no_of_files]" required>
                                            @for ($i = 1; $i <= 6; $i++)
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
                                            @for ($i = 0; $i <= 6; $i++)
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
                                                All Fresh Pages</option>
                                            <option value="All Old Pages"
                                                {{ isset($allottee['remarks']) && $allottee['remarks'] == 'All Old Pages' ? 'selected' : '' }}>
                                                All Old Pages</option>
                                            <option value="All Poor Quality Pages"
                                                {{ isset($allottee['remarks']) && $allottee['remarks'] == 'All Poor Quality Pages' ? 'selected' : '' }}>
                                                All Poor Quality Pages</option>
                                            <option value="Partial Fresh and Old Pages"
                                                {{ isset($allottee['remarks']) && $allottee['remarks'] == 'Partial Fresh and Old Pages' ? 'selected' : '' }}>
                                                Partial Fresh and Old Pages</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Individual Save Button -->
                                <div class="section-actions">
                                    <button type="button" class="save-btn" onclick="saveAllottee({{ $index }})"
                                        id="save-btn-{{ $index }}">
                                        <svg viewBox="0 0 24 24" width="16" height="16">
                                            <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2"
                                                fill="none" />
                                        </svg>
                                        Save
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @elseif(isset($existingAllottees) && count($existingAllottees) > 0)
                        @foreach ($existingAllottees as $index => $allottee)
                            <div class="dynamic-section" data-index="{{ $index }}"
                                id="section-{{ $index }}">
                                <!-- ... (keep existing section content) ... -->
                                <div class="section-header">
                                    <div class="section-title">
                                        <span class="allottee-counter">{{ $index + 1 }}</span>
                                        Allottee File Details
                                        <span class="status-badge status-saved"
                                            id="status-{{ $index }}">Saved</span>
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
                                        <select name="allottees[{{ $index }}][division_id]"
                                            class="division-select" required>
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
                                        <select name="allottees[{{ $index }}][p_type_id]"
                                            class="property-type-select" required>
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
                                        <div class="input-group">
                                            @php $prefixes = ['Shri', 'Smt.', 'Miss', 'Dr.', 'Late', 'M/S']; @endphp
                                            <select name="allottees[{{ $index }}][prefix]" class="prefix-select">
                                                @foreach ($prefixes as $prefix)
                                                    <option value="{{ $prefix }}"
                                                        {{ ($allottee->prefix ?? '') === $prefix ? 'selected' : '' }}>
                                                        {{ $prefix }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="allottees[{{ $index }}][allottee_name]"
                                                placeholder="Enter allottee name" value="{{ $allottee->allottee_name }}">
                                        </div>
                                    </div>

                                    <!-- No. of Files -->
                                    <div class="field">
                                        <label class="label required">No. of Files</label>
                                        <select name="allottees[{{ $index }}][no_of_files]" required>
                                            @for ($i = 1; $i <= 6; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $allottee->no_of_files == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <!-- No. of Supplement -->
                                    <div class="field">
                                        <label class="label">Additional Supplements Files</label>
                                        <select name="allottees[{{ $index }}][no_of_supplement]">
                                            @for ($i = 0; $i <= 6; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $allottee->no_of_supplement == $i ? 'selected' : '' }}>
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
                                                {{ $allottee->remarks == 'All Fresh Pages' ? 'selected' : '' }}>All Fresh
                                                Pages</option>
                                            <option value="All Old Pages"
                                                {{ $allottee->remarks == 'All Old Pages' ? 'selected' : '' }}>All Old Pages
                                            </option>
                                            <option value="All Poor Quality Pages"
                                                {{ $allottee->remarks == 'All Poor Quality Pages' ? 'selected' : '' }}>All
                                                Poor Quality Pages</option>
                                            <option value="Partial Fresh and Old Pages"
                                                {{ $allottee->remarks == 'Partial Fresh and Old Pages' ? 'selected' : '' }}>
                                                Partial Fresh and Old Pages</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Individual Save Button -->
                                <div class="section-actions">
                                    <button type="button" class="save-btn" onclick="saveAllottee({{ $index }})"
                                        id="save-btn-{{ $index }}">
                                        <svg viewBox="0 0 24 24" width="16" height="16">
                                            <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2"
                                                fill="none" />
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
                                            <option value="{{ $quarterType->quarter_id }}">
                                                {{ $quarterType->quarter_code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Dynamic Property Number Field -->
                                <div class="field">
                                    <label class="label required property-number-label">
                                        Property No.
                                    </label>
                                    <input type="text" class="property-number-input"
                                        name="allottees[0][property_number]" placeholder="Enter property number" required>
                                </div>

                                <!-- Allottee Name -->
                                <div class="field">
                                    <label class="label required">Allottee Name</label>
                                    <div class="input-group">
                                        @php $prefixes = ['Shri', 'Smt.', 'Miss', 'Dr.', 'Late', 'M/S']; @endphp
                                        <select name="allottees[0][prefix]" class="prefix-select" required>
                                            @foreach ($prefixes as $prefix)
                                                <option value="{{ $prefix }}">{{ $prefix }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="allottees[0][allottee_name]"
                                            placeholder="Enter allottee name" required>
                                    </div>
                                </div>

                                <!-- No. of Files -->
                                <div class="field">
                                    <label class="label required">No. of Files</label>
                                    <select name="allottees[0][no_of_files]" required>
                                        @for ($i = 1; $i <= 6; $i++)
                                            <option value="{{ $i }}" {{ $i == 1 ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- No. of Supplement -->
                                <div class="field">
                                    <label class="label">Additional Supplements Files</label>
                                    <select name="allottees[0][no_of_supplement]">
                                        @for ($i = 0; $i <= 6; $i++)
                                            <option value="{{ $i }}" {{ $i == 0 ? 'selected' : '' }}>
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
                                        <option value="All Fresh Pages">All Fresh Pages</option>
                                        <option value="All Old Pages">All Old Pages</option>
                                        <option value="All Poor Quality Pages">All Poor Quality Pages</option>
                                        <option value="Partial Fresh and Old Pages">Partial Fresh and Old Pages</option>
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

                <!-- Form Footer with Preview Button -->
                <div class="form-footer">
                    <button type="button" class="submit-btn" onclick="switchToPreview()">
                        Preview & Next
                        <svg viewBox="0 0 24 24">
                            <path d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- PREVIEW MODE CONTAINER -->
        <div id="previewModeContainer" style="display: none; padding: 20px;">
            <div class="summary-card">
                <div id="previewContent"></div>
            </div>

            <!-- Form Footer with Preview Button -->
            <div class="preview-actions">
                <button type="button" class="back-to-edit-btn" onclick="switchMode('edit')">
                    <svg viewBox="0 0 24 24" width="16" height="16">
                        <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                    Back to Edit
                </button>
                <button type="button" class="final-submit-btn" onclick="finalSubmit()">
                    Final Submit
                    <svg viewBox="0 0 24 24" width="16" height="16">
                        <path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global variables
            const savedAllottees = {};
            let registerId = document.getElementById('register_id')?.value;
            let allowedLimit = parseInt(document.getElementById('files_allowed')?.value) || 0;
            let hasSavedAnyAllottee = false;

            // Local storage key for tracking registration
            const STORAGE_KEY = 'file_receiving_registration_' + registerId;
            const STORAGE_COUNT_KEY = 'file_receiving_count_' + registerId;

            // Initialize counter on page load
            updateCounter();

            // Check if there are saved allottees from existing data
            initializeSavedAllottees();

            function initializeSavedAllottees() {
                document.querySelectorAll('.dynamic-section').forEach((section, index) => {
                    const allotteeIdInput = section.querySelector('.allottee-id-input');
                    if (allotteeIdInput && allotteeIdInput.value) {
                        savedAllottees[index] = allotteeIdInput.value;
                        hasSavedAnyAllottee = true;

                        // Update button text for existing allottees
                        const saveBtn = document.getElementById(`save-btn-${index}`);
                        if (saveBtn) {
                            const span = saveBtn.querySelector('span');
                            if (span) span.textContent = 'Update';
                            saveBtn.classList.add('updating');
                        }
                    }
                });
            }

            function toggleQuarterType(propertyTypeSelect) {
                const section = propertyTypeSelect.closest('.dynamic-section');
                if (!section) return;

                const quarterField = section.querySelector('.quarter-type-field');
                const quarterSelect = quarterField?.querySelector('select');
                if (!quarterSelect) return;

                const propertyTypeText = propertyTypeSelect.options[propertyTypeSelect.selectedIndex]?.text
                    ?.toLowerCase() || '';
                const isPlot = propertyTypeText.includes('plot');

                Array.from(quarterSelect.options).forEach(option => {
                    const text = option.text.toLowerCase();
                    if (!option.value) return;

                    if (isPlot) {
                        if (text.includes('mig') || text.includes('hig')) {
                            option.hidden = false;
                        } else {
                            option.hidden = true;
                            if (option.selected) option.selected = false;
                        }
                    } else {
                        option.hidden = false;
                    }
                });

                quarterSelect.required = true;
            }

            /**
             * Optimized counter function to show current/total and manage Add More button
             */
            function updateCounter() {
                const container = document.getElementById('allottee-sections');
                const currentCount = container.querySelectorAll('.dynamic-section').length;
                const counterElement = document.getElementById('sectionCounter');

                // Update counter display
                if (counterElement) {
                    counterElement.innerText = currentCount + "/" + allowedLimit;
                }

                // Find the Add More button
                const addMoreBtn = document.querySelector('button[onclick="addAllotteeSection()"]');

                if (addMoreBtn) {
                    if (currentCount >= allowedLimit) {
                        addMoreBtn.disabled = true;
                        addMoreBtn.style.opacity = "0.6";
                        addMoreBtn.style.cursor = "not-allowed";
                        addMoreBtn.title = "Maximum limit of " + allowedLimit + " files reached";
                    } else {
                        addMoreBtn.disabled = false;
                        addMoreBtn.style.opacity = "1";
                        addMoreBtn.style.cursor = "pointer";
                        addMoreBtn.title = "Add another allottee (max " + allowedLimit + ")";
                    }
                }
            }

            // Preview functions
            window.switchMode = function(mode) {
                const editContainer = document.getElementById('editModeContainer');
                const previewContainer = document.getElementById('previewModeContainer');

                if (mode === 'preview') {
                    generatePreview();
                    editContainer.style.display = 'none';
                    previewContainer.style.display = 'block';
                } else {
                    editContainer.style.display = 'block';
                    previewContainer.style.display = 'none';
                }
            };

            window.switchToPreview = function() {
                const hasSavedAllottees = Object.keys(savedAllottees).length > 0;

                if (!hasSavedAllottees) {
                    alert('Please save at least one allottee before previewing.');
                    return;
                }

                switchMode('preview');
            };

            // Generate preview summary with edit functionality
            function generatePreview() {
                const sections = document.querySelectorAll('.dynamic-section');
                let previewHtml = '';
                console.log(sections);
                sections.forEach((section, index) => {
                    const division = section.querySelector('[name*="[division_id]"] option:checked')
                        ?.text || 'Not selected';
                    const subDivision = section.querySelector('[name*="[sub_division_id]"] option:checked')
                        ?.text || 'Not selected';
                    const category = section.querySelector('[name*="[pcategory_id]"] option:checked')
                        ?.text || 'Not selected';
                    const propertyType = section.querySelector('[name*="[p_type_id]"] option:checked')
                        ?.text || 'Not selected';
                    const propertyNumber = section.querySelector('[name*="[property_number]"]')?.value ||
                        'Not entered';
                    const quarterType = section.querySelector('[name*="[quarter_type]"] option:checked')
                        ?.text || 'Not selected';
                    const prefix = section.querySelector('[name*="[prefix]"] option:checked')?.value || '';
                    const allotteeName = section.querySelector('[name*="[allottee_name]"]')?.value ||
                        'Not entered';
                    const noOfFiles = section.querySelector('[name*="[no_of_files]"] option:checked')
                        ?.value || 'Not selected';
                    const noOfSupplement = section.querySelector(
                        '[name*="[no_of_supplement]"] option:checked')?.value || '0';
                    const remarks = section.querySelector('[name*="[remarks]"] option:checked')?.text ||
                        'Not selected';

                    previewHtml += `
                    <div class="summary-cards" style="margin-bottom: 20px;">
                        <div class="summary-title" style="display: flex; justify-content: space-between; align-items: center;">
                            <span>Allottee #${index + 1}</span>
                            <span class="status-badge ${savedAllottees[index] ? 'status-saved' : 'status-unsaved'}" style="font-size: 11px;">
                                ${savedAllottees[index] ? 'Saved' : 'Unsaved'}
                            </span>
                        </div>
                        <div class="summary-grid">
                            <div class="summary-item">
                                <span class="summary-label">Division</span>
                                <span class="summary-value editable" onclick="editField(${index}, 'division')">${division}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Sub Division</span>
                                <span class="summary-value editable" onclick="editField(${index}, 'sub_division')">${subDivision}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Property Category</span>
                                <span class="summary-value editable" onclick="editField(${index}, 'category')">${category}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Property Type</span>
                                <span class="summary-value editable" onclick="editField(${index}, 'property_type')">${propertyType}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Property No.</span>
                                <span class="summary-value editable" onclick="editField(${index}, 'property_number')">${propertyNumber}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Quarter Type</span>
                                <span class="summary-value editable" onclick="editField(${index}, 'quarter_type')">${quarterType}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Allottee Name</span>
                                <span class="summary-value editable" onclick="editField(${index}, 'allottee_name')">${prefix} ${allotteeName}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">No. of Files</span>
                                <span class="summary-value editable" onclick="editField(${index}, 'no_of_files')">${noOfFiles}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Supplements</span>
                                <span class="summary-value editable" onclick="editField(${index}, 'no_of_supplement')">${noOfSupplement}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Remarks</span>
                                <span class="summary-value editable" onclick="editField(${index}, 'remarks')">${remarks}</span>
                            </div>
                        </div>
                    </div>
                `;
                });

                document.getElementById('previewContent').innerHTML = previewHtml;
            }

            // Edit field from preview mode
            window.editField = function(index, field) {
                switchMode('edit');

                // Scroll to the section
                const section = document.getElementById(`section-${index}`);
                if (section) {
                    section.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    // Highlight the field
                    let fieldElement;
                    switch (field) {
                        case 'division':
                            fieldElement = section.querySelector('[name*="[division_id]"]');
                            break;
                        case 'sub_division':
                            fieldElement = section.querySelector('[name*="[sub_division_id]"]');
                            break;
                        case 'category':
                            fieldElement = section.querySelector('[name*="[pcategory_id]"]');
                            break;
                        case 'property_type':
                            fieldElement = section.querySelector('[name*="[p_type_id]"]');
                            break;
                        case 'property_number':
                            fieldElement = section.querySelector('[name*="[property_number]"]');
                            break;
                        case 'quarter_type':
                            fieldElement = section.querySelector('[name*="[quarter_type]"]');
                            break;
                        case 'allottee_name':
                            fieldElement = section.querySelector('[name*="[allottee_name]"]');
                            break;
                        case 'no_of_files':
                            fieldElement = section.querySelector('[name*="[no_of_files]"]');
                            break;
                        case 'no_of_supplement':
                            fieldElement = section.querySelector('[name*="[no_of_supplement]"]');
                            break;
                        case 'remarks':
                            fieldElement = section.querySelector('[name*="[remarks]"]');
                            break;
                    }
                    console.log(fieldElement);
                    if (fieldElement) {
                        fieldElement.focus();
                        fieldElement.style.borderColor = '#ffc107';
                        fieldElement.style.boxShadow = '0 0 0 2px rgba(255,193,7,0.25)';

                        setTimeout(() => {
                            fieldElement.style.borderColor = '';
                            fieldElement.style.boxShadow = '';
                        }, 2000);
                    }
                }
            };

            // Final submit
            window.finalSubmit = function() {
                const hasSavedAllottees = Object.keys(savedAllottees).length > 0;

                if (!hasSavedAllottees) {
                    alert('Please save at least one allottee before submitting the form.');
                    switchMode('edit');
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

                isLeavingPage = true;

                const form = document.getElementById('fileTrackingForm');
                const formData = new FormData(form);
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                fetch(form.action, {
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
                            localStorage.removeItem(STORAGE_KEY);
                            localStorage.removeItem(STORAGE_COUNT_KEY);
                            localStorage.removeItem(STORAGE_KEY + '_warning');

                            showNotification('File Receiving', 'File registered successfully!', 'success');

                            setTimeout(() => {
                                if (data.redirect_url) {
                                    window.location.href = data.redirect_url;
                                } else {
                                    window.location.href = '/dashboard';
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
            };

            // Save allottee function
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

                // Validate required fields
                let inputs = section.querySelectorAll('input[required], select[required]');
                let isValid = true;
                let firstInvalidInput = null;

                inputs.forEach(input => {
                    // Skip quarter type if hidden
                    if (input.closest('.quarter-type-field')?.classList.contains('hidden-field')) {
                        return;
                    }

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

                // Add form fields
                section.querySelectorAll('input, select').forEach(el => {
                    if (el.name && el.name.includes('allottees')) {
                        const match = el.name.match(/allottees\[(\d+)\]\[(\w+)\]/);
                        if (match) {
                            const fieldName = match[2];
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
                    '/filereceving/individual/store';

                // Send request
                fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            showNotification(
                                'File Receiving',
                                data.message || 'Operation failed.',
                                'error'
                            );
                            return;
                        }

                        // Success flow
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

                        if (saveBtn) {
                            const span = saveBtn.querySelector('span');
                            if (span) span.textContent = 'Update';
                            saveBtn.classList.add('updating');
                        }

                        showNotification(
                            'File Receiving',
                            isUpdate ? 'Allottee updated successfully!' :
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

            // Add allottee section
            window.addAllotteeSection = function() {
                const container = document.getElementById('allottee-sections');
                const currentCount = container.querySelectorAll('.dynamic-section[id^="section-"]').length;

                if (currentCount >= allowedLimit) {
                    showNotification('File Receiving', 'Maximum limit of ' + allowedLimit + ' files reached',
                        'warning');
                    return;
                }

                const index = currentCount;

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
                                        <option value="{{ $quarterType->quarter_id }}">{{ $quarterType->quarter_code }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="field">
                                <label class="label required property-number-label">
                                    Property No.
                                </label>
                                <input type="text" class="property-number-input" name="allottees[${index}][property_number]" placeholder="Enter property number" required>
                            </div>

                            <div class="field">
                                <label class="label required">Allottee Name</label>
                                <div class="input-group">
                                    @php $prefixes = ['Shri', 'Smt.', 'Miss', 'Dr.', 'Late', 'M/S']; @endphp
                                    <select name="allottees[${index}][prefix]" class="prefix-select" required>
                                        @foreach ($prefixes as $prefix)
                                            <option value="{{ $prefix }}">{{ $prefix }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="allottees[${index}][allottee_name]" placeholder="Enter allottee name" required>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label required">No. of Files</label>
                                <select name="allottees[${index}][no_of_files]" required>
                                    @for ($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ $i == 1 ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="field">
                                <label class="label">Additional Supplements Files</label>
                                <select name="allottees[${index}][no_of_supplement]">
                                    @for ($i = 0; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ $i == 0 ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="field">
                                <label class="label">Remarks</label>
                                <select name="allottees[${index}][remarks]">
                                    <option value="">-- Select Page Condition --</option>
                                    <option value="All Fresh Pages">All Fresh Pages</option>
                                    <option value="All Old Pages">All Old Pages</option>
                                    <option value="All Poor Quality Pages">All Poor Quality Pages</option>
                                    <option value="Partial Fresh and Old Pages">Partial Fresh and Old Pages</option>
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
                    </div>
                `;

                container.insertAdjacentHTML('beforeend', template);
                const newSection = container.lastElementChild;
                attachEvents(newSection, index);
                updateCounter();
            };

            // Remove section
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

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                    // Delete from backend first
                    fetch('/filereceving/delete-allottee', {
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
                                delete savedAllottees[index];
                                hasSavedAnyAllottee = Object.keys(savedAllottees).length > 0;
                                section.remove();
                                updateCounters();
                                updateCounter();
                                showNotification('File Receiving', 'Allottee deleted successfully!',
                                    'success');
                            } else {
                                throw new Error(data.message || 'Failed to delete allottee');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting allottee:', error);
                            showNotification('File Receiving', 'Failed to delete allottee: ' + error
                                .message, 'error');
                            btn.disabled = false;
                            btn.innerHTML = 'Remove';
                        });
                } else {
                    section.remove();
                    updateCounters();
                    updateCounter();
                }
            };

            // Helper functions
            function showNotification(title, message, type) {
                showToast('File Receiving', message, type);
            }

            function updateCounters() {
                document.querySelectorAll('.dynamic-section[id^="section-"]').forEach((sec, i) => {
                    sec.dataset.index = i;
                    const counterSpan = sec.querySelector('.allottee-counter');
                    if (counterSpan) {
                        counterSpan.innerText = i + 1;
                    }

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

                updateCounter();
            }

            function attachEvents(section, index) {
                const divisionSelect = section.querySelector('.division-select');
                const categorySelect = section.querySelector('.property-category-select');
                const propertyTypeSelect = section.querySelector('.property-type-select');

                if (divisionSelect) {
                    if (divisionSelect.value) {
                        loadSubDivisions(divisionSelect);
                    }
                    divisionSelect.addEventListener('change', function() {
                        loadSubDivisions(this);
                        markSectionUnsaved(index);
                    });
                }

                if (categorySelect) {
                    if (categorySelect.value) {
                        loadPropertyTypes(categorySelect);
                    }
                    categorySelect.addEventListener('change', function() {
                        loadPropertyTypes(this);
                        markSectionUnsaved(index);
                    });
                }

                if (propertyTypeSelect) {
                    if (propertyTypeSelect.value) {
                        updatePropertyNumberLabel(propertyTypeSelect);
                        toggleQuarterType(propertyTypeSelect);
                    }
                    propertyTypeSelect.addEventListener('change', function() {
                        updatePropertyNumberLabel(this);
                        toggleQuarterType(this);
                        markSectionUnsaved(index);
                    });
                }

                section.querySelectorAll('input, select, textarea').forEach(input => {
                    input.addEventListener('change', () => markSectionUnsaved(index));
                    input.addEventListener('input', () => markSectionUnsaved(index));
                });
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
            }

            function markSectionUnsaved(index) {
                if (index !== null && savedAllottees[index]) {
                    const statusBadge = document.getElementById(`status-${index}`);
                    if (statusBadge) {
                        statusBadge.textContent = 'Unsaved';
                        statusBadge.className = 'status-badge status-unsaved';
                    }

                    const saveBtn = document.getElementById(`save-btn-${index}`);
                    if (saveBtn) {
                        const span = saveBtn.querySelector('span');
                        if (span) span.textContent = 'Save';
                        saveBtn.classList.remove('updating');
                    }
                }
            }

            // Initialize all sections
            document.querySelectorAll('.dynamic-section').forEach((section, index) => {
                if (section.id.startsWith('section-')) {
                    attachEvents(section, index);
                }
            });

            // Set up form submission
            document.getElementById('fileTrackingForm').addEventListener('submit', function(e) {
                e.preventDefault();
                // This is now handled by the preview button
                switchToPreview();
            });
        });
    </script>
@endpush