<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function store(Request $request, Produk $produk)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $customer = Auth::user();
        $cartItem = $customer->cartItems()->where('produk_id', $produk->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            $customer->cartItems()->create([
                'produk_id' => $produk->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function index()
    {
        $customer = Auth::user();
        $cartItems = $customer->cartItems()->with('produk')->get();

        $addresses = $customer->addresses;
        $keyedAddresses = $addresses->keyBy('id');
        $shippingCosts = \App\Models\ShippingCost::all()->keyBy('destination_city');
        $vouchers = \App\Models\Voucher::where('is_active', 1)->where('valid_to', '>=', now())->get();
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->produk->final_price * $item->quantity;
        });

        return view('keranjang.index', [
            'cartItems' => $cartItems,
            'addresses' => $addresses,
            'vouchers' => $vouchers,
            'keyedAddresses_json' => $keyedAddresses->toJson(),
            'shippingCosts_json' => $shippingCosts->toJson(),
            'totalAmount' => $totalAmount,
        ]);
    }
    public function update(Request $request, $cartItemId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem = Auth::user()->cartItems()->findOrFail($cartItemId);
        $cartItem->update(['quantity' => $request->quantity]);
        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy($cartItemId)
    {
        $cartItem = Auth::user()->cartItems()->findOrFail($cartItemId);
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
