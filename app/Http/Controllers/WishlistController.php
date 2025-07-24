<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Produk $produk)
    {
        $wishlist = Auth::user()->wishlists()->where('produk_id', $produk->id)->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
        } else {
            Auth::user()->wishlists()->create(['produk_id' => $produk->id]);
            $status = 'added';
        }

        return response()->json([
            'status' => $status,
            'count' => $produk->wishlists()->count()
        ]);
    }
}