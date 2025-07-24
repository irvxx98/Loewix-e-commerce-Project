@extends('layouts.app')

@section('content')

<div class="container px-4 pb-5 pt-1">

    <div class="row g-4 mb-5 pb-3">
        <div class="col-lg-7">
            <a href="#" class="hero-grid-banner" style="background-image: url('{{ asset($banners['main_banner']) }}'); height: 424px;">
            </a>
        </div>
        <div class="col-lg-5">
            <div class="d-flex flex-column gap-4">
                <a href="#" class="hero-grid-banner" style="background-image: url('{{ asset($banners['top_right']) }}'); height: 200px;">
                </a>
                <a href="#" class="hero-grid-banner" style="background-image: url('{{ asset($banners['bottom_right']) }}'); height: 200px;">
                </a>
            </div>
        </div>
    </div>

    <!-- <h2 class="pb-2 border-bottom text-center fw-bold">Jelajahi Kategori</h2> -->
    <div class="py-5 px-4 mt-5 rounded-4" style="background-color: rgba(0, 169, 255, 0.1);">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-uppercase" style="color: var(--bs-primary);">Kategori Produk</h4>
                <a href="#" class="text-decoration-none">Lihat Semua <i class="fa-solid fa-chevron-right"></i></a>
            </div>
            <div class="row row-cols-6 row-cols-lg-6 g-1 py-3">
                @foreach($kategoris as $kategori)
                <div class="col text-center">
                    <a href="{{ route('produk.by_category', $kategori) }}" class="category-card-simple">
                        <img src="{{ $kategori->image_kategori ? asset('storage/' . $kategori->image_kategori) : asset('images/logo/loewix.png') }}" alt="{{ $kategori->nama_kategori }}">
                        <p class="mt-2 text-xs">{{ $kategori->nama_kategori }}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4 mt-4">
        <div class="col-lg-6">
            <a href="#" class="hero-grid-banner" style="background-image: url('{{ asset($banners['bottom_1']) }}'); height: 200px;">
            </a>
        </div>
        <div class="col-lg-6">
            <a href="#" class="hero-grid-banner" style="background-image: url('{{ asset($banners['bottom_2']) }}'); height: 200px;">
            </a>
        </div>
    </div>

    <!-- <h2 class="pb-2 border-bottom text-center fw-bold mt-5">Produk Populer</h2> -->
    <div class="py-5 px-4 mt-5 rounded-4" style="background-color: rgba(255,255,255,0.7);">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-uppercase" style="color: var(--bs-primary);">Rekomendasi</h4>
                <a href="{{ route('produk.index') }}" class="text-decoration-none">Lihat Semua <i class="fa-solid fa-chevron-right"></i></a>
            </div>
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
                <!-- @foreach($semuaProduk as $produk)
                @include('partials.product_card', ['produk' => $produk])
                @endforeach -->
                @foreach($produksPopuler as $produk)
                @include('partials.product_card', ['produk' => $produk])
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection