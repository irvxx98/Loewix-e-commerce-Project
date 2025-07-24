@extends('dealer.layout')

@section('dealer_content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Dashboard</h3>
</div>


<div class="card shadow-sm border-0 mb-4 bg-primary text-white">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title">Peringkat Anda: <strong>{{ $currentTier->name }}</strong></h5>
            <p class="mb-0">Keuntungan: Diskon Produk {{ $currentTier->product_discount_percentage }}% & Potongan Ongkir Rp{{ number_format($currentTier->shipping_discount_amount, 0, ',', '.') }}</p>
        </div>
        <div class="fs-1">
            @if($currentTier->name == 'Platinum')
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            @elseif($currentTier->name == 'Gold')
            <i class="fas fa-star"></i><i class="fas fa-star"></i>
            @elseif($currentTier->name == 'Silver')
            <i class="fas fa-star"></i>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0 me-3">
                    <div class="bg-warning rounded p-3">
                        <i class="fas fa-box-open fa-2x text-white"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h6 class="text-muted mb-1">Pesanan Perlu Diproses</h6>
                    <h4 class="fw-bold mb-0">{{ $stats['pending_orders'] }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0 me-3">
                    <div class="bg-info rounded p-3">
                        <i class="fas fa-boxes-stacked fa-2x text-white"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h6 class="text-muted mb-1">Produk dalam Stok</h6>
                    <h4 class="fw-bold mb-0">{{ $stats['active_products'] }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mt-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Pesanan Terbaru Perlu Persetujuan</h5>
        <a href="{{ route('dealer.orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body">
        @forelse ($recentOrders as $order)
        <div class="d-flex justify-content-between align-items-center py-2 @if(!$loop->last) border-bottom @endif">
            <div>
                <strong class="d-block">#{{ $order->order_code }}</strong>
                <small class="text-muted">Dari: {{ $order->customer->name }} | Total: Rp {{ number_format($order->total_amount, 0,',','.') }}</small>
            </div>
            <div>
                <a href="{{ route('dealer.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                <form action="{{ route('dealer.orders.accept', $order) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">Terima</button>
                </form>
                <form action="{{ route('dealer.orders.reject', $order) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-center text-muted m-3">Tidak ada pesanan masuk saat ini. ✨</p>
        @endforelse
    </div>
</div>
@endsection