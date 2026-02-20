<!-- Sidebar -->
<aside id="sidebar" class="sidebar fixed left-0 top-0 h-full">
    <!-- Scrollable Menu Container -->
    <div class="sidebar-menu-container">
        <div class="p-4">
            <div class="flex justify-center mb-6">
                <img src="{{ asset(config('config-system.stategovermentLogo')) }}" alt="Housing Board Logo"
                    class="h-20 w-auto object-contain bg-white rounded p-2 shadow-sm">
            </div>

            <!-- Menu Items -->
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center">
                    <i class="fas fa-home"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                @if (Auth::user()->role === 'scanner')
                    <!-- File Section -->
                    <div>
                        <a href="#" class="sidebar-item flex {{ request()->routeIs('admin.filereceving.*') ? 'active' : '' }} items-center justify-between"
                            onclick="toggleSubmenu(event)">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt"></i>
                                <span class="ml-3">File Receiving</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs submenu-icon" style="transition: transform 0.3s;"></i>
                        </a>
                        <div class="submenu">
                            <a href="{{ route('admin.filereceving.create') }}"
                                class="sidebar-item {{ request()->routeIs('admin.filereceving.create') ? 'active' : '' }} submenu-item flex items-center">
                                <i class="fas fa-plus-circle"></i>
                                <span class="ml-3"> Add File Receiving </span>
                            </a>
                            <a href="{{ route('admin.filereceving.index') }}"
                                class="sidebar-item {{ request()->routeIs('admin.filereceving.index') ? 'active' : '' }} submenu-item flex items-center">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M8 8H20M11 12H20M14 16H20M4 8H4.01M7 12H7.01M10 16H10.01"
                                            stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                                <span class="ml-3">Receiving List</span>
                            </a>
                        </div>
                    </div>

                    <!-- Scanning Management -->
                    <div>
                        <a href="#" class="sidebar-item flex {{ request()->routeIs('applicant.scanning.*') ? 'active' : '' }} items-center justify-between"
                            onclick="toggleSubmenu(event)">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                    <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                    <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                    <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                    <path d="M5 12l14 0" />
                                    <path d="M8 12l-4 0" />
                                    <path d="M16 12l4 0" />
                                </svg>
                                <span class="ml-3">Scanning</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs submenu-icon" style="transition: transform 0.3s;"></i>
                        </a>
                        <div class="submenu">
                            <a href="{{ route('applicant.scanning.index') }}" class="sidebar-item {{ request()->routeIs('applicant.scanning.index') ? 'active' : '' }} submenu-item flex items-center"
                                >
                                <i class="fas fa-inbox"></i>
                                <span class="ml-3">Add Scanning</span>
                            </a>
                            <a href="{{ route('applicant.scanning.completed') }}" class="sidebar-item {{ request()->routeIs('applicant.scanning.completed') ? 'active' : '' }} submenu-item flex items-center"
                                >
                                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M8 8H20M11 12H20M14 16H20M4 8H4.01M7 12H7.01M10 16H10.01"
                                            stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                                <span class="ml-3">Scanning List</span>
                            </a>
                        </div>
                    </div>

                    <!-- File Handover -->
                    {{-- <a href="#" class="sidebar-item flex items-center"
                        onclick="setActiveMenu(event, 'documents')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M11 12h2a2 2 0 1 0 0 -4h-2v8" />
                            <path d="M14 10l-3 -3" />
                            <path d="M14 14l-3 3" />
                            <path d="M19 16v-2a2 2 0 0 0 -2 -2h-2" />
                            <path d="M5 8v2a2 2 0 0 0 2 2h2" />
                        </svg>
                        <span class="ml-3">File Handover</span>
                    </a> --}}

                    <!-- Proof Section -->
                    <a href="#" class="sidebar-item flex items-center"
                        onclick="setActiveMenu(event, 'documents')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                            <path d="M10 11l-2 2l2 2" />
                            <path d="M14 11l2 2l-2 2" />
                        </svg>
                        <span class="ml-3">Allottee Records</span>
                    </a>

                    <!-- Reports Section -->
                    {{-- <a href="#" class="sidebar-item flex items-center"
                        onclick="setActiveMenu(event, 'profile')">
                        <i class="fas fa-chart-line"></i>
                        <span class="ml-3">Reports</span>
                    </a> --}}
                @endif
                @if (Auth::user()->role === 'dataentry')
                    <!-- Assigned Scans -->
                    <a href="#" class="sidebar-item flex items-center"
                        onclick="setActiveMenu(event, 'profile')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                            <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                            <path d="M9 12l.01 0" />
                            <path d="M13 12l2 0" />
                            <path d="M9 16l.01 0" />
                            <path d="M13 16l2 0" />
                        </svg>
                        <span class="ml-3">Assigned Scans</span>
                    </a>

                    <!-- File Details -->
                    <a href="#" class="sidebar-item flex items-center"
                        onclick="setActiveMenu(event, 'profile')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                            <path d="M9 12l2 0" />
                            <path d="M9 16l6 0" />
                            <path d="M11 10l-2 2l2 2" />
                        </svg>
                        <span class="ml-3">File Details</span>
                    </a>

                    <!-- File Status / Progress -->
                    <a href="#" class="sidebar-item flex items-center"
                        onclick="setActiveMenu(event, 'profile')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                            <path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                            <path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                            <path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                            <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                            <path d="M12 8v4l3 3" />
                        </svg>
                        <span class="ml-3">File Progress</span>
                    </a>

                    <!-- Reports -->
                    <a href="#" class="sidebar-item flex items-center"
                        onclick="setActiveMenu(event, 'profile')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                            <path d="M7 3v4h4" />
                            <path d="M9 17l0 4" />
                            <path d="M17 14l0 7" />
                            <path d="M13 13l0 8" />
                            <path d="M21 12l0 9" />
                        </svg>
                        <span class="ml-3">Reports</span>
                    </a>
                @endif

                <!-- User Profile -->
                <a href="{{ route('account-settings') }}" class="sidebar-item flex items-center">
                    <i class="fas fa-user"></i>
                    <span class="ml-3">My Profile</span>
                </a>

                <!-- Logout -->
                <a href="javascript:void(0)" class="sidebar-item flex items-center"
                    onclick="document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="ml-3">Logout</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </nav>
        </div>
    </div>

    <!-- Fixed Sidebar Footer -->
    <div class="sidebar-footer">
        <span class="text-xs text-gray-300">Technology Partner</span>
        <a href="https://www.computered.in/" target="_blank"
            class="flex items-center space-x-2 hover:opacity-80 transition">
            <img src="https://computered.co.in/cgst/domains/assets/images/logos/insta-logo.jpg" alt="Partner Logo"
                class="h-8 w-auto object-contain">
            <span class="text-xs text-white font-medium">COMPUTER Ed.</span>
        </a>
    </div>
</aside>
