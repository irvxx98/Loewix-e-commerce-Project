<div class="list-group shadow-sm sticky-top" style="top: 100px;">
    <a href="{{ route('dealer.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dealer.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt fa-fw me-2"></i>Dashboard
    </a>
    <a href="{{ route('dealer.orders.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dealer.orders.index') ? 'active' : '' }}">
        <i class="fas fa-box-open fa-fw me-2"></i>Pesanan Masuk
    </a>
    <a href="{{ route('dealer.stock_orders.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dealer.stock_orders.*') ? 'active' : '' }}">
        <i class="fas fa-receipt fa-fw me-2"></i>Riwayat Pembelian
    </a>
    <a href="{{ route('dealer.inventory.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dealer.inventory.index') ? 'active' : '' }}">
        <i class="fas fa-boxes-stacked fa-fw me-2"></i>Manajemen Stok
    </a>
    <a href="{{ route('dealer.stock_orders.checkout') }}" class="list-group-item list-group-item-action">
        <i class="fas fa-shopping-cart fa-fw me-2"></i>Keranjang Stok
    </a>
    <a href="{{ route('dealer.profil.edit') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dealer.profil.edit') ? 'active' : '' }}">
        <i class="fas fa-store fa-fw me-2"></i>Profil Toko
    </a>
    <a href="{{ route('dealer.banners.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dealer.banners.*') ? 'active' : '' }}">
        <i class="fas fa-images fa-fw me-2"></i>Banner Toko
    </a>
</div>