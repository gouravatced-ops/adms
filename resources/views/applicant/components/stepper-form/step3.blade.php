{{-- resources/views/applicant/components/stepper-form/step2.blade.php --}}
<style>
    .form-block {
        line-height: 1.9;
        background: #fafafa;
        /* padding: 15px 40px; */
    }

    table.form-table {
        width: 100%;
        border-collapse: collapse;
    }

    table.form-table td {
        padding: 10px 8px;
        vertical-align: top;
    }

    table.form-table tr {
        border-bottom: 1px dashed #ddd;
    }

    table.form-table tr:nth-child(even) {
        background-color: #f5f4f0;
        /* Light Yellow */
    }

    .term {
        width: 60%;
        font-weight: 500;
        font-size: 16px;
    }

    .input-cell {
        width: 40%;
    }

    input {
        border: 1.5px solid #ccc !important;
        font-size: 15px;
        padding: 6px 8px;
        width: 100%;
        border-radius: inherit;
    }

    .small {
        max-width: 120px;
    }

    .medium {
        max-width: 200px;
    }

    .long {
        width: 100%;
    }

    table.form-table {
        width: 100%;
        border-collapse: collapse;
    }

    table.form-table th {
        padding: 10px;
        text-align: left;
        border-bottom: 2px solid #e0a800;
    }

    table.form-table td {
        padding: 8px;
    }

    table.form-table tbody tr:nth-child(even) {
        background-color: #fffde7;
    }

    table.form-table tr {
        border-bottom: 1px dashed #ddd;
    }

    /* Sl. Number Column */
    td.sl {
        text-align: center;
        font-weight: 600;
        border-right: 1px solid #ccc;
    }

    /* Select Styling */
    .custom-select {
        width: 100%;
        padding: 6px 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        cursor: pointer;
    }

    /* Focus Effect */
    .custom-select:focus {
        border-color: #e0a800;
        outline: none;
        box-shadow: 0 0 3px rgba(224, 168, 0, 0.4);
    }

    /* Hover */
    .custom-select:hover {
        border-color: #d39e00;
    }

    /* Date Group Layout */
    .date-group {
        display: flex;
        gap: 8px;
    }

    /* Smaller width selects */
    .small-select {
        width: 130px;
    }
