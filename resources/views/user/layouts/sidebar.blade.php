<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light bg-white" id="sidenavAccordion" style="border-right: 1px solid #e0e0e0;">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('user.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="{{ route('home') }}" target="_blank">
                    <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                    Browse Products
                </a>
                <div class="sb-sidenav-menu-heading">Account</div>
                <a class="nav-link" href="{{ url('user/dashboard-settings') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                    Settings
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ auth()->user()->name }}
        </div>
    </nav>
</div>
