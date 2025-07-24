<div class="col">
    <div class="card h-100 product-card">
        <div class="product-card-img-container">
            <a href="{{ route('produk.show', $produk) }}">
                <img src="https://placehold.co/300x300/e0e0e0/333?text={{ urlencode($produk->name) }}" class="card-img-top" alt="{{ $produk->name }}">
            </a>
            @if($produk->has_discount)
            <div class="discount-badge">{{ $produk->diskon }}%</div>
            @endif
        </div>
        <div class="card-body d-flex flex-column">
            <a href="{{ route('produk.show', $produk) }}" class="product-name d-block mb-2">{{ $produk->name }}</a>

            <div class="mt-auto">
                <div class="mb-2">
                    <span class="product-price">Rp{{ number_format($produk->final_price, 0, ',', '.') }}</span>
                    @if($produk->has_discount)
                    <del class="small text-muted ms-1">Rp{{ number_format($produk->harga, 0, ',', '.') }}</del>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="sold-count">{{ $produk->sold }}+ terjual</span>
                    <div class="d-flex align-items-center">
                        <span class="text-muted small me-2 wishlist-count">{{ $produk->wishlists_count }}</span>
                        <button class="wishlist-btn-icon wishlist-toggle {{ Auth::check() && Auth::user()->wishlists()->where('produk_id', $produk->id)->exists() ? 'active' : '' }}" data-id="{{ $produk->id }}">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>