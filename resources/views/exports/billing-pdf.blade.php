    <!DOCTYPE html>
    <html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Files Billing - COMPUTER Ed.</title>
        <style>
            @font-face {
                font-family: 'bookman';
                src: url('{{ public_path('assets/fontspdf/bookman.ttf') }}') format('truetype');
                font-weight: normal;
                font-style: normal;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'DejaVu Sans', Arial, sans-serif;
                font-size: 9px;
                color: #000;
                line-height: 1.4;
                padding: 15px;
            }

            .page-wrapper {
                position: relative;
                min-height: 100vh;
            }

            /* Watermark */
            .watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 30px;
                color: rgba(0, 0, 0, 0.05);
                font-weight: bold;
                z-index: -1;
                white-space: nowrap;
                pointer-events: none;
            }

            /* Header Section */
            .header {
                margin-bottom: 10px;
            }

            /* Table Layout */
            .header-content {
                width: 100%;
                display: table;
                table-layout: fixed;
            }

            /* Three Columns */
            .logo-left,
            .org-info,
            .logo-right {
                display: table-cell;
                vertical-align: middle;
                /* Align all center vertically */
            }

            /* Column Widths */
            .logo-left {
                width: 25%;
                text-align: left;
            }

            .org-info {
                width: 50%;
                text-align: center;
                padding: 0 10px;
            }

            .logo-right {
                width: 25%;
                text-align: right;
            }

            /* 🔹 Make ALL logos same size */
            .logo-left img,
            .logo-right img {
                height: 35px;
                /* Fixed same height */
                width: auto;
            }

            .logo-left img:last-child {
                height: 45px;
                max-width: 85%;
            }

            /* If two logos on left */
            .logo-left img {
                display: inline-block;
                margin-right: 5px;
            }

            /* Organization Name */
            .org-name {
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 4px;
                letter-spacing: 0.5px;
                font-family: 'bookman', serif;
            }

            /* Address */
            .org-address {
                font-size: 10px;
                line-height: 1.3;
                margin-bottom: 3px;
            }

            /* Project Line */
            .org-project {
                font-size: 10px;
                font-style: italic;
                font-weight: bold;
            }

            /* Title Section */
            .document-title {
                text-align: center;
                font-size: 10px;
                font-weight: bold;
                text-transform: uppercase;
                color: #000000;
                letter-spacing: 1px;
            }

            .document-title span {
                display: inline-block;
                padding: 2px 6px;
                border: 1px solid #000;
                background: none;
            }

            .project-name {
                font-size: 10px;
                margin-top: 5px;
                color: #222222;
                font-weight: bold;
            }

            /* Copy Info Box */
            .copy-info {
                padding: 6px;
                margin-bottom: 10px;
                background: #fafafa;
            }

            .copy-type {
                text-align: center;
                font-weight: bold;
                font-size: 12px;
                margin-bottom: 4px;
                text-transform: uppercase;
                text-decoration: underline;
            }

            .receiving-info {
                display: table;
                width: 100%;
            }

            .receiving-date,
            .receiving-time {
                display: table-cell;
                width: 50%;
                font-size: 10px;
            }

            .receiving-time {
                text-align: right;
            }

            .info-label {
                font-weight: bold;
                color: #000;
            }

            /* ========== COMPACT PDF TABLE DESIGN ========== */

            .data-table {
                width: 100%;
                border-collapse: collapse;
                margin: 2px 0 0 0;
                font-size: 12px;
                table-layout: fixed;
                line-height: 1.1;
            }

            .data-table th {
                color: #000;
                text-align: center;
                font-weight: 700;
                border: 1px solid #666;
                font-size: 10px;
                padding: 2px 2px;
                background: #f2f2f2;
                line-height: 1.1;
            }

            .data-table td {
                border: 1px solid #777;
                padding: 1px 3px;
                vertical-align: middle;
                word-wrap: break-word;
                word-break: break-word;
                line-height: 1.1;
            }

            /* Prevent Row Break In PDF */
            .data-table tr {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Compact Column Alignment */
            .data-table td.center,
            .data-table th.center {
                text-align: center;
            }

            .data-table td.right,
            .data-table th.right {
                text-align: right;
            }

            /* Reduce Empty Space */
            .data-table tbody tr td {
                height: 16px;
            }

            /* Zebra Strip Optional */
            .data-table tbody tr:nth-child(even) {
                background: #fafafa;
            }

            .text-center {
                text-align: center;
            }

            .no-records {
                font-style: italic;
                color: #666;
                padding: 20px !important;
            }

            .footer {
                position: fixed;
                bottom: 20px;
                left: 20px;
                right: 20px;
                font-size: 12px;
                border-top: 1.5px solid #000;
            }

            .signature-table {
                width: 100%;
                border-collapse: collapse;
            }

            .signature-table td {
                width: 50%;
                vertical-align: top;
                padding: 0 10px;
            }

            .line-row {
                margin-bottom: 6px;
                white-space: nowrap;
            }

            .line {
                display: inline-block;
                border-bottom: 1px dotted #000;
                height: 10px;
                vertical-align: middle;
            }

            .line.long {
                width: 180px;
            }

            .line.medium {
                width: 150px;
            }

            .sub-text {
                font-size: 10px;
                margin-top: 2px;
            }

            .organization-name {
                text-align: center;
                margin-top: 10px;
                padding-top: 8px;
                border-top: 1px solid #ccc;
            }

            .org-label {
                font-weight: bold;
                margin-bottom: 2px;
            }

            .page-info {
                text-align: center;
                margin-top: 8px;
                font-size: 7px;
                color: #666;
            }

            /* Page break for multiple copies */
            .page-break {
                page-break-before: always;
            }
        </style>
    </head>

    <body>
        @php
            $chunkSize = 15;
            // if $allottees is a collection or array, ensure we can chunk properly
            $allotteesArray = is_array($allottees) ? $allottees : $allottees ?? [];
            $totalAllottees = count($allotteesArray);
            $chunks = [];
            for ($i = 0; $i < $totalAllottees; $i += $chunkSize) {
                $chunks[] = array_slice($allotteesArray, $i, $chunkSize);
            }
            // if no allottees, still one empty chunk to render structure
            if (empty($chunks)) {
                $chunks = [[]];
            }
        @endphp
        @foreach ($copies as $copyIndex => $copyType)
            @foreach ($chunks as $pageIndex => $chunk)
                <div class="page-wrapper {{ $copyIndex > 0 || $pageIndex > 0 ? 'page-break' : '' }}">
                    <!-- Watermark -->
                    <div class="watermark">{{ $copyType }}</div>
                    <!-- Header -->
                    <div class="header">
                        <div class="header-content">
                            <div class="logo-left">
                                <img src="{{ $logo1 }}" alt="INDIAN BANK">
                                <img src="{{ $logo3 }}" alt="JSHB Logo">
                            </div>
                            <div class="org-info">
                                <div class="org-name">COMPUTER Ed.</div>
                                <div class="org-address">
                                    L.I.G R/276, Harmu Housing Colony,<br>
                                    Ranchi, Jharkhand, Pin: 834002
                                </div>
                                <div class="org-project">
                                    (A Project of Indian Bank, Harmu Colony Branch, Ranchi)
                                </div>
                            </div>
                            <div class="logo-right">
                                <img src="{{ $logo2 }}" alt="COMPUTER Ed.">
                            </div>
                        </div>
                    </div>
                    <!-- Title -->
                    <div class="document-title">
                        <span>Scanned Files Statement</span>
                    </div>
                    <!-- Project -->
                    <div class="project-name">
                        Project Name - Allottee Data Management System (ADMS)
                        <strong style="float:right;">
                            Project Office : JSHB HQ
                        </strong>
                    </div>
                    <!-- Copy Info -->
                    <div class="copy-info">
                        <div class="copy-type">{{ $copyType }}</div>
                        <div class="receiving-info">
                            <div class="receiving-date">
                                <span class="info-label">
                                    Total Nos. of Physical Files Scanned:
                                </span>
                                {{ $totalFiles }}
                            </div>
                            <div class="receiving-time">
                                <span class="info-label">Generated on:</span>
                                {{ $date }}
                                <br>
                                <span class="info-label">Time:</span>
                                {{ $BillTime }}
                            </div>
                        </div>
                    </div>
                    <!-- TABLE -->
                    <table class="data-table">

                        <thead>
                            <tr>
                                <th style="width:6%;">Sl.No.</th>
                                <th style="width:12%;">Lot</th>
                                <th style="width:15%;">Register</th>
                                <th style="width:20%;">Div. / Sub Div.</th>
                                <th style="width:15%;">Type</th>
                                <th style="width:12%;">Prop. No.</th>
                                <th style="width:15%;">Allottee</th>
                                <th style="width:8%;">Master Pdf</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($chunk as $index => $allottee)
                                <tr>

                                    <!-- Serial -->
                                    <td class="text-center">
                                        {{ $pageIndex * $chunkSize + $index + 1 }}
                                    </td>

                                    <!-- Lot -->
                                    <td class="text-center">
                                        {{ $allottee['lotname'] ?? ($allottee->lotname ?? '-') }}
                                    </td>

                                    <!-- Register -->
                                    <td class="text-center">
                                        {{ $allottee['registerNo'] ?? ($allottee->registerNo ?? '-') }}
                                    </td>

                                    <!-- Division / Sub Division -->
                                    <td class="text-center">
                                        {{ $allottee['division'] ?? ($allottee->division ?? '-') }}
                                        /
                                        {{ $allottee['subdivision'] ?? ($allottee->subdivision ?? '-') }}
                                    </td>

                                    <!-- Type -->
                                    <td class="text-center">
                                        {{ $allottee['type'] ?? ($allottee->type ?? '') }} -
                                        {{ $allottee['quarter_code'] ?? ($allottee->quarter_code ?? '') }}
                                    </td>

                                    <!-- Property Number -->
                                    <td class="text-center">
                                        {{ $allottee['property_number'] ?? ($allottee->property_number ?? '-') }}
                                    </td>

                                    <!-- Allottee -->
                                    <td>
                                        {{ $allottee['full_name'] ?? ($allottee->full_name ?? '-') }}
                                    </td>

                                    <!-- Master PDF -->
                                    <td class="text-center">
                                        File 1
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center no-records">
                                        No records found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                    <!-- FOOTER -->
                    <div class="footer"> <br>
                        <table class="signature-table">
                            <tr>
                                <td class="left">
                                    <div class="line-row">
                                        Signature :
                                        <span class="line long"></span>
                                    </div>
                                    <div class="line-row">
                                        Name of the Receiver :
                                        <span class="line medium"></span>
                                    </div>
                                    <div class="sub-text">
                                        Sign & Seal (COMPUTER Ed.)
                                    </div>
                                </td>
                                <td class="right">
                                    <div class="line-row">
                                        Signature :
                                        <span class="line long"></span>
                                    </div>
                                    <div class="line-row">
                                        Name of the Received from :
                                        <span class="line medium"></span>
                                    </div>
                                    <div class="sub-text">
                                        Sign & Seal (Jharkhand State Housing Board)
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="page-info">
                            BILL No. {{ $billNumber }}
                            |
                            Generated on {{ date('d/m/Y H:i:s') }}
                            |
                            Page {{ $pageIndex + 1 }}
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </body>

    </html>
