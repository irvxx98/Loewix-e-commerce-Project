@extends('dealer.layout')
@section('dealer_content')
<h3 class="fw-bold">Pesanan Masuk</h3>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Kode Order</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td><span class="badge bg-info">{{ $order->status->value }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Tidak ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">{{ $orders->links() }}</div>
    </div>
</div>
@endsection