<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\User;

class InventoryController extends Controller
{
    public function index()
    {
        $loewix = User::where('role', 'loewix')->first();
        $produks = Produk::orderBy('name')->get();
        $inventory = $loewix->inventories()->pluck('quantity', 'produk_id');
        return view('admin.inventory.index', compact('produks', 'inventory'));
    }

    public function update(Request $request)
    {
        $loewix = User::where('role', 'loewix')->first();
        foreach ($request->quantities as $produkId => $newQuantity) {
            $inventory = $loewix->inventories()->firstOrNew(['produk_id' => $produkId]);

            $quantityBefore = $inventory->quantity ?? 0;
            $newQuantity = $newQuantity ?? 0;

            if ($quantityBefore != $newQuantity) {
                $change = $newQuantity - $quantityBefore;

                \App\Models\StockHistory::create([
                    'user_id' => $loewix->id,
                    'produk_id' => $produkId,
                    'type' => 'koreksi',
                    'quantity_change' => $change,
                    'quantity_before' => $quantityBefore,
                    'quantity_after' => $newQuantity,
                    'description' => 'Stok diubah manual oleh Admin',
                ]);

                $inventory->quantity = $newQuantity;
                $inventory->save();
            }
        }
        return back()->with('success', 'Stok pusat berhasil diperbarui.');
    }
}
