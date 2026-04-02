<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Add this if not already present -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Official Government Housing Board Management System - Application tracking, property allotment, and payment management">
    <meta name="keywords"
        content="housing board, government housing, property allotment, EWS, MIG, HIG, residential, commercial">
    <meta name="author" content="Government Housing Board">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href='{{ asset(config('config-system.faviconIcon')) }}'>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2563EB">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Housing Board Management System">
    <meta property="og:description" content="Official Government Housing Board Management Portal">
    <meta property="og:image" content="/assets/og-image.png">
    <meta property="og:url" content="https://housingboard.gov.in">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Housing Board Management System">
    <meta name="twitter:description" content="Official Government Housing Board Management Portal">

    <!-- Preload Critical Resources -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap"
        as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        as="style">

    <!-- Tailwind CSS -->
    {{-- <script src="{{ asset('assets/js/tailwindcss.js') }}"></script> --}}
    <link rel="stylesheet" type="text/css" href='{{ asset('assets/css/dashboard.css') }}'>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    .form-field-disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .required-indicator::after {
        content: ' *';
        color: #ef4444;
        font-weight: 600;
    }
</style>

<body>
    <!-- Loader -->
    <div class="loader-overlay" id="loader">
        <div>
            <div class="loader"></div>
            <div class="loader-text">Loading ...</div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- Mobile Menu Toggle Button -->
    <button class="menu-toggle" id="mobileMenuToggle" onclick="toggleMobileSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    @include('applicant.dashboard_layouts.aside')

    <!-- Main Content Area -->
    <div id="mainContainer" class="main-container">
        <div class="flex-container">
            @include('applicant.dashboard_layouts.menu')
            <div class="main-content-scroll">
                @yield('content')
            </div>
            @include('applicant.dashboard_layouts.footer')
        </div>
    </div>
    <script>
        // Loader
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loader').classList.add('hidden');
            }, 1500);
        });

        // ============= THEME TOGGLE =============
        function toggleTheme() {
            const html = document.documentElement;
            const themeIcon = document.getElementById('themeIcon');
            const currentTheme = html.getAttribute('data-theme');

            if (currentTheme === 'dark') {
                html.removeAttribute('data-theme');
                themeIcon.className = 'fas fa-moon';
                localStorage.setItem('theme', 'light');
                showToast('Light Mode Activated', 'Theme changed successfully', 'error');
            } else {
                html.setAttribute('data-theme', 'dark');
                themeIcon.className = 'fas fa-sun';
                localStorage.setItem('theme', 'dark');
                showToast('Dark Mode Activated', 'Theme changed successfully', 'success');
            }
        }

        // ============= ENHANCED TOAST NOTIFICATIONS =============
        function showToast(title, message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;

            const icons = {
                success: 'check-circle',
                error: 'exclamation-circle',
                info: 'info-circle',
                warning: 'exclamation-triangle'
            };

            const icon = icons[type] || 'info-circle';

            toast.innerHTML = `
                <div class="toast-content">
                    <div class="toast-icon">
                        <i class="fas fa-${icon}"></i>
                    </div>
                    <div class="toast-message">
                        <div class="toast-title">${title}</div>
                        <div class="toast-text">${message}</div>
                    </div>
                    <button class="toast-close" onclick="closeToast(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="toast-progress">
                    <div class="toast-progress-bar"></div>
                </div>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                closeToast(toast.querySelector('.toast-close'));
            }, 3000);
        }

        function closeToast(btn) {
            const toast = btn.closest('.toast');
            toast.classList.add('removing');
            setTimeout(() => toast.remove(), 300);
        }

        // ============= DROPDOWN MENUS =============
        function toggleProfileMenu() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
            document.getElementById('notificationDropdown').classList.remove('show');
        }

        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('show');
            document.getElementById('profileDropdown').classList.remove('show');
        }

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.relative')) {
                document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('show'));
            }
        });

        // ============= SIDEBAR & NAVIGATION =============
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('mobileMenuToggle');

            sidebar.classList.toggle('show');
            toggleBtn.classList.toggle('active');

            const icon = toggleBtn.querySelector('i');
            if (sidebar.classList.contains('show')) {
                icon.className = 'fas fa-times';
            } else {
                icon.className = 'fas fa-bars';
            }
        }

        // routes open means perticular route is active means menu defaultly open
        function toggleSubmenu(e) {
            e.preventDefault();
            const submenu = e.currentTarget.nextElementSibling;
            const icon = e.currentTarget.querySelector('.submenu-icon');

            submenu.classList.toggle('show');
            icon.style.transform = submenu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0)';
        }

        function setActiveMenu(e, page) {
            e.preventDefault();

            document.querySelectorAll('.sidebar-item, .nav-item').forEach(item => {
                item.classList.remove('active');
            });

            e.currentTarget.classList.add('active');

            // Close mobile sidebar if open
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('mobileMenuToggle');
            if (window.innerWidth <= 768 && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                toggleBtn.classList.remove('active');
                toggleBtn.querySelector('i').className = 'fas fa-bars';
            }

            document.getElementById('profileDropdown').classList.remove('show');

            showToast('Navigation', `Navigated to ${page}`, 'info');
        }

        // ============= LOGOUT =============
        function logout() {
            showToast('Logging Out', 'Please wait...', 'info');
            setTimeout(() => showToast('Success', 'Logged out successfully', 'success'), 1000);
        }
    </script>
    <script>
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => el.remove());
        }, 3000);
    </script>
    <script>
        setInterval(() => {
            fetch('/refresh-csrf')
                .then(res => res.json())
                .then(data => {
                    document.querySelector('meta[name="csrf-token"]')
                        .setAttribute('content', data.token);
                });
        }, 600000);
    </script>
    @stack('scripts')
</body>

</html>
