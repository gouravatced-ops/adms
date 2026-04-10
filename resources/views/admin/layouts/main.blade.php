<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('/assets/admin/') }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>JSHB - Dashboard</title>

    <meta name="description" content="JSPC" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin/assets/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/assets/vendor/libs/select2/select2.css') }} " />
    {{-- Multi select css --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/assets/vendor/libs/DataTables/datatables.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/assets/vendor/fonts/boxicons.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/admin/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/admin/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />

    <link rel="stylesheet"
        href="{{ asset('assets/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}s" />
    <link rel="stylesheet" href="{{ asset('assets/admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <script src="{{ asset('assets/admin/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/config.js') }}"></script>

    <link rel="stylesheet" type="text/css" href='{{ asset('assets/jspc-loader.css') }}'>
    <link rel="stylesheet" type="text/css" href='{{ asset('assets/css/custom.css') }}'>
</head>
<style>
    .invert-text-white {
        color: #0380ec !important;
    }
</style>

<body style="background-color: #f6f4f5;">
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand">
                    <a href="" class="app-brand-link">
                        <span class="app-brand-logo">
                            <img src="{{ asset(config('config-system.logo')) }}" width="45">
                        </span>
                        <span class="app-brand-text  menu-text fw-bold ms-2">JSHB</span>
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none bg-info">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                @include('admin/layouts/menus')

            </aside>

            <div class="layout-page">

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <!-- For larger screens -->
                            <div class="nav-item d-none d-md-flex">
                                Welcome, <strong class="mx-1">{{ auth('admin')->user()->admin_name }}</strong>
                                @if (auth('admin')->user()->role === 'council_office')
                                    (Sub-Admin)
                                @endif
                                @if (auth('admin')->user()->role === 'superadmin')
                                    (Admin)
                                @endif
                                to Allottee Data Management System
                            </div>

                            <!-- For mobile screens -->
                            <div class="nav-item d-flex d-md-none">
                                Welcome, <strong class="mx-1">{{ auth('admin')->user()->admin_name }}</strong>
                                to Allottee Data Management System
                            </div>
                        </div>


                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            @if(auth('admin')->user()->role === 'approver')
                            <strong>({{getDivisionName(auth('admin')->user()->division_id)}})</strong>
                            @endif
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ !empty(auth()->user()->adminDetails->profile_pic) ? asset(auth()->user()->adminDetails->profile_pic) : asset(config('config-system.logo')) }}"
                                            alt class="w-px-40 h-auto rounded-circle"
                                            style="height: 33px !important;" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ !empty(auth()->user()->profile_path) ? asset(auth()->user()->profile_path) : asset(config('config-system.logo')) }}"
                                                            alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-medium d-block">{{ auth('admin')->user()->admin_name }}</span>
                                                    <small class="text-muted">
                                                        @if (auth('admin')->user()->role === 'council_office')
                                                            SUB ADMIN
                                                        @endif
                                                        @if (auth('admin')->user()->role === 'approver')
                                                            JSHB APPROVER
                                                        @endif
                                                        @if (auth('admin')->user()->role == 'superadmin')
                                                            ADMIN
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.my-setting') }}">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <li>
                                            <button type="submit" class="dropdown-item">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Log Out</span>
                                            </button>

                                        </li>
                                    </form>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="content-wrapper">
                    @yield('admin-content')
                    <footer class="content-footer navbar-detached footer bg-footer-theme">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column text-center">
                            <div class="mb-2 mb-md-0">
                                Copyright ® 2025-
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>| Jharkhand State Housing Board , Technology Partner <img
                                    src="{{ asset(config('config-system.patrnterFooterLogo')) }}" width="30px"
                                    alt="ced"> <b><a href="https://www.computered.in/" target="_blank"
                                        class="footer-link fw-medium">ComputerEd</a></b>. All rights reserved.
                            </div>
                        </div>
                    </footer>

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <script src="{{ asset('assets/admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/vendor/js/menu.js') }}"></script>

    <script src="{{ asset('assets/admin/assets/vendor/libs/DataTables/datatables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="{{ asset('assets/admin/assets/vendor/libs/select2/select2.js') }}"></script>

    <script src="{{ asset('assets/admin/js/form.js') }}"></script>
    <script>
        $('form').on('submit', function(e) {
            // Show loader
            $("#jspc-loader").removeClass('d-none');
            $("#loading-text").text("Please Wait...");
        });
    </script>
    <script>
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => el.remove());
        }, 3000);
    </script>
    @stack('script')

    <script src="{{ asset('assets/admin/assets/js/main.js') }}"></script>
</body>

</html>
