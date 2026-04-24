@extends('applicant.dashboard_layouts.main')
@section('title', 'Register New File - File Receiving Register')
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

    .add-more-supplement-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 8px;
        padding: 6px 12px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .add-more-supplement-btn:hover {
        background-color: #218838;
    }

    .add-more-supplement-btn svg {
        margin-right: 4px;
    }

    /* Supplement field visibility */
    .supplement-field-wrapper {
        transition: all 0.3s ease;
    }

    .supplement-field-wrapper.hidden-supplement {
        display: none;
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

@php
$total = (int) ($register->total_files ?? 0);
$allowed = (int) ($register->allowed_files ?? 0);
@endphp

@if ($total == $allowed)
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
                        <div class="field">
                            <label class="label required">Search by Property No.</label>

                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="text" class="property-search-input"
                                    name="allottees[{{ $index }}][property_search]"
                                    placeholder="Enter property number to search"
                                    style="flex: 1; padding: 6px;">

                                <button type="button" class="property-search-btn"
                                    style="padding: 6px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-grid">
                        <!-- Confirm Recived -->
                        <div class="field">
                            <label class="label required">Is Allottee file already received?</label>
                            <select name="allottees[{{ $index }}][confirm_received]"
                                class="confirm-select @error('allottees.' . $index . '.confirm_received') border-red-500 @enderror"
                                required>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            @error('allottees.' . $index . '.confirm_received')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Hidden input select show when confirm_received is "Yes" select open show is this same allotte name select yes / no -->

                        <!-- Confirm Allottee Name -->
                        <div class="field" style="display: none;">
                            <label class="label required">Is this same allotte name ?</label>
                            <select name="allottees[{{ $index }}][confirm_same_allottee_name]"
                                class="confirm-name-select @error('allottees.' . $index . '.confirm_same_allottee_name') border-red-500 @enderror"
                                required>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            @error('allottees.' . $index . '.confirm_same_allottee_name')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

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
                                placeholder="Enter property number"
                                value="{{ $allottee['property_number'] }}" disabled required>
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
                            <label class="label required">Allottee First Name</label>
                            <div class="input-group">
                                @php $prefixes = ['Shri', 'Smt.', 'Miss', 'Dr.', 'Md.', 'Late', 'M/S' , 'Maj.' , 'Capt.']; @endphp
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

                        <!-- Allottee Middle name -->
                        <div class="field">
                            <label class="label">Allottee Middle Name</label>
                            <input type="text" name="allottees[{{ $index }}][allottee_middle_name]"
                                placeholder="Enter allottee middle name"
                                value="{{ $allottee['allottee_middle_name'] }}">
                        </div>

                        <!-- Allottee Surname -->
                        <div class="field">
                            <label class="label required">Allottee Surname</label>
                            <input type="text" name="allottees[{{ $index }}][allottee_surname]"
                                placeholder="Enter allottee surname"
                                value="{{ $allottee['allottee_surname'] }}">
                        </div>

                        <!-- No. of Files -->
                        <div class="field">
                            <label class="label required">No. of Files</label>
                            <select name="allottees[{{ $index }}][no_of_files]" required>
                                @for ($i = 1; $i <= 1; $i++)
                                    <option value="{{ $i }}"
                                    {{ (isset($allottee['no_of_files']) ? $allottee['no_of_files'] == $i : $i == 1) ? 'selected' : '' }}>
                                    {{ $i }}
                                    </option>
                                    @endfor
                            </select>
                        </div>

                        <!-- Add Supplement Files? (Yes/No Select) -->
                        <div class="field">
                            <label class="label">Add Supplement Files?</label>
                            <select name="allottees[{{ $index }}][has_supplement]" class="has-supplement-select">
                                <option value="No" {{ (isset($allottee['has_supplement']) && $allottee['has_supplement'] == 'No') || (!isset($allottee['has_supplement']) && ($allottee['no_of_supplement'] ?? 0) == 0) ? 'selected' : '' }}>No</option>
                                <option value="Yes" {{ (isset($allottee['has_supplement']) && $allottee['has_supplement'] == 'Yes') || (($allottee['no_of_supplement'] ?? 0) > 0) ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>

                        <!-- No. of Supplement (Hidden by default) -->
                        <div class="field supplement-field-wrapper {{ (!isset($allottee['has_supplement']) && ($allottee['no_of_supplement'] ?? 0) == 0) || (isset($allottee['has_supplement']) && $allottee['has_supplement'] == 'No') ? 'hidden-supplement' : '' }}">
                            <label class="label">Additional Supplements Files</label>
                            <select name="allottees[{{ $index }}][no_of_supplement]" class="supplement-select">
                                @for ($i = 0; $i <= 9; $i++)
                                    <option value="{{ $i }}" {{ (isset($allottee['no_of_supplement']) && $allottee['no_of_supplement'] == $i) || (isset($allottee->no_of_supplement) && $allottee->no_of_supplement == $i) ? 'selected' : '' }}>{{ $i }}</option>
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

                        <!-- Confirm Recived -->
                        <div class="field">
                            <label class="label required">Is Allottee file already received?</label>
                            <select name="allottees[{{ $index }}][confirm_received]"
                                class="confirm-select @error('allottees.' . $index . '.confirm_received') border-red-500 @enderror"
                                required>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            @error('allottees.' . $index . '.confirm_received')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Hidden input select show when confirm_received is "Yes" select open show is this same allotte name select yes / no -->

                        <!-- Confirm Allottee Name -->
                        <div class="field" style="display: none;">
                            <label class="label required">Is this same allotte name ?</label>
                            <select name="allottees[{{ $index }}][confirm_same_allottee_name]"
                                class="confirm-name-select @error('allottees.' . $index . '.confirm_same_allottee_name') border-red-500 @enderror"
                                required>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            @error('allottees.' . $index . '.confirm_same_allottee_name')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

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
                            <label class="label required">Allottee First Name</label>
                            <div class="input-group">
                                @php $prefixes = ['Shri', 'Smt.', 'Miss', 'Dr.', 'Md.', 'Late', 'M/S' , 'Maj.' , 'Capt.']; @endphp
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

                        <!-- Allottee Middle name -->
                        <div class="field">
                            <label class="label">Allottee Middle Name</label>
                            <input type="text" name="allottees[{{ $index }}][allottee_middle_name]"
                                placeholder="Enter allottee middle name"
                                value="{{ $allottee['allottee_middle_name'] }}">
                        </div>

                        <!-- Allottee Surname -->
                        <div class="field">
                            <label class="label required">Allottee Surname</label>
                            <input type="text" name="allottees[{{ $index }}][allottee_surname]"
                                placeholder="Enter allottee surname"
                                value="{{ $allottee['allottee_surname'] }}">
                        </div>

                        <!-- No. of Files -->
                        <div class="field">
                            <label class="label required">No. of Files</label>
                            <select name="allottees[{{ $index }}][no_of_files]" required>
                                @for ($i = 1; $i <= 1; $i++)
                                    <option value="{{ $i }}"
                                    {{ $allottee->no_of_files == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                    </option>
                                    @endfor
                            </select>
                        </div>

                        <!-- Add Supplement Files? (Yes/No Select) -->
                        <div class="field">
                            <label class="label">Add Supplement Files?</label>
                            <select name="allottees[{{ $index }}][has_supplement]" class="has-supplement-select">
                                <option value="No" {{ (isset($allottee['has_supplement']) && $allottee['has_supplement'] == 'No') || (!isset($allottee['has_supplement']) && ($allottee['no_of_supplement'] ?? 0) == 0) ? 'selected' : '' }}>No</option>
                                <option value="Yes" {{ (isset($allottee['has_supplement']) && $allottee['has_supplement'] == 'Yes') || (($allottee['no_of_supplement'] ?? 0) > 0) ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>

                        <!-- No. of Supplement (Hidden by default) -->
                        <div class="field supplement-field-wrapper {{ (!isset($allottee['has_supplement']) && ($allottee['no_of_supplement'] ?? 0) == 0) || (isset($allottee['has_supplement']) && $allottee['has_supplement'] == 'No') ? 'hidden-supplement' : '' }}">
                            <label class="label">Additional Supplements Files</label>
                            <select name="allottees[{{ $index }}][no_of_supplement]" class="supplement-select">
                                @for ($i =1; $i <= 9; $i++)
                                    <option value="{{ $i }}" {{ (isset($allottee['no_of_supplement']) && $allottee['no_of_supplement'] == $i) || (isset($allottee->no_of_supplement) && $allottee->no_of_supplement == $i) ? 'selected' : '' }}>{{ $i }}</option>
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
                                    {{ $allottee->remarks == 'All Old Pages' ? 'selected' : '' }}>All Old
                                    Pages
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

                        <div class="field">
                            <label class="label required">Search by Property No.</label>

                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="text" class="property-search-input"
                                    name="allottees[0][property_search]"
                                    placeholder="Enter property number to search"
                                    style="flex: 1; padding: 6px;">

                                <button type="button" class="property-search-btn"
                                    style="padding: 6px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                    Search
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Recived -->
                        <div class="field">
                            <label class="label required">Is Allottee file already received?</label>
                            <select name="allottees[0][confirm_received]" class="confirm-select" required>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>

                        <!-- Hidden input select show when confirm_received is "Yes" select open show is this same allotte name select yes / no -->

                        <!-- Confirm Allottee Name -->
                        <div class="field" style="display: none;">
                            <label class="label required">Is this same allotte name ?</label>
                            <select name="allottees[0][confirm_same_allottee_name]" class="confirm-name-select"
                                required>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>

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
                                name="allottees[0][property_number]" placeholder="Enter property number" disabled required>
                        </div>

                        <!-- Allottee Name -->
                        <div class="field">
                            <label class="label required">Allottee First Name</label>
                            <div class="input-group">
                                @php $prefixes = ['Shri', 'Smt.', 'Miss', 'Dr.', 'Md.', 'Late', 'M/S' , 'Maj.' , 'Capt.']; @endphp
                                <select name="allottees[0][prefix]" class="prefix-select">
                                    @foreach ($prefixes as $prefix)
                                    <option value="{{ $prefix }}"
                                        {{ ($allottee['prefix'] ?? '') === $prefix ? 'selected' : '' }}>
                                        {{ $prefix }}
                                    </option>
                                    @endforeach
                                </select>
                                <input type="text" name="allottees[0][allottee_name]"
                                    placeholder="Enter allottee name" value="">
                            </div>
                        </div>

                        <!-- Allottee Middle name -->
                        <div class="field">
                            <label class="label">Allottee Middle Name</label>
                            <input type="text" name="allottees[0][allottee_middle_name]"
                                placeholder="Enter allottee middle name" value="">
                        </div>

                        <!-- Allottee Surname -->
                        <div class="field">
                            <label class="label required">Allottee Surname</label>
                            <input type="text" name="allottees[0][allottee_surname]"
                                placeholder="Enter allottee surname" value="">
                        </div>

                        <!-- No. of Files -->
                        <div class="field">
                            <label class="label required">No. of Files</label>
                            <select name="allottees[0][no_of_files]" required>
                                @for ($i = 1; $i <= 1; $i++)
                                    <option value="{{ $i }}" {{ $i == 1 ? 'selected' : '' }}>
                                    {{ $i }}
                                    </option>
                                    @endfor
                            </select>
                        </div>

                        <!-- Add Supplement Files? (Yes/No Select) -->
                        <div class="field">
                            <label class="label">Add Supplement Files?</label>
                            <select name="allottees[0][has_supplement]" class="has-supplement-select">
                                <option value="No" selected>No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>

                        <!-- No. of Supplement (Hidden by default) -->
                        <div class="field supplement-field-wrapper hidden-supplement">
                            <label class="label">Additional Supplements Files</label>
                            <select name="allottees[0][no_of_supplement]" class="supplement-select">
                                @for ($i =1; $i <= 9; $i++)
                                    <option value="{{ $i }}" {{ $i == 0 ? 'selected' : '' }}>{{ $i }}</option>
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
    // ==================== SUPPLEMENT MANAGER PER SECTION ====================
    class SupplementManager {
        constructor(section, index) {
            this.section = section;
            this.index = index;
            this.hasSupplementSelect = null;
            this.supplementWrapper = null;
            this.supplementSelect = null;
            this.addMoreBtn = null;
            this.supplementValue = 0;
            this.init();
        }

        init() {
            this.hasSupplementSelect = this.section.querySelector('.has-supplement-select');
            this.supplementWrapper = this.section.querySelector('.supplement-field-wrapper');
            this.supplementSelect = this.section.querySelector('.supplement-select');

            if (this.hasSupplementSelect) {
                this.setupToggleEvent();
            }
        }

        setupToggleEvent() {
            // Remove existing listeners by cloning
            const newSelect = this.hasSupplementSelect.cloneNode(true);
            this.hasSupplementSelect.parentNode.replaceChild(newSelect, this.hasSupplementSelect);
            this.hasSupplementSelect = newSelect;

            // Set initial visibility
            this.updateSupplementVisibility();

            // Add change event for this specific section
            this.hasSupplementSelect.addEventListener('change', (e) => {
                e.stopPropagation();
                this.toggleSupplementField();
                this.markSectionUnsaved();
            });
        }

        toggleSupplementField() {
            if (this.hasSupplementSelect.value === 'Yes') {
                this.supplementWrapper.classList.remove('hidden-supplement');
            } else {
                this.supplementWrapper.classList.add('hidden-supplement');
                if (this.supplementSelect) {
                    this.supplementSelect.value = '0';
                }
                this.removeAddMoreButton();
            }
        }

        updateSupplementVisibility() {
            if (this.hasSupplementSelect.value === 'Yes') {
                this.supplementWrapper.classList.remove('hidden-supplement');
            } else {
                this.supplementWrapper.classList.add('hidden-supplement');
            }
        }

        applyApiData(supplementValue) {
            this.supplementValue = supplementValue;
            console.log("Applying API data for section", this.index, "with supplement value:", supplementValue);

            // Update Yes/No select
            if (this.hasSupplementSelect) {
                this.hasSupplementSelect.value = supplementValue > 0 ? 'Yes' : 'No';
                this.updateSupplementVisibility();
            }

            if (!this.supplementSelect) return;

            console.log("Applying supplement value for section", this.index, "Value:", supplementValue);

            // Clear and populate supplement options based on API value
            this.supplementSelect.innerHTML = '';
            for (let i = 1; i <= 9; i++) {
                let option = document.createElement('option');
                option.className = 'supplement-option-default-from-api';
                option.value = i;
                option.textContent = i;
                if (i == supplementValue) option.selected = true;
                this.supplementSelect.appendChild(option);
            }

            // Disable select if supplementValue > 0
            this.supplementSelect.disabled = supplementValue > 0;

            // Remove existing button
            this.removeAddMoreButton();

            // Create Add More button if conditions met (1-8)
            if (supplementValue > 0 && supplementValue < 9) {
                this.createAddMoreButton();
            }
        }

        createAddMoreButton() {
            this.removeAddMoreButton();

            this.addMoreBtn = document.createElement('button');
            this.addMoreBtn.type = 'button';
            this.addMoreBtn.className = 'add-more-supplement-btn';
            this.addMoreBtn.setAttribute('data-section-index', this.index);
            this.addMoreBtn.innerHTML = `
            <svg viewBox="0 0 24 24" width="14" height="14">
                <path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="2" fill="none"/>
            </svg>
            Add More Supplement
        `;

            // Apply styles
            Object.assign(this.addMoreBtn.style, {
                marginTop: '8px',
                padding: '6px 12px',
                fontSize: '12px',
                backgroundColor: '#28a745',
                color: 'white',
                border: 'none',
                borderRadius: '4px',
                cursor: 'pointer',
                display: 'inline-flex',
                alignItems: 'center',
                gap: '5px'
            });

            // Insert after supplement select
            this.supplementSelect.parentNode.appendChild(this.addMoreBtn);

            // Bind click event for this specific section
            this.addMoreBtn.onclick = (e) => {
                e.stopPropagation();
                this.enableFullSupplementOptions();
            };
        }

        enableFullSupplementOptions() {
            if (!this.supplementSelect) return;

            // Store current selected value
            let currentSelected = parseInt(this.supplementSelect.value);
            console.log("Current selected supplement value before enabling full options:", currentSelected);

            let loopcount = 9 - currentSelected;
            console.log("Enabling full supplement options up to 9. Current:", currentSelected, "Loop count:", loopcount);

            // Clear and add all options 0-8
            this.supplementSelect.innerHTML = '';
            for (let i = 1; i <= loopcount; i++) {
                let option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                console.log("Adding supplement option:", i);
                this.supplementSelect.appendChild(option);
            }

            // Restore selection
            if (currentSelected >= 1 && currentSelected <= loopcount) {
                this.supplementSelect.value = currentSelected;
            } else {
                this.supplementSelect.value = this.supplementValue;
            }

            // Enable dropdown
            this.supplementSelect.disabled = false;

            // Hide button
            if (this.addMoreBtn) {
                this.addMoreBtn.style.display = 'none';
            }

            // Mark section as unsaved
            this.markSectionUnsaved();
        }

        removeAddMoreButton() {
            if (this.addMoreBtn && this.addMoreBtn.parentNode) {
                this.addMoreBtn.remove();
            }
            this.addMoreBtn = null;
        }

        markSectionUnsaved() {
            if (window.markSectionUnsaved) {
                window.markSectionUnsaved(parseInt(this.index));
            }
        }

        resetToOriginalState() {
            if (this.supplementSelect) {
                this.supplementSelect.innerHTML = '';
                for (let i = 0; i <= 10; i++) {
                    let option = document.createElement('option');
                    option.value = i;
                    option.textContent = i;
                    this.supplementSelect.appendChild(option);
                }
                this.supplementSelect.value = '0';
                this.supplementSelect.disabled = false;
            }

            if (this.hasSupplementSelect) {
                this.hasSupplementSelect.value = 'No';
                this.supplementWrapper.classList.add('hidden-supplement');
            }

            this.removeAddMoreButton();
        }

        destroy() {
            this.removeAddMoreButton();
        }
    }

    // ==================== MAIN APPLICATION ====================
    class FileReceivingApp {
        constructor() {
            this.savedAllottees = {};
            this.supplementManagers = new Map(); // Store manager per section index
            this.registerId = null;
            this.allowedLimit = 0;
            this.init();
        }

        init() {
            document.addEventListener("DOMContentLoaded", () => {
                this.registerId = document.getElementById('register_id')?.value;
                this.allowedLimit = parseInt(document.getElementById('files_allowed')?.value) || 0;

                this.initializeEventListeners();
                this.initializeSavedAllottees();
                this.initializeAllSections();
                this.updateCounter();

                // Make functions globally accessible
                window.savedAllottees = this.savedAllottees;
                window.markSectionUnsaved = (index) => this.markSectionUnsaved(index);
                window.addAllotteeSection = () => this.addAllotteeSection();
                window.removeSection = (btn) => this.removeSection(btn);
                window.saveAllottee = (index) => this.saveAllottee(index);
                window.switchMode = (mode) => this.switchMode(mode);
                window.switchToPreview = () => this.switchToPreview();
                window.editField = (index, field) => this.editField(index, field);
                window.finalSubmit = () => this.finalSubmit();
            });
        }

        initializeEventListeners() {
            // Handle Confirm Received changes (global but section-specific)
            document.addEventListener("change", (e) => {
                if (e.target.classList.contains("confirm-select")) {
                    this.handleConfirmReceivedChange(e.target);
                }
                if (e.target.classList.contains("confirm-name-select")) {
                    this.handleConfirmNameChange(e.target);
                }
            });

            // Handle property number auto-fetch (OLD API - KEPT INTACT)
            document.addEventListener("blur", (e) => {
                if (e.target.classList.contains("property-number-input")) {
                    this.handlePropertyNumberBlur(e.target);
                }
            }, true);

            // NEW: Handle property search button click (NEW API)
            document.addEventListener("click", (e) => {
                if (e.target.classList.contains("property-search-btn")) {
                    this.handlePropertySearch(e.target);
                }
            });
        }

        handleConfirmReceivedChange(select) {
            const currentField = select.closest(".field");
            const nextField = currentField?.nextElementSibling;
            const row = currentField?.parentElement;

            if (nextField && nextField.querySelector(".confirm-name-select")) {
                nextField.style.display = select.value === "Yes" ? "block" : "none";
                if (select.value !== "Yes") {
                    nextField.querySelector(".confirm-name-select").value = "No";
                }
            }
            this.updateAutoClass(row);
        }

        handleConfirmNameChange(select) {
            const row = select.closest(".field")?.parentElement;
            this.updateAutoClass(row);
        }

        updateAutoClass(row) {
            const confirmSelect = row.querySelector(".confirm-select");
            const confirmNameSelect = row.querySelector(".confirm-name-select");
            const propertyInput = row.querySelector(".property-number-input");

            if (!confirmSelect || !confirmNameSelect || !propertyInput) return;

            if (confirmSelect.value === "Yes" && confirmNameSelect.value === "Yes") {
                propertyInput.classList.add("auto-check-enabled");
            } else {
                propertyInput.classList.remove("auto-check-enabled");
            }
        }

        // ==================== NEW API: Search by Property Number ====================
        async handlePropertySearch(button) {
            const section = button.closest('.dynamic-section');
            const sectionIndex = section?.getAttribute('data-index');
            if (sectionIndex === undefined || sectionIndex === null) return;

            const formGrid = button.closest('.form-grid') || section.querySelector('.form-grid');
            const searchInput = formGrid.querySelector('.property-search-input');
            const propertyNumber = searchInput?.value.trim();

            if (!propertyNumber) {
                this.showNotification('Search Required', 'Please enter a property number to search.', 'warning');
                return;
            }

            const originalBtnText = button.innerHTML;
            button.innerHTML = 'Searching...';
            button.disabled = true;

            try {
                const response = await fetch('/filereceving/check-property-number-for-receiving', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({
                        property_number: propertyNumber
                    })
                });

                const data = await response.json();

                if (!data.status) {
                    this.showNotification('Search Failed', data.message || 'Property not found.', 'error');
                    this.setPropertyNumberFieldState(section, false, 'disabled');
                    return;
                } else {
                    this.setPropertyNumberFieldState(section, true, 'enabled');
                }

                // Set "Is Allottee file already received?" to Yes if exists is true
                const confirmSelect = formGrid.querySelector('.confirm-select');
                if (confirmSelect && data.exists) {
                    confirmSelect.value = "Yes";
                    // Trigger change event to show/hide the confirm name field
                    this.handleConfirmReceivedChange(confirmSelect);
                } else {
                    if (confirmSelect) {
                        confirmSelect.value = "No";
                        this.handleConfirmReceivedChange(confirmSelect);
                    }
                }

                // Display search results table
                this.displaySearchResultsTable(section, data);

                if (data.exists) {
                    this.showNotification('Search Successful', `Property found. ${data.total_rows} record(s) exist. "Already Received" set to Yes.`, 'success');
                } else {
                    this.showNotification('Search Successful', 'Property found. No existing records.', 'success');
                }

            } catch (error) {
                console.error("Error:", error);
                this.showNotification('Search Failed', 'Network error. Please try again.', 'error');
                this.setPropertyNumberFieldState(section, false, 'disabled');
            } finally {
                button.innerHTML = originalBtnText;
                button.disabled = false;
            }
        }

        // NEW: Display search results in a table format
        displaySearchResultsTable(section, data) {
            // Remove existing table if any
            const existingTable = section.querySelector('.search-results-table');
            if (existingTable) {
                existingTable.remove();
            }

            if (!data.data || data.data.length === 0) {
                const noRecordsMsg = section.querySelector('.no-records-message');
                if (!noRecordsMsg) {
                    const msgDiv = document.createElement('div');
                    msgDiv.className = 'no-records-message';
                    msgDiv.style.cssText = 'background: #fff3cd; padding: 10px; margin: 10px 0; border-radius: 4px; color: #856404;';
                    msgDiv.innerHTML = '! No existing records found for this property number.';
                    const formGrid = section.querySelector('.form-grid');
                    formGrid?.appendChild(msgDiv);
                    setTimeout(() => msgDiv.remove(), 5000);
                }
                return;
            }

            const tableHtml = `
            <div class="search-results-table" style="margin: 15px 0; overflow-x: auto;">
                <h4 style="margin: 10px 0; font-size: 14px; color: #333;">Existing File Records</h4>
                <table style="width: 100%; border-collapse: collapse; font-size: 12px; background: #f8f9fa; border-radius: 6px; overflow: hidden;">
                    <thead style="background: #007bff; color: white;">
                        <tr>
                            <th style="padding: 8px; border: 1px solid #dee2e6;">Property No.</th>
                            <th style="padding: 8px; border: 1px solid #dee2e6;">Allottee Name</th>
                            <th style="padding: 8px; border: 1px solid #dee2e6;">Division</th>
                            <th style="padding: 8px; border: 1px solid #dee2e6;">Subdivision</th>
                            <th style="padding: 8px; border: 1px solid #dee2e6;">Files</th>
                            <th style="padding: 8px; border: 1px solid #dee2e6;">Supplement</th>
                            <th style="padding: 8px; border: 1px solid #dee2e6;">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.data.map(record => `
                            <tr style="border-bottom: 1px solid #dee2e6;">
                                <td style="padding: 8px; border: 1px solid #dee2e6;">${this.escapeHtml(record.property_number || '-')}</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6;">${this.escapeHtml(record.allottee_name || '-')}</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6;">${this.escapeHtml(record.division || '-')}</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6;">${this.escapeHtml(record.subdivision || '-')}</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">${record.no_of_files || 0}</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">${record.no_of_supplement || 0}</td>
                                <td style="padding: 8px; border: 1px solid #dee2e6;">${this.escapeHtml(record.creadted_at || '-')}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                    <tfoot style="background: #e9ecef;">
                        <tr>
                            <td colspan="4" style="padding: 8px; border: 1px solid #dee2e6;"><strong>Summary</strong></td>
                            <td style="padding: 8px; border: 1px solid #dee2e6;"></td>
                            <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;"><strong>${data.total_files || 0}</strong></td>
                            <td style="padding: 8px; border: 1px solid #dee2e6;"><strong>Total Rows: ${data.total_rows || 0}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        `;

            // Insert table after the property search field or at appropriate location
            const searchField = section.querySelector('.field:first-child');

            if (searchField) {
                searchField.insertAdjacentHTML('afterend', tableHtml);
            } else {
                const formGrid = section.querySelector('.form-grid');
                formGrid?.insertAdjacentHTML('afterend', tableHtml); // ✅ FIXED
            }
        }

        setPropertyNumberFieldState(section, enabled, statusText) {
            const propertyNumberInput = section.querySelector('.property-number-input');
            if (propertyNumberInput) {
                propertyNumberInput.disabled = !enabled;
                if (enabled) {
                    propertyNumberInput.classList.add('property-number-enabled');
                    propertyNumberInput.classList.remove('property-number-disabled');
                    propertyNumberInput.placeholder = 'Enter property number';
                } else {
                    propertyNumberInput.classList.add('property-number-disabled');
                    propertyNumberInput.classList.remove('property-number-enabled');
                    propertyNumberInput.placeholder = 'Please search property number first';
                }
            }

            // Update status indicator
            let statusSpan = section.querySelector('.property-number-status');
            if (!statusSpan) {
                statusSpan = document.createElement('span');
                statusSpan.className = 'property-number-status';
                propertyNumberInput?.parentNode?.appendChild(statusSpan);
            }
            statusSpan.textContent = enabled ? '✓ Ready' : '🔒 Search required';
            statusSpan.style.fontSize = '11px';
            statusSpan.style.marginLeft = '8px';
            statusSpan.style.color = enabled ? 'green' : 'orange';
        }

        escapeHtml(str) {
            if (!str) return '';
            return str
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        // ==================== OLD API - COMPLETELY UNCHANGED ====================
        async handlePropertyNumberBlur(propertyInput) {
            if (!propertyInput.classList.contains("auto-check-enabled")) return;

            const row = propertyInput.closest(".field")?.parentElement;
            const section = propertyInput.closest('.dynamic-section');
            const sectionIndex = section?.getAttribute('data-index');

            if (sectionIndex === undefined || sectionIndex === null) return;

            const division = row.querySelector(".division-select")?.value;
            const subDivision = row.querySelector(".sub-division-select")?.value;
            const category = row.querySelector(".property-category-select")?.value;
            const type = row.querySelector(".property-type-select")?.value;
            const propertyNumber = propertyInput.value.trim();

            if (!division || !subDivision || !category || !type || !propertyNumber) {
                this.showNotification('Auto fetch failed', 'All required fields not selected.', 'error');
                return;
            }

            const originalValues = this.storeOriginalValues(row);
            const originalSupplementManager = this.supplementManagers.get(parseInt(sectionIndex));

            // Store original supplement state
            const originalSupplementValue = originalSupplementManager?.supplementSelect?.value || '0';

            try {
                const response = await fetch('/filereceving/check-property-number', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({
                        division_id: division,
                        sub_division_id: subDivision,
                        pcategory_id: category,
                        p_type_id: type,
                        property_number: propertyNumber
                    })
                });

                const data = await response.json();

                if (!data.status) {
                    this.restoreOriginalValues(row, originalValues);
                    if (originalSupplementManager) {
                        originalSupplementManager.resetToOriginalState();
                        originalSupplementManager.supplementSelect.value = originalSupplementValue;
                    }
                    this.showNotification('Auto fetch failed', data.message || 'Property not found.', 'warning');
                    return;
                }

                this.applyFetchedData(row, data.data, sectionIndex);
                this.showNotification('Auto fetch successful', 'Allottee details auto-filled.', 'success');

            } catch (error) {
                console.error("Error:", error);
                this.restoreOriginalValues(row, originalValues);
                if (originalSupplementManager) {
                    originalSupplementManager.resetToOriginalState();
                    originalSupplementManager.supplementSelect.value = originalSupplementValue;
                }
                this.showNotification('Auto fetch failed', 'Network error. Please try again.', 'error');
            }
        }

        storeOriginalValues(row) {
            return {
                prefix: row.querySelector(".prefix-select")?.value,
                firstName: row.querySelector('input[name*="[allottee_name]"]')?.value,
                middleName: row.querySelector('input[name*="[allottee_middle_name]"]')?.value,
                surname: row.querySelector('input[name*="[allottee_surname]"]')?.value,
                files: row.querySelector('select[name*="[no_of_files]"]')?.value,
                supplement: row.querySelector('select[name*="[no_of_supplement]"]')?.value,
                hasSupplement: row.querySelector('.has-supplement-select')?.value
            };
        }

        restoreOriginalValues(row, values) {
            const prefixSelect = row.querySelector(".prefix-select");
            const firstNameInput = row.querySelector('input[name*="[allottee_name]"]');
            const middleNameInput = row.querySelector('input[name*="[allottee_middle_name]"]');
            const surnameInput = row.querySelector('input[name*="[allottee_surname]"]');
            const filesSelect = row.querySelector('select[name*="[no_of_files]"]');

            if (prefixSelect) {
                prefixSelect.value = values.prefix || "";
                prefixSelect.disabled = false;
            }
            if (firstNameInput) {
                firstNameInput.value = values.firstName || "";
                firstNameInput.disabled = false;
            }
            if (middleNameInput) {
                middleNameInput.value = values.middleName || "";
                middleNameInput.disabled = false;
            }
            if (surnameInput) {
                surnameInput.value = values.surname || "";
                surnameInput.disabled = false;
            }
            if (filesSelect) {
                filesSelect.value = values.files || "1";
                filesSelect.disabled = false;
            }

            // Remove hidden input if exists
            const hiddenInput = row.querySelector('input[name*="[allottee_exists_id]"]');
            if (hiddenInput) hiddenInput.remove();
        }

        applyFetchedData(row, data, sectionIndex) {
            const prefixSelect = row.querySelector(".prefix-select");
            const firstNameInput = row.querySelector('input[name*="[allottee_name]"]');
            const middleNameInput = row.querySelector('input[name*="[allottee_middle_name]"]');
            const surnameInput = row.querySelector('input[name*="[allottee_surname]"]');
            const filesSelect = row.querySelector('select[name*="[no_of_files]"]');

            // Apply fetched values
            if (prefixSelect) {
                prefixSelect.value = data.prefix ?? "";
                prefixSelect.disabled = true;
            }
            if (firstNameInput) {
                firstNameInput.value = data.allottee_name ?? "";
                firstNameInput.disabled = true;
            }
            if (middleNameInput) {
                middleNameInput.value = data.allottee_middle_name ?? "";
                middleNameInput.disabled = true;
            }
            if (surnameInput) {
                surnameInput.value = data.allottee_surname ?? "";
                surnameInput.disabled = true;
            }
            if (filesSelect) {
                filesSelect.value = data.no_of_files ?? 1;
                filesSelect.disabled = true;
            }

            // Handle supplement for this specific section
            const supplementValue = data.no_of_supplement ?? 0;
            console.log("Applying supplement value for section", sectionIndex, "Value:", supplementValue);
            const supplementManager = this.supplementManagers.get(parseInt(sectionIndex));
            if (supplementManager) {
                supplementManager.applyApiData(supplementValue);
            }

            // Add hidden input for existing allottee
            if (firstNameInput && data.id_exits) {
                const existingHidden = row.querySelector('input[name*="[allottee_exists_id]"]');
                if (existingHidden) existingHidden.remove();

                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = firstNameInput.getAttribute("name")?.replace("[allottee_name]", "[allottee_exists_id]");
                hiddenInput.value = data.id_exits;
                row.appendChild(hiddenInput);
            }
        }

        initializeSavedAllottees() {
            document.querySelectorAll('.dynamic-section').forEach((section, index) => {
                const allotteeIdInput = section.querySelector('.allottee-id-input');
                if (allotteeIdInput?.value) {
                    this.savedAllottees[index] = allotteeIdInput.value;
                    const saveBtn = document.getElementById(`save-btn-${index}`);
                    if (saveBtn) {
                        const span = saveBtn.querySelector('span');
                        if (span) span.textContent = 'Update';
                        saveBtn.classList.add('updating');
                    }
                }
            });
        }

        initializeAllSections() {
            document.querySelectorAll('.dynamic-section').forEach((section, index) => {
                if (section.id && section.id.startsWith('section-')) {
                    // Create supplement manager for this section
                    const supplementManager = new SupplementManager(section, index);
                    this.supplementManagers.set(index, supplementManager);

                    // Attach other events
                    this.attachEvents(section, index);
                }
            });
        }

        attachEvents(section, index) {
            const divisionSelect = section.querySelector('.division-select');
            const categorySelect = section.querySelector('.property-category-select');
            const propertyTypeSelect = section.querySelector('.property-type-select');
            const searchInput = section.querySelector('.property-search-input');

            // Add search button if not present (NEW)
            let searchButton = section.querySelector('.property-search-btn');
            if (!searchButton && searchInput) {
                searchButton = document.createElement('button');
                searchButton.type = 'button';
                searchButton.className = 'property-search-btn';
                searchButton.innerHTML = 'Search';
                Object.assign(searchButton.style, {
                    marginLeft: '8px',
                    padding: '4px 12px',
                    backgroundColor: '#007bff',
                    color: 'white',
                    border: 'none',
                    borderRadius: '4px',
                    cursor: 'pointer'
                });
                searchInput.parentNode?.appendChild(searchButton);
            }

            if (divisionSelect) {
                if (divisionSelect.value) this.loadSubDivisions(divisionSelect);
                divisionSelect.addEventListener('change', () => {
                    this.loadSubDivisions(divisionSelect);
                    this.markSectionUnsaved(index);
                });
            }

            if (categorySelect) {
                if (categorySelect.value) this.loadPropertyTypes(categorySelect);
                categorySelect.addEventListener('change', () => {
                    this.loadPropertyTypes(categorySelect);
                    this.markSectionUnsaved(index);
                });
            }

            if (propertyTypeSelect) {
                if (propertyTypeSelect.value) {
                    this.updatePropertyNumberLabel(propertyTypeSelect);
                    this.toggleQuarterType(propertyTypeSelect);
                }
                propertyTypeSelect.addEventListener('change', () => {
                    this.updatePropertyNumberLabel(propertyTypeSelect);
                    this.toggleQuarterType(propertyTypeSelect);
                    this.markSectionUnsaved(index);
                });
            }

            section.querySelectorAll('input, select, textarea').forEach(input => {
                input.addEventListener('change', () => this.markSectionUnsaved(index));
                input.addEventListener('input', () => this.markSectionUnsaved(index));
            });
        }

        async loadSubDivisions(divisionSelect, selectedValue = null) {
            const divisionId = divisionSelect.value;
            const section = divisionSelect.closest('.dynamic-section');
            const subDivisionSelect = section.querySelector('.sub-division-select');

            subDivisionSelect.innerHTML = '<option value="">Select Sub Division</option>';
            if (!divisionId) return;

            try {
                const response = await fetch(`/get-sub-divisions/${divisionId}`);
                const data = await response.json();
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    if (selectedValue && selectedValue == item.id) option.selected = true;
                    subDivisionSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading sub divisions:', error);
            }
        }

        async loadPropertyTypes(categorySelect, selectedValue = null) {
            const categoryId = categorySelect.value;
            const section = categorySelect.closest('.dynamic-section');
            const propertyTypeSelect = section.querySelector('.property-type-select');

            propertyTypeSelect.innerHTML = '<option value="">Select Property Type</option>';
            if (!categoryId) return;

            try {
                const response = await fetch(`/get-property-types/${categoryId}`);
                const data = await response.json();
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    if (selectedValue && selectedValue == item.id) option.selected = true;
                    propertyTypeSelect.appendChild(option);
                });
                if (selectedValue) this.toggleQuarterType(propertyTypeSelect);
            } catch (error) {
                console.error('Error loading property types:', error);
            }
        }

        updatePropertyNumberLabel(propertyTypeSelect) {
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

        toggleQuarterType(propertyTypeSelect) {
            const section = propertyTypeSelect.closest('.dynamic-section');
            if (!section) return;

            const quarterField = section.querySelector('.quarter-type-field');
            const quarterSelect = quarterField?.querySelector('select');
            if (!quarterSelect) return;

            const propertyTypeText = propertyTypeSelect.options[propertyTypeSelect.selectedIndex]?.text?.toLowerCase() || '';
            const isPlot = propertyTypeText.includes('plot');

            Array.from(quarterSelect.options).forEach(option => {
                const text = option.text.toLowerCase();
                if (!option.value) return;
                option.hidden = isPlot ? (!text.includes('mig') && !text.includes('hig')) : false;
                if (option.hidden && option.selected) option.selected = false;
            });

            quarterSelect.required = true;
        }

        updateCounter() {
            const container = document.getElementById('allottee-sections');
            const currentCount = container.querySelectorAll('.dynamic-section').length;
            const counterElement = document.getElementById('sectionCounter');

            if (counterElement) counterElement.innerText = `${currentCount}/${this.allowedLimit}`;

            const addMoreBtn = document.querySelector('button[onclick="addAllotteeSection()"]');
            if (addMoreBtn) {
                const isMax = currentCount >= this.allowedLimit;
                addMoreBtn.disabled = isMax;
                addMoreBtn.style.opacity = isMax ? "0.6" : "1";
                addMoreBtn.style.cursor = isMax ? "not-allowed" : "pointer";
                addMoreBtn.title = isMax ? `Maximum limit of ${this.allowedLimit} files reached` : `Add another allottee (max ${this.allowedLimit})`;
            }
        }

        addAllotteeSection() {
            const container = document.getElementById('allottee-sections');
            const currentCount = container.querySelectorAll('.dynamic-section[id^="section-"]').length;

            if (currentCount >= this.allowedLimit) {
                this.showNotification('Maximum limit of ' + this.allowedLimit + ' files reached', '', 'warning');
                return;
            }

            const index = currentCount;
            const template = this.generateSectionTemplate(index);
            container.insertAdjacentHTML('beforeend', template);

            const newSection = container.lastElementChild;

            // Create supplement manager for new section
            const supplementManager = new SupplementManager(newSection, index);
            this.supplementManagers.set(index, supplementManager);

            this.attachEvents(newSection, index);
            this.updateCounter();
        }

        generateSectionTemplate(index) {
            return `
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
                    
                    <!-- NEW: Search Property Number Field -->
                    <div class="field">
                        <label class="label">Search by Property No.</label>
                        <div style="display: flex; align-items: center;">
                            <input type="text" class="property-search-input" style="flex: 1;"
                                name="allottees[${index}][property_search]"
                                placeholder="Enter property number to search"
                                value="">
                            <button type="button" class="property-search-btn"
                                style="margin-left: 8px; padding: 6px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                Search
                            </button>
                        </div>
                    </div>
                    
                    <div class="field">
                        <label class="label required">Is Allottee file already received?</label>
                        <select name="allottees[${index}][confirm_received]" class="confirm-select" required>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                    
                    <div class="field" style="display: none;">
                        <label class="label required">Is this same allotte name ?</label>
                        <select name="allottees[${index}][confirm_same_allottee_name]" class="confirm-name-select" required>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                    
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
                        <label class="label required property-number-label">Property No.</label>
                        <input type="text" class="property-number-input" name="allottees[${index}][property_number]" placeholder="Enter property number" disabled required>
                    </div>
                    
                    <div class="field">
                        <label class="label required">Allottee First Name</label>
                        <div class="input-group">
                            @php $prefixes = ['Shri', 'Smt.', 'Miss', 'Dr.', 'Md.', 'Late', 'M/S', 'Maj.', 'Capt.']; @endphp
                            <select name="allottees[${index}][prefix]" class="prefix-select" required>
                                @foreach ($prefixes as $prefix)
                                    <option value="{{ $prefix }}">{{ $prefix }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="allottees[${index}][allottee_name]" placeholder="Enter allottee name" required>
                        </div>
                    </div>
                    
                    <div class="field">
                        <label class="label">Allottee Middle Name</label>
                        <input type="text" name="allottees[${index}][allottee_middle_name]" placeholder="Enter allottee middle name">
                    </div>
                    
                    <div class="field">
                        <label class="label required">Allottee Surname</label>
                        <input type="text" name="allottees[${index}][allottee_surname]" placeholder="Enter allottee surname" required>
                    </div>
                    
                    <div class="field">
                        <label class="label required">No. of Files</label>
                        <select name="allottees[${index}][no_of_files]" required>
                            @for ($i = 1; $i <= 1; $i++)
                                <option value="{{ $i }}" {{ $i == 1 ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="field">
                        <label class="label">Add Supplement Files?</label>
                        <select name="allottees[${index}][has_supplement]" class="has-supplement-select">
                            <option value="No" selected>No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                    
                    <div class="field supplement-field-wrapper hidden-supplement">
                        <label class="label">Additional Supplements Files</label>
                        <select name="allottees[${index}][no_of_supplement]" class="supplement-select">
                            @for ($i =1; $i <= 9; $i++)
                                <option value="{{ $i }}" {{ $i == 0 ? 'selected' : '' }}>{{ $i }}</option>
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
        }

        async saveAllottee(index) {
            const section = document.getElementById(`section-${index}`);
            if (!section) {
                this.showNotification('Error', 'Could not find section to save.', 'error');
                return;
            }

            if (!this.registerId) {
                this.showNotification('Error', 'Register ID not found.', 'error');
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                this.showNotification('Error', 'CSRF token not found.', 'error');
                return;
            }

            const isValid = this.validateSection(section);
            if (!isValid) return;

            const allotteeIdInput = section.querySelector('.allottee-id-input');
            const allotteeId = allotteeIdInput?.value || null;
            const isUpdate = !!allotteeId;

            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('register_id', this.registerId);
            if (isUpdate) formData.append('allottee_id', allotteeId);

            section.querySelectorAll('input, select').forEach(el => {
                if (el.name && el.name.includes('allottees')) {
                    const match = el.name.match(/allottees\[(\d+)\]\[(\w+)\]/);
                    if (match && match[2] !== 'id') {
                        formData.append(match[2], el.value);
                    }
                }
            });

            const saveBtn = document.getElementById(`save-btn-${index}`);
            this.setButtonLoading(saveBtn, true);

            try {
                const endpoint = isUpdate ? '/filereceving/individual/update-allottee' : '/filereceving/individual/store';
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || 'Operation failed.');
                }

                const statusBadge = document.getElementById(`status-${index}`);
                if (statusBadge) {
                    statusBadge.textContent = 'Saved';
                    statusBadge.className = 'status-badge status-saved';
                }

                if (data.allottee_id) {
                    this.savedAllottees[index] = data.allottee_id;
                    if (allotteeIdInput) allotteeIdInput.value = data.allottee_id;
                }

                this.setButtonSaved(saveBtn, isUpdate);
                this.showNotification('Success', isUpdate ? 'Allottee updated successfully!' : 'Allottee saved successfully!', 'success');

            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error', error.message || 'Unexpected error occurred.', 'error');
            } finally {
                this.setButtonLoading(saveBtn, false);
            }
        }

        validateSection(section) {
            const inputs = section.querySelectorAll('input[required], select[required]');
            let isValid = true;
            let firstInvalidInput = null;

            inputs.forEach(input => {
                if (input.closest('.quarter-type-field')?.classList.contains('hidden-field')) return;
                if (!input.value.trim()) {
                    input.style.borderColor = '#dc3545';
                    if (!firstInvalidInput) firstInvalidInput = input;
                    isValid = false;
                } else {
                    input.style.borderColor = '';
                }
            });

            if (!isValid && firstInvalidInput) {
                firstInvalidInput.focus();
                this.showNotification('Validation Error', 'Please fill all required fields.', 'error');
            }

            return isValid;
        }

        setButtonLoading(button, isLoading) {
            if (!button) return;
            if (isLoading) {
                button.innerHTML = '<span>Saving...</span>';
                button.disabled = true;
            } else {
                button.disabled = false;
            }
        }

        setButtonSaved(button, isUpdate) {
            if (!button) return;
            const span = button.querySelector('span');
            if (span) span.textContent = isUpdate ? 'Update' : 'Save';
            if (isUpdate) button.classList.add('updating');
        }

        removeSection(btn) {
            const section = btn.closest('.dynamic-section');
            if (!section) return;

            const sectionId = section.id;
            const index = parseInt(sectionId.split('-')[1]);
            const allotteeIdInput = section.querySelector('.allottee-id-input');
            const allotteeId = allotteeIdInput?.value;

            if (allotteeId && !confirm('This allottee has been saved. Are you sure you want to remove it? This will delete the allottee record.')) {
                return;
            }

            if (allotteeId) {
                this.deleteAllottee(allotteeId, section, index);
            } else {
                this.removeSectionFromDOM(section, index);
            }
        }

        async deleteAllottee(allotteeId, section, index) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            try {
                const response = await fetch('/filereceving/delete-allottee', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        allottee_id: allotteeId
                    })
                });

                const data = await response.json();

                if (data.success) {
                    delete this.savedAllottees[index];
                    const manager = this.supplementManagers.get(index);
                    if (manager) manager.destroy();
                    this.supplementManagers.delete(index);
                    section.remove();
                    this.reindexSections();
                    this.updateCounter();
                    this.showNotification('Success', 'Allottee deleted successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to delete allottee');
                }
            } catch (error) {
                console.error('Error deleting allottee:', error);
                this.showNotification('Error', 'Failed to delete allottee: ' + error.message, 'error');
            }
        }

        removeSectionFromDOM(section, index) {
            const manager = this.supplementManagers.get(index);
            if (manager) manager.destroy();
            this.supplementManagers.delete(index);
            section.remove();
            this.reindexSections();
            this.updateCounter();
        }

        reindexSections() {
            const newManagers = new Map();

            document.querySelectorAll('.dynamic-section[id^="section-"]').forEach((sec, i) => {
                sec.dataset.index = i;
                const counterSpan = sec.querySelector('.allottee-counter');
                if (counterSpan) counterSpan.innerText = i + 1;

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

                // Reattach supplement manager with new index
                const oldManager = this.supplementManagers.get(parseInt(sec.getAttribute('data-old-index') || i));
                if (oldManager) {
                    oldManager.destroy();
                }
                const newManager = new SupplementManager(sec, i);
                newManagers.set(i, newManager);
            });

            this.supplementManagers = newManagers;
            this.updateCounter();
        }

        markSectionUnsaved(index) {
            if (index !== null && this.savedAllottees[index]) {
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

        switchMode(mode) {
            const editContainer = document.getElementById('editModeContainer');
            const previewContainer = document.getElementById('previewModeContainer');

            if (mode === 'preview') {
                this.generatePreview();
                editContainer.style.display = 'none';
                previewContainer.style.display = 'block';
            } else {
                editContainer.style.display = 'block';
                previewContainer.style.display = 'none';
            }
        }

        switchToPreview() {
            const hasSavedAllottees = Object.keys(this.savedAllottees).length > 0;
            if (!hasSavedAllottees) {
                alert('Please save at least one allottee before previewing.');
                return;
            }
            this.switchMode('preview');
        }

        generatePreview() {
            const sections = document.querySelectorAll('.dynamic-section');
            let previewHtml = '';

            sections.forEach((section, index) => {
                const confirmRecieved = section.querySelector('[name*="[confirm_received]"] option:checked')?.text || 'Not selected';
                const confirmSameAllotteename = section.querySelector('[name*="[confirm_same_allottee_name]"] option:checked')?.text || 'Not selected';
                const division = section.querySelector('[name*="[division_id]"] option:checked')?.text || 'Not selected';
                const subDivision = section.querySelector('[name*="[sub_division_id]"] option:checked')?.text || 'Not selected';
                const category = section.querySelector('[name*="[pcategory_id]"] option:checked')?.text || 'Not selected';
                const propertyType = section.querySelector('[name*="[p_type_id]"] option:checked')?.text || 'Not selected';
                const propertyNumber = section.querySelector('[name*="[property_number]"]')?.value || 'Not entered';
                const quarterType = section.querySelector('[name*="[quarter_type]"] option:checked')?.text || 'Not selected';
                const prefix = section.querySelector('[name*="[prefix]"] option:checked')?.value || '';
                const allotteeName = section.querySelector('[name*="[allottee_name]"]')?.value || 'Not entered';
                const allotteeMiddleName = section.querySelector('[name*="[allottee_middle_name]"]')?.value || 'Not entered';
                const allotteeSurname = section.querySelector('[name*="[allottee_surname]"]')?.value || 'Not entered';
                const noOfFiles = section.querySelector('[name*="[no_of_files]"] option:checked')?.value || 'Not selected';
                const noOfSupplement = section.querySelector('[name*="[no_of_supplement]"] option:checked')?.value || '0';
                const remarks = section.querySelector('[name*="[remarks]"] option:checked')?.text || 'Not selected';

                previewHtml += `
                <div class="summary-cards" style="margin-bottom: 20px;">
                    <div class="summary-title" style="display: flex; justify-content: space-between; align-items: center;">
                        <span>Allottee #${index + 1}</span>
                        <span class="status-badge ${this.savedAllottees[index] ? 'status-saved' : 'status-unsaved'}" style="font-size: 11px;">
                            ${this.savedAllottees[index] ? 'Saved' : 'Unsaved'}
                        </span>
                    </div>
                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="summary-label">Is Allottee file already received?</span>
                            <span class="summary-value editable" onclick="editField(${index}, 'confirm_received')">${confirmRecieved}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Is this same allotte name ?</span>
                            <span class="summary-value editable" onclick="editField(${index}, 'confirm_same_allottee_name')">${confirmSameAllotteename}</span>
                        </div>
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
                            <span class="summary-label">Allottee Middle Name</span>
                            <span class="summary-value editable" onclick="editField(${index}, 'allottee_middle_name')">${allotteeMiddleName}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Allottee Surname</span>
                            <span class="summary-value editable" onclick="editField(${index}, 'allottee_surname')">${allotteeSurname}</span>
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

        editField(index, field) {
            this.switchMode('edit');

            const section = document.getElementById(`section-${index}`);
            if (section) {
                section.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                const fieldMap = {
                    'confirm_received': '[name*="[confirm_received]"]',
                    'confirm_same_allottee_name': '[name*="[confirm_same_allottee_name]"]',
                    'division': '[name*="[division_id]"]',
                    'sub_division': '[name*="[sub_division_id]"]',
                    'category': '[name*="[pcategory_id]"]',
                    'property_type': '[name*="[p_type_id]"]',
                    'property_number': '[name*="[property_number]"]',
                    'quarter_type': '[name*="[quarter_type]"]',
                    'allottee_name': '[name*="[allottee_name]"]',
                    'no_of_files': '[name*="[no_of_files]"]',
                    'no_of_supplement': '[name*="[no_of_supplement]"]',
                    'remarks': '[name*="[remarks]"]'
                };

                const fieldElement = section.querySelector(fieldMap[field]);
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
        }

        finalSubmit() {
            const hasSavedAllottees = Object.keys(this.savedAllottees).length > 0;

            if (!hasSavedAllottees) {
                alert('Please save at least one allottee before submitting the form.');
                this.switchMode('edit');
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

            if (unsavedSections.length > 0 && !confirm(`Allottee(s) ${unsavedSections.join(', ')} are not saved. Do you want to register the file anyway? Unsaved data will be lost.`)) {
                return;
            }

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
                .then(response => response.ok ? response.json() : Promise.reject('Network response was not ok'))
                .then(data => {
                    if (data.success) {
                        this.showNotification('Success', 'File registered successfully!', 'success');
                        setTimeout(() => window.location.href = data.redirect_url || '/dashboard', 1500);
                    } else {
                        this.showNotification('Error', data.message || 'Registration failed.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.showNotification('Error', 'An error occurred during registration.', 'error');
                });
        }

        showNotification(title, message, type) {
            if (typeof showToast === 'function') {
                showToast(title, message, type);
            } else {
                console.log(`${title}: ${message}`);
            }
        }
    }

    // Initialize the application
    const app = new FileReceivingApp();
</script>
@endpush