<form id="document-upload-form" action="{{ route('apply-new-licence', 'upload-documents') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="form-step">
        <h3 class="mb-4">Upload Documents</h3>
        <div class="row">
            <h4 class="col-12 mb-3">Personal Documents</h4>

            <div class="col-md-4 mb-3">
                <label for="applicant_photo" class="form-label">Recent Colour Photo <small class="text-danger">*</small>
                    <small class="text-primary">( Max. Size 100kb, Only .jpeg )</small></label>
                <div class="input-group">
                    <input type="file" class="form-control @error('applicant_photo') is-invalid @enderror"
                        id="applicant_photo" name="applicant_photo" accept="image/jpeg, image/jpg" data-max-size="100">
                    @if (isset($data['applicant_photo']))
                        <button class="btn btn-success preview-btn" type="button"
                            data-document-url="{{ asset($data['applicant_photo']->document_path) }}"
                            data-label="Recent Colour Photo">View Document</button>
                    @else
                        <button class="btn btn-outline-secondary preview-btn" type="button"
                            data-label="Recent Colour Photo">View Document</button>
                    @endif
                </div>
                @error('applicant_photo')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="applicant_signature" class="form-label">Signature <small class="text-danger">*</small>
                    <small class="text-primary">( Max. Size 50kb, Only .jpeg )</small></label>
                <div class="input-group">
                    <input type="file" class="form-control @error('applicant_signature') is-invalid @enderror"
                        id="applicant_signature" name="applicant_signature" accept="image/jpeg, image/jpg"
                        data-max-size="50">
                    @if (isset($data['applicant_signature']))
                        <button class="btn btn-success preview-btn" type="button"
                            data-document-url="{{ asset($data['applicant_signature']->document_path) }}"
                            data-label="Signature">View Document</button>
                    @else
                        <button class="btn btn-outline-secondary preview-btn" type="button" data-label="Signature">View
                            Document</button>
                    @endif
                </div>
                @error('applicant_signature')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- <div class="col-md-4 mb-3">
                <label for="attested_applicant_photo" class="form-label">Attested Photo and Signature by the Principal
                    <small class="text-danger">*</small> <small class="text-primary">( Max. Size 200kb, Only
                        .jpeg)</small></label>
                <div class="input-group">
                    <input type="file" class="form-control @error('attested_applicant_photo') is-invalid @enderror"
                        id="attested_applicant_photo" name="attested_applicant_photo" accept="image/jpeg, image/jpg"
                        data-max-size="200">
                    @if (isset($data['attested_applicant_photo']))
                        <button class="btn btn-success preview-btn" type="button"
                            data-document-url="{{ asset($data['attested_applicant_photo']->document_path) }}"
                            data-label="Attested Photo and Signature">View Document</button>
                    @else
                        <button class="btn btn-outline-secondary preview-btn" type="button"
                            data-label="Attested Photo and Signature">View Document</button>
                    @endif
                </div>
                @error('attested_applicant_photo')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div> -->

            <div class="col-md-4 mb-3">
                <label for="aadhaar_card" class="form-label">Aadhaar Card <small class="text-danger">*</small> <small
                        class="text-primary">( Max. Size 200kb, Only .jpeg )</small></label>
                <div class="input-group">
                    <input type="file" class="form-control @error('aadhaar_card') is-invalid @enderror"
                        id="aadhaar_card" name="aadhaar_card" accept=".jpg,.jpeg" data-max-size="200">
                    @if (isset($data['aadhaar_card']))
                        <button class="btn btn-success preview-btn" type="button"
                            data-document-url="{{ asset($data['aadhaar_card']->document_path) }}"
                            data-label="Aadhaar Card">View
                            Document</button>
                    @else
                        <button class="btn btn-outline-secondary preview-btn" type="button"
                            data-label="Aadhaar Card">View
                            Document</button>
                    @endif
                </div>
                @error('aadhaar_card')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            @if (Auth::user()->category == 'ST' || Auth::user()->category == 'SC')
                <div class="col-md-4 mb-3">
                    <label for="caste_certificate" class="form-label">Caste Certificate <small
                            class="text-danger">*</small>
                        <small class="text-primary">( Max. Size 250kb, Only .jpeg )</small></label>
                    <div class="input-group">
                        <input type="file" class="form-control @error('caste_certificate') is-invalid @enderror"
                            id="caste_certificate" name="caste_certificate" accept=".jpg,.jpeg" data-max-size="250">
                        @if (isset($data['caste_certificate']))
                            <button class="btn btn-success preview-btn" type="button"
                                data-document-url="{{ asset($data['caste_certificate']->document_path) }}"
                                data-label="Caste Certificate">View Document</button>
                        @else
                            <button class="btn btn-outline-secondary preview-btn" type="button"
                                data-label="Caste Certificate">View Document</button>
                        @endif
                    </div>
                    @error('caste_certificate')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            @if ($data['course_type'] == 'Certificate')
                <div class="col-md-4 mb-3">
                    <label for="tenth_certificate" class="form-label">Xth Marksheet/Provisional Certificate <small
                            class="text-danger">*</small> <small class="text-primary">( Max. Size 250kb, Only
                            .jpeg)</small></label>
                    <div class="input-group">
                        <input type="file" class="form-control @error('tenth_certificate') is-invalid @enderror"
                            id="tenth_certificate" name="tenth_certificate" accept=".jpg,.jpeg" data-max-size="250">
                        @if (isset($data['tenth_certificate']))
                            <button class="btn btn-success preview-btn" type="button"
                                data-document-url="{{ asset($data['tenth_certificate']->document_path) }}"
                                data-label="Xth Marksheet/Provisional Certificate">View Document</button>
                        @else
                            <button class="btn btn-outline-secondary preview-btn" type="button"
                                data-label="Xth Marksheet/Provisional Certificate">View Document</button>
                        @endif
                    </div>
                    @error('tenth_certificate')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            @elseif($data['course_type'] == 'PG')
                <div class="col-md-4 mb-3">
                    <label for="tenth_certificate" class="form-label">Graduation Marksheet/Provisional Certificate <small
                            class="text-danger">*</small> <small class="text-primary">( Max. Size 250kb, Only
                            .jpeg)</small></label>
                    <div class="input-group">
                        <input type="file" class="form-control @error('tenth_certificate') is-invalid @enderror"
                            id="tenth_certificate" name="tenth_certificate" accept=".jpg,.jpeg" data-max-size="250">
                        @if (isset($data['tenth_certificate']))
                            <button class="btn btn-success preview-btn" type="button"
                                data-document-url="{{ asset($data['tenth_certificate']->document_path) }}"
                                data-label="Graduation Marksheet/Provisional Certificate">View Document</button>
                        @else
                            <button class="btn btn-outline-secondary preview-btn" type="button"
                                data-label="Graduation Marksheet/Provisional Certificate">View Document</button>
                        @endif
                    </div>
                    @error('tenth_certificate')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            @else
                <div class="col-md-4 mb-3">
                    <label for="twelfth_certificate" class="form-label">XII Marksheet <small
                            class="text-danger">*</small> <small class="text-primary">( Max. Size 250kb, Only
                            .jpeg)</small></label>
                    <div class="input-group">
                        <input type="file" class="form-control @error('twelfth_certificate') is-invalid @enderror"
                            id="twelfth_certificate" name="twelfth_certificate" accept=".jpg,.jpeg"
                            data-max-size="250">
                        @if (isset($data['twelfth_certificate']))
                            <button class="btn btn-success preview-btn" type="button"
                                data-document-url="{{ asset($data['twelfth_certificate']->document_path) }}"
                                data-label="XII Marksheet">View Document</button>
                        @else
                            <button class="btn btn-outline-secondary preview-btn" type="button"
                                data-label="XII Marksheet">View Document</button>
                        @endif
                    </div>
                    @error('twelfth_certificate')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            @php
                if ($data['course_type'] == 'Certificate') {
                    $count = '1';
                } elseif ($data['course_type'] == 'Diploma') {
                    $count = '1';
                } else {
                    $count = '6';
                }
            @endphp

            <h4 class="col-12 mt-4 mb-3">Paramedical Passing Year Admit Cards</h4>
            @for ($i = 1; $i <= $count; $i++)
                <div class="col-md-4 mb-3">
                    <label for="admit_card_{{ $i }}" class="form-label">Admit Card -
                        {{ $i }}
                        @if ($i == ceil($count / 2))
                            <small class="text-danger">*</small>
                        @endif <small class="text-primary">( Max. Size 250kb, Only .jpeg )</small>
                    </label>
                    <div class="input-group">
                        <input type="file" class="form-control @error('admit_card_' . $i) is-invalid @enderror"
                            id="admit_card_{{ $i }}" name="admit_card_{{ $i }}"
                            accept=".jpg,.jpeg" data-max-size="250">
                        @if (isset($data['admit_card_' . $i]))
                            <button class="btn btn-success preview-btn" type="button"
                                data-document-url="{{ asset($data['admit_card_' . $i]->document_path) }}"
                                data-label="Admit Card - {{ $i }}">View Document</button>
                        @else
                            <button class="btn btn-outline-secondary preview-btn" type="button"
                                data-label="Admit Card - {{ $i }}">View Document</button>
                        @endif
                    </div>
                    @error('admit_card_' . $i)
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            @endfor

            <h4 class="col-12 mt-4 mb-3">Course Marksheets</h4>
            @for ($i = 1; $i <= $count; $i++)
                <div class="col-md-4 mb-3">
                    <label for="marksheet_{{ $i }}" class="form-label">Marksheet -
                        {{ $i }}
                        @if ($i == ceil($count / 2))
                            <small class="text-danger">*</small>
                        @endif <small class="text-primary">( Max. Size 250kb, Only .jpeg)</small>
                    </label>
                    <div class="input-group">
                        <input type="file" class="form-control @error('marksheet_' . $i) is-invalid @enderror"
                            id="marksheet_{{ $i }}" name="marksheet_{{ $i }}"
                            accept=".jpg,.jpeg" data-max-size="250">
                        @if (isset($data['marksheet_' . $i]))
                            <button class="btn btn-success preview-btn" type="button"
                                data-document-url="{{ asset($data['marksheet_' . $i]->document_path) }}"
                                data-label="Marksheet - {{ $i }}">View Document</button>
                        @else
                            <button class="btn btn-outline-secondary preview-btn" type="button"
                                data-label="Marksheet - {{ $i }}">View Document</button>
                        @endif
                    </div>
                    @error('marksheet_' . $i)
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            @endfor

            <h4 class="col-12 mt-4 mb-3">Provisional Certificates</h4>
            @for ($i = 1; $i <= 1; $i++)
                <div class="col-md-4 mb-3">
                    <label for="provisional_{{ $i }}" class="form-label">Provisional -
                        {{ $i }} <small class="text-danger">*</small> <small class="text-primary">( Max.
                            Size 250kb, Only .jpeg )</small></label>
                    <div class="input-group">
                        <input type="file" class="form-control @error('provisional_' . $i) is-invalid @enderror"
                            id="provisional_{{ $i }}" name="provisional_{{ $i }}"
                            accept=".jpg,.jpeg" data-max-size="250">
                        @if (isset($data['provisional_' . $i]))
                            <button class="btn btn-success preview-btn" type="button"
                                data-document-url="{{ asset($data['provisional_' . $i]->document_path) }}"
                                data-label="Provisional - {{ $i }}">View Document</button>
                        @else
                            <button class="btn btn-outline-secondary preview-btn" type="button"
                                data-label="Provisional - {{ $i }}">View
                                Document</button>
                        @endif
                    </div>
                    @error('provisional_' . $i)
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            @endfor

            {{-- ********************** --}}
            <h4 class="col-12 mt-4 mb-3">Last Issued Certificate</h4>
            <div class="col-md-4 mb-3">
                <label for="last_issued_certificate" class="form-label">Last Issued Certificate <small
                        class="text-danger">*</small> <small class="text-primary">( Max. Size 200kb, Only .jpeg
                        )</small></label>
                <div class="input-group">
                    <input type="file" class="form-control @error('last_issued_certificate') is-invalid @enderror"
                        id="last_issued_certificate" name="last_issued_certificate" accept=".jpg,.jpeg"
                        data-max-size="200">
                    @if (isset($data['last_issued_certificate']))
                        <button class="btn btn-success preview-btn" type="button"
                            data-document-url="{{ asset($data['last_issued_certificate']->document_path) }}"
                            data-label="Last Issued Certificate">View
                            Document</button>
                    @else
                        <button class="btn btn-outline-secondary preview-btn" type="button"
                            data-label="Last Issued Certificate">View
                            Document</button>
                    @endif
                </div>
                @error('last_issued_certificate')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            {{-- ********************** --}}
            @if ($data['passState'] == 'Other')
                <h4 class="col-12 mt-4 mb-3">Other States Applicants</h4>
                <div class="col-md-6 mb-3">
                    <label for="state_council_registration" class="form-label">State Council Registration
                        Certificate <small class="text-danger">*</small> <small class="text-primary">( Max. Size
                            250kb, Only .jpeg )</small></label>
                    <div class="input-group">
                        <input type="file"
                            class="form-control @error('state_council_registration') is-invalid @enderror"
                            id="state_council_registration" name="state_council_registration" accept=".jpg,.jpeg"
                            data-max-size="250">
                        @if (isset($data['state_council_registration']))
                            <button class="btn btn-success preview-btn" type="button"
                                data-document-url="{{ asset($data['state_council_registration']->document_path) }}"
                                data-label="State Council Registration Certificate">View Document</button>
                        @else
                            <button class="btn btn-outline-secondary preview-btn" type="button"
                                data-label="State Council Registration Certificate">View Document</button>
                        @endif
                    </div>
                    @error('state_council_registration')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="state_council_noc" class="form-label">NOC from the State Council <small
                            class="text-danger">*</small> <small class="text-primary">( Max. Size 250kb, Only .jpeg
                            )</small></label>
                    <div class="input-group">
                        <input type="file" class="form-control @error('state_council_noc') is-invalid @enderror"
                            id="state_council_noc" name="state_council_noc" accept=".jpg,.jpeg" data-max-size="250">
                        @if (isset($data['state_council_noc']))
                            <button class="btn btn-success preview-btn" type="button"
                                data-document-url="{{ asset($data['state_council_noc']->document_path) }}"
                                data-label="NOC from the State Council">View Document</button>
                        @else
                            <button class="btn btn-outline-secondary preview-btn" type="button"
                                data-label="NOC from the State Council">View Document</button>
                        @endif
                    </div>
                    @error('state_council_noc')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            @endif
            <h4 class="col-12 mt-4 mb-3">JCECE Documents (if applicable)</h4>
            <div class="col-md-6 mb-3">
                <label for="jcece_practical" class="form-label">JCECE Practical Copy <small class="text-primary">(
                        Max. Size 250kb, Only .jpeg )</small></label>
                <div class="input-group">
                    <input type="file" class="form-control @error('jcece_practical') is-invalid @enderror"
                        id="jcece_practical" name="jcece_practical" accept=".jpg,.jpeg" data-max-size="250">
                    @if (isset($data['jcece_practical']))
                        <button class="btn btn-success preview-btn" type="button"
                            data-document-url="{{ asset($data['jcece_practical']->document_path) }}"
                            data-label="JCECE Practical Copy">View Document</button>
                    @else
                        <button class="btn btn-outline-secondary preview-btn" type="button"
                            data-label="JCECE Practical Copy">View Document</button>
                    @endif
                </div>
                @error('jcece_practical')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="jcece_allotment" class="form-label">JCECE Board Allotment Letter <small
                        class="text-primary">(
                        Max. Size 250kb, Only .jpeg )</small></label>
                <div class="input-group">
                    <input type="file" class="form-control @error('jcece_allotment') is-invalid @enderror"
                        id="jcece_allotment" name="jcece_allotment" accept=".jpg,.jpeg" data-max-size="250">

                    @if (isset($data['jcece_allotment']))
                        <button class="btn btn-success preview-btn" type="button"
                            data-document-url="{{ asset($data['jcece_allotment']->document_path) }}"
                            data-label="JCECE Practical Copy">View Document</button>
                    @else
                        <button class="btn btn-outline-secondary preview-btn" type="button"
                            data-label="JCECE Practical Copy">View Document</button>
                    @endif
                </div>
                @error('jcece_allotment')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <div class="d-flex justify-content-between mt-4">
            <button type="submit" name="previous" class="btn btn-secondary">Previous</button>
            <button type="submit" name="next" class="btn btn-primary">Next</button>
        </div>
    </div>
</form>

<!-- Modal for document preview -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Document Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="preview-content"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/applicant/dashboard/js/uploadDoc.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.step').parent().find('.active').removeClass('active');
            $('.step').eq(2).addClass('active');
        });
    </script>
@endpush
