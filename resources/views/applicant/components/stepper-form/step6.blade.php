{{-- resources/views/applicant/components/stepper-form/step3.blade.php --}}
<form id="step6Form" method="POST">
    @csrf

    {{-- ── Uploads Documents ── --}}
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
                <h3 class="section-title">Allottee Documents Uploads</h3>
                <p class="section-desc">Upload required documents for the allottee</p>
            </div>
        </div>
    </div>
    <div class="form-grid">
        <div class="field">
            <label class="field-label">Division Office <span class="req-star">*</span></label>
            <input type="text" name="division_office" class="custom-input"
                value="{{ $applicant->division_office ?? 'Hazaribagh & Daltonganj Division' }}"
                placeholder="Enter division office" required>
        </div>
    </div>
</form>
