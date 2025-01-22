<style>
    .truncate-text {
        width: 150px;
        /* Ajusta el ancho deseado */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="main-header-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="{{ $navbar }}">
        <a href="{{ url('admin/dashboard') }}" class="logo">
            <h1 class="text-white">CRUE</h1>
        </a>
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
<!-- Navbar Header -->
<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
    data-background-color="{{ $navbar }}">
    <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <button class="nav-link" id="custom-toggle-btn">
                    <i class="fas fa-paint-roller"></i>
                </button>
            </li>
            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        <img src="{{ asset('assets/images/app/version_alcaldia.svg') }}" alt="..."
                            class="avatar-img rounded-circle" />
                    </div>
                    <span class="profile-username">
                        <span class="op-7">Hola,</span>
                        <span class="fw-bold">{{ auth()->user()->name }}</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    <img src="{{ asset('assets/images/app/version_alcaldia.svg') }}" alt="image profile"
                                        class="avatar-img rounded" />
                                </div>
                                <div class="u-text">
                                    <h4>{{ auth()->user()->name }}</h4>
                                    <small>
                                        <p class="truncate-text">{{ auth()->user()->email }}</p>
                                    </small>
                                </div>
                            </div>
                        </li>
                        <li>
                            {{-- <a class="dropdown-item" href="#">Configuración de cuenta</a> --}}
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    Cerrar sesion
                                </button>
                            </form>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- End Navbar -->
