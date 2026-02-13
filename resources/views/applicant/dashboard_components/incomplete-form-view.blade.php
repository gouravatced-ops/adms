@extends('applicant.dashboard_layouts.main')

@section('title', 'Reverted Forms')

@section('page-title', 'Reverted Documents')

@section('content')
    <form action="{{ route('submit-reverted-form') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible mx-3 mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible mx-3 mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="card-body">
                <div id="table-default" class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><button class="table-sort" data-sort="sort-name">Document Name</button></th>
                                <th><button class="table-sort" data-sort="sort-course-type">Reason</button></th>
                                <th><button class="table-sort" data-sort="sort-course-name">Upload Doc.</button></th>
                                <th><button class="table-sort" data-sort="sort-passing-state">Preview Doc.</button></th>
                                <th><button class="table-sort" data-sort="sort-status">Status</button></th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody">
                            @if ($studentApplications->isEmpty() && $studentPayApplications->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">No records found</td>
                                </tr>
                            @else
                                @if ($studentApplications->isNotEmpty())
                                    @foreach ($studentApplications as $data)
                                        <tr>
                                            <td class="sort-name">
                                                @switch($data->document_name)
                                                    @case('applicant_photo')
                                                        <span>Recent Colour Photo</span>
                                                    @break

                                                    @case('applicant_signature')
                                                        <span>Applicant Signature</span>
                                                    @break

                                                    @case('attested_applicant_photo')
                                                        <span>Attested Photo and Signature by the Principal </span>
                                                    @break

                                                    @case('aadhaar_card')
                                                        <span>Aadhaar Card</span>
                                                    @break

                                                    @case('admit_card_1')
                                                        <span>Paramedical Admit Cards 1 </span>
                                                    @break

                                                    @case('admit_card_2')
                                                        <span>Paramedical Admit Cards 2 </span>
                                                    @break

                                                    @case('admit_card_3')
                                                        <span>Paramedical Admit Cards 3 </span>
                                                    @break

                                                    @case('admit_card_4')
                                                        <span>Paramedical Admit Cards 4 </span>
                                                    @break

                                                    @case('admit_card_5')
                                                        <span>Paramedical Admit Cards 5 </span>
                                                    @break

                                                    @case('admit_card_6')
                                                        <span>Paramedical Admit Cards 6 </span>
                                                    @break

                                                    @case('marksheet_1')
                                                        <span>Course Marksheets 1 </span>
                                                    @break

                                                    @case('marksheet_2')
                                                        <span>Course Marksheets 2 </span>
                                                    @break

                                                    @case('marksheet_3')
                                                        <span>Course Marksheets 3 </span>
                                                    @break

                                                    @case('marksheet_4')
                                                        <span>Course Marksheets 4 </span>
                                                    @break

                                                    @case('marksheet_5')
                                                        <span>Course Marksheets 5 </span>
                                                    @break

                                                    @case('marksheet_6')
                                                        <span>Course Marksheets 6 </span>
                                                    @break

                                                    @case('provisional_1')
                                                        <span>Provisional Certificates </span>
                                                    @break

                                                    @case('state_council_registration')
                                                        <span>State Council Regn. Certificate </span>
                                                    @break

                                                    @case('state_council_noc')
                                                        <span>NOC from the State Council </span>
                                                    @break

                                                    @case('jcece_practical')
                                                        <span>JCECE Practical Copy</span>
                                                    @break

                                                    @case('jcece_practical')
                                                        <span>JCECE Practical Copy</span>
                                                    @break

                                                    @case('tenth_certificate')
                                                        <span>Xth Marksheet/Provisional Certificate </span>
                                                    @break

                                                    @case('twelfth_certificate')
                                                        <span>XIIth Marksheet/Provisional Certificate </span>
                                                    @break

                                                    @case('caste_certificate')
                                                        <span>Caste Certificate </span>
                                                    @break

                                                    @default
                                                        <!-- <span>Something went wrong, please try again</span> -->
                                                @endswitch
                                            </td>
                                            <td class="sort-course-type">{{ $data->reason }}</td>
                                            <td class="sort-course-name">
                                                @if ($data->stu_revert_date == null)
                                                    <input type="file" name="docs[{{ $data->document_name }}]"
                                                        id="file-input-{{ $loop->index }}"
                                                        class="form-control mb-3 file-input" accept=".jpg, .jpeg">
                                                    <span id="file-name-{{ $loop->index }}" class="text-muted"></span>
                                                    <span id="file-error-{{ $loop->index }}" class="text-danger"></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->stu_revert_date == null)
                                                    <img id="image-preview-{{ $loop->index }}" src=""
                                                        alt="Image Preview" class="img-fluid mb-3"
                                                        style="display:none; max-width: 100px; max-height: 100px;" />
                                                    <a href="#" class="btn btn-info preview-link"
                                                        id="preview-link-{{ $loop->index }}" target="_blank"
                                                        style="display:none;">
                                                        Preview
                                                    </a>
                                                @else
                                                    <img id="image-preview-{{ $loop->index }}"
                                                        src="{{ asset($data->document_path) }}" alt="Image Preview"
                                                        class="img-fluid mb-3" max-width: 100px; max-height: 100px;" />
                                                    <a href="{{ asset($data->document_path) }}"
                                                        class="btn btn-info preview-link"
                                                        id="preview-link-{{ $loop->index }}" target="_blank">
                                                        Preview
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="sort-status">
                                                <span class="badge bg-danger-lt">Reverted</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                                @if ($studentPayApplications->isNotEmpty())
                                    <tr>
                                        <td class="sort-name">
                                            <span>Payement Receipt</span>
                                        </td>
                                        <td class="sort-course-type">{{ $studentPayApplications[0]->revert_reason }}</td>
                                        <td class="sort-course-name">
                                            @if ($studentPayApplications[0]->stu_revert_date == null)
                                                <input type="file" name="payDocs" id="file-input-payDocs"
                                                    class="form-control mb-3 file-input" accept=".jpg, .jpeg">
                                                <span id="file-name-payDocs" class="text-muted"></span>
                                                <span id="file-error-payDocs" class="text-danger"></span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($studentPayApplications[0]->stu_revert_date == null)
                                                <img id="image-preview-payDocs" src="" alt="Image Preview"
                                                    class="img-fluid mb-3"
                                                    style="display:none; max-width: 100px; max-height: 100px;" />
                                                <a href="#" class="btn btn-info preview-link"
                                                    id="preview-link-payDocs" target="_blank" style="display:none;">
                                                    Preview
                                                </a>
                                            @else
                                                <img id="image-preview-payDocs"
                                                    src="{{ asset($studentPayApplications[0]->payment_receipt) }}"
                                                    alt="Image Preview" class="img-fluid mb-3" max-width: 100px; max-height:
                                                    100px;" />
                                                <a href="{{ asset($studentPayApplications[0]->payment_receipt) }}"
                                                    class="btn btn-info preview-link" id="preview-link-payDocs"
                                                    target="_blank">
                                                    Preview
                                                </a>
                                            @endif
                                        </td>
                                        <td class="sort-status">
                                            <span class="badge bg-danger-lt">Reverted</span>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @php
            $check = true;
        @endphp

        @foreach ($studentApplications as $data)
            @php
                if ($data->stu_revert_date != null) {
                    $check = false;
                    break;
                }
            @endphp
        @endforeach

        @if ($check)
            <div class="card my-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Declaration</h4>
                </div>
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input @error('declaration') is-invalid @enderror" type="checkbox"
                            name="declaration" id="declaration" required>
                        <input type="hidden" name="applicant"
                            value="{{ $stuAppId }}">
                        <label class="form-check-label" for="declaration">
                            I hereby declare that the information provided above is true and correct to the best of my
                            knowledge.
                        </label>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                    </div>

                </div>
            </div>
        @endif
    </form>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            let selectedFiles = {};

            function checkFileInputs() {
                let allFilesSelected = true;

                $('.file-input').each(function() {
                    if (!$(this).val()) {
                        allFilesSelected = false;
                    }
                });

                if (allFilesSelected) {
                    $('#submitButton').prop('disabled', false);
                } else {
                    $('#submitButton').prop('disabled', true);
                }
            }

            function isDuplicateFile(fileName, index) {
                for (let key in selectedFiles) {
                    if (selectedFiles[key] === fileName && key != index) {
                        return true;
                    }
                }
                return false;
            }

            $('.file-input').on('change', function() {
                const inputId = $(this).attr('id');
                const index = inputId.split('-').pop();

                const fileInput = document.getElementById(inputId);
                const fileNameElement = document.getElementById(`file-name-${index}`);
                const fileErrorElement = document.getElementById(`file-error-${index}`);
                const previewLink = document.getElementById(`preview-link-${index}`);
                const imagePreview = document.getElementById(`image-preview-${index}`);

                fileNameElement.textContent = "";
                fileErrorElement.textContent = "";
                previewLink.style.display = "none";
                imagePreview.style.display = "none";
                imagePreview.src = "";

                const file = fileInput.files[0];
                if (!file) return;

                const validTypes = ['image/jpeg', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    fileErrorElement.textContent = "Only JPEG images are allowed.";
                    fileInput.value = "";
                    return;
                }

                const maxSize = 250 * 1024;
                if (file.size > maxSize) {
                    fileErrorElement.textContent = "File size must be less than or equal to 250KB.";
                    fileInput.value = "";
                    return;
                }

                if (isDuplicateFile(file.name, index)) {
                    fileErrorElement.textContent = "This file has already been selected.";
                    fileInput.value = "";
                    return;
                }

                selectedFiles[index] = file.name;

                fileNameElement.textContent = `Selected file: ${file.name}`;

                const fileURL = URL.createObjectURL(file);
                previewLink.href = fileURL;
                previewLink.style.display = "inline";

                imagePreview.src = fileURL;
                imagePreview.style.display = "block";

                checkFileInputs();
            });

            checkFileInputs();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.step').parent().find('.active').removeClass('active');
            $('.step').eq(2).addClass('active');
        });
    </script>
@endpush
