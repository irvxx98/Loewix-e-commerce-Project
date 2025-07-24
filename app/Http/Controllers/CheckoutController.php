<?php

namespace App\Http\Controllers;

use App\Models\ShippingCost;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'customer_address_id' => 'required|exists:customer_addresses,id',
            'voucher_id' => 'nullable|exists:vouchers,id',
            'shipping_cost' => 'required|numeric|min:0'
        ]);

        $customer = Auth::user();

        $result = $this->checkoutService->findBestDealerAndCreateOrder(
            $customer,
            $request->customer_address_id,
            $request->voucher_id,
            $request->shipping_cost
        );

        if (!$result['success']) {
            return redirect()->route('cart.index')->with('error', $result['message']);
        }

        return redirect()->route('checkout.success')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success()
    {
        return view('checkout.success');
    }
}
