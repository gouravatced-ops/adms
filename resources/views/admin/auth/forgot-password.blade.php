{{-- {{ dd(session('verifyError')) }} --}}
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
        </div>
    @endif

    <div class="mx-auto">
        <p class="mb-4">Forgot Password.</p>
        @if (session('success') || session('verifyError'))
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <small>{{ session('success') }}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <p class="mb-4">Type your 6 digit security code</p>
            <form id="twoStepsForm" action="{{ route('admin.forgot-password-verify') }}" method="POST"
                class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                @csrf
                <div class="mb-6 fv-plugins-icon-container">
                    <div class="auth-input-wrapper d-flex align-items-center justify-content-between numeral-mask-wrapper">
                        <input type="tel"
                            class="form-control {{ session('verifyError') ? 'is-invalid' : '' }} auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                            maxlength="1" autofocus="">
                        <input type="tel"
                            class="form-control {{ session('verifyError') ? 'is-invalid' : '' }} auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                            maxlength="1">
                        <input type="tel"
                            class="form-control {{ session('verifyError') ? 'is-invalid' : '' }} auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                            maxlength="1">
                        <input type="tel"
                            class="form-control {{ session('verifyError') ? 'is-invalid' : '' }} auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                            maxlength="1">
                        <input type="tel"
                            class="form-control {{ session('verifyError') ? 'is-invalid' : '' }} auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                            maxlength="1">
                        <input type="tel"
                            class="form-control {{ session('verifyError') ? 'is-invalid' : '' }} auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                            maxlength="1">
                    </div>
                    <input type="hidden" name="otp">
                    @if (session('verifyError'))
                        <span class="text-danger ">{{ session('verifyError') }}</span>
                    @endif
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>
                <button class="btn btn-primary d-grid w-100 py-6">
                    Reset Password
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
        @else
            @if (session('notValid'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <small>{{ session('notValid') }}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form id="forgotForm" action="{{ route('admin.forgotPassAdminOtp') }}" method="POST"
                class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                @csrf
                <div class="form-group my-3">
                    <label for="username">Email Id</label>
                    <input type="username" class="form-control @error('username') is-invalid @enderror" id="username"
                        required name="username" :value="old('username')" placeholder="Enter your username" autofocus />

                    @error('username')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <button class="btn btn-info d-grid w-100 py-6">
                    Reset Password
                </button>
                <input type="hidden">
            </form>
        @endif

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            var countdownDuration = 1 * 60; // 2 minutes in seconds
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
