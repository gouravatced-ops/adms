@extends('admin.layouts.main')

@section('admin-content')
<div class="container-fluid flex-grow-1 ">
    <h6 class="py-3 mb-4"><span class="invert-text-white">Registration Certificate / View Registered Applicant List
    </h6>

    <div class="card mb-4">
        <h5 class="card-header">ACK. NO. : {{ $applicantApplication[0]->acknowledgment_no }} | Name:
            {{ $applicantApplication[0]->name }} | Category: {{ $applicantApplication[0]->category }} | Submission
            DateTime:
            {{ \Carbon\Carbon::parse($applicantApplication[0]->form_submission_date)->format('d-m-Y H:i:s') }}</h5>
        @if (session('success'))
        <div class="alert alert-success alert-dismissible mx-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible mx-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card-body mt-2">
            {{-- Paymennt Details --}}
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="table-responsive mb-3">
                        <table border="1" id="preview-table" width="100%" class="table table-striped table-bordered"
                            style="border-collapse: collapse;page-break-before: always; margin-top:15px;">
                            <thead>
                                <tr>
                                    <th
                                        style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                                        Course Name
                                    </th>
                                    <th
                                        style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                                        Status
                                    </th>
                                    <th
                                        style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                                        Pay. Ref. No.
                                    </th>
                                    <th
                                        style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                                        Pay. Date
                                    </th>
                                    <th
                                        style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                                        Alloted Regn. No.
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @if($prevApplications->isNotEmpty())
                                <tr>
                                    @foreach($prevApplications as $application)
                                    <td>
                                        {{ $application->course_type }} : {{ strtoupper($application->course_name) !=
                                        'OTHER' ? strtoupper($application->course_name) :
                                        strtoupper($application->course_name) . ' - ' .
                                        strtoupper($application->other_course) }}
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill bg-{{ $application['auth_status'] == " reject"
                                            ? 'danger' : ($application['auth_status']=="approved" ? 'success'
                                            : 'warning' ) }}">{{ $application['auth_status'] }}</span>
                                    </td>
                                    <td>
                                        {{ $application['payment_receipt_no'] }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($application->dated)->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        {{ $application['alloted_regn_no'] ?? "----" }}
                                    </td>
                                    @endforeach
                                </tr>
                                @else
                                <tr>
                                    <td colspan="5">-- No Previous Course Found --</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="{{ $applicantApplication[0]->doc_status == 'Revert' ? 'col-md-5' : 'col-md-5' }}">
                    <div class="card">
                        <div class="card-header text-white bg-info">
                            PAYMENT DETAILS / CERTIFICATE HISTORY
                        </div>

                        <div class="card-body mt-3 table-responsive">
                            <table border="0" id="application-table" width="100%" cellpadding="5"
                                style="border-collapse: collapse;font-size:14px;" cellspacing="0">

                                <tr>
                                    <td><b>Amount</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->amount) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Receipt No:</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->payment_receipt_no) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Payment Date</b></td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($applicantApplication[0]->dated)->format('d-m-Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Course Passing State</b></td>
                                    <td>
                                        {{ strtoupper($applicantApplication[0]->passing_state == 'Jharkhand' ?
                                        $applicantApplication[0]->passing_state :
                                        $applicantApplication[0]->pay_other_state_name) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="white-space: nowrap;"><b>Passing Certificate Issue
                                            Date</b></td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($applicantApplication[0]->result_date)->format('d-m-Y')
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Registration applied for</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->course_name) != 'OTHER' ?
                                        strtoupper($applicantApplication[0]->course_name) :
                                        strtoupper($applicantApplication[0]->course_name) . ' - ' .
                                        strtoupper($applicantApplication[0]->other_course) }}
                                    </td>
                                </tr>
                                @if ($applicantApplication[0]->college_name === '999')
                                <tr>
                                    <td><strong>Institute</strong></td>
                                    <td> OTHERS - {{ strtoupper($applicantApplication[0]->jh_other_college_name) }}
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td><strong>Institute</strong></td>
                                    <td> {{ !empty($applicantApplication[0]->institute_name) ?
                                        strtoupper($applicantApplication[0]->institute_name) :
                                        strtoupper($applicantApplication[0]->college_name) }}
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive mb-3">
                                <table border="1" id="preview-table" width="100%"
                                    class="table table-striped table-bordered"
                                    style="border-collapse: collapse;page-break-before: always; margin-top:15px;">
                                    <thead>
                                        <tr>
                                            <th
                                                style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                                                Course Type
                                            </th>
                                            <th
                                                style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                                                Start Date
                                            </th>
                                            <th
                                                style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                                                Expiry Date
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if($certificateHistory->isNotEmpty())

                                        @foreach($certificateHistory as $application)
                                        <tr>
                                            <td>
                                                {{ $application->certificate_type }}
                                            </td>
                                            <td>
                                                {{ $application['cert_start_date'] }}
                                            </td>
                                            <td>
                                                {{ $application['cert_expiry_date'] }}
                                            </td>
                                        </tr>
                                        @endforeach

                                        @else
                                        <tr>
                                            <td colspan="5">-- No Previous Course Found --</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header text-white bg-info">
                            PAYMENT ATTACHMENT
                        </div>
                        <form action="{{ route('payment-action') }}" method="post">
                            @csrf
                            <input type="hidden" name="document_name" value="payment_receipt">
                            <input type="hidden" name="ack_no"
                                value="{{ $applicantApplication[0]->acknowledgment_no }}">

                            <div class="card-body mt-3">

                                {{-- <img id="receipt-image"
                                    src="{{ asset($applicantApplication[0]->payment_receipt) }}"
                                    data-zoom-image="{{ asset($applicantApplication[0]->payment_receipt) }}"
                                    width="100%" /> --}}

                                @php
                                $receiptPath = $applicantApplication[0]->payment_receipt;
                                $fileExtension = pathinfo($receiptPath, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg']))
                                <!-- Display image -->
                                <img id="receipt-image" src="{{ asset($receiptPath) }}" width="auto" height="600px"
                                    alt="Payment Receipt" />
                                @elseif(strtolower($fileExtension) == 'pdf')
                                <!-- Display PDF -->
                                <embed id="receipt-pdf" src="{{ asset($receiptPath) }}" type="application/pdf"
                                    width="100%" height="600px" />
                                @else
                                <p>Unsupported file format.</p>
                                @endif

                                <div class="d-flex justify-content-between mt-2">
                                    <button type="submit" name="accept_pay" class="btn btn-success">Accept</button>
                                    <a href="{{ asset($applicantApplication[0]->payment_receipt) }}"
                                        class="btn btn-info" target="_blank">View Full Screen</a>
                                    <button type="button" id="revert_pay" class="btn btn-warning">Revert
                                        Back</button>
                                </div>
                                <div id="reasonInput" class="mt-2" style="display: none;">
                                    <input type="text" class="form-control" name="reason_pay" id="incompleteReason"
                                        placeholder="Enter reason for Revert Back">
                                    <button type="submit" name="revert_pay" class="btn btn-warning mt-2">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
            {{-- Applicant Details --}}
            <div class="row mb-2">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header text-white bg-info">
                            APPLICANT DETAILS
                        </div>

                        <div class="card-body mt-3 table-responsive">
                            <table border="0" id="application-table" width="100%" cellpadding="5"
                                style="border-collapse: collapse;font-size:14px;" cellspacing="0">

                                <tr>
                                    <td><b>Name</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->name) }} </td>

                                </tr>
                                <tr>
                                    <td><b>Date Of Birth</b></td>
                                    <td>
                                        {{
                                        \Carbon\Carbon::parse($applicantApplication[0]->date_of_birth)->format('d-m-Y')
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Gender</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->gender) }} </td>
                                </tr>
                                <tr>
                                    <td><b>Guardian Type</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->guardian_type) }} </td>
                                </tr>
                                <tr>
                                    <td><b>Guardian's Name</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->father_name) }} </td>
                                </tr>
                                <tr>
                                    <td><b>Category</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->category) }} </td>
                                </tr>
                                <tr>
                                    <td><b>Address</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->address) }} </td>
                                </tr>
                                <tr>
                                    <td><b>City (State)</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->city) }}
                                        ({{ strtoupper($applicantApplication[0]->res_other_state_name) }}) -
                                        {{ strtoupper($applicantApplication[0]->pin_code) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Primary Mobile No.</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->mobile_no) }} </td>
                                </tr>
                                <tr>
                                    <td><b>Alt. Mobile No.</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->alternate_mobile_no) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>WhatsApp Mobile No.</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->whatsapp_no) }} </td>
                                </tr>
                                <tr>
                                    <td><b>E-mail</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->email) }} </td>
                                </tr>
                                <tr>
                                    <td><b>Aadhaar No.</b></td>
                                    <td>{{ strtoupper($applicantApplication[0]->aadhaar) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Course Regn. No./Admit Card No. </b></td>
                                    <td>
                                        {{ strtoupper($applicantApplication[0]->course_registration_no) }} </td>
                                </tr>
                                <tr>
                                    <td><b>Regn. No. </b></td>
                                    <td>
                                        {{ strtoupper($applicantApplication[0]->registration_no) }} </td>
                                </tr>
                                @if ($applicantApplication[0]->passing_state == 'Other')
                                <tr>
                                    <td><b>Council Regn. Certificate No.</b></td>
                                    <td>{{ $applicantApplication[0]->council_regn_no }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>NOC from State Council No.</b></td>
                                    <td>{{ $applicantApplication[0]->noc_state_council }}
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header text-white bg-info" id="document-header">
                            APPLICANT ATTACHMENT
                        </div>
                        <input type="hidden" id="attach_name" name="">
                        <div class="card-body mt-3">

                            <img id="applicant_preview" src="" data-zoom-image="" width="100%" height="650px" />

                            <div class="d-flex justify-content-between mt-2">
                                <button type="submit" name="previous" class="btn btn-success" id="acceptBtn"
                                    style="display: none;">Accept</button>
                                <a href="" class="btn btn-info" target="_blank" style="display: none;"
                                    id="appl_doc_view">View Full Screen</a>
                                <button type="button" class="btn btn-warning" id="incompleteBtn"
                                    style="display: none;">Revert
                                    Back</button>
                            </div>
                            <div id="appReasonInput" class="mt-2" style="display: none;">
                                <input type="text" class="form-control" id="revertReason"
                                    placeholder="Enter reason for revert back">
                                <button type="submit" name="next" class="btn btn-warning mt-2"
                                    id="submitIncomplete">Submit</button>
                            </div>
                            <hr>
                            <div class=" mt-2">
                                @foreach ($applicantApplication as $item)
                                @switch($item->document_name)
                                @case('applicant_photo')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="applicant_photo" data-src="{{ asset($item->document_path) }}">
                                    Recent Colour Photo
                                </button>
                                @break

                                @case('applicant_signature')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="applicant_signature" data-src="{{ asset($item->document_path) }}">
                                    Applicant Signature
                                </button>
                                @break

                                @case('attested_applicant_photo')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="attested_applicant_photo"
                                    data-src="{{ asset($item->document_path) }}">
                                    Attested Photo and Signature by the Principal
                                </button>
                                @break

                                @case('aadhaar_card')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="aadhaar_card" data-src="{{ asset($item->document_path) }}">
                                    Aadhaar Card
                                </button>
                                @break

                                @case('admit_card_1')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="admit_card_1" data-src="{{ asset($item->document_path) }}">
                                    Paramedical Admit Cards 1
                                </button>
                                @break

                                @case('admit_card_2')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="admit_card_2" data-src="{{ asset($item->document_path) }}">
                                    Paramedical Admit Cards 2
                                </button>
                                @break

                                @case('admit_card_3')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="admit_card_3" data-src="{{ asset($item->document_path) }}">
                                    Paramedical Admit Cards 3
                                </button>
                                @break

                                @case('admit_card_4')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="admit_card_4" data-src="{{ asset($item->document_path) }}">
                                    Paramedical Admit Cards 4
                                </button>
                                @break

                                @case('admit_card_5')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="admit_card_5" data-src="{{ asset($item->document_path) }}">
                                    Paramedical Admit Cards 5
                                </button>
                                @break

                                @case('admit_card_6')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="admit_card_6" data-src="{{ asset($item->document_path) }}">
                                    Paramedical Admit Cards 6
                                </button>
                                @break

                                @case('marksheet_1')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="marksheet_1" data-src="{{ asset($item->document_path) }}">
                                    Course Marksheets 1
                                </button>
                                @break

                                @case('marksheet_2')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="marksheet_2" data-src="{{ asset($item->document_path) }}">
                                    Course Marksheets 2
                                </button>
                                @break

                                @case('marksheet_3')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="marksheet_3" data-src="{{ asset($item->document_path) }}">
                                    Course Marksheets 3
                                </button>
                                @break

                                @case('marksheet_4')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="marksheet_4" data-src="{{ asset($item->document_path) }}">
                                    Course Marksheets 4
                                </button>
                                @break

                                @case('marksheet_5')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="marksheet_5" data-src="{{ asset($item->document_path) }}">
                                    Course Marksheets 5
                                </button>
                                @break

                                @case('marksheet_6')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="marksheet_6" data-src="{{ asset($item->document_path) }}">
                                    Course Marksheets 6
                                </button>
                                @break

                                @case('provisional_1')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="provisional_1" data-src="{{ asset($item->document_path) }}">
                                    Provisional Certificates
                                </button>
                                @break

                                @case('state_council_registration')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="state_council_registration"
                                    data-src="{{ asset($item->document_path) }}">
                                    State Council Regn. Certificate
                                </button>
                                @break

                                @case('state_council_noc')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="state_council_noc" data-src="{{ asset($item->document_path) }}">
                                    NOC from the State Council
                                </button>
                                @break

                                @case('jcece_practical')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="jcece_practical" data-src="{{ asset($item->document_path) }}">
                                    JCECE Practical Copy
                                </button>
                                @break

                                @case('jcece_allotment')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="jcece_allotment" data-src="{{ asset($item->document_path) }}">
                                    JCECE Board Allotment Letter
                                </button>
                                @break

                                @case('tenth_certificate')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="tenth_certificate" data-src="{{ asset($item->document_path) }}">
                                    Xth Marksheet/Provisional Certificate
                                </button>
                                @break

                                @case('twelfth_certificate')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="twelfth_certificate" data-src="{{ asset($item->document_path) }}">
                                    XIIth Marksheet/Provisional Certificate
                                </button>
                                @break

                                @case('caste_certificate')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="caste_certificate" data-src="{{ asset($item->document_path) }}">
                                    Caste Certificate
                                </button>
                                @break

                                @case('last_issued_certificate')
                                <button type="button"
                                    class="btn {{ $item->status == 'Revert' ? 'btn-danger' : ($item->status == 'Accept' ? 'btn-success' : 'btn-primary') }} mb-2 document-btn"
                                    data-document="last_issued_certificate"
                                    data-src="{{ asset($item->document_path) }}">
                                    Last Isssued Certificate
                                </button>
                                @break

                                @default
                                <!-- Something went wrong, please try again -->
                                @endswitch
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table border="1" id="preview-table" width="100%" class="table table-striped table-bordered"
                    style="border-collapse: collapse;page-break-before: always; margin-top:15px;">
                    <thead>
                        <tr>
                            <th
                                style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                                Document Name
                            </th>
                            <th
                                style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                                Is Uploaded
                            </th>
                            <th
                                style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                                Status
                            </th>
                            <th
                                style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                                Reason
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 10px;">
                                <strong>Payment Receipt</strong>
                            </td>
                            <td style="padding: 10px;">
                                <strong>{{ !empty($applicantApplication[0]->payment_receipt) ? 'Yes' : 'No' }}</strong>
                            </td>
                            <td style="padding: 10px;">
                                <span
                                    class="badge rounded-pill {{ $applicantApplication[0]->doc_status == 'Accept' ? 'bg-success' : ($applicantApplication[0]->doc_status == 'Revert' ? 'bg-danger' : 'bg-secondary') }}">{{
                                    $applicantApplication[0]->doc_status }}</span>
                            </td>
                            <td style="padding: 10px;">
                                <span>{{ !empty($applicantApplication[0]->revert_reason) ?
                                    $applicantApplication[0]->revert_reason : '----' }}</span>
                            </td>
                        </tr>
                        @php
                        $isAcceptAll = true;
                        $isPending = false;
                        @endphp

                        @foreach ($applicantApplication as $index => $doc)
                        @php
                        if ($doc->status !== 'Accept') {
                        $isAcceptAll = false;
                        }

                        if ($doc->status == 'Pending') {
                        $isPending = true;
                        }

                        // echo $doc->document_name . '-->' . $doc->id;

                        @endphp
                        <tr>
                            <td style="padding: 10px;">
                                <strong>
                                    @switch($doc->document_name)
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

                                    @case('jcece_allotment')
                                    <span>JCECE Board Allotment Letter</span>
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

                                    @case('last_issued_certificate')
                                    <span>Last Issued Certificate </span>
                                    @break

                                    @default
                                    <!-- <span>Something went wrong, please try again</span> -->
                                    @endswitch
                                </strong>
                            </td>

                            <td style="padding: 10px;">
                                <strong>
                                    @switch($doc->document_name)
                                    @case('applicant_photo')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('applicant_signature')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('attested_applicant_photo')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('aadhaar_card')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('admit_card_1')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('admit_card_2')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('admit_card_3')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('admit_card_4')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('admit_card_5')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('admit_card_6')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('marksheet_1')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('marksheet_2')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('marksheet_3')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('marksheet_4')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('marksheet_5')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('marksheet_6')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('provisional_1')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('last_issued_certificate')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('state_council_registration')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('state_council_noc')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('jcece_practical')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('jcece_allotment')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('tenth_certificate')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('twelfth_certificate')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @case('caste_certificate')
                                    {{ !empty($doc->document_path) ? 'Yes' : 'No' }}
                                    @break

                                    @default
                                    <!-- <span>Something went wrong, please try again</span> -->
                                    @endswitch
                                </strong>
                            </td>

                            <td style="padding: 10px;">

                                @switch($doc->document_name)
                                @case('applicant_photo')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('applicant_signature')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('attested_applicant_photo')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('aadhaar_card')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('admit_card_1')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('admit_card_2')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('admit_card_3')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('admit_card_4')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('admit_card_5')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('admit_card_6')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('marksheet_1')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('marksheet_2')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('marksheet_3')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('marksheet_4')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('marksheet_5')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('marksheet_6')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('provisional_1')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('last_issued_certificate')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('state_council_registration')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('state_council_noc')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('jcece_practical')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('jcece_allotment')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('tenth_certificate')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('twelfth_certificate')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @case('caste_certificate')
                                <span
                                    class="badge rounded-pill {{ $doc->status == 'Revert' ? 'bg-danger' : ($doc->status == 'Accept' ? 'bg-success' : 'bg-secondary') }}">{{
                                    $doc->status }}</span>
                                @break

                                @default
                                <!-- <span>Something went wrong, please try again</span> -->
                                @endswitch

                            </td>

                            <td style="padding: 10px;">
                                <span>
                                    @switch($doc->document_name)
                                    @case('applicant_photo')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('applicant_signature')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('attested_applicant_photo')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('aadhaar_card')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('admit_card_1')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('admit_card_2')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('admit_card_3')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('admit_card_4')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('admit_card_5')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('admit_card_6')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('marksheet_1')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('marksheet_2')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('marksheet_3')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('marksheet_4')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('marksheet_5')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('marksheet_6')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('provisional_1')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('state_council_registration')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('state_council_noc')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('jcece_practical')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('jcece_allotment')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('tenth_certificate')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('twelfth_certificate')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('caste_certificate')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('caste_certificate')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @case('last_issued_certificate')
                                    {{ !empty($doc->reason) ? $doc->reason : '----' }}
                                    @break

                                    @default
                                    <!-- <span>Something went wrong, please try again</span> -->
                                    @endswitch
                                </span>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <form action="{{ route('aplication-change-status') }}" method="POST">
                @csrf

                @php
                if ($applicantApplication[0]->doc_status !== 'Accept') {
                $isAcceptAll = false;
                }

                if ($applicantApplication[0]->doc_status == 'Pending') {
                $isPending = true;
                }
                @endphp
                <div class="d-flex justify-content-between mt-3">
                    <input type="hidden" name="ack_no" value="{{ $applicantApplication[0]->acknowledgment_no }}">
                    @if ($isAcceptAll)
                    <button type="submit" name="verified" class="btn btn-success" name="verifyBtn"
                        id="verifyBtn">Approve</button>
                    @else
                    <button type="submit" class="btn btn-warning" name="incompleteBtn" id="incompleteBtn" {{ $isPending
                        ? 'disabled' : '' }}>Incomplete</button>

                    <button type="button" class="btn btn-danger" name="reject" {{ $isPending ? 'disabled' : '' }}
                        id="reject">Reject</button>

                    {{-- <button type="submit" class="btn btn-danger" name="rejectBtn" id="rejectBtn" {{ $isPending
                        ? 'disabled' : '' }}>Reject</button> --}}

                    <button type="submit" class="btn btn-danger mx-2" name="rejectBtn" {{ $isPending ? 'disabled' : ''
                        }} id="rejectBtn" style="display: none">Reject</button>

                    <input type="text" name="reject_reason" class="form-control" id="reject_reason" {{ $isPending
                        ? 'disabled' : '' }} style="display: none" disabled placeholder="Reject Reason">
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/3.0.8/jquery.elevatezoom.min.js"></script>

<script>
    $('#receipt-image').elevateZoom({
        zoomType: "lens",
        lensShape: "square",
        lensSize: 150,
        scrollZoom: true
    });

    function initZoom() {
        $('#applicant_preview').elevateZoom({
            zoomType: "lens",
            lensShape: "square",
            lensSize: 150,
            scrollZoom: true
        });
    }

    // Initialize zoom on page load
    $(document).ready(function () {
        initZoom();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.document-btn');
        const preview = document.getElementById('applicant_preview');
        const header = document.getElementById('document-header');
        const attachName = document.getElementById('attach_name');
        const incompleteBtn = document.getElementById('incompleteBtn');
        const acceptBtn = document.getElementById('acceptBtn');
        const reasonInput = document.getElementById('reasonInput');
        const appReasonInput = document.getElementById('appReasonInput');
        const submitIncomplete = document.getElementById('submitIncomplete');
        const fullscreenDoc = document.getElementById('appl_doc_view');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                // Reset all buttons to their original state
                buttons.forEach(btn => btn.classList.replace('btn-secondary', 'btn-primary'));

                // Change the clicked button to secondary color
                this.classList.replace('btn-primary', 'btn-secondary');

                // Update the image source
                preview.src = this.getAttribute('data-src');
                preview.setAttribute('data-zoom-image', this.getAttribute('data-src'));

                fullscreenDoc.setAttribute('href', this.getAttribute('data-src'));
                fullscreenDoc.style.display = 'block';

                incompleteBtn.style.display = 'block';

                acceptBtn.style.display = 'block';

                attachName.value = this.getAttribute('data-document');
                // Update the header text
                header.textContent = this.textContent.trim();

                $('#applicant_preview').removeData('elevateZoom').elevateZoom({
                    zoomType: "lens",
                    lensShape: "square",
                    lensSize: 300,
                    scrollZoom: true
                });

                // Reinitialize zoom after a short delay to ensure the new image is loaded
                setTimeout(function () {
                    initZoom();
                }, 100);
            });
        });


        @if ($applicantApplication[0] -> doc_status == 'Revert')
            document.getElementById('revert_pay').addEventListener('click', function () {
                reasonInput.style.display = 'block';
            })
        @endif

        incompleteBtn.addEventListener('click', function () {
            appReasonInput.style.display = 'block';

            submitIncomplete.addEventListener('click', function () {
                const reason = document.getElementById('revertReason').value;
                if (reason.trim() === '') {
                    alert('Please enter a reason for revert back.');
                    return;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content');

                const attachName = document.getElementById('attach_name').value;
                $.ajax({
                    url: '/admin/submit-incomplete-reason',
                    method: 'POST',
                    data: {
                        ack_no: {{ $applicantApplication[0]-> acknowledgment_no }},
                reason: reason,
                document_name: attachName
                        },
            headers: {
            'X-CSRF-TOKEN': csrfToken
        },
            success: function (response) {
                if (response.success) {
                    alert('Marked Incompleted successfully.');
                    location.reload(true);
                    // const activeButton = document.querySelector(
                    //     '.document-btn.btn-secondary');
                    // if (activeButton) {
                    //     activeButton.classList.remove('btn-primary',
                    //         'btn-secondary');
                    //     activeButton.classList.add('btn-danger');
                    // }

                    // document.getElementById('incompleteReason').value = '';
                    // reasonInput.style.display = 'none';
                    // document.getElementById('verifyBtn').style.display =
                    //     'none';
                } else {
                    alert('Failed to submit reason. Please try again.');
                    location.reload(true);
                }
            },
            error: function (xhr, status, error) {
                // console.error('Error submitting reason:', error);
                alert(
                    'An error occurred while submitting the reason. Please try again.'
                );
            }
                    });
                });
            });

    acceptBtn.addEventListener('click', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')
            .getAttribute('content');

        const attachName = document.getElementById('attach_name').value;
        $.ajax({
            url: '/admin/submit-accept-doc',
            method: 'POST',
            data: {
                ack_no: {{ $applicantApplication[0]-> acknowledgment_no }},
        document_name: attachName
                    },
        headers: {
        'X-CSRF-TOKEN': csrfToken
    },
        success: function (response) {
            if (response.success) {
                alert('Marked Accepted successfully.');
                location.reload(true);
                // const activeButton = document.querySelector(
                //     '.document-btn.btn-secondary');
                // if (activeButton) {
                //     activeButton.classList.remove('btn-primary',
                //         'btn-secondary');
                //     activeButton.classList.add('btn-success');
                // }

                // document.getElementById('incompleteReason').value = '';
                // reasonInput.style.display = 'none';
                // document.getElementById('verifyBtn').style.display =
                //     'none';
                // document.getElementById('rejectBtn').style.display =
                //     'block';
            } else {
                alert('Failed to accept document. Please try again.');
                location.reload(true);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error submitting accept:', error);
            alert(
                'An error occurred while accepting the documents. Please try again.'
            );
        }
                });
            });

    document.getElementById('reject').addEventListener('click', function () {
        const rejectReasonInput = document.getElementById('reject_reason');
        rejectReasonInput.style.display = 'block';
        rejectReasonInput.disabled = false;
        document.getElementById('rejectBtn').style.display = 'block';
        document.getElementById('reject').style.display = 'none';
    });

        });
</script>
@endpush