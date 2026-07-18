@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Master PDF Uploads</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Master PDF Uploads</h5>

            <div class="card-body mt-2">
                @php
                    #return getDebugIndex($registrations);
                @endphp
                {{-- Alerts --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        {{ session('success') }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        {{ session('error') }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="allLotsListTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sl.No.</th>
                                <th>Lot</th>
                                <th>Register</th>
                                <th>Div. / Sub Div.</th>
                                <th>Type</th>
                                <th>Prop. No.</th>
                                <th>Allottee</th>
                                <th>Files</th>
                                <th>File Name</th>
                                <th>Uploads</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($masterFiles as $key => $item)
                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        {{ $item->lot_no }}
                                    </td>

                                    <td>
                                        {{ $item->register_no }}
                                    </td>

                                    <td>
                                        {{ $item->division_name }}/{{ $item->subdivision_name }}
                                    </td>

                                    <td>
                                        {{ $item->property_type }}
                                        {{ $item->quarter_code ? '- ' . $item->quarter_code : '' }}
                                    </td>

                                    <td>
                                        {{ $item->property_number }}
                                    </td>

                                    <td>
                                        {{ $item->full_name }}
                                    </td>

                                    <td>
                                        {{ $item->file_label }}
                                    </td>

                                    <td>
                                        <a href="{{ asset($item->file_path) }}" target="_blank"
                                            class="text-primary fw-semibold">

                                            {{ $item->file_name }}
                                        </a>
                                    </td>

                                    <td>
                                        {{ formatDate($item->uploaded_at) }}
                                    </td>

                                    {{-- Status --}}
                                    <td>

                                        @if ($item->is_reupload == 1)
                                            <span class="badge bg-success">
                                                ✓ Re Uploaded
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Pending
                                            </span>
                                        @endif

                                    </td>

                                    <td class="text-center">

                                        {{-- Reupload --}}
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#reUploadModal" data-id="{{ $item->encrypted_id }}"
                                            data-file="{{ asset($item->file_path) }}" data-name="{{ $item->file_name }}">

                                            <i class="bx bx-upload"></i>
                                        </button>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="12" class="text-center text-muted">
                                        No Files Found.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ReUpload Modal --}}
    <div class="modal fade" id="reUploadModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl">

            <form action="{{ route('admin.master.file.reupload') }}" method="POST" enctype="multipart/form-data"
                class="modal-content">

                @csrf

                <div class="modal-header bg-primary" style="padding: 10px;">

                    <h5 class="modal-title text-white">
                        Re Upload Master PDF
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="master_id" id="master_id">

                    <div class="row">

                        {{-- Selected PDF Preview --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Selected PDF Preview
                            </label>

                            <iframe id="selected_pdf_preview" src="" width="100%" height="500"
                                style="border:1px solid #ddd;border-radius:8px;">
                            </iframe>

                        </div>

                        {{-- New PDF --}}
                        <div class="col-md-6">

                            {{-- File Name --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Current File Name
                                </label>

                                <input type="text" id="current_file_name" class="form-control bg-light" readonly>
                            </div>

                            {{-- Rename --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Rename File
                                </label>

                                <input type="text" name="rename_file" id="rename_file" class="form-control"
                                    placeholder="Enter New File Name">
                            </div>

                            {{-- Upload --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Select New PDF
                                </label>

                                <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept=".pdf"
                                    required>
                            </div>

                            {{-- New Preview --}}
                            <div>

                                <label class="form-label fw-semibold">
                                    Current PDF
                                </label>

                                <iframe id="current_pdf_preview" src="" width="100%" height="300"
                                    style="border:1px solid #ddd;border-radius:8px;">
                                </iframe>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary">

                        <i class="bx bx-upload"></i>
                        &nbsp; Re Upload PDF
                    </button>

                </div>

            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const modal = document.getElementById('reUploadModal');

            // Open Modal
            modal.addEventListener('show.bs.modal', function(event) {

                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');
                const file = button.getAttribute('data-file');
                const name = button.getAttribute('data-name');

                // Set Values
                document.getElementById('master_id').value = id;

                document.getElementById('current_file_name').value = name;

                document.getElementById('rename_file').value = name;

                // Current PDF Preview
                document.getElementById('current_pdf_preview').src = file;

                // Reset Selected Preview
                document.getElementById('selected_pdf_preview').src = '';
            });

            // Selected File Preview
            document.getElementById('pdf_file').addEventListener('change', function(e) {

                const file = e.target.files[0];

                if (file) {

                    const fileURL = URL.createObjectURL(file);

                    document.getElementById('selected_pdf_preview').src = fileURL;
                }
            });

        });
    </script>
@endsection
