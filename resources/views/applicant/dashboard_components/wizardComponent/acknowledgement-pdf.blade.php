<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style>
        body {
            font-size: 16px;
        }

        #acknowledgment-table {
            border: 1px solid #69676724;
            /* Applying the custom border color */
            height: 30px;
        }

        #acknowledgment-table td {
            border: 1px solid #69676724;
            /* Applying the border to all table cells */
            height: 30px;
        }

        #acknowledgment-table img {
            border: 2px solid #000;
            /* Keeping the border styles for the images */
            margin-top: 5px;
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
                        <span style="font-weight:700;font-size:16px;color:#000; padding-top:25px;"><u>ACKNOWLEDGEMENT
                                SLIP</u></span><br>
                    </td>
                    <td width="15%"><img src="{{ public_path('assets/applicant/auth/images/jspc_logo_in.png') }}"
                            height="75px" width="75px" style="position:relative !important;margin-top:-0px;"></td>
                    <td width="1%"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <table border="1" id="acknowledgment-table" width="100%" id="app" cellpadding="5" cellspacing="0"
        style="border-collapse: collapse; font-size: 14px; margin-top: 25px; border: 1px solid #dad8d8fe;">
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;" width="25%"><strong>Acknowledgement No.</strong></td>
            <td style="border: 1px solid #69676724;" width="50%">
                {{ $app['studentApplication']['acknowledgment_no'] }}
            </td>
            <td style="border: 1px solid #69676724;" width="25%" rowspan="9"
                style="text-align: center; vertical-align: middle;">
                <img src="{{ public_path($app['document']['applicant_photo']['document_path']) }}"
                    style="width: 135px; height: auto; object-fit: cover; border: 2px solid #000; margin-top: 5px;">
                <img src="{{ public_path($app['document']['applicant_signature']['document_path']) }}"
                    style="height: 45px; width: 135px; border: 2px solid #000; margin-top: 5px;">
            </td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;"><strong>Registration applied for</strong></td>
            <td style="border: 1px solid #69676724;">
                {{ $app['studentApplication']->course_name != 'Other' ? strtoupper($app['studentApplication']->course_name) : strtoupper($app['studentApplication']->course_name) . ' - ' . strtoupper($app['studentApplication']->other_course) }}
                ({{ strtoupper($app['studentApplication']['course_type']) }})</td>
        </tr>
        @if ($app['studentApplication']->college_name === '999')
            <tr style="border: 1px solid #69676724;">
                <td style="border: 1px solid #69676724;"><strong>Name of the Institute</strong></td>
                <td style="border: 1px solid #69676724;">
                    OTHERS - {{ strtoupper($app['studentApplication']->jh_other_college_name) }}
                </td>
            </tr>
        @else
            <tr style="border: 1px solid #69676724;">
                <td style="border: 1px solid #69676724;"><strong>Name of the Institute</strong></td>
                <td style="border: 1px solid #69676724;">
                    {{ !empty($app['studentApplication']->inst_name) ? strtoupper($app['studentApplication']->inst_name) : strtoupper($app['studentApplication']->college_name) }}
                </td>
            </tr>
        @endif

        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;"><strong>Name</strong></td>
            <td style="border: 1px solid #69676724;">{{ strtoupper($app['studentApplication']['name']) }}</td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;"><strong>Father's/Husband Name</strong></td>
            <td style="border: 1px solid #69676724;">{{ strtoupper($app['studentApplication']['father_name']) }}</td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;"><strong>Gender</strong></td>
            <td style="border: 1px solid #69676724;">
                {{ strtoupper($app['studentApplication']['gender']) }}
            </td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;"><strong>Date of Birth</strong></td>
            <td style="border: 1px solid #69676724;">
                {{ \Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('d-m-Y') }}
            </td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;"><strong>Category</strong></td>
            <td style="border: 1px solid #69676724;">
                {{ strtoupper($app['studentApplication']['category']) }}
            </td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724; white-space: nowrap;"><strong>Course Registration No./ Admit Card Roll No.</strong></td>
            <td style="border: 1px solid #69676724;">
                {{ $app['studentApplication']['course_registration_no'] }}
            </td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724; white-space: nowrap;"><strong>Registration Certificate Issue Date</strong></td>
            <td style="border: 1px solid #69676724;" colspan="2">
                {{ $app['payment']['result_date'] }}
            </td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724; white-space: nowrap;"><strong>Registration No.</strong></td>
            <td style="border: 1px solid #69676724;" colspan="2">
                {{ $app['payment']['registration_no'] }}
            </td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;" colspan="3" style="background-color: #f2f2f2;"><strong>PAYMENT
                    DETAILS</strong></td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;"><strong>Amount</strong></td>
            <td style="border: 1px solid #69676724;" colspan="2">{{ strtoupper($app['payment']['amount']) }}</td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;"><strong>Receipt No</strong></td>
            <td style="border: 1px solid #69676724;" colspan="2">
                {{ strtoupper($app['payment']['payment_receipt_no']) }}
            </td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;"><strong>Payment Date</strong></td>
            <td style="border: 1px solid #69676724;" colspan="2">
                {{ \Carbon\Carbon::parse($app['payment']['dated'])->format('d-m-Y') }}
            </td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;"><strong> Date & Time of Submission</strong></td>
            <td style="border: 1px solid #69676724;" colspan="2">
                {{ \Carbon\Carbon::parse($app['studentApplication']['created_at'])->format('d-m-Y H:i:s') }}
            </td>
        </tr>
        <tr style="border: 1px solid #69676724;">
            <td style="border: 1px solid #69676724;"><strong>Application Status</strong></td>
            <td style="border: 1px solid #69676724;" colspan="2">Under Verification</td>
        </tr>
    </table>
</body>

</html>
