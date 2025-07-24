@extends('admin.layout')
@section('admin_content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-semibold">Semua Riwayat Transaksi</h5>
        <form action="{{ route('admin.orders.all') }}" method="GET" style="width: 300px;">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari kode, customer, dealer..." value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode Order</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Ditangani Oleh</th>
                        <th class="text-end">Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allOrders as $order)
                    <tr>
                        <td><strong>{{ $order->order_code }}</strong></td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->dealer->dealerProfile->store_name ?? 'Loewix Pusat' }}</td>
                        <td class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $order->status->value }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $allOrders->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection