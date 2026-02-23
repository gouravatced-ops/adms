<div class="review-section">
    <h3 class="section-title mb-3">Review Your Application</h3>

    @if ($applicant)
        <div class="alert alert-info">
            <strong>Application Number:</strong> {{ $applicant->application_number }}
        </div>
    @endif
    <!-- Personal Details Card -->
    <div class="review-card">
        <div class="section-header gradient-header" style="background: linear-gradient(90deg, #aa7700, #ffb703);">
            <div class="section-icon">
                <!-- Review / Verification SVG -->
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 12l2 2 4-4"></path>
                    <path d="M21 12c0 5-9 9-9 9s-9-4-9-9 4-9 9-9 9 4 9 9z"></path>
                </svg>
            </div>
            <div>
                <h3 class="section-title">Allottee Review Details</h3>
                <p class="section-desc">Review and verification of allottee information</p>
            </div>
        </div>
        <div class="review-grid">
            <div class="review-pair">
                <span class="rp-label">Full Name</span><span class="rp-value">Rajesh Kumar Sharma</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Father's Name</span><span class="rp-value">Ramesh Kumar Sharma</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Date of Birth</span><span class="rp-value">15 Aug 1985</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Gender</span><span class="rp-value">Male</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Marital Status</span><span class="rp-value">Married</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Annual Income</span><span class="rp-value">MGL more than 6 Lac &amp; up to 12
                    Lac</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">PAN Card</span><span class="rp-value mono">ABCDE1234F</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Aadhaar Card</span><span class="rp-value mono">9876 XXXX 3210</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Email Address</span><span class="rp-value">rajesh.sharma@example.com</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Mobile Number</span><span class="rp-value mono">9876543210</span>
            </div>
        </div>
    </div>

    <div class="review-card">
        <div class="section-header gradient-header" style="background: linear-gradient(90deg, #00c6ff, #0072ff)">
            <div class="section-icon">
                <!-- Address / Location SVG -->
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
            <div>
                <h3 class="section-title">Address Review Details </h3>
                <p class="section-desc">Review and verification of allottee Address</p>
            </div>
        </div>
        <div class="review-grid">
            <div class="review-pair">
                <span class="rp-label">Present Address</span><span class="rp-value">House No. 42, Gandhi Nagar,
                    Near Railway Station, Medininagar</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Post Office</span><span class="rp-value">Medininagar HO</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Police Station</span><span class="rp-value">Medininagar PS</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">District</span><span class="rp-value">Palamu</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">State</span><span class="rp-value">Jharkhand</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Pin Code</span><span class="rp-value mono">822101</span>
            </div>
        </div>
    </div>

    <!-- Nominee & Bank Card -->
    <div class="review-card">
        <div class="section-header gradient-header" style="background: linear-gradient(90deg, #fc466b, #3f5efb)">
            <div class="section-icon">
                <!-- Address / Location SVG -->
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
            <div>
                <h3 class="section-title">Nominee, Family Details & Bank Details</h3>
                <p class="section-desc">Review and verification of nominee, family and bank details</p>
            </div>
        </div>
        <div class="review-grid">
            <div class="review-pair">
                <span class="rp-label">Nominee Name</span><span class="rp-value">Sunita Devi</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Relationship</span><span class="rp-value">Spouse</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Nominee PAN</span><span class="rp-value mono">SUNID1234F</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Nominee Aadhaar</span><span class="rp-value mono">9876 XXXX 0012</span>
            </div>
        </div>
        <div class="review-subsection">
            <div class="review-subsection-title">Family Details</div>
            <div class="review-grid">
                <div class="review-pair">
                    <span class="rp-label">Full Name </span><span class="rp-value">Ramesh Kumar</span>
                </div>
                <div class="review-pair">
                    <span class="rp-label">Gender</span><span class="rp-value mono">Male</span>
                </div>
                <div class="review-pair">
                    <span class="rp-label">Date of Birth</span><span class="rp-value">15-06-1985</span>
                </div>
                <div class="review-pair">
                    <span class="rp-label">Relationship</span><span class="rp-value mono">Spouse</span>
                </div>
                <div class="review-pair">
                    <span class="rp-label">Aadhaar Number </span><span class="rp-value mono">9876 XXXX 0012</span>
                </div>
                <div class="review-pair">
                    <span class="rp-label">PAN Card</span><span class="rp-value mono">RAMESH1234P</span>
                </div>
            </div>
        </div>
        <div class="review-subsection">
            <div class="review-subsection-title">Bank Details</div>
            <div class="review-grid">
                <div class="review-pair">
                    <span class="rp-label">Bank Name</span><span class="rp-value">State Bank of India</span>
                </div>
                <div class="review-pair">
                    <span class="rp-label">Account Number</span><span class="rp-value mono">****3456</span>
                </div>
                <div class="review-pair">
                    <span class="rp-label">Branch</span><span class="rp-value">Palamu Main Branch</span>
                </div>
                <div class="review-pair">
                    <span class="rp-label">IFSC Code</span><span class="rp-value mono">SBIN0001234</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Property & Payment Card -->
    <div class="review-card">
        <div class="section-header gradient-header" style="background: linear-gradient(90deg, #fc466b, #3f5efb)">
            <div class="section-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </div>
            <div>
                <h3 class="section-title">Property Details</h3>
                <p class="section-desc">Review and verification of property details</p>
            </div>
        </div>
        <div class="review-grid">
            <div class="review-pair">
                <span class="rp-label">Division Office</span><span class="rp-value">Hazaribagh &amp; Daltonganj
                    Division</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Property Location</span><span class="rp-value">Medininagar, formerly
                    Daltonganj (BARALOTA)</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Yojana Name</span><span class="rp-value">36 MIG PLOT</span>
            </div>
            <div class="review-pair">
                <span class="rp-label">Property Area</span><span class="rp-value">1800 sq.ft</span>
            </div>
        </div>
    </div>
</div>
