@extends('admin.layout')
@section('admin_content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-semibold">Pesanan Perlu Diproses</h5>
        <div style="width: 300px;"><input type="text" id="orderSearch" class="form-control" placeholder="Cari pesanan..."></div>
    </div>
    <div class="card-body bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Kode Order</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Ditangani Oleh</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="orderTable">
                    @forelse ($pendingOrders as $order)
                    <tr class="order-row">
                        <td><strong>{{ $order->order_code }}</strong></td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->dealer->name ?? 'Loewix Pusat' }}</td>
                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>
                            @if($order->status->value == 'pending_dealer_acceptance')
                            <span class="badge bg-warning text-dark">Perlu Konfirmasi</span>
                            @elseif($order->status->value == 'processing')
                            <span class="badge bg-info">Sedang Diproses</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada pesanan yang perlu diproses.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">{{ $pendingOrders->links() }}</div>
    </div>
</div>

<script>
    document.getElementById('orderSearch').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        document.querySelectorAll('#orderTable tr.order-row').forEach(row => {
            let text = row.querySelector('.order-data').innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection