@extends('admin.layout')
@section('admin_content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-semibold">Riwayat Pergerakan Stok</h5>
        <div style="width: 300px;"><input type="text" id="historySearch" class="form-control" placeholder="Cari berdasarkan produk..."></div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Tipe</th>
                        <th class="text-center">Perubahan</th>
                        <th class="text-center">Stok Awal</th>
                        <th class="text-center">Stok Akhir</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody id="historyTable">
                    @forelse ($histories as $history)
                    <tr>
                        <td>{{ $history->created_at->format('d M Y, H:i') }}</td>
                        <td class="product-name">{{ $history->produk->name ?? 'Produk Dihapus' }}</td>
                        <td>
                            @if($history->type == 'penambahan') <span class="badge bg-success">Penambahan</span>
                            @elseif($history->type == 'pengurangan') <span class="badge bg-danger">Pengurangan</span>
                            @else <span class="badge bg-warning text-dark">Koreksi</span>
                            @endif
                        </td>
                        <td class="text-center fw-bold {{ $history->quantity_change > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $history->quantity_change > 0 ? '+' : '' }}{{ $history->quantity_change }}
                        </td>
                        <td class="text-center">{{ $history->quantity_before }}</td>
                        <td class="text-center">{{ $history->quantity_after }}</td>
                        <td>{{ $history->description }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada riwayat pergerakan stok.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">{{ $histories->links() }}</div>
    </div>
</div>

<script>
    document.getElementById('historySearch').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#historyTable tr');
        rows.forEach(row => {
            let productName = row.querySelector('.product-name')?.innerText.toLowerCase() || '';
            row.style.display = productName.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection