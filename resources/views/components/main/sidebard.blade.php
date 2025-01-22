<div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="{{ $logo }}">
        @if ($logo !== 'white')
            <h1 class="text-white fw-semibold logo" style="font-weight: semibold">
                CRUE
            </h1>
        @else
            <h1 class="text-dark fw-semibold logo" style="font-weight: semibold">
                CRUE
            </h1>
        @endif
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
            </button>
        </div>
        <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
        </button>
    </div>
    <!-- End Logo Header -->
</div>
<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li
                class="nav-item {{ request()->is('admin/dashboard') || request()->is('admin/dashboard/*') ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}">
                    <i class="fas fa-home"></i>
                    <p>Inicio</p>
                </a>
            </li>

            {{-- @can('admin.saturations.index') --}}
            <li
                class="nav-item {{ request()->is('admin/saturations') || request()->is('admin/saturations/*') ? 'active' : '' }}">
                <a href="{{ route('admin.saturations.index') }}">
                    <i class="fas fa-percentage"></i>
                    <p>Saturaciones</p>
                </a>
            </li>
            {{-- @endcan --}}

            @can('admin.ips.index')
                <li class="nav-item {{ request()->is('admin/ips') || request()->is('admin/ips/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.ips.index') }}">
                        <i class="fas fa-hospital"></i>
                        <p>Capacidad</p>
                    </a>
                </li>
            @endcan

            @can('admin.occupations.index')
                <li
                    class="nav-item {{ request()->is('admin/occupations') || request()->is('admin/occupations/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.occupations.index') }}">
                        <i class="fas fa-procedures"></i>
                        <p>Ocupaciones</p>
                    </a>
                </li>
            @endcan

            @can('admin.blockeds.index')
                <li
                    class="nav-item {{ request()->is('admin/blockeds') || request()->is('admin/blockeds/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.blockeds.index') }}">
                        <i class="fas fa-ban"></i>
                        <p>Bloqueos</p>
                    </a>
                </li>
            @endcan

            @can('admin.out_of_services.index')
                <li
                    class="nav-item {{ request()->is('admin/out_of_services') || request()->is('admin/out_of_services/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.out_of_services.index') }}">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Fuera de servicio</p>
                    </a>
                </li>
            @endcan


            @canany(['admin.users.index', 'admin.roles.index', 'admin.app-users.index'])
                <li
                    class="nav-item {{ request()->is('admin/roles') ||
                    request()->is('admin/roles/*') ||
                    request()->is('admin/users') ||
                    request()->is('admin/users/*')
                        ? 'active submenu'
                        : '' }}">
                    <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                        <i class="fas fa-cogs"></i>
                        <p>Administración</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('admin/roles') ||
                    request()->is('admin/roles/*') ||
                    request()->is('admin/users') ||
                    request()->is('admin/users/*')
                        ? 'show'
                        : '' }}"
                        id="dashboard">
                        <ul class="nav nav-collapse">

                            @can('admin.users.index')
                                <li
                                    class="{{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.users.index') }}">
                                        <span class="sub-item">Usuarios</span>
                                    </a>
                                </li>
                            @endcan

                            @can('admin.roles.index')
                                <li
                                    class="{{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.roles.index') }}">
                                        <span class="sub-item">Roles</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            </ul>
        @endcanany
    </div>
</div>
