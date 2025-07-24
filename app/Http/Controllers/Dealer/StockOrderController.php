<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\StockOrder;
use App\Models\Voucher;
use App\Models\CustomerAddress;
use App\Services\DealerTierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class StockOrderController extends Controller
{
    public function index()
    {
        $stockOrders = Auth::user()->stockOrders()->latest()->paginate(15);
        return view('dealer.pembelian.index', compact('stockOrders'));
    }

    private function getOrderDetails(StockOrder $stockOrder)
    {
        if ($stockOrder->dealer_id !== Auth::id()) {
            abort(403);
        }

        $stockOrder->load(['items.produk.images', 'shippingAddress']);

        $subtotal = 0;
        $totalWeight = 0;
        foreach ($stockOrder->items as $item) {
            $subtotal += $item->price * $item->quantity;
            $totalWeight += $item->produk->berat * $item->quantity;
        }

        $voucher = $stockOrder->voucher_id ? Voucher::find($stockOrder->voucher_id) : null;

        return [
            'stockOrder' => $stockOrder,
            'subtotal' => $subtotal,
            'totalWeightKg' => ceil($totalWeight / 1000),
            'voucher' => $voucher
        ];
    }

    public function show(StockOrder $stockOrder)
    {
        $data = $this->getOrderDetails($stockOrder);
        return view('dealer.pembelian.show', $data);
    }

    public function printInvoice(StockOrder $stockOrder)
    {
        $data = $this->getOrderDetails($stockOrder);
        $pdf = Pdf::loadView('dealer.pembelian.invoice_pdf', $data);
        return $pdf->stream('invoice-' . $stockOrder->order_code . '.pdf');
    }

    public function checkout(DealerTierService $tierService)
    {
        $dealer = Auth::user();
        $cartItems = $dealer->dealerCartItems()->with(['produk.images'])->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('dealer.inventory.index')->with('error', 'Keranjang stok Anda kosong.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->produk->final_price * $item->quantity);
        $tier = $tierService->getTierForDealer($dealer);
        $addresses = $dealer->addresses;
        $primaryAddress = $addresses->where('is_primary', 1)->first() ?? $addresses->first();

        $shippingCost = 0;
        if ($primaryAddress) {
            $totalWeightKg = ceil($cartItems->sum(fn($item) => $item->produk->berat * $item->quantity) / 1000);
            $costData = \App\Models\ShippingCost::where('destination_city', $primaryAddress->city)->first();
            $shippingCost = $costData ? $costData->cost_per_kg * max(1, $totalWeightKg) : 30000 * max(1, $totalWeightKg);
        }

        $vouchers = Voucher::where('for_dealer', true)
            ->where('is_active', 1)
            ->where(fn($q) => $q->whereNull('valid_to')->orWhere('valid_to', '>=', now()))
            ->where(fn($q) => $q->whereNull('usage_limit')->orWhereColumn('usage_count', '<', 'usage_limit'))
            ->get();

        return view('dealer.pembelian.checkout', compact('cartItems', 'subtotal', 'tier', 'addresses', 'shippingCost', 'vouchers'));
    }

    public function placeOrder(Request $request, DealerTierService $tierService)
    {
        $request->validate([
            'customer_address_id' => 'required|exists:customer_addresses,id',
            'voucher_id' => 'nullable|exists:vouchers,id',
            'shipping_cost' => 'required|numeric|min:0'
        ]);

        $dealer = Auth::user();
        $cartItems = $dealer->dealerCartItems()->with('produk')->get();
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang stok kosong.');
        }

        DB::beginTransaction();
        try {
            $subtotal = $cartItems->sum(fn($item) => $item->produk->final_price * $item->quantity);
            $tier = $tierService->getTierForDealer($dealer);

            $tierDiscountAmount = $subtotal * ($tier->product_discount_percentage / 100);
            $totalAfterTierDiscount = $subtotal - $tierDiscountAmount;

            $voucherDiscount = 0;
            $voucherId = $request->input('voucher_id');
            if ($voucherId) {
                $voucher = Voucher::find($voucherId);
                if ($voucher && $subtotal >= $voucher->min_purchase && ($voucher->usage_limit === null || $voucher->usage_count < $voucher->usage_limit)) {
                    if ($voucher->type == 'fixed') {
                        $voucherDiscount = $voucher->value;
                    }
                    $voucher->increment('usage_count');
                } else {
                    $voucherId = null;
                }
            }

            $baseShippingCost = $request->shipping_cost;
            $finalShippingDiscount = min($baseShippingCost, $tier->shipping_discount_amount);
            $finalShippingCost = $baseShippingCost - $finalShippingDiscount;

            $grandTotal = ($totalAfterTierDiscount - $voucherDiscount) + $finalShippingCost;

            $stockOrder = $dealer->stockOrders()->create([
                'order_code' => 'STK-' . strtoupper(uniqid()),
                'total_amount' => max(0, $grandTotal),
                'status' => 'pending_payment',
                'customer_address_id' => $request->customer_address_id,
                'voucher_id' => $voucherId,
                'shipping_cost' => $baseShippingCost,
                'shipping_discount_amount' => $finalShippingDiscount,
                'discount_amount' => $tierDiscountAmount + $voucherDiscount
            ]);

            foreach ($cartItems as $item) {
                $stockOrder->items()->create(['produk_id' => $item->produk_id, 'quantity' => $item->quantity, 'price' => $item->produk->harga]);
            }
            $dealer->dealerCartItems()->delete();
            DB::commit();

            return redirect()->route('dealer.stock_orders.show', $stockOrder)->with('success', 'Pesanan stok berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
