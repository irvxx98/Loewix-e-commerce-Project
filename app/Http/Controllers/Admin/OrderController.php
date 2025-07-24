<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StockOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function pendingOrders(Request $request)
    {
        $query = Order::whereIn('status', ['pending_dealer_acceptance', 'processing'])
            ->with(['customer', 'dealer']);

        if ($request->get('sort')) {
            $query->orderBy($request->get('sort'), $request->get('direction', 'desc'));
        } else {
            $query->latest();
        }

        $pendingOrders = $query->paginate(15);

        return view('admin.orders.pending', compact('pendingOrders'));
    }

    public function loewixOrders()
    {
        $customerOrders = Order::whereNull('dealer_id')->with('customer')->latest()->paginate(10, ['*'], 'customer_page');
        $stockOrders = StockOrder::with('dealer')->latest()->paginate(10, ['*'], 'stock_page');
        return view('admin.orders.loewix', compact('customerOrders', 'stockOrders'));
    }

    public function dealerOrders()
    {
        $dealerOrders = Order::whereNotNull('dealer_id')->with(['customer', 'dealer'])->latest()->paginate(15);
        return view('admin.orders.dealer', compact('dealerOrders'));
    }

    public function allOrders(Request $request)
    {
        $query = Order::with(['customer', 'dealer.dealerProfile']);
        if ($request->get('search')) {
            $search = $request->get('search');
            $query->where('order_code', 'like', "%{$search}%")
                ->orWhereHas('customer', fn($q) => $q->where('name', 'like', "%{$search}%"))
                ->orWhereHas('dealer', fn($q) => $q->where('name', 'like', "%{$search}%"));
        }
        $allOrders = $query->latest()->paginate(15);
        return view('admin.orders.all', compact('allOrders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.produk.images', 'customer', 'dealer.dealerProfile', 'shippingAddress', 'assignments']);

        $subtotal = 0;
        foreach ($order->items as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        $progressSteps = [
            'created' => ['status' => 'Pesanan Dibuat', 'time' => $order->created_at],
            'processed' => ['status' => 'Pesanan Diproses', 'time' => $order->status == 'processing' ? $order->updated_at : null],
            'shipped' => ['status' => 'Pesanan Dikirim', 'time' => $order->status == 'shipped' ? $order->updated_at : null],
            'completed' => ['status' => 'Pesanan Selesai', 'time' => $order->status == 'completed' ? $order->updated_at : null],
        ];

        if ($order->status == 'cancelled') {
            $progressSteps['cancelled'] = ['status' => 'Pesanan Dibatalkan', 'time' => $order->updated_at];
        }


        return view('admin.orders.show', compact('order', 'subtotal', 'progressSteps'));
    }

    public function processStockOrder(StockOrder $stockOrder)
    {
        $stockOrder->update(['status' => 'processing']);
        return back()->with('success', "Pesanan stok #{$stockOrder->order_code} telah diproses.");
    }

    public function showStockOrder(StockOrder $stockOrder)
    {
        $stockOrder->load(['items.produk.images', 'dealer.dealerProfile', 'shippingAddress']);

        $subtotal = 0;
        foreach ($stockOrder->items as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        $progressSteps = [
            'created' => ['status' => 'Pesanan Dibuat', 'time' => $stockOrder->created_at],
            'processing' => ['status' => 'Pesanan Diproses', 'time' => $stockOrder->status == 'processing' ? $stockOrder->updated_at : null],
            'shipped' => ['status' => 'Pesanan Dikirim', 'time' => $stockOrder->status == 'shipped' ? $stockOrder->updated_at : null],
            'completed' => ['status' => 'Pesanan Selesai', 'time' => $stockOrder->status == 'completed' ? $stockOrder->updated_at : null],
        ];

        if ($stockOrder->status == 'cancelled') {
            $progressSteps['cancelled'] = ['status' => 'Pesanan Dibatalkan', 'time' => $stockOrder->updated_at];
        }

        return view('admin.orders.show_stock', compact('stockOrder', 'subtotal', 'progressSteps'));
    }
}
