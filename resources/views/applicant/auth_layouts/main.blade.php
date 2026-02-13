<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>@yield('title')</title>
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="apple-touch-icon.html">
  <link rel="shortcut icon" type="image/x-icon" href='{{ asset(config('config-system.faviconIcon')) }}'>
  <link rel="stylesheet" type="text/css" href='{{ asset('assets/applicant/auth/css/bootstrap.min.css') }}'>
  <link rel="stylesheet" type="text/css" href='{{ asset('assets/applicant/auth/css/all.min.css') }}'>
  <link rel="stylesheet" type="text/css" href='{{ asset('assets/applicant/auth/css/fonts.googleapis.css') }}'>

  <link rel="stylesheet" type="text/css" href='{{ asset('assets/jspc-loader.css') }}'>
  <link rel="stylesheet" type="text/css" href='{{ asset('assets/applicant/auth/css/login.css') }}'>
  <link rel="stylesheet" type="text/css" href='{{ asset('assets/applicant/auth/css/loader.css') }}'>
</head>

<style>
  .hero-slider {
    position: relative;
  }
</style>
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
<body>
  <div class="login-page">
    <!-- Floating Particles -->
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="login-container">
      <!-- <h2 class="page-title">Admin Panel</h2> -->
      <div class="login-card">
        <div class="row g-0">
          <div class="col-md-7">
            <div class="form-left">
              @yield('content')
              <div class="form-left-footer d-flex align-items-center justify-content-center gap-2">
                <span class="footer-label">Technology Partner</span>
                <img src="{{ asset(config('config-system.patrnterFooterLogo')) }}" alt="" srcset=""
                  style="width: 35px;">
                <a href="https://www.computered.in/" target="_blank" rel="noopener noreferrer" class="footer-brand">
                  <span style="color:#ff00ff; font-family: old-bookmark;font-size: 16px;"><b>COMPUTER Ed.</b></span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-5 d-none d-md-block form-right">
            <div class="form-right1">
              <a href="#" target="_blank" rel="noopener noreferrer"><img
                  src="{{ asset(config('config-system.logo')) }}" alt="Logo"
                  class="brand-logo logo-container"></a>
              <div class="info-section">
                <h4>{{ config('config-system.organization') }}</h4>
                <p>Manage your resources efficiently with our powerful admin tools</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/applicant/auth/js/bootstrap.bundle.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
  @stack('scripts')
</body>

</html>