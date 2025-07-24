<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->paginate(15);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:vouchers,code',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'valid_to' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:0',
        ]);
        $validated['is_active'] = $request->has('is_active');
        $validated['for_dealer'] = $request->has('for_dealer');

        Voucher::create($validated);
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dibuat.');
    }
}
