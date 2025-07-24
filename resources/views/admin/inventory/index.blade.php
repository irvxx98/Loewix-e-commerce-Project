@extends('admin.layout')
@section('admin_content')
<form action="{{ route('admin.inventory.update') }}" method="POST">
    @csrf
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-semibold">Manajemen Stok Pusat</h5>
            <div class="d-flex">
                <input type="text" id="inventorySearch" class="form-control me-2 p-1 px-2" placeholder="Cari produk...">
                <button type="submit" class="btn btn-primary flex-shrink-0 p-1 px-2">Simpan Perubahan</button>
                <a href="{{ route('admin.inventory.history') }}" class="btn btn-warning flex-shrink-0 p-1 px-2 ms-2">
                    <i class="fas fa-history fa-fw me-1"></i>Riwayat Stok</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Status</th>
                            <th style="width: 150px;">Jumlah Stok</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTable">
                        @foreach($produks as $produk)
                        @php
                        $stock = $inventory[$produk->id] ?? 0;
                        $statusClass = '';
                        if ($stock <= 0) {
                            $statusClass='table-danger' ;
                            } elseif ($stock < 10) {
                            $statusClass='table-warning' ;
                            }
                            @endphp
                            <tr class="{{ $statusClass }}">
                            <td class="product-name">{{ $produk->name }}</td>
                            <td class="text-center">
                                @if($stock <= 0)
                                    <span class="badge bg-danger">Habis</span>
                                    @elseif($stock < 10)
                                        <span class="badge bg-warning text-dark">Menipis</span>
                                        @else
                                        <span class="badge bg-success">Tersedia</span>
                                        @endif
                            </td>
                            <td>
                                <input type="number" name="quantities[{{ $produk->id }}]" class="form-control" value="{{ $stock }}" min="0">
                            </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('inventorySearch').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#inventoryTable tr');
        rows.forEach(row => {
            let productName = row.querySelector('.product-name')?.innerText.toLowerCase() || '';
            row.style.display = productName.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection