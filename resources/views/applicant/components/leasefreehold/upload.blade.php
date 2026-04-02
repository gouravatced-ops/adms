@extends('applicant.dashboard_layouts.main')

@section('title', 'Lease Free Hold - Uploads Document')

@section('content')
    <style>
        :root {
            --ink: #000000;
            --deep: #111827;
            --surface: #f5f4f0;
            --card: #ffffff;
            --muted: #777a7f;
            --border: #e4e2dc;
            --gold: #686868;
            --gold-lt: #f5ecd5;
            --gold-dk: #a07c30;
            --success: #15803d;
            --success-lt: #d6f0e3;
            --danger: #b53b3b;
            --danger-lt: #fde8e8;
            --radius: 14px;
            --radius-sm: 8px;
            --shadow: 0 4px 24px rgba(13, 15, 20, 0.08);
        }

        /* ── OUTER CARD ─────────────────────────────────────────── */
        .app-shell {
            background: var(--card);
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        /* ── BODY ────────────────────────────────────────────────── */
        .app-body {
            padding: 20px 24px;
        }

        /* Alert */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: var(--success-lt);
            border-left: 4px solid var(--success);
            color: var(--success);
        }

        .alert-danger {
            background: var(--danger-lt);
            border-left: 4px solid var(--danger);
            color: var(--danger);
        }

        .btn-close {
            margin-left: auto;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        /* Property Summary Pills */
        .property-summary {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .prop-pill {
            display: flex;
            flex-direction: column;
            gap: 3px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 8px 14px;
            min-width: 120px;
            flex: 1;
        }

        .prop-pill-label {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--muted);
        }

        .prop-pill-value {
            font-size: 12px;
            font-weight: 600;
            color: var(--ink);
        }

        /* Progress Bar */
        .progress-section {
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .progress-header h4 {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
        }

        .progress-percentage {
            font-size: 12px;
            font-weight: 600;
            color: #667eea;
        }

        .progress-bar-container {
            background: #e0e0e0;
            border-radius: 4px;
            height: 6px;
            overflow: hidden;
        }

        .progress-bar-fill {
            background: linear-gradient(90deg, #667eea, #764ba2);
            height: 100%;
            transition: width 0.3s;
        }

        .progress-status {
            margin-top: 8px;
            text-align: center;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .status-badge.completed {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        /* Documents Section */
        .documents-section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 2px solid;
        }

        .completed-title {
            color: #28a745;
            border-bottom-color: #28a745;
        }

        .pending-title {
            color: #ffc107;
            border-bottom-color: #ffc107;
        }

        /* Table Styles */
        .document-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .document-table th {
            background: #667eea;
            color: white;
            padding: 8px 6px;
            font-weight: 600;
            font-size: 14px;
            border: 1px solid #ddd;
        }

        .document-table td {
            padding: 6px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        .document-row.completed-row {
            background-color: #f8f9fa;
        }

        /* .document-row.completed-row input,
                .document-row.completed-row select,
                .document-row.completed-row textarea {
                    background-color: #e9ecef;
                    opacity: 0.7;
                    pointer-events: none;
                } */

        .sl-badge {
            display: inline-block;
            width: 24px;
            height: 24px;
            background: #aa7700;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-completed {
            display: inline-block;
            width: 18px;
            height: 18px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 18px;
            font-size: 14px;
            margin-left: 5px;
        }

        .compact-input {
            width: 100%;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .compact-input:focus {
            border-color: #aa7700;
            outline: none;
        }

        .file-input {
            width: 100%;
            padding: 3px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .date-group {
            display: flex;
            gap: 4px;
        }

        .form-input-sm {
            flex: 1;
            padding: 4px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
        }

        .btn-submit {
            padding: 5px 10px;
            background: #aa7700;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
        }

        .btn-submit:hover:not(:disabled) {
            background: #8b6200;
        }

        .btn-submit:disabled {
            background: #cccccc;
            cursor: not-allowed;
        }

        .btn-preview-sm {
            padding: 3px 8px;
            background: #17a2b8;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-reupload-sm {
            padding: 3px 8px;
            background: #ffc107;
            color: #000;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .text-center {
            text-align: center;
        }

        .field-hint {
            font-size: 9px;
            color: #6c757d;
            margin-top: 2px;
            display: block;
        }

        .optional-badge {
            font-size: 9px;
            font-weight: normal;
            color: #6c757d;
            margin-left: 5px;
        }

        .upload-time {
            font-size: 14px;
            color: #6c757d;
            margin-top: 2px;
        }

        /* Modal Styles - Top to Bottom Animation */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            position: relative;
            background: white;
            width: 90%;
            max-width: 700px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: slideDown 0.4s cubic-bezier(0.34, 1.2, 0.64, 1);
            transform-origin: top center;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-100px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Center the modal vertically and horizontally */
        .modal-overlay {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .modal-content {
            max-height: 80vh;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 10px 15px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 15px;
            font-weight: 600;
        }

        .modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 10px;
            overflow-y: auto;
            flex: 1;
        }

        .file-preview {
            text-align: center;
            margin-bottom: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-preview img,
        .file-preview embed {
            width: 600px;
            max-height: 350px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .preview-details {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .preview-details p {
            margin: 10px 0;
            font-size: 13px;
            line-height: 1.5;
        }

        .preview-details strong {
            display: inline-block;
            width: 130px;
            color: #555;
            font-weight: 600;
        }

        .modal-footer {
            padding: 16px 20px;
            border-top: 1px solid #e0e0e0;
            text-align: right;
            background: #fafafa;
            border-radius: 0 0 12px 12px;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 12px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }

        .btn-primary-modal {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            padding: 8px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary-modal:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                margin: 10px auto;
            }

            .modal-header h3 {
                font-size: 16px;
            }

            .preview-details p {
                font-size: 12px;
            }

            .preview-details strong {
                width: 100px;
            }

            .file-preview {
                min-height: 200px;
                padding: 10px;
            }

            .file-preview img,
            .file-preview embed {
                max-height: 250px;
            }

            .btn-secondary,
            .btn-primary-modal,
            .btn-danger {
                padding: 6px 16px;
                font-size: 12px;
            }
        }

        /* Animation for modal close */
        .modal-overlay.closing {
            animation: fadeOut 0.3s ease-out;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        .modal-content.closing {
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            to {
                opacity: 0;
                transform: translateY(-50px) scale(0.95);
            }
        }

        @media (max-width: 768px) {
            .app-body {
                padding: 15px;
            }

            .property-summary {
                flex-direction: column;
            }

            .document-table {
                font-size: 14px;
            }

            .compact-input {
                font-size: 14px;
            }
        }
    </style>

    <div class="app-shell">
        {{-- Header --}}
        <div class="modern-card-header">
            <div class="header-flex">
                <div>
                    <h1 class="header-title">Free Hold Supporting Documents</h1>
                    <p class="header-subtitle">
                        View uploaded documents and upload remaining documents for the selected allottee.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('lease.allottee.index') }}">
                        <button class="btn btn-info"
                            style="background: linear-gradient(135deg, #ce3d04, #ee5121) !important; color:white;padding: 6px 24px; border-radius: 2px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16"
                                height="16">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg> Back
                        </button>
                    </a>
                </div>
            </div>
        </div>

        {{-- Alert Container --}}
        <div id="alertContainer"></div>

        {{-- Body --}}
        <div class="app-body">
            {{-- Property summary pill --}}
            <div class="property-summary">
                <div class="prop-pill">
                    <span class="prop-pill-label">Division</span>
                    <span class="prop-pill-value">{{ $file->division->name ?? 'N/A' }}</span>
                </div>
                <div class="prop-pill">
                    <span class="prop-pill-label">Sub Division</span>
                    <span class="prop-pill-value">{{ $file->subDivision->name ?? 'N/A' }}</span>
                </div>
                <div class="prop-pill">
                    <span class="prop-pill-label">Property No.</span>
                    <span class="prop-pill-value">{{ $file->property_number }}</span>
                </div>
                <div class="prop-pill">
                    <span class="prop-pill-label">Property Type</span>
                    <span class="prop-pill-value">{{ $file->propertyCategory->name ?? 'N/A' }}-<span
                            style="color: green;">{{ $file->propertyType->name ?? 'N/A' }}</span></span>
                </div>
                <div class="prop-pill">
                    <span class="prop-pill-label">Quarter Type</span>
                    <span class="prop-pill-value">{{ $file->quarterType->quarter_code ?? 'N/A' }}</span>
                </div>
            </div>

            {{-- Progress Bar --}}
            <div class="progress-section">
                <div class="progress-header">
                    <h4>Document Upload Progress</h4>
                    <span class="progress-percentage" id="progressCount">0/0</span>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" id="progressBar" style="width: 0%"></div>
                </div>
                <div class="progress-status">
                    <span class="status-badge pending" id="progressStatus">📄 Loading...</span>
                </div>
            </div>

            {{-- Completed Documents Section --}}
            @if (isset($completedDocuments) && count($completedDocuments) > 0)
                <div class="documents-section">
                    <h4 class="section-title completed-title">
                        <i class="fas fa-check-circle"></i> Completed Documents
                    </h4>
                    <table class="document-table">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="18%">Document Name</th>
                                <th width="10%">Doc No.</th>
                                <th width="10%">Date</th>
                                <th width="12%">Additional Info</th>
                                <th width="10%">File</th>
                                <th width="15%">Remarks</th>
                                <th width="10%">Upload Time</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="completedDocumentsBody">
                            @foreach ($completedDocuments as $index => $doc)
                                @php
                                    $uploadData = $doc->upload;
                                    $docDate =
                                        $uploadData && $uploadData->document_date
                                            ? \Carbon\Carbon::parse($uploadData->document_date)->format('d/m/Y')
                                            : 'N/A';
                                    $docNo = $uploadData->doc_no ?? '';
                                    $additionalInfo = $uploadData->additional_info ?? '';
                                    $remarks = $uploadData->remarks ?? '';
                                    $day = $uploadData->doc_day ?? '';
                                    $month = $uploadData->doc_month ?? '';
                                    $year = $uploadData->doc_year ?? '';
                                @endphp
                                <tr class="document-row completed-row" data-document-id="{{ $doc->id }}"
                                    data-doc-no="{{ $docNo }}" data-day="{{ $day }}"
                                    data-month="{{ $month }}" data-year="{{ $year }}"
                                    data-additional-info="{{ $additionalInfo }}" data-remarks="{{ $remarks }}">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="doc-name-cell">
                                        {{ $doc->document_name }}
                                        <span class="status-completed">✓</span>
                                    </td>
                                    <td>
                                        <input type="text" class="compact-input" value="{{ $docNo }}" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="compact-input" value="{{ $docDate }}" disabled>
                                    </td>
                                    <td>
                                        <textarea class="compact-input" rows="1" disabled>{{ $additionalInfo }}</textarea>
                                    </td>
                                    <td>
                                        @if ($uploadData && $uploadData->file_path)
                                            <button type="button" class="btn-preview-sm"
                                                onclick="previewCompletedDocument('{{ asset($uploadData->file_path) }}', '{{ addslashes($doc->document_name) }}', '{{ addslashes($docNo) }}', '{{ addslashes($docDate) }}', '{{ addslashes($additionalInfo) }}', '{{ addslashes($remarks) }}', '{{ $uploadData->created_at ?? '' }}')">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        @else
                                            <span class="text-muted">No file</span>
                                        @endif
                                    </td>
                                    <td>
                                        <textarea class="compact-input" rows="1" disabled>{{ $remarks }}</textarea>
                                    </td>
                                    <td class="upload-time">
                                        @if ($uploadData && $uploadData->created_at)
                                            {{ \Carbon\Carbon::parse($uploadData->created_at)->format('d/m/Y H:i:s') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn-reupload-sm"
                                            onclick="openReuploadModal({{ $doc->id }}, '{{ addslashes($doc->document_name) }}')">
                                            <i class="fas fa-sync-alt"></i> Re-upload
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Pending Documents Section --}}
            <div class="documents-section">
                <h4 class="section-title pending-title">
                    <i class="fas fa-upload"></i> Pending Documents
                </h4>
                <div id="pendingDocumentsContainer"></div>
            </div>
        </div>
    </div>

    {{-- Hidden Data --}}
    <input type="hidden" id="applicantId" value="{{ $file->id }}">
    <input type="hidden" id="uploadPath" value="{{ $file->freehold_upload_document_path }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        // Global utility functions
        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        function generateDateOptions(selectedDay = '', selectedMonth = '', selectedYear = '') {
            let days = '',
                months = '',
                years = '';

            // Generate days
            for (let i = 1; i <= 31; i++) {
                const selected = selectedDay == i ? 'selected' : '';
                days += `<option value="${i}" ${selected}>${i}</option>`;
            }

            // Generate months
            for (let i = 1; i <= 12; i++) {
                const selected = selectedMonth == i ? 'selected' : '';
                months += `<option value="${i}" ${selected}>${i}</option>`;
            }

            // Generate years (last 100 years)
            const currentYear = new Date().getFullYear();
            for (let i = currentYear; i >= currentYear - 100; i--) {
                const selected = selectedYear == i ? 'selected' : '';
                years += `<option value="${i}" ${selected}>${i}</option>`;
            }

            return {
                days,
                months,
                years
            };
        }

        function showAlert(message, type, containerId = 'alertContainer') {
            const container = document.getElementById(containerId);
            if (!container) return;

            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            container.innerHTML = `
                <div class="alert ${alertClass}">
                    <span>${escapeHtml(message)}</span>
                    <button class="btn-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            `;

            setTimeout(() => {
                if (container.firstChild) {
                    container.firstChild.remove();
                }
            }, 5000);
        }

        function getFilePreview(fileUrl) {
            const ext = fileUrl.split('.').pop().toLowerCase();
            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                return `<img src="${fileUrl}" alt="Preview" style="max-width: 100%; max-height: 350px;">`;
            } else if (ext === 'pdf') {
                return `<embed src="${fileUrl}" type="application/pdf" width="100%" height="350px">`;
            } else {
                return `<p>Preview not available for this file type. <a href="${fileUrl}" target="_blank">Click here to view</a></p>`;
            }
        }

        function closeModal() {
            const modals = ['previewModal', 'previewUploadModal', 'reuploadModal'];
            modals.forEach(id => {
                const modal = document.getElementById(id);
                if (modal) modal.remove();
            });
        }

        // Preview completed document
        window.previewCompletedDocument = function(fileUrl, docName, docNo, docDate, additionalInfo, remarks, uploadTime) {
            const existingModal = document.getElementById('previewModal');
            if (existingModal) existingModal.remove();

            const modalHtml = `
                <div id="previewModal" class="modal-overlay" style="display: flex;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>${escapeHtml(docName)}</h3>
                            <button class="modal-close" onclick="closeModal()">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="file-preview">
                                ${getFilePreview(fileUrl)}
                            </div>
                            <div class="preview-details">
                                <p><strong>Document Name:</strong> ${escapeHtml(docName)}</p>
                                <p><strong>Document No.:</strong> ${escapeHtml(docNo) || 'N/A'}</p>
                                <p><strong>Date:</strong> ${escapeHtml(docDate) || 'N/A'}</p>
                                <p><strong>Additional Info:</strong> ${escapeHtml(additionalInfo) || 'N/A'}</p>
                                <p><strong>Remarks:</strong> ${escapeHtml(remarks) || 'N/A'}</p>
                                <p><strong>Upload Time:</strong> ${escapeHtml(uploadTime) || 'N/A'}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="${fileUrl}" target="_blank" class="btn-secondary" style="text-decoration: none; display: inline-block;">View</a>
                            <button class="btn-danger" onclick="closeModal()">Close</button>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        };

        // Open reupload modal
        window.openReuploadModal = function(docId, docName) {
            const row = document.querySelector(`tr[data-document-id="${docId}"]`);
            if (!row) return;

            const existingDocNo = row.getAttribute('data-doc-no') || '';
            const existingDay = row.getAttribute('data-day') || '';
            const existingMonth = row.getAttribute('data-month') || '';
            const existingYear = row.getAttribute('data-year') || '';
            const existingAdditionalInfo = row.getAttribute('data-additional-info') || '';
            const existingRemarks = row.getAttribute('data-remarks') || '';

            const applicantId = document.getElementById('applicantId').value;
            const uploadPath = document.getElementById('uploadPath').value;
            const dateOptions = generateDateOptions(existingDay, existingMonth, existingYear);

            const modalHtml = `
                <div id="reuploadModal" class="modal-overlay" style="display: flex;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Re-upload: ${escapeHtml(docName)}</h3>
                            <button class="modal-close" onclick="closeModal()">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="reuploadForm" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <input type="hidden" name="allottee_id" value="${applicantId}">
                                <input type="hidden" name="document_id" value="${docId}">
                                <input type="hidden" name="uploadpath" value="${uploadPath}">
                                
                                <div style="margin-bottom: 12px;">
                                    <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 4px;">Document Name</label>
                                    <input type="text" class="compact-input" value="${escapeHtml(docName)}" disabled style="background: #f5f5f5;">
                                </div>
                                
                                <div style="margin-bottom: 12px;">
                                    <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 4px;">Document No.</label>
                                    <input type="text" name="doc_no" class="compact-input" value="${escapeHtml(existingDocNo)}" placeholder="Document Number">
                                </div>
                                
                                <div style="margin-bottom: 12px;">
                                    <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 4px;">Date</label>
                                    <div class="date-group">
                                        <select name="day" class="form-input-sm">
                                            <option value="">Day</option>
                                            ${dateOptions.days}
                                        </select>
                                        <select name="month" class="form-input-sm">
                                            <option value="">Month</option>
                                            ${dateOptions.months}
                                        </select>
                                        <select name="year" class="form-input-sm">
                                            <option value="">Year</option>
                                            ${dateOptions.years}
                                        </select>
                                    </div>
                                </div>
                                
                                <div style="margin-bottom: 12px;">
                                    <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 4px;">Additional Information</label>
                                    <textarea name="additional_info" class="compact-input" rows="2" placeholder="Additional Information">${escapeHtml(existingAdditionalInfo)}</textarea>
                                </div>
                                
                                <div style="margin-bottom: 12px;">
                                    <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 4px;">Remarks</label>
                                    <textarea
                                        name="remarks"
                                        class="compact-input"
                                        rows="2"
                                        placeholder="Enter remarks"
                                    >${escapeHtml(existingRemarks || 'Re-Upload')}</textarea>
                                </div>
                                
                                <div style="margin-bottom: 12px;">
                                    <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 4px;">
                                        Select New File <span style="color: #dc3545;">*</span>
                                    </label>
                                    <input type="file" name="document_file" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                                    <span class="field-hint">Max 10MB - Select a file to replace the existing one</span>
                                </div>
                                
                                <div id="reuploadFilePreview" style="display: none; margin-top: 10px; padding: 10px; background: #f8f9fa; border-radius: 4px;"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary" onclick="closeModal()">Cancel</button>
                            <button class="btn-primary-modal" onclick="submitReupload(${docId})">Confirm Re-upload</button>
                        </div>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', modalHtml);

            // Add file preview listener
            const fileInput = document.querySelector('#reuploadForm input[type="file"]');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const previewDiv = document.getElementById('reuploadFilePreview');
                    if (this.files && this.files[0]) {
                        const file = this.files[0];
                        const fileUrl = URL.createObjectURL(file);
                        const ext = file.name.split('.').pop().toLowerCase();
                        let previewHtml = '';
                        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                            previewHtml =
                                `<img src="${fileUrl}" alt="Preview" style="max-width: 100%; max-height: 200px;">`;
                        } else if (ext === 'pdf') {
                            previewHtml =
                                `<embed src="${fileUrl}" type="application/pdf" width="100%" height="200px">`;
                        } else {
                            previewHtml =
                                `<p>Preview not available for this file type. File: ${escapeHtml(file.name)}</p>`;
                        }
                        previewDiv.innerHTML = `<strong>File Preview:</strong><br>${previewHtml}`;
                        previewDiv.style.display = 'block';
                    } else {
                        previewDiv.style.display = 'none';
                    }
                });
            }
        };

        // Submit reupload
        window.submitReupload = async function(docId) {
            const form = document.getElementById('reuploadForm');
            if (!form) return;

            const formData = new FormData(form);
            const file = formData.get('document_file');

            const submitBtn = document.querySelector('#reuploadModal .btn-primary-modal');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
            submitBtn.disabled = true;

            try {
                const response = await fetch('{{ route('lease.documents.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showAlert('Document re-uploaded successfully!', 'success');
                    closeModal();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    throw new Error(data.message || 'Re-upload failed');
                }
            } catch (error) {
                showAlert(error.message, 'error');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        };

        // Main Upload Handler
        const FreeHoldUploadHandler = (function() {
            const CONFIG = {
                submitUrl: "{{ route('lease.documents.store') }}"
            };

            let state = {
                documents: [],
                completedDocs: [],
                applicantId: null,
                uploadPath: null,
                isLoading: false,
                currentDoc: null
            };

            let elements = {};

            function cacheElements() {
                elements = {
                    pendingContainer: document.getElementById("pendingDocumentsContainer"),
                    completedBody: document.getElementById("completedDocumentsBody"),
                    progressCount: document.getElementById("progressCount"),
                    progressBar: document.getElementById("progressBar"),
                    progressStatus: document.getElementById("progressStatus"),
                    alertContainer: document.getElementById("alertContainer")
                };
            }

            function updateProgress() {
                const total = {{ $totalDocument ?? 7 }};
                const completed = state.completedDocs.length;
                const percentage = total > 0 ? (completed / total) * 100 : 0;

                if (elements.progressCount) {
                    elements.progressCount.textContent = `${completed}/${total}`;
                }
                if (elements.progressBar) {
                    elements.progressBar.style.width = `${percentage}%`;
                }
                if (elements.progressStatus) {
                    if (completed === total && total > 0) {
                        elements.progressStatus.className = "status-badge completed";
                        elements.progressStatus.innerHTML = "✓ All Documents Completed";
                    } else {
                        elements.progressStatus.className = "status-badge pending";
                        elements.progressStatus.innerHTML = `📄 ${total - completed} Document(s) Pending`;
                    }
                }
            }

            function loadNextDocument() {
                if (!elements.pendingContainer) return;

                const completedIds = state.completedDocs.map(d => d.id);
                const nextDoc = state.documents.find(d => !completedIds.includes(d.id));

                if (!nextDoc) {
                    elements.pendingContainer.innerHTML = `
                        <div style="padding: 20px; text-align: center; background: #d4edda; border-radius: 6px; color: #155724;">
                            <strong>✓ All documents have been uploaded successfully!</strong>
                        </div>
                    `;
                    return;
                }

                state.currentDoc = nextDoc;
                renderPendingDocument(nextDoc, completedIds.length + 1);
            }

            function renderPendingDocument(doc, slNo) {
                const dateOptions = generateDateOptions();

                const html = `
                    <div class="pending-card" style="background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 16px; margin-top: 10px;">
                        <div style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                            <span style="font-size: 14px; color: #6c757d;">Document ${slNo} of 7</span>
                            <div style="font-size: 14px; font-weight: 600; margin-top: 4px;">${escapeHtml(doc.name)}</div>
                        </div>
                        
                        <form id="uploadForm_${doc.id}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                            <input type="hidden" name="allottee_id" value="${state.applicantId}">
                            <input type="hidden" name="document_id" value="${doc.id}">
                            <input type="hidden" name="uploadpath" value="${state.uploadPath}">
                            
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 15px;">
                                <div>
                                    <label style="font-size: 14px; font-weight: 600; margin-bottom: 4px; display: block;">Document No.</label>
                                    <input type="text" name="doc_no" class="compact-input" placeholder="Optional">
                                </div>
                                
                                <div>
                                    <label style="font-size: 14px; font-weight: 600; margin-bottom: 4px; display: block;">Date</label>
                                    <div class="date-group">
                                        <select name="day" class="form-input-sm">
                                            <option value="">Day</option>
                                            ${dateOptions.days}
                                        </select>
                                        <select name="month" class="form-input-sm">
                                            <option value="">Month</option>
                                            ${dateOptions.months}
                                        </select>
                                        <select name="year" class="form-input-sm">
                                            <option value="">Year</option>
                                            ${dateOptions.years}
                                        </select>
                                    </div>
                                </div>
                                
                                <div>
                                    <label style="font-size: 14px; font-weight: 600; margin-bottom: 4px; display: block;">Additional Info</label>
                                    <textarea name="additional_info" class="compact-input" rows="1" placeholder="Optional"></textarea>
                                </div>
                                
                                <div>
                                    <label style="font-size: 14px; font-weight: 600; margin-bottom: 4px; display: block;">
                                        File <span class="optional-badge">(Required if no remarks)</span>
                                    </label>
                                    <input type="file" name="document_file" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                                    <span class="field-hint">Max 10MB</span>
                                </div>
                            </div>
                            
                            <div style="margin-bottom: 15px;">
                                <label style="font-size: 14px; font-weight: 600; margin-bottom: 4px; display: block;">
                                    Remarks <span class="optional-badge">(Required if no file)</span>
                                </label>
                                <textarea name="remarks" class="compact-input" rows="2" placeholder="Remarks (required if file not uploaded)"></textarea>
                            </div>
                            
                            <div style="text-align: right; padding-top: 10px; border-top: 1px solid #e0e0e0;">
                                <button type="button" class="btn-submit" onclick="showUploadPreview(${doc.id})">
                                    <i class="fas fa-eye"></i> Preview & Upload
                                </button>
                            </div>
                        </form>
                    </div>
                `;

                elements.pendingContainer.innerHTML = html;
            }

            function showUploadPreview(docId) {
                const form = document.getElementById(`uploadForm_${docId}`);
                if (!form) return;

                const doc = state.documents.find(d => d.id === docId);
                if (!doc) return;

                const docNo = form.querySelector('input[name="doc_no"]').value;
                const day = form.querySelector('select[name="day"]').value;
                const month = form.querySelector('select[name="month"]').value;
                const year = form.querySelector('select[name="year"]').value;
                const additionalInfo = form.querySelector('textarea[name="additional_info"]').value;
                const remarks = form.querySelector('textarea[name="remarks"]').value;
                const fileInput = form.querySelector('input[name="document_file"]');
                const file = fileInput.files[0];

                if ((!file || file.size === 0) && (!remarks || remarks.trim() === '')) {
                    showAlert('Either select a file OR enter remarks is required.', 'error');
                    return;
                }

                let filePreview = '';
                if (file) {
                    const fileUrl = URL.createObjectURL(file);
                    const ext = file.name.split('.').pop().toLowerCase();
                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                        filePreview =
                            `<img src="${fileUrl}" alt="Preview" style="max-width: 100%; max-height: 350px;">`;
                    } else if (ext === 'pdf') {
                        filePreview = `<embed src="${fileUrl}" type="application/pdf" width="100%" height="350px">`;
                    } else {
                        filePreview =
                            `<p>Preview not available for this file type. File: ${escapeHtml(file.name)}</p>`;
                    }
                } else {
                    filePreview =
                        `<p style="color: #856404; background: #fff3cd; padding: 10px; border-radius: 4px;">⚠️ No file selected. Document will be recorded with remarks only.</p>`;
                }

                const dateStr = (day && month && year) ? `${day}/${month}/${year}` : 'Not provided';

                const existingModal = document.getElementById('previewUploadModal');
                if (existingModal) existingModal.remove();

                const modalHtml = `
                    <div id="previewUploadModal" class="modal-overlay" style="display: flex;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3>Preview: ${escapeHtml(doc.name)}</h3>
                                <button class="modal-close" onclick="closeModal()">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="file-preview">
                                    ${filePreview}
                                </div>
                                <div class="preview-details">
                                    <p><strong>Document Name:</strong> ${escapeHtml(doc.name)}</p>
                                    <p><strong>Document No.:</strong> ${escapeHtml(docNo) || 'Not provided'}</p>
                                    <p><strong>Date:</strong> ${escapeHtml(dateStr)}</p>
                                    <p><strong>Additional Info:</strong> ${escapeHtml(additionalInfo) || 'Not provided'}</p>
                                    <p><strong>Remarks:</strong> ${escapeHtml(remarks) || 'Not provided'}</p>
                                    ${file ? `<p><strong>File:</strong> ${escapeHtml(file.name)} (${(file.size / 1024).toFixed(2)} KB)</p>` : '<p><strong>File:</strong> No file selected</p>'}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn-secondary" onclick="closeModal()">Cancel</button>
                                <button class="btn-primary-modal" onclick="confirmAndUpload(${docId})">Confirm & Upload</button>
                            </div>
                        </div>
                    </div>
                `;

                document.body.insertAdjacentHTML('beforeend', modalHtml);
            }

            async function confirmAndUpload(docId) {
                closeModal();

                const form = document.getElementById(`uploadForm_${docId}`);
                if (!form) return;

                const formData = new FormData(form);
                const file = formData.get('document_file');
                const remarks = formData.get('remarks');

                if ((!file || file.size === 0) && (!remarks || remarks.trim() === '')) {
                    showAlert('Either select a file OR enter remarks is required.', 'error');
                    return;
                }

                state.isLoading = true;
                const submitBtn = form.querySelector('.btn-submit');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
                submitBtn.disabled = true;

                try {
                    const response = await fetch(CONFIG.submitUrl, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        const doc = state.documents.find(d => d.id === docId);
                        const completedDoc = {
                            id: docId,
                            name: doc.name,
                            doc_no: formData.get('doc_no') || '',
                            day: formData.get('day') || '',
                            month: formData.get('month') || '',
                            year: formData.get('year') || '',
                            additional_info: formData.get('additional_info') || '',
                            remarks: remarks || '',
                            has_file: file && file.size > 0,
                            file_path: data.data?.file_path || null,
                            upload_time: new Date().toLocaleString()
                        };

                        state.completedDocs.push(completedDoc);
                        addToCompletedTable(completedDoc);

                        if (elements.pendingContainer) {
                            elements.pendingContainer.innerHTML = '';
                        }

                        updateProgress();
                        loadNextDocument();
                        showAlert(data.message, 'success');
                    } else {
                        throw new Error(data.message || 'Upload failed');
                    }
                } catch (error) {
                    console.error('Upload Error:', error);
                    showAlert(error.message, 'error');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                } finally {
                    state.isLoading = false;
                }
            }

            function addToCompletedTable(doc) {
                if (!elements.completedBody) return;

                const slNo = elements.completedBody.children.length + 1;
                const dateStr = (doc.day && doc.month && doc.year) ? `${doc.day}/${doc.month}/${doc.year}` : 'N/A';
                const uploadTime = doc.upload_time;

                const newRow = document.createElement('tr');
                newRow.className = 'document-row completed-row';
                newRow.setAttribute('data-document-id', doc.id);
                newRow.setAttribute('data-doc-no', doc.doc_no);
                newRow.setAttribute('data-day', doc.day);
                newRow.setAttribute('data-month', doc.month);
                newRow.setAttribute('data-year', doc.year);
                newRow.setAttribute('data-additional-info', doc.additional_info);
                newRow.setAttribute('data-remarks', doc.remarks);

                newRow.innerHTML = `
                    <td class="text-center">${slNo}</td>
                    <td class="doc-name-cell">
                        ${escapeHtml(doc.name)}
                        <span class="status-completed">✓</span>
                    </td>
                    <td><input type="text" class="compact-input" value="${escapeHtml(doc.doc_no)}" disabled></td>
                    <td><input type="text" class="compact-input" value="${escapeHtml(dateStr)}" disabled></td>
                    <td><textarea class="compact-input" rows="1" disabled>${escapeHtml(doc.additional_info)}</textarea></td>
                    <td>
                        ${doc.has_file && doc.file_path ? 
                            `<button type="button" class="btn-preview-sm" onclick="previewCompletedDocument('${doc.file_path}', '${escapeHtml(doc.name)}', '${escapeHtml(doc.doc_no)}', '${escapeHtml(dateStr)}', '${escapeHtml(doc.additional_info)}', '${escapeHtml(doc.remarks)}', '${uploadTime}')">
                                    <i class="fas fa-eye"></i> View
                                </button>` : 
                            '<span class="text-muted">No file</span>'
                        }
                    </td>
                    <td><textarea class="compact-input" rows="1" disabled>${escapeHtml(doc.remarks)}</textarea></td>
                    <td class="upload-time">${uploadTime}</td>
                    <td class="text-center">
                        <button type="button" class="btn-reupload-sm" onclick="openReuploadModal(${doc.id}, '${escapeHtml(doc.name)}')">
                            <i class="fas fa-sync-alt"></i> Re-upload
                        </button>
                    </td>
                `;

                elements.completedBody.appendChild(newRow);
            }

            function init() {
                console.log("Free Hold Upload Handler Initialized");
                cacheElements();
                state.applicantId = document.getElementById('applicantId').value;
                state.uploadPath = document.getElementById('uploadPath').value;

                state.documents = documentList.map(doc => ({
                    id: doc.id,
                    name: doc.document_name,
                    key: doc.document_key,
                    sort_order: doc.sort_order
                }));

                state.completedDocs = completedList.map(doc => ({
                    id: doc.id,
                    name: doc.document_name,
                    doc_no: doc.upload?.doc_no || "",
                    day: doc.upload?.doc_day || "",
                    month: doc.upload?.doc_month || "",
                    year: doc.upload?.doc_year || "",
                    additional_info: doc.upload?.additional_info || "",
                    remarks: doc.upload?.remarks || "",
                    has_file: !!doc.upload?.file_path,
                    file_path: doc.upload?.file_path || null,
                    upload_time: doc.upload?.created_at ? new Date(doc.upload.created_at)
                        .toLocaleString() : null
                }));

                updateProgress();
                loadNextDocument();
            }

            return {
                init,
                showUploadPreview,
                confirmAndUpload,
                addToCompletedTable,
                updateProgress,
                loadNextDocument
            };
        })();

        // Global functions for the handler
        window.showUploadPreview = function(docId) {
            FreeHoldUploadHandler.showUploadPreview(docId);
        };

        window.confirmAndUpload = function(docId) {
            FreeHoldUploadHandler.confirmAndUpload(docId);
        };

        // Pass PHP data to JavaScript
        const documentList = @json($remainingDocuments ?? []);
        const completedList = @json($completedDocuments ?? []);

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            FreeHoldUploadHandler.init();
        });
    </script>
@endsection