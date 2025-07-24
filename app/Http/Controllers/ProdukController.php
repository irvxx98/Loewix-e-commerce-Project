<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function showByCategory(Kategori $kategori)
    {
        $produks = $kategori->produks()->paginate(12);

        return view('produk.kategori', [
            'kategori' => $kategori,
            'produks' => $produks,
        ]);
    }

    public function show(Produk $produk)
    {
        $produk->load(['images', 'wishlists']);
        return view('produk.show', ['produk' => $produk]);
    }

    public function index()
    {
        $produks = \App\Models\Produk::latest()->paginate(12);
        return view('produk.index', compact('produks'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return redirect()->route('produk.index');
        }

        $produks = \App\Models\Produk::where('name', 'LIKE', "%{$query}%")
            ->orWhere('merk', 'LIKE', "%{$query}%")
            ->paginate(16);

        return view('produk.search_results', compact('produks', 'query'));
    }
}
