<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DealerTier;
use Illuminate\Http\Request;

class DealerTierController extends Controller
{
    public function index()
    {
        $tiers = DealerTier::orderBy('min_monthly_purchase')->get();
        return view('admin.tiers.index', compact('tiers'));
    }

    public function update(Request $request)
    {
        foreach ($request->tiers as $id => $values) {
            DealerTier::find($id)->update($values);
        }
        return back()->with('success', 'Tingkatan dealer berhasil diperbarui.');
    }
}
