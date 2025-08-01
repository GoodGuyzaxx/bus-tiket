<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-th-large"></i></div> Dashboard
                </a>

                <div class="sb-sidenav-menu-heading mt-3">MASTER DATA</div>
                <a class="nav-link {{ Request::is('manager/user*') ? 'active' : '' }}" href="{{route('manager.user.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div> Accounts
                </a>

                <div class="sb-sidenav-menu-heading mt-3">SALES</div> <a class="nav-link {{ Request::is('admin/route*') ? 'active' : '' }}" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div> Tickets
                </a>
                <a class="nav-link {{ Request::is('admin/route*') ? 'active' : '' }}" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div> Sales
                </a>

                {{-- Uncomment and adapt your other sections as needed with similar styling --}}

                {{-- Master Data (SPK System Example) --}}
                {{-- <div class="sb-sidenav-menu-heading mt-3">SPK SYSTEM</div>
                <a class="nav-link {{ Request::is('dashboard/alternatif*') ? 'active' : '' }}" href="{{ route('alternatif.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users-class"></i></div>
                    Alternatives
                </a>
                <a class="nav-link {{ Request::is('dashboard/perbandingan*') ? 'active' : '' }}" href="{{ route('perbandingan.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-balance-scale"></i></div>
                    Comparisons
                </a>
                <a class="nav-link {{ Request::is('dashboard/ranking*') ? 'active' : '' }}" href="{{ route('rank.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-trophy"></i></div>
                    Ranking
                </a> --}}

                {{-- Admin & Profile Section --}}
                {{-- @can('admin')
                <div class="sb-sidenav-menu-heading mt-3">ADMINISTRATION</div>
                <a class="nav-link {{ Request::is('dashboard/users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                    Users
                </a>
                @endcan
                <div class="sb-sidenav-menu-heading mt-3">SETTINGS</div>
                <a class="nav-link {{ Request::is('dashboard/profile*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-edit"></i></div>
                    Edit Profile
                </a> --}}
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small text-muted">Logged in as:</div> <div class="fw-bold text-white">{{ auth()->user()->role }}</div> </div>
    </nav>
</div>
