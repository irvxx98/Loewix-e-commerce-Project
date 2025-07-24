<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\DealerBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Auth::user()->dealerBanners()->latest()->get();
        return view('dealer.banner.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('image')->store('banners/dealers', 'public');
        $validated['image'] = $path;
        $validated['dealer_id'] = Auth::id();

        DealerBanner::create($validated);
        return back()->with('success', 'Banner berhasil ditambahkan.');
    }

    public function destroy(DealerBanner $dealerBanner)
    {
        if ($dealerBanner->dealer_id !== Auth::id()) {
            abort(403);
        }
        $dealerBanner->delete();
        return back()->with('success', 'Banner berhasil dihapus.');
    }
}
