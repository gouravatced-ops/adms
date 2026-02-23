{{-- resources/views/applicant/components/stepper-form/step3.blade.php --}}
<form id="step3Form" method="POST">
    @csrf
    <input type="hidden" name="applicant_id" value="{{ $applicant->id ?? '' }}">

    {{-- ── Property Details ── --}}
    <div class="form-section">
        <div class="section-header gradient-header" style="background: linear-gradient(90deg, #aa7700, #ffb703);">
            <div class="section-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </div>
            <div>
                <h3 class="section-title">Property Details</h3>
                <p class="section-desc">Details of the property unit you are applying for</p>
            </div>
        </div>

        <div class="form-grid">
            <div class="field">
                <label class="field-label">Division Office <span class="req-star">*</span></label>
                <input type="text" name="division_office" class="custom-input"
                    value="{{ $applicant->division_office ?? 'Hazaribagh & Daltonganj Division' }}"
                    placeholder="Enter division office" required>
            </div>

            <div class="field">
                <label class="field-label">Property Location <span class="req-star">*</span></label>
                <input type="text" name="property_location" class="custom-input"
                    value="{{ $applicant->property_location ?? 'Medininagar, formerly Daltonganj (BARALOTA)' }}"
                    placeholder="Enter property location" required>
            </div>

            <div class="field">
                <label class="field-label">Yojana Name <span class="req-star">*</span></label>
                <input type="text" name="yojana_name" class="custom-input"
                    value="{{ $applicant->yojana_name ?? '36 MIG PLOT' }}" placeholder="Enter scheme / yojana name"
                    required>
            </div>

            <div class="field">
                <label class="field-label">Property Area <span class="req-star">*</span></label>
                <div class="input-unit-wrap">
                    <input type="text" name="property_area" class="custom-input has-unit"
                        value="{{ $applicant->property_area ?? '1800' }}" placeholder="e.g. 1800" required>
                    <span class="input-unit">sq.ft</span>
                </div>
            </div>
        </div>

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
    </div>

    {{-- ── Payment Details ── --}}
    {{-- <div class="form-section"> --}}
    {{-- <div class="section-header">
            <div class="section-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                    <line x1="1" y1="10" x2="23" y2="10" />
                </svg>
            </div>
            <div>
                <h3 class="section-title">Payment Details</h3>
                <p class="section-desc">Application fee and EMD payment transaction records</p>
            </div>
        </div> --}}

    {{-- Application Fee Card --}}
    {{-- <div class="payment-card">
            <div class="payment-card-head">
                <div class="payment-card-title">
                    <div class="payment-type-icon app-fee-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                    </div>
                    <div>
                        <span class="payment-name">Application Fee</span>
                        <span class="payment-mode-chip">Online</span>
                    </div>
                </div>
                <div class="payment-amount-block">
                    <span class="payment-amount-label">Amount</span>
                    <span class="payment-amount">₹2,360</span>
                </div>
                <div class="payment-status-chip success">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Success
                </div>
            </div>

            <div class="form-grid">
                <div class="field">
                    <label class="field-label">Payment For</label>
                    <input type="text" class="custom-input" value="Application Fee" readonly>
                </div>

                <div class="field">
                    <label class="field-label">Payment Mode</label>
                    <input type="text" class="custom-input" value="Online" readonly>
                </div>

                <div class="field">
                    <label class="field-label">Client Transaction ID</label>
                    <input type="text" name="payment_details[app_fee][client_txn_id]"
                        class="custom-input txn-input"
                        value="{{ $applicant->payment_details['app_fee']['client_txn_id'] ?? 'JSHBTNX05256746831b4ac18843' }}">
                </div>

                <div class="field">
                    <label class="field-label">Transaction ID</label>
                    <input type="text" name="payment_details[app_fee][txn_id]" class="custom-input txn-input"
                        value="{{ $applicant->payment_details['app_fee']['txn_id'] ?? '250524229398967' }}">
                </div>

                <div class="field">
                    <label class="field-label">Amount (₹)</label>
                    <input type="text" name="payment_details[app_fee][amount]" class="custom-input amount-input"
                        value="{{ $applicant->payment_details['app_fee']['amount'] ?? '2360' }}" readonly>
                </div>

                <div class="field">
                    <label class="field-label">Payment Status</label>
                    <div class="status-display success">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Successful
                    </div>
                </div>
            </div>
        </div> --}}

    {{-- EMD Fee Card --}}
    {{-- <div class="payment-card">
            <div class="payment-card-head">
                <div class="payment-card-title">
                    <div class="payment-type-icon emd-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23" />
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                    </div>
                    <div>
                        <span class="payment-name">EMD Fee</span>
                        <span class="payment-mode-chip challan">Challan</span>
                    </div>
                </div>
                <div class="payment-amount-block">
                    <span class="payment-amount-label">Amount</span>
                    <span class="payment-amount">₹2,08,800</span>
                </div>
                <div class="payment-status-chip success">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Success
                </div>
            </div>

            <div class="form-grid">
                <div class="field">
                    <label class="field-label">Payment For</label>
                    <input type="text" class="custom-input" value="EMD Fee" readonly>
                </div>

                <div class="field">
                    <label class="field-label">Payment Mode</label>
                    <input type="text" class="custom-input" value="Challan" readonly>
                </div>

                <div class="field">
                    <label class="field-label">Client Transaction ID</label>
                    <input type="text" name="payment_details[emd_fee][client_txn_id]"
                        class="custom-input txn-input"
                        value="{{ $applicant->payment_details['emd_fee']['client_txn_id'] ?? 'JSHBTNX0525699683a793a9e70b' }}">
                </div>

                <div class="field">
                    <label class="field-label">Transaction ID</label>
                    <input type="text" name="payment_details[emd_fee][txn_id]" class="custom-input txn-input"
                        value="{{ $applicant->payment_details['emd_fee']['txn_id'] ?? 'ICL50531229931781' }}">
                </div>

                <div class="field">
                    <label class="field-label">Amount (₹)</label>
                    <input type="text" name="payment_details[emd_fee][amount]" class="custom-input amount-input"
                        value="{{ $applicant->payment_details['emd_fee']['amount'] ?? '208800' }}" readonly>
                </div>

                <div class="field">
                    <label class="field-label">Payment Status</label>
                    <div class="status-display success">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Successful
                    </div>
                </div>
            </div>
        </div> --}}

    {{-- Payment Summary footer --}}
    {{-- <div class="payment-total-bar">
            <div class="total-bar-left">
                <div class="total-bar-label">Application Number</div>
                <div class="total-bar-appno">{{ $applicant->application_number ?? 'JSHBA-' . time() }}</div>
            </div>
            <div class="total-bar-divider"></div>
            <div class="total-bar-right">
                <div class="total-bar-label">Total Amount Paid</div>
                <div class="total-bar-amount">₹2,11,160</div>
            </div>
        </div> --}}
    {{-- </div> --}}
