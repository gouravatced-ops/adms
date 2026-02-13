<!-- Header -->
<header class="header px-4 py-3">
    <div class="flex items-center justify-between">
        <!-- Logo above header -->
        <div class="flex justify-center pr-1">
            <img src="{{ asset(config('config-system.logo')) }}" alt="Housing Board Logo"
                class="h-[60px] w-auto object-contain rounded shadow-sm">
        </div>
        <!-- College Info -->
        <div class="flex-1">
            <h1 class="text-base md:text-lg font-bold text-[var(--navy-primary)]">
                {{ config('config-system.app_name') }}
            </h1>

            <p class="text-xs text-[var(--text-gray)]">
                {{ config('config-system.organization') }}
            </p>
        </div>
        @php
            $themeColor = ltrim($projectTheme['primary-color'], '#');
        @endphp
        <!-- Right: Header Actions -->
        <div class="flex items-center space-x-4 ml-4">

            <!-- Header Actions -->
            <div class="flex items-center space-x-3">
                <!-- Profile -->
                <div class="relative">
                    <button onclick="toggleProfileMenu()"
                        class="flex items-center space-x-2 hover:opacity-80 transition"
                        style="border: none; background: none; cursor: pointer;">

                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background={{ $themeColor }}&color=fbbf24"
                            alt="Profile" class="w-8 h-8" style="border-radius: 4px;">

                        <span class="hidden md:block text-sm font-medium">
                            {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                        </span>
                    </button>
                    <div id="profileDropdown" class="dropdown">
                        <a href="{{ route('dashboard') }}" class="dropdown-item flex items-center">
                            <i class="fas fa-home mr-3"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('account-settings') }}" class="dropdown-item flex items-center">
                            <i class="fas fa-user mr-3"></i>
                            Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
</header>
