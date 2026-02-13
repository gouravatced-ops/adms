@extends('applicant.auth_layouts.main')

@section('title', 'Forget Password ' . config('config-system.app_name'))

@section('content')
@if (session('success') || session('verifyError'))
<div class="glass-form">

    {{-- Header --}}
    <div class="administration-header d-flex align-items-center justify-content-between">
        <div class="administration-title">
            <h1>{{ config('config-system.app_name') }}</h1>
        </div>
        <div class="administration-logo">
            <img src="{{ asset(config('config-system.logo')) }}" alt="EDMS Logo" class="img-fluid" height="50">
        </div>
    </div>

    <div class="page-header">
        <p>Type your 6-digit security code to reset your password</p>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('verifyError'))
    <div class="alert alert-danger">{{ session('verifyError') }}</div>
    @endif

    {{-- OTP Form --}}
    <form action="{{ route('applicant-forgot-password-verify') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label w-100">Enter OTP</label>

            <div class="d-flex justify-content-between otp-input-wrapper">
                @for ($i = 0; $i < 6; $i++) <input type="tel" maxlength="1"
                    class="form-control otp-input text-center mx-1 {{ session('verifyError') ? 'is-invalid' : '' }}">
                    @endfor
            </div>

            <input type="hidden" name="otp">
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary w-100">
                Verify OTP
            </button>
        </div>

        <div class="text-center mt-3">
            <span class="text-muted">Didn’t receive the code?</span>
            <a href="javascript:void(0);" class="btn btn-link p-2">Resend OTP</a>
        </div>

    </form>
</div>

@else
<div class="glass-form">
    {{-- Header --}}
    <div class="administration-header d-flex align-items-center justify-content-between">
        <div class="administration-title">
            <h1>{{ config('config-system.app_name') }}</h1>
        </div>
        <div class="administration-logo">
            <img src="{{ asset(config('config-system.logo')) }}" alt="EDMS Logo" class="img-fluid" height="50">
        </div>
    </div>

    <div class="page-header">
        <p>Enter your registered Email</p>
    </div>

    {{-- Alert --}}
    @if (session('notValid'))
    <div class="alert alert-danger">{{ session('notValid') }}</div>
    @endif

    <form action="{{ route('forgotPassApplicantOtp') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Email</label>
            <div class="input-group">
                <div class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="5" width="18" height="14" rx="2" />
                        <polyline points="3 7 12 13 21 7" />
                    </svg>
                </div>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
            </div>
        </div>

        <div class="form-group mt-3">
            <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div>
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary w-100">
                Send OTP
            </button>
        </div>
    </form>
    <div class="text-center mt-3">
        <a href="/" class="btn btn-outline-secondary">
            ← Back to Home
        </a>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/two-factor-auth-pages.js') }}"></script>
@endpush