</form>

<style>
    /* ── Input with unit ── */
    .input-unit-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .custom-input.has-unit {
        padding-right: 54px;
    }

    .input-unit {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        padding: 0 14px;
        font-size: 12px;
        font-weight: 600;
        color: #000000;
        background: var(--gold-lt);
        border: 1.5px solid var(--border);
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        letter-spacing: 0.04em;
        pointer-events: none;
    }

    /* ── Property Summary Pills ── */
    .property-summary {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px dashed var(--border);
    }

    .prop-pill {
        display: flex;
        flex-direction: column;
        gap: 3px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px 16px;
        min-width: 120px;
        flex: 1;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .prop-pill:hover {
        border-color: var(--gold);
        box-shadow: 0 2px 8px rgba(201, 168, 76, 0.12);
    }

    .prop-pill-label {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--muted);
    }

    .prop-pill-value {
        font-size: 13px;
        font-weight: 600;
        color: var(--ink);
    }

    ── Payment Card ── .payment-card {
        background: #faf9f6;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 22px;
        margin-bottom: 16px;
        transition: border-color 0.2s, box-shadow 0.2s;
        animation: cardIn 0.3s ease;
    }

    .payment-card:hover {
        border-color: var(--gold);
        box-shadow: 0 4px 16px rgba(201, 168, 76, 0.08);
    }

    .payment-card-head {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px dashed var(--border);
        flex-wrap: wrap;
    }

    .payment-card-title {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .payment-type-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .app-fee-icon {
        background: #e0ecff;
        color: #1a56d6;
    }

    .emd-icon {
        background: var(--success-lt);
        color: var(--success);
    }

    .payment-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--ink);
        font-family: 'Fraunces', serif;
        display: block;
    }

    .payment-mode-chip {
        display: inline-block;
        margin-top: 3px;
        padding: 2px 10px;
        background: var(--gold-lt);
        color: var(--gold-dk);
        border-radius: 20px;
        font-size: 10.5px;
        font-weight: 600;
        letter-spacing: 0.04em;
    }

    .payment-mode-chip.challan {
        background: #ede9ff;
        color: #5b21b6;
    }

    .payment-amount-block {
        text-align: right;
        margin-left: auto;
    }

    .payment-amount-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--muted);
        display: block;
        margin-bottom: 2px;
    }

    .payment-amount {
        font-family: 'Fraunces', serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--ink);
    }

    .payment-status-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .payment-status-chip.success {
        background: var(--success-lt);
        color: var(--success);
    }

    /* Transaction ID input style */
    .custom-input.txn-input {
        font-size: 12.5px;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.03em;
        color: #4a5062;
    }

    .custom-input.amount-input {
        font-family: 'Fraunces', serif;
        font-size: 15px;
        font-weight: 600;
        color: var(--ink);
    }

    /* Status display (non-input) */
    .status-display {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 11px 14px;
        background: var(--success-lt);
        border: 1.5px solid #a7f3d0;
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-weight: 600;
        color: var(--success);
    }

    /* ── Payment Total Bar ── */
    .payment-total-bar {
        display: flex;
        align-items: center;
        gap: 24px;
        background: var(--ink);
        border-radius: var(--radius-sm);
        padding: 18px 24px;
        margin-top: 6px;
        position: relative;
        overflow: hidden;
    }

    .payment-total-bar::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 400px 200px at 80% 50%, rgba(201, 168, 76, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    .total-bar-label {
        font-size: 10px;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.45);
        margin-bottom: 5px;
    }

    .total-bar-appno {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.04em;
    }

    .total-bar-divider {
        width: 1px;
        height: 40px;
        background: rgba(255, 255, 255, 0.12);
        flex-shrink: 0;
    }

    .total-bar-right {
        margin-left: auto;
        text-align: right;
    }

    .total-bar-amount {
        font-family: 'Fraunces', serif;
        font-size: 22px;
        font-weight: 700;
        color: var(--gold);
    }

    @keyframes cardIn {
        from {
            opacity: 0;
            transform: translateY(-6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
