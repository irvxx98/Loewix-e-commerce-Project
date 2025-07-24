<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\DealerCart;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['produk_id' => 'required|exists:produks,id', 'quantity' => 'required|integer|min:1']);
        $dealer = Auth::user();
        $cartItem = $dealer->dealerCartItems()->where('produk_id', $request->produk_id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            $dealer->dealerCartItems()->create($request->all());
        }
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang stok.');
    }

    public function update(Request $request, DealerCart $cartItem)
    {
        if ($cartItem->dealer_id !== Auth::id()) {
            abort(403);
        }
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem->update(['quantity' => $request->quantity]);
        return redirect()->route('dealer.stock_orders.checkout')->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy(DealerCart $cartItem)
    {
        if ($cartItem->dealer_id !== Auth::id()) {
            abort(403);
        }
        $cartItem->delete();
        return redirect()->route('dealer.stock_orders.checkout')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
