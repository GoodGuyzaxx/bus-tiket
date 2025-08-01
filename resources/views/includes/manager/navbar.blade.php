<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3 d-flex align-items-center" href="{{ route('admin.dashboard') }}">
        <img src="{{ url('frontend/images/logo.png') }}" class="me-2" style="height: 35px; width: 35px; border-radius: 5px;" alt="SPK Logo" />
        <span class="fw-bold">E-Bus Sistem</span>
    </a>

    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-white" id="sidebarToggle" type="button">
        <i class="fas fa-bars"></i>
    </button>

    <div class="ms-auto d-flex align-items-center">
        <span class="d-none d-lg-inline text-white small me-3">Welcome back, {{ auth()->user()->name }}</span>

        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle fa-fw fa-lg text-white"></i> </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
