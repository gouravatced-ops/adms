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

    table.form-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        /* Important for fixed width columns */
    }

    /* Header Width Control */
    table.form-table th:nth-child(1),
    table.form-table td:nth-child(1) {
        width: 10%;
        text-align: center;
    }

    table.form-table th:nth-child(2),
    table.form-table td:nth-child(2) {
        width: 45%;
    }

    table.form-table th:nth-child(3),
    table.form-table td:nth-child(3) {
        width: 45%;
    }

    /* Header Styling */
    table.form-table th {
        padding: 10px;
        text-align: left;
        border-bottom: 2px solid #e0a800;
    }

    /* Row Styling */
    table.form-table tr {
        border-bottom: 1px dashed #ddd;
    }

    table.form-table tbody tr:nth-child(even) {
        background-color: #fffde7;
    }

    /* Input Styling */
    table.form-table input {
        width: 100%;
        padding: 6px 8px;
        border: 1.5px solid #ccc;
        font-size: 15px;
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

    table tbody {
        counter-reset: rowNumber;
    }

    table tbody tr {
        counter-increment: rowNumber;
    }

    table tbody tr td.sl::before {
        content: counter(rowNumber) ".";
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
@php
    $states = getStates();
    $subdivision = getSubDivisionById($applicant->subdivision_id) ?? '';
    #return getDebugIndex($applicant);
@endphp
<form id="step3Form" method="POST">
    @csrf
    <input type="hidden" name="allottee_id" value="{{ $applicant->id ?? '' }}">
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
                        <td class="sl"></td>
                        <td class="term">भूखंड के अंतरिम (टेन्टेटिव) कीमत (Tentative Plot Price)</td>
                        <td><input name="tentative_price" id="tentative_price" class="only-number num-input"
                                data-word-target="amount_words" data-word-postfix=" Only"
                                value="{{ old('tentative_price', $applicant->tentative_price) }}"
                                placeholder="राशि दर्ज करें / Enter Amount"></td>
                    </tr>
                    <tr>
                        <td class="sl"></td>
                        <td class="term">राशि रुपये (शब्दों में) (Amount in Words)</td>
                        <td><input name="amount_words" id="amount_words" placeholder="राशि शब्दों में / Amount in Words"
                                value="{{ old('amount_words', $applicant->amount_words) }}"></td>
                    </tr>
                    <tr>
                        <td class="sl"></td>
                        <td class="term">मूल्यांकन दिनांक (Valuation Date)</td>
                        <td class="value date-group">
                            <!-- Day Dropdown -->
                            <select name="maav_day" class="custom-select small-select">
                                <option value="">दिन / Day</option>
                                <?php for ($d = 1; $d <= 31; $d++): ?>
                                <option value="{{ $d }}" {{ $applicant->maav_day == $d ? 'selected' : '' }}>
                                    {{ str_pad($d, 2, '0', STR_PAD_LEFT) }}
                                </option>
                                <?php endfor; ?>
                            </select>
                            /
                            <!-- Month Dropdown -->
                            <select name="maav_month" class="custom-select small-select">
                                <option value="">माह / Month</option>
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>"
                                    {{ $applicant->maav_month == $m ? 'selected' : '' }}>
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
                                <option value="<?= $y ?>" {{ $applicant->maav_year == $y ? 'selected' : '' }}><?= $y ?>
                                </option>
                                <?php endfor; ?>
                            </select>

                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">उच्चतम आय वर्ग, अंतरिम कीमत का (%) (High Income % of Tentative Price)</td>
                        <td><input name="high_income_percent" id="high_income_percent" class="only-float-100"
                                value="{{ old('high_income_percent', $applicant->high_income_percent) }}"
                                placeholder="प्रतिशत / Percentage"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">अल्प/कमजोर वर्ग, अंतरिम कीमत का (%) (Low Income % of Tentative Price)</td>
                        <td><input name="low_income_percent" id="low_income_percent" placeholder="प्रतिशत / Percentage"
                                value="{{ old('low_income_percent', $applicant->low_income_percent) }}"
                                class="only-float-100">
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">जमा की गयी राशि (Deposited Amount)</td>
                        <td><input name="deposited_amount" id="deposited_amount" class="only-number"
                                placeholder="जमा राशि / Deposited Amount"
                                value="{{ old('deposited_amount', $applicant->deposited_amount) }}"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">विधि एवं अनुशासन शुल्क (-) (Legal & Discipline Fee)</td>
                        <td><input name="legal_fee" id="legal_fee" placeholder="शुल्क दर्ज करें / Enter Fee"
                                class="only-number" value="{{ old('legal_fee', $applicant->legal_fee) }}"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">विधि एवं अभिलेखन शुल्क (+) (Legal and Documentation Charges)</td>
                        <td><input name="legal_document_fee" id="legal_document_fee" class="only-number"
                                placeholder="शुल्क दर्ज करें / Enter Fee"
                                value="{{ old('legal_document_fee', $applicant->legal_document_fee) }}"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">कुल भुक्तान राशि (Total Payment Amount)</td>
                        <td><input name="total_payment" id="total_payment" placeholder="कुल राशि / Total Amount"
                                value="{{ old('total_payment', $applicant->total_payment) }}" class="only-number"></td>
                    </tr>


                    <tr>
                        <td class="sl"></td>
                        <td class="term">अंतरिम कीमत (Tentative Price)</td>
                        <td><input name="interim_price" id="interim_price" placeholder="अंतरिम कीमत / Tentative Price"
                                value="{{ old('interim_price', $applicant->interim_price) }}" class="only-number">
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">शेष राशि (Remaining Amount)</td>
                        <td><input name="remaining_amount" id="remaining_amount"
                                placeholder="शेष राशि / Remaining Amount"
                                value="{{ old('remaining_amount', $applicant->remaining_amount) }}"
                                class="only-number"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">भुगतान मास (किस्तों में) (Payment Months in Instalments)</td>
                        <td><input name="payment_months" id="payment_months"
                                placeholder="महीनों की संख्या / Number of EMI Counts"
                                value="{{ old('payment_months', $applicant->payment_months) }}" class="only-number">
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">किस्तों का भुगतान प्रहारम्भ माह (Installment Payment Starting Month)</td>
                        <td class="value date-group">
                            <!-- Month Dropdown -->
                            <select name="payment_start_month" id="payment_start_month"
                                class="custom-select small-select">
                                <option value="">-- माह / Month --</option>

                                <?php
                                $months = [
                                    1 => ['en' => 'January',   'hi' => 'जनवरी'],
                                    2 => ['en' => 'February',  'hi' => 'फरवरी'],
                                    3 => ['en' => 'March',     'hi' => 'मार्च'],
                                    4 => ['en' => 'April',     'hi' => 'अप्रैल'],
                                    5 => ['en' => 'May',       'hi' => 'मई'],
                                    6 => ['en' => 'June',      'hi' => 'जून'],
                                    7 => ['en' => 'July',      'hi' => 'जुलाई'],
                                    8 => ['en' => 'August',    'hi' => 'अगस्त'],
                                    9 => ['en' => 'September', 'hi' => 'सितंबर'],
                                    10 => ['en' => 'October',  'hi' => 'अक्टूबर'],
                                    11 => ['en' => 'November', 'hi' => 'नवंबर'],
                                    12 => ['en' => 'December', 'hi' => 'दिसंबर']
                                ];

                                foreach ($months as $num => $month):
                                ?>

                                <option value="<?= str_pad($num, 2, '0', STR_PAD_LEFT) ?>"
                                    {{ $applicant->payment_start_month == $num ? 'selected' : '' }}>
                                    <?= $month['hi'] ?> / <?= $month['en'] ?>
                                </option>

                                <?php endforeach; ?>

                            </select>
                            /
                            <!-- Year Dropdown -->
                            <select name="payment_start_year" id="payment_start_year"
                                class="custom-select small-select">
                                <option value="">-- वर्ष / Year --</option>
                                <?php 
                                    $currentYear = date('Y');
                                    for ($y = $currentYear; $y >= 1960; $y--): 
                                ?>
                                <option value="<?= $y ?>"
                                    {{ $applicant->payment_start_year == $y ? 'selected' : '' }}><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>

                    <!-- Last EMI Due Month  (August 1998)-->
                    <tr>
                        <td class="sl"></td>
                        <td class="term">अंतिम ईएमआई देय महीना (Last EMI Due Month)</td>
                        <td><input name="last_payment_due_date" id="last_payment_due_date" readonly
                                placeholder="अंतिम ईएमआई देय महीना / Last EMI Due Month"
                                value="{{ old('last_payment_due_date', $applicant->last_payment_due_date) }}"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">ब्याज का प्रकार (Type of Interest)</td>
                        <td class="value">
                            <select name="interest_type" id="interest_type" class="custom-select">
                                <option value="">-- चयन करें / Select --</option>
                                <option value="simple" {{ $applicant->interest_type == 'simple' ? 'selected' : '' }}>
                                    साधारण ब्याज / Simple Interest</option>
                                <option value="compound"
                                    {{ $applicant->interest_type == 'compound' ? 'selected' : '' }}>चक्रवृद्धि ब्याज /
                                    Compound Interest</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">पूर्व भुगतान पर वृद्धि व्याज (%) (Prepayment Interest %)</td>
                        <td><input name="pre_interest" id="pre_interest" class="only-float-100"
                                placeholder="प्रतिशत / Percentage"
                                value="{{ old('pre_interest', $applicant->pre_interest) }}"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">विलंब पर वृद्धि व्याज (%) (Late Payment Interest %)</td>
                        <td><input name="late_interest" id="late_interest" class="only-float-100"
                                placeholder="प्रतिशत / Percentage"
                                value="{{ old('late_interest', $applicant->late_interest) }}"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">व्याज राशि (₹) (Interest Amount)</td>
                        <td><input name="pre_interest_amount" id="pre_interest_amount" class="only-number"
                                placeholder="ब्याज राशि / Interest Amount"
                                value="{{ old('pre_interest_amount', $applicant->pre_interest_amount) }}"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">दंड वृद्धि व्याज (₹) (Penalty increase interest)</td>
                        <td><input name="late_interest_amount" id="late_interest_amount" class="only-number"
                                placeholder="दंड ब्याज राशि / Penalty Interest Amount"
                                value="{{ old('late_interest_amount', $applicant->late_interest_amount) }}"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">आवंटन दिनांक (Allotment Date)</td>
                        <td class="value date-group">

                            <!-- Day -->
                            <select name="allot_day" class="custom-select small-select">
                                <option value="">दिन / Day</option>
                                <?php for ($d = 1; $d <= 31; $d++): ?>
                                <option value="<?= str_pad($d, 2, '0', STR_PAD_LEFT) ?>"
                                    {{ $applicant->allot_day == $d ? 'selected' : '' }}>
                                    <?= str_pad($d, 2, '0', STR_PAD_LEFT) ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                            /
                            <!-- Month -->
                            <select name="allot_month" class="custom-select small-select">
                                <option value="">माह / Month</option>
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>"
                                    {{ $applicant->allot_month == $m ? 'selected' : '' }}>
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
                                <option value="<?= $y ?>" {{ $applicant->allot_year == $y ? 'selected' : '' }}>
                                    <?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">किस लॉटरी के तहत (शब्दों में) (Lottery Details in Words)</td>
                        <td><input name="lottery_details" placeholder="लॉटरी विवरण / Lottery Details"
                                class="only-eng-hindi-special"
                                value="{{ old('lottery_details', $applicant->lottery_details) }}"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">आवासीय कॉलोनी का नाम (Residential Colony Name)</td>
                        <td><input name="colony_name" placeholder="कॉलोनी का नाम / Colony Name"
                                value="{{ old('colony_name', $subdivision->colony_name ?? ($applicant->colony_name ?? '')) }}"
                                class="only-eng-hindi"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">बोर्ड द्वारा आवंटीत भूखंड संख्या (Board Allotted Plot No.)</td>
                        <td><input name="plot_number" placeholder="भूखंड संख्या / Plot Number" class="alpha-num-dash"
                                value="{{ old('plot_number', $applicant->plot_number) }}"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">रकबा (वर्गफीट) (Area in Sq. Ft.)</td>
                        <td><input name="area_sqft" placeholder="क्षेत्रफल / Area"
                                value="{{ old('area_sqft', $applicant->area_sqft) }}" class="only-number"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">मुहल्ला (Locality)</td>
                        <td><input name="mohalla" placeholder="मुहल्ला / Locality" class="only-eng-hindi"
                                value="{{ old('mohalla', $subdivision->locality_address ?? ($applicant->mohalla ?? '')) }}">
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">डाकघर (Post Office)</td>
                        <td><input name="post_office" placeholder="डाकघर / Post Office"
                                value="{{ old('post_office', $applicant->post_office) }}" class="only-eng-hindi">
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">शहर (City)</td>
                        <td><input name="city" placeholder="शहर / City"
                                value="{{ old('city', $applicant->city) }}" class="only-eng-hindi"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">थाना (Police Station)</td>
                        <td><input name="police_station"  value="{{ old('police_station', $applicant->police_station) }}" placeholder="थाना / Police Station" class="only-eng-hindi">
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">राज्य (State)</td>
                        <td class="value">
                            <select name="state" class="custom-select state-select-hindi"
                                data-target="district-hi">
                                <option value="">-- राज्य चुनें --</option>
                                @foreach ($states as $item)
                                    <option value="{{ $item->id }}" {{ isset($applicant) && $applicant->state == $item->id ? 'selected' : '' }}>{{ $item->name_hi }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @php
                        $districts = getDistrict($applicant->state);
                    @endphp
                    <tr>
                        <td class="sl"></td>
                        <td class="term">जिला (District)</td>
                        <td class="value">
                            <select name="district" class="custom-select fetch-district-hindi" id="district-hi">
                                <option value="">-- जिला चुनें --</option>
                                @if (!empty($districts))
                                    @foreach ($districts as $dist)
                                        <option value="{{ $dist->id }}"
                                            {{ isset($applicant) && $applicant->district == $dist->id ? 'selected' : '' }}>
                                            {{ $dist->name_hi }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">चौहद्दी - उत्तर सीमा (Boundary - North)</td>
                        <td><input name="north_boundary" placeholder="उत्तर सीमा / North Boundary"
                                class="only-number" value="{{ old('north_boundary', $applicant->north_boundary) }}"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">चौहद्दी - दक्षिण सीमा (Boundary - South)</td>
                        <td><input name="south_boundary" placeholder="दक्षिण सीमा / South Boundary" value="{{ old('south_boundary', $applicant->south_boundary) }}"
                                class="only-number"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">चौहद्दी - पूरब सीमा (Boundary - East)</td>
                        <td><input name="east_boundary" placeholder="पूरब सीमा / East Boundary" value="{{ old('east_boundary', $applicant->east_boundary) }}" class="only-number">
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">चौहद्दी - पश्चिम सीमा (Boundary - West)</td>
                        <td><input name="west_boundary" placeholder="पश्चिम सीमा / West Boundary" value="{{ old('west_boundary', $applicant->west_boundary) }}"
                                class="only-number"></td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">पूरब से पश्चिम उत्तर तरफ (फीट) (East-West North Side in Ft.)</td>
                        <td><input name="ew_north" placeholder="फीट में लंबाई / Length in Ft." value="{{ old('ew_north', $applicant->ew_north) }}" class="only-number">
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">पूरब से पश्चिम दक्षिण तरफ (फीट) (East-West South Side in Ft.)</td>
                        <td><input name="ew_south" placeholder="फीट में लंबाई / Length in Ft." value="{{ old('ew_south', $applicant->ew_south) }}" class="only-number">
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">उत्तर से दक्षिण पूरब तरफ (फीट) (North-South East Side in Ft.)</td>
                        <td><input name="ns_east" placeholder="फीट में लंबाई / Length in Ft." value="{{ old('ns_east', $applicant->ns_east) }}" class="only-number">
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">उत्तर से दक्षिण पश्चिम तरफ (फीट) (North-South West Side in Ft.)</td>
                        <td><input name="ns_west" placeholder="फीट में लंबाई / Length in Ft." value="{{ old('ns_west', $applicant->ns_west) }}" class="only-number">
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">निर्धारित अवधि (दिनों में) (Specified Period in Days)</td>
                        <td class="value">
                            <select name="specified_days" class="custom-select">
                                <option value="">-- Select Days --</option>
                                <option value="10 days" {{ $applicant->specified_days == '10 days' ? 'selected' : '' }}> 10 days</option>
                                <option value="15 days" {{ $applicant->specified_days == '15 days' ? 'selected' : '' }}> 15 days</option>
                                <option value="30 days" {{ $applicant->specified_days == '30 days' ? 'selected' : '' }}> 30 days</option>
                                <option value="45 days" {{ $applicant->specified_days == '45 days' ? 'selected' : '' }}> 45 days</option>
                                <option value="60 days" {{ $applicant->specified_days == '60 days' ? 'selected' : '' }}> 60 days</option>
                                <option value="75 days" {{ $applicant->specified_days == '75 days' ? 'selected' : '' }}> 75 days</option>
                                <option value="90 days" {{ $applicant->specified_days == '90 days' ? 'selected' : '' }}> 90 days</option>
                                <option value="105 days" {{ $applicant->specified_days == '105 days' ? 'selected' : '' }}> 105 days</option>
                                <option value="120 days" {{ $applicant->specified_days == '120 days' ? 'selected' : '' }}> 120 days</option>
                                <option value="150 days" {{ $applicant->specified_days == '150 days' ? 'selected' : '' }}> 150 days</option>
                                <option value="180 days" {{ $applicant->specified_days == '180 days' ? 'selected' : '' }}> 180 days</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="sl"></td>
                        <td class="term">अंतिम जमा करने की तिथि (Last date of the Payment as for the Agreement)</td>
                        <td class="value date-group">

                            <!-- Day -->
                            <select name="last_day" class="custom-select small-select">
                                <option value="">दिन / Day</option>
                                <?php for ($d = 1; $d <= 31; $d++): ?>
                                <option value="<?= str_pad($d, 2, '0', STR_PAD_LEFT) ?>" {{ $applicant->last_day == $d ? 'selected' : '' }}>
                                    <?= str_pad($d, 2, '0', STR_PAD_LEFT) ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                            /
                            <!-- Month -->
                            <select name="last_month" class="custom-select small-select">
                                <option value="">माह / Month</option>
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>" {{ $applicant->last_month == $m ? 'selected' : '' }}>
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
                                <option value="<?= $y ?>" {{ $applicant->last_year == $y ? 'selected' : '' }}><?= $y ?></option>
                                <?php endfor; ?>
                            </select>

                        </td>
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
