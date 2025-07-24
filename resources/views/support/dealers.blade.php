@extends('layouts.app')

@section('content')
@include('support.header_menu')
<div class="bg-white">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold">Dealer Resmi Loewix</h1>
        <p class="lead col-md-8 mx-auto text-muted">Temukan partner resmi kami yang terpercaya di berbagai kota untuk kebutuhan keamanan Anda.</p>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        @forelse($dealers as $dealer)
        <div class="col-md-6 col-lg-4">
            <div class="dealer-card h-100">
                <div class="dealer-card-header" style="background-image: url('{{ $dealer->dealerProfile->store_image ? asset('storage/' . $dealer->dealerProfile->store_image) : 'https://placehold.co/600x300/0052FF/FFFFFF?text=Toko+Resmi' }}');">
                    <img src="{{ $dealer->dealerProfile->store_logo ? asset('storage/' . $dealer->dealerProfile->store_logo) : 'https://placehold.co/100x100/e9ecef/333?text=L' }}" alt="Logo Toko" class="dealer-card-logo">
                </div>
                <div class="dealer-card-body px-3">
                    <h5 class="card-title fw-bold mt-3 mb-2">{{ $dealer->dealerProfile->store_name ?? 'Nama Toko Dealer' }}</h5>
                    <p class="card-text mb-2 text-muted">
                        <i class="fas fa-map-marker-alt fa-fw me-1"></i>
                        {{ $dealer->address ?? 'Alamat tidak tersedia' }}
                    </p>
                    <p class="card-text text-muted">
                        <i class="fas fa-phone fa-fw me-1"></i>
                        {{ $dealer->phone ?? 'Nomor tidak tersedia' }}
                    </p>
                    <a href="{{ $delaer->store_maps ?? '#' }}" class="btn btn-outline-primary mt-3">Lihat di Peta</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning">Belum ada dealer resmi yang terdaftar.</div>
        </div>
        @endforelse
    </div>
</div>
@endsection