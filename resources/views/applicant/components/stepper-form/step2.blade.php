{{-- resources/views/applicant/components/stepper-form/step2.blade.php --}}
<form id="step2Form" method="POST">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applicant->id ?? '' }}">

    {{-- ── Present Address Details ── --}}
    <div class="form-section">
        <div class="section-header gradient-header" style="background:linear-gradient(90deg, #8e2de2, #4a00e0)">
            <div class="section-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                    <circle cx="12" cy="10" r="3" />
                </svg>
            </div>
            <div>
                <h3 class="section-title">Present Address</h3>
                <p class="section-desc">Enter your present residential address details</p>
            </div>
        </div>
        {{-- ── Present Address Details ── --}}
        <div class="form-grid">
            <div class="field">
                <label class="field-label">
                    Present Address <span class="req-star">*</span>
                </label>
                <textarea name="present_address" id="present_address" class="custom-input" rows="3" placeholder="House No., Street, Area, Locality…"
                    required>{{ $applicant->present_address ?? '' }}</textarea>
            </div>

            <div class="field">
                <label class="field-label">
                    Post Office <span class="req-star">*</span>
                </label>
                <input type="text" name="post_office" id="post_office" class="custom-input"
                    value="{{ $applicant->post_office ?? '' }}" placeholder="Enter post office name" required>
            </div>

            <div class="field">
                <label class="field-label">
                    Police Station <span class="req-star">*</span>
                </label>
                <input type="text" name="police_station" id="police_station" class="custom-input"
                    value="{{ $applicant->police_station ?? '' }}" placeholder="Enter police station name" required>
            </div>

            <div class="field">
                <label class="field-label">
                    State <span class="req-star">*</span>
                </label>
                <select name="state" id="state" class="custom-input" required>
                    <option value="">— Select state —</option>
                    <option value="JHARKHAND"
                        {{ isset($applicant) && $applicant->state == 'JHARKHAND' ? 'selected' : '' }}>Jharkhand</option>
                    {{-- Populate dynamically from database --}}
                </select>
            </div>

            <div class="field">
                <label class="field-label">
                    District <span class="req-star">*</span>
                </label>
                <select name="district" id="district" class="custom-input" required>
                    <option value="">— Select district —</option>
                    <option value="PALAMU"
                        {{ isset($applicant) && $applicant->district == 'PALAMU' ? 'selected' : '' }}>
                        Palamu</option>
                    {{-- Populate dynamically based on state --}}
                </select>
            </div>

            <div class="field">
                <label class="field-label">
                    Pin Code <span class="req-star">*</span>
                </label>
                <input type="text" name="pin_code" id="pin_code" class="custom-input" value="{{ $applicant->pin_code ?? '' }}"
                    placeholder="6-digit pin code" pattern="[0-9]{6}" maxlength="6" required>
            </div>

            <div class="field">
                <label class="field-label">
                    Telephone Number <span class="req-star">*</span>
                </label>
                <input type="text" name="telephone" id="telephone" class="custom-input" value="{{ $applicant->telephone ?? '' }}"
                    placeholder="10-digit telephone number" pattern="[0-9]{10}" maxlength="10" required>
            </div>

            <div class="field">
                <label class="field-label">
                    Mobile Number <span class="req-star">*</span>
                </label>
                <input type="text" name="mobile_number" id="mobile_number" class="custom-input"
                    value="{{ $applicant->mobile_number ?? '' }}" placeholder="10-digit mobile number"
                    pattern="[0-9]{10}" maxlength="10" required>
            </div>

            <div class="field">
                <label class="field-label">
                    WhatsApp Number
                </label>
                <input type="text" name="whatsapp_number" id="whatsapp_number" class="custom-input"
                    value="{{ $applicant->whatsapp_number ?? '' }}" placeholder="10-digit WhatsApp number"
                    pattern="[0-9]{10}" maxlength="10">
            </div>
        </div>
    </div>

    {{-- ── Permanent Address Details ── --}}
    <div class="form-section">
        <div class="section-header gradient-header" style="background:linear-gradient(90deg, #1e3c72, #2a5298)" >
            <div class="section-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                    <circle cx="12" cy="10" r="3" />
                </svg>
            </div>
            <div>
                <h3 class="section-title">Permanent Address</h3>
                <p class="section-desc">Enter your permanent residential address details</p>
            </div>
        </div>
        {{-- Check Box Button Same as Present Address show auto fill if checked --}}

        <div class="field" style="display:flex;gap:8px;width: 200px;">

            <label class="field-label" for="same_as_present"
                style="display:flex; align-items:center; gap:8px; margin:0; cursor:pointer; font-weight:600;">
                Same as Present Address
                <input type="checkbox" onclick="copyAddress()" id="same_as_present" name="same_as_present"
                    style="width:18px; height:18px; margin:0; cursor:pointer;">

            </label>
        </div>
        <br>

        {{-- ── Permanent Address Details ── --}}
        <div class="form-grid">
            <div class="field">
                <label class="field-label">
                    Permanent Address <span class="req-star">*</span>
                </label>
                <textarea name="permanent_address" class="custom-input" id="permanent_address" rows="3"
                    placeholder="House No., Street, Area, Locality…" required>{{ $applicant->permanent_address ?? '' }}</textarea>
            </div>

            <div class="field">
                <label class="field-label">
                    Post Office <span class="req-star">*</span>
                </label>
                <input type="text" name="permanent_post_office" id="permanent_post_office" class="custom-input"
                    value="{{ $applicant->permanent_post_office ?? '' }}" placeholder="Enter post office name" required>
            </div>

            <div class="field">
                <label class="field-label">
                    Police Station <span class="req-star">*</span>
                </label>
                <input type="text" name="permanent_police_station" id="permanent_police_station" class="custom-input"
                    value="{{ $applicant->permanent_police_station ?? '' }}" placeholder="Enter police station name" required>
            </div>

            <div class="field">
                <label class="field-label">
                    State <span class="req-star">*</span>
                </label>
                <select name="permanent_state" id="permanent_state" class="custom-input" required>
                    <option value="">— Select state —</option>
                    <option value="JHARKHAND"
                        {{ isset($applicant) && $applicant->permanent_state == 'JHARKHAND' ? 'selected' : '' }}>Jharkhand
                    </option>
                    {{-- Populate dynamically from database --}}
                </select>
            </div>

            <div class="field">
                <label class="field-label">
                    District <span class="req-star">*</span>
                </label>
                <select name="permanent_district" id="permanent_district" class="custom-input" required>
                    <option value="">— Select district —</option>
                    <option value="PALAMU"
                        {{ isset($applicant) && $applicant->permanent_district == 'PALAMU' ? 'selected' : '' }}>
                        Palamu</option>
                    {{-- Populate dynamically based on state --}}
                </select>
            </div>

            <div class="field">
                <label class="field-label">
                    Pin Code <span class="req-star">*</span>
                </label>
                <input type="text" name="permanent_pin_code" id="permanent_pin_code" class="custom-input" value="{{ $applicant->permanent_pin_code ?? '' }}"
                    placeholder="6-digit pin code" pattern="[0-9]{6}" maxlength="6" required>
            </div>

            <div class="field">
                <label class="field-label">
                    Telephone Number <span class="req-star">*</span>
                </label>
                <input type="text" name="permanent_telephone" id="permanent_telephone" class="custom-input"
                    value="{{ $applicant->permanent_telephone ?? '' }}" placeholder="10-digit telephone number"
                    pattern="[0-9]{10}" maxlength="10" required>
            </div>

            <div class="field">
                <label class="field-label">
                    Mobile Number <span class="req-star">*</span>
                </label>
                <input type="text" name="permanent_mobile_number" id="permanent_mobile_number" class="custom-input"
                    value="{{ $applicant->permanent_mobile_number ?? '' }}" placeholder="10-digit mobile number"
                    pattern="[0-9]{10}" maxlength="10" required>
            </div>
        </div>
    </div>
</form>
