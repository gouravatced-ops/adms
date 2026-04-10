@extends('admin.layouts.main')
@section('admin-content')
<div class="container-xxl flex-grow-1">
    <h6 class="py-3 mb-2">
        <span class="invert-text-white">Dashboard / Data Entry / Edit Allottee</span>
    </h6>

    <div class="card mb-4">
        <h5 class="card-header text-white bg-info">
            <i class="bx bx-plus me-2"></i>Edit Allottee Details
        </h5>
        <div class="card-body mt-2">
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <form action="{{ route('admin.schemes.store') }}" method="POST" class="row g-3 align-items-end"
                id="AllotteeStep1Form">
                @csrf
                <div class="row g-3">

                    <!-- Application No -->
                    <div class="col-md-3">
                        <label for="application_no" class="form-label">
                            Application No. <small class="text-danger">*</small>
                        </label>
                        <input type="text" name="application_no" id="application_no"
                            class="form-control @error('application_no') is-invalid @enderror"
                            value="{{ old('application_no', $applicant->application_no ?? '') }}"
                            placeholder="Enter Application No." required>
                        @error('application_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Application Date -->
                    <div class="col-md-3">
                        <label class="form-label">
                            Application Date <small class="text-danger">*</small>
                        </label>

                        <div class="row g-2">
                            <div class="col-4">
                                <select name="application_day" class="form-select" required>
                                    <option value="">DD</option>
                                    @for ($d = 1; $d <= 31; $d++)
                                        @php $day=str_pad($d, 2, '0' , STR_PAD_LEFT); @endphp
                                        <option value="{{ $day }}"
                                        {{ old('application_day', $applicant->application_day ?? '') == $day ? 'selected' : '' }}>
                                        {{ $day }}
                                        </option>
                                        @endfor
                                </select>
                            </div>

                            <div class="col-4">
                                <select name="application_month" class="form-select" required>
                                    <option value="">MM</option>
                                    @for ($m = 1; $m <= 12; $m++)
                                        @php $month=str_pad($m, 2, '0' , STR_PAD_LEFT); @endphp
                                        <option value="{{ $month }}"
                                        {{ old('application_month', $applicant->application_month ?? '') == $month ? 'selected' : '' }}>
                                        {{ $month }}
                                        </option>
                                        @endfor
                                </select>
                            </div>

                            <div class="col-4">
                                <select name="application_year" class="form-select" required>
                                    <option value="">YYYY</option>
                                    @for ($y = date('Y'); $y >= 1960; $y--)
                                    <option value="{{ $y }}"
                                        {{ old('application_year', $applicant->application_year ?? '') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    @php
                    if ($applicant->allotment_no) {
                        $parts = explode('/', $applicant->allotment_no);
                        $allotment_no = $parts[0] ?? '';
                        $year = $parts[1] ?? '';
                    } else {
                        $allotment_no = '';
                        $year = '';
                    }
                    @endphp
                    <!-- Allotment No -->
                    <div class="col-md-3">
                        <label for="allotment_no" class="form-label">
                            Allotment No. <small class="text-danger">*</small>
                        </label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="text" name="allotment_no" class="form-control only-number"
                                    value="{{ old('allotment_no', $allotment_no ?? '') }}" placeholder="e.g. 1234567890" />
                            </div>
                            <div class="col-6">
                                <input type="text" name="year" id="allotmentYear" class="form-control only-number"
                                    value="{{ old('year', $year ?? '') }}" placeholder="YYYY" maxlength="4" />
                            </div>
                        </div>
                    </div>

                    <!-- Allotment Date -->
                    <div class="col-md-3">
                        <label class="form-label">
                            Allotment Date <small class="text-danger">*</small>
                        </label>

                        <div class="row g-2">
                            <div class="col-4">
                                <select name="allotment_day" class="form-select allotment-date" required>
                                    <option value="">DD</option>
                                    @for ($d = 1; $d <= 31; $d++)
                                        @php $day=str_pad($d, 2, '0' , STR_PAD_LEFT); @endphp
                                        <option value="{{ $day }}" {{ old('allotment_day', $applicant->allotment_day ?? '') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col-4">
                                <select name="allotment_month" class="form-select allotment-date" required>
                                    <option value="">MM</option>
                                    @for ($m = 1; $m <= 12; $m++)
                                        @php $month=str_pad($m, 2, '0' , STR_PAD_LEFT); @endphp
                                        <option value="{{ $month }}" {{ old('allotment_month', $applicant->allotment_month ?? '') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col-4">
                                <select name="allotment_year" id="allotment_year" class="form-select allotment-date" required>
                                    <option value="">YYYY</option>
                                    @for ($y = date('Y'); $y >= 1960; $y--)
                                    <option value="{{ $y }}" {{ old('allotment_year', $applicant->allotment_year ?? '') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="col-md-4">
                        <div class="row g-2">
                            <div class="col-4">
                                <label class="form-label">Prefix </label>
                                <select name="prefix" class="form-select">
                                    @foreach (['Shri', 'Smt.', 'Miss', 'Dr.', 'Md.', 'Late', 'M/S', 'Maj.', 'Capt.'] as $prefix)
                                    <option value="{{ $prefix }}"
                                        {{ old('prefix', $applicant->prefix ?? '') == $prefix ? 'selected' : '' }}>
                                        {{ $prefix }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-8">
                                <label class="form-label">First Name <small class="text-danger">*</small></label>
                                <input type="text" name="allottee_name" class="form-control"
                                    value="{{ old('allottee_name', $applicant->allottee_name ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="allottee_middle_name" class="form-control"
                            value="{{ old('allottee_middle_name', $applicant->allottee_middle_name ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Surname <small class="text-danger">*</small></label>
                        <input type="text" name="allottee_surname" class="form-control"
                            value="{{ old('allottee_surname', $applicant->allottee_surname ?? '') }}">
                    </div>

                    <!-- Hindi Name -->
                    <div class="col-md-4">
                        <div class="row g-2">
                            <div class="col-4">
                                <label class="form-label">Prefix </label>
                                <select name="allottee_prefix_hindi" class="form-select">
                                    @foreach (['श्री', 'श्रीमती', 'सुश्री', 'डॉ.', 'मो.', 'स्व०', 'मेसर्स', 'मेजर', 'कैप्टन'] as $prefix)
                                    <option value="{{ $prefix }}"
                                        {{ old('allottee_prefix_hindi', $applicant->allottee_prefix_hindi ?? '') == $prefix ? 'selected' : '' }}>
                                        {{ $prefix }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-8">
                                <label class="form-label">First Name <small class="text-danger">*</small></label>
                                <input type="text" name="allottee_name_hindi" class="form-control"
                                    value="{{ old('allottee_name_hindi', $applicant->allottee_name_hindi ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Middle Name (Hindi)</label>
                        <input type="text" name="allottee_middle_hindi" class="form-control"
                            value="{{ old('allottee_middle_hindi', $applicant->allottee_middle_hindi ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Surname (Hindi) <small class="text-danger">*</small></label>
                        <input type="text" name="allottee_surname_hindi" class="form-control"
                            value="{{ old('allottee_surname_hindi', $applicant->allottee_surname_hindi ?? '') }}">
                    </div>

                    <!-- Relation -->
                    <div class="col-md-4">
                        <div class="row g-2">
                            <div class="col-4">
                                <label class="form-label">Relation Prefix <small class="text-danger">*</small></label>
                                <select name="allottee_relation_type" class="form-select">
                                    <option value="">Select Relation</option>
                                    @foreach (['Father', 'Mother', 'Husband', 'Wife'] as $relation)
                                    <option value="{{ $relation }}"
                                        {{ old('allottee_relation_type', $applicant->allottee_relation_type ?? '') == $relation ? 'selected' : '' }}>
                                        {{ $relation }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-8">
                                <label class="form-label">Relation Name <small class="text-danger">*</small></label>
                                <input type="text" name="relation_name" class="form-control"
                                    value="{{ old('relation_name', $applicant->relation_name ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Marital Status & Gender -->
                    <div class="col-md-4">
                        <label class="form-label">Marital Status <small class="text-danger">*</small></label>
                        <select name="marital_status" class="form-select">
                            <option value="">Select Marital Status</option>
                            @foreach (['Single', 'Married', 'Widow', 'Divorced'] as $status)
                            <option value="{{ $status }}"
                                {{ old('marital_status', $applicant->marital_status ?? '') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Gender <small class="text-danger">*</small></label>
                        <select name="allottee_gender" class="form-select">
                            <option value="">Select Gender</option>
                            @foreach (['Male', 'Female', 'Other'] as $gender)
                            <option value="{{ $gender }}"
                                {{ old('allottee_gender', $applicant->allottee_gender ?? '') == $gender ? 'selected' : '' }}>
                                {{ $gender }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category -->
                    <div class="col-md-3">
                        <label class="form-label">Category <small class="text-danger">*</small></label>

                        @php
                        $categories = [
                        'General' => 'General',
                        'General (PwD)' => 'General (PwD)',
                        'Scheduled Caste (SC)' => 'Scheduled Caste (SC)',
                        'Scheduled Caste (SC) (PwD)' => 'Scheduled Caste (SC) (PwD)',
                        'Scheduled Tribe (ST)' => 'Scheduled Tribe (ST)',
                        'Scheduled Tribe (ST) (PwD)' => 'Scheduled Tribe (ST) (PwD)',
                        'Other Backward Class (OBC)' => 'Other Backward Class (OBC)',
                        'Other Backward Class (OBC) (PwD)' => 'Other Backward Class (OBC) (PwD)',
                        'Retired Government Servant' => 'Retired Government Servant',
                        'Govt. Servant retiring within one year' => 'Govt. Servant retiring within one year',
                        'Armed Forces Personnel' => 'Armed Forces Personnel',
                        'Ex-Servicemen' => 'Ex-Servicemen',
                        'Abandoned' => 'Abandoned',
                        'Destitute Widows' => 'Destitute Widows',
                        'Vidhaanmandal' => 'Vidhaanmandal',
                        'Vidhansabha' => 'Vidhansabha',
                        ];
                        @endphp

                        <select name="allottee_category" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $value => $label)
                            <option value="{{ $value }}" {{ old('allottee_category', $applicant->allottee_category ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Religion -->
                    <div class="col-md-3">
                        <label class="form-label">Religion <small class="text-danger">*</small></label>
                        {{-- Religion --}}
                        <select name="allottee_religion" class="form-select">
                            <option value="">Select Religion</option>

                            @foreach (['Hindu','Muslim','Christian','Sikh','Buddhist','Jain','Parsi','Other'] as $religion)
                            <option value="{{ $religion }}"
                                {{ old('allottee_religion', $applicant->allottee_religion ?? '') == $religion ? 'selected' : '' }}>
                                {{ $religion }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nationality -->
                    <div class="col-md-3">
                        <label class="form-label">Nationality</label>
                        {{-- Nationality --}}
                        <input type="text" name="allottee_nationality" class="form-control"
                            value="{{ old('allottee_nationality', $applicant->allottee_nationality ?? 'Indian') }}"
                            readonly>
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-3">
                        <label class="form-label">Date of Birth</label>
                        <div class="row g-2">
                            <div class="col-4">
                                <select name="date_of_birth_day" class="form-select">
                                    <option value="">DD</option>
                                    @for ($d = 1; $d <= 31; $d++)
                                        @php $day=str_pad($d, 2, '0' , STR_PAD_LEFT); @endphp
                                        <option value="{{ $day }}"
                                        {{ old('date_of_birth_day', $applicant->date_of_birth_day ?? '') == $day ? 'selected' : '' }}>
                                        {{ $day }}
                                        </option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col-4">
                                <select name="date_of_birth_month" class="form-select">
                                    <option value="">MM</option>
                                    @for ($m = 1; $m <= 12; $m++)
                                        @php $month=str_pad($m, 2, '0' , STR_PAD_LEFT); @endphp
                                        <option value="{{ $month }}"
                                        {{ old('date_of_birth_month', $applicant->date_of_birth_month ?? '') == $month ? 'selected' : '' }}>
                                        {{ $month }}
                                        </option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col-4">
                                <select name="date_of_birth_year" class="form-select">
                                    <option value="">YYYY</option>
                                    @for ($y = date('Y'); $y >= 1900; $y--)
                                    <option value="{{ $y }}"
                                        {{ old('date_of_birth_year', $applicant->date_of_birth_year ?? '') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    
                    <!-- PAN and Aadhaar -->
                    <div class="col-md-4 d-none" id="pan_div">
                        <label class="form-label">PAN Card Number <small class="text-danger">*</small></label>
                        <input type="text" name="pan_card_number" id="pan_no" class="form-control"
                            value="{{ old('pan_card_number', $applicant->pan_card_number ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Aadhaar Card Number <small class="text-danger">*</small></label>
                        <input type="text" name="aadhar_card_number" class="form-control"
                            value="{{ old('aadhar_card_number', $applicant->aadhar_card_number ?? '') }}">
                    </div>

                    <!-- DOB Remark -->
                    <div class="col-md-4">
                        <label class="form-label">Remark (If DOB N/A)</label>
                        <input name="remarks_for_dob" class="form-control" value="{{ old('remarks_for_dob', $applicant->remarks_for_dob ?? '') }}"
                            placeholder="Enter reason if Date of Birth is not available">
                    </div>
                </div>
                <!-- ACTION BUTTONS -->
                <div class="col-12 d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Save Changes
                    </button>

                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bx bx-reset me-1"></i> Reset
                    </button>

                    <a href="{{ route('admin.schemes.index') }}" class="btn btn-outline-danger ms-auto">
                        <i class="bx bx-x me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const allotmentYear = document.getElementById('allotment_year');
        const panDiv = document.getElementById('pan_div');
        const panInput = document.getElementById('pan_no');

        function togglePanField() {
            const year = parseInt(allotmentYear.value);

            if (year && year <= 2010) {
                panDiv.classList.remove('d-none');
                panInput.setAttribute('required', 'required');
            } else {
                panDiv.classList.add('d-none');
                panInput.removeAttribute('required');
                panInput.value = '';
            }
        }

        allotmentYear.addEventListener('change', togglePanField);
        togglePanField();
    });
</script>
@endsection