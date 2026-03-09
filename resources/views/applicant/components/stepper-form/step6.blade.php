<div class="review-section">
    <!-- Header with Application Number -->
    <div class="review-header">
        <h3 class="review-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 12l2 2 4-4"></path>
                <circle cx="12" cy="12" r="10"></circle>
            </svg>
            Review Your Application
        </h3>
        @if ($applicant)
            <div class="application-badge">
                <span class="badge-label">Application No:</span>
                <span class="badge-value">{{ $applicant->application_number }}</span>
            </div>
        @endif
    </div>

    <!-- Personal Details Table -->
    <div class="review-table-container">
        <div class="table-header" style="background: linear-gradient(90deg, #aa7700, #ffb703);">
            <div class="header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="header-content">
                <h4>Personal Details</h4>
                <p>Allottee information verification</p>
            </div>
        </div>
        <table class="review-table">
            <tr>
                <td class="label-cell">Full Name</td>
                <td class="value-cell">Rajesh Kumar Sharma</td>
                <td class="label-cell">Father's Name</td>
                <td class="value-cell">Ramesh Kumar Sharma</td>
            </tr>
            <tr>
                <td class="label-cell">Date of Birth</td>
                <td class="value-cell">15 Aug 1985</td>
                <td class="label-cell">Gender</td>
                <td class="value-cell">Male</td>
            </tr>
            <tr>
                <td class="label-cell">Marital Status</td>
                <td class="value-cell">Married</td>
                <td class="label-cell">Annual Income</td>
                <td class="value-cell">MGL more than 6 Lac & up to 12 Lac</td>
            </tr>
            <tr>
                <td class="label-cell">PAN Card</td>
                <td class="value-cell mono">ABCDE1234F</td>
                <td class="label-cell">Aadhaar Card</td>
                <td class="value-cell mono">9876 XXXX 3210</td>
            </tr>
            <tr>
                <td class="label-cell">Email Address</td>
                <td class="value-cell">rajesh.sharma@example.com</td>
                <td class="label-cell">Mobile Number</td>
                <td class="value-cell mono">9876543210</td>
            </tr>
        </table>
    </div>

    <!-- Address Details Table -->
    <div class="review-table-container">
        <div class="table-header" style="background: linear-gradient(90deg, #00c6ff, #0072ff);">
            <div class="header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
            <div class="header-content">
                <h4>Address Details</h4>
                <p>Residential address verification</p>
            </div>
        </div>
        <table class="review-table">
            <tr>
                <td class="label-cell" style="width: 15%;">Present Address</td>
                <td class="value-cell" colspan="3">House No. 42, Gandhi Nagar, Near Railway Station, Medininagar</td>
            </tr>
            <tr>
                <td class="label-cell">Post Office</td>
                <td class="value-cell">Medininagar HO</td>
                <td class="label-cell">Police Station</td>
                <td class="value-cell">Medininagar PS</td>
            </tr>
            <tr>
                <td class="label-cell">District</td>
                <td class="value-cell">Palamu</td>
                <td class="label-cell">State</td>
                <td class="value-cell">Jharkhand</td>
            </tr>
            <tr>
                <td class="label-cell">Pin Code</td>
                <td class="value-cell mono">822101</td>
                <td class="label-cell"></td>
                <td class="value-cell"></td>
            </tr>
        </table>
    </div>

    <!-- Nominee Details Table -->
    <div class="review-table-container">
        <div class="table-header" style="background: linear-gradient(90deg, #fc466b, #3f5efb);">
            <div class="header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="header-content">
                <h4>Nominee Details</h4>
                <p>Nominee information verification</p>
            </div>
        </div>
        <table class="review-table">
            <tr>
                <td class="label-cell">Nominee Name</td>
                <td class="value-cell">Sunita Devi</td>
                <td class="label-cell">Relationship</td>
                <td class="value-cell">Spouse</td>
            </tr>
            <tr>
                <td class="label-cell">Nominee PAN</td>
                <td class="value-cell mono">SUNID1234F</td>
                <td class="label-cell">Nominee Aadhaar</td>
                <td class="value-cell mono">9876 XXXX 0012</td>
            </tr>
        </table>
    </div>

    <!-- Family Details Table -->
    <div class="review-table-container">
        <div class="table-header" style="background: linear-gradient(90deg, #11998e, #38ef7d);">
            <div class="header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="header-content">
                <h4>Family Details</h4>
                <p>Family member information</p>
            </div>
        </div>
        <table class="review-table">
            <thead>
                <tr>
                    <th class="table-subhead">Full Name</th>
                    <th class="table-subhead">Gender</th>
                    <th class="table-subhead">Date of Birth</th>
                    <th class="table-subhead">Relationship</th>
                    <th class="table-subhead">Aadhaar Number</th>
                    <th class="table-subhead">PAN Card</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Ramesh Kumar</td>
                    <td>Male</td>
                    <td>15-06-1985</td>
                    <td>Spouse</td>
                    <td class="mono">9876 XXXX 0012</td>
                    <td class="mono">RAMESH1234P</td>
                </tr>
                <tr>
                    <td>Priya Kumari</td>
                    <td>Female</td>
                    <td>10-03-2010</td>
                    <td>Daughter</td>
                    <td class="mono">1234 XXXX 5678</td>
                    <td class="mono">-</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Bank Details Table -->
    <div class="review-table-container">
        <div class="table-header" style="background: linear-gradient(90deg, #f7971e, #ffd200);">
            <div class="header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="2" y="6" width="20" height="16" rx="2"></rect>
                    <path d="M2 12h20"></path>
                    <path d="M7 12v5"></path>
                    <path d="M17 12v5"></path>
                    <path d="M7 6V4"></path>
                    <path d="M17 6V4"></path>
                </svg>
            </div>
            <div class="header-content">
                <h4>Bank Details</h4>
                <p>Bank account information</p>
            </div>
        </div>
        <table class="review-table">
            <tr>
                <td class="label-cell" style="width: 15%;">Bank Name</td>
                <td class="value-cell" style="width: 35%;">State Bank of India</td>
                <td class="label-cell" style="width: 15%;">Account Number</td>
                <td class="value-cell mono" style="width: 35%;">****3456</td>
            </tr>
            <tr>
                <td class="label-cell">Branch</td>
                <td class="value-cell">Palamu Main Branch</td>
                <td class="label-cell">IFSC Code</td>
                <td class="value-cell mono">SBIN0001234</td>
            </tr>
        </table>
    </div>
