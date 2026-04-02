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

    /* Joint Allottee Styles */
    .joint-allottee-section {
        margin-top: 24px;
        border-top: 2px dashed var(--border, #e2e8f0);
        padding-top: 20px;
    }

    .joint-allottee-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .joint-allottee-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary, #1e293b);
    }

    .btn-add-joint {
        background: #10b981;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add-joint:hover {
        background: #059669;
    }

    .btn-remove-joint {
        background: #ef4444;
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-remove-joint:hover {
        background: #dc2626;
    }

    .joint-member-card {
        background: var(--surface, #f8fafc);
        border: 1px solid var(--border, #e2e8f0);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        position: relative;
        transition: all 0.2s;
    }

    .joint-member-card:last-child {
        margin-bottom: 0;
    }

    .joint-member-title {
        font-weight: 600;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border, #e2e8f0);
        color: var(--text-secondary, #475569);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .joint-form-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .joint-field {
        margin-bottom: 12px;
    }

    .joint-field label {
        display: block;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 4px;
        color: var(--text-secondary, #475569);
    }

    .joint-field .req-star {
        color: #ef4444;
    }

    .joint-field input, 
    .joint-field select {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid var(--border, #e2e8f0);
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
        background: white;
    }

    .joint-field input:focus, 
    .joint-field select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }

    .joint-name-group {
        display: flex;
        gap: 8px;
    }

    .joint-name-group select {
        width: 90px;
        flex-shrink: 0;
    }

    .joint-name-group input {
        flex: 1;
    }

    .is-invalid {
        border-color: #dc3545 !important;
        background-color: #fff5f5;
    }

    @media (max-width: 768px) {
        .joint-form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@php    
    #return getDebugIndex($applicant);
    // Handle both relation object and JSON string
    $existingJointAllottees = collect();

    if (!empty($applicant->joint_allottees_data)) {

        // When relation is loaded as Collection
        if ($applicant->joint_allottees_data instanceof \Illuminate\Support\Collection) {
            $existingJointAllottees = $applicant->joint_allottees_data;

        // When stored as JSON string
        } elseif (is_string($applicant->joint_allottees_data)) {
            $existingJointAllottees = collect(json_decode($applicant->joint_allottees_data, true) ?? []);
        }
    } elseif (!empty($applicant->jointAllottees)) {
        // Fallback relation name
        $existingJointAllottees = collect($applicant->jointAllottees);
    }
    // return getDebugIndex($existingJointAllottees);
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
        <div class="form-grid" style="grid-template-columns: repeat(1, 1fr) !important;">
            <div class="field">
                <label class="field-label">
                    Name Transfer Date <span class="req-star">*</span>
                </label>
                <div class="date-group">
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
                    <select name="allotment_year" id="allotment_year" class="custom-input">
                        <option value="">वर्ष / Year</option>
                        <?php 
                            $selectedYear = $applicant->allotment_year ?? '';
                            $currentYear = date('Y');
                            for ($y = $currentYear; $y >= 1950; $y--): 
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
                </div>
            </div>

            <div class="field">
                <label class="field-label">Middle Name</label>
                <input type="text" name="allottee_middle_name" class="custom-input only-alphabet"
                    value="{{ $applicant->allottee_middle_name ?? '' }}" placeholder="Optional">
            </div>

            <div class="field">
                <label class="field-label">
                    Last Name <span class="req-star">*</span>
                </label>
                <input type="text" name="allottee_surname" class="custom-input only-alphabet"
                    value="{{ $applicant->allottee_surname ?? '' }}" placeholder="e.g. Kumar">
            </div>

            <div class="field">
                <label class="field-label">
                    First Name (Hindi) <span class="req-star">*</span>
                </label>
                <div class="input-group">
                    @php $prefixesHindi = ['श्री', 'श्रीमती', 'सुश्री', 'डॉ.', 'मो.', 'स्व०', 'मेसर्स' , 'मेजर', 'कैप्टन']; @endphp
                    <select name="allottee_prefix_hindi" class="prefix-select">
                        @foreach ($prefixesHindi as $prefix)
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
                    Last Name (Hindi) <span class="req-star">*</span>
                </label>
                <input type="text" name="allottee_surname_hindi" class="custom-input only-hindi"
                    value="{{ $applicant->allottee_surname_hindi ?? '' }}" placeholder="e.g. कुमार">
            </div>

            <div class="field">
                <label class="field-label">
                    Relation Name <span class="req-star">*</span>
                </label>
                <div class="input-group">
                    @php $relations = ['Father', 'Mother', 'Husband', 'Wife']; @endphp
                    <select name="relation_prefix" class="prefix-select">
                        @foreach ($relations as $relation)
                            <option value="{{ $relation }}"
                                {{ ($applicant->relation_prefix ?? '') === $relation ? 'selected' : '' }}>
                                {{ $relation }}
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

    {{-- ── Joint Allottee Section ── --}}
    <div class="joint-allottee-section">
        <div class="joint-allottee-header">
            <h3>Joint Allottee Details (सह-आवंटी विवरण)</h3>
            <button type="button" class="btn-add-joint" id="addJointAllotteeBtn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Add Joint Allottee
            </button>
        </div>
        
        <div id="jointAllotteesContainer">
            @if(count($existingJointAllottees) > 0)
                @foreach($existingJointAllottees as $index => $joint)
                <div class="joint-member-card" data-joint-index="{{ $index }}">
                    <div class="joint-member-title">
                        <span>Joint Allottee #<span class="joint-number">{{ $index + 1 }}</span></span>
                        <button type="button" class="btn-remove-joint" onclick="removeJointAllottee(this)">Remove</button>
                    </div>
                    <div class="joint-form-grid">
                        {{-- First Name with Prefix --}}
                        <div class="joint-field">
                            <label>First Name <span class="req-star">*</span></label>
                            <div class="joint-name-group">
                                <select name="joint_allottee_prefix[]" class="joint-prefix-select">
                                    <option value="Shri" {{ ($joint['prefix'] ?? 'Shri') == 'Shri' ? 'selected' : '' }}>Shri</option>
                                    <option value="Smt." {{ ($joint['prefix'] ?? '') == 'Smt.' ? 'selected' : '' }}>Smt.</option>
                                    <option value="Miss" {{ ($joint['prefix'] ?? '') == 'Miss' ? 'selected' : '' }}>Miss</option>
                                    <option value="Dr." {{ ($joint['prefix'] ?? '') == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                                    <option value="Md." {{ ($joint['prefix'] ?? '') == 'Md.' ? 'selected' : '' }}>Md.</option>
                                    <option value="Late" {{ ($joint['prefix'] ?? '') == 'Late' ? 'selected' : '' }}>Late</option>
                                    <option value="M/S" {{ ($joint['prefix'] ?? '') == 'M/S' ? 'selected' : '' }}>M/S</option>
                                    <option value="Maj." {{ ($joint['prefix'] ?? '') == 'Maj.' ? 'selected' : '' }}>Maj.</option>
                                    <option value="Capt." {{ ($joint['prefix'] ?? '') == 'Capt.' ? 'selected' : '' }}>Capt.</option>
                                </select>
                                <input type="text" name="joint_allottee_name[]" class="joint-first-name only-alphabet" 
                                    value="{{ $joint['first_name'] ?? '' }}" placeholder="First Name" required>
                            </div>
                        </div>
                        
                        {{-- Middle Name --}}
                        <div class="joint-field">
                            <label>Middle Name</label>
                            <input type="text" name="joint_allottee_middle_name[]" class="joint-middle-name only-alphabet" 
                                value="{{ $joint['middle_name'] ?? '' }}" placeholder="Middle Name (Optional)">
                        </div>
                        
                        {{-- Last Name --}}
                        <div class="joint-field">
                            <label>Last Name </label>
                            <input type="text" name="joint_allottee_surname[]" class="joint-last-name only-alphabet" 
                                value="{{ $joint['last_name'] ?? '' }}" placeholder="Last Name">
                        </div>
                        
                        {{-- First Name (Hindi) with Prefix --}}
                        <div class="joint-field">
                            <label>First Name (Hindi)</label>
                            <div class="joint-name-group">
                                <select name="joint_allottee_prefix_hindi[]" class="joint-prefix-hindi-select">
                                    <option value="श्री" {{ ($joint['prefix_hindi'] ?? 'श्री') == 'श्री' ? 'selected' : '' }}>श्री</option>
                                    <option value="श्रीमती" {{ ($joint['prefix_hindi'] ?? '') == 'श्रीमती' ? 'selected' : '' }}>श्रीमती</option>
                                    <option value="सुश्री" {{ ($joint['prefix_hindi'] ?? '') == 'सुश्री' ? 'selected' : '' }}>सुश्री</option>
                                    <option value="डॉ." {{ ($joint['prefix_hindi'] ?? '') == 'डॉ.' ? 'selected' : '' }}>डॉ.</option>
                                    <option value="मो." {{ ($joint['prefix_hindi'] ?? '') == 'मो.' ? 'selected' : '' }}>मो.</option>
                                    <option value="स्व०" {{ ($joint['prefix_hindi'] ?? '') == 'स्व०' ? 'selected' : '' }}>स्व०</option>
                                    <option value="मेसर्स" {{ ($joint['prefix_hindi'] ?? '') == 'मेसर्स' ? 'selected' : '' }}>मेसर्स</option>
                                    <option value="मेजर" {{ ($joint['prefix_hindi'] ?? '') == 'मेजर' ? 'selected' : '' }}>मेजर</option>
                                    <option value="कैप्टन" {{ ($joint['prefix_hindi'] ?? '') == 'कैप्टन' ? 'selected' : '' }}>कैप्टन</option>
                                </select>
                                <input type="text" name="joint_allottee_name_hindi[]" class="joint-first-name-hindi only-hindi" 
                                    value="{{ $joint['first_name_hindi'] ?? '' }}" placeholder="प्रथम नाम">
                            </div>
                        </div>
                        
                        {{-- Middle Name (Hindi) --}}
                        <div class="joint-field">
                            <label>Middle Name (Hindi)</label>
                            <input type="text" name="joint_allottee_middle_name_hindi[]" class="joint-middle-name-hindi only-hindi" 
                                value="{{ $joint['middle_name_hindi'] ?? '' }}" placeholder="मध्य नाम (वैकल्पिक)">
                        </div>
                        
                        {{-- Last Name (Hindi) --}}
                        <div class="joint-field">
                            <label>Last Name (Hindi) </label>
                            <input type="text" name="joint_allottee_surname_hindi[]" class="joint-last-name-hindi only-hindi" 
                                value="{{ $joint['last_name_hindi'] ?? '' }}" placeholder="अंतिम नाम">
                        </div>
                        
                        {{-- Gender --}}
                        <div class="joint-field">
                            <label>Gender <span class="req-star">*</span></label>
                            <select name="joint_allottee_gender[]" class="joint-gender" required>
                                <option value="">Select</option>
                                <option value="Male" {{ ($joint['gender'] ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ ($joint['gender'] ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Transgender" {{ ($joint['gender'] ?? '') == 'Transgender' ? 'selected' : '' }}>Transgender</option>
                            </select>
                        </div>
                        
                        {{-- Aadhar Number (Optional) --}}
                        <div class="joint-field">
                            <label>Aadhar Number</label>
                            <input type="text" name="joint_allottee_aadhar[]" class="joint-aadhar only-number" 
                                value="{{ $joint['aadhar_number'] ?? '' }}" placeholder="12-digit Aadhar (Optional)" maxlength="12">
                        </div>
                        
                        {{-- PAN Number (Optional) --}}
                        <div class="joint-field">
                            <label>PAN Number</label>
                            <input type="text" name="joint_allottee_pan[]" class="joint-pan pan-input" 
                                value="{{ $joint['pan_number'] ?? '' }}" placeholder="ABCDE1234F (Optional)" maxlength="10">
                        </div>
                        
                        {{-- Other Document Type --}}
                        <div class="joint-field">
                            <label>Other Document Type</label>
                            <select name="joint_allottee_doc_type[]" class="joint-doc-type">
                                <option value="">Select Document Type</option>
                                <option value="driving_license" {{ ($joint['other_doc_type'] ?? '') == 'driving_license' ? 'selected' : '' }}>Driving License</option>
                                <option value="passport" {{ ($joint['other_doc_type'] ?? '') == 'passport' ? 'selected' : '' }}>Passport</option>
                                <option value="voter_id" {{ ($joint['other_doc_type'] ?? '') == 'voter_id' ? 'selected' : '' }}>Voter ID</option>
                            </select>
                        </div>
                        
                        {{-- Other Document Number --}}
                        <div class="joint-field">
                            <label>Other Document Number</label>
                            <input type="text" name="joint_allottee_doc_number[]" class="joint-doc-number" 
                                value="{{ $joint['other_doc_number'] ?? '' }}" placeholder="Document Number (Optional)">
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</form>

{{-- Hidden template for joint allottee card --}}
<template id="jointAllotteeCardTemplate">
    <div class="joint-member-card" data-joint-index="__INDEX__">
        <div class="joint-member-title">
            <span>Joint Allottee #<span class="joint-number">__NUMBER__</span></span>
            <button type="button" class="btn-remove-joint" onclick="removeJointAllottee(this)">Remove</button>
        </div>
        <div class="joint-form-grid">
            {{-- First Name with Prefix --}}
            <div class="joint-field">
                <label>First Name <span class="req-star">*</span></label>
                <div class="joint-name-group">
                    <select name="joint_allottee_prefix[]" class="joint-prefix-select">
                        <option value="Shri">Shri</option>
                        <option value="Smt.">Smt.</option>
                        <option value="Miss">Miss</option>
                        <option value="Dr.">Dr.</option>
                        <option value="Md.">Md.</option>
                        <option value="Late">Late</option>
                        <option value="M/S">M/S</option>
                        <option value="Maj.">Maj.</option>
                        <option value="Capt.">Capt.</option>
                    </select>
                    <input type="text" name="joint_allottee_name[]" class="joint-first-name only-alphabet" placeholder="First Name" required>
                </div>
            </div>
            
            {{-- Middle Name --}}
            <div class="joint-field">
                <label>Middle Name</label>
                <input type="text" name="joint_allottee_middle_name[]" class="joint-middle-name only-alphabet" placeholder="Middle Name (Optional)">
            </div>
            
            {{-- Last Name --}}
            <div class="joint-field">
                <label>Last Name </label>
                <input type="text" name="joint_allottee_surname[]" class="joint-last-name only-alphabet" placeholder="Last Name">
            </div>
            
            {{-- First Name (Hindi) with Prefix --}}
            <div class="joint-field">
                <label>First Name (Hindi)</label>
                <div class="joint-name-group">
                    <select name="joint_allottee_prefix_hindi[]" class="joint-prefix-hindi-select">
                        <option value="श्री">श्री</option>
                        <option value="श्रीमती">श्रीमती</option>
                        <option value="सुश्री">सुश्री</option>
                        <option value="डॉ.">डॉ.</option>
                        <option value="मो.">मो.</option>
                        <option value="स्व०">स्व०</option>
                        <option value="मेसर्स">मेसर्स</option>
                        <option value="मेजर">मेजर</option>
                        <option value="कैप्टन">कैप्टन</option>
                    </select>
                    <input type="text" name="joint_allottee_name_hindi[]" class="joint-first-name-hindi only-hindi" placeholder="प्रथम नाम">
                </div>
            </div>
            
            {{-- Middle Name (Hindi) --}}
            <div class="joint-field">
                <label>Middle Name (Hindi)</label>
                <input type="text" name="joint_allottee_middle_name_hindi[]" class="joint-middle-name-hindi only-hindi" placeholder="मध्य नाम (वैकल्पिक)">
            </div>
            
            {{-- Last Name (Hindi) --}}
            <div class="joint-field">
                <label>Last Name (Hindi)</label>
                <input type="text" name="joint_allottee_surname_hindi[]" class="joint-last-name-hindi only-hindi" placeholder="अंतिम नाम">
            </div>
            
            {{-- Gender --}}
            <div class="joint-field">
                <label>Gender <span class="req-star">*</span></label>
                <select name="joint_allottee_gender[]" class="joint-gender" required>
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Transgender">Transgender</option>
                </select>
            </div>
            
            {{-- Aadhar Number (Optional) --}}
            <div class="joint-field">
                <label>Aadhar Number</label>
                <input type="text" name="joint_allottee_aadhar[]" class="joint-aadhar only-number" placeholder="12-digit Aadhar (Optional)" maxlength="12">
            </div>
            
            {{-- PAN Number (Optional) --}}
            <div class="joint-field">
                <label>PAN Number</label>
                <input type="text" name="joint_allottee_pan[]" class="joint-pan pan-input" placeholder="ABCDE1234F (Optional)" maxlength="10">
            </div>
            
            {{-- Other Document Type --}}
            <div class="joint-field">
                <label>Other Document Type</label>
                <select name="joint_allottee_doc_type[]" class="joint-doc-type">
                    <option value="">Select Document Type</option>
                    <option value="driving_license">Driving License</option>
                    <option value="passport">Passport</option>
                    <option value="voter_id">Voter ID</option>
                </select>
            </div>
            
            {{-- Other Document Number --}}
            <div class="joint-field">
                <label>Other Document Number</label>
                <input type="text" name="joint_allottee_doc_number[]" class="joint-doc-number" placeholder="Document Number (Optional)">
            </div>
        </div>
    </div>
</template>