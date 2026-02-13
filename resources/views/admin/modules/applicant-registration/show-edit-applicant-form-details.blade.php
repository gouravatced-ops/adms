@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 ">
        <h6 class="py-3 mb-4"><span class="invert-text-white">Registration Certificate / Edit Accepted Aplicant Details
            </span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Edit Accepted Applicant Details <small>(Double-click the box to
                    enable editing)</small></h5>

            <h5 class="mx-4 my-2 text-center text-primary">ACK. NO. : {{ $application->acknowledgment_no }} | Name:
                {{ $application->name }} | Category: {{ $application->category }} | Submission
                DateTime:
                {{ \Carbon\Carbon::parse($application->form_submission_date)->format('d-m-Y H:i:s') }}
            </h5>

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

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible mx-3 mt-3" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-body mt-2">

                <h6>1. Payment Details</h6>
                <hr class="mt-0">

                <div class="payment-details">
                    <form id="paymentForm" method="POST" action="{{ route('payment.update', $payment->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4 mb-2 col-sm-12">
                                <label for="amount">Amount</label>
                                <input type="text" id="amount" class="form-control @error('amount') is-invalid @enderror"
                                    name="amount" value="{{ $payment->amount }}" readonly>
                                @error('state')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-2 col-sm-12">
                                <label for="payment_receipt_no">Receipt No</label>
                                <input type="text" id="payment_receipt_no"
                                    class="form-control @error('payment_receipt_no') is-invalid @enderror"
                                    name="payment_receipt_no" value="{{ $payment->payment_receipt_no }}" readonly>
                                @error('state')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-2 col-sm-12">
                                <label for="dated">Payment Date</label>
                                <input type="date" id="dated" class="form-control @error('dated') is-invalid @enderror"
                                    name="dated" value="{{ $payment->dated }}" readonly>
                                @error('state')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-2 col-sm-12">
                                <label for="result_date">Passing Certificate Issue Date</label>
                                <input type="date" id="result_date"
                                    class="form-control @error('result_date') is-invalid @enderror" name="result_date"
                                    value="{{ $payment->result_date }}" readonly>
                                @error('state')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-2 col-sm-12">
                                <label for="registration_no">Registration No.</label>
                                <input type="text" id="registration_no"
                                    class="form-control @error('registration_no') is-invalid @enderror"
                                    name="registration_no" value="{{ $payment->registration_no }}" readonly>
                                @error('state')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-2 col-sm-12">
                                <label for="passing_state">Passing State</label>
                                <select id="passing_state" class="form-control @error('passing_state') is-invalid @enderror"
                                    name="passing_state" readonly>
                                    <option value="Jharkhand" {{ $payment->passing_state == 'Jharkhand' ? 'selected' : ''
                                                                        }}>
                                        Jharkhand</option>
                                    <option value="Other" {{ $payment->passing_state == 'Other' ? 'selected' : '' }}>Other
                                        State</option>
                                </select>
                                @error('state')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 {{ old('otherState', isset($application['passing_state']) === 'Other' ? '' : 'd-none') }}"
                                id="otherStateDiv">
                                <label for="otherState">Other State</label>

                                <select name="other_state" id="otherState"
                                    class="form-select  @error('other_state') is-invalid @enderror">

                                </select>

                                @error('otherState')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success d-none my-4 col-md-2" id="savePaymentButton">Save
                                Payment</button>
                        </div>
                    </form>
                </div>

                <h6 class="mt-2">2. Applicant Details</h6>
                <hr class="mt-0">

                <form id="applicantForm" method="POST" action="{{ route('applicant.update', $application->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4 mb-2 form-group">
                            <label for="course_type">Type of Course</label>
                            <select name="course_type" id="course_type" class="form-control" readonly>
                                <option value="Diploma" {{ old('course_type', $application['course_type'] ?? '') == 'Diploma'
        ? 'selected="selected"' : '' }}>
                                    Diploma</option>
                                <option value="Certificate" {{ old(
        'course_type',
        $application['course_type'] ?? ''
    ) == 'Certificate' ? 'selected="selected"' : '' }}>
                                    Certificate</option>
                                <option value="Bachelor" {{ old(
        'course_type',
        $application['course_type'] ?? ''
    ) == 'Bachelor' ? 'selected="selected"' : '' }}>
                                    Bachelor</option>
                            </select>
                            @error('course_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-2 form-group">
                            <label for="course_id">Name of Course</label>

                            <select name="course_id" id="course_id"
                                class="form-control  @error('course_id') is-invalid @enderror" readonly>

                            </select>
                            @error('course_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-2" id="collegeNameContainer">

                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="course_registration_no">Course Registration No. / Admit Card No. <small
                                    class="text-danger">*</small> </label>
                            <input type="text" name="course_registration_no" id="course_registration_no"
                                class="form-control @error('course_registration_no') is-invalid @enderror"
                                value="{{ old('course_registration_no', isset($application['course_registration_no']) ? $application['course_registration_no'] : '') }}">
                            @error('course_registration_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="guardian_type">Guardian's Type</label>
                            <select class="form-control" id="guardian_type" name="guardian_type" readonly>
                                <option value="husband" {{ $application->guardian_type == 'husband' ? 'selected' : '' }}>
                                    Husband
                                </option>
                                <option value="father" {{ $application->guardian_type == 'father' ? 'selected' : '' }}>Father
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="father_name">Guardian's Name</label>
                            <input type="text" class="form-control" id="father_name" name="father_name"
                                value="{{ $application->father_name }}" readonly>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4 mb-2">
                            <label for="address">Address for Correspondence</label>
                            <textarea class="form-control" id="address" name="address"
                                readonly>{{ $application->address }}</textarea>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ $application->city }}"
                                readonly>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="state">State</label>
                            <select name="state" id="state" class="form-control  @error('state') is-invalid @enderror"
                                readonly>
                            </select>
                            @error('state')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="pin_code">Pin Code</label>
                            <input type="text" class="form-control" id="pin_code" name="pin_code"
                                value="{{ $application->pin_code }}" readonly>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="alternate_mobile_no">Alternate Mobile No. <small class="text-danger">*</small>
                            </label>
                            <input type="tel" name="alternate_mobile_no" id="alternate_mobile_no"
                                class="form-control @error('alternate_mobile_no') is-invalid @enderror" maxlength="10"
                                value="{{ old('alternate_mobile_no', isset($application['alternate_mobile_no']) ? $application['alternate_mobile_no'] : '') }}">
                            @error('alternate_mobile_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="whatsapp_no">WhatsApp No.</label>
                            <input type="tel" name="whatsapp_no" id="whatsapp_no"
                                class="form-control @error('whatsapp_no') is-invalid @enderror" pattern="[0-9]{10}"
                                maxlength="10"
                                value="{{ old('whatsapp_no', isset($application['whatsapp_no']) ? $application['whatsapp_no'] : '') }}">
                            @error('whatsapp_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="email">Email ID</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', isset($application['email']) ? $application['email'] : '') }}">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row mb-3 d-none" id="otherStateDivs">
                            <div class="col-md-4 mb-2">
                                <label for="council_regn">State Council Registration Document No. <small
                                        class="text-danger">*</small>
                                </label>
                                <input type="text" name="council_regn" id="council_regn"
                                    class="form-control @error('council_regn') is-invalid @enderror"
                                    value="{{ old('council_regn', isset($application['council_regn_no']) ? $application['council_regn_no'] : '') }}"
                                    disabled>
                                @error('council_regn')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="noc_council">NOC from the State Council Document No. <small
                                        class="text-danger">*</small>
                                </label>
                                <input type="text" name="noc_council" id="noc_council"
                                    class="form-control @error('noc_council') is-invalid @enderror"
                                    value="{{ old('noc_council', isset($application['noc_state_council']) ? $application['noc_state_council'] : '') }}"
                                    disabled>
                                @error('noc_council')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success d-none my-4 col-md-2" id="saveApplicantButton">Save
                            Applicant Detail</button>
                    </div>
                </form>

                <h6 class="my-2">3. Applicant Files</h6>
                <hr class="mt-0">

                <div class="row">
                    <h6 class="col-12 mb-3">Personal Documents</h6>
                    <input type="hidden" id="app_id" value="{{$application->id}}">

                    <div class="col-md-4 mb-3">
                        <label for="payment_receipt" class="form-label">Payment Receipt <small class="text-danger">*</small>
                            <small class="text-primary">( Max. Size 1000kb, Only .jpeg, .pdf )</small></label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('payment_receipt') is-invalid @enderror"
                                id="payment_receipt" name="payment_receipt" accept="image/jpeg, image/jpg, application/pdf"
                                data-max-size="1000">
                            @if (isset($payment['payment_receipt']))
                                <button class="btn btn-success preview-btn" type="button"
                                    data-document-url="{{ asset($payment['payment_receipt']) }}"
                                    data-label="Payment Receipt">View Document</button>
                            @else
                                <button class="btn btn-outline-secondary preview-btn" type="button"
                                    data-label="Payment Receipt">View Document</button>
                            @endif
                        </div>
                        @error('payment_receipt')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="applicant_photo" class="form-label">Recent Colour Photo <small
                                class="text-danger">*</small>
                            <small class="text-primary">( Max. Size 100kb, Only .jpeg )</small></label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('applicant_photo') is-invalid @enderror"
                                id="applicant_photo" name="applicant_photo" accept="image/jpeg, image/jpg"
                                data-max-size="100">
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
                        <label for="aadhaar_card" class="form-label">Aadhaar Card <small class="text-danger">*</small>
                            <small class="text-primary">( Max. Size 200kb, Only .jpeg )</small></label>
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

                    @if ($application['category'] == 'ST' || $application['category'] == 'SC')
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

                    @if ($application['course_type'] == 'Certificate')
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
                    @elseif($application['course_type'] == 'PG')
                        <div class="col-md-4 mb-3">
                            <label for="tenth_certificate" class="form-label">Graduation Marksheet/Provisional Certificate
                                <small class="text-danger">*</small> <small class="text-primary">( Max. Size 250kb, Only
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
                                    id="twelfth_certificate" name="twelfth_certificate" accept=".jpg,.jpeg" data-max-size="250">
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
                        if ($application['course_type'] == 'Certificate') {
                            $count = '1';
                        } elseif ($application['course_type'] == 'Diploma') {
                            $count = '1';
                        } else {
                            $count = '6';
                        }
                    @endphp

                    <h6 class="col-12 mt-4 mb-3">Paramedical Passing Year Admit Cards</h6>
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
                                    id="admit_card_{{ $i }}" name="admit_card_{{ $i }}" accept=".jpg,.jpeg" data-max-size="250">
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

                    <h6 class="col-12 mt-4 mb-3">Course Marksheets</h6>
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
                                    id="marksheet_{{ $i }}" name="marksheet_{{ $i }}" accept=".jpg,.jpeg" data-max-size="250">
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

                    <h6 class="col-12 mt-4 mb-3">Provisional Certificates</h6>
                    @for ($i = 1; $i <= 1; $i++)
                        <div class="col-md-4 mb-3">
                            <label for="provisional_{{ $i }}" class="form-label">Provisional -
                                {{ $i }} <small class="text-danger">*</small> <small class="text-primary">( Max.
                                    Size 250kb, Only .jpeg )</small></label>
                            <div class="input-group">
                                <input type="file" class="form-control @error('provisional_' . $i) is-invalid @enderror"
                                    id="provisional_{{ $i }}" name="provisional_{{ $i }}" accept=".jpg,.jpeg"
                                    data-max-size="250">
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
                    <h6 class="col-12 mt-4 mb-3">Last Issued Certificate</h6>
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
                    @if ($payment->passing_state == 'Other')
                        <h6 class="col-12 mt-4 mb-3">Other States Applicants</h6>
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
                    <h6 class="col-12 mt-4 mb-3">JCECE Documents (if applicable)</h6>
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

                <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel"
                    aria-hidden="true">
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
            </div>
        </div>
    </div>
    </div>
@endsection

@push('script')

    <script src="{{ asset('assets/admin/js/uploadDoc.js') }}"></script>

    <script>
        $(document).ready(function () {

            function getPassingState() {
                $.ajax({
                    url: "{{ route('admin-get-state') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#otherState').empty();
                        $('#otherState').append('<option value="">Select State</option>');

                        $.each(data.states, function (index, state) {
                            if (state.id != '10') {
                                var selected = (state.id ==
                                    "{{ old('otherState', $payment['other_state'] ?? '') }}"
                                ) ? 'selected' : '';
                                $('#otherState').append('<option value="' + state.id +
                                    '" ' +
                                    selected + '>' + state.name + '</option>');
                            }
                        });
                    }
                });
            }

            $('#passing_state').on('change', function () {
                if ($("#passing_state :selected").val() == 'Other') {
                    getPassingState();
                    $("#otherStateDiv").removeClass('d-none');
                } else {

                    $("#otherStateDiv").addClass('d-none');
                }
            });

            if ($('#passing_state :selected').val() === 'Other') {
                $("#otherStateDiv").removeClass('d-none');
                getPassingState();
            }

        });
    </script>
    <script>
        // $(document).ready(function () {
        function enableEditing(formField, saveButton) {
            $(formField).on('dblclick', function () {
                $(this).prop('readonly', false).removeClass('form-control').addClass(
                    'form-control');
                $(saveButton).removeClass('d-none');
            });
        }

        enableEditing('#amount', '#savePaymentButton');
        enableEditing('#payment_receipt_no', '#savePaymentButton');
        enableEditing('#dated', '#savePaymentButton');
        enableEditing('#result_date', '#savePaymentButton');
        enableEditing('#registration_no', '#savePaymentButton');
        enableEditing('#otherState', '#savePaymentButton');

        $('#passing_state').on('dblclick', function () {
            $(this).prop('disabled', false).removeClass('form-control').addClass(
                'form-control');
            $('#savePaymentButton').removeClass('d-none');
        });

        enableEditing('#guardian_type', '#saveApplicantButton');
        enableEditing('#father_name', '#saveApplicantButton');
        enableEditing('#address', '#saveApplicantButton');
        enableEditing('#city', '#saveApplicantButton');
        enableEditing('#res_other_state_name', '#saveApplicantButton');
        enableEditing('#pin_code', '#saveApplicantButton');
        enableEditing('#alternate_mobile_no', '#saveApplicantButton');
        enableEditing('#whatsapp', '#saveApplicantButton');
        enableEditing('#email', '#saveApplicantButton');
        enableEditing('#council_regn', '#saveApplicantButton');
        enableEditing('#noc_council', '#saveApplicantButton');
        enableEditing('#course_type', '#saveApplicantButton');
        enableEditing('#course_id', '#saveApplicantButton');
        enableEditing('#college_name', '#saveApplicantButton');
        enableEditing('#jh_other_college_name', '#saveApplicantButton');
        enableEditing('#course_registration_no', '#saveApplicantButton');

        function getCheckOther() {
            $.ajax({
                url: "{{ route('admin-get-check-other') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token
                    pay_id: "{{ $payment['id'] }}",
                },
                success: function (data) {
                    if (data.status === true) {
                        $("#otherStateDivs").removeClass('d-none').find('input').removeAttr(
                            'disabled');

                        var collegeNameField = `
                                                            <div class="form-group">
                                                                <label for="college_name">Name of the College</label>
                                                                <input type="text" name="college_name" id="college_name"
                                                                    class="form-control @error('college_name') is-invalid @enderror"
                                                                    value="{{ old('college_name', isset($application['college_name']) ? $application['college_name'] : '') }}">
                                                                @error('college_name')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>`;
                    } else {
                        var collegeNameField = `
                                                            <div class="form-group">
                                                                <label for="college_name">Name of the College</label>
                                                                 <select name="college_name" id="college_name" class="form-control  @error('college_name') is-invalid @enderror">
                                                                 </select>
                                                                @error('college_name')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>`;

                        getInstitute();
                    }
                    $("#collegeNameContainer").empty();
                    $('#collegeNameContainer').append(collegeNameField);
                    enableEditing('#college_name', '#saveApplicantButton');
                }
            });
        }

        function getState() {
            $.ajax({
                url: "{{ route('admin-get-state') }}",
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#state').empty();
                    $('#state').append('<option value="">Select State</option>');

                    $.each(data.states, function (index, state) {

                        var selected = (state.id ==
                            "{{ old('state', $application['state'] ?? '') }}"
                        ) ? 'selected' : '';
                        $('#state').append('<option value="' + state.id +
                            '" ' +
                            selected + '>' + state.name + '</option>');
                    });

                }
            });
        }

        function getCourse() {
            var courseTypeId = $("#course_type").val();
            if (courseTypeId) {
                $.ajax({
                    url: "{{ route('admin-get-courses', ['id' => ':id']) }}".replace(':id', courseTypeId),
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#course_id').empty();
                        $('#course_id').append('<option value="">Select Course Name</option>');

                        $.each(data.course_names, function (index, course) {
                            var selected = (course.id ==
                                "{{ old('course_id', $application['course_id'] ?? '') }}"
                            ) ? 'selected' : '';
                            $('#course_id').append('<option value="' + course.id + '" ' +
                                selected + '>' + course.course_name + '</option>');
                        });
                        otherCourse();
                    }
                });
            } else {
                $('#course_id').empty();
                $('#course_id').append('<option value="">Select Course Name</option>');
            }
        }

        function getInstitute() {
            $.ajax({
                url: "{{ route('admin-get-college-name') }}",
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#college_name').empty();
                    $('#college_name').append('<option value="">Select College Name</option>');

                    $.each(data.institutes, function (index, inst) {
                        var selected = (inst.institute_id ==
                            "{{ old('college_id', $application['college_name'] ?? '') }}"
                        ) ? 'selected' : '';

                        $('#college_name').append('<option value="' + inst.institute_id +
                            '" ' +
                            selected + '>' + inst.name + '</option>');
                    });

                    var selectedOther = (999 ==
                        "{{ old('college_name', $application['college_name'] ?? '') }}"
                    ) ? 'selected' : '';

                    $('#college_name').append('<option value="999" ' + selectedOther +
                        '>Others</option>');
                    otherCollege();
                }
            });
        }

        function otherCourse() {
            var course_id = $("#course_id").find(':selected').text();

            $('#other_course_group').remove();

            if (course_id == 'Other') {
                var otherCourse = `
                                                    <div class="form-group col-md-4 mb-2" id="other_course_group">
                                                        <label for="other_course">Other Course Name</label>
                                                        <input type="text" name="other_course" id="other_course" class="form-control @error('other_course') is-invalid @enderror"
                                                           value="{{ old('other_course', isset($application['other_course']) ? $application['other_course'] : '') }}">
                                                        @error('other_course')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>`;
                $("#course_id").closest('.form-group').after(otherCourse);

                enableEditing('#other_course', '#saveApplicantButton');
            }
        }

        function otherCollege() {
            var college_name = $("#college_name").find(':selected').val();
            $('#other_college').remove();
            if (college_name === '999') {
                var collegeOtherNameField = `
                                                    <div class="col-md-4 mb-2" id="other_college">
                                                        <div class="form-group">
                                                            <label for="jh_other_college_name">Name of the Other College</label>
                                                            <input type="text" name="jh_other_college_name" id="jh_other_college_name"
                                                                class="form-control @error('jh_other_college_name') is-invalid @enderror"
                                                                value="{{ old('jh_other_college_name', isset($application['jh_other_college_name']) ? $application['jh_other_college_name'] : '') }}">
                                                            @error('jh_other_college_name')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>`;
                $("#collegeNameContainer").after(collegeOtherNameField);

                enableEditing('#jh_other_college_name', '#saveApplicantButton');
            }
        }

        $('#course_type').on('change', function () {
            getCourse();
        });
        $('#course_id').on('change', function () {
            otherCourse();
        });
        $(document).on('change', '#college_name', function () {
            otherCollege();
        });

        getCheckOther();
        getCourse();
        getState();
        // });

    </script>
@endpush