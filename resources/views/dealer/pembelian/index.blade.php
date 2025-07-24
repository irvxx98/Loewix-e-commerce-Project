@extends('dealer.layout')
@section('dealer_content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-semibold">Riwayat Pembelian Stok</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Kode Pembelian</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stockOrders as $order)
                    <tr>
                        <td><strong>{{ $order->order_code }}</strong></td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-success">{{ Str::title(str_replace('_', ' ', $order->status->value)) }}</span>
                        </td>
                        <td class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="{{ route('dealer.stock_orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Anda belum memiliki riwayat pembelian stok.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">{{ $stockOrders->links() }}</div>
    </div>
</div>
@endsection