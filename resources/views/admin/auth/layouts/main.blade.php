<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>JSHB - Admin Login</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin/assets/img/favicon/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/admin/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/admin/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />

    <link rel="stylesheet" type="text/css" href='{{ asset(' assets/jspc-loader.css') }}'>
    <script src="{{ asset('assets/admin/assets/vendor/js/helpers.js') }}"></script>
</head>
@php
    $defaultTheme = config('config-system.defaultTheme');
    $projectTheme = config("config-system.dashboardThemes.$defaultTheme");

    // $themes = config('config-system.dashboardThemes');
    // $themeKey = array_rand($themes);
    // $projectTheme = $themes[$themeKey];
@endphp
<style>
    :root {
        --primary-color: {{ $projectTheme['primary-color'] }};
        --primary-hover: {{ $projectTheme['primary-hover'] }};

        --sidebar-bg: {{ $projectTheme['sidebar-bg'] }};
        --sidebar-secondary: {{ $projectTheme['sidebar-secondary'] }};
        --sidebar-hover: {{ $projectTheme['sidebar-hover'] }};
        --sidebar-active: {{ $projectTheme['sidebar-active'] }};
        --sidebar-active-secondary: {{ $projectTheme['sidebar-active-secondary'] }};
    }
</style>
<style>
    /* ===== BODY BACKGROUND ===== */
    .auth-body {
        min-height: 100vh;
        background: linear-gradient(-45deg, #0d6efd, #6610f2, #198754, #0dcaf0);
        background-size: 400% 400%;
        animation: gradientBG 12s ease infinite;
        font-family: 'Inter', sans-serif;
    }

    .auth-body {
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        position: relative;
        overflow: hidden;
    }

    /* Animated Background Pattern */
    .auth-body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image:
            radial-gradient(circle at 25% 25%, rgba(249, 115, 22, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(6, 182, 212, 0.06) 0%, transparent 50%),
            radial-gradient(circle at 50% 50%, rgba(255, 107, 107, 0.05) 0%, transparent 50%);
        opacity: 1;
        z-index: 0;
    }

    /* White Background */
    .auth-body {
        position: relative;
        background: #eae8e8;
        overflow: hidden;
    }

    /* Mesh Gradient Overlay */
    .auth-body::after {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(45deg,
                transparent 30%,
                rgba(249, 115, 22, 0.04) 30%,
                rgba(249, 115, 22, 0.04) 70%,
                transparent 70%),
            linear-gradient(-45deg,
                transparent 30%,
                rgba(6, 182, 212, 0.03) 30%,
                rgba(6, 182, 212, 0.03) 70%,
                transparent 70%);
        background-size: 60px 60px;
        opacity: 1;
        z-index: 0;
        pointer-events: none;
        animation: meshMove 20s linear infinite;
    }


    /* Animation */
    @keyframes meshMove {
        from {
            background-position: 0 0, 0 0;
        }

        to {
            background-position: 200px 200px, -200px -200px;
        }
    }

    /* ===== BACKGROUND ANIMATION ===== */
    @keyframes gradientBG {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* ===== LOGIN CARD ===== */
    .login-card {
        max-width: 1200px;
        width: 100%;
        overflow: hidden;
        background: #ffffff;
    }

    /* ===== RIGHT PANEL ===== */
    .auth-right {
        background: linear-gradient(180deg, var(--sidebar-bg) 0%, var(--sidebar-secondary) 100%);
        position: relative;
    }

    .auth-right::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='400' height='400' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='200' cy='200' r='180'/%3E%3C/g%3E%3C/svg%3E");
    }

    /* ===== LOGO ===== */
    .auth-logo {
        max-width: 140px;
    }

    /* ===== FORM INPUT POLISH ===== */
    .form-control {
        border-radius: 10px;
        padding: 12px 14px;
    }

    .btn-primary {
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .login-card {
            margin: 1rem;
        }

        .auth-right {
            display: none;
        }
    }

    /* LOGIN HEADER */
    .login-header {
        gap: 12px;
    }

    /* LOGO CONTAINER */
    .login-logo {
        background: #ffffff;
        padding: 10px;
        border-radius: 12px;
        box-shadow:
            0 8px 20px rgba(255, 255, 255, 0.6),
            0 4px 12px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* LOGO IMAGE */
    .login-logo img {
        max-height: 100px;
        width: auto;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.25));
        image-rendering: auto;
    }

    .login-header {
        justify-content: space-between;
    }

    .brand-logo {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        border: 3px solid rgba(249, 115, 22, 0.3);
    }

    /* TITLE TEXT */
    .login-header h4 {
        line-height: 1.2;
    }

    .login-header small {
        font-size: 0.85rem;
    }

    /* LEFT FORM FOOTER */
    .form-left-footer {
        margin-top: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
        text-align: center;
        border-top
    }

    /* LABEL */
    .footer-label {
        font-size: 0.9rem;
        color: #6c757d;
    }

    /* LOGO IMAGE */
    .footer-logo {
        width: 35px;
        height: auto;
        border-radius: 6px;
    }

    /* BRAND LINK */
    .footer-brand {
        text-decoration: none;
    }

    /* BRAND TEXT */
    .footer-brand-text {
        color: #ff00ff;
        font-family: old-bookmark, serif;
        font-size: 16px;
        transition: opacity 0.3s ease;
    }

    /* HOVER EFFECT */
    .footer-brand:hover .footer-brand-text {
        opacity: 0.8;
    }

    /* MOBILE STACK */
    @media (max-width: 576px) {
        .form-left-footer {
            gap: 6px;
            font-size: 0.85rem;
        }
    }

    /* LEFT COLUMN WRAPPER */
    .form-left-wrapper {
        align-items: stretch;
        gap: 24px;
    }

    /* FORM CONTENT */
    .form-left-content {
        flex: 1;
    }

    /* HEADER */
    .login-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 0.5rem;
    }

    /* LOGO */
    .login-logo {
        padding: 8px;
        border-radius: 12px;
    }

    .login-logo img {
        width: 45px;
    }

    /* HIDE RIGHT PANEL ON MOBILE */
    @media (max-width: 768px) {
        .auth-right {
            display: none;
        }
    }
