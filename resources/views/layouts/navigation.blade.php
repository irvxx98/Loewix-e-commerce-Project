<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            {{-- Ganti dengan logo jika ada --}}
            LOEWIX
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('produk.index') }}">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('support.index') }}">Dukungan</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                @endif

                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
                </li>
                @endif
                @else
                {{-- Ikon Notifikasi dan Keranjang --}}
                <li class="nav-item">
                    <a href="{{ route('notifications.index') }}" class="nav-link"><i class="fas fa-bell"></i></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cart.index') }}" class="nav-link"><i class="fas fa-shopping-cart"></i></a>
                </li>

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @if(Auth::user()->role === \App\Enums\Role::LOEWIX)
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                            Admin Panel
                        </a>
                        @elseif(Auth::user()->role === \App\Enums\Role::DEALER)
                        <a class="dropdown-item" href="{{ route('dealer.dashboard') }}">
                            Dealer Panel
                        </a>
                        @else
                        <a class="dropdown-item" href="#">
                            Akun Saya
                        </a>
                        @endif

                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>