@extends('dealer.layout')
@section('dealer_content')

<div id="checkout-data"
    data-subtotal="{{ $subtotal }}"
    data-tier-discount-percent="{{ $tier->product_discount_percentage }}"
    data-shipping-discount-max="{{ $tier->shipping_discount_amount }}"
    data-initial-shipping-cost="{{ $shippingCost }}"
    data-vouchers="{{ $vouchers->mapWithKeys(fn($v) => [$v->id => $v])->toJson() }}"
    style="display: none;">
</div>

<div class="container">
    <h3 class="fw-bold">Keranjang & Checkout Pembelian Stok</h3>
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if ($cartItems->isEmpty())
    <div class="alert alert-warning">Keranjang stok Anda kosong.</div>
    @else
    <div class="row g-5">
        <div class="col-lg-12">
            <h4 class="fw-semibold mb-3">Item Pesanan</h4>
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    @foreach($cartItems as $item)
                    <div class="row align-items-center mb-3 pb-3 @if(!$loop->last) border-bottom @endif">
                        <div class="col-2 col-md-1"><img src="{{ $item->produk->images->first() ? asset('storage/' . $item->produk->images->first()->image) : 'https://placehold.co/75x75' }}" class="img-fluid rounded"></div>
                        <div class="col-10 col-md-4">
                            <h6 class="mb-0">{{ $item->produk->name }}</h6><small>Rp {{ number_format($item->produk->final_price, 0,',','.') }}</small>
                        </div>
                        <div class="col-6 col-md-3 mt-2 mt-md-0">
                            <form action="{{ route('dealer.cart.update', $item) }}" method="POST" class="d-flex">
                                @csrf @method('PATCH')
                                <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $item->quantity }}" min="1" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-outline-primary ms-2">Update</button>
                            </form>
                        </div>
                        <div class="col-4 col-md-3 text-md-end fw-bold"><span>Rp {{ number_format($item->quantity * $item->produk->final_price, 0,',','.') }}</span></div>
                        <div class="col-2 col-md-1 text-end">
                            <form action="{{ route('dealer.cart.destroy', $item) }}" method="POST">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">&times;</button></form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card shadow-sm sticky-top border-0" style="top: 100px;">
                <form action="{{ route('dealer.stock_orders.place_order') }}" method="POST">
                    @csrf
                    <input type="hidden" name="voucher_id" id="selected_voucher_id">
                    <input type="hidden" name="shipping_cost" id="shipping_cost_input">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0">Ringkasan Pembelian</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Pilih Alamat Pengiriman</label>
                            <div class="list-group list-group-flush border rounded">
                                @forelse($addresses as $address)
                                <label class="list-group-item d-flex gap-3">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="customer_address_id" value="{{ $address->id }}" {{ $address->is_primary ? 'checked' : '' }} required>
                                    <span class="pt-1 form-checked-content"><strong>{{ $address->receiver_name }}</strong><small class="d-block text-muted">{{ $address->address }}, {{ $address->city }}</small></span>
                                </label>
                                @empty
                                <div class="alert alert-warning mb-0">Anda belum punya alamat. <a href="{{ route('dealer.profil.edit') }}">Tambah Alamat</a></div>
                                @endforelse
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="voucher_id_select" class="form-label">Voucher Khusus</label>
                            <select id="voucher_id_select" class="form-select">
                                <option value="">Pilih Voucher</option>
                                @foreach($vouchers as $voucher)
                                <option value="{{ $voucher->id }}">{{ $voucher->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0"><span>Subtotal Produk</span><span>Rp {{ number_format($subtotal, 0,',','.') }}</span></li>
                            <li class="list-group-item d-flex justify-content-between px-0 text-success"><span>Diskon Tier ({{ $tier->name }})</span><span id="tier-discount-span">- Rp 0</span></li>
                            <li class="list-group-item d-flex justify-content-between px-0"><span>Ongkos Kirim</span><span id="shipping-cost-span">Rp 0</span></li>
                            <li class="list-group-item d-flex justify-content-between px-0 text-success"><span>Potongan Ongkir</span><span id="shipping-discount-span">- Rp 0</span></li>
                            <li class="list-group-item d-flex justify-content-between px-0 text-danger" id="voucher-discount-row" style="display: none;"><span>Diskon Voucher</span><span id="voucher-discount-span">- Rp 0</span></li>
                            <li class="list-group-item d-flex justify-content-between px-0 fw-bold fs-5 border-top pt-3"><span>Grand Total</span><span id="grand-total-span">Rp 0</span></li>
                        </ul>
                    </div>
                    <div class="card-footer p-3">
                        <button type="submit" class="btn btn-primary w-100" @if($addresses->isEmpty()) disabled @endif>Buat Pesanan Stok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dataElement = document.getElementById('checkout-data');
        const voucherSelect = document.getElementById('voucher_id_select');
        const vouchersData = JSON.parse(dataElement.dataset.vouchers);

        function calculateTotals() {
            const subtotal = parseFloat(dataElement.dataset.subtotal);
            const tierDiscountPercent = parseFloat(dataElement.dataset.tierDiscountPercent);
            const shippingDiscountMax = parseFloat(dataElement.dataset.shippingDiscountMax);
            const baseShippingCost = parseFloat(dataElement.dataset.initialShippingCost);
            let voucherDiscount = 0;

            document.getElementById('shipping_cost_input').value = baseShippingCost;

            const selectedVoucherId = voucherSelect.value;
            document.getElementById('selected_voucher_id').value = selectedVoucherId;
            if (selectedVoucherId && vouchersData[selectedVoucherId]) {
                const voucher = vouchersData[selectedVoucherId];
                if (subtotal >= voucher.min_purchase) {
                    if (voucher.type === 'fixed') {
                        voucherDiscount = voucher.value;
                    }
                }
            }

            const tierDiscountAmount = subtotal * (tierDiscountPercent / 100);
            const finalShippingDiscount = Math.min(baseShippingCost, shippingDiscountMax);
            const finalShippingCost = baseShippingCost - finalShippingDiscount;
            const grandTotal = (subtotal - tierDiscountAmount - voucherDiscount) + finalShippingCost;

            document.getElementById('tier-discount-span').innerText = '- Rp ' + Math.round(tierDiscountAmount).toLocaleString('id-ID');
            document.getElementById('voucher-discount-row').style.display = voucherDiscount > 0 ? 'flex' : 'none';
            document.getElementById('voucher-discount-span').innerText = '- Rp ' + Math.round(voucherDiscount).toLocaleString('id-ID');
            document.getElementById('shipping-cost-span').innerText = 'Rp ' + baseShippingCost.toLocaleString('id-ID');
            document.getElementById('shipping-discount-span').innerText = '- Rp ' + finalShippingDiscount.toLocaleString('id-ID');
            document.getElementById('grand-total-span').innerText = 'Rp ' + Math.max(0, grandTotal).toLocaleString('id-ID');
        }

        voucherSelect.addEventListener('change', calculateTotals);
        calculateTotals();
    });
</script>
@endsection