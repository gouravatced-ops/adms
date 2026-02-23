{{-- resources/views/applicant/components/stepper-form/step1.blade.php --}}
@php
    $quarterTypes = getQuarterType();
    $getSchemeList = getSchemeList();
@endphp
<form id="step1Form" method="POST">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applicant->id ?? '' }}">
    {{-- Property summary pill --}}
    <div class="property-summary">
        <div class="prop-pill">
            <span class="prop-pill-label">Unit Type</span>
            <span class="prop-pill-value">MIG Plot</span>
        </div>
        <div class="prop-pill">
            <span class="prop-pill-label">Area</span>
            <span class="prop-pill-value">1800 sq.ft</span>
        </div>
        <div class="prop-pill">
            <span class="prop-pill-label">Location</span>
            <span class="prop-pill-value">Medininagar</span>
        </div>
        <div class="prop-pill">
            <span class="prop-pill-label">Division</span>
            <span class="prop-pill-value">Daltonganj</span>
        </div>
    </div>
    {{-- ── Allottee Details ── --}}
    <div class="form-section" style="margin-top:10px;">
        <div class="form-grid" style="grid-template-columns: repeat(1, 1fr) !important;">
            <div class="field">
                <label class="field-label">
                    Schemes <span class="req-star">*</span>
                </label>
                <select name="scheme" class="custom-input" required>
                    <option value="">— Select scheme —</option>
                    @foreach ($getSchemeList as $scheme)
                        <option value="{{ $scheme->id }}"
                            {{ isset($applicant) && $applicant->scheme_id == $scheme->id ? 'selected' : '' }}>
                            {{ $scheme->scheme_code }} - {{ $scheme->scheme_name }}
                    @endforeach
                    </option>
                </select>
            </div>
        </div>

        <div class="form-grid" style="grid-template-columns: repeat(4, 1fr) !important;">
            <div class="field">
                <label class="field-label">
                    Application No. <span class="req-star">*</span>
                </label>
                <input type="text" name="application_no" class="custom-input"
                    value="{{ $applicant->application_number ?? '' }}" placeholder="e.g. 1234567890" required>
            </div>
            <div class="field">
                <label class="field-label">
                    Application Date <span class="req-star">*</span>
                </label>
                <input type="date" id="application_date" name="application_date" class="custom-input"
                    value="{{ $applicant->application_date ?? '' }}" placeholder="e.g. 2023-01-01" required>
            </div>
            <div class="field">
                <label class="field-label">
                    Allotment No. <span class="req-star">*</span>
                </label>
                <input type="text" name="allotment_no" class="custom-input"
                    value="{{ $applicant->allotment_number ?? '' }}" placeholder="e.g. 1234567890" required>
            </div>
            <div class="field">
                <label class="field-label">
                    Allotment Date <span class="req-star">*</span>
                </label>
                <input type="date" id="allotment_date" name="allotment_date" class="custom-input"
                    value="{{ $applicant->allotment_date ?? '' }}" placeholder="e.g. 2023-01-01" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="field">
                <label class="field-label">
                    First Name <span class="req-star">*</span>
                </label>
                <input type="text" name="first_name" class="custom-input" value="{{ $applicant->first_name ?? '' }}"
                    placeholder="e.g. Rajesh">
            </div>

            <div class="field">
                <label class="field-label">Middle Name</label>
                <input type="text" name="middle_name" class="custom-input"
                    value="{{ $applicant->middle_name ?? '' }}" placeholder="Optional">
            </div>

            <div class="field">
                <label class="field-label">
                    Last Name <span class="req-star">*</span>
                </label>
                <input type="text" name="last_name" class="custom-input" value="{{ $applicant->last_name ?? '' }}"
                    placeholder="e.g. Kumar">
            </div>

            <div class="field">
                <label class="field-label">
                    First Name (Hindi) <span class="req-star">*</span>
                </label>
                <input type="text" name="first_name_hindi" class="custom-input"
                    value="{{ $applicant->first_name_hindi ?? '' }}" placeholder="e.g. राजेश">
            </div>

            <div class="field">
                <label class="field-label">Middle Name (Hindi)</label>
                <input type="text" name="middle_name_hindi" class="custom-input"
                    value="{{ $applicant->middle_name_hindi ?? '' }}" placeholder="Optional">
            </div>

            <div class="field">
                <label class="field-label">
                    Last Name (Hindi) <span class="req-star">*</span>
                </label>
                <input type="text" name="last_name_hindi" class="custom-input"
                    value="{{ $applicant->last_name_hindi ?? '' }}" placeholder="e.g. कुमार">
            </div>

            <div class="field">
                <label class="field-label">
                    Father's Name / Mother's Name / Husband's Name / Wife's Name <span class="req-star">*</span>
                </label>
                <input type="text" name="fathers_name" class="custom-input"
                    value="{{ $applicant->fathers_name ?? '' }}" placeholder="Enter father's full name">
            </div>

            <div class="field">
                <label class="field-label">
                    Marital Status <span class="req-star">*</span>
                </label>
                <select name="marital_status" class="custom-input">
                    <option value="">— Select status —</option>
                    <option value="Married"
                        {{ isset($applicant) && $applicant->marital_status == 'Married' ? 'selected' : '' }}>Married
                    </option>
                    <option value="Unmarried"
                        {{ isset($applicant) && $applicant->marital_status == 'Unmarried' ? 'selected' : '' }}>
                        Unmarried
                    </option>
                    <option value="Divorced"
                        {{ isset($applicant) && $applicant->marital_status == 'Divorced' ? 'selected' : '' }}>Divorced
                    </option>
                    <option value="Widowed"
                        {{ isset($applicant) && $applicant->marital_status == 'Widowed' ? 'selected' : '' }}>Widowed
                    </option>
                </select>
            </div>

            <div class="field">
                <label class="field-label">
                    Gender <span class="req-star">*</span>
                </label>
                <select name="gender" class="custom-input">
                    <option value="">— Select gender —</option>
                    <option value="Male" {{ isset($applicant) && $applicant->gender == 'Male' ? 'selected' : '' }}>
                        Male</option>
                    <option value="Female"
                        {{ isset($applicant) && $applicant->gender == 'Female' ? 'selected' : '' }}>
                        Female</option>
                    {{-- <option value="Transgender"  {{ isset($applicant) && $applicant->gender == 'Transgender'  ? 'selected' : '' }}>Transgender</option> --}}
                </select>
            </div>

            <div class="field" id="pan-field" style="display:none;">
                <label class="field-label">
                    PAN Card Number <span class="req-star" id="pan-star">*</span>
                </label>
                <input type="text" id="pan_card_number" name="pan_card_number" placeholder="ABCDE1234F"
                    class="custom-input" value="{{ $applicant->pan_card_number ?? '' }}"
                    pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" maxlength="10" style="text-transform:uppercase">
            </div>

            <div class="field" id="aadhar-field" style="display:none;">
                <label class="field-label">
                    Aadhar Card Number <span class="req-star" id="aadhar-star">*</span>
                </label>
                <input type="text" id="aadhar_card_number" name="aadhar_card_number" class="custom-input"
                    value="{{ $applicant->aadhar_card_number ?? '' }}"
                    placeholder="12-digit Aadhar number, no spaces" pattern="[0-9]{12}" maxlength="12">
            </div>

            <div class="field">
                <label class="field-label">
                    Category <span class="req-star">*</span>
                </label>
                <select name="caste" class="custom-input">
                    <option value="">— Select caste —</option>
                    <option value="General" {{ isset($applicant) && $applicant->caste == 'General' ? 'selected' : '' }}>General</option>
                    <option value="OBC" {{ isset($applicant) && $applicant->caste == 'OBC' ? 'selected' : '' }}>OBC
                    </option>
                    <option value="SC" {{ isset($applicant) && $applicant->caste == 'SC' ? 'selected' : '' }}>SC
                    </option>
                    <option value="ST" {{ isset($applicant) && $applicant->caste == 'ST' ? 'selected' : '' }}>ST
                    </option>
                    <option value="EWS" {{ isset($applicant) && $applicant->caste == 'EWS' ? 'selected' : '' }}>EWS
                    </option>
                </select>
            </div>


            <div class="field">
                <label class="field-label">
                    Date of Birth <span class="req-star">*</span>
                </label>
                <input type="date" name="date_of_birth" class="custom-input"
                    value="{{ isset($applicant) ? date('Y-m-d', strtotime($applicant->date_of_birth)) : '' }}"
                    required>
            </div>
        </div>
    </div>
</form>
