{{-- resources/views/applicant/components/stepper-form/step1.blade.php --}}
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
@php
    #return getDebugIndex($applicant);
@endphp
<form id="step1Form" method="POST">
    @csrf
    <input type="hidden" name="allottee_id" value="{{ $applicant->id ?? '' }}">
    <input type="hidden" name="register_id" value="{{ $applicant->register_id ?? '' }}">
    <input type="hidden" name="division_id" value="{{ $applicant->division_id ?? '' }}">
    <input type="hidden" name="subdivision_id" value="{{ $applicant->subdivision_id ?? '' }}">
    <input type="hidden" name="pcategory_id" value="{{ $applicant->pcategory_id ?? '' }}">
    <input type="hidden" name="property_type_id" value="{{ $applicant->property_type_id ?? '' }}">
    <input type="hidden" name="quarter_id" value="{{ $applicant->quarter_id ?? '' }}">
    <input type="hidden" name="property_number" value="{{ $applicant->property_number ?? '' }}">
    <input type="hidden" name="quarter_income_code" value="{{ $applicant->quarterType->quarter_code ?? '' }}">
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
        {{-- <div class="form-grid" style="grid-template-columns: repeat(1, 1fr) !important;">
            <div class="field">
                <label class="field-label">
                    Schemes
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
        </div> --}}

        <div class="form-grid" style="grid-template-columns: repeat(1, 1fr) !important;">
            <div class="field">
                <label class="field-label">
                    Name Transfer Date <span class="req-star">*</span>
                </label>
                <div class="date-group">
                    <!-- Day -->
                    <select name="allotment_day" class="custom-input">
                        <option value="">दिन / Day</option>
                        <?php 
                            $selectedDay = $applicant->allotment_day ?? '';
                            for ($d = 1; $d <= 31; $d++): 
                                $day = str_pad($d, 2, '0', STR_PAD_LEFT);
                        ?>
                        <option value="<?= $day ?>" <?= $selectedDay == $day ? 'selected' : '' ?>>
                            <?= $day ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                    <!-- Month -->
                    <select name="allotment_month" class="custom-input">
                        <option value="">माह / Month</option>
                        <?php 
                            $selectedMonth = $applicant->allotment_month ?? '';
                            for ($m = 1; $m <= 12; $m++): 
                                $month = str_pad($m, 2, '0', STR_PAD_LEFT);
                        ?>
                        <option value="<?= $month ?>" <?= $selectedMonth == $month ? 'selected' : '' ?>>
                            <?= $month ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                    <!-- Year -->
                    <select name="allotment_year" id="allotment_year" class="custom-input">
                        <option value="">वर्ष / Year</option>
                        <?php 
                            $selectedYear = $applicant->allotment_year ?? '';
                            $currentYear = date('Y');
                            for ($y = $currentYear; $y >= $applicant->allotment_year; $y--): 
                        ?>
                        <option value="<?= $y ?>" <?= $selectedYear == $y ? 'selected' : '' ?>>
                            <?= $y ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-grid">
            <div class="field">
                <label class="field-label">
                    First Name <span class="req-star">*</span>
                </label>
                <div class="input-group">
                    @php $prefixes = ['Shri', 'Smt.', 'Miss', 'Dr.', 'Md.', 'Late', 'M/S' , 'Maj.' , 'Capt.']; @endphp
                    <select name="prefix" class="prefix-select">
                        @foreach ($prefixes as $prefix)
                            <option value="{{ $prefix }}"
                                {{ ($applicant->prefix ?? '') === $prefix ? 'selected' : '' }}>
                                {{ $prefix }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="allottee_name" class="custom-input only-alphabet"
                        value="{{ $applicant->allottee_name ?? '' }}" placeholder="e.g. Rajesh">
                    <input type="hidden" name="">
                </div>
            </div>

            <div class="field">
                <label class="field-label">Middle Name</label>
                <input type="text" name="allottee_middle_name" class="custom-input only-alphabet"
                    value="{{ $applicant->allottee_middle_name ?? '' }}" placeholder="Optional">
            </div>

            <div class="field">
                <label class="field-label">
                    Last Name
                </label>
                <input type="text" name="allottee_surname" class="custom-input only-alphabet"
                    value="{{ $applicant->allottee_surname ?? '' }}" placeholder="e.g. Kumar">
            </div>

            <div class="field">
                <label class="field-label">
                    First Name (Hindi) <span class="req-star">*</span>
                </label>
                <div class="input-group">
                    @php $prefixes = ['श्री', 'श्रीमती', 'सुश्री', 'डॉ.', 'मो.', 'स्व०', 'मेसर्स' , 'मेजर', 'कैप्टन']; @endphp
                    <select name="allottee_prefix_hindi" class="prefix-select">
                        @foreach ($prefixes as $prefix)
                            <option value="{{ $prefix }}"
                                {{ ($applicant->allottee_prefix_hindi ?? '') === $prefix ? 'selected' : '' }}>
                                {{ $prefix }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="allottee_name_hindi" class="custom-input only-hindi"
                        value="{{ $applicant->allottee_name_hindi ?? '' }}" placeholder="e.g. राजेश">
                </div>
            </div>

            <div class="field">
                <label class="field-label">Middle Name (Hindi)</label>
                <input type="text" name="allottee_middle_hindi" class="custom-input only-hindi"
                    value="{{ $applicant->allottee_middle_hindi ?? '' }}" placeholder="e.g. कुमार">
            </div>

            <div class="field">
                <label class="field-label">
                    Last Name (Hindi)
                </label>
                <input type="text" name="allottee_surname_hindi" class="custom-input only-hindi"
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
                    <input type="text" name="relation_name" class="custom-input only-alphabet"
                        value="{{ $applicant->relation_name ?? '' }}"
                        placeholder="e.g. Father, Mother, Husband, Wife">
                </div>
            </div>

            <div class="field">
                <label class="field-label">
                    Marital Status <span class="req-star">*</span>
                </label>
                <select name="marital_status" class="custom-input">
                    <option value="Unmarried"
                        {{ isset($applicant) && $applicant->marital_status == 'Unmarried' ? 'selected' : '' }}>
                        Unmarried
                    </option>
                    <option value="Married"
                        {{ isset($applicant) && $applicant->marital_status == 'Married' ? 'selected' : '' }}>Married
                    </option>
                    <option value="Divorced"
                        {{ isset($applicant) && $applicant->marital_status == 'Divorced' ? 'selected' : '' }}>Divorced
                    </option>
                    <option value="Widow"
                        {{ isset($applicant) && $applicant->marital_status == 'Widow' ? 'selected' : '' }}>Widow
                    </option>
                    <option value="Widower"
                        {{ isset($applicant) && $applicant->marital_status == 'Widower' ? 'selected' : '' }}>Widower
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
                    PAN Card Number
                </label>
                <input type="text" id="pan_card_number" name="pan_card_number" placeholder="ABCDE1234F"
                    class="custom-input pan-input" value="{{ $applicant->pan_card_number ?? '' }}" maxlength="10"
                    style="text-transform:uppercase">
            </div>

            <div class="field" id="aadhar-field" style="display:none;">
                <label class="field-label">
                    Aadhar Card Number
                </label>
                <input type="text" id="aadhar_card_number" name="aadhar_card_number" class="custom-input"
                    value="{{ $applicant->aadhar_card_number ?? '' }}"
                    placeholder="12-digit Aadhar number, no spaces" pattern="[0-9]{12}" maxlength="12">
            </div>


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

                $selectedCategory = old('allottee_category', $applicant->allottee_category ?? '');
            @endphp

            <div class="field">
                <label class="field-label">
                    Category <span class="req-star">*</span>
                </label>
                <select name="allottee_category" class="custom-input" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $value => $label)
                        <option value="{{ $value }}" {{ $selectedCategory === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="field-label">
                    Religion <span class="req-star">*</span>
                </label>

                <select name="allottee_religion" class="custom-input">
                    <option value="">Select Religion</option>

                    <option value="Hindu"
                        {{ isset($applicant) && $applicant->allottee_religion == 'Hindu' ? 'selected' : '' }}>
                        Hindu
                    </option>

                    <option value="Muslim"
                        {{ isset($applicant) && $applicant->allottee_religion == 'Muslim' ? 'selected' : '' }}>
                        Muslim
                    </option>

                    <option value="Christian"
                        {{ isset($applicant) && $applicant->allottee_religion == 'Christian' ? 'selected' : '' }}>
                        Christian
                    </option>

                    <option value="Sikh"
                        {{ isset($applicant) && $applicant->allottee_religion == 'Sikh' ? 'selected' : '' }}>
                        Sikh
                    </option>

                    <option value="Buddhist"
                        {{ isset($applicant) && $applicant->allottee_religion == 'Buddhist' ? 'selected' : '' }}>
                        Buddhist
                    </option>

                    <option value="Jain"
                        {{ isset($applicant) && $applicant->allottee_religion == 'Jain' ? 'selected' : '' }}>
                        Jain
                    </option>

                    <option value="Parsi"
                        {{ isset($applicant) && $applicant->allottee_religion == 'Parsi' ? 'selected' : '' }}>
                        Parsi
                    </option>

                    <option value="Other"
                        {{ isset($applicant) && $applicant->allottee_religion == 'Other' ? 'selected' : '' }}>
                        Other
                    </option>

                </select>
            </div>

            <div class="field">
                <label class="field-label">Nationality</label>
                <input type="text" name="allottee_nationality" class="custom-input only-alphabet" value="Indian">
            </div>

            <div class="field">
                <label class="field-label">
                    Date of Birth (जन्म तिथि)
                </label>
                <div class="input-group date-group">
                    <!-- Day -->
                    <select name="date_of_birth_day" class="custom-input">
                        <option value="">दिन / Day</option>
                        <?php 
                            $selectedDay = $applicant->date_of_birth_day ?? '';
                            for ($d = 1; $d <= 31; $d++): 
                                $day = str_pad($d, 2, '0', STR_PAD_LEFT);
                        ?>
                        <option value="<?= $day ?>" <?= $selectedDay == $day ? 'selected' : '' ?>>
                            <?= $day ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                    <!-- Month -->
                    <select name="date_of_birth_month" class="custom-input">
                        <option value="">माह / Month</option>
                        <?php 
                            $selectedMonth = $applicant->date_of_birth_month ?? '';
                            for ($m = 1; $m <= 12; $m++): 
                                $month = str_pad($m, 2, '0', STR_PAD_LEFT);
                        ?>
                        <option value="<?= $month ?>" <?= $selectedMonth == $month ? 'selected' : '' ?>>
                            <?= $month ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                    <!-- Year -->
                    <select name="date_of_birth_year" class="custom-input">
                        <option value="">वर्ष / Year</option>
                        <?php 
                            $selectedYear = $applicant->date_of_birth_year ?? '';
                            $currentYear = date('Y');
                            for ($y = $currentYear; $y >= 1925; $y--): 
                        ?>
                        <option value="<?= $y ?>" <?= $selectedYear == $y ? 'selected' : '' ?>>
                            <?= $y ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <?php
                if(!$applicant->date_of_birth_day) {
            ?>
            <div class="field">
                <label class="field-label">Current Age</label>
                <input type="text" name="current_age" class="custom-input" id="current_age"
                    value="{{ $applicant->current_age ?? '' }}" disabled placeholder="e.g. 99 year old">
            </div>
            <?php
                }
            ?>

            <div class="field">
                <label class="field-label">Remark (If Date of Birth Not Available)</label>
                <input type="text" name="remarks_for_dob" value="{{ $applicant->remarks_for_dob ?? '' }}"
                    class="custom-input">
            </div>
        </div>
    </div>
</form>
