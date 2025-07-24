<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;

class InventoryController extends Controller
{
    public function index()
    {
        $produks = Produk::with('images')->orderBy('name')->get();
        $inventory = Auth::user()->inventories()->pluck('quantity', 'produk_id');
        return view('dealer.inventaris.index', compact('produks', 'inventory'));
    }

    public function update(Request $request)
    {
        $dealer = Auth::user();
        foreach ($request->quantities as $produkId => $quantity) {
            $dealer->inventories()->updateOrCreate(
                ['produk_id' => $produkId],
                ['quantity' => $quantity ?? 0]
            );
        }
        return back()->with('success', 'Stok berhasil diperbarui.');
    }
}
