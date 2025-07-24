<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function validateForDealer(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string',
            'subtotal' => 'required|numeric'
        ]);

        $code = $request->input('voucher_code');
        $subtotal = $request->input('subtotal');

        $voucher = Voucher::where('code', $code)->where('for_dealer', true)->first();

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Kode voucher tidak ditemukan.']);
        }
        if (!$voucher->is_active || ($voucher->valid_to && $voucher->valid_to < now())) {
            return response()->json(['success' => false, 'message' => 'Voucher sudah tidak berlaku.']);
        }
        if ($voucher->usage_limit !== null && $voucher->usage_count >= $voucher->usage_limit) {
            return response()->json(['success' => false, 'message' => 'Voucher sudah habis digunakan.']);
        }
        if ($subtotal < $voucher->min_purchase) {
            $minPurchaseFormatted = number_format($voucher->min_purchase, 0, ',', '.');
            return response()->json(['success' => false, 'message' => "Minimal belanja untuk voucher ini adalah Rp {$minPurchaseFormatted}."]);
        }

        $discountAmount = 0;
        if ($voucher->type === 'percentage') {
            $potentialDiscount = $subtotal * ($voucher->value / 100);
            $discountAmount = ($voucher->max_discount && $potentialDiscount > $voucher->max_discount) ? $voucher->max_discount : $potentialDiscount;
        } else {
            $discountAmount = $voucher->value;
        }

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil digunakan!',
            'discount_amount' => round($discountAmount),
            'voucher_id' => $voucher->id
        ]);
    }
}
