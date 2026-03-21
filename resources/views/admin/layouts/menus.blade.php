<ul class="menu-inner py-1">
    @if (auth('admin')->user()->role == 'superadmin')
        <li class="menu-item {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('superadmin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>

        {{-- File Receieved --}}
        <li class="menu-item {{ request()->routeIs('admin.file.receiving') ? 'active' : '' }}">
            <a href="{{ route('admin.file.receiving') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Dashboards">File Receiving</div>
            </a>
        </li>

        {{-- File Sacnner --}}
        <li class="menu-item {{ request()->routeIs('applicant.scanning.completed') ? 'active' : '' }}">
            <a href="{{ route('applicant.scanning.completed') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file-blank"></i>
                <div data-i18n="Dashboards">Scanner Files</div>
            </a>
        </li>

        {{-- File Data Entry --}}
        <li class="menu-item {{ request()->routeIs('applicant.scanning.completed') ? 'active' : '' }}">
            <a href="{{ route('applicant.scanning.completed') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div data-i18n="Dashboards">File Data Entry</div>
            </a>
        </li>


        {{-- File Data Entry --}}
        <li class="menu-item {{ request()->routeIs('applicant.scanning.completed') ? 'active' : '' }}">
            <a href="{{ route('applicant.scanning.completed') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Dashboards">Allottee List</div>
            </a>
        </li>

        {{-- File Handover --}}
        <li class="menu-item {{ request()->routeIs('applicant.scanning.completed') ? 'active' : '' }}">
            <a href="{{ route('applicant.scanning.completed') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-transfer"></i>
                <div data-i18n="Dashboards">Handover File</div>
            </a>
        </li>


        <li class="menu-header small text-uppercase">
            <span style="color: #269809 !important; font-weight:600;">Allottee Components</span>
        </li>

        {{-- HeadQuaters --}}
        <li class="menu-item {{ request()->routeIs('headquarters.index') ? 'active' : '' }}">
            <a href="{{ route('headquarters.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-building"></i>
                <div data-i18n="Dashboards">Headquarters</div>
            </a>
        </li>

        {{-- Divisions --}}
        <li class="menu-item {{ request()->routeIs('admin.division.index', 'admin.division.create', 'admin.subdivision.create', 'admin.subdivision.index') ? 'active open' : '' }}"
            style="">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-sitemap"></i>
                <div class="text-truncate" data-i18n="Divisions">Divisions</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.division.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.division.create') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-plus"></i>
                        <div data-i18n="Pending Registrations">Add Divisions</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.division.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.division.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-table"></i>
                        <div data-i18n="Incomplete Applications">Divisions List</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.subdivision.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.subdivision.create') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-plus"></i>
                        <div data-i18n="Pending Registrations">Add Sub Divisions</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.subdivision.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.subdivision.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-table"></i>
                        <div data-i18n="Incomplete Applications">Sub Divisions List</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Property Categories --}}
        <li
            class="menu-item {{ request()->routeIs(
                'admin.pcategory.index',
                'admin.pcategory.create',
                'admin.pcategorytype.index',
                'admin.pcategorytype.create',
                'admin.propertysubtypes.index',
                'admin.propertysubtypes.create',
            )
                ? 'active open'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div class="text-truncate" data-i18n="Property Categories">Categories</div>
            </a>
            <ul class="menu-sub">
                {{-- Property Category --}}
                <li class="menu-item {{ request()->routeIs('admin.pcategory.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.pcategory.create') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-plus"></i>
                        <div data-i18n="Add Property Category">Add Category</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.property_category.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.pcategory.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-table"></i>
                        <div data-i18n="Property Category List">Category List</div>
                    </a>
                </li>

                {{-- Property Type --}}
                <li class="menu-item {{ request()->routeIs('admin.pcategorytype.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.pcategorytype.create') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-plus"></i>
                        <div data-i18n="Add Property Type">Add Property Type</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.pcategorytype.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.pcategorytype.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-table"></i>
                        <div data-i18n="Property Type List">Property Type List</div>
                    </a>
                </li>

                {{-- Property Main Types --}}
                <li class="menu-item {{ request()->routeIs('admin.propertysubtypes.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.propertysubtypes.create') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-plus"></i>
                        <div data-i18n="Add Property Main Type">Add Property Sub Type</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.propertysubtypes.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.propertysubtypes.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-table"></i>
                        <div data-i18n="Property Main Type List">Property Main Sub List</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Quarters --}}
        <li class="menu-item {{ request()->routeIs('admin.quarter-types.create', 'admin.quarter-types.index') ? 'active open' : '' }}"
            style="">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="7" width="18" height="14" rx="2" ry="2" />
                    <path d="M7 21V7" />
                    <path d="M17 21V7" />
                    <path d="M3 11h18" />
                    <path d="M3 15h18" />
                    <path d="M7 7h4" />
                    <path d="M13 7h4" />
                </svg>

                <div class="text-truncate" data-i18n="Divisions"> &nbsp; Quarters Type</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.quarter-types.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.quarter-types.create') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-plus"></i>
                        <div data-i18n="Pending Registrations">Add Quarter</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.quarter-types.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.quarter-types.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-table"></i>
                        <div data-i18n="Incomplete Applications">Quarters List</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Schemes --}}
        <li class="menu-item {{ request()->routeIs('admin.schemes.index', 'admin.schemes.create') ? 'active open' : '' }}"
            style="">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layer"></i>
                <div class="text-truncate" data-i18n="Divisions">Schemes</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.schemes.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.schemes.create') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-plus"></i>
                        <div data-i18n="Pending Registrations">Add Schemes</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.schemes.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.schemes.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-table"></i>
                        <div data-i18n="Incomplete Applications">Schemes List</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.schemes.blocks.create.page') ? 'active' : '' }}">
                    <a href="{{ route('admin.schemes.blocks.create.page') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-plus"></i>
                        <div data-i18n="Incomplete Applications">Add Blocks</div>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    @if (auth('admin')->user()->role == 'council_office')
        {{-- Dashboard --}}
        <li class="menu-item {{ request()->routeIs('council_office.dashboard') ? 'active' : '' }}">
            <a href="{{ route('council_office.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        {{-- File Receiving --}}
        <li class="menu-item {{ request()->routeIs('admin.filereceving.index') ? 'active' : '' }}">
            <a href="{{ route('admin.filereceving.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div>File Receiving</div>
            </a>
        </li>

        {{-- File Scanned --}}
        <li class="menu-item {{ request()->routeIs('applicant.scanning.completed') ? 'active' : '' }}">
            <a href="{{ route('applicant.scanning.completed') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file-blank"></i>
                <div>File Scanned</div>
            </a>
        </li>

        {{-- Lots (Submenu) --}}
        <li class="menu-item {{ request()->routeIs('admin.lots.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layer"></i>
                <div>Lots</div>
            </a>

            <ul class="menu-sub">

                <li class="menu-item">
                    <a href="{{ route('admin.lots.aasign.index') }}" class="menu-link">
                        <div>Assign Lots</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div>Data Entry Lots</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div>Completed Lots</div>
                    </a>
                </li>

            </ul>
        </li>

        {{-- Handover --}}
        <li class="menu-item">
            <a href="#" class="menu-link">
                <span class="menu-icon">
                    <!-- Transfer SVG -->
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 7h10M7 7l4-4M7 7l4 4" />
                        <path d="M17 17H7M17 17l-4-4M17 17l-4 4" />
                    </svg>
                </span>
                <div>Handover File</div>
            </a>
        </li>

        {{-- Allottee --}}
        <li class="menu-item">
            <a href="#" class="menu-link">
                <span class="menu-icon">
                    <!-- Users SVG -->
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M9 21v-2a4 4 0 0 1 3-3.87" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </span>
                <div>Allottee List</div>
            </a>
        </li>

        {{-- Divisions --}}
        <li class="menu-item {{ request()->routeIs('sub-admin.division.index', 'sub-admin.subdivision.index', 'sub-admin.quarter-types.index') ? 'active open' : '' }}"
            style="">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layer"></i>
                <div class="text-truncate" data-i18n="Components">Components</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('sub-admin.division.index') ? 'active' : '' }}">
                    <a href="{{ route('sub-admin.division.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-sitemap"></i>
                        <div data-i18n="Incomplete Applications">Divisions List</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('sub-admin.subdivision.index') ? 'active' : '' }}">
                    <a href="{{ route('sub-admin.subdivision.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-sitemap"></i>
                        <div data-i18n="Incomplete Applications">Sub Divisions List</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('sub-admin.quarter-types.index') ? 'active' : '' }}">
                    <a href="{{ route('sub-admin.quarter-types.index') }}" class="menu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="7" width="18" height="14" rx="2" ry="2" />
                            <path d="M7 21V7" />
                            <path d="M17 21V7" />
                            <path d="M3 11h18" />
                            <path d="M3 15h18" />
                            <path d="M7 7h4" />
                            <path d="M13 7h4" />
                        </svg>
                        <div data-i18n="Incomplete Applications">&nbsp; Quarters List</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Property Categories --}}
        <li
            class="menu-item {{ request()->routeIs(
                'admin.pcategory.index',
                'admin.pcategory.create',
                'admin.pcategorytype.index',
                'admin.pcategorytype.create',
                'admin.propertysubtypes.index',
                'admin.propertysubtypes.create',
            )
                ? 'active open'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div class="text-truncate" data-i18n="Property Categories">Categories</div>
            </a>
            <ul class="menu-sub">

                <li class="menu-item {{ request()->routeIs('sub-admin.property_category.index') ? 'active' : '' }}">
                    <a href="{{ route('sub-admin.pcategory.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-table"></i>
                        <div data-i18n="Property Category List">Category List</div>
                    </a>
                </li>


                <li class="menu-item {{ request()->routeIs('sub-admin.pcategorytype.index') ? 'active' : '' }}">
                    <a href="{{ route('sub-admin.pcategorytype.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-table"></i>
                        <div data-i18n="Property Type List">Property Type List</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('sub-admin.propertysubtypes.index') ? 'active' : '' }}">
                    <a href="{{ route('sub-admin.propertysubtypes.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-table"></i>
                        <div data-i18n="Property Main Type List">Property Main Sub List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->routeIs('sub-admin.schemes.index') ? 'active' : '' }}">
            <a href="{{ route('sub-admin.schemes.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layer"></i>
                <div data-i18n="Incomplete Applications">Schemes List</div>
            </a>
        </li>
    @endif
</ul>
