@php
    $user = auth()->user();

    // Permissions
    $canViewDashboard     = $user->can('view_dashboard');

    $canViewRegions       = $user->can('view_regions');
    $canManageRegions     = $user->can('manage_regions');

    $canViewWarehouses    = $user->can('view_warehouses');
    $canManageWarehouses  = $user->can('manage_warehouses');

    $canViewReports       = $user->can('view_reports');

    // SuperAdmin only
    $isSuperAdmin         = $user->hasRole('superadmin');

    // Current route for active state
    $currentRoute = request()->route()->getName() ?? '';
    $nmsActive    = str_starts_with($currentRoute, 'nms.pages.');
@endphp

<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title">Main Menu</li>

                {{-- DASHBOARD --}}
                @if($canViewDashboard)
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line text-primary"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @endif

                {{-- NMS --}}
                <li class="{{ $nmsActive ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect {{ $nmsActive ? 'active' : '' }}">
                        <i class="ri-router-line text-danger"></i>
                        <span>NMS</span>
                    </a>
                    <ul class="sub-menu {{ $nmsActive ? 'mm-show' : '' }}">
                        <li class="{{ $currentRoute === 'nms.pages.dashboard' ? 'mm-active' : '' }}">
                            <a href="{{ route('nms.pages.dashboard') }}" class="{{ $currentRoute === 'nms.pages.dashboard' ? 'active' : '' }}">
                                <i class="ri-dashboard-3-line"></i> Dashboard
                            </a>
                        </li>
                        <li class="{{ str_starts_with($currentRoute, 'nms.pages.warehouse') || str_starts_with($currentRoute, 'nms.pages.region') ? 'mm-active' : '' }}">
                            <a href="{{ route('nms.pages.warehouses') }}" class="{{ str_starts_with($currentRoute, 'nms.pages.warehouse') || str_starts_with($currentRoute, 'nms.pages.region') ? 'active' : '' }}">
                                <i class="ri-building-2-line"></i> Warehouses
                            </a>
                        </li>
                        <li class="{{ $currentRoute === 'nms.pages.map' ? 'mm-active' : '' }}">
                            <a href="{{ route('nms.pages.map') }}" class="{{ $currentRoute === 'nms.pages.map' ? 'active' : '' }}">
                                <i class="ri-map-pin-2-line"></i> Live Map
                            </a>
                        </li>
                    </ul>
                </li>



                {{-- FIRE / SMOKE / RODENT --}}
                @if($canViewReports)
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ri-fire-line text-danger"></i>
                        <span>Fire & Smoke</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('alerts.fire') }}">Fire</a></li>
                        <li><a href="{{ route('alerts.smoke') }}">Smoke</a></li>
                        <li><a href="{{ route('alerts.rodent') }}">Rodent</a></li>
                    </ul>
                </li>
                @endif

                {{-- FRS & SACK COUNTING --}}
                @if($canViewReports)
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ri-user-search-line"></i>
                        <span>FRS & Bag Counting</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('frs.logs') }}">FRS</a></li>
                        <li><a href="{{ route('sack.count') }}">Bag Counting</a></li>
                    </ul>
                </li>
                @endif

                {{-- IOT --}}
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ri-cpu-line text-info"></i>
                        <span>IOT</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('alerts.index', ['deviceTypeId' => 30000]) }}">CO₂</a></li>
                        <li><a href="{{ route('alerts.index', ['deviceTypeId' => 30001]) }}">Phosphine</a></li>
                    </ul>
                </li>

                 {{-- LIVE STREAMING --}}
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ri-live-line text-danger"></i>
                        <span>Live Streaming</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('sso.redirect', 'new') }}" target="_blank">New CCTV</a></li>
                        <li><a href="{{ route('sso.redirect', 'analog') }}" target="_blank">Existing CCTV</a></li>
                    </ul>
                </li>

                {{-- USER MANAGEMENT (SUPERADMIN ONLY) --}}
                @if($isSuperAdmin)
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ri-user-settings-line text-purple"></i>
                        <span>User Management</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('users.index') }}">All Users</a></li>
                        <li><a href="{{ route('users.create') }}">Create User</a></li>
                    </ul>
                </li>
                @endif

            </ul>
        </div>
    </div>
</div>