</div>

<style>
    .review-section {
        margin: 0 auto;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .review-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
    }

    .review-title svg {
        color: #aa7700;
    }

    .application-badge {
        background: #f8f9fa;
        padding: 8px 16px;
        border-radius: 30px;
        border: 1px solid #e0e0e0;
        font-size: 0.9rem;
    }

    .badge-label {
        color: #666;
        margin-right: 8px;
    }

    .badge-value {
        color: #aa7700;
        font-weight: 600;
        font-family: monospace;
        font-size: 1rem;
    }

    .review-table-container {
        margin-bottom: 25px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        background: white;
    }

    .table-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px 20px;
        color: white;
    }

    .header-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
    }

    .header-content h4 {
        margin: 0 0 4px;
        font-size: 1rem;
        font-weight: 600;
    }

    .header-content p {
        margin: 0;
        font-size: 0.8rem;
        opacity: 0.9;
    }

    .review-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .review-table tr {
        border-bottom: 1px solid #f0f0f0;
    }

    .review-table tr:last-child {
        border-bottom: none;
    }

    .review-table td {
        padding: 12px 15px;
        font-size: 0.9rem;
    }

    .label-cell {
        background: #f8f9fa;
        font-weight: 500;
        color: #666;
        width: 15%;
        border-right: 1px solid #f0f0f0;
    }

    .value-cell {
        color: #333;
        font-weight: 400;
        width: 35%;
    }

    .review-table th {
        background: #f8f9fa;
        padding: 10px 15px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #555;
        text-align: left;
        border-bottom: 2px solid #e0e0e0;
    }

    .table-subhead {
        background: #f8f9fa;
        font-size: 0.85rem;
        font-weight: 600;
        color: #555;
    }

    .mono {
        font-family: 'Courier New', monospace;
        font-weight: 500;
    }

    .review-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }

    .btn-edit,
    .btn-confirm {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        border: none;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-edit {
        background: white;
        color: #666;
        border: 1px solid #ddd;
    }

    .btn-edit:hover {
        background: #f8f9fa;
        border-color: #999;
    }

    .btn-confirm {
        background: #aa7700;
        color: white;
    }

    .btn-confirm:hover {
        background: #8b6200;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(170, 119, 0, 0.2);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .review-section {
            padding: 15px;
        }

        .review-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .review-table,
        .review-table tbody,
        .review-table tr,
        .review-table td {
            display: block;
        }

        .review-table tr {
            margin-bottom: 10px;
            border: 1px solid #f0f0f0;
            border-radius: 8px;
        }

        .review-table td {
            display: flex;
            padding: 10px;
            border: none;
        }

        .label-cell {
            width: 40%;
            background: none;
            border: none;
        }

        .value-cell {
            width: 60%;
        }

        .review-table th {
            display: none;
        }
    }

    /* Compact Mode */
    @media (min-width: 1200px) {
        .review-table td {
            padding: 10px 15px;
            font-size: 0.85rem;
        }

        .review-table-container {
            margin-bottom: 20px;
        }

        .table-header {
            padding: 12px 20px;
        }
    }
</style>
