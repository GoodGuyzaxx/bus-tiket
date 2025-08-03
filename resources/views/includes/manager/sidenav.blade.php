<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('manager.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-th-large"></i></div> Dashboard
                </a>

                <div class="sb-sidenav-menu-heading mt-3">MASTER DATA</div>
                <a class="nav-link {{ Request::is('manager/user*') ? 'active' : '' }}" href="{{route('manager.user.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div> Accounts
                </a>

                <div class="sb-sidenav-menu-heading mt-3">TRANSAKSI</div>
                <a class="nav-link {{ Request::is('manager/tiket*') ? 'active' : '' }}" href="{{route('manager.tiket.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div> Tiket
                </a>
                <a class="nav-link {{ Request::is('manager/penjualan*') ? 'active' : '' }}" href="{{route('manager.penjualan.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div> Penjualan
                </a>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small text-muted">Logged in as:</div> <div class="fw-bold text-white">{{ auth()->user()->role }}</div> </div>
    </nav>
</div>
