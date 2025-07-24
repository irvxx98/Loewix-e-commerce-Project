<div class="admin-sidebar p-3 d-flex flex-column sticky-top" style="max-height: 100vh; overflow-y: auto;">
    <div class="text-center mb-4">
        <a class="navbar-brand fs-4" href="{{ route('admin.dashboard') }}">LOEWIX PANEL</a>
    </div>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-1"><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'link-dark' }}"><i class="fas fa-home fa-fw me-2"></i>Dashboard</a></li>
        <li class="nav-item mb-1">
            <a href="#orders-submenu" data-bs-toggle="collapse" class="nav-link {{ request()->routeIs('admin.orders.*') ? '' : 'collapsed' }} link-dark">
                <i class="fas fa-receipt fa-fw me-2"></i>Pesanan
            </a>
            <div class="collapse {{ request()->routeIs('admin.orders.*') ? 'show' : '' }}" id="orders-submenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item"><a href="{{ route('admin.orders.loewix') }}" class="nav-link link-dark small py-1">Pesanan Loewix</a></li>
                    <li class="nav-item"><a href="{{ route('admin.orders.all') }}" class="nav-link link-dark small py-1">Semua Transaksi</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item mb-1"><a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : 'link-dark' }}"><i class="fas fa-box fa-fw me-2"></i>Produk</a></li>
        <li class="nav-item mb-1"><a href="{{ route('admin.inventory.index') }}" class="nav-link {{ request()->routeIs('admin.inventory.*') ? 'active' : 'link-dark' }}"><i class="fas fa-boxes-stacked fa-fw me-2"></i>Stok</a></li>
        <li class="nav-item mb-1"><a href="{{ route('admin.vouchers.index') }}" class="nav-link {{ request()->routeIs('admin.vouchers.*') ? 'active' : 'link-dark' }}"><i class="fas fa-ticket-alt fa-fw me-2"></i>Voucher</a></li>
        <li class="nav-item mb-1"><a href="{{ route('admin.tiers.index') }}" class="nav-link {{ request()->routeIs('admin.tiers.*') ? 'active' : 'link-dark' }}"><i class="fas fa-star fa-fw me-2"></i>Tier Dealer</a></li>
    </ul>
    <hr>
    <div>
        <a href="{{ route('logout') }}" class="d-flex align-items-center link-dark text-decoration-none" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-fw me-2"></i> <strong>Logout</strong>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
</div>