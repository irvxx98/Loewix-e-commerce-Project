<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Wishlist;

class HomeController extends Controller
{
    public function index()
    {
        $produksPopuler = \App\Models\Produk::where('is_popular', true)->latest()->take(8)->get();
        $semuaProduk = \App\Models\Produk::latest()->take(8)->get();
        $kategoris = \App\Models\Kategori::where('parent_id', 0)->take(6)->get();
        $produksPopuler = \App\Models\Produk::where('is_popular', true)->withCount('wishlists')->latest()->take(8)->get();

        $banners = [
            'main_banner' => 'images/header-1.jpg',
            'top_right' => 'images/header-2.jpg',
            'bottom_right' => 'images/header-1.jpg',
            'bottom_1' => 'images/header-2.jpg',
            'bottom_2' => 'images/header-1.jpg',
        ];

        return view('home', [
            'produksPopuler' => $produksPopuler,
            'semuaProduk' => $semuaProduk,
            'kategoris' => $kategoris,
            'banners' => $banners
        ]);
    }
}
