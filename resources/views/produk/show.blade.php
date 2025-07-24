@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-lg-5">
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <img src="{{ $produk->images->first() ? asset('storage/' . $produk->images->first()->image) : 'https://placehold.co/600x600/e0e0e0/333?text=Loewix' }}" class="img-fluid rounded main-product-image" alt="{{ $produk->name }}">
                    </div>
                    <div class="d-flex">
                        @foreach($produk->images as $image)
                        <div class="p-1">
                            <img src="{{ asset('storage/' . $image->image) }}" class="img-fluid rounded product-thumbnail" alt="Thumbnail" style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-6">
                    <h2 class="fw-bold mb-2">{{ $produk->name }}</h2>
                    <div class="d-flex align-items-center mb-3 text-muted">
                        <span>Terjual {{ $produk->sold }}+</span>
                        <span class="mx-2">|</span>
                        <span><i class="fa-solid fa-star text-warning"></i> {{ $produk->rating }}/5.0</span>
                    </div>

                    <div class="mb-4">
                        @if($produk->has_discount)
                        <span class="fs-2 fw-bold text-primary me-3">Rp {{ number_format($produk->final_price, 0, ',', '.') }}</span>
                        <del class="fs-5 text-muted">Rp {{ number_format($produk->harga, 0, ',', '.') }}</del>
                        <span class="badge bg-danger ms-2">{{ $produk->diskon }}% OFF</span>
                        @else
                        <span class="fs-2 fw-bold text-primary">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                        @endif
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        @if(Auth::check() && Auth::user()->role === \App\Enums\Role::DEALER)
                        <form action="{{ route('dealer.cart.store') }}" method="POST" class="d-flex align-items-end">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <div class="me-3">
                                <label for="quantity" class="form-label mb-0">Jumlah:</label>
                                <input type="number" name="quantity" class="form-control" value="1" min="1" style="width: 80px;">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-truck-loading me-2"></i>Tambah ke Keranjang Stok
                            </button>
                        </form>
                        @else
                        <form action="{{ route('cart.store', $produk) }}" method="POST" class="d-flex align-items-end">
                            @csrf
                            <div class="me-3">
                                <label for="quantity" class="form-label mb-0">Jumlah:</label>
                                <input type="number" class="form-control" name="quantity" value="1" min="1" style="width: 80px;">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-cart-plus me-2"></i>Tambah Keranjang
                            </button>
                        </form>
                        @endif
                    </div>

                    <div class="d-flex align-items-end justify-content-end mb-4">
                        <div class="ms-3">
                            <button class="wishlist-btn-icon me-2 wishlist-toggle {{ Auth::check() && Auth::user()->wishlists()->where('produk_id', $produk->id)->exists() ? 'active' : '' }}" data-id="{{ $produk->id }}">
                                <i class="fa-solid fa-heart fs-4"></i>
                            </button>{{ $produk->wishlists_count }}
                        </div>
                    </div>

                    <hr class="my-4">

                    <ul class="nav nav-tabs" id="productTab" role="tablist">
                        <li class="nav-item" role="presentation"><button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-pane" type="button">Deskripsi</button></li>
                        <li class="nav-item" role="presentation"><button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs-pane" type="button">Spesifikasi</button></li>
                    </ul>

                    <div class="tab-content pt-3" id="productTabContent">
                        <div class="tab-pane fade show active" id="description-pane" role="tabpanel">
                            <p>{{ $produk->keterangan ?? 'Tidak ada deskripsi untuk produk ini.' }}</p>
                        </div>
                        <div class="tab-pane fade" id="specs-pane" role="tabpanel">
                            <ul class="list-unstyled">
                                <li><strong>Merk:</strong> {{ $produk->merk }}</li>
                                <li><strong>Garansi:</strong> {{ $produk->garansi ?? 'N/A' }}</li>
                                <li><strong>Berat:</strong> {{ $produk->berat }} gram</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainImage = document.querySelector('.main-product-image');
        const thumbnails = document.querySelectorAll('.product-thumbnail');

        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                mainImage.src = this.src;
            });
        });
    });
</script>
@endsection