<?php

namespace App\Services;

use App\Enums\StockOrderStatus;
use App\Models\Produk;
use App\Models\StockOrder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockOrderService
{
    public function createStockOrder(User $dealer, array $items)
    {
        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $orderItemsData = [];

            $productIds = array_column($items, 'produk_id');
            $products = Produk::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($items as $item) {
                $product = $products->get($item['produk_id']);
                if (!$product) {
                    throw new \Exception("Produk dengan ID {$item['produk_id']} tidak ditemukan.");
                }
                $price = $product->harga; // Asumsi harga beli dealer = harga jual
                $totalAmount += $price * $item['quantity'];
                $orderItemsData[] = [
                    'produk_id' => $item['produk_id'],
                    'quantity' => $item['quantity'],
                    'price' => $price,
                ];
            }

            $stockOrder = $dealer->stockOrders()->create([
                'order_code' => 'STK-' . strtoupper(uniqid()),
                'total_amount' => $totalAmount,
                'status' => StockOrderStatus::PENDING_PAYMENT,
            ]);

            $stockOrder->items()->createMany($orderItemsData);

            DB::commit();
            return ['success' => true, 'order' => $stockOrder];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal membuat pesanan stok: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function confirmPaymentAndUpdateInventory(StockOrder $stockOrder)
    {
        if ($stockOrder->status !== StockOrderStatus::PENDING_PAYMENT) {
            return ['success' => false, 'message' => 'Pesanan ini tidak dalam status menunggu pembayaran.'];
        }

        DB::beginTransaction();
        try {
            foreach ($stockOrder->items as $item) {
                $inventory = $stockOrder->dealer->inventories()->firstOrNew([
                    'produk_id' => $item->produk_id,
                ]);
                $inventory->quantity = ($inventory->quantity ?? 0) + $item->quantity;
                $inventory->save();
            }

            $stockOrder->update(['status' => StockOrderStatus::COMPLETED]);

            DB::commit();
            return ['success' => true, 'message' => 'Pembayaran dikonfirmasi dan stok dealer telah diperbarui.'];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal konfirmasi pesanan stok #{$stockOrder->id}: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
