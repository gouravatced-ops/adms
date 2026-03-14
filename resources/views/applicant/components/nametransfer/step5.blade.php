{{-- Step 6: Document Upload Form --}}
@php
    #return getDebugIndex($applicant);
@endphp
{{-- Completed Documents Table --}}
<?php if(count($completedDocuments) > 0 ) { ?>
<div class="documents-section" style="margin-bottom:20px;">

    <h4 style="margin:0 0 10px;font-size:14px;color:#aa7700;border-bottom:1px solid #aa7700;padding-bottom:5px;">
        Uploaded Documents
    </h4>

    <table class="document-table" style="width:100%;border-collapse:collapse;font-size:13px;">
        <thead>
            <tr>
                <th style="padding:8px 5px;border:1px solid #ddd;width:5%;">Sl.</th>
                <th style="padding:8px 5px;border:1px solid #ddd;width:11%;">Document</th>
                <th style="padding:8px 5px;border:1px solid #ddd;width:12%;">Doc No.</th>
                <th style="padding:8px 5px;border:1px solid #ddd;width:10%;">Date</th>
                <th style="padding:8px 5px;border:1px solid #ddd;width:15%;">Additional Info</th>
                <th style="padding:8px 5px;border:1px solid #ddd;width:18%;">File</th>
                <th style="padding:8px 5px;border:1px solid #ddd;width:25%;">Remarks</th>
            </tr>
        </thead>

        <tbody id="uploadedDocumentRows">

            @forelse($completedDocuments as $index => $doc)
                <tr class="document-row completed-row" data-document-id="{{ $doc->document_id }}"
                    data-file-path="{{ $doc->file_path }}" data-file-name="{{ $doc->file_name }}">

                    <td style="padding:8px 5px;border:1px solid #ddd;text-align:center;">
                        <span class="sl-badge">{{ $index + 1 }}</span>
                    </td>

                    <td style="padding:8px 5px;border:1px solid #ddd;">
                        {{ $doc->name }}
                        <span class="status-completed" style="margin-left:5px;">✓</span>
                    </td>

                    <td style="padding:8px 5px;border:1px solid #ddd;">
                        {{ $doc->doc_no ?? 'N/A' }}
                    </td>

                    <td style="padding:8px 5px;border:1px solid #ddd;">
                        {{-- {{ $doc->doc_day }}/{{ $doc->doc_month }}/{{ $doc->doc_year }} --}} N/A
                    </td>

                    <td style="padding:8px 5px;border:1px solid #ddd;">
                        {{ $doc->additional_info ?? 'N/A' }}
                    </td>

                    <td style="padding:8px 5px;border:1px solid #ddd;">

                        @if ($doc->file_name)
                            <div>
                                <small>📄</small>

                                <a href="{{ asset($doc->file_path) }}" target="_blank" class="btn-link"
                                    style="margin-left:5px;color:#0066cc;">
                                    View
                                </a>
                            </div>
                        @else
                            <small>No file</small>
                        @endif

                    </td>

                    <td style="padding:8px 5px;border:1px solid #ddd;">
                        {{ $doc->remarks ?? 'N/A' }}
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:15px;">
                        No uploaded documents found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<?php } ?>

