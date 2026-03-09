{{-- resources/views/applicant/stepper-form/index.blade.php --}}
@extends('applicant.dashboard_layouts.main')

@section('title', 'Application Form')
@section('content')

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
            font-size: 16px;
            font-weight: 700;
            color: #fad637;
            line-height: 1.2;
        }

        .header-sub {
            font-size: 12px;
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
            background: var(--gold-dk);
            border: 1.5px solid var(--border);
            color: #ffffff;
        }

        .btn-ghost:hover {
            background: #094fc0;
            border-color: #c0c4d0;
            color: #ffffff;
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

        .input-group {
            display: flex;
            width: 100%;
        }

        .prefix-select {
            width: 100px;
            border: 1px solid #ccc;
            border-right: none;
            padding: 11px 14px;
            border-radius: 6px 0 0 6px;
            background: #f9f9f9;
        }

        .input-group input {
            flex: 1;
            border: 1px solid #ccc;
            padding: 11px 14px;
            border-radius: 0 6px 6px 0;
        }

        .input-group select:focus,
        .input-group input:focus {
            outline: none;
            border-color: #2563eb;
        }

        .bilingual-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 35px;
        }

        .field-label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        .custom-input {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .field-inline {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .date-group {
            display: flex;
            gap: 8px;
        }
    </style>

    <div class="app-shell">
        {{-- Header --}}
        <div class="modern-card-header">
            <div class="header-flex">
                <div>
                    <h1 class="header-title">Residential Property Allotment Application</h1>
                    <p class="header-subtitle">Submit complete allottee and property information</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('applicant.dataentry.scanned.lots.files', encrypt($registerId)) }}">
                        <button class="btn btn-info"
                            style="background: linear-gradient(135deg, #ce3d04, #ee5121) !important; color:white;padding: 6px 24px;
                            border-radius: 2px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg> Back
                        </button>
                    </a>
                </div>
            </div>
        </div>

        {{-- Stepper --}}
        <div class="stepper-wrapper">
            <div class="stepper" id="stepper">
                <div class="stepper-track" id="stepperTrack"></div>
                @foreach ([
            1 => 'Allottee Details',
            2 => 'Address Details',
            3 => 'Property Financial Details',
            4 => 'Nominee & Banking',
            5 => 'Documents Uploads',
            6 => 'Review & Submit',
        ] as $step => $label)
                    <div class="step-item {{ $step === 1 ? 'active' : '' }}" data-step="{{ $step }}"
                        onclick="app.goToStep({{ $step }})">
                        <div class="step-bubble">
                            <span>{{ $step }}</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        </div>
                        <div class="step-meta">
                            <div class="step-label">{{ $label }}</div>
                        </div>
                    </div>
                @endforeach
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
                    Step <strong id="stepNum">1</strong> of <strong>6</strong>
                </div>
                <div style="display:flex; gap:12px; align-items:center;">
                    <button type="button" class="btn btn-ghost" id="prevBtn" onclick="app.prevStep()"
                        style="display:none;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7" />
                        </svg>
                        Previous
                    </button>
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="app.nextStep()">
                        <div class="spinner" id="btnSpinner"></div>
                        <span id="btnLabel">Save & Continue</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.app = {
            config: {
                currentStep: 1,
                applicantId: {{ isset($applicant) ? $applicant->id : 'null' }},
                steps: {
                    1: '{{ route('applicant.apply.step1.save') }}',
                    2: '{{ route('applicant.apply.step2.save') }}',
                    3: '{{ route('applicant.apply.step3.save') }}',
                    4: '{{ route('applicant.apply.step4.save') }}',
                    5: '{{ route('applicant.apply.step5.save') }}',
                },
                loadStepUrl: '{{ route('applicant.apply.step', ['step' => '__STEP__', 'applicantId' => '__ID__']) }}',
                csrfToken: '{{ csrf_token() }}'
            },

            init: function() {
                @if (isset($applicant) && $applicant->current_step > 1)
                    this.config.currentStep = {{ $applicant->current_step }};
                    this.loadStep(this.config.currentStep);
                @else
                    // VERY IMPORTANT
                    this.initializeStep1();
                @endif
                this.updateStepper(this.config.currentStep);
                this.bindEvents();
            },

            bindEvents: function() {
                // Remove validation errors on input
                document.addEventListener('input', e => {
                    if (e.target.classList.contains('is-invalid') && e.target.value.trim()) {
                        e.target.classList.remove('is-invalid');
                    }
                });

                document.addEventListener('change', e => {
                    if (e.target.classList.contains('is-invalid') && e.target.value) {
                        e.target.classList.remove('is-invalid');
                    }
                });
            },

            updateStepper: function(step) {
                const items = document.querySelectorAll('.step-item');
                items.forEach((item, i) => {
                    item.classList.remove('active', 'completed');
                    if (i + 1 < step) item.classList.add('completed');
                    if (i + 1 === step) item.classList.add('active');
                });

                const pct = step === 1 ? 0 : ((step - 1) / (items.length - 1)) * 100;
                document.getElementById('stepperTrack').style.width = pct + '%';
                document.getElementById('stepNum').textContent = step;

                const prev = document.getElementById('prevBtn');
                const lbl = document.getElementById('btnLabel');

                prev.style.display = step === 1 ? 'none' : 'inline-flex';
                lbl.innerHTML = step === 6 ? 'Submit Application' : 'Save & Continue';

                this.config.currentStep = step;
            },

            goToStep: function(step) {
                const item = document.querySelector(`.step-item[data-step="${step}"]`);
                if (item && (item.classList.contains('completed') || step === this.config.currentStep)) {
                    this.loadStep(step);
                }
            },

            loadStep: function(step) {
                if (!this.config.applicantId) {
                    this.showAlert('Please save step 1 first.', 'error');
                    return;
                }

                const url = this.config.loadStepUrl
                    .replace('__STEP__', step)
                    .replace('__ID__', this.config.applicantId);

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Failed to load step');
                        return res.text();
                    })
                    .then(html => {
                        document.getElementById('stepContent').innerHTML = html;
                        this.updateStepper(step);

                        // Re-initialize any step-specific JavaScript
                        this.initializeStepScripts(step);
                    })
                    .catch(err => {
                        console.error(err);
                        this.showAlert('Failed to load step. Please try again.', 'error');
                    });
            },

            // New function to initialize step-specific scripts
            initializeStepScripts: function(step) {
                // Re-run DOMContentLoaded scripts for the newly loaded content
                if (step === 1) {
                    // Re-initialize step1 specific functionality
                    this.initializeStep1();
                } else if (step === 2) {
                    // Initialize step2 specific functionality
                    this.initializeStep2();
                } else if (step === 3) {
                    // Initialize step3 specific functionality
                    this.initializeStep3();
                } else if (step === 4) {
                    // Initialize step4 specific functionality
                    this.initializeStep4();
                } else if (step === 5) {
                    // Initialize step5 specific functionality
                    this.initializeStep5();
                } else if (step === 6) {
                    // Initialize step6 specific functionality
                    this.initializeStep6();
                }
            },

            // Step 1 initialization
            initializeStep1: function() {
                const yearInput = document.getElementById("allotmentYear");
                const applicationYearSelect = document.getElementById("application_year");
                const errorText = document.getElementById("yearError");

                if (!yearInput) return;

                function validateYear() {

                    let value = yearInput.value.trim().replace(/[^0-9]/g, '');
                    yearInput.value = value;

                    if (value.length !== 4) {
                        yearInput.classList.remove("invalid-year");
                        if (errorText) errorText.textContent = "";
                        return;
                    }

                    const currentYear = new Date().getFullYear();
                    const minYear = 1950;
                    const appYear = parseInt(applicationYearSelect?.value || 0);
                    const allotYear = parseInt(value);

                    // Basic Range Validation
                    if (allotYear < minYear || allotYear > currentYear) {
                        yearInput.classList.add("invalid-year");
                        if (errorText) {
                            errorText.textContent =
                                `Year must be between ${minYear} and ${currentYear}`;
                        }
                        return;
                    }

                    // Application Year Validation (>=)
                    if (appYear && allotYear < appYear) {
                        yearInput.classList.add("invalid-year");
                        if (errorText) {
                            errorText.textContent =
                                `Allotment Year cannot be less than Application Year (${appYear})`;
                        }
                        return;
                    }

                    // If valid
                    yearInput.classList.remove("invalid-year");
                    if (errorText) errorText.textContent = "";

                }

                // Input validation
                yearInput.addEventListener("input", validateYear);

                // Re-check if application year changes
                if (applicationYearSelect) {
                    applicationYearSelect.addEventListener("change", validateYear);
                }

                // Re-initialize Year change event
                const allotmentYear = document.getElementById('allotment_year');
                if (allotmentYear) {
                    // Remove old listeners safely
                    const newAllotmentYear = allotmentYear.cloneNode(true);
                    allotmentYear.parentNode.replaceChild(newAllotmentYear, allotmentYear);
                    console.log('come');

                    newAllotmentYear.addEventListener('change', function() {
                        console.log('comming');
                        app.togglePanAadhar();
                    });

                    // Initial trigger
                    app.togglePanAadhar();
                }

                document.getElementById("application_year").addEventListener("change", function() {

                    let appYear = parseInt(this.value);
                    let allotSelect = document.getElementById("allotment_year");

                    if (!appYear) return;

                    Array.from(allotSelect.options).forEach(option => {

                        if (!option.value) return; // skip default option

                        let allotYear = parseInt(option.value);

                        if (allotYear < appYear) {
                            option.hidden = true; // hide small year
                        } else {
                            option.hidden = false; // show valid year
                        }
                    });

                    // Reset selection if invalid selected
                    if (parseInt(allotSelect.value) < appYear) {
                        allotSelect.value = "";
                    }

                });

                document.addEventListener("change", function(e) {

                    // Only run when DOB fields change
                    if (
                        !e.target.matches(
                            '[name="date_of_birth_day"], [name="date_of_birth_month"], [name="date_of_birth_year"]'
                        )
                    ) return;

                    let dayField = document.querySelector('[name="date_of_birth_day"]');
                    let monthField = document.querySelector('[name="date_of_birth_month"]');
                    let yearField = document.querySelector('[name="date_of_birth_year"]');

                    // Safety check
                    if (!dayField || !monthField || !yearField) return;

                    let day = dayField.value;
                    let month = monthField.value;
                    let year = yearField.value;

                    if (!day || !month || !year) return;

                    let dob = new Date(year, month - 1, day);
                    let today = new Date();

                    let age = today.getFullYear() - dob.getFullYear();
                    let m = today.getMonth() - dob.getMonth();

                    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }

                    let ageField = document.getElementById("current_age");
                    if (!ageField) return;

                    ageField.value = age + " years";
                    ageField.readOnly = true;

                });

                // Only Numbers (0-9)
                document.querySelectorAll(".only-number").forEach(function(input) {
                    input.addEventListener("input", function() {
                        this.value = this.value.replace(/[^0-9]/g, "");
                    });
                });

                // Only Alphabets (A-Z + space)
                document.querySelectorAll(".only-alphabet").forEach(function(input) {
                    input.addEventListener("input", function() {
                        this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
                    });
                });

                document.querySelectorAll(".only-hindi").forEach(function(input) {
                    input.addEventListener("input", function() {
                        this.value = this.value.replace(/[^\u0900-\u097F\s]/g, "");
                    });
                });
            },

            // Step 2 initialization (add your step2 specific code)
            initializeStep2: function() {
                document.querySelectorAll('.state-select, .state-select-hindi')
                    .forEach(function(select) {

                        select.addEventListener('change', function() {

                            let stateId = this.value;
                            let targetId = this.dataset.target; // data-target value
                            let districtSelect = document.getElementById(targetId);

                            districtSelect.innerHTML =
                                '<option value="">-- Select District --</option>';

                            if (!stateId) return;

                            fetch(`/districts/${stateId}`)
                                .then(res => res.json())
                                .then(data => {

                                    // Clear based on language
                                    if (targetId.includes('hi')) {
                                        districtSelect.innerHTML =
                                            '<option value="">-- जिला चुनें --</option>';
                                    } else {
                                        districtSelect.innerHTML =
                                            '<option value="">-- Select District --</option>';
                                    }

                                    data.forEach(item => {

                                        const option = document.createElement('option');
                                        option.value = item.id;

                                        // Auto language detect
                                        option.textContent = targetId.includes('hi') ?
                                            item.name_hi :
                                            item.name_en;

                                        districtSelect.appendChild(option);
                                    });

                                })
                                .catch(error => console.error('Error loading districts:', error));
                        });

                    });

                // Only Numbers (0-9)
                document.querySelectorAll(".only-number").forEach(function(input) {
                    input.addEventListener("input", function() {
                        this.value = this.value.replace(/[^0-9]/g, "");
                    });
                });

                // Only Alphabets (A-Z + space)
                document.querySelectorAll(".only-alphabet").forEach(function(input) {
                    input.addEventListener("input", function() {
                        this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
                    });
                });

                document.querySelectorAll(".only-hindi").forEach(function(input) {
                    input.addEventListener("input", function() {
                        this.value = this.value.replace(/[^\u0900-\u097F\s]/g, "");
                    });
                });

                // Only Email Allowed Characters
                document.querySelectorAll(".only-email").forEach(function(input) {
                    input.addEventListener("input", function() {
                        this.value = this.value.replace(/[^a-zA-Z0-9@._\-]/g, "");
                    });
                });

                /* ---------------- ADDRESS COPY ---------------- */
                const doc = document;
                const checkbox = doc.getElementById('same_as_relation_copy');

                if (checkbox) {

                    checkbox.addEventListener('change', function() {

                        const fieldMap = [

                            ['relation_address', 'present_address'],
                            ['relation_address_hindi', 'present_address_hindi'],

                            ['relation_state', 'present_state'],
                            ['relation_state_hindi', 'present_state_hindi'],

                            ['relation_district', 'present_district'],
                            ['relation_district_hindi', 'present_district_hindi'],

                            ['relation_pincode', 'present_pincode'],
                            ['relation_pincode_hindi', 'present_pincode_hindi'],

                            ['relation_post_office', 'present_post_office'],
                            ['relation_post_office_hindi', 'present_post_office_hindi'],

                            ['relation_police_station', 'present_police_station'],
                            ['relation_police_station_hindi', 'present_police_station_hindi']

                        ];

                        fieldMap.forEach(([from, to]) => {

                            const fromEl = doc.querySelector(`[name="${from}"]`);
                            const toEl = doc.querySelector(`[name="${to}"]`);

                            if (fromEl && toEl) {
                                toEl.value = checkbox.checked ? fromEl.value : '';
                            }

                        });

                        if (checkbox.checked) {
                            doc.querySelector('[name="present_state"]')
                                ?.dispatchEvent(new Event('change'));

                            doc.querySelector('[name="present_state_hindi"]')
                                ?.dispatchEvent(new Event('change'));
                        }

                    });
                }

                /* ---------------- PRESENT → PERMANENT ADDRESS COPY ---------------- */
                const presentCheckbox = document.getElementById('same_as_present_place_residance');

                if (presentCheckbox) {

                    presentCheckbox.addEventListener('change', function() {

                        const fieldMap = [

                            ['present_address', 'permanent_address'],
                            ['present_address_hindi', 'permanent_address_hindi'],

                            ['present_state', 'permanent_state'],
                            ['present_state_hindi', 'permanent_state_hindi'],

                            ['present_district', 'permanent_district'],
                            ['present_district_hindi', 'permanent_district_hindi'],

                            ['present_pincode', 'permanent_pincode'],
                            ['present_pincode_hindi', 'permanent_pincode_hindi'],

                            ['present_post_office', 'permanent_post_office'],
                            ['present_post_office_hindi', 'permanent_post_office_hindi'],

                            ['present_police_station', 'permanent_police_station'],
                            ['present_police_station_hindi', 'permanent_police_station_hindi']

                        ];

                        fieldMap.forEach(([from, to]) => {

                            const fromEl = document.querySelector(`[name="${from}"]`);
                            const toEl = document.querySelector(`[name="${to}"]`);

                            if (fromEl && toEl) {
                                toEl.value = presentCheckbox.checked ? fromEl.value : '';
                            }

                        });

                        // reload district if state copied
                        if (presentCheckbox.checked) {

                            document.querySelector('[name="permanent_state"]')
                                ?.dispatchEvent(new Event('change'));

                            document.querySelector('[name="permanent_state_hindi"]')
                                ?.dispatchEvent(new Event('change'));
                        }

                    });

                }

                /* ---------------- PERMANENT → CORRESPONDENCE ADDRESS COPY ---------------- */

                const permanentCheckbox = document.getElementById('same_as_permanent_address');

                if (permanentCheckbox) {

                    permanentCheckbox.addEventListener('change', function() {

                        const fieldMap = [

                            ['permanent_address', 'correspondence_address'],
                            ['permanent_address_hindi', 'correspondence_address_hindi'],

                            ['permanent_state', 'correspondence_state'],
                            ['permanent_state_hindi', 'correspondence_state_hindi'],

                            ['permanent_district', 'correspondence_district'],
                            ['permanent_district_hindi', 'correspondence_district_hindi'],

                            ['permanent_pincode', 'correspondence_pincode'],
                            ['permanent_pincode_hindi', 'correspondence_pincode_hindi'],

                            ['permanent_post_office', 'correspondence_post_office'],
                            ['permanent_post_office_hindi', 'correspondence_post_office_hindi'],

                            ['permanent_police_station', 'correspondence_police_station'],
                            ['permanent_police_station_hindi', 'correspondence_police_station_hindi']

                        ];

                        fieldMap.forEach(([from, to]) => {

                            const fromEl = document.querySelector(`[name="${from}"]`);
                            const toEl = document.querySelector(`[name="${to}"]`);

                            if (fromEl && toEl) {
                                toEl.value = permanentCheckbox.checked ? fromEl.value : '';
                            }

                        });

                        // reload district if state copied
                        if (permanentCheckbox.checked) {

                            document.querySelector('[name="correspondence_state"]')
                                ?.dispatchEvent(new Event('change'));

                            document.querySelector('[name="correspondence_state_hindi"]')
                                ?.dispatchEvent(new Event('change'));
                        }

                    });

                }
            },

            // Step 3 initialization
            initializeStep3: function() {
                function num(v) {
                    return parseFloat(v) || 0;
                }

                function disableAll() {
                    const ids = [
                        'high_income_percent', 'low_income_percent',
                        'deposited_amount', 'legal_fee', 'legal_document_fee',
                        'total_payment',
                        'interim_price', 'remaining_amount',
                        'payment_months', 'interest_type',
                        'pre_interest', 'late_interest',
                        'pre_interest_amount', 'late_interest_amount'
                    ];
                    ids.forEach(id => document.getElementById(id).disabled = true);
                }
                disableAll();

                const tentative = document.getElementById('tentative_price');
                tentative.addEventListener('input', function() {
                    if (this.value) {
                        enable(['high_income_percent', 'low_income_percent']);
                        setAuto('interim_price', num(this.value));
                    } else {
                        disableAll();
                    }
                });


                const high = document.getElementById('high_income_percent');
                const low = document.getElementById('low_income_percent');

                high.addEventListener('input', function() {
                    if (this.value) {
                        low.value = '';
                    }
                    calculateDeposit();
                });
                low.addEventListener('input', function() {
                    if (this.value) {
                        high.value = '';
                    }
                    calculateDeposit();
                });


                function calculateDeposit() {
                    let P = num(tentative.value);
                    let percent = num(high.value || low.value);

                    if (percent > 0) {
                        enable(['legal_fee', 'legal_document_fee']);
                    }

                    let deposit = (P * percent) / 100;
                    setAuto('deposited_amount', deposit);

                    calculateRemaining();
                    calculateTotal();
                }


                document.getElementById('legal_fee').addEventListener('input', calculateTotal);
                document.getElementById('legal_document_fee').addEventListener('input', calculateTotal);

                function calculateTotal() {
                    let d = num(document.getElementById('deposited_amount').value);
                    let l1 = num(document.getElementById('legal_fee').value);
                    let l2 = num(document.getElementById('legal_document_fee').value);

                    let total = d - l1 + l2;
                    setAuto('total_payment', total);

                    calculateRemaining();
                }

                function calculateRemaining() {
                    let P = num(tentative.value);
                    let d = num(document.getElementById('deposited_amount').value);

                    let remaining = P - d;
                    setAuto('remaining_amount', remaining);

                    if (remaining > 0) {
                        enable(['payment_months', 'interest_type', 'pre_interest', 'late_interest']);
                    }
                }

                ['payment_months', 'interest_type', 'pre_interest', 'late_interest']
                .forEach(id => {
                    document.getElementById(id).addEventListener('input', calculateInterest);
                    document.getElementById(id).addEventListener('change', calculateInterest);
                });

                function calculateInterest() {

                    console.log("------ Interest Calculation Triggered ------");

                    let P = num(document.getElementById('remaining_amount').value);
                    let T = num(document.getElementById('payment_months').value);
                    let R1 = num(document.getElementById('pre_interest').value);
                    let R2 = num(document.getElementById('late_interest').value);
                    let type = document.getElementById('interest_type').value;
                    let monthlyRate = R1 / 12 / 100;
                    let TY = T / 12;

                    if (!P || !T || !type) {
                        console.log("❌ Missing Required Values");
                        return;
                    }

                    let preInterestAmount = 0;
                    let lateInterestAmount = 0;
                    let SIAmount = 0;
                    let PSIAmount = 0;
                    let totalAmount = 0;
                    let PtotalAmount = 0;

                    if (type === 'simple') {
                        // // Pre Interest Only
                        SIAmount = (P * R1 * TY) / 100;
                        totalAmount = P + SIAmount;
                        preInterestAmount = totalAmount / T;

                        // Combined (Pre + Late)
                        let totalRate = (R1 + R2);
                        PSIAmount = (P * totalRate * TY) / 100;
                        PtotalAmount = P + PSIAmount;
                        lateInterestAmount = PtotalAmount / T;

                        console.log("Total Rate (R1+R2):", totalRate);
                    } else if (type === 'compound') {
                        // Normal EMI
                        if (monthlyRate > 0 && T > 0) {
                            let emi = (P * monthlyRate * Math.pow(1 + monthlyRate, T)) /
                                (Math.pow(1 + monthlyRate, T) - 1);
                            preInterestAmount = Math.ceil(emi);
                        } else {
                            preInterestAmount = T > 0 ? Math.ceil(P / T) : 0;
                        }

                        // Penalty EMI
                        let penaltyRate = (R1 + R2) / 12 / 100;

                        if (penaltyRate > 0 && T > 0) {
                            let emiPen = (P * penaltyRate * Math.pow(1 + penaltyRate, T)) /
                                (Math.pow(1 + penaltyRate, T) - 1);
                            lateInterestAmount = Math.ceil(emiPen);
                        } else {
                            lateInterestAmount = T > 0 ? Math.ceil(P / T) : 0;
                        }

                        console.log("Total Rate (R1+R2):", penaltyRate);
                    }
                    setAuto('pre_interest_amount', preInterestAmount);
                    setAuto('late_interest_amount', lateInterestAmount);
                }


                function enable(arr) {
                    arr.forEach(id => {
                        document.getElementById(id).disabled = false;
                    });
                }

                function setAuto(id, value) {
                    let input = document.getElementById(id);
                    input.value = value.toFixed(2);
                    input.disabled = true;

                    let hidden = document.querySelector('input[type=hidden][name="' + input.name + '"]');
                    if (!hidden) {
                        hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = input.name;
                        input.parentNode.appendChild(hidden);
                    }
                    hidden.value = value.toFixed(2);
                }


                document.querySelectorAll('.state-select, .state-select-hindi')
                    .forEach(function(select) {

                        select.addEventListener('change', function() {

                            let stateId = this.value;
                            let targetId = this.dataset.target; // data-target value
                            let districtSelect = document.getElementById(targetId);

                            districtSelect.innerHTML =
                                '<option value="">-- Select District --</option>';

                            if (!stateId) return;

                            fetch(`/districts/${stateId}`)
                                .then(res => res.json())
                                .then(data => {

                                    // Clear based on language
                                    if (targetId.includes('hi')) {
                                        districtSelect.innerHTML =
                                            '<option value="">-- जिला चुनें --</option>';
                                    } else {
                                        districtSelect.innerHTML =
                                            '<option value="">-- Select District --</option>';
                                    }

                                    data.forEach(item => {

                                        const option = document.createElement('option');
                                        option.value = item.id;

                                        // Auto language detect
                                        option.textContent = targetId.includes('hi') ?
                                            item.name_hi :
                                            item.name_en;

                                        districtSelect.appendChild(option);
                                    });

                                })
                                .catch(error => console.error('Error loading districts:', error));
                        });

                    });

                const emiInput = document.getElementById('payment_months');
                const monthInput = document.getElementById('payment_start_month');
                const yearInput = document.getElementById('payment_start_year');
                const result = document.getElementById('last_payment_due_date');

                const monthNames = [
                    "", "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];

                function calculateLastEMI() {

                    const emi = parseInt(emiInput?.value) || 0;
                    const month = parseInt(monthInput?.value) || 0;
                    const year = parseInt(yearInput?.value) || 0;

                    if (!emi || !month || !year) {
                        result.value = "";
                        return;
                    }

                    const startDate = new Date(year, month - 1);
                    startDate.setMonth(startDate.getMonth() + emi - 1);

                    const lastMonth = monthNames[startDate.getMonth() + 1];
                    const lastYear = startDate.getFullYear();

                    result.value = `${lastMonth} ${lastYear}`;
                }

                [emiInput, monthInput, yearInput].forEach(el => {
                    el?.addEventListener("input", calculateLastEMI);
                    el?.addEventListener("change", calculateLastEMI);
                });

                // Only Numbers (0-9)
                document.querySelectorAll(".only-number").forEach(function(input) {
                    input.addEventListener("input", function() {
                        this.value = this.value.replace(/[^0-9]/g, "");
                    });
                });

                // Only Alphabets (A-Z + space)
                document.querySelectorAll(".only-alphabet").forEach(function(input) {
                    input.addEventListener("input", function() {
                        this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
                    });
                });

                // English (A-Z, a-z) + Hindi (Devanagari) + Space
                document.querySelectorAll(".only-eng-hindi").forEach(function(input) {
                    input.addEventListener("input", function() {
                        this.value = this.value.replace(/[^a-zA-Z\u0900-\u097F\s]/g, "");
                    });
                });

                document.querySelectorAll(".only-float-100").forEach(function(input) {

                    input.addEventListener("input", function() {

                        // Remove invalid characters (allow digits + dot)
                        let value = this.value.replace(/[^0-9.]/g, "");

                        // Prevent multiple dots
                        let parts = value.split(".");
                        if (parts.length > 2) {
                            value = parts[0] + "." + parts[1];
                        }

                        // Convert to number and check max limit
                        let number = parseFloat(value);

                        if (!isNaN(number) && number > 100) {
                            value = "100";
                        }

                        this.value = value;
                    });

                });
            },

            // Step 4 initialization
            initializeStep4: function() {
                // Add any step4 specific initialization here
                console.log('Step 4 initialized');
            },

            initializeStep5: function() {
                const self = this;
                const applicantId = document.getElementById('applicant_id')?.value || '';
                const submitUrl = '/applicant/documents/store';

                // State management
                let isNameTransfer = false;
                let completedBasicDocs = [];
                let completedNameTransferDocs = [];
                let emiFormSaved = false;
                let allotteeDetailsSaved = false; // Track if allottee details are saved

                // Document configurations
                const documentConfigs = {
                    basic: [{
                            id: 1,
                            name: 'Application Letter',
                            key: 'application_letter'
                        },
                        {
                            id: 2,
                            name: 'Allotment Letter',
                            key: 'allotment_letter'
                        },
                        {
                            id: 3,
                            name: 'Agreement Copy',
                            key: 'agreement_copy'
                        },
                        {
                            id: 4,
                            name: 'Allotment Cancellation Letter',
                            key: 'allotment_cancellation'
                        },
                        {
                            id: 5,
                            name: 'Re-Allotment Letter',
                            key: 'reallotment_letter'
                        },
                        {
                            id: 6,
                            name: 'Final Calculation',
                            key: 'final_calculation'
                        },
                        {
                            id: 7,
                            name: 'NOC before Registry',
                            key: 'noc_before_registry'
                        },
                        {
                            id: 8,
                            name: 'Registry Deed',
                            key: 'registry_deed'
                        }
                    ],
                    nameTransfer: [{
                            id: 9,
                            name: 'Name Transfer Request Order',
                            key: 'name_transfer_request'
                        },
                        {
                            id: 10,
                            name: 'Name Transfer forwarding from JSHB',
                            key: 'name_transfer_forwarding'
                        },
                        {
                            id: 11,
                            name: 'Dividend Calculation Letter',
                            key: 'dividend_calculation'
                        },
                        {
                            id: 12,
                            name: 'Letter for Deed to New Allottee',
                            key: 'deed_letter'
                        },
                        {
                            id: 13,
                            name: 'Site Verification Document',
                            key: 'site_verification'
                        },
                        {
                            id: 14,
                            name: 'NOC Letter',
                            key: 'noc_letter'
                        },
                        {
                            id: 15,
                            name: 'Name Transfer Confirmation Order',
                            key: 'name_transfer_confirmation'
                        },
                        {
                            id: 16,
                            name: 'Ground Rent before Registry',
                            key: 'ground_rent'
                        },
                        {
                            id: 17,
                            name: 'Registry Deed',
                            key: 'name_transfer_registry_deed'
                        }
                    ]
                };

                // Function to show new allottee form
                function showNewAllotteeForm() {
                    if (document.getElementById('newAllotteeForm')) return;

                    const formHtml = `
                        <div id="newAllotteeForm" style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #aa7700; border-radius: 4px;">
                            <h4 style="margin: 0 0 15px; color: #aa7700;">New Allottee Details</h4>
                            <div id="allotteeDetailsForm" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                                <input type="hidden" name="applicant_id" value="${applicantId}">
                                <div>
                                    <label style="font-size: 12px;">Allottee Name *</label>
                                    <input type="text" name="allottee_name" class="compact-input" required>
                                </div>
                                <div>
                                    <label style="font-size: 12px;">Father/Husband Name *</label>
                                    <input type="text" name="father_name" class="compact-input" required>
                                </div>
                                <div>
                                    <label style="font-size: 12px;">Gender *</label>
                                    <select name="gender" class="compact-input" required>
                                        <option value="">Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 12px;">Date of Birth *</label>
                                    <input type="date" name="dob" class="compact-input" required>
                                </div>
                                <div>
                                    <label style="font-size: 12px;">Marital Status *</label>
                                    <select name="marital_status" class="compact-input" required>
                                        <option value="">Select</option>
                                        <option value="married">Married</option>
                                        <option value="unmarried">Unmarried</option>
                                        <option value="divorced">Divorced</option>
                                        <option value="widowed">Widowed</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 12px;">Category *</label>
                                    <select name="category" class="compact-input" required>
                                        <option value="">Select</option>
                                        <option value="general">General</option>
                                        <option value="obc">OBC</option>
                                        <option value="sc">SC</option>
                                        <option value="st">ST</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 12px;">Religion *</label>
                                    <input type="text" name="religion" class="compact-input" required>
                                </div>
                                <div>
                                    <label style="font-size: 12px;">Nationality *</label>
                                    <input type="text" name="nationality" class="compact-input" value="Indian" required>
                                </div>
                                <div>
                                    <label style="font-size: 12px;">Address for Correspondence *</label>
                                    <textarea name="correspondence_address" class="compact-input" rows="2" required></textarea>
                                </div>
                                <div>
                                    <label style="font-size: 12px;">Full Permanent Address *</label>
                                    <textarea name="permanent_address" class="compact-input" rows="2" required></textarea>
                                </div>
                                <div>
                                    <label style="font-size: 12px;">Mobile No. *</label>
                                    <input type="tel" name="mobile" class="compact-input" pattern="[0-9]{10}" required>
                                </div>
                                <div>
                                    <label style="font-size: 12px;">Alternate Mobile No.</label>
                                    <input type="tel" name="alternate_mobile" class="compact-input" pattern="[0-9]{10}">
                                </div>
                                <div>
                                    <label style="font-size: 12px;">WhatsApp No.</label>
                                    <input type="tel" name="whatsapp" class="compact-input" pattern="[0-9]{10}">
                                </div>
                                <div>
                                    <label style="font-size: 12px;">Email ID *</label>
                                    <input type="email" name="email" class="compact-input" required>
                                </div>
                            </div>
                            <div style="margin-top: 15px; text-align: right;">
                                <button type="button" class="btn-submit" id="saveAllotteeBtn" style="width: auto; padding: 8px 20px;">Save Allottee Details</button>
                            </div>
                        </div>
                    `;

                    const nameTransferSection = document.getElementById('nameTransferSection');
                    nameTransferSection.insertAdjacentHTML('afterend', formHtml);

                    // Add event listener for save button
                    document.getElementById('saveAllotteeBtn').addEventListener('click', saveAllotteeDetails);
                }

                // Function to save allottee details
                function saveAllotteeDetails() {
                    const form = document.getElementById('allotteeDetailsForm');
                    const inputs = form.querySelectorAll('input, select, textarea');
                    let isValid = true;

                    inputs.forEach(input => {
                        if (input.hasAttribute('required') && !input.value) {
                            isValid = false;
                            input.classList.add('error');
                        } else {
                            input.classList.remove('error');
                        }
                    });

                    if (!isValid) {
                        alert('Please fill all required fields');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');
                    formData.append('applicant_id', applicantId);

                    inputs.forEach(input => {
                        formData.append(input.name, input.value);
                    });

                    const saveBtn = document.getElementById('saveAllotteeBtn');
                    const originalText = saveBtn.textContent;

                    saveBtn.disabled = true;
                    saveBtn.textContent = 'Saving...';

                    fetch('/applicant/save-allottee-details', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('newAllotteeForm').style.opacity = '0.7';

                                inputs.forEach(el => {
                                    el.disabled = true;
                                });
                                saveBtn.disabled = true;
                                saveBtn.textContent = 'Saved';

                                // Mark allottee details as saved
                                allotteeDetailsSaved = true;

                                // Load first name transfer document
                                if (isNameTransfer) {
                                    loadNextDocument('nameTransfer');
                                }
                            } else {
                                alert(data.message || 'Error saving details');
                                saveBtn.disabled = false;
                                saveBtn.textContent = originalText;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error saving details');
                            saveBtn.disabled = false;
                            saveBtn.textContent = originalText;
                        });
                }

                // EMI Payment Form HTML
                const emiFormTemplate = `
                        <div id="emiPaymentForm" style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #b11226; border-radius: 4px;">
                            <h4 style="margin: 0 0 15px; color: #b11226;">EMI Payment Status</h4>
                            
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Is EMI still being paid?</label>
                                <select id="emiPaymentStatus" class="compact-input" style="width: 200px;" required>
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>

                            <div id="emiCountSection" style="display: none; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Without Penalty EMI Count</label>
                                        <input type="number" id="withoutPenaltyEmi" class="compact-input" min="0" placeholder="Enter count">
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">With Penalty EMI Count</label>
                                        <input type="number" id="withPenaltyEmi" class="compact-input" min="0" placeholder="Enter count">
                                    </div>
                                </div>
                            </div>

                            <div style="margin-top: 15px; text-align: right;">
                                <button type="button" class="btn-submit" id="saveEmiBtn" style="width: auto; padding: 8px 20px;">Save EMI Details</button>
                            </div>
                        </div>
                    `;

                // Modal HTML template
                const modalTemplate = (docName, filePreview, docData) => `
                <div id="filePreviewModal" class="modal-overlay" style="display: flex; padding-top:0px;">
                    <div class="modal modal-top" style="background: white; margin: 50px auto; width: 90%; max-width: 600px; border-radius: 4px;">
                        <div class="modal-header">
                            <h4>Preview: ${docName}</h4>
                            <button class="modal-close" onclick="document.getElementById('filePreviewModal').remove()">×</button>
                        </div>
                        <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                            ${filePreview}
                            ${docData.remarks ? `
                                                <div style="margin-top: 15px; padding: 10px; background: #f9f9f9; border-left: 3px solid #b11226;">
                                                    <strong>Remarks:</strong> ${docData.remarks}
                                                </div>` : ''}
                            ${docData.doc_no ? `
                                                <div style="margin-top: 10px; padding: 10px; background: #f9f9f9;">
                                                    <strong>Document No:</strong> ${docData.doc_no}
                                                </div>` : ''}
                            ${(docData.day && docData.month && docData.year) ? `
                                                <div style="margin-top: 10px; padding: 10px; background: #f9f9f9;">
                                                    <strong>Date:</strong> ${docData.day}/${docData.month}/${docData.year}
                                                </div>` : ''}
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" onclick="document.getElementById('filePreviewModal').remove()">Cancel</button>
                            <button class="btn btn-danger" id="confirmFileBtn">Confirm & Submit</button>
                        </div>
                    </div>
                </div>
                `;

                // Utility functions
                const generateDayOptions = (selected = '') => {
                    let options = '<option value="">DD</option>';
                    for (let i = 1; i <= 31; i++) {
                        const val = i.toString().padStart(2, '0');
                        options +=
                            `<option value="${val}" ${selected === val ? 'selected' : ''}>${val}</option>`;
                    }
                    return options;
                };

                const generateMonthOptions = (selected = '') => {
                    let options = '<option value="">MM</option>';
                    for (let i = 1; i <= 12; i++) {
                        const val = i.toString().padStart(2, '0');
                        options +=
                            `<option value="${val}" ${selected === val ? 'selected' : ''}>${val}</option>`;
                    }
                    return options;
                };

                const generateYearOptions = (selected = '') => {
                    const currentYear = new Date().getFullYear();
                    let options = '<option value="">YYYY</option>';
                    for (let i = currentYear; i >= 1960; i--) {
                        options += `<option value="${i}" ${selected == i ? 'selected' : ''}>${i}</option>`;
                    }
                    return options;
                };

                // File preview generator
                const generateFilePreview = (file) => {
                    if (!file) return '<p>No file selected</p>';

                    const fileType = file.type;
                    const fileUrl = URL.createObjectURL(file);

                    if (fileType.startsWith('image/')) {
                        return `<img src="${fileUrl}" alt="Preview" style="max-width: 100%; max-height: 350px; display: block; margin: 0 auto;">`;
                    } else if (fileType === 'application/pdf') {
                        return `<embed src="${fileUrl}" type="application/pdf" width="100%" height="350px" />`;
                    } else {
                        return `<div style="text-align: center; padding: 20px;">
                            <i class="fas fa-file" style="font-size: 48px; color: #b11226;"></i>
                            <p>${file.name}</p>
                            <p style="color: #666;">(Preview not available for this file type)</p>
                            </div>`;
                    }
                };

                // Check if row is valid for preview
                const isRowValid = (row) => {
                    const file = row.querySelector('.document-file')?.files[0];
                    const remarks = row.querySelector('.remarks')?.value.trim();

                    if (file) {
                        return true;
                    } else {
                        return remarks && remarks.length > 0;
                    }
                };

                // Update preview button state and text
                const updatePreviewButtonState = (row) => {
                    const previewBtn = row.querySelector('.preview-btn');
                    const file = row.querySelector('.document-file')?.files[0];

                    if (previewBtn) {
                        if (isRowValid(row)) {
                            previewBtn.disabled = false;
                            previewBtn.style.opacity = '1';
                            previewBtn.style.cursor = 'pointer';
                            previewBtn.textContent = file ? 'Preview Document' : 'Preview Remarks';
                        } else {
                            previewBtn.disabled = true;
                            previewBtn.style.opacity = '0.5';
                            previewBtn.style.cursor = 'not-allowed';
                            previewBtn.textContent = 'Preview';
                        }
                    }
                };

                // Create document row
                const createDocumentRow = (doc, sl, type, isCompleted = false, data = null) => {
                    const rowId = `row_${doc.id}`;
                    const completedClass = isCompleted ? 'completed-row' : 'current-row';
                    return `
                        <tr class="document-row ${completedClass}" id="${rowId}" 
                            data-document-id="${doc.id}" data-document-type="${type}" data-document-key="${doc.key}">
                            <td style="padding: 8px 5px; border: 1px solid #ddd; text-align: center; width:5%;">
                                <span class="sl-badge">${sl}</span>
                            </td>
                            <td style="padding: 8px 5px; border: 1px solid #ddd; width:11%;" class="doc-name-cell">
                                ${doc.name}
                                <span class="status-completed" style="${isCompleted ? 'display: inline-block;' : 'display: none;'}">✓</span>
                            </td>
                            <td style="padding: 8px 5px; border: 1px solid #ddd; width:12%;">
                                <input type="text" class="compact-input doc-no" placeholder="Doc No. (Optional)" 
                                    value="${data?.doc_no || ''}" ${isCompleted ? 'disabled' : ''}>
                            </td>
                            <td style="padding: 8px 5px; border: 1px solid #ddd; width:10%;">
                                <div style="display: flex; gap: 2px;">
                                    <select class="compact-input day" style="width: 35px;" ${isCompleted ? 'disabled' : ''}>
                                        ${generateDayOptions(data?.day || '')}
                                    </select>
                                    <select class="compact-input month" style="width: 45px;" ${isCompleted ? 'disabled' : ''}>
                                        ${generateMonthOptions(data?.month || '')}
                                    </select>
                                    <select class="compact-input year" style="width: 60px;" ${isCompleted ? 'disabled' : ''}>
                                        ${generateYearOptions(data?.year || '')}
                                    </select>
                                </div>
                            </td>
                            <td style="padding: 8px 5px; border: 1px solid #ddd; width:15%;">
                                <textarea class="compact-input additional-info" rows="2" placeholder="Additional Information (Optional)" 
                                        ${isCompleted ? 'disabled' : ''}>${data?.additional_info || ''}</textarea>
                            </td>
                            <td style="padding: 8px 5px; border: 1px solid #ddd; width:18%;">
                                <input type="file" class="file-input document-file" accept=".pdf,.jpg,.jpeg,.png" 
                                    ${isCompleted ? 'disabled' : ''}>
                                ${isCompleted && data?.has_file ? '<div><small>File uploaded</small></div>' : ''}
                            </td>
                            <td style="padding: 8px 5px; border: 1px solid #ddd; width:25%;">
                                <textarea class="compact-input remarks-field remarks" rows="2" placeholder="Remarks (Required)" 
                                        ${isCompleted ? 'disabled' : ''}>${data?.remarks || ''}</textarea>
                            </td>
                            <td style="padding: 8px 5px; border: 1px solid #ddd; width:10%; text-align: center;">
                                ${!isCompleted ? 
                                    `<button type="button" class="btn-submit preview-btn" data-doc-id="${doc.id}" disabled style="opacity: 0.5; cursor: not-allowed;">Preview</button>` : 
                                    `<span class="status-completed" style="display: inline-block; font-size: 15px; color: #ffffff;">✓</span>`}
                            </td>
                        </tr>
                    `;
                };

                // Attach input event listeners to row
                const attachInputListeners = (row) => {
                    const fileInput = row.querySelector('.document-file');
                    const remarksInput = row.querySelector('.remarks');

                    const updateRemarksRequired = () => {
                        const hasFile = fileInput?.files?.length > 0;
                        if (hasFile) {
                            remarksInput.placeholder = 'Remarks (Optional - file uploaded)';
                            remarksInput.removeAttribute('required');
                        } else {
                            remarksInput.placeholder = 'Remarks (Required)';
                            remarksInput.setAttribute('required', 'required');
                        }
                        updatePreviewButtonState(row);
                    };

                    if (fileInput) {
                        fileInput.addEventListener('change', updateRemarksRequired);
                    }

                    if (remarksInput) {
                        remarksInput.addEventListener('input', () => updatePreviewButtonState(row));
                    }

                    updateRemarksRequired();
                };

                // Function to display EMI form
                const displayEmiForm = () => {
                    const existingForm = document.getElementById('emiPaymentForm');
                    if (existingForm) existingForm.remove();

                    const basicTable = document.getElementById('basicDocumentRows')?.closest('table');
                    if (basicTable && !emiFormSaved) {
                        basicTable.insertAdjacentHTML('afterend', emiFormTemplate);

                        const emiStatus = document.getElementById('emiPaymentStatus');
                        const emiCountSection = document.getElementById('emiCountSection');
                        const saveEmiBtn = document.getElementById('saveEmiBtn');

                        emiStatus.addEventListener('change', (e) => {
                            if (e.target.value === 'yes') {
                                emiCountSection.style.display = 'block';
                            } else {
                                emiCountSection.style.display = 'none';
                            }
                        });

                        saveEmiBtn.addEventListener('click', saveEmiDetails);

                        setTimeout(() => {
                            document.getElementById('emiPaymentForm').scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }, 100);
                    }
                };

                // Save EMI details
                const saveEmiDetails = () => {
                    const emiStatus = document.getElementById('emiPaymentStatus').value;

                    if (!emiStatus) {
                        alert('Please select EMI payment status');
                        return;
                    }

                    if (emiStatus === 'yes') {
                        const withoutPenalty = document.getElementById('withoutPenaltyEmi').value;
                        const withPenalty = document.getElementById('withPenaltyEmi').value;

                        if (!withoutPenalty || !withPenalty) {
                            alert('Please enter both EMI counts');
                            return;
                        }
                    }

                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');
                    formData.append('applicant_id', applicantId);
                    formData.append('emi_status', emiStatus);

                    if (emiStatus === 'yes') {
                        formData.append('without_penalty_emi', document.getElementById('withoutPenaltyEmi')
                            .value);
                        formData.append('with_penalty_emi', document.getElementById('withPenaltyEmi').value);
                    }

                    fetch('/applicant/save-emi-details', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                emiFormSaved = true;
                                document.getElementById('emiPaymentForm').style.opacity = '0.7';
                                document.querySelectorAll('#emiPaymentForm input, #emiPaymentForm select')
                                    .forEach(el => {
                                        el.disabled = true;
                                    });
                                document.getElementById('saveEmiBtn').disabled = true;
                                document.getElementById('saveEmiBtn').textContent = 'Saved';

                                loadNextDocument('basic');
                            } else {
                                alert(data.message || 'Error saving EMI details');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error saving EMI details');
                        });
                };

                // Collect document data
                const collectDocumentData = (row) => {
                    return {
                        doc_no: row.querySelector('.doc-no')?.value || '',
                        day: row.querySelector('.day')?.value || '',
                        month: row.querySelector('.month')?.value || '',
                        year: row.querySelector('.year')?.value || '',
                        additional_info: row.querySelector('.additional-info')?.value || '',
                        remarks: row.querySelector('.remarks')?.value || '',
                        file: row.querySelector('.document-file')?.files[0]
                    };
                };

                // Show preview modal
                const showPreviewModal = (doc, row) => {
                    const docData = collectDocumentData(row);
                    const filePreview = docData.file ? generateFilePreview(docData.file) :
                        '<p>No file attached</p>';

                    const existingModal = document.getElementById('filePreviewModal');
                    if (existingModal) existingModal.remove();

                    document.body.insertAdjacentHTML('beforeend', modalTemplate(doc.name, filePreview,
                        docData));

                    document.getElementById('confirmFileBtn').addEventListener('click', () => {
                        submitDocument(doc.id, row, docData);
                        document.getElementById('filePreviewModal').remove();
                    });
                };

                // Submit document
                const submitDocument = async (docId, row, docData) => {
                    const doc = findDocumentById(docId);
                    const type = row?.dataset?.documentType;

                    console.log("Document ID:", docId, "| Type:", type);

                    const submitBtn = row.querySelector('.preview-btn');
                    const originalText = submitBtn.textContent;

                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Submitting...';

                    try {
                        const formData = new FormData();
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                            ?.content || '');
                        formData.append('applicant_id', applicantId);
                        formData.append('document_id', docId);
                        formData.append('document_type', type);
                        formData.append('document_key', doc?.key || '');

                        Object.entries(docData).forEach(([key, value]) => {
                            if (key !== 'file') formData.append(key, value);
                        });

                        if (docData.file) {
                            formData.append('document_file', docData.file);
                        }

                        const response = await fetch(submitUrl, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (!data.success) {
                            throw new Error(data.message || 'Upload failed');
                        }

                        const documentData = {
                            id: docId,
                            ...docData,
                            has_file: !!docData.file,
                            file_name: data.file_name || docData.file?.name || null
                        };

                        console.log("Upload Success:", documentData);

                        // Add to completed documents array FIRST
                        if (type === 'basic') {
                            if (!completedBasicDocs.some(d => d.id === docId)) {
                                completedBasicDocs.push(documentData);
                            }
                        } else if (type === 'nameTransfer') {
                            if (!completedNameTransferDocs.some(d => d.id === docId)) {
                                completedNameTransferDocs.push(documentData);
                            }
                        }

                        /* =========================
                           BASIC DOCUMENT WORKFLOW
                        ==========================*/
                        if (type === 'basic') {
                            const totalBasicDocs = documentConfigs.basic.length;
                            console.log(`Basic Progress: ${completedBasicDocs.length}/${totalBasicDocs}`);

                            if (docId === 2) {
                                console.log("Opening EMI Form");
                                displayEmiForm();
                                return;
                            }

                            if (completedBasicDocs.length >= totalBasicDocs) {
                                console.log("Basic Completed → Opening Name Transfer");

                                const nameTransferSection = document.getElementById('nameTransferSection');
                                if (nameTransferSection) {
                                    nameTransferSection.style.display = 'block';
                                }

                                // Reload the current table to show all completed rows with checkmarks
                                loadNextDocument('basic');
                            } else {
                                loadNextDocument('basic');
                            }
                        }
                        /* =========================
                           NAME TRANSFER WORKFLOW
                        ==========================*/
                        else if (type === 'nameTransfer') {
                            const totalTransferDocs = documentConfigs.nameTransfer.length;
                            console.log(
                                `Name Transfer Progress: ${completedNameTransferDocs.length}/${totalTransferDocs}`
                            );

                            if (completedNameTransferDocs.length >= totalTransferDocs) {
                                console.log("All Name Transfer Documents Completed");
                                alert("All documents submitted successfully.");

                                // Reload the current table to show all completed rows with checkmarks
                                loadNextDocument('nameTransfer');
                            } else {
                                loadNextDocument('nameTransfer');
                            }
                        }

                        updateProgress();
                        checkAllDocumentsCompleted();

                    } catch (error) {
                        console.error("Upload Error:", error);
                        alert(error.message || 'Error uploading document');
                    } finally {
                        // Don't re-enable the button if it was the last document
                        if (row && row.classList.contains('completed-row')) {
                            // Button is already handled by the row completion
                        } else {
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                        }
                    }
                };

                // Find document by ID
                const findDocumentById = (docId) => {
                    return [...documentConfigs.basic, ...documentConfigs.nameTransfer]
                        .find(d => d.id === docId);
                };

                // Load next document
                const loadNextDocument = (type) => {
                    const tbody = document.getElementById(
                        type === 'basic' ? 'basicDocumentRows' : 'additionalDocumentRows'
                    );
                    const documents = documentConfigs[type === 'basic' ? 'basic' : 'nameTransfer'];
                    const completedDocs = type === 'basic' ? completedBasicDocs : completedNameTransferDocs;

                    const nextIndex = completedDocs.length;

                    tbody.innerHTML = '';

                    // Add all completed rows with checkmarks
                    completedDocs.forEach((completedDoc, index) => {
                        const originalDoc = documents.find(d => d.id === completedDoc.id);
                        if (originalDoc) {
                            tbody.insertAdjacentHTML('beforeend',
                                createDocumentRow(originalDoc, index + 1, type, true, completedDoc));
                        }
                    });

                    // If there are more documents to complete, add the next one
                    if (nextIndex < documents.length) {
                        tbody.insertAdjacentHTML('beforeend',
                            createDocumentRow(documents[nextIndex], nextIndex + 1, type, false));

                        const newRow = tbody.querySelector(`tr[data-document-id="${documents[nextIndex].id}"]`);
                        if (newRow) {
                            attachInputListeners(newRow);
                            updatePreviewButtonState(newRow);
                        }

                        setTimeout(() => {
                            newRow?.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }, 100);
                    }
                    // If all documents are completed (no next document), just show all completed rows
                    else {
                        console.log(`All ${type} documents completed - showing final view with checkmarks`);

                        // Optionally add a completion message
                        if (type === 'nameTransfer') {
                            const tableContainer = tbody.closest('.table-container');
                            if (tableContainer && !document.getElementById('completionMessage')) {
                                const messageHtml = `
                    <div id="completionMessage" style="margin-top: 20px; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; color: #155724; text-align: center;">
                        <strong>✓ All documents have been successfully uploaded!</strong>
                    </div>
                `;
                                tableContainer.insertAdjacentHTML('afterend', messageHtml);
                            }
                        }
                    }
                };

                // Update progress
                const updateProgress = () => {
                    const totalBasic = documentConfigs.basic.length;
                    const totalNameTransfer = isNameTransfer ? documentConfigs.nameTransfer.length : 0;
                    const completedCount = completedBasicDocs.length + completedNameTransferDocs.length;
                    const totalDocs = totalBasic + totalNameTransfer;

                    const progressCount = document.getElementById('progressCount');
                    const progressBar = document.getElementById('progressBar');

                    if (progressCount) progressCount.textContent = `${completedCount}/${totalDocs}`;
                    if (progressBar) {
                        const percentage = totalDocs > 0 ? (completedCount / totalDocs) * 100 : 0;
                        progressBar.style.width = `${percentage}%`;
                    }
                };

                // Check if all documents completed
                const checkAllDocumentsCompleted = () => {
                    const totalBasic = documentConfigs.basic.length;
                    const totalNameTransfer = isNameTransfer ? documentConfigs.nameTransfer.length : 0;

                    const allBasicCompleted = completedBasicDocs.length === totalBasic;
                    const allNameTransferCompleted = !isNameTransfer || completedNameTransferDocs.length ===
                        totalNameTransfer;

                    if (allBasicCompleted && allNameTransferCompleted && emiFormSaved) {
                        enableSubmitButton();
                    }
                };

                // Enable submit button
                const enableSubmitButton = () => {
                    const submitBtn = document.getElementById('finalSubmitBtn');
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.classList.add('enabled');
                    }
                };

                // Event delegation for preview button only
                document.addEventListener('click', (e) => {
                    if (e.target.classList.contains('preview-btn') && !e.target.disabled) {
                        const docId = parseInt(e.target.dataset.docId);
                        const row = e.target.closest('tr');
                        const doc = findDocumentById(docId);
                        if (doc && row) showPreviewModal(doc, row);
                    }
                });

                // Setup name transfer section
                const setupNameTransfer = () => {
                    const nameTransferSection = document.getElementById('nameTransferSection');
                    const additionalSection = document.getElementById('additionalDocumentsSection');
                    const nameTransferSelect = document.getElementById('nameTransfer');

                    if (nameTransferSection) {
                        nameTransferSection.style.display = 'none';

                        if (nameTransferSelect) {
                            nameTransferSelect.addEventListener('change', (e) => {
                                isNameTransfer = e.target.value === 'yes';

                                if (isNameTransfer) {
                                    showNewAllotteeForm();
                                    additionalSection.style.display = 'block';
                                    completedNameTransferDocs = [];
                                } else {
                                    additionalSection.style.display = 'none';
                                    const existingForm = document.getElementById('newAllotteeForm');
                                    if (existingForm) existingForm.remove();
                                    completedNameTransferDocs = [];
                                    const tbody = document.getElementById('additionalDocumentRows');
                                    if (tbody) tbody.innerHTML = '';
                                }
                                updateProgress();
                            });
                        }
                    }
                };

                // Initialize
                const initialize = () => {
                    const basicTbody = document.getElementById('basicDocumentRows');
                    if (basicTbody) {
                        basicTbody.innerHTML = '';
                        loadNextDocument('basic');
                    }

                    setupNameTransfer();
                    updateProgress();
                };

                initialize();
            },

            // Step 6 initialization
            initializeStep6: function() {

            },

            validateStep: function() {
                const form = document.querySelector('#stepContent form');
                if (!form) return true;

                let valid = true,
                    firstInvalid = null;

                form.querySelectorAll('[required]').forEach(field => {
                    field.classList.remove('is-invalid');

                    const isEmpty = !field.value.trim();
                    const isInvalidEmail = field.type === 'email' && field.value &&
                        !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value);
                    const isInvalidPattern = field.pattern && field.value &&
                        !new RegExp(field.pattern).test(field.value);

                    if (isEmpty || isInvalidEmail || isInvalidPattern) {
                        field.classList.add('is-invalid');
                        valid = false;
                        if (!firstInvalid) firstInvalid = field;
                    }
                });

                if (firstInvalid) {
                    firstInvalid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

                return valid;
            },

            nextStep: function() {
                if (!this.validateStep()) {
                    this.showAlert('Please fill in all required fields correctly.', 'error');
                    return;
                }

                const nextBtn = document.getElementById('nextBtn');
                const spinner = document.getElementById('btnSpinner');
                const btnLabel = document.getElementById('btnLabel');

                nextBtn.disabled = true;
                spinner.style.display = 'block';
                btnLabel.textContent = 'Saving...';

                // Handle final submission
                if (this.config.currentStep === 6) {
                    this.submitApplication();
                    return;
                }

                const form = document.querySelector('#stepContent form');
                if (!form) {
                    this.loadStep(this.config.currentStep + 1);
                    nextBtn.disabled = false;
                    spinner.style.display = 'none';
                    btnLabel.innerHTML = 'Save & Continue';
                    return;
                }

                const formData = new FormData(form);
                formData.append('applicant_id', this.config.applicantId);

                fetch(this.config.steps[this.config.currentStep], {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.config.csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.showAlert(data.message, 'success');
                            if (data.applicant_id) {
                                this.config.applicantId = data.applicant_id;
                            }
                            if (data.next_step) {
                                this.loadStep(data.next_step);
                            } else if (this.config.currentStep < 6) {
                                this.loadStep(this.config.currentStep + 1);
                            }
                            console.log('Success Comes');
                        } else {
                            console.log('Error Comes');
                            const msg = data.errors ?
                                Object.values(data.errors).flat().join('<br>') :
                                'Error saving data. Please try again.';
                            this.showAlert(msg, 'error');
                        }
                    })
                    .catch(() => {
                        this.showAlert('An error occurred. Please try again.', 'error');
                    })
                    .finally(() => {
                        nextBtn.disabled = false;
                        spinner.style.display = 'none';
                        btnLabel.innerHTML = this.config.currentStep === 6 ? 'Submit Application' :
                            'Save & Continue';
                    });
            },

            prevStep: function() {
                if (this.config.currentStep > 1) {
                    this.loadStep(this.config.currentStep - 1);
                }
            },

            submitApplication: function() {
                fetch('{{ route('applicant.apply.step6.save') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.config.csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            applicant_id: this.config.applicantId,
                            final_submission: true
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.showAlert('Application submitted successfully!', 'success');
                            setTimeout(() => {
                                window.location.href =
                                    '{{ route('applicant.dataentry.scanned.files') }}';
                            }, 2000);
                        } else {
                            this.showAlert(data.message || 'Error submitting application.', 'error');
                        }
                    })
                    .catch(() => {
                        this.showAlert('Error submitting application. Please try again.', 'error');
                    });
            },

            showAlert: function(message, type = 'success') {
                showToast('Allottee Data Entry', message, type);
            },

            // Utility functions for specific features
            copyAddress: function() {
                const checkbox = document.getElementById('same_as_present');
                if (!checkbox) return;

                const fieldMap = [
                    ['present_address', 'permanent_address'],
                    ['post_office', 'permanent_post_office'],
                    ['police_station', 'permanent_police_station'],
                    ['state', 'permanent_state'],
                    ['district', 'permanent_district'],
                    ['pin_code', 'permanent_pin_code'],
                    ['telephone', 'permanent_telephone'],
                    ['mobile_number', 'permanent_mobile_number']
                ];

                fieldMap.forEach(([from, to]) => {
                    const fromEl = document.getElementById(from);
                    const toEl = document.getElementById(to);

                    if (fromEl && toEl) {
                        toEl.value = checkbox.checked ? fromEl.value : '';
                    }
                });
            },


            togglePanAadhar: function() {

                const yearInput = document.getElementById('allotment_year');
                const panField = document.getElementById('pan-field');
                const aadharField = document.getElementById('aadhar-field');
                const panInput = document.getElementById('pan_card_number');
                const aadharInput = document.getElementById('aadhar_card_number');

                if (!yearInput || !panField || !aadharField) return;

                // Direct number conversion (no Date object needed)
                const year = yearInput.value ? parseInt(yearInput.value) : null;

                const show = year && year >= 2009;

                panField.style.display = show ? 'block' : 'none';
                aadharField.style.display = show ? 'block' : 'none';
            }
        };

        // Initialize on DOM ready
        document.addEventListener('DOMContentLoaded', () => {
            window.app.init();
        });
    </script>
@endsection
