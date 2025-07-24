@extends('dealer.layout')
@section('dealer_content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Detail Pembelian #{{ $stockOrder->order_code }}</h3>
    <div>
        <a href="{{ route('dealer.stock_orders.print', $stockOrder) }}" target="_blank" class="btn btn-outline-danger"><i class="fas fa-print me-2"></i>Cetak Nota</a>
        <a href="{{ route('dealer.stock_orders.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">Item yang Dibeli</h5>
            </div>
            <div class="card-body">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th colspan="2">Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stockOrder->items as $item)
                        <tr>
                            <td style="width: 75px;">
                                <img src="{{ $item->produk->images->first() ? asset('storage/' . $item->produk->images->first()->image) : 'https://placehold.co/75x75' }}" class="img-thumbnail">
                            </td>
                            <td>{{ $item->produk->name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">Info Pengiriman</h5>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Penerima:</strong> {{ $stockOrder->shippingAddress->receiver_name }}</p>
                <address class="mb-0 small text-muted">{{ $stockOrder->shippingAddress->address }}, {{ $stockOrder->shippingAddress->city }}</address>
                <p class="mt-2 mb-0"><strong>Total Berat:</strong> {{ $totalWeightKg }} kg</p>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">Rincian Biaya</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0"><span>Subtotal Produk</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></li>
                    <li class="list-group-item d-flex justify-content-between px-0"><span>Ongkos Kirim</span><span>Rp {{ number_format($stockOrder->shipping_cost, 0, ',', '.') }}</span></li>
                    @if($stockOrder->shipping_discount_amount > 0)
                    <li class="list-group-item d-flex justify-content-between px-0 text-success"><span>Potongan Ongkir</span><span>- Rp {{ number_format($stockOrder->shipping_discount_amount, 0, ',', '.') }}</span></li>
                    @endif
                    @if($stockOrder->discount_amount > 0)
                    <li class="list-group-item d-flex justify-content-between px-0 text-success">
                        <span>Diskon @if($voucher) ({{$voucher->code}}) @endif</span>
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