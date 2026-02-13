<form id="registrationForm" action="{{ route('apply-new-licence', 'applicant-information') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="form-step">
        <h3>Applicant's Information</h3>
        <div class="row mb-3">
            <div class="col-md-6 form-group">
                <label class="mb-1" for="course_type">Type of Course <small class="text-danger">*</small> </label>
                <select name="course_type" id="course_type" class="form-select">
                    <option value="Diploma"
                        {{ old('course_type', $data['course_type'] ?? '') == 'Diploma' ? 'selected="selected"' : '' }}>
                        Diploma</option>
                    <option value="Certificate"
                        {{ old('course_type', $data['course_type'] ?? '') == 'Certificate' ? 'selected="selected"' : '' }}>
                        Certificate</option>
                    <option value="Bachelor"
                        {{ old('course_type', $data['course_type'] ?? '') == 'Bachelor' ? 'selected="selected"' : '' }}>
                        Bachelor</option>
                    <option value="Vocational"
                        {{ old('course_type', $data['course_type'] ?? '') == 'Vocational' ? 'selected="selected"' : '' }}>
                        Vocational</option>
                    <option value="POST GRADUATE DIPLOMA"
                        {{ old('course_type', $data['course_type'] ?? '') == 'POST GRADUATE DIPLOMA' ? 'selected="selected"' : '' }}>
                        POST GRADUATE DIPLOMA</option>
                </select>
                @error('course_type')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6 form-group">
                <label class="mb-1" for="course_name">Name of Course <small class="text-danger">*</small> </label>

                <select name="course_name" id="course_name"
                    class="form-select  @error('course_name') is-invalid @enderror">

                </select>
                @error('course_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6" id="collegeNameContainer">

            </div>

            <div class="col-md-6">
                <label class="mb-1" for="course_registration_no">Course Registration No. / Admit Card Roll No. <small
                        class="text-danger">*</small> </label>
                <input type="text" name="course_registration_no" id="course_registration_no"
                    class="form-control @error('course_registration_no') is-invalid @enderror"
                    value="{{ old('course_registration_no', isset($data['course_registration_no']) ? $data['course_registration_no'] : '') }}">
                @error('course_registration_no')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="mb-1" for="applicant_name">Name</label>
                <input type="text" name="applicant_name" id="applicant_name"
                    class="form-control @error('applicant_name') is-invalid @enderror" value="{{ Auth::user()->name }}"
                    readonly>
                @error('applicant_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <label>Choose Guardian <small class="text-danger">*</small></label>
                <div>
                    <label>
    <input type="radio" name="guardian_type" value="father"
        {{ old('guardian_type', $data['guardian_type'] ?? '') == 'father' ? 'checked' : '' }} required>
    Father's Name
</label>

<label class="ms-3">
    <input type="radio" name="guardian_type" value="husband"
        {{ old('guardian_type', $data['guardian_type'] ?? '') == 'husband' ? 'checked' : '' }}>
    Husband's Name
</label>

                </div>
                <input type="text" name="fathers_name" id="fathers_name"
                    class="form-control @error('fathers_name') is-invalid @enderror"
                    value="{{ old('fathers_name', isset($data['father_name']) ? $data['father_name'] : '') }}"
                    placeholder="Guardian's Name">
                @error('fathers_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="mb-1" for="gender">Gender</label>
                <input name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror"
                    value="{{ Auth::user()->gender }}" @readonly(true)>
                @error('gender')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="mb-1" for="category">Category</label>
                <input name="category" id="category" class="form-control @error('category') is-invalid @enderror"
                    value="{{ Auth::user()->category }}" readonly>

                @error('category')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-8">
                <label class="mb-1" for="address">Address for Correspondence <small class="text-danger">*</small>
                </label>
                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror">{{ old('address', isset($data['address']) ? $data['address'] : '') }}</textarea>
                @error('address')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="mb-1" for="city">City <small class="text-danger">*</small> </label>

                <input name="city" id="city" class="form-control  @error('city') is-invalid @enderror"
                    value="{{ old('city', isset($data['city']) ? $data['city'] : '') }}" placeholder="City's Name">

                @error('city')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="mb-1" for="state">State <small class="text-danger">*</small> </label>

                <select name="state" id="state" class="form-select  @error('state') is-invalid @enderror">
                </select>
                @error('state')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="mb-1" for="pin">Pin Code <small class="text-danger">*</small> </label>
                <input type="text" name="pin" id="pin"
                    class="form-control @error('pin') is-invalid @enderror" pattern="[0-9]{6}" maxlength="6"
                    value="{{ old('pin', isset($data['pin_code']) ? $data['pin_code'] : '') }}"
                    placeholder="Pin Code">
                @error('pin')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="mb-1" for="country">Country</label>
                <input type="text" name="country" id="country"
                    class="form-control @error('country') is-invalid @enderror" value="India" readonly>
                @error('country')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="mb-1" for="mobile_no">Mobile No. <small class="text-danger">*</small> </label>
                <input type="tel" name="mobile_no" id="mobile_no"
                    class="form-control @error('mobile_no') is-invalid @enderror" pattern="[0-9]{10}" maxlength="10"
                    value="{{ old('mobile_no', Auth::user()->mobile_no) }}" readonly>
                @error('mobile_no')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="mb-1" for="alternate_mobile_no">Alternate Mobile No. <small
                        class="text-danger">*</small> </label>
                <input type="tel" name="alternate_mobile_no" id="alternate_mobile_no"
                    class="form-control @error('alternate_mobile_no') is-invalid @enderror" pattern="[0-9]{10}"
                    maxlength="10"
                    value="{{ old('alternate_mobile_no', isset($data['alternate_mobile_no']) ? $data['alternate_mobile_no'] : '') }}"
                    placeholder="Alternate Mobile No.">
                @error('alternate_mobile_no')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">

            <div class="col-md-4">
                <label class="mb-1" for="whatsapp">WhatsApp No. <small class="text-danger">*</small> </label>
                <input type="tel" name="whatsapp" id="whatsapp"
                    class="form-control @error('whatsapp') is-invalid @enderror" pattern="[0-9]{10}" maxlength="10"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" maxlength="10"
                    value="{{ old('whatsapp', isset($data['whatsapp_no']) ? $data['whatsapp_no'] : '') }}"
                    placeholder="WhatsApp No.">
                @error('whatsapp')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="mb-1" for="email">Email ID <small class="text-danger">*</small> </label>
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', isset($data['email']) ? $data['email'] : '') }}" placeholder="E-mail ID">
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="mb-1" for="aadhaar">Aadhaar No.</label>
                <input type="text" name="aadhaar" id="aadhaar"
                    class="form-control @error('aadhaar') is-invalid @enderror" pattern="[0-9]{12}"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)" maxlength="12"
                    value="{{ Auth::user()->aadhaar_no }}" readonly>
                @error('aadhaar')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row mb-3 d-none" id="otherStateDivs">
            <div class="col-md-4">
                <label class="mb-1" for="council_regn">State Council Registration Document No. <small
                        class="text-danger">*</small>
                </label>
                <input type="text" name="council_regn" id="council_regn"
                    class="form-control @error('council_regn') is-invalid @enderror"
                    value="{{ old('council_regn', isset($data['council_regn_no']) ? $data['council_regn_no'] : '') }}"
                    placeholder="State Council Registration Document No." disabled>
                @error('council_regn')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="mb-1" for="noc_council">NOC from the State Council Document No. <small
                        class="text-danger">*</small>
                </label>
                <input type="text" name="noc_council" id="noc_council"
                    class="form-control @error('noc_council') is-invalid @enderror"
                    value="{{ old('noc_council', isset($data['noc_state_council']) ? $data['noc_state_council'] : '') }}"
                    placeholder="NOC from the State Council Document No." disabled>
                @error('noc_council')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button type="submit" name="previous" class="btn btn-secondary">Previous</button>
            {{-- <button type="submit" name="save" class="btn btn-secondary save-progress">Save Progress</button> --}}
            <button type="submit" name="next" class="btn btn-primary">Next</button>
        </div>
    </div>
</form>
@push('scripts')
    <script>
        $(document).ready(function() {

            function getCheckOther() {
                $.ajax({
                    url: "{{ route('get-check-other') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === true) {
                            $("#otherStateDivs").removeClass('d-none').find('input').removeAttr(
                                'disabled');

                            var collegeNameField = `
                                <div class="form-group">
                                    <label class="mb-1" for="college_name">Name of the College <small class="text-danger">*</small> </label>
                                    <input type="text" name="college_name" id="college_name"
                                        class="form-control @error('college_name') is-invalid @enderror"
                                        value="{{ old('college_name', isset($data['college_name']) ? $data['college_name'] : '') }}">
                                    @error('college_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>`;


                        } else {
                            var collegeNameField = `
                                <div class="form-group">
                                    <label class="mb-1" for="college_name">Name of the College <small class="text-danger">*</small> </label>
                                     <select name="college_name" id="college_name" class="form-select  @error('college_name') is-invalid @enderror">
                                     </select>
                                    @error('college_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>`;

                            // $("#collegeNameContainer").empty();
                            // $('#collegeNameContainer').append(collegeNameField);
                            getInstitute();
                        }
                        $("#collegeNameContainer").empty();
                        $('#collegeNameContainer').append(collegeNameField);
                    }
                });
            }

            function getState() {
                $.ajax({
                    url: "{{ route('get-state') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#state').empty();
                        $('#state').append('<option value="">Select State</option>');

                        $.each(data.states, function(index, state) {

                            var selected = (state.id ==
                                "{{ old('state', $data['state'] ?? '') }}"
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
                        // url: "{{ route('get-courses', ['id' => ':id']) }}".replace(':id', courseTypeId),
                        url: '/get-courses/' + encodeURIComponent(courseTypeId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#course_name').empty();
                            $('#course_name').append('<option value="">Select Course Name</option>');

                            $.each(data.course_names, function(index, course) {
                                var selected = (course.id ==
                                    "{{ old('course_name', $data['course_id'] ?? '') }}"
                                ) ? 'selected' : '';
                                $('#course_name').append('<option value="' + course.id + '" ' +
                                    selected + '>' + course.course_name + '</option>');
                            });
                            otherCourse();
                        }
                    });
                } else {
                    $('#course_name').empty();
                    $('#course_name').append('<option value="">Select Course Name</option>');
                }
            }

            function getInstitute() {
                $.ajax({
                    url: "{{ route('get-college-name') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#college_name').empty();
                        $('#college_name').append('<option value="">Select College Name</option>');

                        $.each(data.institutes, function(index, inst) {
                            var selected = (inst.institute_id ==
                                "{{ old('college_name', $data['college_name'] ?? '') }}"
                            ) ? 'selected' : '';

                            $('#college_name').append('<option value="' + inst.institute_id +
                                '" ' +
                                selected + '>' + inst.name + '</option>');
                        });

                        var selectedOther = (999 ==
                            "{{ old('college_name', $data['college_name'] ?? '') }}"
                        ) ? 'selected' : '';

                        $('#college_name').append('<option value="999" ' + selectedOther +
                            '>Others</option>');
                        otherCollege();
                    }
                });
            }

            function otherCourse() {
                var course_name = $("#course_name").find(':selected').text();

                $('#other_course_group').remove();

                if (course_name == 'Other') {
                    var otherCourse = `
                        <div class="form-group col-md-4" id="other_course_group">
                            <label class="mb-1" for="other_course">Other Course Name <small class="text-danger">*</small></label>
                            <input type="text" name="other_course" id="other_course" class="form-control @error('other_course') is-invalid @enderror"
                               value="{{ old('other_course', isset($data['other_course']) ? $data['other_course'] : '') }}">
                            @error('other_course')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>`;

                    $("#course_name").parent().parent().find('.col-md-6').removeClass('col-md-6').addClass(
                        'col-md-4');
                    $("#course_name").closest('.form-group').after(otherCourse);
                } else {
                    $("#course_name").parent().parent().find('.col-md-4').removeClass('col-md-4').addClass(
                        'col-md-6');
                }
            }

            function otherCollege() {
                var college_name = $("#college_name").find(':selected').val();
                $('#other_college').remove();
                if (college_name === '999') {
                    var collegeOtherNameField = `
                        <div class="col-md-4" id="other_college">
                            <div class="form-group">
                                <label class="mb-1" for="jh_other_college_name">Name of the Other College <small class="text-danger">*</small> </label>
                                <input type="text" name="jh_other_college_name" id="jh_other_college_name"
                                    class="form-control @error('jh_other_college_name') is-invalid @enderror"
                                    value="{{ old('jh_other_college_name', isset($data['jh_other_college_name']) ? $data['jh_other_college_name'] : '') }}">
                                @error('jh_other_college_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>`;
                    $("#collegeNameContainer").parent().find('.col-md-6').removeClass('col-md-6').addClass(
                        'col-md-4');
                    $("#collegeNameContainer").after(collegeOtherNameField);

                } else {
                    $("#collegeNameContainer").parent().find('.col-md-4').removeClass('col-md-4').addClass(
                        'col-md-6');
                }
            }

            $('#course_type').on('change', function() {
                getCourse();
            });
            $('#course_name').on('change', function() {
                otherCourse();
            });
            $(document).on('change', '#college_name', function() {
                otherCollege();
            });

            getCheckOther();
            getCourse();
            getState();
        });
    </script>

    <script>
        $('form').on('submit', function(e) {
            // Show loader
            $("#jspc-loader").removeClass('d-none');
            $("#loading-text").text("Please Wait...");
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.step').parent().find('.active').removeClass('active');
            $('.step').eq(1).addClass('active');
        });
    </script>
@endpush
