{{-- resources/views/applicant/stepper-form/index.blade.php --}}
@extends('applicant.dashboard_layouts.main')

@section('title', 'Application Form')
@section('content')

    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet"> --}}

    <style>
        :root {
            --ink: #000000;
            --deep: #111827;
            --surface: #f5f4f0;
            --card: #ffffff;
            --muted: #777a7f;
            --border: #e4e2dc;
            --gold: #686868;
            --gold-lt: #f5ecd5;
            --gold-dk: #a07c30;
            --success: #15803d;
            --success-lt: #d6f0e3;
            --danger: #b53b3b;
            --danger-lt: #fde8e8;
            --radius: 14px;
            --radius-sm: 8px;
            --shadow: 0 4px 24px rgba(13, 15, 20, 0.08);
            --shadow-lg: 0 12px 40px rgba(13, 15, 20, 0.14);
        }


        /* ── OUTER CARD ─────────────────────────────────────────── */
        .app-shell {
            background: var(--card);
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        /* ── HEADER ─────────────────────────────────────────────── */
        .app-header1 {
            background: var(--success);
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .app-header1::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 600px 300px at 80% 50%, rgba(201, 168, 76, 0.18) 0%, transparent 70%);
            pointer-events: none;
        }

        .app-header1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, var(--gold) 35%, var(--gold-lt) 50%, var(--gold) 65%, transparent 100%);
        }

        .header-brand {
            z-index: 1;
        }

        .header-eyebrow {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 6px;
        }

        .header-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }

        .header-sub {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 6px;
        }

        .app-number-badge {
            z-index: 1;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(201, 168, 76, 0.3);
            border-radius: 10px;
            padding: 5px 10px;
            text-align: right;
        }

        .app-number-label {
            font-size: 10px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--light);
        }

        .app-number-value {
            font-size: 18px;
            font-weight: 600;
            color: #f3d303;
            margin-top: 2px;
        }

        /* ── STEPPER ─────────────────────────────────────────────── */
        .stepper-wrapper {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 15px 10px;
        }

        .stepper {
            display: flex;
            gap: 0;
            position: relative;
        }

        .stepper::before {
            content: '';
            position: absolute;
            top: 12px;
            left: 12px;
            right: 12px;
            height: 2px;
            background: var(--border);
            z-index: 0;
        }

        .stepper-track {
            position: absolute;
            top: 12px;
            left: 12px;
            right: 12px;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), var(--gold-dk));
            z-index: 1;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .step-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 2;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .step-item:hover:not(.active) {
            opacity: 0.8;
        }

        .step-bubble {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--card);
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            color: var(--muted);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .step-bubble svg {
            width: 18px;
            height: 18px;
            display: none;
        }

        .step-meta {
            text-align: center;
        }

        .step-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 0.02em;
            transition: color 0.2s;
        }

        .step-hint {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
            transition: color 0.2s;
        }

        /* Active */
        .step-item.active .step-bubble {
            background: var(--ink);
            border-color: var(--ink);
            color: #fff;
            box-shadow: 0 0 0 6px rgba(201, 168, 76, 0.18), 0 4px 16px rgba(13, 15, 20, 0.25);
            transform: scale(1.08);
        }

        .step-item.active .step-label {
            color: var(--deep);
        }

        .step-item.active .step-hint {
            color: var(--gold);
        }

        /* Completed */
        .step-item.completed .step-bubble {
            background: var(--success);
            border-color: var(--gold);
            color: #fff;
        }

        .step-item.completed .step-bubble span {
            display: none;
        }

        .step-item.completed .step-bubble svg {
            display: block;
        }

        .step-item.completed .step-label {
            color: var(--gold-dk);
        }

        /* ── BODY ────────────────────────────────────────────────── */
        .app-body {
            padding: 15px 18px 10px;
        }

        /* Alert */
        #alertContainer {
            margin-bottom: 10px;
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 20px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            border-left: 4px solid;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: var(--success-lt);
            border-color: var(--success);
            color: var(--success);
        }

        .alert-error {
            background: var(--danger-lt);
            border-color: var(--danger);
            color: var(--danger);
        }

        .alert-icon {
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Step content area */
        .step-content-area {
            min-height: 420px;
            animation: fadeUp 0.35s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-section {
            background: #fff;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--gold), var(--gold-dk));
            border-radius: 4px 0 0 4px;
        }

        .gradient-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            color: #fff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            margin-bottom: 10px;
            transition: 0.3s ease;
        }

        .gradient-header .section-icon {
            width: 34px;
            height: 34px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gradient-header .section-title {
            font-size: 15px;
            font-weight: 600;
            margin: 0;
            color: #fff;
        }

        .gradient-header .section-desc {
            font-size: 11px;
            margin: 2px 0 0;
            color: rgba(255, 255, 255, 0.85);
        }

        .form-grid {
            display: grid;
            gap: 12px;
            margin-bottom: 10px;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .col-span-2 {
            grid-column: span 2;
        }

        @media (max-width: 960px) {
            .form-grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 680px) {

            .form-grid,
            .form-grid-3 {
                grid-template-columns: 1fr;
            }

            .col-span-2 {
                grid-column: span 1;
            }

            .stepper-wrapper {
                padding: 20px;
            }

            .app-body {
                padding: 24px;
            }
        }

        /* ── FIELD ───────────────────────────────────────────────── */
        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field-label {
            font-size: 12.5px;
            font-weight: 600;
            color: #4a5062;
            letter-spacing: 0.03em;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .req-star {
            color: var(--danger);
            font-size: 13px;
        }

        .custom-input {
            width: 100%;
            padding: 11px 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            outline: none;
            transition: all 0.2s ease;
            appearance: none;
        }

        .custom-input::placeholder {
            color: #c0c4d0;
        }

        .custom-input:hover:not([readonly]):not(:focus) {
            border-color: #c9a84c66;
            background: #fff;
        }

        .custom-input:focus {
            border-color: var(--gold);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.15);
        }

        .custom-input.is-invalid {
            border-color: var(--danger);
            background: var(--danger-lt);
        }

        .custom-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(181, 59, 59, 0.12);
        }

        .custom-input[readonly] {
            background: #f0ede6;
            color: var(--muted);
            cursor: not-allowed;
        }

        textarea.custom-input {
            resize: vertical;
            min-height: 90px;
        }

        /* Select arrow */
        select.custom-input {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' viewBox='0 0 24 24'%3E%3Cpath stroke='%239399a6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 38px;
            cursor: pointer;
        }

        /* Dropdown options */
        select.custom-input option:nth-child(even) {
            background-color: #1a7a3f39;
            color: #111111;
        }

        select.custom-input option:hover {
            background-color: #ffeb3b;
        }

        .field-hint {
            font-size: 11px;
            color: var(--muted);
        }

        .field-error {
            font-size: 11px;
            color: var(--danger);
            display: none;
        }

        .custom-input.is-invalid~.field-error {
            display: block;
        }

        /* ── NAVIGATION ──────────────────────────────────────────── */
        .nav-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }

        .nav-info {
            font-size: 12.5px;
            color: #484848;
        }

        .nav-info strong {
            color: var(--ink);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            text-decoration: none;
        }

        .btn svg {
            width: 18px;
            height: 18px;
        }

        .btn-ghost {
            background: transparent;
            border: 1.5px solid var(--border);
            color: #6a6f7e;
        }

        .btn-ghost:hover {
            background: var(--surface);
            border-color: #c0c4d0;
            color: var(--ink);
        }

        .btn-primary {
            background: var(--success);
            color: #fff;
            box-shadow: 0 4px 14px rgba(13, 15, 20, 0.2);
        }

        .btn-primary:hover {
            background: #1c2130;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 15, 20, 0.28);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.55;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Loading spinner */
        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── FAMILY MEMBER CARD ──────────────────────────────────── */
        .member-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 20px;
            margin-bottom: 14px;
            position: relative;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .member-card:hover {
            border-color: var(--gold);
            box-shadow: 0 4px 16px rgba(201, 168, 76, 0.1);
        }

        .btn-remove {
            position: absolute;
            top: 14px;
            right: 14px;
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
        }

        .btn-remove:hover {
            background: var(--danger);
            color: #fff;
        }

        /* ── ADD BUTTON ──────────────────────────────────────────── */
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: var(--gold-lt);
            border: 1.5px dashed var(--gold);
            border-radius: var(--radius-sm);
            color: var(--gold-dk);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }

        .btn-add:hover {
            background: var(--gold);
            color: #fff;
            border-style: solid;
        }

        /* ── REVIEW CARD ─────────────────────────────────────────── */
        .review-section {
            overflow: hidden;
            margin-bottom: 20px;
        }

        .review-section-head {
            background: var(--surface);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
        }

        .review-section-title {
            font-family: 'Fraunces', serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--ink);
        }

        .btn-edit-step {
            font-size: 12px;
            font-weight: 600;
            color: var(--gold-dk);
            background: var(--gold-lt);
            border: none;
            border-radius: 6px;
            padding: 5px 12px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-edit-step:hover {
            background: var(--gold);
            color: #fff;
        }

        .review-grid {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
        }

        .review-pair {}

        .review-pair-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 4px;
        }

        .review-pair-value {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink);
        }

        /* Loading state */
        .load-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            padding: 60px 0;
            color: var(--muted);
            font-size: 14px;
        }

        .load-ring {
            width: 40px;
            height: 40px;
            border: 3px solid var(--border);
            border-top-color: var(--gold);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        /* ── PAYMENT CARD ────────────────────────────────────────── */
        .payment-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 20px;
            margin-bottom: 14px;
        }

        .payment-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            padding-bottom: 14px;
            border-bottom: 1px dashed var(--border);
        }

        .chip {
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .chip-blue {
            background: #e0ecff;
            color: #1a56d6;
        }

        .chip-green {
            background: var(--success-lt);
            color: var(--success);
        }

        .chip-gold {
            background: var(--gold-lt);
            color: var(--gold-dk);
        }

        /* ── Review Cards ── */
        .review-card {
            background: #fff;
            overflow: hidden;
            margin-bottom: 20px;
            transition: box-shadow .2s;
        }

        .review-card:hover {
            box-shadow: 0 4px 20px rgba(13, 15, 20, .07);
        }

        .review-card-head {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 22px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }

        .review-card-icon {
            width: 36px;
            height: 36px;
            background: var(--gold-lt);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-dk);
            flex-shrink: 0;
        }

        .review-card-title {
            font-family: 'Fraunces', serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--ink);
            flex: 1;
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: var(--gold-lt);
            border: 1px solid rgba(201, 168, 76, .4);
            border-radius: 8px;
            color: var(--gold-dk);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-edit:hover {
            background: var(--gold);
            color: #fff;
            border-color: var(--gold);
        }

        /* ── Review Grid ── */
        .review-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }

        .review-pair {
            padding: 14px 22px;
            border-right: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            transition: background .15s;
        }

        .review-pair:hover {
            background: #faf9f6;
        }

        .review-pair.wide {
            grid-column: span 2;
        }

        .rp-label {
            display: block;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 5px;
        }

        .rp-value {
            display: block;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--ink);
            line-height: 1.4;
        }

        .rp-value.mono {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            letter-spacing: .04em;
        }

        .rp-value.sm {
            font-size: 11.5px;
        }

        /* Sub-sections */
        .review-subsection {
            border-top: 2px dashed var(--border);
        }

        .review-subsection-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--gold-dk);
            padding: 12px 22px 6px;
            background: rgba(201, 168, 76, .06);
            border-bottom: 1px solid var(--border);
        }

        /* Payment rows */
        .payments-review-grid {
            padding: 0;
        }

        .payment-review-row {
            display: flex;
            align-items: stretch;
            border-bottom: 1px solid var(--border);
            transition: background .15s;
        }

        .payment-review-row:last-child {
            border-bottom: none;
        }

        .payment-review-row:hover {
            background: #faf9f6;
        }

        .prr-type {
            padding: 16px 22px;
            min-width: 140px;
            border-right: 1px solid var(--border);
            display: flex;
            align-items: center;
        }

        .prr-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .1em;
            color: var(--ink);
            font-family: 'Fraunces', serif;
        }

        .prr-detail {
            padding: 14px 20px;
            flex: 1;
            border-right: 1px solid var(--border);
        }

        .prr-amount {
            padding: 14px 20px;
            border-right: 1px solid var(--border);
            min-width: 130px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .prr-amt-value {
            font-family: 'Fraunces', serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--ink);
            margin-top: 4px;
        }

        .prr-status {
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--success);
        }

        /* ── Property Summary Pills ── */
        .property-summary {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-bottom: 14px;
            border-bottom: 1px dashed var(--border);
            border-collapse: separate;
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
    </style>

    <div class="app-shell">
        {{-- Header --}}
        <div class="modern-card-header">
            <div class="header-flex">
                <div>
                    <h1 class="header-title">Application Form</h1>
                    <p class="header-subtitle">Complete your application form in 4 easy steps</p>
                </div>
                @if (isset($applicant))
                    <div class="app-number-badge">
                        <div class="app-number-label">Application No.</div>
                        <div class="app-number-value">{{ $applicant->application_number }}</div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Stepper --}}
        <div class="stepper-wrapper">
            <div class="stepper" id="stepper">
                <div class="stepper-track" id="stepperTrack"></div>

                <div class="step-item active" data-step="1" onclick="goToStep(1)">
                    <div class="step-bubble">
                        <span>1</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div class="step-meta">
                        <div class="step-label">Allottee Details</div>
                    </div>
                </div>

                <div class="step-item" data-step="2" onclick="goToStep(2)">
                    <div class="step-bubble">
                        <span>2</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div class="step-meta">
                        <div class="step-label">Address Details</div>
                        {{-- <div class="step-label">Nominee &amp; banking details</div> --}}
                    </div>
                </div>

                <div class="step-item" data-step="3" onclick="goToStep(3)">
                    <div class="step-bubble">
                        <span>3</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div class="step-meta">
                        <div class="step-label">Nominee &amp; banking details</div>
                        {{-- <div class="step-label">Property &amp; payment info</div> --}}
                    </div>
                </div>

                <div class="step-item" data-step="4" onclick="goToStep(4)">
                    <div class="step-bubble">
                        <span>4</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div class="step-meta">
                        <div class="step-label">Property &amp; payment info</div>
                        {{-- <div class="step-label">Review &amp; Submit</div> --}}
                    </div>
                </div>

                <div class="step-item" data-step="5" onclick="goToStep(5)">
                    <div class="step-bubble">
                        <span>5</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div class="step-meta">
                        <div class="step-label">Review &amp; Submit</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="app-body">
            {{-- Step Content --}}
            <div id="stepContent" class="step-content-area">
                @include('applicant.components.stepper-form.step1')
            </div>

            {{-- Navigation --}}
            <div class="nav-bar">
                <div class="nav-info">
                    Step <strong id="stepNum">1</strong> of <strong>5</strong>
                </div>
                <div style="display:flex; gap:12px; align-items:center;">
                    <button type="button" class="btn btn-ghost" id="prevBtn" onclick="prevStep()" style="display:none;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7" />
                        </svg>
                        Previous
                    </button>
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextStep()">
                        <div class="spinner" id="btnSpinner"></div>
                        <span id="btnLabel">Save &amp; Continue</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.copyAddress = function() {

            const checkbox = document.getElementById("same_as_present");

            const fieldMap = [
                ["present_address", "permanent_address"],
                ["post_office", "permanent_post_office"],
                ["police_station", "permanent_police_station"],
                ["state", "permanent_state"],
                ["district", "permanent_district"],
                ["pin_code", "permanent_pin_code"],
                ["telephone", "permanent_telephone"],
                ["mobile_number", "permanent_mobile_number"]
            ];

            if (checkbox.checked) {

                // Copy Values
                fieldMap.forEach(([from, to]) => {
                    const fromEl = document.getElementById(from);
                    const toEl = document.getElementById(to);

                    if (fromEl && toEl) {
                        toEl.value = fromEl.value;
                    }
                });

            } else {

                // Clear Values
                fieldMap.forEach(([_, to]) => {
                    const toEl = document.getElementById(to);
                    if (toEl) toEl.value = "";
                });

            }
        };
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const dateInput = document.getElementById("allotment_date");
            const panField = document.getElementById("pan-field");
            const aadharField = document.getElementById("aadhar-field");

            const panInput = document.getElementById("pan_card_number");
            const aadharInput = document.getElementById("aadhar_card_number");

            const panStar = document.getElementById("pan-star");
            const aadharStar = document.getElementById("aadhar-star");

            const toggleFields = () => {
                const year = dateInput.value ? new Date(dateInput.value).getFullYear() : null;
                const show = year && year >= 2009;

                // Toggle display
                panField.style.display = show ? "block" : "none";
                aadharField.style.display = show ? "block" : "none";

                // Toggle required
                panInput.required = show;
                aadharInput.required = show;

                // Toggle star
                panStar.style.display = show ? "inline" : "none";
                aadharStar.style.display = show ? "inline" : "none";
            };

            toggleFields(); // On load (edit mode support)
            dateInput.addEventListener("change", toggleFields);
        });
    </script>
    <script>
        let currentStep = 1;
        let applicantId = {{ $applicant->id ?? 'null' }};

        /* ── Stepper visual ───── */
        function updateStepper(step) {
            const items = document.querySelectorAll('.step-item');
            items.forEach((item, i) => {
                item.classList.remove('active', 'completed');
                if (i + 1 < step) item.classList.add('completed');
                if (i + 1 === step) item.classList.add('active');
            });

            // Animate track
            const pct = step === 1 ? 0 : ((step - 1) / (items.length - 1)) * 100;
            document.getElementById('stepperTrack').style.width = pct + '%';

            // Step counter
            document.getElementById('stepNum').textContent = step;

            // Buttons
            const prev = document.getElementById('prevBtn');
            const lbl = document.getElementById('btnLabel');

            prev.style.display = step === 1 ? 'none' : 'inline-flex';
            lbl.innerHTML = step === 5 ?
                'Submit Application' :
                'Save &amp; Continue';
        }

        function goToStep(step) {
            const item = document.querySelector(`.step-item[data-step="${step}"]`);
            if (item && (item.classList.contains('completed') || step === currentStep)) {
                loadStep(step);
            }
        }

        /* ── Alert ───────────── */
        function showAlert(message, type) {
            showToast('Allottee Data Entry', message, type);
        }

        /* ── Load step ───────── */
        function loadStep(step) {
            document.getElementById('stepContent').innerHTML =
                `<div class="load-state"><div class="load-ring"></div>Loading step ${step}…</div>`;

            fetch(`{{ route('applicant.apply.step', '') }}/${step}`)
                .then(r => r.text())
                .then(html => {
                    document.getElementById('stepContent').innerHTML = html;
                    currentStep = step;
                    updateStepper(step);
                    document.getElementById('stepContent').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                })
                .catch(() => showAlert('Failed to load step. Please try again.', 'error'));
        }

        /* ── Validation ──────── */
        function validateStep() {
            const form = document.querySelector('#stepContent form');
            if (!form) return true;

            let valid = true,
                first = null;

            form.querySelectorAll('[required]').forEach(f => {
                f.classList.remove('is-invalid');
                const empty = !f.value.trim();
                const badEmail = f.type === 'email' && f.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(f.value);
                const badPat = f.pattern && f.value && !(new RegExp(f.pattern).test(f.value));

                if (empty || badEmail || badPat) {
                    f.classList.add('is-invalid');
                    valid = false;
                    if (!first) first = f;
                }
            });

            if (first) first.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            return valid;
        }

        /* ── Next / Save ─────── */
        function nextStep() {
            if (!validateStep()) {
                showAlert('Please fill in all required fields correctly.', 'error');
                return;
            }

            const nextBtn = document.getElementById('nextBtn');
            const spinner = document.getElementById('btnSpinner');
            const lbl = document.getElementById('btnLabel');

            nextBtn.disabled = true;
            spinner.style.display = 'block';
            lbl.textContent = 'Saving…';

            const form = document.querySelector('#stepContent form');

            if (!form && currentStep === 5) {
                submitApplication();
                return;
            }

            const urls = {
                1: '{{ route('applicant.apply.step1.save') }}',
                2: '{{ route('applicant.apply.step2.save') }}',
                3: '{{ route('applicant.apply.step3.save') }}',
                4: '{{ route('applicant.apply.step4.save') }}',
            };
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            fetch(urls[currentStep], {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(form)
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        if (data.applicant_id) applicantId = data.applicant_id;
                        if (data.next_step) loadStep(data.next_step);
                    } else {
                        const msg = data.errors ?
                            Object.values(data.errors).flat().join('<br>') :
                            'Error saving data.';
                        showAlert(msg, 'error');
                    }
                })
                .catch(() => showAlert('An error occurred. Please try again.', 'error'))
                .finally(() => {
                    nextBtn.disabled = false;
                    spinner.style.display = 'none';
                    lbl.innerHTML = currentStep === 5 ? 'Submit Application' : 'Save &amp; Continue';
                });
        }

        function prevStep() {
            if (currentStep > 1) loadStep(currentStep - 1);
        }

        function submitApplication() {
            fetch('{{ route('applicant.apply.step3.save') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        applicant_id: applicantId,
                        final_submission: true
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        showAlert('Application submitted successfully!', 'success');
                        setTimeout(() => {
                            window.location.href = '#';
                        }, 2000);
                    }
                })
                .catch(() => showAlert('Error submitting application.', 'error'));
        }

        /* ── Init ────────────── */
        document.addEventListener('DOMContentLoaded', function() {
            @if (isset($applicant) && $applicant->current_step > 1)
                currentStep = {{ $applicant->current_step }};
                loadStep(currentStep);
            @endif
            updateStepper(currentStep);

            document.addEventListener('input', e => {
                if (e.target.classList.contains('is-invalid') && e.target.value.trim()) e.target.classList
                    .remove('is-invalid');
            });
            document.addEventListener('change', e => {
                if (e.target.classList.contains('is-invalid') && e.target.value) e.target.classList.remove(
                    'is-invalid');
            });
        });
    </script>
@endsection
