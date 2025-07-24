@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('user.account.sidebar')
        <div class="col-md-9">
            <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-secondary) 100%); color: white;">
                <div class="card-body p-4">
                    <h4 class="fw-bold">Halo, {{ $user->name }}!</h4>
                    <p class="mb-0">Selamat datang kembali di dashboard Anda. Di sini Anda bisa melacak semua aktivitas belanja Anda.</p>
                </div>
            </div>
            <h5 class="fw-bold">Status Pesanan Anda</h5>
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4 border-end">
                            <a href="{{ route('account.orders') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                <p class="mb-0 fw-semibold">Diproses</p>
                                <span class="badge rounded-pill bg-primary">{{ $orderStatusCounts['processing'] }}</span>
                            </a>
                        </div>
                        <div class="col-4 border-end">
                            <a href="{{ route('account.orders') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-truck fa-2x text-muted mb-2"></i>
                                <p class="mb-0 fw-semibold">Dikirim</p>
                                <span class="badge rounded-pill bg-primary">{{ $orderStatusCounts['shipped'] }}</span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="{{ route('account.orders') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-check-circle fa-2x text-muted mb-2"></i>
                                <p class="mb-0 fw-semibold">Selesai</p>
                                <span class="badge rounded-pill bg-primary">{{ $orderStatusCounts['completed'] }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
                <h4 class="fw-bold mb-0">Rekomendasi Untuk Anda</h4>
                <a href="{{ route('produk.index') }}" class="text-decoration-none">Lihat Semua</a>
            </div>
            <div class="row row-cols-2 row-cols-md-2 row-cols-lg-3 g-3">
                @forelse($recommendations as $produk)
                @include('partials.product_card', ['produk' => $produk])
                @empty
                <div class="col-12">
                    <p class="text-muted">Belum ada rekomendasi untuk Anda.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection