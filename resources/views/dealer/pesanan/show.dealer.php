@extends('dealer.layout')
@section('dealer_content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Detail Pesanan #{{ $order->order_code }}</h3>
    <a href="{{ route('dealer.orders.index') }}" class="btn btn-sm btn-outline-secondary">Kembali ke Daftar Pesanan</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Item Pesanan</div>
            <div class="card-body">
                @foreach($order->items as $item)
                <div class="d-flex align-items-center @if(!$loop->last) mb-3 pb-3 border-bottom @endif">
                    <img src="https://placehold.co/75x75/e0e0e0/333?text=LWX" class="rounded me-3">
                    <div class="flex-grow-1">
                        <h6 class="mb-0">{{ $item->produk->name }}</h6>
                        <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0,',','.') }}</small>
                    </div>
                    <div class="fw-bold">
                        Rp {{ number_format($item->quantity * $item->price, 0,',','.') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Info Customer & Pengiriman</div>
            <div class="card-body">
                <strong>Customer:</strong>
                <p>{{ $order->customer->name }}</p>
                <strong>Alamat Kirim:</strong>
                <address class="mb-0">
                    <strong>{{ $order->shippingAddress->receiver_name }}</strong><br>
                    {{ $order->shippingAddress->address }}<br>
                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->province }}
                </address>
            </div>
        </div>
        @if($order->status == 'pending_dealer_acceptance')
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-3">
            <form action="{{ route('dealer.orders.accept', $order) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">Terima Pesanan</button>
            </form>
            <form action="{{ route('dealer.orders.reject', $order) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">Tolak Pesanan</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection