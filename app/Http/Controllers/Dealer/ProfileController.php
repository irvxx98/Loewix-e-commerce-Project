<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerAddress;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user()->load(['dealerProfile', 'addresses']);
        return view('dealer.profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $profile = Auth::user()->dealerProfile;
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
            'store_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('store_logo')) {
            $path = $request->file('store_logo')->store('logos', 'public');
            $validated['store_logo'] = $path;
        }

        $profile->update($validated);
        return back()->with('success', 'Profil toko berhasil diperbarui.');
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:25',
            'address' => 'required|string',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);
        Auth::user()->addresses()->create($validated);
        return back()->with('success_address', 'Alamat baru berhasil ditambahkan.');
    }

    public function destroyAddress(CustomerAddress $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        $address->delete();
        return back()->with('success_address', 'Alamat berhasil dihapus.');
    }
}
