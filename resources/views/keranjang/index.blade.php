@extends('layouts.app')

@section('content')
<div id="checkout-data"
    data-shipping-costs="{{ $shippingCosts_json }}"
    data-addresses="{{ $keyedAddresses_json }}"
    data-subtotal="{{ $totalAmount }}"
    style="display: none;">
</div>
<div class="container">
    <h1 class="mb-4 fw-bold">Checkout</h1>

    @if ($cartItems->isEmpty())
    <div class="alert alert-warning">Keranjang belanja Anda kosong.</div>
    @else
    <div class="row g-5">
        <div class="col-md-7">
            <h4 class="fw-semibold mb-3">Pilih Alamat Pengiriman</h4>
            <div class="list-group mb-4">
                @foreach($addresses as $address)
                <label class="list-group-item d-flex gap-3">
                    <input class="form-check-input flex-shrink-0" type="radio" name="address_id" value="{{ $address->id }}" {{ $address->is_primary ? 'checked' : '' }} onchange="calculateShipping({{ $address->id }})">
                    <span class="pt-1 form-checked-content">
                        <strong>{{ $address->receiver_name }}</strong> ({{ $address->receiver_phone }})
                        <small class="d-block text-muted">{{ $address->address }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</small>
                    </span>
                </label>
                @endforeach
            </div>

            <h4 class="fw-semibold mb-3">Item Pesanan</h4>
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    @foreach ($cartItems as $item)
                    <div class="row align-items-center mb-3 pb-3 border-bottom">
                        <div class="col-2 col-md-1">
                            <img src="https://placehold.co/75x75" class="img-fluid rounded">
                        </div>
                        <div class="col-10 col-md-4">
                            <h6 class="mb-0">{{ $item->produk->name }}</h6>
                            <small class="text-muted">Rp {{ number_format($item->produk->final_price, 0,',','.') }}</small>
                        </div>
                        <div class="col-6 col-md-3 mt-2 mt-md-0">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $item->quantity }}" min="1" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-outline-primary ms-2">Update</button>
                            </form>
                        </div>
                        <div class="col-4 col-md-3 text-md-end fw-bold">
                            <span>Rp {{ number_format($item->produk->final_price * $item->quantity, 0,',','.') }}</span>
                        </div>
                        <div class="col-2 col-md-1 text-end">
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">&times;</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Ringkasan Belanja</h5>
                    <div class="mb-3">
                        <label for="voucher" class="form-label">Punya Voucher?</label>
                        <select name="voucher" id="voucher" class="form-select" onchange="applyVoucher()">
                            <option value="" data-type="" data-value="0" data-max="0">Pilih Voucher</option>
                            @foreach($vouchers as $voucher)
                            <option value="{{ $voucher->id }}" data-type="{{ $voucher->type }}" data-value="{{ $voucher->value }}" data-max="{{ $voucher->max_discount ?? 0 }}">{{ $voucher->code }} - {{ $voucher->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp {{ number_format($totalAmount, 0,',','.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Ongkos Kirim</span>
                            <span id="shipping-cost">Rp 0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 text-danger">
                            <span>Diskon Voucher</span>
                            <span id="voucher-discount">- Rp 0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 fw-bold fs-5">
                            <span>Total Harga</span>
                            <span id="grand-total">Rp {{ number_format($totalAmount, 0,',','.') }}</span>
                        </li>
                    </ul>
                    <form action="{{ route('checkout.process') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="customer_address_id" id="selected_address_id">
                        <input type="hidden" name="voucher_id" id="selected_voucher_id">
                        <input type="hidden" name="shipping_cost" id="shipping_cost_input"> <button type="submit" class="btn btn-primary w-100 btn-lg">Bayar Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    const dataElement = document.getElementById('checkout-data');

    const shippingCosts = JSON.parse(dataElement.dataset.shippingCosts);
    const addresses = JSON.parse(dataElement.dataset.addresses);
    const subtotal = parseFloat(dataElement.dataset.subtotal);

    function calculateShipping(addressId) {
        const address = addresses[addressId];
        document.getElementById('selected_address_id').value = addressId;
        const costData = shippingCosts[address.city];
        const shippingCost = costData ? costData.cost_per_kg * 2 : 25000;

        document.getElementById('shipping-cost').innerText = 'Rp ' + shippingCost.toLocaleString('id-ID');
        updateTotals();
    }

    function applyVoucher() {
        updateTotals();
    }

    function updateTotals() {
        const shippingCostEl = document.getElementById('shipping-cost');
        let shippingCost = parseInt(shippingCostEl.innerText.replace(/[^0-9]/g, '')) || 0;

        document.getElementById('shipping_cost_input').value = shippingCost;

        const voucherSelect = document.getElementById('voucher');
        const selectedVoucher = voucherSelect.options[voucherSelect.selectedIndex];
        document.getElementById('selected_voucher_id').value = voucherSelect.value;

        let discount = 0;
        const type = selectedVoucher.dataset.type;
        const value = parseFloat(selectedVoucher.dataset.value);
        const max = parseFloat(selectedVoucher.dataset.max);

        if (type === 'percentage') {
            discount = subtotal * (value / 100);
            if (max > 0 && discount > max) {
                discount = max;
            }
        } else if (type === 'fixed') {
            discount = value;
        }

        document.getElementById('voucher-discount').innerText = '- Rp ' + Math.round(discount).toLocaleString('id-ID');

        const grandTotal = subtotal + shippingCost - discount;
        document.getElementById('grand-total').innerText = 'Rp ' + Math.round(grandTotal).toLocaleString('id-ID');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const checkedAddress = document.querySelector('input[name="address_id"]:checked');
        if (checkedAddress) {
            calculateShipping(checkedAddress.value);
        } else {
            updateTotals();
        }
    });
</script>
@endsection