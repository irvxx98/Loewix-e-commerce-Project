@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('user.account.sidebar')

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Detail Pesanan #{{ $order->order_code }}</h3>
                <a href="{{ route('account.orders') }}" class="btn btn-sm btn-outline-secondary">Kembali ke Riwayat</a>
            </div>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h5 class="card-title fw-semibold">Info Pesanan</h5>
                            <ul class="list-unstyled mb-0">
                                <li><strong>Nama Akun:</strong> {{ $order->customer->name }}</li>
                                <li><strong>Tanggal:</strong> {{ $order->created_at->format('d F Y H:i') }}</li>
                                <li><strong>Status:</strong> <span class="badge bg-primary">{{ Str::title(str_replace('_', ' ', $order->status->value)) }}</span></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title fw-semibold">Dikirim Oleh</h5>
                            <ul class="list-unstyled mb-0">
                                @if($order->dealer && $order->dealer->dealerProfile)
                                <li><strong>Toko:</strong> {{ $order->dealer->dealerProfile->store_name }}</li>
                                <li><strong>Lokasi:</strong> {{ $order->dealer->city }}</li>
                                @else
                                <li><strong>Toko:</strong> Gudang Pusat Loewix</li>
                                <li><strong>Lokasi:</strong> Semarang</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <h5 class="card-title fw-semibold">Alamat Pengiriman</h5>
                    <address class="mb-0">
                        <strong>{{ $order->shippingAddress->receiver_name ?? $order->customer->name }}</strong><br>
                        {{ $order->shippingAddress->address ?? 'Alamat tidak tersedia' }}<br>
                        {{ $order->shippingAddress->city ?? '' }}, {{ $order->shippingAddress->province ?? '' }}
                    </address>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
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

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">Rincian Pembayaran</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Subtotal Produk</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Ongkos Kirim</span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </li>
                        @if($order->discount_amount > 0)
                        <li class="list-group-item d-flex justify-content-between px-0 text-success">
                            <span>Diskon ({{ $order->voucher_code }})</span>
                            <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between px-0 fw-bold fs-5 border-top pt-3">
                            <span>Grand Total</span>
                            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            @if(in_array($order->status, [\App\Enums\OrderStatus::PENDING_DEALER_ACCEPTANCE, \App\Enums\OrderStatus::PENDING_PAYMENT]))
            <div class="mt-4">
                <form action="{{ route('account.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-outline-danger w-100">Batalkan Pesanan</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection