@extends('applicant.dashboard_layouts.main')

@section('title', 'Create Register')

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

        <form action="{{ route('admin.filereceving.limitset') }}" method="POST" class="form-body">
            @csrf
            <input type="hidden" name="register_id" value="{{ $register->register_no }}">
            <p class="mb-3"> Select how many files are allowed in this registration (Max 15): </p>
            <div class="field"> <label class="label required">Allowed Files</label> <select name="allowed_files"
                    class="form-select" required>
                    <option value="">Select</option>
                    @for ($i = 1; $i <= 15; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <!-- Form Footer with Submit Button -->
            <div class="form-footer">
                <button type="submit" class="submit-btn">
                    Continue
                    <svg viewBox="0 0 24 24">
                        <path d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
@endsection