</style>
<form id="step3Form" method="POST">
    @csrf

    {{-- ── Property Financial Details ── --}}
    <div class="form-section">
        {{-- <div class="section-header gradient-header" style="background: linear-gradient(90deg, #aa7700, #ffb703);">
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
                <h3 class="section-title">Property Financial Details</h3>
                <p class="section-desc">Person nominated to receive benefits on your behalf</p>
            </div>
        </div> --}}
        <div class="form-block">
            <table class="form-table">
                <thead>
                    <tr>
                        <th style="width:100px;">Sl. No.</th>
                        <th>विवरण (Description)</th>
                        <th>प्रविष्टि दर्ज करें (Enter Details)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="sl">1.</td>
                        <td class="term">भूखंड के अंतरिम (टेन्टेटिव) कीमत (Tentative Plot Price)</td>
                        <td><input name="tentative_price" id="tentative_price" placeholder="राशि दर्ज करें / Enter Amount"></td>
                    </tr>
                    <tr>
                        <td class="sl">2.</td>
                        <td class="term">राशि रुपये (शब्दों में) (Amount in Words)</td>
                        <td><input name="amount_words" placeholder="राशि शब्दों में / Amount in Words"></td>
                    </tr>
                    <tr>
                        <td class="sl">3.</td>
                        <td class="term">मूल्यांकन दिनांक (Valuation Date)</td>
                        <td class="value date-group">

                            <!-- Day Dropdown -->
                            <select name="maav_day" class="custom-select small-select">
                                <option value="">दिन / Day</option>
                                <?php for ($d = 1; $d <= 31; $d++): ?>
                                <option value="<?= str_pad($d, 2, '0', STR_PAD_LEFT) ?>">
                                    <?= str_pad($d, 2, '0', STR_PAD_LEFT) ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                            /
                            <!-- Month Dropdown -->
                            <select name="maav_month" class="custom-select small-select">
                                <option value="">माह / Month</option>
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>">
                                    <?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                            /
                            <!-- Year Dropdown -->
                            <select name="maav_year" class="custom-select small-select">
                                <option value="">वर्ष / Year</option>
                                <?php 
                                    $currentYear = date('Y');
                                    for ($y = $currentYear; $y >= 1970; $y--): 
                                ?>
                                <option value="<?= $y ?>"><?= $y ?></option>
                                <?php endfor; ?>
                            </select>

                        </td>
                    </tr>

                    <tr>
                        <td class="sl">4.</td>
                        <td class="term">निर्गत होने की तिथि के अंदर (दिनों में) (Issue Period in Days)</td>
                        <td><input name="nirgat_days" placeholder="दिन दर्ज करें / Enter Days"></td>
                    </tr>

                    <tr>
                        <td class="sl">5.</td>
                        <td class="term">उच्चतम आय वर्ग, अंतरिम कीमत का (%) (High Income % of Tentative Price)</td>
                        <td><input name="high_income_percent" id="high_income_percent" placeholder="प्रतिशत / Percentage"></td>
                    </tr>

                    <tr>
                        <td class="sl">6.</td>
                        <td class="term">अल्प/कमजोर वर्ग, अंतरिम कीमत का (%) (Low Income % of Tentative Price)</td>
                        <td><input name="low_income_percent" id="low_income_percent" placeholder="प्रतिशत / Percentage"></td>
                    </tr>

                    <tr>
                        <td class="sl">7.</td>
                        <td class="term">जमा की गयी राशि (-) (Deposited Amount)</td>
                        <td><input name="deposited_amount" id="deposited_amount" placeholder="जमा राशि / Deposited Amount"></td>
                    </tr>

                    <tr>
                        <td class="sl">8.</td>
                        <td class="term">विधि एवं अनुशासन शुल्क (+) (Legal & Discipline Fee)</td>
                        <td><input name="legal_fee" id="legal_fee" placeholder="शुल्क दर्ज करें / Enter Fee"></td>
                    </tr>
                    
                    <tr>
                        <td class="sl">9.</td>
                        <td class="term">विधि एवं अभिलेखन शुल्क  (+) (Legal and Documentation Charges)</td>
                        <td><input name="legal_document_fee" id="legal_document_fee" placeholder="शुल्क दर्ज करें / Enter Fee"></td>
                    </tr>

                    <tr>
                        <td class="sl">10.</td>
                        <td class="term">कुल भुक्तान राशि (Total Payment Amount)</td>
                        <td><input name="total_payment" id="total_payment" placeholder="कुल राशि / Total Amount"></td>
                    </tr>

                    <tr>
                        <td class="sl">11.</td>
                        <td class="term">प्रतिष्ठित राशि अवधि (40/30 ब्याज सहित) (Instalment Amount with Interest)
                        </td>
                        <td><input name="installment_amount" id="installment_amount" placeholder="राशि दर्ज करें / Enter Amount"></td>
                    </tr>

                    <tr>
                        <td class="sl">12.</td>
                        <td class="term">अंतरिम कीमत (Tentative Price)</td>
                        <td><input name="interim_price" id="interim_price" placeholder="अंतरिम कीमत / Tentative Price"></td>
                    </tr>

                    <tr>
                        <td class="sl">13.</td>
                        <td class="term">शेष राशि (Remaining Amount)</td>
                        <td><input name="remaining_amount" id="remaining_amount" placeholder="शेष राशि / Remaining Amount"></td>
                    </tr>

                    <tr>
                        <td class="sl">14.</td>
                        <td class="term">भुगतान मास (किस्तों में) (Payment Months in Instalments)</td>
                        <td><input name="payment_months" id="payment_months" placeholder="महीनों की संख्या / Number of Months"></td>
                    </tr>

                    <tr>
                        <td class="sl">15.</td>
                        <td class="term">ब्याज का प्रकार (Type of Interest)</td>
                        <td class="value">
                            <select name="interest_type" id="interest_type" class="custom-select">
                                <option value="">-- चयन करें / Select --</option>
                                <option value="simple">साधारण ब्याज / Simple Interest</option>
                                <option value="compound">चक्रवृद्धि ब्याज / Compound Interest</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="sl">16.</td>
                        <td class="term">पूर्व भुगतान पर वृद्धि व्याज (%) (Prepayment Interest %)</td>
                        <td><input name="pre_interest" id="pre_interest" placeholder="प्रतिशत / Percentage"></td>
                    </tr>

                    <tr>
                        <td class="sl">17.</td>
                        <td class="term">विलंब पर वृद्धि व्याज (%) (Late Payment Interest %)</td>
                        <td><input name="late_interest" id="late_interest" placeholder="प्रतिशत / Percentage"></td>
                    </tr>

                    <tr>
                        <td class="sl">18.</td>
                        <td class="term">व्याज राशि (₹) (Interest Amount)</td>
                        <td><input name="pre_interest" id="pre_interest" placeholder="प्रतिशत / Percentage"></td>
                    </tr>

                    <tr>
                        <td class="sl">19.</td>
                        <td class="term">दंड वृद्धि व्याज (₹) (Penalty increase interest)</td>
                        <td><input name="late_interest" id="late_interest" placeholder="प्रतिशत / Percentage"></td>
                    </tr>

                    <tr>
                        <td class="sl">20.</td>
                        <td class="term">निर्धारित अवधि (दिनों में) (Specified Period in Days)</td>
                        <td><input name="specified_days" placeholder="दिन दर्ज करें / Enter Days"></td>
                    </tr>

                    <tr>
                        <td class="sl">21.</td>
                        <td class="term">अंतिम जमा करने की तिथि (Last Submission Date)</td>
                        <td class="value date-group">

                            <!-- Day -->
                            <select name="last_day" class="custom-select small-select">
                                <option value="">दिन / Day</option>
                                <?php for ($d = 1; $d <= 31; $d++): ?>
                                <option value="<?= str_pad($d, 2, '0', STR_PAD_LEFT) ?>">
                                    <?= str_pad($d, 2, '0', STR_PAD_LEFT) ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                            /
                            <!-- Month -->
                            <select name="last_month" class="custom-select small-select">
                                <option value="">माह / Month</option>
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>">
                                    <?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                            /
                            <!-- Year -->
                            <select name="last_year" class="custom-select small-select">
                                <option value="">वर्ष / Year</option>
                                <?php 
                                    $currentYear = date('Y');
                                    for ($y = $currentYear; $y >= 1970; $y--): 
                                ?>
                                <option value="<?= $y ?>"><?= $y ?></option>
                                <?php endfor; ?>
                            </select>

                        </td>
                    </tr>

                    <tr>
                        <td class="sl">22.</td>
                        <td class="term">आवंटन दिनांक (Allotment Date)</td>
                        <td class="value date-group">

                            <!-- Day -->
                            <select name="allot_day" class="custom-select small-select">
                                <option value="">दिन / Day</option>
                                <?php for ($d = 1; $d <= 31; $d++): ?>
                                <option value="<?= str_pad($d, 2, '0', STR_PAD_LEFT) ?>">
                                    <?= str_pad($d, 2, '0', STR_PAD_LEFT) ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                            /
                            <!-- Month -->
                            <select name="allot_month" class="custom-select small-select">
                                <option value="">माह / Month</option>
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>">
                                    <?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                            /
                            <!-- Year -->
                            <select name="allot_year" class="custom-select small-select">
                                <option value="">वर्ष / Year</option>
                                <?php 
                                    $currentYear = date('Y');
                                    for ($y = $currentYear; $y >= 1970; $y--): 
                                ?>
                                <option value="<?= $y ?>"><?= $y ?></option>
                                <?php endfor; ?>
                            </select>

                        </td>
                    </tr>

                    <tr>
                        <td class="sl">23.</td>
                        <td class="term">किस लॉटरी के तहत (शब्दों में) (Lottery Details in Words)</td>
                        <td><input name="lottery_details" placeholder="लॉटरी विवरण / Lottery Details"></td>
                    </tr>

                    <tr>
                        <td class="sl">24.</td>
                        <td class="term">आवासीय कॉलोनी का नाम (Residential Colony Name)</td>
                        <td><input name="colony_name" placeholder="कॉलोनी का नाम / Colony Name"></td>
                    </tr>

                    <tr>
                        <td class="sl">25.</td>
                        <td class="term">बोर्ड द्वारा आवंटीत भूखंड संख्या (Board Allotted Plot No.)</td>
                        <td><input name="plot_number" placeholder="भूखंड संख्या / Plot Number"></td>
                    </tr>

                    <tr>
                        <td class="sl">26.</td>
                        <td class="term">रकबा (वर्गफीट) (Area in Sq. Ft.)</td>
                        <td><input name="area_sqft" placeholder="क्षेत्रफल / Area"></td>
                    </tr>

                    <tr>
                        <td class="sl">27.</td>
                        <td class="term">मुहल्ला (Locality)</td>
                        <td><input name="mohalla" placeholder="मुहल्ला / Locality"></td>
                    </tr>

                    <tr>
                        <td class="sl">28.</td>
                        <td class="term">डाकघर (Post Office)</td>
                        <td><input name="post_office" placeholder="डाकघर / Post Office"></td>
                    </tr>

                    <tr>
                        <td class="sl">29.</td>
                        <td class="term">शहर (City)</td>
                        <td><input name="city" placeholder="शहर / City"></td>
                    </tr>

                    <tr>
                        <td class="sl">30.</td>
                        <td class="term">थाना (Police Station)</td>
                        <td><input name="police_station" placeholder="थाना / Police Station"></td>
                    </tr>

                    <tr>
                        <td class="sl">31.</td>
                        <td class="term">जिला (District)</td>
                        <td><input name="district" placeholder="जिला / District"></td>
                    </tr>

                    <tr>
                        <td class="sl">32.</td>
                        <td class="term">चौहद्दी - उत्तर सीमा (Boundary - North)</td>
                        <td><input name="north_boundary" placeholder="उत्तर सीमा / North Boundary"></td>
                    </tr>

                    <tr>
                        <td class="sl">33.</td>
                        <td class="term">चौहद्दी - दक्षिण सीमा (Boundary - South)</td>
                        <td><input name="south_boundary" placeholder="दक्षिण सीमा / South Boundary"></td>
                    </tr>

                    <tr>
                        <td class="sl">34.</td>
                        <td class="term">चौहद्दी - पूरब सीमा (Boundary - East)</td>
                        <td><input name="east_boundary" placeholder="पूरब सीमा / East Boundary"></td>
                    </tr>

                    <tr>
                        <td class="sl">35.</td>
                        <td class="term">चौहद्दी - पश्चिम सीमा (Boundary - West)</td>
                        <td><input name="west_boundary" placeholder="पश्चिम सीमा / West Boundary"></td>
                    </tr>

                    <tr>
                        <td class="sl">36.</td>
                        <td class="term">पूरब से पश्चिम उत्तर तरफ (फीट) (East-West North Side in Ft.)</td>
                        <td><input name="ew_north" placeholder="फीट में लंबाई / Length in Ft."></td>
                    </tr>

                    <tr>
                        <td class="sl">37.</td>
                        <td class="term">पूरब से पश्चिम दक्षिण तरफ (फीट) (East-West South Side in Ft.)</td>
                        <td><input name="ew_south" placeholder="फीट में लंबाई / Length in Ft."></td>
                    </tr>

                    <tr>
                        <td class="sl">38.</td>
                        <td class="term">उत्तर से दक्षिण पूरब तरफ (फीट) (North-South East Side in Ft.)</td>
                        <td><input name="ns_east" placeholder="फीट में लंबाई / Length in Ft."></td>
                    </tr>

                    <tr>
                        <td class="sl">39.</td>
                        <td class="term">उत्तर से दक्षिण पश्चिम तरफ (फीट) (North-South West Side in Ft.)</td>
                        <td><input name="ns_west" placeholder="फीट में लंबाई / Length in Ft."></td>
                    </tr>

                </tbody>

            </table>
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
