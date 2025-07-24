@extends('layouts.app')

@section('content')
<div class="container">
    <div class="p-4 mb-4 bg-light rounded-3">
        <div class="container-fluid py-3">
            <h1 class="display-5 fw-bold">{{ $kategori->nama_kategori }}</h1>
            <p class="col-md-8 fs-4">Menampilkan semua produk dalam kategori {{ $kategori->nama_kategori }}.</p>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @forelse ($produks as $produk)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm card-product">
                <img src="https://via.placeholder.com/300x200.png/17A2B8/FFFFFF?text=Produk" class="card-img-top" alt="{{ $produk->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $produk->name }}</h5>
                    <p class="card-text text-muted">{{ $produk->merk }}</p>
                    <h6 class="fw-bold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h6>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="{{ route('produk.show', $produk) }}" class="btn btn-primary w-100">Lihat Detail</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                Belum ada produk untuk kategori ini.
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $produks->links() }}
    </div>
</div>
@endsection