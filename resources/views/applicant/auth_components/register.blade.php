@extends('applicant.auth_layouts.main')

@section('title', 'Login Portal For User | ' . config('config-system.app_name'))

@section('content')
    <style>
        /* Captcha image fade */
        .captcha-image {
            display: inline-block;
            transition: opacity 0.3s ease;
        }

        .fade-out {
            opacity: 0;
        }

        .fade-in {
            opacity: 1;
        }

        /* Loader */
        .captcha-loader {
            width: 28px;
            height: 28px;
            border: 3px solid #e5e7eb;
            border-top: 3px solid #6366f1;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        /* Refresh button */
        .captcha-refresh-btn {
            cursor: pointer;
            transition: transform 0.25s ease;
        }

        .captcha-refresh-btn:hover {
            transform: rotate(90deg);
        }

        /* Spinner animation */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .d-none {
            display: none;
        }
    </style>
    <div class="glass-form">
        <!-- Administration Header with Logo and Title -->
        <div class="administration-header">
            <!-- Left Side: App Title -->
            <div class="administration-title">
                <h1>{{ config('config-system.app_name') }}</h1>
            </div>

            <!-- Right Side: Logo -->
            <div class="administration-logo">
                <img src="{{ asset(config('config-system.logo')) }}" alt="{{ config('config-system.app_name') }} Logo"
                    class="img-fluid" loading="lazy" width="60" height="60">
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="page-header">
            <p>Please sign in to access your dashboard</p>
        </div>

        <!-- Error Alert -->
        @if (session('LoginError'))
            <div class="alert alert-danger" role="alert">
                {{ session('LoginError') }}
            </div>
        @endif

        <!-- Success Alert (if needed) -->
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login.submit') }}" method="POST" autocomplete="on">
            @csrf

            <!-- Email/Username Field -->
            <div class="form-group">
                <label class="form-label" for="username">
                    Username (E-mail) <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-text" aria-label="User icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <input type="email" name="username" class="form-control @error('username') is-invalid @enderror"
                        id="username" placeholder="Enter your email address" value="{{ old('username') }}" required
                        autocomplete="email" aria-label="Username or Email" aria-required="true">
                </div>
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label class="form-label" for="password">
                    Password <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-text" aria-label="Lock icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        id="password" placeholder="Enter your password" required autocomplete="current-password"
                        aria-label="Password" aria-required="true">

                    <!-- Toggle Password Visibility Button -->
                    <button type="button" id="togglePassword" class="input-group-text"
                        aria-label="Toggle password visibility">
                        <!-- Eye Icon (Show Password) -->
                        <svg id="eyeOpen" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="20"
                            height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>

                        <!-- Eye Slash Icon (Hide Password) -->
                        <svg id="eyeSlash" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24">
                            </path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Captcha Field -->
            <div class="form-group mt-3">
                <label class="form-label">
                    Captcha <span class="text-danger">*</span>
                </label>

                <div class="input-group captcha-group">
                    <!-- Captcha Image -->
                    <span class="input-group-text p-1 bg-white">
                        <span id="captcha-img" class="captcha-image">
                            {!! captcha_img('flat') !!}
                        </span>

                        <!-- Loader -->
                        <span id="captcha-loader" class="captcha-loader d-none"></span>
                    </span>

                    <!-- Captcha Input -->
                    <input type="text" name="captcha" class="form-control @error('captcha') is-invalid @enderror"
                        placeholder="Enter captcha" required>

                    <!-- Refresh Button (Input Group Button) -->
                    <button type="button" class="input-group-text captcha-refresh-btn" id="reload-captcha"
                        aria-label="Refresh captcha">
                        &#x21bb;
                    </button>
                </div>

                @error('captcha')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <!-- Remember Me Checkbox (Optional) -->
            {{-- Uncomment if you want a Remember Me option
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" 
                       type="checkbox" 
                       name="remember" 
                       id="remember"
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>
        </div>
        --}}

            <!-- Sign In Button -->
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary w-100">
                    <span>Sign In</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.2929 4.29289C12.6834 3.90237 13.3166 3.90237 13.7071 4.29289L20.7071 11.2929C21.0976 11.6834 21.0976 12.3166 20.7071 12.7071L13.7071 19.7071C13.3166 20.0976 12.6834 20.0976 12.2929 19.7071C11.9024 19.3166 11.9024 18.6834 12.2929 18.2929L17.5858 13H4C3.44772 13 3 12.5523 3 12C3 11.4477 3.44772 11 4 11H17.5858L12.2929 5.70711C11.9024 5.31658 11.9024 4.68342 12.2929 4.29289Z"
                            fill="currentColor">
                        </path>
                    </svg>
                </button>
            </div>
        </form>

        <!-- Forgot Password Link -->
        <div class="text-center mt-3">
            <a href="{{ route('forgot-password') }}" class="text-decoration-none" aria-label="Forgot password link">
                <svg fill="currentColor" height="16px" width="16px" viewBox="0 0 512 512"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M499.5,385.4L308.9,57.2c-31.8-52.9-74.1-52.9-105.9,0L12.5,385.4c-31.8,52.9,0,95.3,63.5,95.3h360 C499.5,480.7,531.3,438.3,499.5,385.4z M298.4,438.3h-84.7v-84.7h84.7V438.3z M298.4,311.3h-84.7V120.7h84.7V311.3z">
                    </path>
                </svg>
                <span>Forgot Password?</span>
            </a>
        </div>

        <!-- Additional Links (Optional) -->
        {{-- Uncomment if you need registration or help links
    <div class="form-group text-center mt-2">
        <small class="text-muted">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-primary">Sign up</a>
        </small>
    </div>
    --}}
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeSlash = document.getElementById('eyeSlash');

            if (togglePassword && passwordInput && eyeOpen && eyeSlash) {
                togglePassword.addEventListener('click', function() {
                    // Toggle password visibility
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle icon visibility
                    if (type === 'text') {
                        eyeOpen.style.display = 'block';
                        eyeSlash.style.display = 'none';
                    } else {
                        eyeOpen.style.display = 'none';
                        eyeSlash.style.display = 'block';
                    }
                });
            }
        });
    </script>
    <script>
        document.getElementById('reload-captcha').addEventListener('click', function() {
            const imgBox = document.getElementById('captcha-img');
            const loader = document.getElementById('captcha-loader');
            const btn = this;

            btn.disabled = true;
            imgBox.classList.add('fade-out');
            loader.classList.remove('d-none');

            fetch("{{ route('captcha.reload') }}")
                .then(res => res.json())
                .then(data => {
                    setTimeout(() => {
                        imgBox.innerHTML = data.captcha;

                        loader.classList.add('d-none');
                        imgBox.classList.remove('fade-out');
                        imgBox.classList.add('fade-in');

                        setTimeout(() => {
                            imgBox.classList.remove('fade-in');
                            btn.disabled = false;
                        }, 300);
                    }, 300);
                });
        });
    </script>
@endpush
