<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function orderHistory()
    {
        $orders = Auth::user()->ordersAsCustomer()->latest()->paginate(10);
        return view('user.account.order_history', ['orders' => $orders]);
    }

    public function orderDetail(Order $order)
    {
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.produk', 'dealer.dealerProfile', 'shippingAddress']);

        $subtotal = $order->total_amount + $order->discount_amount - $order->shipping_cost;

        return view('user.account.order_detail', [
            'order' => $order,
            'subtotal' => $subtotal
        ]);
    }

    public function cancelOrder(Order $order)
    {
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        $cancellableStatuses = [
            \App\Enums\OrderStatus::PENDING_DEALER_ACCEPTANCE,
            \App\Enums\OrderStatus::PENDING_PAYMENT,
        ];

        if (in_array($order->status, $cancellableStatuses)) {
            $order->update(['status' => \App\Enums\OrderStatus::CANCELLED]);
            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return back()->with('error', 'Pesanan ini tidak dapat dibatalkan lagi.');
    }

    public function dashboard()
    {
        $user = Auth::user();

        $orderStatusCounts = [
            'processing' => $user->ordersAsCustomer()->where('status', 'processing')->count(),
            'shipped' => $user->ordersAsCustomer()->where('status', 'shipped')->count(),
            'completed' => $user->ordersAsCustomer()->where('status', 'completed')->count(),
        ];

        $recommendations = \App\Models\Produk::where('is_popular', true)
            ->whereDoesntHave('wishlists', fn($q) => $q->where('user_id', $user->id))
            ->withCount('wishlists')
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('user.account.dashboard', compact('user', 'orderStatusCounts', 'recommendations'));
    }

    public function editProfile()
    {
        $user = Auth::user()->load('addresses');
        return view('user.account.profile_edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);
        $user->update($validated);
        return back()->with('success_profile', 'Informasi akun berhasil diperbarui!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success_password', 'Password berhasil diubah!');
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
