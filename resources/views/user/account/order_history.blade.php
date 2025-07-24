@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('user.account.sidebar')
        <div class="col-md-9">
            <h3>Riwayat Pesanan Saya</h3>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode Order</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td><span class="badge bg-info">{{ $order->status->value }}</span></td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('account.orders.show', $order) }}" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Anda belum memiliki riwayat pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection