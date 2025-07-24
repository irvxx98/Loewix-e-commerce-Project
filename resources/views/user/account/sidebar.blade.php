<div class="col-md-3">
    <div class="list-group shadow-sm">
        <a href="{{ route('account.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high fa-fw me-2"></i>Dashboard
        </a>
        <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.orders*') ? 'active' : '' }}">
            <i class="fa-solid fa-box-archive fa-fw me-2"></i>Riwayat Pesanan
        </a>
        <a href="{{ route('account.profil.edit') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.profil.edit') ? 'active' : '' }}">
            <i class="fa-solid fa-user-pen fa-fw me-2"></i>Profil & Alamat
        </a>
        <a href="{{ route('logout') }}" class="list-group-item list-group-item-action" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket fa-fw me-2"></i>Logout
        </a>
    </div>
</div>