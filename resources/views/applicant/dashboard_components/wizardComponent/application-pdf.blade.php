{{-- {{dd($app['document']['applicant_photo']['document_path'])}} --}}

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style>
        body {
            margin-top: 5px;
            font-size: 16px;
        }

        #application-table,
        #preview-table {
            border: 1px solid #69676724;
        }

        #application-table td,
        #preview-table td,
        #preview-table hr {
            border: 1px solid #69676724;
        }

        #application-table img {
            border: 2px solid #000;
            margin-top: 5px;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 30px;
            line-height: 30px;
            border-top: 1px solid #000;
            background: white;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div style="width:100%">
        <table style="font-size:18px; border:0px solid" cellpadding="5" width="98%">
            <tbody>
                <tr style="text-align:center">
                    <td width="1%"></td>
                    <td width="15%"><img src="{{ public_path('assets/applicant/auth/images/jharkhand_logo_in.png') }}"
                            height="75px" width="75px" style="position:relative !important;margin-top:-0px;"></td>
                    <td width="68%">
                        <span style="Font-weight:900;font-size:19px;color:#6c130e">JHARKHAND STATE PARAMEDICAL
                            COUNCIL</span>
                        <br />
                        <span style="Font-weight:700;font-size:15px;color:#7d7b7b">RIMS Doctors' Colony Campus, Bariatu,
                            <br /> Ranchi - 834009, Jharkhand, India
                        </span>
                        <br /><br />
                        <span style="font-weight:700;font-size:16px;color:#000; padding-top:25px;"><u>APPLICATION
                                FORM</u></span><br>
                    </td>
                    <td width="15%"><img src="{{ public_path('assets/applicant/auth/images/jspc_logo_in.png') }}"
                            height="75px" width="75px" style="position:relative !important;margin-top:-0px;"></td>
                    <td width="1%"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <table border="1" id="application-table" width="100%" cellpadding="5"
        style="border-collapse: collapse;font-size:14px;" cellspacing="0">

        <tr>
            <td width="30%" colspan="1"><strong>Acknowledgement Number</strong></td>
            <td colspan="2">{{ $app['studentApplication']['acknowledgment_no'] }}</td>
            <td rowspan="7" align="center" style="padding: 0; vertical-align: middle;">
                <img src="{{ public_path($app['document']['applicant_photo']['document_path']) }}"
                    style="width: 135px; height: 135px; object-fit: cover; border: 2px solid #000; margin-top: 5px;">
                <img src="{{ public_path($app['document']['applicant_signature']['document_path']) }}"
                    style="height: 45px; width: 135px; border: 2px solid #000; margin-top: 5px;">
            </td>
        </tr>
        <tr>
            <td width="30%" colspan="1"><strong>Registration applied for</strong></td>
            <!-- <td colspan="2">{{ strtoupper($app['studentApplication']->course_name) }}
                ( {{ strtoupper($app['studentApplication']['course_type']) }} )</td> -->
            <td colspan="2">
                {{ $app['studentApplication']->course_name != 'Other' ? strtoupper($app['studentApplication']->course_name) : strtoupper($app['studentApplication']->course_name) . ' - ' . strtoupper($app['studentApplication']->other_course) }}
                ({{ strtoupper($app['studentApplication']['course_type']) }})
            </td>
        </tr>
        <tr>
            <td colspan="1"><strong>Aadhaar No. </strong></td>
            <td colspan="2">{{ strtoupper($app['studentApplication']['aadhaar']) }}</td>
        </tr>
        <tr>
            <td colspan="1"><strong>Name</strong></td>
            <td colspan="2">{{ strtoupper($app['studentApplication']['name']) }} </td>
        </tr>
        <tr>
            <td colspan="1"><strong>Father's/Husband Name </strong></td>
            <td colspan="2">{{ strtoupper($app['studentApplication']['father_name']) }}</td>
        </tr>
        <tr>
            <td colspan="1"><strong>Date Of Birth </strong></td>
            <td colspan="2">{{ \Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('d-m-Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="1"><strong>Course Regn. No./Admit Card No. </strong></td>
            <td colspan="2">{{ $app['studentApplication']['course_registration_no'] }}</td>
        </tr>
        <tr>
            <td width="30%" colspan="1"><strong>Category </strong></td>
            <td>{{ strtoupper($app['studentApplication']['category']) }} </td>
            <td><strong>Gender </strong></td>
            <td>{{ strtoupper($app['studentApplication']['gender']) }} </td>
        </tr>
        @if ($app['studentApplication']->college_name === '999')
            <tr style="border: 1px solid #69676724;">
                <td colspan="1" style="border: 1px solid #69676724;"><strong>Name of the Institute</strong></td>
                <td colspan="3" style="border: 1px solid #69676724;">
                    OTHERS - {{ strtoupper($app['studentApplication']->jh_other_college_name) }}
                </td>
            </tr>
        @else
            <tr style="border: 1px solid #69676724;">
                <td colspan="1" style="border: 1px solid #69676724;"><strong>Name of the Institute</strong></td>
                <td colspan="3" style="border: 1px solid #69676724;">
                    {{ !empty($app['studentApplication']->inst_name) ? strtoupper($app['studentApplication']->inst_name) : strtoupper($app['studentApplication']->college_name) }}
                </td>
            </tr>
        @endif
        <tr>
            <td style="white-space: nowrap;"><b>Primary Mobile No.</b></td>
            <td style="white-space: nowrap;">{{ strtoupper($app['studentApplication']['mobile_no']) }}</td>
            <td style="white-space: nowrap;"><b>Alt. Mobile No.</b></td>
            <td style="white-space: nowrap;">
                {{ strtoupper(empty($app['studentApplication']['alternate_mobile_no']) ? 'NA' : $app['studentApplication']['alternate_mobile_no']) }}
            </td>
        </tr>
        <tr>
            <td><b>WhatsApp Mobile No.</b></td>
            <td>{{ strtoupper(empty($app['studentApplication']['whatsapp_no']) ? 'NA' : $app['studentApplication']['whatsapp_no']) }}
            </td>
            <td><b>Email ID</b></td>
            <td>{{ strtoupper(empty($app['studentApplication']['email']) ? 'NA' : $app['studentApplication']['email']) }}
            </td>
        </tr>
        <tr>
            <td><b>Course Passing State</b></td>
            <td>{{ strtoupper($app['payment']['passing_state'] == 'Jharkhand' ? $app['payment']['passing_state'] : $app['passState']->name) }}
            </td>
            <td style="white-space: nowrap;"><b>Passing Certificate Issue Date</b></td>
            <td>
                {{ \Carbon\Carbon::parse($app['payment']['result_date'])->format('d-m-Y') }}
            </td>
        </tr>
        <tr>
            <td><b>Registration No.</b></td>
            <td>{{ strtoupper($app['payment']['registration_no']) }}</td>
               <td><b>Pin Code</b></td>
            <td>{{ strtoupper($app['studentApplication']['pin_code']) }}</td>
        </tr>
        <tr>
            <td><b>Address</b></td>
            <td colspan="3">{{ strtoupper($app['studentApplication']['address']) }}</td>

        </tr>
        <tr>
            <td><b>City (State)</b></td>
            <td colspan="3">{{ strtoupper($app['studentApplication']['city']) }}
                ({{ strtoupper($app['resState']->name) }})
            </td>
        </tr>

        @if ($app['payment']['passing_state'] == 'Other')
            <tr>
                <td><b>Council Regn. Certificate No.</b></td>
                <td>{{ $app['studentApplication']['council_regn_no'] }}
                </td>
                <td><b>NOC from State Council</b></td>
                <td>{{ $app['studentApplication']['noc_state_council'] }}
                </td>
            </tr>
        @endif
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;" colspan="4" style="background-color: #f2f2f2;"><strong>CERTIFICATE HISTORY</strong></td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="1" id="application-table" width="100%" cellpadding="5"
                    style="border-collapse: collapse;font-size:13px;" cellspacing="0">
                   
                        <tr>
                            <td><b>Type</b></td>
                            <td><b>Start Date</b></td>
                            <td><b>Expiry Date</b></td>
                        </tr>
                    
                        @foreach($app['certificateHistory'] as $history)
                        <tr>
                            <td>{{ $history['certificate_type'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($history['cert_start_date'])->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($history['cert_expiry_date'])->format('d-m-Y') }}</td>
                        </tr>
                        @endforeach
                    
                </table>
            </td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;" colspan="4" style="background-color: #f2f2f2;"><strong>PAYMENT
                    DETAILS</strong></td>
        </tr>

        <tr>
            <td><b>Amount</b></td>
            <td>{{ strtoupper($app['payment']['amount']) }}
            </td>
            <td><b>Receipt No:</b></td>
            <td>{{ strtoupper($app['payment']['payment_receipt_no']) }}
            </td>
        </tr>
        <tr>
            <td><b>Payment Date</b></td>
            <td>
                {{ \Carbon\Carbon::parse($app['payment']['dated'])->format('d-m-Y') }}
            </td>
            <td><b>Upload Payment Receipt </b></td>
            <td>{{ isset($app['payment']['payment_receipt']) && !empty($app['payment']['payment_receipt']) ? 'YES' : 'NO' }}
            </td>
        </tr>

        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;" colspan="4" style="background-color: #f2f2f2;"><strong>ATTACHED
                    DOCUMENTS</strong></td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="1" id="application-table" width="100%" cellpadding="5"
                    style="border-collapse: collapse;font-size:13px;" cellspacing="0">
                    <tr>
                        <td><strong>Recent Colour Photo</strong></td>
                        <td>{{ isset($app['document']['applicant_photo']) && !empty($app['document']['applicant_photo']['document_path']) ? 'Yes' : 'No' }}
                        </td>
                        <td><strong>Signature</strong></td>
                        <td>{{ isset($app['document']['applicant_signature']) && !empty($app['document']['applicant_signature']['document_path']) ? 'Yes' : 'NO' }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Aadhaar</strong></td>
                        <td>{{ isset($app['document']['aadhaar_card']) && !empty($app['document']['aadhaar_card']['document_path']) ? 'Yes' : 'No' }}
                        </td>
                        <td><strong>{{ strtoupper($app['studentApplication']['course_type']) == 'CERTIFICATE' ? 'Xth Marksheet ' : 'XIIth Marksheet ' }}</strong>
                        </td>
                        <td>{{ $app['studentApplication']['course_type'] == 'CERTIFICATE' ? (isset($app['document']['tenth_certificate']) && !empty($app['document']['tenth_certificate']['document_path']) ? 'Yes' : 'NO') : (isset($app['document']['twelfth_certificate']) && !empty($app['document']['twelfth_certificate']['document_path']) ? 'Yes' : 'NO') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"><strong>Attested Photo and Signature by the Principal </strong></td>
                        <td colspan="1">
                            {{ isset($app['document']['attested_applicant_photo']) && !empty($app['document']['attested_applicant_photo']['document_path']) ? 'Yes' : 'No' }}
                        </td>
                        <td><strong>Provisional Certificates</strong></td>
                        <td>{{ isset($app['document']['provisional_1']) && !empty($app['document']['provisional_1']['document_path']) ? 'Yes' : 'No' }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Paramedical Admit Cards 1 </strong></td>
                        <td>{{ isset($app['document']['admit_card_1']) && !empty($app['document']['admit_card_1']['document_path']) ? 'Yes' : 'No' }}
                        </td>
                        <td><strong>Paramedical Admit Cards 2 </strong></td>
                        <td>{{ isset($app['document']['admit_card_2']) && !empty($app['document']['admit_card_2']['document_path']) ? 'Yes' : 'No' }}
                        </td>
                    </tr>

                    @if ($app['studentApplication']['course_type'] == 'Diploma' || $app['studentApplication']['course_type'] == 'Bachelor')
                        <tr>
                            <td><strong>Paramedical Admit Cards 3 </strong></td>
                            <td>{{ isset($app['document']['admit_card_3']) && !empty($app['document']['admit_card_3']['document_path']) ? 'Yes' : 'No' }}
                            </td>
                            <td><strong>Paramedical Admit Cards 4 </strong></td>
                            <td>{{ isset($app['document']['admit_card_4']) && !empty($app['document']['admit_card_4']['document_path']) ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                    @endif

                    @if ($app['studentApplication']['course_type'] == 'Bachelor')
                        <tr>
                            <td><strong>Paramedical Admit Cards 5 </strong></td>
                            <td>{{ isset($app['document']['admit_card_5']) && !empty($app['document']['admit_card_5']['document_path']) ? 'Yes' : 'No' }}
                            </td>
                            <td><strong>Paramedical Admit Cards 6 </strong></td>
                            <td>{{ isset($app['document']['admit_card_6']) && !empty($app['document']['admit_card_6']['document_path']) ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td><strong>Course Marksheets 1 </strong></td>
                        <td>{{ isset($app['document']['marksheet_1']) && !empty($app['document']['marksheet_1']['document_path']) ? 'Yes' : 'No' }}
                        </td>
                        <td><strong>Course Marksheets 2 </strong></td>
                        <td>{{ isset($app['document']['marksheet_2']) && !empty($app['document']['marksheet_2']['document_path']) ? 'Yes' : 'No' }}
                        </td>
                    </tr>

                    @if ($app['studentApplication']['course_type'] == 'Diploma' || $app['studentApplication']['course_type'] == 'Bachelor')
                        <tr>
                            <td><strong>Course Marksheets 3 </strong></td>
                            <td>{{ isset($app['document']['marksheet_3']) && !empty($app['document']['marksheet_3']['document_path']) ? 'Yes' : 'No' }}
                            </td>
                            <td><strong>Course Marksheets 4 </strong></td>
                            <td>{{ isset($app['document']['marksheet_4']) && !empty($app['document']['marksheet_4']['document_path']) ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                    @endif

                    @if ($app['studentApplication']['course_type'] == 'Bachelor')
                        <tr>
                            <td><strong>Course Marksheets 5 </strong></td>
                            <td>{{ isset($app['document']['marksheet_5']) && !empty($app['document']['marksheet_5']['document_path']) ? 'Yes' : 'No' }}
                            </td>
                            <td><strong>Course Marksheets 6 </strong></td>
                            <td>{{ isset($app['document']['marksheet_6']) && !empty($app['document']['marksheet_6']['document_path']) ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                    @endif

                    <!-- <tr>
                    <td><strong>Provisional Certificates</strong></td>
                        <td>{{ isset($app['document']['provisional_1']) && !empty($app['document']['provisional_1']['document_path']) ? 'Yes' : 'No' }}
                        </td>
                        <td colspan="2"></td>
                    </tr> -->

                    @if ($app['payment']['passing_state'] == 'Other')
                        <tr>
                            <td><strong>State Council Regn.
                                    Certificate</strong></td>
                            <td>{{ isset($app['document']['state_council_registration']) && !empty($app['document']['state_council_registration']['document_path']) ? 'Yes' : 'No' }}
                            </td>
                            <td><strong>NOC from the State Council</strong></td>
                            <td>{{ isset($app['document']['state_council_noc']) && !empty($app['document']['state_council_noc']['document_path']) ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td><strong>JCECE Practical Copy</strong></td>
                        <td>{{ isset($app['document']['jcece_practical']) && !empty($app['document']['jcece_practical']['document_path']) ? 'Yes' : 'No' }}
                        </td>
                        <td><strong>JCECE Board Allotment Letter</strong></td>
                        <td>{{ isset($app['document']['jcece_allotment']) && !empty($app['document']['jcece_allotment']['document_path']) ? 'Yes' : 'No' }}
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

    <footer>
        <div style="text-align: right; font-size: 8pt; position: absolute; right: 25px;">
            Printed on: {{ now() }}
        </div>
        <div style="text-align: center; font-size: 8pt; position: absolute; left: 50%; transform: translateX(-50%);">
            (Ack. No. {{ $app['studentApplication']['acknowledgment_no'] }})
        </div>

        <div style="text-align: left; font-size: 8pt; position: absolute; left: 25px;">
            Date & Time of Submission :
            {{ \Carbon\Carbon::parse($app['studentApplication']['created_at'])->format('d-m-Y H:i:s') }}
        </div>
    </footer>

    <table border="1" id="preview-table" width="100%" style="border-collapse: collapse;page-break-before: always;">
        <thead>
            <tr>
                <th style="border: 1px solid #ccc; background-color: #f2f2f2; padding: 10px 20px; text-align: left;">
                    Preview Attached Documents
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($app['document'] as $index => $doc)
                <tr>
                    <td style="padding: 10px;">
                        <div>
                            <!-- <strong>{{ ucfirst(str_replace('_', ' ', $doc->document_name)) }} -->
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
                                    @case('jcece_practical')
                                    <span>JCECE Practical Copy</span>
                                    @break
                                    @case('tenth_certificate')
                                    <span>Xth Marksheet </span>
                                    @break
                                    @case('twelfth_certificate')
                                    <span>XIIth Marksheet </span>
                                    @break
                                @default
                                    <!-- <span>Something went wrong, please try again</span> -->
                            @endswitch
                            </strong>
                        </div>
                        <hr>
                        <div>
                            <!-- Display image -->
                            <img src="{{ public_path($doc->document_path) }}" alt="{{ $doc->document_name }}"
                                style="width: 100%; max-width: 600px;">

                        </div>
                    </td>
                </tr>

                <!-- Add a page break only between documents, not after each one -->
                @if ($index < count($app['document']) - 1)
                    <tr>
                        <td style="page-break-before: always;"></td>
                    </tr>
                @endif
            @endforeach

        </tbody>
    </table>

    <footer>
        <div style="text-align: right; font-size: 8pt; position: absolute; right: 25px;">
            Printed on: {{ now() }}
        </div>
        <div style="text-align: center; font-size: 8pt; position: absolute; left: 50%; transform: translateX(-50%);">
            (Ack. No. {{ $app['studentApplication']['acknowledgment_no'] }})
        </div>

        <div style="text-align: left; font-size: 8pt; position: absolute; left: 25px;">
            Date & Time of Submission :
            {{ \Carbon\Carbon::parse($app['studentApplication']['created_at'])->format('d-m-Y H:i:s') }}
        </div>
    </footer>
</body>

</html>