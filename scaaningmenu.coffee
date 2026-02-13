                    <ul class="navbar-nav">
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <span
                                    class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Home
                                </span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('apply-new-licence') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('apply-new-licence') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-license">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                                    <path d="M9 7l4 0" />
                                    <path d="M9 11l4 0" />
                                </svg>
                                <span class="nav-link-title">
                                    Apply For Renew Registration Certificate
                                </span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('track-application') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('track-application') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-transform">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 6a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                    <path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3" />
                                    <path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3" />
                                    <path d="M15 18a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                </svg> <span class="nav-link-title">
                                    Track Application
                                </span>
                            </a>
                        </li>
                        <li
                            class="nav-item dropdown {{ request()->routeIs('incomplete-application', 'approved-application') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M15 15l3.35 3.35" />
                                        <path d="M9 15l-3.35 3.35" />
                                        <path d="M5.65 5.65l3.35 3.35" />
                                        <path d="M18.35 5.65l-3.35 3.35" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Manage
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item text-primary {{ request()->routeIs('incomplete-application') ? 'active' : '' }}"
                                    href="{{ route('incomplete-application') }}" rel="noopener">
                                    In-Complete Application
                                </a>
                                <a class="dropdown-item text-success {{ request()->routeIs('accepted-application') ? 'active' : '' }}"
                                    href="{{ route('accepted-application') }}" rel="noopener">
                                    Accepted Application
                                </a>
                                <a class="dropdown-item text-pink {{ request()->routeIs('rejected-application') ? 'active' : '' }}"
                                    href="{{ route('rejected-application') }}" rel="noopener">
                                    Rejected Application
                                </a> <a
                                    class="dropdown-item text-success {{ request()->routeIs('approved-application') ? 'active' : '' }}"
                                    href="{{ route('approved-application') }}" rel="noopener">
                                    Approved Application
                                </a>
                            </div>
                        </li>

                        <li class="nav-item {{ request()->routeIs('account-settings') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('account-settings') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                </svg> <span class="nav-link-title">
                                    Account Settings
                                </span>
                            </a>
                        </li>
                    </ul>