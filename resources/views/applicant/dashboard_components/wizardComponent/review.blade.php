{{-- {{ dd($data);}} --}}
<form action="{{ route('submit-application') }}" method="POST" class="container mt-4">
    @csrf
    <div class="form-step">
        <h3>Review & Submit</h3>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Payment Information</h4>
                <a class="btn btn-light btn-sm" href="{{ route('apply-new-licence', 'payment-information') }}">Edit</a>
            </div>
            <div class="card-body">
                @if ($data['payment']->passing_state == 'Jharkhand')
                    <div class="row">
                        <div class="col-md-4"><strong>Passing State </strong></div>
                        <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['payment']->passing_state }}</div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-4"><strong>Passing State </strong></div>
                        <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['passState']->name }}</div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-4"><strong>Registration No. </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['payment']->registration_no }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Registration Certificate Issue Date </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['payment']->result_date }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Category </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ Auth::user()->category }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Receipt No </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['payment']->payment_receipt_no }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Amount </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['payment']->amount }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Date </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['payment']->dated }}</div>
                </div>
                @if (isset($data['payment']->payment_receipt))
                    <div class="row">
                        <div class="col-md-4"><strong>Receipt </strong></div>
                        <div class="col-md-8">
                            <a href="{{ asset($data['payment']->payment_receipt) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">View Payment Receipt</a>
                        </div>
                    </div>
                @endif

                <div class="row">
                    
                    <div class="col-md-12 my-3"><strong>Certificate Histories :</strong></div>

                    <div class="col-md-4"><strong>Certificate Type</strong></div>
                        <div class="col-md-4"><strong>Certificate Start Date</strong></div>
                        <div class="col-md-4"><strong>Certificate Expiry Date</strong></div>
                        <hr>

                    @foreach($data['certificateHistory'] as $history)
                        <div class="col-md-4">{{ $history['certificate_type'] }}</div>
                        <div class="col-md-4">{{ $history['cert_start_date'] }}</div>
                        <div class="col-md-4">{{ $history['cert_expiry_date'] }}</div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Applicant Information</h4>
                <a class="btn btn-light btn-sm"
                    href="{{ route('apply-new-licence', 'applicant-information') }}">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4"><strong>Course Type </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->course_type }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Name of Course </strong></div>
                    <div class="col-md-8">
                        :&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->course_name == 'Other' ? $data['studentApplication']->course_name . ' - ' . $data['studentApplication']->other_course : $data['studentApplication']->course_name }}
                    </div>
                </div>
                @if ($data['payment']->passing_state != 'Other')
                    <div class="row">
                        <div class="col-md-4"><strong>Name of College </strong></div>
                        <div class="col-md-8">
                            :&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->college_name == '999' ? $data['studentApplication']->jh_other_college_name : $data['jhCollege']->name }}
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-4"><strong>Name of College </strong></div>
                        <div class="col-md-8">
                            :&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->college_name }}
                        </div>
                    </div>
                    {{-- @if ($data['studentApplication']->college_name == '999')
                        <div class="row">
                            <div class="col-md-4"><strong>Name of the Other College Name </strong></div>
                            <div class="col-md-8">
                                :&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->jh_other_college_name }}
                            </div>
                        </div>
                    @endif --}}
                @endif
                <div class="row">
                    <div class="col-md-4"><strong>Name </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->name }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Father's Name </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->father_name }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Gender </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ ucfirst(Auth::user()->gender) }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Address </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->address }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>City </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->city }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Pin Code </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->pin_code }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>State </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['resState']->name }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Country </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->country }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Mobile No </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->mobile_no }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Alternate Mobile No </strong></div>
                    <div class="col-md-8">
                        :&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->alternate_mobile_no }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>WhatsApp Mobile No </strong></div>
                    <div class="col-md-8">
                        :&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->whatsapp_no ?? 'NA' }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Email </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->email }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Aadhaar </strong></div>
                    <div class="col-md-8">:&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->aadhaar }}</div>
                </div>
                @if ($data['payment']->passing_state == 'Other')
                    <div class="row">
                        <div class="col-md-4"><strong>Council Regn. Certificate No. </strong></div>
                        <div class="col-md-8">
                            :&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->council_regn_no }}</div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"><strong>NOC from State Council </strong></div>
                        <div class="col-md-8">
                            :&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['studentApplication']->noc_state_council }}</div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Uploaded Documents</h4>
                <a class="btn btn-light btn-sm" href="{{ route('apply-new-licence', 'upload-documents') }}">Edit</a>
            </div>
            <div class="card-body">
                @foreach ($data['document'] as $docType => $document)
                    <div class="row mb-2">
                        <div class="col-md-4"><strong>
                                @switch($docType)
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

                                    @case('last_issued_certificate')
                                        <span>Last Issued Certificate </span>
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

                                    @default
                                        <!-- <span>Something went wrong, please try again</span> -->
                                @endswitch
                            </strong></div>
                        <div class="col-md-8">
                            <a href="{{ asset($document->document_path) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">View Document</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Declaration</h4>
            </div>
            <div class="card-body">
                <div class="form-check">
                    <input class="form-check-input @error('declaration') is-invalid @enderror" type="checkbox"
                        name="declaration" id="declaration" required>
                    <label class="form-check-label" for="declaration">
                        I hereby declare that the information provided above is true and correct to the best of my
                        knowledge.
                    </label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button type="submit" id="submitButton" class="btn btn-primary">Submit Application</button>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        $('form').on('submit', function(e) {
            $("#jspc-loader").removeClass('d-none');
            $("#loading-text").text("Final Submitting Form. Please Wait!!");
            $('#submitButton').prop('disabled', true);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.step').parent().find('.active').removeClass('active');
            $('.step').eq(3).addClass('active');
        });
    </script>
@endpush
