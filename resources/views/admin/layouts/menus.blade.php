<ul class="menu-inner py-1">
    @if (auth('admin')->user()->role == 'superadmin')
    <li class="menu-item {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('superadmin.dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboards">Dashboards</div>
        </a>
    </li>

    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Admin &amp; Roles</span>
    </li>

    <li class="menu-item {{ request()->routeIs('admins.create') ? 'active' : '' }}">
        <a href="{{ route('admins.create') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
            <div data-i18n="CR">Create Admin</div>
            <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">New</div>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('admins.view-admins') ? 'active' : '' }}">
        <a href="{{ route('admins.view-admins') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
            <div data-i18n="CR">View Admin</div>
            <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">New</div>
        </a>
    </li>
    @endif

    @if (auth('admin')->user()->role == 'council_office')
    <li class="menu-item {{ request()->routeIs('council_office.dashboard') ? 'active' : '' }}">
        <a href="{{ route('council_office.dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboards">Dashboards</div>
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
    <li class="menu-item {{ request()->routeIs('admin.division.index', 'admin.division.create' , 'admin.subdivision.create', 'admin.subdivision.index') ? 'active open' : '' }}"
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

    {{-- Sub Divisions --}}
    {{-- <li class="menu-item {{ request()->routeIs('admin.subdivision.index', 'admin.subdivision.create') ? 'active open' : '' }}"
        style="">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-git-branch"></i>
            <div class="text-truncate" data-i18n="Divisions">Sub Divisions</div>
        </a>
        <ul class="menu-sub">
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
    </li> --}}

    {{-- Property Categories --}}
    <li class="menu-item {{ request()->routeIs(
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
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
</ul>