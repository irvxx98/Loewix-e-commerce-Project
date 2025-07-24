<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->ordersAsDealer()->with('customer')->latest();
        if ($request->get('status')) {
            $query->where('status', $request->get('status'));
        }
        $orders = $query->paginate(15);
        return view('dealer.pesanan.index', compact('orders'));
    }
    public function show(Order $order)
    {
        if ($order->dealer_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.produk', 'customer', 'shippingAddress']);

        return view('dealer.pesanan.show', compact('order'));
    }
}
