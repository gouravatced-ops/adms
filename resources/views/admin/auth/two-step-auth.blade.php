@extends('admin.auth.layouts.main')

@section('content')
    @if (session('error'))
        <div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">Error</div>
                <small>Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="mx-auto mt-12 mt-2">
        <h5 class="mb-1">Two Step Verification </h5>
        <p class="text-start mb-6">
            We sent a verification code to your email Id <span
                class="fw-medium text-heading">{{ session('username') }}</span>. Enter the code from the Email Id in the
            field below.

        </p>
        <p class="mb-0">Type your 6 digit security code</p>
        <form id="twoStepsForm" action="{{ route('admin.verifyOtp') }}" method="POST"
            class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
            @csrf
            <div class="mb-6 fv-plugins-icon-container">
                <div class="auth-input-wrapper d-flex align-items-center justify-content-between numeral-mask-wrapper">
                    <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                        maxlength="1" autofocus="">
                    <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                        maxlength="1">
                    <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                        maxlength="1">
                    <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                        maxlength="1">
                    <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                        maxlength="1">
                    <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                        maxlength="1">
                </div>
                <input type="hidden" name="otp">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
            </div>
            <button class="btn btn-primary d-grid w-100 py-6">
                Verify my account
            </button>
            <input type="hidden">
        </form>
        <form action="{{ route('admin.AdminResendOtp') }}" method="post" class="mt-3">
            @csrf
            <div class="text-center">Didn't get the code?
                <input type="hidden" name="username" value="{{ session('username') }}">
                <input type="submit" value="Resend" id="resend"  style="pointer-events: none; opacity: 0.5;" class="disabled"><br />
                <span id="countdown"></span>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var countdownDuration = 2 * 60; // 2 minutes in seconds
            var $countdownElement = $('#countdown');
            var $resendElement = $('#resend');

            var countdownInterval = setInterval(function() {
                var minutes = Math.floor(countdownDuration / 60);
                var seconds = countdownDuration % 60;
                $countdownElement.text(
                    "Resend available in " +
                    (minutes < 10 ? '0' + minutes : minutes) + ":" +
                    (seconds < 10 ? '0' + seconds : seconds)
                );
                countdownDuration--;
                if (countdownDuration < 0) {
                    clearInterval(countdownInterval);
                    $countdownElement.text(''); // Clear the countdown text
                    $resendElement.removeClass('disabled').css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });
                }
            }, 1000);
        });
    </script>
@endpush
