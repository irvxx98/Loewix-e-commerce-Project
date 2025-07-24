<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Loewix') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --bs-primary: #0052FF;
            --bs-secondary: #00A9FF;
            --bs-light-bg: #F0F8FF;
            --bs-accent: #FFD700;
            --bs-dark-text: #333333;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #fff;
            color: var(--bs-dark-text);
        }

        .navbar {
            box-shadow: 0 4px 12px rgba(0, 0, 0, .05);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--bs-primary) !important;
        }

        .navbar-brand img {
            max-width: 120px;
        }

        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 82, 255, 0.3);
        }

        .btn-accent {
            background-color: var(--bs-accent);
            border-color: var(--bs-accent);
            color: var(--bs-dark-text);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
        }

        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(255, 215, 0, 0.4);
        }

        .card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .05);
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, .1);
        }

        .category-card {
            background-size: cover;
            background-position: center;
            transition: transform 0.3s ease;
        }

        .category-card:hover {
            transform: scale(1.05);
        }

        .text-shadow-1 {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, .5);
        }

        .product-card {
            background-color: #fff;
            border: 1px solid #e5e5e5;
            text-align: left;
            transition: all 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
        }

        .product-card-img-container {
            position: relative;
        }

        .discount-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: var(--bs-accent);
            color: var(--bs-dark-text);
            padding: 0.2rem 0.5rem;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .product-card .card-body {
            padding: 0.75rem;
        }

        .product-card .product-name {
            font-size: 0.9rem;
            color: var(--bs-dark-text);
            text-decoration: none;
            height: 45px;
            overflow: hidden;
        }

        .product-card .product-price {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--bs-primary);
        }

        .product-card .sold-count {
            font-size: 0.7rem;
            color: #6c757d;
        }

        .hero-grid-banner {
            background-size: cover;
            background-position: center;
            border-radius: 0.75rem;
            overflow: hidden;
            color: white;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
        }

        .hero-grid-banner:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
        }

        .category-card-simple {
            text-align: center;
            text-decoration: none;
            color: var(--bs-dark-text);
            transition: all 0.2s ease;
        }

        .category-card-simple:hover {
            transform: translateY(-5px);
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
            text-decoration: none;
            color: var(--bs-primary);
        }

        .category-card-simple img {
            background-color: #fff;
            border-radius: 0.75rem;
            padding: 0.8rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .05);
            height: 80%;
            width: 80%;
            object-fit: contain;
        }

        .item-hidden {
            display: none !important;
        }

        .dealer-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
            transition: all 0.3s ease;
        }

        .dealer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .1);
        }

        .dealer-card-header {
            height: 180px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .dealer-card-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
            position: absolute;
            bottom: -40px;
            left: 50%;
            transform: translateX(-50%);
        }

        .dealer-card-body {
            padding-top: 50px;
            padding-bottom: 1.5rem;
            text-align: center;
        }

        .wishlist-btn-icon {
            background: none;
            border: none;
            padding: 0;
            color: #adb5bd;
            font-size: 1.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .wishlist-btn-icon:hover {
            color: #dc3545;
        }

        .wishlist-btn-icon.active {
            color: #dc3545;
            transform: scale(1.2);
        }

        .wishlist-btn-icon-view {
            background: none;
            border: none;
            padding: 0;
            color: #6c757d;
            font-size: 1rem;
            cursor: pointer;
            transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
            vertical-align: middle;
        }

        .wishlist-btn-icon-view:hover {
            color: #dc3545;
        }

        .wishlist-btn-icon-view.active {
            color: #dc3545;
            transform: scale(1.1);
        }

        .image-container-admin-product {
            position: relative;
            display: inline-block;
        }

        .delete-image-btn-admin-product {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 20px;
            height: 20px;
            padding: 0;
            font-size: 1em;
            line-height: 0;
            border-radius: 50%;
            border: 1px solid #fff;
        }

        .footer {
            background-color: #001f3f;
            color: #e9ecef;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3" style="z-index: 1040;">
            <div class="container">
                <a class="navbar-brand me-4" href="{{ route('home') }}"><img src="{{ asset('images/logo/lwx-htm.png') }}" alt="Logo Loewix"></a>

                <div class="w-50">
                    <form action="{{ route('produk.search') }}" method="GET" class="d-flex">
                        <input class="form-control form-control-lg" type="search" name="q" placeholder="Cari produk di Loewix..." aria-label="Search" value="{{ request('q') }}">
                        <button class="btn btn-primary ms-2 px-3" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>

                <ul class="navbar-nav ms-auto d-flex flex-row">
                    @guest
                    <li class="nav-item me-3"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-primary" href="{{ route('register') }}">Register</a></li>
                    @else
                    @if(Auth::user()->role === \App\Enums\Role::DEALER)
                    <li class="nav-item me-3">
                        <a class="nav-link fs-5" href="{{ route('dealer.stock_orders.checkout') }}" title="Keranjang Stok">
                            <i class="fas fa-truck-loading"></i>
                            @if(Auth::user()->dealerCartItems()->count() > 0)
                            <span class="badge rounded-pill bg-danger" style="font-size: 0.6rem; vertical-align: top;">{{ Auth::user()->dealerCartItems()->count() }}</span>
                            @endif
                        </a>
                    </li>
                    @elseif(Auth::user()->role === \App\Enums\Role::CUSTOMER)
                    <li class="nav-item me-3">
                        <a class="nav-link fs-5" href="{{ route('cart.index') }}" title="Keranjang Belanja">
                            <i class="fa-solid fa-cart-shopping"></i>
                            @if(Auth::user()->cartItems()->count() > 0)
                            <span class="badge rounded-pill bg-danger" style="font-size: 0.6rem; vertical-align: top;">{{ Auth::user()->cartItems()->count() }}</span>
                            @endif
                        </a>
                    </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle fs-5" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <div class="px-3 py-2">
                                <span class="d-block small">Signed in as</span>
                                <strong class="d-block">{{ Auth::user()->name }}</strong>
                            </div>
                            <div class="dropdown-divider"></div>
                            @if(Auth::user()->role === \App\Enums\Role::DEALER)
                            <a class="dropdown-item" href="{{ route('dealer.dashboard') }}">Dashboard Dealer</a>
                            @elseif(Auth::user()->role === \App\Enums\Role::LOEWIX)
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                            @else
                            <a class="dropdown-item" href="{{ route('account.orders') }}">Akun Saya</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <main class="py-5 flex-grow-1">
            @yield('content')
        </main>

        <footer class="py-4 footer">
            <div class="container text-center">
                <span class="text-white-50">Hak Cipta &copy; {{ date('Y') }} Loewix. All Rights Reserved.</span>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('click', function(e) {
            if (e.target.closest('.wishlist-toggle')) {
                e.preventDefault();
                const button = e.target.closest('.wishlist-toggle');
                const productId = button.dataset.id;
                const url = `/wishlist/toggle/${productId}`;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                }).then(res => res.json()).then(data => {
                    if (data.status) {
                        button.classList.toggle('active', data.status === 'added');
                        const countSpan = button.previousElementSibling;
                        if (countSpan && countSpan.classList.contains('wishlist-count')) {
                            countSpan.innerText = data.count;
                        }
                    }
                }).catch(error => console.error('Error:', error));
            }
        });
    </script>
</body>

</html>