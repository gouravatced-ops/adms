<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Files Receiving - COMPUTER Ed.</title>
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

        
        /* ========== DATA TABLE - COMPACT PADDING & MARGIN ========== */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0 0 0;
            /* removed left margin completely */
            font-size: 8.8px;
            /* slight reduction for cleaner fit */
            table-layout: fixed;
        }

        .data-table th {
            color: #000000;
            text-align: center;
            font-weight: bold;
            border: 1px solid #888;
            font-size: 10px;
            padding: 3px 2px;
            background-color: #f7f7f7;
        }

        .data-table td {
            border: 1px solid #888;
            padding: 2px 3px;
            /* minimal padding - shrink */
            vertical-align: middle;
            word-break: break-word;
        }

        /* Force avoid page break inside any table row - critical fix */
        .data-table tr {
            page-break-inside: avoid;
            break-inside: avoid;
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
        // ============================================================
        // OPTIMIZED PAGINATION LOGIC: SPLIT ALLOTTEES INTO CHUNKS OF 15
        // Ensures NO page break inside any table row (blade 15 records per page)
        // ============================================================
        $chunkSize = 15;
        // if $allottees is a collection or array, ensure we can chunk properly
        $allotteesArray = is_array($allottees) ? $allottees : ($allottees ?? []);
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
        <div class="page-wrapper {{ $copyIndex > 0 ? 'page-break' : '' }}">

            <!-- Watermark -->
            <div class="watermark">{{ $copyType }}</div>

            <!-- Header Section -->
            <div class="header">
                <div class="header-content">
                    <!-- Left Logos -->
                    <div class="logo-left">
                        <img src="{{ $logo1 }}" alt="INDIAN BANK">
                        <img src="{{ $logo3 }}" alt="JSHB Logo">
                    </div>

                    <!-- Organization Info -->
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

                    <!-- Right Logo -->
                    <div class="logo-right">
                        <img src="{{ $logo2 }}" alt="COMPUTER Ed.">
                    </div>
                </div>
            </div>

            <!-- Document Title -->
            <div class="document-title">
                <span>Files Receiving Sheet</span>
            </div>

            <!-- Project Name -->
            <div class="project-name">
                Project Name - Allottee Data Management System (ADMS)
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Division
                    :</strong> {{ $lotDivision }}
            </div>

            <!-- Copy Information Box -->
            <div class="copy-info">
                <div class="copy-type">{{ $copyType }}</div>
                <div class="receiving-info">
                    <div class="receiving-date">
                        <span class="info-label"><strong>{{ $lotNumber }}</strong></span><br>
                        <span class="info-label">Total Nos. of Physical Files Received:</span> {{ count($allottees) }}
                    </div>
                    <div class="receiving-time">
                        <span class="info-label">Date of Receiving:</span> {{ $lotcreateDate }}<br>
                        <span class="info-label">Time of Receiving:</span> {{ $lotTime }}<br>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 4%;">Sl No.</th>
                        <th style="width: 15%;">Division</th>
                        <th style="width: 15%;">Sub-division</th>
                        <th style="width: 11%;">Property Category</th>
                        <th style="width: 8%;">Type of <br> Property</th>
                        <th style="width: 8%;">Income Category</th>
                        <th style="width: 9%;">Property No.</th>
                        <th style="width: 18%;">Allottee Name</th>
                        <th style="width: 10%;">Physical File</th>
                    </tr>
                </thead>
               <tbody>
                    @forelse($allottees as $index => $allottee)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $allottee['division'] ?? $allottee->division ?? 'N/A' }}</td>
                            <td>{{ $allottee['subdivision'] ?? $allottee->subdivision ?? 'N/A' }}</td>
                            <td>{{ $allottee['category'] ?? $allottee->category ?? 'N/A' }}</td>
                            <td>{{ $allottee['type'] ?? $allottee->type ?? 'N/A' }}</td>
                            <td class="text-center">{{ $allottee['quarter_code'] ?? $allottee->quarter_code ?? 'N/A' }}</td>
                            <td class="text-center">{{ $allottee['property_number'] ?? $allottee->property_number ?? 'N/A' }}</td>
                            <td>
                                {{ $allottee['full_name'] ?? ($allottee->full_name ?? '') }}
                            </td>
                            <td>{{ $allottee['file_label'] ?? $allottee->file_label ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center no-records">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Footer Signatures -->
            <div class="footer">
                <br><br><br><br>
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
                                (Authorized Signature-COMPUTER Ed.)
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
                                (Nodal Officer-Jharkhand State Housing Board)
                            </div>
                        </td>
                    </tr>
                </table>
                <!-- Page Info -->
                <div class="page-info">
                    REG ID. {{ $registerNo }} | Generated on {{ date('d/m/Y H:i:s') }}
                </div>
            </div>
        </div>
    @endforeach
</body>

</html>
