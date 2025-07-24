<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\DealerTierService;

class DashboardController extends Controller
{
    public function index(DealerTierService $tierService)
    {
        $dealer = Auth::user();

        $currentTier = $tierService->getTierForDealer($dealer);

        $stats = [
            'pending_orders' => $dealer->ordersAsDealer()->where('status', 'pending_dealer_acceptance')->count(),
            'active_products' => $dealer->inventories()->where('quantity', '>', 0)->count(),
        ];

        $recentOrders = $dealer->ordersAsDealer()
            ->where('status', 'pending_dealer_acceptance')
            ->with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view('dealer.dashboard', compact('stats', 'recentOrders', 'currentTier'));
    }

    public function acceptOrder(Order $order)
    {
        if ($order->dealer_id !== Auth::id() || $order->status !== \App\Enums\OrderStatus::PENDING_DEALER_ACCEPTANCE) {
            abort(403);
        }

        foreach ($order->items as $item) {
            Auth::user()->inventories()->where('produk_id', $item->produk_id)->decrement('quantity', $item->quantity);
        }

        $order->assignments()->where('status', 'offered')->update(['status' => 'accepted']);
        $order->update(['status' => 'processing']);
        $order->customer->notify(new \App\Notifications\OrderStatusUpdated($order));

        return back()->with('success', 'Pesanan berhasil diterima.');
    }

    public function rejectOrder(Order $order)
    {
        if ($order->dealer_id !== Auth::id() || $order->status !== \App\Enums\OrderStatus::PENDING_DEALER_ACCEPTANCE) {
            abort(403);
        }

        $order->assignments()->where('status', 'offered')->update(['status' => 'rejected']);
        $order->update(['status' => 'searching_new_dealer']);

        return back()->with('success', 'Pesanan telah ditolak.');
    }
}
