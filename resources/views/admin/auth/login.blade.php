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
    @if (session('LoginError'))
        <div class="alert alert-danger">
            {{ session('LoginError') }}
        </div>
    @endif
    <p class="mb-4">Please sign-in to your account.</p>
    <form id="formAuthentication" class="mb-3 needs-validation was-validated" novalidate="novalidate" method="POST"
        action="{{ route('admin.login') }}">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username (E-mail) </label>
            <input type="username" class="form-control @error('username') is-invalid @enderror" id="username" required
                name="username" :value="old('username')" placeholder="Enter your username" autofocus />

            @error('username')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
            </div>
            <div class="input-group input-group-merge">
                <input type="password" id="password" required class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" autocomplete="current-password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="captcha">Captcha</label>
            </div>

            <div class="input-group input-group-merge">
                <!-- Captcha Image -->
                <span class="input-group-text p-1" id="captcha-image">
                    {!! captcha_img('flat') !!}
                </span>

                <!-- Captcha Input -->
                <input type="text" id="captcha" name="captcha" required
                    class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter captcha"
                    aria-describedby="captcha" autocomplete="off" />

                <!-- Refresh Button -->
                <span class="input-group-text cursor-pointer" id="reload-captcha">
                    <i class="bx bx-refresh"></i>
                </span>
            </div>

            @error('captcha')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
        </div>
    </form>
    <span>Forget Password</span><a href="{{ route('admin.forgot-password') }}">
        <span>Click Here</span>
    </a>
    <script>
        document.getElementById('reload-captcha').addEventListener('click', function() {
            fetch("{{ route('captcha.reload') }}")
                .then(res => res.json())
                .then(data => {
                    document.getElementById('captcha-image').innerHTML = data.captcha;
                });
        });
    </script>
@endsection
