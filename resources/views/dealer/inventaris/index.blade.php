@extends('dealer.layout')
@section('dealer_content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Katalog & Manajemen Stok</h3>
    <a href="{{ route('dealer.stock_orders.checkout') }}" class="btn btn-primary">
        <i class="fas fa-shopping-cart me-2"></i>Keranjang Stok ({{ Auth::user()->dealerCartItems()->count() }})
    </a>
</div>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<div class="card shadow-sm border-0">
    <div class="card-header bg-white p-3">
        <input type="text" id="productSearch" class="form-control" placeholder="Cari produk berdasarkan nama...">
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="productTable">
                <thead>
                    <tr>
                        <th style="width: 10%;">Gambar</th>
                        <th>Produk</th>
                        <th class="text-center">Stok Anda</th>
                        <th style="width: 220px;">Tambah ke Keranjang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $produk)
                    <tr>
                        <td>
                            <img src="{{ $produk->images->first() ? asset('storage/' . $produk->images->first()->image) : 'https://placehold.co/100x100' }}" class="img-thumbnail" alt="{{ $produk->name }}">
                        </td>
                        <td>
                            <strong class="d-block product-name">{{ $produk->name }}</strong>
                            <span class="text-muted small">Harga Beli: Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                        </td>
                        <td class="text-center fw-bold">{{ $inventory[$produk->id] ?? 0 }}</td>
                        <td>
                            <form action="{{ route('dealer.cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control" value="1" min="1">
                                    <button type="submit" class="btn btn-outline-primary">Tambah</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('productSearch').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#productTable tbody tr');

        rows.forEach(row => {
            let productName = row.querySelector('.product-name').innerText.toLowerCase();
            row.style.display = productName.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection