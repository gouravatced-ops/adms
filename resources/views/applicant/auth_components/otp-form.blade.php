@extends('applicant.auth_layouts.main')

@section('title', 'User OTP ' . config('config-system.app_name'))

@section('content')
<div class="glass-form">
    <div class="administration-header d-flex align-items-center justify-content-between">

        <!-- Left Side : Heading -->
        <div class="administration-title">
            <h1>{{ config('config-system.app_name') }}</h1>
        </div>

        <!-- Right Side : Logo -->
        <div class="administration-logo">
            <img src="{{ asset(config('config-system.logo')) }}" alt="EDMS Logo" class="img-fluid" loading="lazy"
                height="50">
        </div>

    </div>

    <div class="page-header">
        <p>Please enter the OTP to access your dashboard</p>
    </div>

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('verifyLogin.otp') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Username (E-mail)</label>
            <div class="input-group">
                <div class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M6 20c0-3.3 5.3-5 6-5s6 1.7 6 5" />
                    </svg>
                </div>
                <input type="email" name="username" class="form-control" value="{{ session('mobile_number') }}"
                    disabled>
            </div>
        </div>
        <input type="hidden" name="mobile_number" value="{{ session('mobile_number') }}">
        <div class="form-group">
            <label class="form-label d-flex justify-content-between">
                <span>OTP <span class="text-danger">*</span></span>
            </label>
            <div class="input-group">
                <div class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="5" y="11" width="14" height="10" rx="2" ry="2" />
                        <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                    </svg>
                </div>
                <input type="text" name="otp" class="form-control" pattern="[0-9]{6}" maxlength="6"
                    placeholder="Enter your otp">
            </div>
        </div>
        <div class="form-group mt-4">
            <!-- Sign In Button -->
            <button type="submit" class="btn btn-primary w-100">
                Verify OTP
                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.2929 4.29289C12.6834 3.90237 13.3166 3.90237 13.7071 4.29289L20.7071 11.2929C21.0976 11.6834 21.0976 12.3166 20.7071 12.7071L13.7071 19.7071C13.3166 20.0976 12.6834 20.0976 12.2929 19.7071C11.9024 19.3166 11.9024 18.6834 12.2929 18.2929L17.5858 13H4C3.44772 13 3 12.5523 3 12C3 11.4477 3.44772 11 4 11H17.5858L12.2929 5.70711C11.9024 5.31658 11.9024 4.68342 12.2929 4.29289Z"
                            fill="#ffffff"></path>
                    </g>
                </svg>
            </button>
        </div>
    </form>
    <form action="{{ route('resend.otp') }}" method="POST">
        @csrf
        <input type="hidden" name="mobile_number" value="{{ session('mobile_number') }}">

        <div class="text-center mt-3">
            <button type="submit" class="btn btn-link" id="resendBtn" disabled>
                Resend OTP
            </button>

            <div id="countdown" class="text-muted small mt-1">
                Resend available in 01:00
            </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {

    let duration = 60; // 1 minute in seconds
    const $countdown = $('#countdown');
    const $resendBtn = $('#resendBtn');

    const timer = setInterval(function () {

        let minutes = Math.floor(duration / 60);
        let seconds = duration % 60;

        $countdown.text(
            'Resend available in ' +
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0')
        );

        duration--;

        if (duration < 0) {
            clearInterval(timer);
            $countdown.text('');
            $resendBtn.prop('disabled', false); // enable button
        }

    }, 1000);

});
</script>
@endpush