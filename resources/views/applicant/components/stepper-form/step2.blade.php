{{-- resources/views/applicant/components/stepper-form/step2.blade.php --}}
<form id="step2Form" method="POST">
    @csrf

    <div class="form-section">

        <div class="bilingual-grid member-card" style="background: #faf9f6 !important;">
            <div class="section-header gradient-header" style="background:linear-gradient(90deg,#8e2de2,#4a00e0)">
                <div class="section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <h3 class="section-title">
                        Name and Full Address of Father/Husband
                    </h3>
                </div>
            </div>
            <div class="section-header gradient-header" style="background:linear-gradient(90deg,#8e2de2,#4a00e0)">
                <div class="section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <h3 class="section-title">
                        पिता/पति का नाम एवं पूरा स्थायी पता
                    </h3>
                </div>
            </div>
            <!-- Relation Type -->
            <div class="field">
                <div class="field-inline">
                    <label>
                        <input type="radio" name="relation_type" value="father"
                            {{ ($applicant->relation_type ?? '') == 'father' ? 'checked' : '' }}>
                        Father
                    </label>

                    <label>
                        <input type="radio" name="relation_type" value="husband"
                            {{ ($applicant->relation_type ?? '') == 'husband' ? 'checked' : '' }}>
                        Husband
                    </label>
                </div>
                <label class="field-label">Name</label>
                <input type="text" name="relation_name" class="custom-input"
                    value="{{ $applicant->relation_name ?? '' }}" placeholder="e.g. Rajesh">
            </div>

            <div class="field">
                <div class="field-inline">
                    <label>
                        <input type="radio" name="relation_type" value="पिता"
                            {{ ($applicant->relation_type ?? '') == 'पिता' ? 'checked' : '' }}>
                        पिता
                    </label>

                    <label>
                        <input type="radio" name="relation_type" value="पति"
                            {{ ($applicant->relation_type ?? '') == 'पति' ? 'checked' : '' }}>
                        पति
                    </label>
                </div>
                <label class="field-label">नाम </label>
                <input type="text" name="relation_name_hindi" class="custom-input"
                    value="{{ $applicant->relation_name_hindi ?? '' }}" placeholder="e.g. राजेश">
            </div>

            <!-- Address -->
            <div class="field">
                <label class="field-label">Address</label>
                <textarea name="relation_address" class="custom-input" rows="2" placeholder="Enter address">{{ $applicant->relation_address ?? '' }}</textarea>
            </div>

            <div class="field">
                <label class="field-label">पता </label>
                <textarea name="relation_address_hindi" class="custom-input" rows="2" placeholder="Enter address in Hindi">{{ $applicant->relation_address_hindi ?? '' }}</textarea>
            </div>

            <!-- State -->
            <div class="field">
                <label class="field-label">State</label>
                <input type="text" name="relation_state" class="custom-input"
                    value="{{ $applicant->relation_state ?? '' }}" placeholder="Enter state name">
            </div>

            <div class="field">
                <label class="field-label">राज्य </label>
                <input type="text" name="relation_state_hindi" class="custom-input"
                    value="{{ $applicant->relation_state_hindi ?? '' }}" placeholder="Enter state name in Hindi">
            </div>

            <!-- District -->
            <div class="field">
                <label class="field-label">District</label>
                <input type="text" name="relation_district" class="custom-input"
                    value="{{ $applicant->relation_district ?? '' }}" placeholder="Enter district name">
            </div>

            <!-- State -->
            <div class="field">
                <label class="field-label">जिला </label>
                <input type="text" name="relation_district_hindi" class="custom-input"
                    value="{{ $applicant->relation_district_hindi ?? '' }}" placeholder="Enter district name in Hindi">
            </div>

            <div class="field">
                <label class="field-label">Pincode</label>
                <input type="text" name="relation_pincode" class="custom-input" maxlength="6"
                    value="{{ $applicant->relation_pincode ?? '' }}" placeholder="Enter 6-digit pincode">
            </div>

            <div class="field">
                <label class="field-label">पिनकोड </label>
                <input type="text" name="relation_pincode" class="custom-input" maxlength="6"
                    value="{{ $applicant->relation_pincode ?? '' }}" placeholder="Enter 6-digit pincode">
            </div>


            <div class="field">
                <label class="field-label">Post Office</label>
                <input type="text" name="relation_post_office" class="custom-input"
                    value="{{ $applicant->relation_post_office ?? '' }}" placeholder="Enter post office name">
            </div>

            <div class="field">
                <label class="field-label">पोस्ट ऑफ़िस</label>
                <input type="text" name="relation_post_office_hindi" class="custom-input"
                    value="{{ $applicant->relation_post_office_hindi ?? '' }}"
                    placeholder="Enter post office name in Hindi">
            </div>

            <div class="field">
                <label class="field-label">Police Station</label>
                <input type="text" name="relation_police_station" class="custom-input"
                    value="{{ $applicant->relation_police_station ?? '' }}" placeholder="Enter police station name">
            </div>

            <div class="field">
                <label class="field-label">पुलिस स्टेशन</label>
                <input type="text" name="relation_police_station_hindi" class="custom-input"
                    value="{{ $applicant->relation_police_station_hindi ?? '' }}"
                    placeholder="Enter police station name in Hindi">
            </div>



        </div>
    </div>

    <div class="form-section">
        <div class="bilingual-grid member-card" style="background: #faf9f6 !important;">
            <div class="section-header gradient-header" style="background: linear-gradient(90deg, #f59e0b, #f97316);">
                <div class="section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <h3 class="section-title">Address of your present place of Residance</h3>
                </div>
            </div>
            <div class="section-header gradient-header" style="background: linear-gradient(90deg, #f59e0b, #f97316);">
                <div class="section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <h3 class="section-title">आपका वर्तमान निवास स्थान का पता</h3>
                </div>
            </div>
            <!-- Address -->
            <div class="field">
                <label class="field-label">Address</label>
                <textarea name="present_address" class="custom-input" rows="2" placeholder="Enter address">{{ $applicant->present_address ?? '' }}</textarea>
            </div>

            <div class="field">
                <label class="field-label">पता</label>
                <textarea name="present_address_hindi" class="custom-input" rows="2" placeholder="Enter address in Hindi">{{ $applicant->present_address_hindi ?? '' }}</textarea>
            </div>

            <!-- State -->
            <div class="field">
                <label class="field-label">State</label>
                <input type="text" name="present_state" class="custom-input"
                    value="{{ $applicant->present_state ?? '' }}" placeholder="Enter state name">
            </div>

            <div class="field">
                <label class="field-label">राज्य</label>
                <input type="text" name="present_state_hindi" class="custom-input"
                    value="{{ $applicant->present_state_hindi ?? '' }}" placeholder="Enter state name in Hindi">
            </div>

            <!-- District -->
            <div class="field">
                <label class="field-label">District</label>
                <input type="text" name="present_district" class="custom-input"
                    value="{{ $applicant->present_district ?? '' }}" placeholder="Enter district name">
            </div>

            <!-- State -->
            <div class="field">
                <label class="field-label">जिला </label>
                <input type="text" name="present_district_hindi" class="custom-input"
                    value="{{ $applicant->present_district_hindi ?? '' }}"
                    placeholder="Enter district name in Hindi">
            </div>

            <div class="field">
                <label class="field-label">Pincode</label>
                <input type="text" name="present_pincode" class="custom-input" maxlength="6"
                    value="{{ $applicant->present_pincode ?? '' }}" placeholder="Enter 6-digit pincode">
            </div>

            <div class="field">
                <label class="field-label">पिनकोड</label>
                <input type="text" name="present_pincode" class="custom-input" maxlength="6"
                    value="{{ $applicant->present_pincode ?? '' }}" placeholder="Enter 6-digit pincode">
            </div>

            <div class="field">
                <label class="field-label">Post Office</label>
                <input type="text" name="present_post_office" class="custom-input"
                    value="{{ $applicant->present_post_office ?? '' }}" placeholder="Enter post office name">
            </div>
            <div class="field">
                <label class="field-label">पोस्ट ऑफ़िस</label>
                <input type="text" name="present_post_office_hindi" class="custom-input"
                    value="{{ $applicant->present_post_office_hindi ?? '' }}"
                    placeholder="Enter post office name in Hindi">
            </div>

            <div class="field">
                <label class="field-label">Police Station</label>
                <input type="text" name="present_police_station" class="custom-input"
                    value="{{ $applicant->present_police_station ?? '' }}" placeholder="Enter police station name">
            </div>

            <div class="field">
                <label class="field-label">पुलिस स्टेशन</label>
                <input type="text" name="present_police_station_hindi" class="custom-input"
                    value="{{ $applicant->present_police_station_hindi ?? '' }}"
                    placeholder="Enter police station name in Hindi">
            </div>
        </div>
    </div>
    <div class="form-section">
        <div class="bilingual-grid member-card" style="background: #faf9f6 !important;">
            <div class="section-header gradient-header" style="background:linear-gradient(90deg,#1e3c72,#2a5298)">
                <div class="section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <h3 class="section-title">
                        Full permanent address of Applicant
                    </h3>
                </div>
            </div>
            <div class="section-header gradient-header" style="background:linear-gradient(90deg,#1e3c72,#2a5298)">
                <div class="section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <h3 class="section-title">
                        आवेदक का पूरा स्थायी पता
                    </h3>
                </div>
            </div>


            <div class="field" style="display:flex;gap:8px;width: 200px;">

                <label class="field-label" for="same_as_present"
                    style="display:flex; align-items:center; gap:8px; margin:0; cursor:pointer; font-weight:600;">
                    Same as Present Address
                    <input type="checkbox" onclick="copyAddress()" id="same_as_present" name="same_as_present"
                        style="width:18px; height:18px; margin:0; cursor:pointer;">

                </label>
            </div>
            <br>

            <!-- Address -->
            <div class="field">
                <label class="field-label">Address</label>
                <textarea name="permanent_address" class="custom-input" rows="2" placeholder="Enter address">{{ $applicant->permanent_address ?? '' }}</textarea>
            </div>

            <div class="field">
                <label class="field-label">पता </label>
                <textarea name="permanent_address_hindi" class="custom-input" rows="2" placeholder="Enter address in Hindi">{{ $applicant->permanent_address_hindi ?? '' }}</textarea>
            </div>

            <!-- State -->
            <div class="field">
                <label class="field-label">State</label>
                <input type="text" name="permanent_state" class="custom-input"
                    value="{{ $applicant->permanent_state ?? '' }}" placeholder="Enter state name">
            </div>

            <div class="field">
                <label class="field-label">राज्य </label>
                <input type="text" name="permanent_state_hindi" class="custom-input"
                    value="{{ $applicant->permanent_state_hindi ?? '' }}" placeholder="Enter state name in Hindi">
            </div>

            <!-- District -->
            <div class="field">
                <label class="field-label">District</label>
                <input type="text" name="permanent_district" class="custom-input"
                    value="{{ $applicant->permanent_district ?? '' }}" placeholder="Enter district name">
            </div>

            <!-- State -->
            <div class="field">
                <label class="field-label">जिला </label>
                <input type="text" name="permanent_district_hindi" class="custom-input"
                    value="{{ $applicant->permanent_district_hindi ?? '' }}"
                    placeholder="Enter district name in Hindi">
            </div>

            <div class="field">
                <label class="field-label">Pincode</label>
                <input type="text" name="permanent_pincode" class="custom-input" maxlength="6"
                    value="{{ $applicant->permanent_pincode ?? '' }}" placeholder="Enter 6-digit pincode">
            </div>

            <div class="field">
                <label class="field-label">पिनकोड </label>
                <input type="text" name="permanent_pincode" class="custom-input" maxlength="6"
                    value="{{ $applicant->permanent_pincode ?? '' }}" placeholder="Enter 6-digit pincode">
            </div>

            <div class="field">
                <label class="field-label">Post Office</label>
                <input type="text" name="permanent_post_office" class="custom-input"
                    value="{{ $applicant->permanent_post_office ?? '' }}" placeholder="Enter post office name">
            </div>

            <div class="field">
                <label class="field-label">पोस्ट ऑफ़िस</label>
                <input type="text" name="permanent_post_office_hindi" class="custom-input"
                    value="{{ $applicant->permanent_post_office_hindi ?? '' }}"
                    placeholder="Enter post office name in Hindi">
            </div>

            <div class="field">
                <label class="field-label">Police Station</label>
                <input type="text" name="permanent_police_station" class="custom-input"
                    value="{{ $applicant->permanent_police_station ?? '' }}" placeholder="Enter police station name">
            </div>

            <div class="field">
                <label class="field-label">पुलिस स्टेशन</label>
                <input type="text" name="permanent_police_station_hindi" class="custom-input"
                    value="{{ $applicant->permanent_police_station_hindi ?? '' }}"
                    placeholder="Enter police station name in Hindi">
            </div>

        </div>
    </div>

    <div class="form-section">
        <div class="bilingual-grid member-card" style="background: #faf9f6 !important;">
            <div class="section-header gradient-header" style="background:linear-gradient(90deg,#11998e,#38ef7d)">
                <div class="section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <h3 class="section-title">
                        Address for correspondence regarding this Application
                    </h3>
                </div>
            </div>

            <div class="section-header gradient-header" style="background:linear-gradient(90deg,#11998e,#38ef7d)">
                <div class="section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <h3 class="section-title">
                        इस आवेदन सम्बन्धी पत्राचार के लिए पता
                    </h3>
                </div>
            </div>

            <div class="field" style="display:flex;gap:8px;width: 200px;">

                <label class="field-label" for="same_as_present"
                    style="display:flex; align-items:center; gap:8px; margin:0; cursor:pointer; font-weight:600;">
                    Same as Present Address
                    <input type="checkbox" onclick="copyAddress()" id="same_as_present" name="same_as_present"
                        style="width:18px; height:18px; margin:0; cursor:pointer;">

                </label>
            </div>
            <br>
            <!-- Address -->
            <div class="field">
                <label class="field-label">Address</label>
                <textarea name="correspondence_address" class="custom-input" rows="2" placeholder="Enter address">{{ $applicant->correspondence_address ?? '' }}</textarea>
            </div>

            <div class="field">
                <label class="field-label">पता </label>
                <textarea name="correspondence_address_hindi" class="custom-input" rows="2"
                    placeholder="Enter address in Hindi">{{ $applicant->correspondence_address_hindi ?? '' }}</textarea>
            </div>

            <!-- State -->
            <div class="field">
                <label class="field-label">State</label>
                <input type="text" name="correspondence_state" class="custom-input"
                    value="{{ $applicant->correspondence_state ?? '' }}" placeholder="Enter state name">
            </div>

            <div class="field">
                <label class="field-label">राज्य </label>
                <input type="text" name="correspondence_state_hindi" class="custom-input"
                    value="{{ $applicant->correspondence_state_hindi ?? '' }}"
                    placeholder="Enter state name in Hindi">
            </div>

            <!-- District -->
            <div class="field">
                <label class="field-label">District</label>
                <input type="text" name="correspondence_district" class="custom-input"
                    value="{{ $applicant->correspondence_district ?? '' }}" placeholder="Enter district name">
            </div>

            <!-- State -->
            <div class="field">
                <label class="field-label">जिला </label>
                <input type="text" name="correspondence_district_hindi" class="custom-input"
                    value="{{ $applicant->correspondence_district_hindi ?? '' }}"
                    placeholder="Enter district name in Hindi">
            </div>

            <div class="field">
                <label class="field-label">Pincode</label>
                <input type="text" name="correspondence_pincode" class="custom-input" maxlength="6"
                    value="{{ $applicant->correspondence_pincode ?? '' }}" placeholder="Enter 6-digit pincode">
            </div>

            <div class="field">
                <label class="field-label">पिनकोड </label>
                <input type="text" name="correspondence_pincode" class="custom-input" maxlength="6"
                    value="{{ $applicant->correspondence_pincode ?? '' }}" placeholder="Enter 6-digit pincode">
            </div>


            <div class="field">
                <label class="field-label">Post Office</label>
                <input type="text" name="correspondence_post_office" class="custom-input"
                    value="{{ $applicant->correspondence_post_office ?? '' }}" placeholder="Enter post office name">
            </div>

            <div class="field">
                <label class="field-label">पोस्ट ऑफ़िस</label>
                <input type="text" name="correspondence_post_office_hindi" class="custom-input"
                    value="{{ $applicant->correspondence_post_office_hindi ?? '' }}"
                    placeholder="Enter post office name in Hindi">
            </div>


            <div class="field">
                <label class="field-label">Police Station</label>
                <input type="text" name="correspondence_police_station" class="custom-input"
                    value="{{ $applicant->correspondence_police_station ?? '' }}"
                    placeholder="Enter police station name">
            </div>

            <div class="field">
                <label class="field-label">पुलिस स्टेशन</label>
                <input type="text" name="correspondence_police_station_hindi" class="custom-input"
                    value="{{ $applicant->correspondence_police_station_hindi ?? '' }}"
                    placeholder="Enter police station name in Hindi">
            </div>

        </div>
    </div>
    <div class="form-section">
    
        <div class="section-header gradient-header" style="background:linear-gradient(90deg,#ff512f,#dd2476)">
            <div class="section-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                            19.86 19.86 0 0 1-8.63-3.07
                            19.5 19.5 0 0 1-6-6
                            19.86 19.86 0 0 1-3.07-8.67
                            A2 2 0 0 1 4.11 2h3
                            a2 2 0 0 1 2 1.72
                            c.12.81.37 1.6.72 2.34
                            a2 2 0 0 1-.45 2.11L8.09 9.91
                            a16 16 0 0 0 6 6l1.74-1.29
                            a2 2 0 0 1 2.11-.45
                            c.74.35 1.53.6 2.34.72
                            A2 2 0 0 1 22 16.92z" />
                </svg>
            </div>
            <div>
                <h3 class="section-title">Contact Details of Applicant</h3>
            </div>
        </div>
        <div class="form-grid member-card" style="background: #faf9f6 !important;">
            <div class="field">
                <label class="field-label">
                    Primary Mobile No. of Applicant
                </label>
                <input type="text" name="mobile_number" class="custom-input" maxlength="10"
                    value="{{ $applicant->mobile_number ?? '' }}" placeholder="Enter 10-digit mobile number">
            </div>

            <div class="field">
                <label class="field-label">
                    Alternate Mobile No.
                </label>
                <input type="text" name="alternate_mobile" class="custom-input" maxlength="10"
                    value="{{ $applicant->alternate_mobile ?? '' }}"
                    placeholder="Enter 10-digit alternate mobile number">
            </div>

            <div class="field">
                <label class="field-label">
                    Landline (STD Code + Phone Number)
                </label>
                <input type="text" name="landline" class="custom-input" value="{{ $applicant->landline ?? '' }}"
                    placeholder="Enter landline number">
            </div>

            <div class="field">
                <label class="field-label">
                    WhatsApp No.
                </label>
                <input type="text" name="whatsapp_number" class="custom-input" maxlength="10"
                    value="{{ $applicant->whatsapp_number ?? '' }}" placeholder="Enter 10-digit WhatsApp number">
            </div>

            <div class="field">
                <label class="field-label">
                    E-mail ID of Applicant
                </label>
                <input type="email" name="email" class="custom-input" value="{{ $applicant->email ?? '' }}"
                    placeholder="Enter email address">
            </div>
        </div>
    </div>
</form>
