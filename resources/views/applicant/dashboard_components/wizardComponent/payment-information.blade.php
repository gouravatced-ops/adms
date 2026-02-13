<style>
    .certificate-group {
        border-left: 3px solid #007bff;
        padding-left: 15px;
        margin-bottom: 15px;
    }

    .remove-cert {
        height: 38px;
    }

    #field-counter {
        font-size: 0.875rem;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>

<form id="registrationForm" action="{{ route('apply-new-licence', 'payment-information') }}" method="POST"
    enctype="multipart/form-data">
    @csrf

    <div class="form-step">

        <h3>Payment Information</h3>

        <div class="row">
            <div class="col-md-3 mb-2">
                <label for="state">Course Passing State <small class="text-danger">*</small> </label>
                <select name="state" id="state" class="form-select @error('state') is-invalid @enderror" required>
                    <option value="">Select option</option>
                    <option value="Jharkhand"
                        {{ old('state', $data['payment']['passing_state'] ?? '') == 'Jharkhand' ? 'selected' : '' }}>
                        Jharkhand
                    </option>
                    <option value="Other"
                        {{ old('state', $data['payment']['passing_state'] ?? '') == 'Other' ? 'selected' : '' }}>
                        Other State
                    </option>
                </select>

                @error('state')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-3 {{ old('otherState', isset($data['payment']['passing_state']) === 'Other' ? '' : 'd-none') }}"
                id="otherStateDiv">
                <label for="otherState">Other State <small class="text-danger">*</small> </label>

                <select name="otherState" id="otherState"
                    class="form-select  @error('otherState') is-invalid @enderror">

                </select>

                @error('otherState')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-3 mb-2">
                <label for="registrationNo">Registration No. <small class="text-danger">*</small> </label>
                <input type="text" name="registrationNo" id="registrationNo"
                    class="form-control @error('registrationNo') is-invalid @enderror"  oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 7)" maxlength="7"
                    value="{{ old('registrationNo', isset($data['payment']['registration_no']) ? $data['payment']['registration_no'] : '') }}"
                    required>
                @error('registrationNo')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <div class="invalid-feedback">
                    Please enter a Registration No.
                </div>
            </div>

            <div class="col-md-3 mb-2">
                <label for="resultDate">Registration Certificate Issue Date <small class="text-danger">*</small> </label>
                <input type="date" name="resultDate" id="resultDate"
                    class="form-control @error('resultDate') is-invalid @enderror"
                    max="{{ now()->subYears(5)->format('Y-m-d') }}" min="2011-11-04"
                    value="{{ old('resultDate', isset($data['payment']['result_date']) ? $data['payment']['result_date'] : '') }}"
                    required>
                @error('resultDate')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <div class="invalid-feedback">
                    Please enter a Registration Certificate Issue Date.
                </div>
            </div>

            @php
                $limit = 1; // Default limit
                if (old('resultDate') || isset($data['payment']['result_date'])) {
                    $resultDate = old(
                        'resultDate',
                        isset($data['payment']['result_date']) ? $data['payment']['result_date'] : '',
                    );
                    $resultYear = date('Y', strtotime($resultDate));
                    $currentYear = date('Y');
                    $limit = floor(($currentYear - $resultYear) / 5) + 1;
                }

                // If certificate history exists, use that count
                $existingCertificates = $data['certificate_history'] ?? collect();
                $certificateCount = max($existingCertificates->count(), 1);
            @endphp

            <div class="col-md-3 mb-2">
                <label for="category">Category</label>
                <input name="category" id="category" class="form-control" value="{{ Auth::user()->category }}" required
                    readonly>
            </div>
        </div>

        <!-- ******************** -->

        <div class="card my-3">
            <div class="card-header bg-primary">
                <strong class="card-title text-light">Certificates Information</strong>
            </div>
            <div class="card-body">
                <div id="certificate-fields">
                    @if ($existingCertificates->count() > 0)
                        {{-- Load existing certificates --}}
                        @foreach ($existingCertificates as $index => $certificate)
                            <div class="certificate-group mb-3" data-index="{{ $index + 1 }}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label for="cert_start_date{{ $index + 1 }}">
                                            {{ $index == 0 ? 'Certificate Start Date' : ($index == 1 ? '1st Renewal Start Date' : ($index == 2 ? '2nd Renewal Start Date' : ($index == 3 ? '3rd Renewal Start Date' : $index + 1 . 'th Renewal Start Date'))) }}
                                        </label>
                                        <input class="form-control cert-start-date" type="date"
                                            name="cert_start_date{{ $index + 1 }}"
                                            id="cert_start_date{{ $index + 1 }}"
                                            max="{{ $index == 0 ? now()->subYears(5)->format('Y-m-d') : now()->format('Y-m-d') }}"
                                            min="2011-11-04" onchange="calculateExpiry({{ $index + 1 }})"
                                            value="{{ old('cert_start_date' . ($index + 1), $certificate->cert_start_date) }}"
                                            readonly>
                                        <input type="hidden" name="cert_id{{ $index + 1 }}"
                                            value="{{ $certificate->id }}">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="cert_expiry_date{{ $index + 1 }}">
                                            {{ $index == 0 ? 'Certificate Expiry Date' : ($index == 1 ? '1st Renewal Expiry Date' : ($index == 2 ? '2nd Renewal Expiry Date' : ($index == 3 ? '3rd Renewal Expiry Date' : $index + 1 . 'th Renewal Expiry Date'))) }}
                                        </label>
                                        <input class="form-control cert-expiry-date" type="date"
                                            name="cert_expiry_date{{ $index + 1 }}"
                                            id="cert_expiry_date{{ $index + 1 }}" readonly min="2011-11-04"
                                            value="{{ old('cert_expiry_date' . ($index + 1), $certificate->cert_expiry_date) }}"
                                            readonly>
                                    </div>
                                    @if ($index != 0)
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove-cert"
                                                onclick="removeCertificate({{ $index + 1 }})"
                                                style="{{ $existingCertificates->count() == 1 ? 'display: none;' : '' }}">
                                                Delete <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="certificate-group mb-3" data-index="1">
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="cert_start_date1">Certificate Start Date</label>
                                    <input class="form-control cert-start-date" type="date" name="cert_start_date1"
                                        id="cert_start_date1" max="{{ now()->subYears(5)->format('Y-m-d') }}"
                                        min="2011-11-04" onchange="calculateExpiry(1)"
                                        value="{{ old('cert_start_date1', isset($data['payment']['result_date']) ? $data['payment']['result_date'] : '') }}"
                                        readonly>
                                </div>
                                <div class="col-md-5">
                                    <label for="cert_expiry_date1">Certificate Expiry Date</label>
                                    <input class="form-control cert-expiry-date" type="date" name="cert_expiry_date1"
                                        id="cert_expiry_date1" readonly min="2011-11-04"
                                        value="{{ old('cert_expiry_date1') }}" readonly>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-success" id="add-more-cert"
                            onclick="addCertificate()">
                            <i class="fas fa-plus"></i> Add More Certificate
                        </button>
                        <small class="text-muted ml-2" id="field-counter">Fields: {{ $certificateCount }} / <span
                                id="max-fields">{{ $limit }}</span></small>
                    </div>
                </div>
            </div>
        </div>

        <table class="table-bordered my-4" id="feeTable" border="1" width="100%" style="display:none">
            <thead class="bg-primary text-white  text-center">
                <tr>
                    <th>Certificate Renewal Fee</th>
                    <th>Late Fee</th>
                    <th>Total Fee</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td><b id="basicFee">Rs. 0</b></td>
                    <td><b id="lateFee">Rs. 0</b></td>
                    <td><b id="totalFee">Rs. 0</b></td>
                </tr>
            </tbody>
        </table>

        <!-- *********************** -->
        <div class="row">
            <div class="form-group col-md-12 mb-2">
                <label for="receipt_no">Payment Receipt No. <small class="text-danger">*</small> </label>
                <input type="text" id="receipt_no" name="receipt_no" maxlength="25"
                    class="form-control @error('receipt_no') is-invalid @enderror"
                    value="{{ old('receipt_no', isset($data['payment']['payment_receipt_no']) ? $data['payment']['payment_receipt_no'] : '') }}"
                    required>
                @error('receipt_no')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-md-6 mb-2">
                <label for="amount">Amount <small class="text-danger">*</small> </label>
                <input type="text" id="amount" name="amount"
                    class="form-control @error('amount') is-invalid @enderror"
                    value="{{ old('amount', isset($data['payment']['amount']) ? $data['payment']['amount'] : '') }}"
                    required readonly>
                @error('amount')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-md-6" mb-2>
                <label for="dated">Payment Receipt Date <small class="text-danger">*</small> </label>
                <input type="date" id="dated datepicker-icon-prepend" name="dated"
                    class="form-control @error('dated') is-invalid @enderror"
                    value="{{ old('dated', isset($data['payment']['dated']) ? $data['payment']['dated'] : '') }}"
                    max="{{ date('Y-m-d') }}" required>
                @error('dated')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-6 mb-2">
                <label for="receipt_file">Upload Payment Receipt <small class="text-danger">*</small> <span
                        class="text-primary">(Max. 200kb, Only .jpg)</span></label>
                <input type="file" id="receipt_file" name="receipt_file" accept=".jpg,.jpege"
                    class="form-control @error('receipt_file') is-invalid @enderror"
                    {{ isset($data['payment']['payment_receipt']) && $data['payment']['payment_receipt'] ? '' : 'required' }}>
                @error('receipt_file')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-md-6 mt-4">
                @if (isset($data['payment']['payment_receipt']) && $data['payment']['payment_receipt'])
                    <a href="{{ asset($data['payment']['payment_receipt']) }}" target="_blank">View
                        Uploaded Receipt</a>
                @endif
            </div>
        </div>
        <button type="submit" name="next" class="btn btn-primary mt-3">Next</button>
    </div>
