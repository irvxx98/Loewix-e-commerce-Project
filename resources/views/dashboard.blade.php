@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Selamat Datang, {{ Auth::user()->name }}!</h3>
    <p>Ini adalah halaman dashboard khusus untuk Anda mengelola toko.</p>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header fw-bold">
            Pesanan Masuk ({{ $incomingOrders->count() }})
        </div>
        <div class="card-body">
            @forelse ($incomingOrders as $order)
            <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded">
                <div>
                    <strong>Order #{{ $order->order_code }}</strong>
                    <br>
                    <small>Dari: {{ $order->customer->name }} | Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</small>
                </div>
                <div>
                    <a href="#" class="btn btn-success">Terima</a>
                    <a href="#" class="btn btn-danger">Tolak</a>
                </div>
            </div>
            @empty
            <p class="text-center">Tidak ada pesanan masuk saat ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection