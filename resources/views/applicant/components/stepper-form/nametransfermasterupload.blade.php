@extends('applicant.dashboard_layouts.main')

@section('title', 'Allottee - Upload Master File Documents')

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

    .app-shell {
        background: var(--card);
        box-shadow: var(--shadow);
        overflow: hidden;
        border: 1px solid var(--border);
        border-radius: var(--radius);
    }

    .modern-card-header {
        padding: 20px 24px;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
    }

    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0 0 8px 0;
    }

    .header-subtitle {
        font-size: 0.85rem;
        color: #fff7ed;
        margin: 0;
    }

    .app-body {
        padding: 20px 24px;
    }

    .property-summary {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 25px;
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
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--muted);
    }

    .prop-pill-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--ink);
    }

    .documents-table-wrapper {
        overflow-x: auto;
    }

    .document-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .document-table th {
        background: #2a5298;
        color: white;
        padding: 12px 10px;
        font-weight: 600;
        font-size: 13px;
        border: 1px solid #3a6bb5;
    }

    .document-table td {
        padding: 12px 10px;
        border: 1px solid var(--border);
        vertical-align: middle;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge.completed {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.pending {
        background: #fff3cd;
        color: #856404;
    }

    .btn-preview-sm,
    .btn-reupload-sm,
    .btn-upload-sm {
        padding: 5px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-preview-sm {
        background: #17a2b8;
        color: white;
    }

    .btn-preview-sm:hover {
        background: #138496;
    }

    .btn-reupload-sm {
        background: #ffc107;
        color: #000;
    }

    .btn-reupload-sm:hover {
        background: #e0a800;
    }

    .btn-upload-sm {
        background: #28a745;
        color: white;
    }

    .btn-upload-sm:hover {
        background: #218838;
    }

    .btn-info {
        background: #6c757d;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        width: 90%;
        max-width: 750px;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        animation: slideDown 0.3s ease-out;
        max-height: 85vh;
        display: flex;
        flex-direction: column;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
        }
    }

    .modal-header {
        padding: 15px 20px;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
        border-radius: 12px 12px 0 0;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 18px;
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
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .modal-body {
        padding: 20px;
        overflow-y: auto;
        flex: 1;
    }

    .file-preview-area {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        margin-bottom: 20px;
        min-height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed #ccc;
    }

    .file-preview-area img,
    .file-preview-area embed,
    .file-preview-area iframe {
        max-width: 100%;
        max-height: 320px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .preview-details {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }

    .preview-details p {
        margin: 8px 0;
        font-size: 13px;
    }

    .preview-details strong {
        display: inline-block;
        width: 140px;
        color: #555;
    }

    .modal-footer {
        padding: 15px 20px;
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
        margin-right: 10px;
    }

    .btn-primary-modal {
        background: #28a745;
        color: white;
        padding: 8px 24px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
        padding: 8px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .text-center {
        text-align: center;
    }

    @media (max-width: 768px) {
        .app-body {
            padding: 15px;
        }

        .property-summary {
            flex-direction: column;
        }

        .preview-details strong {
            width: 100px;
        }
    }

    .notes-section {
        margin-top: 20px;
        padding: 14px 18px;
        border-radius: 6px;
        border-left: 4px solid #2a5298;
        background: #f4f7fb;
    }

    .notes-section.info {
        border-left-color: #17a2b8;
        background: #e8f7fb;
    }

    .notes-title {
        font-size: 15px;
        font-weight: 600;
        margin: 0 0 6px;
        color: #1e3c72;
    }

    .notes-text {
        font-size: 14px;
        color: #444;
        margin: 0;
        line-height: 1.5;
    }
</style>

<div class="app-shell">
    <div class="modern-card-header">
        <div class="header-flex">
            <div>
                <h1 class="header-title">
                    Master File Documents:
                    <span style="color: #ffd966;">{{ $file->prefix }} {{ $file->allottee_name }} {{ $file->allottee_middle_name }} {{ $file->allottee_surname }}</span>
                </h1>
                <p class="header-subtitle">Upload or re-upload documents for the selected allottee.</p>
            </div>
            <div>
                <a href="{{ route('nametransfer.dataentry.completed') }}">
                    <button class="btn-info">Back</button>
                </a>
            </div>
        </div>
    </div>

    <div class="app-body">
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
                <span class="prop-pill-value">{{ $file->propertyCategory->name ?? 'N/A' }} - <span style="color: green;">{{ $file->propertyType->name ?? 'N/A' }}</span></span>
            </div>
            <div class="prop-pill">
                <span class="prop-pill-label">Quarter Type</span>
                <span class="prop-pill-value">{{ $file->quarterType->quarter_code ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Notes -->
        @if(!empty($fromDataEntry))
        <div class="notes-section info">
            <h3 class="notes-title">Note</h3>
            <p class="notes-text">
                You were redirected here because this allottee’s data entry has already been completed. <span style="color:red;">Please Don't Back !</span>
            </p>
        </div>
        @endif

        <br>

        <div class="documents-table-wrapper">
            <table class="document-table">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="35%">File Label</th>
                        <th width="15%">Status</th>
                        <th width="25%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $index => $doc)
                    @php
                    $isCompleted = false;
                    $completedDoc = null;
                    if (isset($completedDocuments) && count($completedDocuments) > 0) {
                    $completedDoc = collect($completedDocuments)->firstWhere('file_label', $doc['file_label']);
                    if ($completedDoc) {
                    $isCompleted = true;
                    }
                    }
                    @endphp
                    <tr data-file-label="{{ $doc['file_label'] }}"
                        data-allottee-id="{{ $doc['allottee_id'] }}"
                        data-register-allottee-id="{{ $doc['register_allottee_id'] }}">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $doc['file_label'] }}</strong></td>
                        <td class="text-center">
                            @if($isCompleted)
                            <span class="status-badge completed">Completed</span>
                            @else
                            <span class="status-badge pending">Pending</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($isCompleted)
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <!-- <button type="button" class="btn-preview-sm"
                                    onclick="viewDetails('{{ $doc['file_label'] }}', {{ json_encode($completedDoc) }})">
                                    View
                                </button> -->
                                <button type="button" class="btn-reupload-sm"
                                    onclick="openReuploadModal('{{ $doc['file_label'] }}', '{{ $doc['allottee_id'] }}', '{{ $doc['register_allottee_id'] }}')">
                                    Re-upload
                                </button>
                            </div>
                            @else
                            <input type="file" class="hidden-file-input" style="display: none;" accept=".pdf,.jpg,.jpeg,.png, .doc,.docx">
                            <button type="button" class="btn-upload-sm upload-trigger-btn"
                                data-file-label="{{ $doc['file_label'] }}"
                                data-allottee-id="{{ $doc['allottee_id'] }}"
                                data-register-allottee-id="{{ $doc['register_allottee_id'] }}">
                                Upload
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<input type="hidden" id="allotteeId" value="{{ $file['id'] ?? '' }}">
<input type="hidden" id="uploadPath" value="{{ $file['allottee_document_path'] ?? '' }}">
<input type="hidden" id="confirm_received" value="{{ $confirmReceived ?? '' }}">
<input type="hidden" id="confirm_same_allottee_name" value="{{ $confirmSameAllotteeName ?? '' }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    function closeModal() {
        const modal = document.getElementById('dynamicModal');
        if (modal) {
            modal.style.animation = 'fadeOut 0.2s ease-out';
            setTimeout(() => modal.remove(), 200);
        }
    }

    // View completed document details
    window.viewDetails = function(fileLabel, completedDoc) {
        closeModal();

        let previewHtml = '<div class="file-preview-area"><p>No preview available</p></div>';
        if (completedDoc.file_path) {
            const fileExt = (completedDoc.file_path.split('.').pop() || '').toLowerCase();
            const fileUrl = completedDoc.file_path;

            if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'doc', 'docx'].includes(fileExt)) {
                previewHtml = `<div class="file-preview-area"><img src="${escapeHtml(fileUrl)}" alt="Document Preview"></div>`;
            } else if (fileExt === 'pdf') {
                previewHtml = `<div class="file-preview-area"><embed src="${escapeHtml(fileUrl)}" type="application/pdf" width="100%" height="300px"></div>`;
            } else {
                previewHtml = `<div class="file-preview-area"><p>Preview not available. <a href="${escapeHtml(fileUrl)}" target="_blank">View file</a></p></div>`;
            }
        }

        const modalHtml = `
                <div id="dynamicModal" class="modal-overlay" style="display: flex;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Document Details: ${escapeHtml(fileLabel)}</h3>
                            <button class="modal-close" onclick="closeModal()">&times;</button>
                        </div>
                        <div class="modal-body">
                            ${previewHtml}
                            <div class="preview-details">
                                <p><strong>File Label:</strong> ${escapeHtml(fileLabel)}</p>
                                <p><strong>Allottee ID:</strong> ${completedDoc.allottee_id || 'N/A'}</p>
                                <p><strong>Property Number:</strong> ${completedDoc.property_number || 'N/A'}</p>
                                <p><strong>Confirm Received:</strong> ${completedDoc.confirm_received || 'No'}</p>
                                <p><strong>Confirm Same Allottee Name:</strong> ${completedDoc.confirm_same_allottee_name || 'No'}</p>
                                <p><strong>Is Checked:</strong> ${completedDoc.is_checked ? 'Yes' : 'No'}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-danger" onclick="closeModal()">Close</button>
                        </div>
                    </div>
                </div>
            `;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
    };

    // Upload handler - opens file picker, then preview modal, then submit
    document.querySelectorAll('.upload-trigger-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = '.pdf,.jpg,.jpeg,.png,.doc,.docx';
            fileInput.style.display = 'none';
            document.body.appendChild(fileInput);

            fileInput.addEventListener('change', (event) => {
                if (event.target.files.length > 0) {
                    const file = event.target.files[0];
                    const fileLabel = btn.getAttribute('data-file-label');
                    const allotteeId = btn.getAttribute('data-allottee-id');
                    const registerAllotteeId = btn.getAttribute('data-register-allottee-id');

                    // Open preview modal with file for final confirmation
                    openUploadPreviewModal(file, fileLabel, allotteeId, registerAllotteeId);
                }
                fileInput.remove();
            });

            fileInput.click();
        });
    });

    // Open modal with file preview and submit button
    function openUploadPreviewModal(file, fileLabel, allotteeId, registerAllotteeId) {
        closeModal();

        let previewHtml = '';
        const fileType = file.type;
        const fileUrl = URL.createObjectURL(file);
        const fileSizeKB = (file.size / 1024).toFixed(2);

        if (fileType.startsWith('image/')) {
            previewHtml = `<div class="file-preview-area"><img src="${fileUrl}" alt="File Preview"></div>`;
        } else if (fileType === 'application/pdf') {
            previewHtml = `<div class="file-preview-area"><embed src="${fileUrl}" type="application/pdf" width="100%" height="320px"></div>`;
        } else {
            previewHtml = `<div class="file-preview-area"><p>File: ${escapeHtml(file.name)} (${fileSizeKB} KB)</p><p>Preview not available for this file type</p></div>`;
        }

        const modalHtml = `
                <div id="dynamicModal" class="modal-overlay" style="display: flex;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Preview: ${escapeHtml(fileLabel)}</h3>
                            <button class="modal-close" onclick="closeModal()">&times;</button>
                        </div>
                        <div class="modal-body">
                            ${previewHtml}
                            <div class="preview-details">
                                <p><strong>File Label:</strong> ${escapeHtml(fileLabel)}</p>
                                <p><strong>File Name:</strong> ${escapeHtml(file.name)}</p>
                                <p><strong>File Size:</strong> ${fileSizeKB} KB</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary" onclick="closeModal()">Cancel</button>
                            <button class="btn-primary-modal" onclick="submitUpload('${escapeHtml(fileLabel)}', '${escapeHtml(allotteeId)}', '${escapeHtml(registerAllotteeId)}', ${JSON.stringify(file)})">Confirm Upload</button>
                        </div>
                    </div>
                </div>
            `;
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Store file reference for submit function
        window.pendingUploadFile = file;
        window.pendingUploadFileLabel = fileLabel;
        window.pendingUploadAllotteeId = allotteeId;
        window.pendingUploadRegisterAllotteeId = registerAllotteeId;
    }

    window.submitUpload = function(fileLabel, allotteeId, registerAllotteeId, file) {
        const actualFile = window.pendingUploadFile || file;

        if (!actualFile) {
            closeModal();
            return;
        }

        const submitBtn = document.querySelector('#dynamicModal .btn-primary-modal');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Uploading...';

        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('allottee_id', allotteeId);
        formData.append('register_allottee_id', registerAllotteeId);
        formData.append('file_label', fileLabel);
        formData.append('uploadpath', document.getElementById('uploadPath').value);
        formData.append('document_file', actualFile);

        fetch('{{ route("applicant.masterdocuments.store") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    location.reload();
                } else {
                    throw new Error(data.message || 'Upload failed');
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Retry Upload';
                const errorDiv = document.createElement('div');
                errorDiv.style.cssText = 'background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin-top:10px;text-align:center;';
                errorDiv.innerHTML = err.message;
                const modalBody = document.querySelector('#dynamicModal .modal-body');
                if (modalBody && !modalBody.querySelector('.error-message')) {
                    errorDiv.className = 'error-message';
                    modalBody.appendChild(errorDiv);
                }
            });
    };

    // Re-upload modal with file selection and preview
    window.openReuploadModal = function(fileLabel, allotteeId, registerAllotteeId) {
        closeModal();

        const modalHtml = `
                <div id="dynamicModal" class="modal-overlay" style="display: flex;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Re-upload: ${escapeHtml(fileLabel)}</h3>
                            <button class="modal-close" onclick="closeModal()">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 600; display: block; margin-bottom: 5px;">File Label</label>
                                <input type="text" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:5px;background:#f5f5f5;" value="${escapeHtml(fileLabel)}" disabled>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 600; display: block; margin-bottom: 5px;">Select New File</label>
                                <input type="file" id="reuploadFileInput" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:5px;" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <div id="reuploadPreviewContainer" style="display: none;"></div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary" onclick="closeModal()">Cancel</button>
                            <button class="btn-primary-modal" id="confirmReuploadBtn" disabled>Confirm Re-upload</button>
                        </div>
                    </div>
                </div>
            `;
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        const fileInput = document.getElementById('reuploadFileInput');
        const previewContainer = document.getElementById('reuploadPreviewContainer');
        const confirmBtn = document.getElementById('confirmReuploadBtn');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && previewContainer) {
                const fileType = file.type;
                const fileUrl = URL.createObjectURL(file);

                if (fileType.startsWith('image/')) {
                    previewContainer.innerHTML = `<div class="file-preview-area"><img src="${fileUrl}" style="max-width:100%; max-height:250px; border-radius:8px;"></div>`;
                } else if (fileType === 'application/pdf') {
                    previewContainer.innerHTML = `<div class="file-preview-area"><embed src="${fileUrl}" type="application/pdf" width="100%" height="250px"></div>`;
                } else {
                    previewContainer.innerHTML = `<div class="file-preview-area"><p>Selected: ${escapeHtml(file.name)} (${(file.size/1024).toFixed(2)} KB)</p></div>`;
                }
                previewContainer.style.display = 'block';
                confirmBtn.disabled = false;

                window.reuploadFile = file;
            } else {
                previewContainer.style.display = 'none';
                confirmBtn.disabled = true;
            }
        });

        window.reuploadFileLabel = fileLabel;
        window.reuploadAllotteeId = allotteeId;
        window.reuploadRegisterAllotteeId = registerAllotteeId;

        confirmBtn.onclick = function() {
            submitReupload();
        };
    };

    window.submitReupload = function() {
        const file = window.reuploadFile;

        if (!file) {
            return;
        }

        const confirmBtn = document.getElementById('confirmReuploadBtn');
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = 'Uploading...';

        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('allottee_id', window.reuploadAllotteeId);
        formData.append('register_allottee_id', window.reuploadRegisterAllotteeId);
        formData.append('file_label', window.reuploadFileLabel);
        formData.append('uploadpath', document.getElementById('uploadPath').value);
        formData.append('document_file', file);

        fetch('{{ route("applicant.masterdocuments.store") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    location.reload();
                } else {
                    throw new Error(data.message || 'Re-upload failed');
                }
            })
            .catch(err => {
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = 'Retry';
            });
    };
</script>
@endsection