</form>

@push('scripts')
    <script src="{{-- asset('assets/applicant/auth/js/verification.js') --}}"></script>
    <script>
        $(document).ready(function() {

            function getState() {
                $.ajax({
                    url: "{{ route('get-state') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#otherState').empty();
                        $('#otherState').append('<option value="">Select State</option>');

                        $.each(data.states, function(index, state) {
                            if (state.id != '10') {
                                var selected = (state.id ==
                                    "{{ old('otherState', $data['other_state'] ?? '') }}"
                                ) ? 'selected' : '';
                                $('#otherState').append('<option value="' + state.id +
                                    '" ' +
                                    selected + '>' + state.name + '</option>');
                            }

                        });

                    }
                });
            }

            $('#state').on('change', function() {
                if ($("#state :selected").val() == 'Other') {
                    $("#state").parent().parent().find(".col-md-4").removeClass('col-md-4').addClass(
                        'col-md-3');
                    getState();
                    $("#otherStateDiv").removeClass('d-none');
                } else {
                    $("#state").parent().parent().find(".col-md-3").removeClass('col-md-3').addClass(
                        'col-md-4');
                    $("#otherStateDiv").addClass('d-none');
                }
            });

            if ($('#state :selected').val() === 'Other') {
                $("#state").parent().parent().find(".col-md-4").removeClass('col-md-4').addClass('col-md-3');
                $("#otherStateDiv").removeClass('d-none');
                getState();
            }

        });
    </script>

    <script>
        $('form').on('submit', function(e) {
            // Show loader
            $("#jspc-loader").removeClass('d-none');
            $("#loading-text").text("Please Wait...");
        });

        $(document).ready(function() {
            $('.step').parent().find('.active').removeClass('active');
            $('.step').eq(0).addClass('active');
        });
    </script>

    <script>
        let maxFields = {{ $limit }}; // Initialize with calculated value
        let fieldCount = {{ $certificateCount }}; // Initialize with existing certificate count

      /*  function calculateFee() {
            var category = $('#category').val();
            var state = $('#state').val();

            const allExpiries = getAllExpiryDates();
            const mostRecentExpiry = allExpiries[allExpiries.length - 1];

            const resultDate = mostRecentExpiry?.value;

            if (!resultDate) {
                $('#feeTable').hide();
                $("#amount").val('');
                return;
            }

            var currentDate = new Date();
            var diffYears = currentDate.getFullYear() - new Date(resultDate).getFullYear();
            var monthDiff = currentDate.getMonth() - new Date(resultDate).getMonth();
            var dayDiff = currentDate.getDate() - new Date(resultDate).getDate();

            if (monthDiff < 0 || (monthDiff === 0 && dayDiff <= 0)) {
                diffYears--;
            }

            var basicFee = 1000;
            var lateFee = 0;

            if (diffYears >= 1) {
                if (state.toLowerCase() == 'jharkhand') {
                    lateFee = (category.toLowerCase() === 'general' || category.toLowerCase() === 'obc') ? 200 : 100;
                    lateFee *= diffYears;
                } else {
                    lateFee = 200;
                    lateFee *= diffYears;
                }
            } else {
                lateFee = 0;
            }

            var totalFee = basicFee + lateFee;

            $('#feeTable').show();
            $('#basicFee').text('Rs. ' + basicFee);
            $('#lateFee').text('Rs. ' + lateFee);
            $('#totalFee').text('Rs. ' + totalFee);

            $("#amount").val(totalFee);
        }
    */

        function calculateFee() {
            var category = $('#category').val();
            var state = $('#state').val();

            const allExpiries = getAllExpiryDates();
            const mostRecentExpiry = allExpiries[allExpiries.length - 1];

            const resultDate = mostRecentExpiry?.value;

            if (!resultDate) {
                $('#feeTable').hide();
                $("#amount").val('');
                return;
            }

            var currentDate = new Date();
            var expiryDate = new Date(resultDate);
            
            // Calculate year difference
            var diffYears = currentDate.getFullYear() - expiryDate.getFullYear();
            var monthDiff = currentDate.getMonth() - expiryDate.getMonth();
            var dayDiff = currentDate.getDate() - expiryDate.getDate();

            if (monthDiff < 0 || (monthDiff === 0 && dayDiff <= 0)) {
                diffYears--;
            }

            // Calculate basic fee - increases by 1000 every 5 years from expiry date
            var fiveYearPeriods = Math.floor(diffYears / 5);
            var basicFee = 1000 + (fiveYearPeriods * 1000);

            // Calculate late fee (unchanged logic)
            var lateFee = 0;

            if (diffYears >= 1) {
                if (state.toLowerCase() == 'jharkhand') {
                    lateFee = (category.toLowerCase() === 'general' || category.toLowerCase() === 'obc') ? 200 : 100;
                    lateFee *= diffYears;
                } else {
                    lateFee = 200;
                    lateFee *= diffYears;
                }
            }

            var totalFee = basicFee + lateFee;

            $('#feeTable').show();
            $('#basicFee').text('Rs. ' + basicFee);
            $('#lateFee').text('Rs. ' + lateFee);
            $('#totalFee').text('Rs. ' + totalFee);

            $("#amount").val(totalFee);
        }

        function getAllExpiryDates() {
            const expiryInputs = document.querySelectorAll('.cert-expiry-date');
            const expiryDates = [];

            expiryInputs.forEach(input => {
                if (input.value) {
                    expiryDates.push({
                        element: input,
                        value: input.value,
                        date: new Date(input.value)
                    });
                }
            });

            expiryDates.sort((a, b) => a.date - b.date);
            return expiryDates;
        }

        function calculateMaxFields() {
            const resultPubDate = document.getElementById('resultDate').value;

            if (!resultPubDate) {
                maxFields = 1;
                document.getElementById('max-fields').textContent = maxFields;
                updateFieldCounter();
                return;
            }

            const resultPubYear = new Date(resultPubDate).getFullYear();
            const currentYear = new Date().getFullYear();
            maxFields = Math.floor((currentYear - resultPubYear) / 5) + 1;

            document.getElementById('max-fields').textContent = maxFields;
            updateFieldCounter();

            // Set first certificate start date if no existing certificates
           /* if (fieldCount === 1 && !document.getElementById('cert_start_date1').value) {
                document.getElementById('cert_start_date1').value = resultPubDate;
                calculateExpiry(1);
            } */

            // if (fieldCount === 1 ) {
                document.getElementById('cert_start_date1').value = resultPubDate;
                calculateExpiry(1);
            // }

            // Hide excess fields if maxFields is reduced
            if (fieldCount > maxFields) {
                for (let i = maxFields + 1; i <= fieldCount; i++) {
                    const group = document.querySelector(`[data-index="${i}"]`);
                    if (group) {
                        group.remove();
                    }
                }
                fieldCount = maxFields;
                updateFieldCounter();
                updateRemoveButtons();
                reindexFields();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const resultDateInput = document.getElementById('resultDate');
            if (resultDateInput) {
                resultDateInput.addEventListener('change', calculateMaxFields);
                calculateMaxFields();
            }

            // Calculate fee on page load if certificates exist
            calculateFee();
            updateFieldCounter();
            updateRemoveButtons();
        });

        function addCertificate() {
            if (fieldCount >= maxFields) {
                alert(`Maximum ${maxFields} certificate fields allowed.`);
                return;
            }

            fieldCount++;

            const certificateFields = document.getElementById('certificate-fields');
            const newGroup = document.createElement('div');
            newGroup.className = 'certificate-group mb-3';
            newGroup.setAttribute('data-index', fieldCount);

            const ordinal = getOrdinal(fieldCount-1);
            const label = (fieldCount-1) === 0 ? 'Certificate' : ordinal + ' Renewal';

            newGroup.innerHTML = `
                <div class="row">
                    <div class="col-md-5">
                        <label for="cert_start_date${fieldCount}">${label} Start Date</label>
                        <input class="form-control cert-start-date" type="date" name="cert_start_date${fieldCount}" 
                               id="cert_start_date${fieldCount}" max="${fieldCount === 1 ? '{{ now()->subYears(5)->format('Y-m-d') }}' : '{{ now()->format('Y-m-d') }}'}" min="2011-11-04"
                               onchange="calculateExpiry(${fieldCount})" required>
                    </div>
                    <div class="col-md-5">
                        <label for="cert_expiry_date${fieldCount}">${label} Expiry Date</label>
                        <input class="form-control cert-expiry-date" type="date" name="cert_expiry_date${fieldCount}" min="2011-11-04"
                               id="cert_expiry_date${fieldCount}" readonly required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-cert" 
                                onclick="removeCertificate(${fieldCount})">
                          Delete  <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            certificateFields.appendChild(newGroup);
            updateFieldCounter();
            updateRemoveButtons();
        }

        function removeCertificate(index) {
            if (fieldCount <= 1) {
                alert('At least one certificate is required.');
                return;
            }

            const group = document.querySelector(`[data-index="${index}"]`);
            if (group) {
                group.remove();
                fieldCount--;
                updateFieldCounter();
                updateRemoveButtons();
                reindexFields();
                calculateFee();
            }
        }

        function calculateExpiry(index) {
            const startDateInput = document.getElementById(`cert_start_date${index}`);
            const expiryDateInput = document.getElementById(`cert_expiry_date${index}`);

            if (startDateInput.value) {
                const startDate = new Date(startDateInput.value);
                const expiryDate = new Date(startDate);
                expiryDate.setDate(expiryDate.getDate() - 1);
                expiryDate.setFullYear(expiryDate.getFullYear() + 5);

                const formattedDate = expiryDate.toISOString().split('T')[0];
                expiryDateInput.value = formattedDate;
                calculateFee();
            } else {
                expiryDateInput.value = '';
            }
        }

        function updateFieldCounter() {
            document.getElementById('field-counter').innerHTML =
                `Fields: ${fieldCount} / <span id="max-fields">${maxFields}</span>`;

            const addButton = document.getElementById('add-more-cert');
            if (fieldCount >= maxFields) {
                addButton.style.display = 'none';
            } else {
                addButton.style.display = 'inline-block';
            }
        }

        function updateRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove-cert');
            removeButtons.forEach(button => {
                if (fieldCount > 1) {
                    button.style.display = 'inline-block';
                } else {
                    button.style.display = 'none';
                }
            });
        }

        function reindexFields() {
            const groups = document.querySelectorAll('.certificate-group');
            groups.forEach((group, index) => {
                const newIndex = index + 1;
                const ordinal = getOrdinal(newIndex);
                const label = index === 0 ? 'Certificate' : ordinal + ' Renewal';

                group.setAttribute('data-index', newIndex);

                const labels = group.querySelectorAll('label');
                labels[0].textContent = `${label} Start Date`;
                labels[0].setAttribute('for', `cert_start_date${newIndex}`);
                labels[1].textContent = `${label} Expiry Date`;
                labels[1].setAttribute('for', `cert_expiry_date${newIndex}`);

                const inputs = group.querySelectorAll('input[type="date"]');
                inputs[0].name = `cert_start_date${newIndex}`;
                inputs[0].id = `cert_start_date${newIndex}`;
                inputs[0].setAttribute('onchange', `calculateExpiry(${newIndex})`);
                inputs[1].name = `cert_expiry_date${newIndex}`;
                inputs[1].id = `cert_expiry_date${newIndex}`;

                // Update hidden input for certificate ID if it exists
                const hiddenInput = group.querySelector('input[type="hidden"]');
                if (hiddenInput) {
                    hiddenInput.name = `cert_id${newIndex}`;
                }

                const removeBtn = group.querySelector('.remove-cert');
                if(removeBtn)
                {
                removeBtn.setAttribute('onclick', `removeCertificate(${newIndex})`);
                }
            });

            fieldCount = groups.length;
            updateFieldCounter();
        }

        function getOrdinal(num) {
            const ordinals = {
                1: '1st',
                2: '2nd',
                3: '3rd',
                4: '4th',
                5: '5th',
                6: '6th',
                7: '7th',
                8: '8th',
                9: '9th',
                10: '10th',
                11: '11th',
                12: '12th',
                13: '13th',
                14: '14th',
                15: '15th'
            };

            if (ordinals[num]) {
                return ordinals[num];
            }

            const lastDigit = num % 10;
            const lastTwoDigits = num % 100;

            if (lastTwoDigits >= 11 && lastTwoDigits <= 13) {
                return num + 'th';
            }

            switch (lastDigit) {
                case 1:
                    return num + 'st';
                case 2:
                    return num + 'nd';
                case 3:
                    return num + 'rd';
                default:
                    return num + 'th';
            }
        }
    </script>
@endpush