</style>

<body class="auth-body">

    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="card login-card shadow-lg border-0">
            <div class="row g-0">

                <!-- LEFT SIDE : LOGIN FORM -->
                <div class="col-md-7 form-left-wrapper p-4">
                    <div class="form-left-content">
                        <!-- TITLE + LOGO -->
                        <div class="login-header">
                            <div>
                                <h4 class="fw-bold mb-0">{{ config('config-system.full_app_name') }}</h4>
                            </div>
                            <div class="login-logo">
                                <img src="{{ asset(config('config-system.logo')) }}" alt="Logo">
                            </div>
                        </div>

                        @yield('content')
                    </div>

                    <!-- SIDE FOOTER -->
                    <div class="form-left-footer">
                        <span class="footer-label">Technology Partner</span>

                        <img src="{{ asset(config('config-system.patrnterFooterLogo')) }}" alt="Technology Partner Logo"
                            class="footer-logo">

                        <a href="https://www.computered.in/" target="_blank" rel="noopener noreferrer"
                            class="footer-brand">
                            <span class="footer-brand-text"><b>COMPUTER Ed.</b></span>
                        </a>
                    </div>
                </div>



                <!-- RIGHT SIDE : LOGO + TITLE -->
                <div class="col-md-5 auth-right d-flex align-items-center justify-content-center text-center">
                    <div>
                        <img src="{{ asset(config('config-system.logo')) }}" alt="Logo"
                            class="brand-logo mb-4 auth-logo" style="background-color: white;">

                        <h3 class="fw-bold text-white mb-2">{{ config('config-system.full_app_name') }}</h3>
                        <p class="text-white-50 px-3">
                            Manage your resources efficiently with our powerful admin tools
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

<script src="{{ asset('assets/admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/admin/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/admin/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/admin/assets/js/main.js') }}"></script>
<script src="{{ asset('assets/admin/js/two-factor-auth-pages.js') }}"></script>
@stack('scripts')
</body>

</html>