{{-- Document Upload Section --}}
<div class="form-section">
    <div class="form-block" style="padding: 15px;">
        {{-- Progress Bar --}}
        <div id="uploadProgress" style="margin-bottom: 15px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 5px; font-size:12px;">
                <span>Progress</span>
                <span id="progressCount">0/0</span>
            </div>
            <div style="height: 6px; background: #e0e0e0; border-radius: 3px; overflow: hidden;">
                <div id="progressBar" style="height: 100%; background: #aa7700; width: 0%; transition: width 0.3s;">
                </div>
            </div>
        </div>

        {{-- Basic Documents Table --}}
        <div class="documents-section" style="margin-bottom: 20px;">
            <h4
                style="margin: 0 0 10px; font-size:14px; color:#aa7700; border-bottom:1px solid #aa7700; padding-bottom:5px;">
                Name Transfer Document
            </h4>
            <table class="document-table" style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr>
                        <th style="padding:8px 5px; border:1px solid #ddd; width:5%;">Sl.</th>
                        <th style="padding:8px 5px;border:1px solid #ddd;width: 11%;">Document</th>
                        <th style="padding:8px 5px; border:1px solid #ddd; width:12%;">Doc No.</th>
                        <th style="padding:8px 5px;border:1px solid #ddd;width: 10%;">Date</th>
                        <th style="padding:8px 5px;border:1px solid #ddd;width: 15%;">Additional Information</th>
                        <th style="padding:8px 5px; border:1px solid #ddd; width:18%;">File</th>
                        <th style="padding:8px 5px;border:1px solid #ddd;width: 25%;">Remarks</th>
                        <th style="padding:8px 5px; border:1px solid #ddd; width:10%;">Action</th>
                    </tr>
                </thead>
                <tbody id="nameTransferDocumentRows"></tbody>
            </table>
        </div>

        <form id="step5Form" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="allottee_id" id="applicant_id" value="{{ $applicant->id ?? '' }}">
            <meta name="csrf-token" content="{{ csrf_token() }}">
                
            {{-- Name Transfer Question --}}
            <div id="nameTransferSection" style="margin:15px 0; padding:12px; background:#f9f9f9; border-radius:4px;">
                <div style="display:flex; align-items:center; gap:15px;">
                    <label style="font-weight:600; font-size:13px;">Is this a Name Transfer case?</label>
                    <select id="nametransferValue" name="nametransferValue" class="custom-select"
                        style="width:150px; padding:5px; border:1px solid #ddd; border-radius:4px;">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .document-table {
        width: 100%;
        border-collapse: collapse;
    }

    .document-table td {
        padding: 8px 5px;
        border: 1px solid #ddd;
        vertical-align: middle;
    }

    .document-row {
        transition: all 0.2s ease;
    }

    .document-row.current-row {
        background-color: #fffde7;
    }

    .document-row.completed-row {
        background-color: #f8f9fa;
    }

    .document-row.completed-row input,
    .document-row.completed-row select,
    .document-row.completed-row textarea,
    .document-row.completed-row .file-input {
        background-color: #e9ecef;
        opacity: 0.7;
        pointer-events: none;
    }

    .doc-name-cell {
        font-weight: 500;
        font-size: 12px;
        padding: 5px !important;
        background: #fafafa;
        position: relative;
    }

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

    .compact-input {
        width: 100%;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 12px;
        box-sizing: border-box;
    }

    .compact-input:focus {
        border-color: #aa7700;
        outline: none;
        box-shadow: 0 0 0 2px rgba(170, 119, 0, 0.1);
    }

    .compact-input.error {
        border-color: #dc3545;
        background-color: #fff8f8;
    }

    .file-input {
        width: 100%;
        padding: 3px;
        font-size: 11px;
        border: 1px solid #ddd;
        border-radius: 3px;
    }

    .btn-submit {
        padding: 5px 10px;
        background: #aa7700;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 12px;
        width: 100%;
        transition: all 0.2s;
    }

    .btn-submit:hover:not(:disabled) {
        background: #8b6200;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-submit:disabled {
        background: #cccccc;
        cursor: not-allowed;
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
        font-size: 11px;
        margin-left: 5px;
    }

    .remarks-field {
        width: 100%;
        background: #fff3cd;
    }

    .validation-message {
        color: #dc3545;
        font-size: 10px;
        margin-top: 2px;
    }

    /* Name Transfer Form Styles */
    #newAllotteeForm {
        animation: slideDown 0.3s ease-out;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
        padding: 20px;
        background: #fff;
        border: 1px solid #aa7700;
        border-radius: 4px;
    }

    #newAllotteeForm .form-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .document-table {
            font-size: 11px;
        }

        .compact-input {
            font-size: 11px;
            padding: 4px;
        }

        #newAllotteeForm .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        #newAllotteeForm .form-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Print Styles */
    @media print {

        .btn-submit,
        .file-input,
        .remarks-field {
            display: none;
        }
    }
</style>
