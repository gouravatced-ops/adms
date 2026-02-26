{{-- resources/views/applicant/components/stepper-form/step1.blade.php --}}
@php
    #return getDebugIndex($applicant);
@endphp
<style>
    .allotment-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .year-input {
        width: 100px;
        height: 42px;
        border-radius: 6px;
        background: var(--surface);
        border: 1.5px solid var(--border);
    }

    .slash {
        font-weight: 600;
        font-size: 18px;
    }

    /* Invalid state */
    .invalid-year {
        border: 2px solid #dc3545 !important;
        background-color: #fff5f5;
    }

    .error-text {
        color: #dc3545;
        font-size: 12px;
    }
</style>
<form id="step1Form" method="POST">
    @csrf
    {{-- Property summary pill --}}
    <div class="property-summary">
        <div class="prop-pill">
            <span class="prop-pill-label">Division</span>
            <span class="prop-pill-value">{{ $applicant->division->name }}</span>
        </div>
        <div class="prop-pill">
            <span class="prop-pill-label">Sub Division</span>
            <span class="prop-pill-value">{{ $applicant->subDivision->name }}</span>
        </div>
        <div class="prop-pill">
            <span class="prop-pill-label">Property No.</span>
            <span class="prop-pill-value">{{ $applicant->property_number }}</span>
        </div>
        <div class="prop-pill">
            <span class="prop-pill-label">Property Type</span>
            <span class="prop-pill-value">{{ $applicant->propertyCategory->name }}-<span
                    style="color: green;">{{ $applicant->propertyType->name }}</span></span>
        </div>
    </div>
    {{-- ── Allottee Details ── --}}
    <div class="form-section" style="margin-top:10px;">
        <div class="form-grid" style="grid-template-columns: repeat(1, 1fr) !important;">
            <div class="field">
                <label class="field-label">
                    Schemes <span class="req-star">*</span>
                </label>
                <select name="scheme_id" class="custom-input">
                    <option value="">— Select scheme —</option>
                    @foreach ($getSchemeList as $scheme)
                        <option value="{{ $scheme->id }}"
                            {{ isset($applicant) && $applicant->scheme_id == $scheme->id ? 'selected' : '' }}>
                            {{ $scheme->scheme_code }} / {{ $scheme->scheme_name }}
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
                    value="{{ $applicant->application_no ?? '' }}" placeholder="e.g. 1234567890">
            </div>
            <div class="field">
                <label class="field-label">
                    Application Date <span class="req-star">*</span>
                </label>
                <input type="date" id="application_date" name="application_date" class="custom-input"
                    value="{{ $applicant->application_date ?? '' }}" placeholder="e.g. 2023-01-01">
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
            <div class="field">
                <label class="field-label">
                    Allotment No. <span class="req-star">*</span>
                </label>

                <div class="input-group allotment-group">
                    <input type="text" name="allotment_no" class="custom-input" value="{{ $allotment_no ?? '' }}"
                        placeholder="e.g. 1234567890" />

                    <span class="slash">/</span>

                    <input type="text" name="year" id="allotmentYear" class="year-input"
                        value="{{ $year ?? '' }}" placeholder="YYYY" maxlength="4" />
                </div>

                <small id="yearError" class="error-text"></small>
            </div>
            <div class="field">
                <label class="field-label">
                    Allotment Date <span class="req-star">*</span>
                </label>
                <input type="date" id="allotment_date" name="allotment_date" class="custom-input"
                    value="{{ $applicant->allotment_date ?? '' }}" placeholder="e.g. 2023-01-01">
            </div>
        </div>
        <div class="form-grid">
            <div class="field">
                <label class="field-label">
                    First Name <span class="req-star">*</span>
                </label>
                <div class="input-group">
                    @php $prefixes = ['Shri', 'Smt.', 'Miss', 'Dr.', 'Md.', 'Late', 'M/S']; @endphp
                    <select name="prefix" class="prefix-select" disabled>
                        @foreach ($prefixes as $prefix)
                            <option value="{{ $prefix }}"
                                {{ ($applicant->prefix ?? '') === $prefix ? 'selected' : '' }}>
                                {{ $prefix }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="allottee_name" class="custom-input"
                        value="{{ $applicant->allottee_name ?? '' }}" placeholder="e.g. Rajesh" disabled>
                    <input type="hidden" name="">
                    <input type="hidden" name="prefix" value="{{ $applicant->prefix ?? '' }}">
                    <input type="hidden" name="allottee_name" value="{{ $applicant->allottee_name ?? '' }}">
                </div>
            </div>

            <div class="field">
                <label class="field-label">Middle Name</label>
                <input type="text" name="allottee_middle_name" class="custom-input"
                    value="{{ $applicant->allottee_middle_name ?? '' }}" placeholder="Optional" disabled>
                <input type="hidden" name="allottee_middle_name"
                    value="{{ $applicant->allottee_middle_name ?? '' }}">
            </div>

            <div class="field">
                <label class="field-label">
                    Surname
                </label>
                <input type="text" name="allottee_surname" class="custom-input"
                    value="{{ $applicant->allottee_surname ?? '' }}" placeholder="e.g. Kumar" disabled>
                <input type="hidden" name="allottee_surname" value="{{ $applicant->allottee_surname ?? '' }}">
            </div>

            <div class="field">
                <label class="field-label">
                    First Name (Hindi) <span class="req-star">*</span>
                </label>
                <div class="input-group">
                    @php $prefixes = ['श्री', 'श्रीमती', 'कुमारी', 'डॉ.', 'मो.', 'स्वर्गीय', 'एम/एस']; @endphp
                    <select name="allottee_prefix_hindi" class="prefix-select">
                        @foreach ($prefixes as $prefix)
                            <option value="{{ $prefix }}"
                                {{ ($applicant->allottee_prefix_hindi ?? '') === $prefix ? 'selected' : '' }}>
                                {{ $prefix }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="allottee_name_hindi" class="custom-input"
                        value="{{ $applicant->allottee_name_hindi ?? '' }}" placeholder="e.g. राजेश">
                </div>
            </div>

            <div class="field">
                <label class="field-label">Middle Name (Hindi)</label>
                <input type="text" name="allottee_middle_hindi" class="custom-input"
                    value="{{ $applicant->allottee_middle_hindi ?? '' }}" placeholder="e.g. कुमार">
            </div>

            <div class="field">
                <label class="field-label">
                    Surname (Hindi) <span class="req-star">*</span>
                </label>
                <input type="text" name="allottee_surname_hindi" class="custom-input"
                    value="{{ $applicant->allottee_surname_hindi ?? '' }}" placeholder="e.g. कुमार">
            </div>

            <div class="field">
                <label class="field-label">
                    Relation Name <span class="req-star">*</span>
                </label>
                <div class="input-group">
                    @php $prefixes = ['Father', 'Mother', 'Husband', 'Wife']; @endphp
                    <select name="relation_prefix" class="prefix-select">
                        @foreach ($prefixes as $prefix)
                            <option value="{{ $prefix }}"
                                {{ ($applicant->relation_prefix ?? '') === $prefix ? 'selected' : '' }}>
                                {{ $prefix }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="relation_name" class="custom-input"
                        value="{{ $applicant->relation_name ?? '' }}"
                        placeholder="e.g. Father, Mother, Husband, Wife">
                </div>
            </div>

            <div class="field">
                <label class="field-label">
                    Marital Status <span class="req-star">*</span>
                </label>
                <select name="marital_status" class="custom-input">
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
                <select name="allottee_gender" class="custom-input">
                    <option value="Male"
                        {{ isset($applicant) && $applicant->allottee_gender == 'Male' ? 'selected' : '' }}>
                        Male</option>
                    <option value="Female"
                        {{ isset($applicant) && $applicant->allottee_gender == 'Female' ? 'selected' : '' }}>
                        Female</option>
                    <option value="Transgender"
                        {{ isset($applicant) && $applicant->allottee_gender == 'Transgender' ? 'selected' : '' }}>
                        Transgender</option>
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
                <select name="allottee_category" class="custom-input">
                    <option value="General"
                        {{ isset($applicant) && $applicant->allottee_category == 'General' ? 'selected' : '' }}>General
                    </option>
                    <option value="OBC"
                        {{ isset($applicant) && $applicant->allottee_category == 'OBC' ? 'selected' : '' }}>OBC
                    </option>
                    <option value="SC"
                        {{ isset($applicant) && $applicant->allottee_category == 'SC' ? 'selected' : '' }}>SC
                    </option>
                    <option value="ST"
                        {{ isset($applicant) && $applicant->allottee_category == 'ST' ? 'selected' : '' }}>ST
                    </option>
                    <option value="EWS"
                        {{ isset($applicant) && $applicant->allottee_category == 'EWS' ? 'selected' : '' }}>EWS
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
    <div class="form-section">
        <div class="bilingual-grid member-card" style="background: #faf9f6 !important;">
            <div class="section-header gradient-header" style="background: linear-gradient(90deg, #f59e0b, #f97316);">
                <div class="section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor"
                            stroke-width="1.8" />
                        <line x1="3" y1="9" x2="21" y2="9" stroke="currentColor"
                            stroke-width="1.8" />
                        <line x1="8" y1="3" x2="8" y2="7" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" />
                        <line x1="16" y1="3" x2="16" y2="7" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </div>
                <div>
                    <h3 class="section-title">Date of Birth of Applicant at the time of Application
                        (In Numbers & Figures both)</h3>
                </div>
            </div>
            <div class="section-header gradient-header" style="background: linear-gradient(90deg, #f59e0b, #f97316);">
                <div class="section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor"
                            stroke-width="1.8" />
                        <line x1="3" y1="9" x2="21" y2="9" stroke="currentColor"
                            stroke-width="1.8" />
                        <line x1="8" y1="3" x2="8" y2="7" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" />
                        <line x1="16" y1="3" x2="16" y2="7" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </div>
                <div>
                    <h3 class="section-title">आवेदन की तिथि पर उम्र (अंक एवं अक्षर दोनों में )</h3>
                </div>
            </div>
            <div class="field">
                <label class="field-label"> Number
                </label>
                <input type="text" name="age_number_of_birth_application" class="custom-input"
                    value="{{ $applicant->age_number_of_birth_application ?? '' }}" placeholder="e.g 30">
            </div>

            <div class="field">
                <label class="field-label"> अंक
                </label>
                <input type="text" name="age_number_of_birth_application" class="custom-input"
                    value="{{ $applicant->age_number_of_birth_application ?? '' }}" placeholder="e.g 30">
            </div>

            <div class="field">
                <label class="field-label"> Word
                </label>
                <input type="text" name="age_word_of_birth_application" class="custom-input"
                    value="{{ $applicant->age_word_of_birth_application ?? '' }}" placeholder="e.g. Thirty">
            </div>

            <div class="field">
                <label class="field-label"> अक्षर
                </label>
                <input type="text" name="age_word_hindi_of_birth_application" class="custom-input"
                    value="{{ $applicant->age_word_hindi_of_birth_application ?? '' }}" placeholder="e.g. तीस">
            </div>
        </div>
    </div>
</form>
