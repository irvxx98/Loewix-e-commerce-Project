@extends('admin.layout')
@section('admin_content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-semibold">Daftar Produk</h5>
        <div class="d-flex">
            <input type="text" id="productSearch" class="form-control me-2" placeholder="Cari produk...">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary flex-shrink-0">Tambah Produk</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 75px;">Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                    @forelse ($produks as $produk)
                    <tr>
                        <td>
                            <img src="{{ $produk->images->first() ? asset('storage/' . $produk->images->first()->image) : 'https://placehold.co/75x75' }}" class="img-thumbnail" style="width: 75px; height: 75px; object-fit: cover;">
                        </td>
                        <td class="product-name">{{ $produk->name }}</td>
                        <td>{{ $produk->kategori->nama_kategori ?? 'N/A' }}</td>
                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td><a href="{{ route('admin.products.edit', $produk) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">{{ $produks->links() }}</div>
    </div>
</div>

<script>
    document.getElementById('productSearch').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#productTable tr');
        rows.forEach(row => {
            let productName = row.querySelector('.product-name')?.innerText.toLowerCase() || '';
            row.style.display = productName.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection