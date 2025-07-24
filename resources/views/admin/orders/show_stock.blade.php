@extends('admin.layout')
@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Detail Pesanan Stok #{{ $stockOrder->order_code }}</h3>
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Kembali</a>
</div>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">Progress Pesanan</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    @foreach($progressSteps as $step)
                    @if($step['time'])
                    <li class="d-flex mb-3">
                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                        <div>
                            <strong class="d-block">{{ $step['status'] }}</strong>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($step['time'])->format('d M Y, H:i') }}</small>
                        </div>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h6 class="text-muted">Dealer Pemesan</h6>
                        <p class="fw-semibold">{{ $stockOrder->dealer->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Alamat Pengiriman</h6>
                        <address class="mb-0 small">
                            <strong>{{ $stockOrder->shippingAddress->receiver_name }}</strong><br>
                            {{ $stockOrder->shippingAddress->address }}, {{ $stockOrder->shippingAddress->city }}
                        </address>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">Rincian Item</h5>
            </div>
            <div class="card-body">
                @foreach($stockOrder->items as $item)
                <div class="d-flex align-items-center @if(!$loop->last) mb-3 pb-3 border-bottom @endif">
                    <img src="{{ $item->produk->images->first() ? asset('storage/' . $item->produk->images->first()->image) : 'https://placehold.co/60x60' }}" class="rounded me-3" style="width:60px; height:60px; object-fit:cover;">
                    <div class="flex-grow-1">
                        <h6 class="mb-0 small">{{ $item->produk->name }}</h6>
                        <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0,',','.') }}</small>
                    </div>
                    <div class="fw-bold">Rp {{ number_format($item->quantity * $item->price, 0,',','.') }}</div>
                </div>
                @endforeach
                <hr>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0"><span>Subtotal Produk</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></li>
                    <li class="list-group-item d-flex justify-content-between px-0"><span>Ongkos Kirim</span><span>Rp {{ number_format($stockOrder->shipping_cost, 0, ',', '.') }}</span></li>
                    @if($stockOrder->shipping_discount_amount > 0)
                    <li class="list-group-item d-flex justify-content-between px-0 text-success"><span>Potongan Ongkir</span><span>- Rp {{ number_format($stockOrder->shipping_discount_amount, 0, ',', '.') }}</span></li>
                    @endif
                    @if($stockOrder->discount_amount > 0)
                    <li class="list-group-item d-flex justify-content-between px-0 text-success">
                        <span>Diskon</span>
                        <span>- Rp {{ number_format($stockOrder->discount_amount, 0, ',', '.') }}</span>
                    </li>
                    @endif
                    <li class="list-group-item d-flex justify-content-between px-0 fw-bold fs-5 border-top pt-3">
                        <span>Grand Total</span>
                        <span>Rp {{ number_format($stockOrder->total_amount, 0, ',', '.') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection