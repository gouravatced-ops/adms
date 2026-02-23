{{-- resources/views/applicant/components/stepper-form/step2.blade.php --}}
<form id="step2Form" method="POST">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applicant->id ?? '' }}">

    {{-- ── Nominee Details ── --}}
    <div class="form-section">
        <div class="section-header gradient-header" style="background: linear-gradient(90deg, #aa7700, #ffb703);">
            <div class="section-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div>
                <h3 class="section-title">Nominee Details</h3>
                <p class="section-desc">Person nominated to receive benefits on your behalf</p>
            </div>
        </div>

        <div class="form-grid" style="grid-template-columns: repeat(2, 1fr) !important;">
            <div class="field">
                <label class="field-label">Nominee Full Name <span class="req-star">*</span></label>
                <input type="text" name="nominee_name" class="custom-input"
                    value="{{ $applicant->nominee_name ?? '' }}" placeholder="Enter nominee's full name" required>
            </div>

            <div class="field">
                <label class="field-label">Relationship with Applicant <span class="req-star">*</span></label>
                <input type="text" name="nominee_relationship" class="custom-input"
                    value="{{ $applicant->nominee_relationship ?? '' }}" placeholder="e.g. Spouse, Son, Daughter"
                    required>
            </div>

            <div class="field">
                <label class="field-label">Nominee PAN Card <span class="req-star">*</span></label>
                <input type="text" name="nominee_pan_card" class="custom-input"
                    value="{{ $applicant->nominee_pan_card ?? '' }}" placeholder="ABCDE1234F"
                    pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" maxlength="10"
                    style="text-transform:uppercase; letter-spacing:0.05em" required>
            </div>

            <div class="field">
                <label class="field-label">Nominee Aadhaar Number <span class="req-star">*</span></label>
                <input type="text" name="nominee_aadhaar" class="custom-input"
                    value="{{ $applicant->nominee_aadhaar ?? '' }}" placeholder="12-digit Aadhaar number"
                    pattern="[0-9]{12}" maxlength="12" required>
            </div>
        </div>
    </div>

    {{-- ── Family Details ── --}}
    <div class="form-section">
        <div class="section-header gradient-header" style="background:linear-gradient(90deg, #1e3c72, #2a5298)">
            <div class="section-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </div>
            <div>
                <h3 class="section-title">Family Details</h3>
                <p class="section-desc">Add details of all family members to be included in the application</p>
            </div>
        </div>

        <div id="familyMembers">
            <div class="member-card" id="member">
                {{-- Member header --}}
                <div class="member-card-head">
                    <div class="member-number">
                        <span class="member-num-label">Family Member</span>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="field">
                        <label class="field-label">Full Name <span class="req-star">*</span></label>
                        <input type="text" name="family_details[name]" class="custom-input" value=""
                            placeholder="Member's full name" required>
                    </div>

                    <div class="field">
                        <label class="field-label">Gender <span class="req-star">*</span></label>
                        <select name="family_details[gender]" class="custom-input" required>
                            <option value="">— Select gender —</option>
                            <option value="Male">
                                Male</option>
                            <option value="Female">
                                Female</option>
                            {{-- <option value="Other">
                                Other</option> --}}
                        </select>
                    </div>

                    <div class="field">
                        <label class="field-label">Date of Birth <span class="req-star">*</span></label>
                        <input type="date" name="family_details[dob]" class="custom-input" value=""
                            required>
                    </div>

                    <div class="field">
                        <label class="field-label">Relationship <span class="req-star">*</span></label>
                        <input type="text" name="family_details[relationship]" class="custom-input"
                            value="" placeholder="e.g. Spouse, Child" required>
                    </div>

                    <div class="field">
                        <label class="field-label">Aadhaar Number <span class="req-star">*</span></label>
                        <input type="text" name="family_details[aadhaar]" class="custom-input" value=""
                            placeholder="12-digit number" pattern="[0-9]{12}" maxlength="12" required>
                    </div>

                    <div class="field">
                        <label class="field-label">PAN Card <span class="req-star">*</span></label>
                        <input type="text" name="family_details[pan]" class="custom-input" value=""
                            placeholder="ABCDE1234F" style="text-transform:uppercase" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Bank Details ── --}}
    <div class="form-section">
        <div class="section-header gradient-header" style="background:linear-gradient(90deg, #8e2de2, #4a00e0)">
            <div class="section-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" />
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                </svg>
            </div>
            <div>
                <h3 class="section-title">Bank Details</h3>
                <p class="section-desc">Bank account details for payment and refund processing</p>
            </div>
        </div>

        <div class="form-grid">
            <div class="field">
                <label class="field-label">Bank Name <span class="req-star">*</span></label>
                <input type="text" name="bank_name" class="custom-input"
                    value="{{ $applicant->bank_name ?? '' }}" placeholder="e.g. State Bank of India" required>
            </div>

            <div class="field">
                <label class="field-label">Account Number <span class="req-star">*</span></label>
                <input type="text" name="bank_account_no" class="custom-input"
                    value="{{ $applicant->bank_account_no ?? '' }}" placeholder="Enter account number"
                    style="letter-spacing:0.04em" required>
            </div>

            <div class="field">
                <label class="field-label">Branch Name <span class="req-star">*</span></label>
                <input type="text" name="bank_branch" class="custom-input"
                    value="{{ $applicant->bank_branch ?? '' }}" placeholder="e.g. Palamu Main Branch" required>
            </div>

            <div class="field">
                <label class="field-label">IFSC Code <span class="req-star">*</span></label>
                <input type="text" name="bank_ifsc" class="custom-input"
                    value="{{ $applicant->bank_ifsc ?? '' }}" placeholder="e.g. SBIN0001234"
                    pattern="[A-Z]{4}0[A-Z0-9]{6}" maxlength="11"
                    style="text-transform:uppercase; letter-spacing:0.05em" required>
                <span class="field-hint">4 letters + 0 + 6 alphanumeric characters</span>
            </div>

            <div class="field col-span-2">
                <label class="field-label">Account Holder Name <span class="req-star">*</span></label>
                <input type="text" name="bank_account_holder" class="custom-input"
                    value="{{ $applicant->bank_account_holder ?? '' }}" placeholder="Name as printed on passbook"
                    required>
                <span class="field-hint">Must match exactly with the bank records</span>
            </div>
        </div>

        {{-- Bank verification badge --}}
        <div class="bank-verify-note">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            Please ensure all bank details are accurate. Incorrect details may delay payment processing.
        </div>
    </div>
</form>

{{-- Step 2 scoped styles --}}
<style>
    /* Member Card */
    .member-card {
        background: #faf9f6;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 22px;
        margin-bottom: 14px;
        position: relative;
        transition: border-color 0.2s, box-shadow 0.2s;
        animation: cardIn 0.3s ease;
    }

    @keyframes cardIn {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .member-card:hover {
        border-color: var(--gold);
        box-shadow: 0 4px 16px rgba(201, 168, 76, 0.1);
    }

    .member-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px dashed var(--border);
    }

    .member-number {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .member-num-badge {
        width: 28px;
        height: 28px;
        background: var(--gold);
        color: #fff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        font-family: 'Fraunces', serif;
    }

    .member-num-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--ink);
    }

    .btn-remove-member {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: var(--danger-lt);
        border: none;
        color: var(--danger);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .btn-remove-member:hover {
        background: var(--danger);
        color: #fff;
        transform: scale(1.05);
    }

    /* Empty state */
    .empty-family {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 36px 20px;
        background: #faf9f6;
        border: 1.5px dashed var(--border);
        border-radius: var(--radius-sm);
        text-align: center;
    }

    .empty-icon {
        width: 56px;
        height: 56px;
        background: var(--gold-lt);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold-dk);
        margin-bottom: 4px;
    }

    .empty-text {
        font-size: 14px;
        font-weight: 600;
        color: var(--ink);
    }

    .empty-sub {
        font-size: 12px;
        color: var(--muted);
        max-width: 280px;
        line-height: 1.5;
    }

    /* Bank verify note */
    .bank-verify-note {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-top: 18px;
        padding: 12px 16px;
        background: var(--gold-lt);
        border-radius: var(--radius-sm);
        font-size: 12.5px;
        color: var(--gold-dk);
        line-height: 1.5;
    }

    .bank-verify-note svg {
        flex-shrink: 0;
        margin-top: 1px;
    }
</style>

<script>
    /* IFSC auto-uppercase */
    document.addEventListener('input', e => {
        if (e.target.name === 'bank_ifsc' || e.target.name === 'nominee_pan_card') {
            e.target.value = e.target.value.toUpperCase();
        }
        if (e.target.classList.contains('is-invalid') && e.target.value.trim()) {
            e.target.classList.remove('is-invalid');
        }
    });
</script>
