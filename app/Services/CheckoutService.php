<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\Role;
use App\Models\Order;
use App\Models\User;
use App\Models\CustomerAddress;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function findBestDealerAndCreateOrder(User $customer, $customerAddressId, $voucherId = null, $shippingCost = 0)
    {
        $cartItems = $customer->cartItems()->with('produk')->get();
        if ($cartItems->isEmpty()) {
            return ['success' => false, 'message' => 'Keranjang belanja Anda kosong.'];
        }
        $selectedAddress = \App\Models\CustomerAddress::find($customerAddressId);
        if (!$selectedAddress) {
            return ['success' => false, 'message' => 'Alamat pengiriman tidak valid.'];
        }

        $productIds = $cartItems->pluck('produk_id')->toArray();
        $itemQuantities = $cartItems->pluck('quantity', 'produk_id');
        $potentialDealerIds = DB::table('inventories')->select('user_id')->whereIn('produk_id', $productIds)->where(function ($query) use ($itemQuantities) {
            foreach ($itemQuantities as $productId => $quantity) {
                $query->orWhere(function ($q) use ($productId, $quantity) {
                    $q->where('produk_id', $productId)->where('quantity', '>=', $quantity);
                });
            }
        })->whereExists(function ($query) {
            $query->select(DB::raw(1))->from('users')->whereColumn('users.id', 'inventories.user_id')->where('role', \App\Enums\Role::DEALER);
        })->groupBy('user_id')->having(DB::raw('count(*)'), '=', count($productIds))->pluck('user_id');
        $dealers = User::whereIn('id', $potentialDealerIds)->get();

        $assignee = null;

        if ($dealers->isEmpty()) {
            $loewixUser = User::where('role', \App\Enums\Role::LOEWIX)->first();
            if ($loewixUser && $this->userHasStock($loewixUser, $itemQuantities)) {
                $assignee = $loewixUser;
            } else {
                return ['success' => false, 'message' => 'Stok tidak tersedia, bahkan di gudang pusat.'];
            }
        } else {
            $assignee = $dealers->firstWhere('city', $selectedAddress->city)
                ?? $dealers->firstWhere('province', $selectedAddress->province)
                ?? $dealers->first();
        }
        if (!$assignee) {
            return ['success' => false, 'message' => 'Tidak dapat menentukan dealer atau pusat untuk pesanan ini.'];
        }

        return $this->createOrder($customer, $assignee, $cartItems, $customerAddressId, $voucherId, $shippingCost);
    }

    private function userHasStock(User $user, $itemQuantities)
    {
        foreach ($itemQuantities as $productId => $quantity) {
            $hasStock = $user->inventories()->where('produk_id', $productId)->where('quantity', '>=', $quantity)->exists();
            if (!$hasStock) {
                return false;
            }
        }
        return true;
    }

    // signature dan logika metode createOrder
    protected function createOrder(User $customer, User $assignee, $cartItems, $customerAddressId, $voucherId = null, $shippingCost = 0)
    {
        $selectedAddress = CustomerAddress::findOrFail($customerAddressId);
        if ($selectedAddress->user_id !== $customer->id) {
            abort(403, 'Alamat tidak valid.');
        }

        DB::beginTransaction();
        try {
            $subtotal = $cartItems->sum(function ($item) {
                return $item->produk->final_price * $item->quantity;
            });
            $discountAmount = 0;
            $voucherCode = null;

            // LOGIKA VOUCHER
            if ($voucherId) {
                $voucher = Voucher::find($voucherId);
                if ($voucher && $subtotal >= $voucher->min_purchase) {
                    if ($voucher->type === 'percentage') {
                        $potentialDiscount = $subtotal * ($voucher->value / 100);
                        $discountAmount = ($voucher->max_discount && $potentialDiscount > $voucher->max_discount) ? $voucher->max_discount : $potentialDiscount;
                    } else { // type === 'fixed'
                        $discountAmount = $voucher->value;
                    }
                    $voucherCode = $voucher->code;
                }
            }

            $grandTotal = ($subtotal - $discountAmount) + $shippingCost;

            $orderData = [
                'order_code' => 'ORD-' . strtoupper(uniqid()),
                'customer_id' => $customer->id,
                'customer_address_id' => $selectedAddress->id,
                'total_amount' => $grandTotal,
                'shipping_address' => $selectedAddress->address,
                'shipping_province' => $selectedAddress->province,
                'shipping_city' => $selectedAddress->city,
                'voucher_id' => $voucherId,
                'voucher_code' => $voucherCode,
                'discount_amount' => $discountAmount,
                'shipping_cost' => $shippingCost,
            ];

            if ($assignee->role === Role::DEALER) {
                $orderData['dealer_id'] = $assignee->id;
                $orderData['status'] = OrderStatus::PENDING_DEALER_ACCEPTANCE;
                $orderData['acceptance_deadline'] = Carbon::now()->addHours(3);
            } else {
                $orderData['dealer_id'] = null;
                $orderData['status'] = OrderStatus::PROCESSING;
            }

            $order = Order::create($orderData);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'produk_id' => $item->produk_id,
                    'quantity' => $item->quantity,
                    'price' => $item->produk->final_price, // Simpan harga setelah diskon produk
                ]);
            }
            if ($assignee->role === Role::DEALER) {
                $order->assignments()->create(['dealer_id' => $assignee->id, 'assigned_at' => Carbon::now(), 'status' => 'offered',]);
            }
            $customer->cartItems()->delete();
            DB::commit();

            return ['success' => true, 'order' => $order, 'message' => 'Pesanan berhasil dibuat.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage()];
        }
    }
}
