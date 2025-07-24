<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Dealer\DashboardController;
use App\Http\Controllers\Dealer\ProfileController;
use App\Http\Controllers\Dealer\OrderController;
use App\Http\Controllers\Dealer\InventoryController;
use App\Http\Controllers\Dealer\BannerController;
use App\Http\Controllers\Dealer\StockOrderController;
use App\Http\Controllers\Dealer\CartController as DealerCartController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\VoucherController as AdminVoucherController;
use App\Http\Controllers\Admin\DealerTierController as AdminDealerTierController;
use App\Http\Controllers\Admin\StockHistoryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE OTENTIKASI ---
Auth::routes();

// --- RUTE PUBLIK
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/cari', [ProdukController::class, 'search'])->name('produk.search');
Route::get('/kategori/{kategori}', [ProdukController::class, 'showByCategory'])->name('produk.by_category');
Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');

Route::prefix('support')->name('support.')->group(function () {
    Route::get('/', [SupportController::class, 'index'])->name('index');
    Route::get('/tutorials', [SupportController::class, 'tutorials'])->name('tutorials');
    Route::get('/dealers', [SupportController::class, 'dealers'])->name('dealers');
    Route::get('/faq', [SupportController::class, 'faq'])->name('faq');
    Route::get('/contact', [SupportController::class, 'contact'])->name('contact');
    Route::post('/contact', [SupportController::class, 'sendContactMessage'])->name('contact.send');
});

// --- RUTE LOGIN ---
Route::middleware(['auth'])->group(function () {

    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications.index');

    // Rute Keranjang Belanja
    Route::prefix('keranjang')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/tambah/{produk}', [CartController::class, 'store'])->name('store');
        Route::patch('/update/{cartItemId}', [CartController::class, 'update'])->name('update');
        Route::delete('/hapus/{cartItemId}', [CartController::class, 'destroy'])->name('destroy');
    });

    Route::post('/wishlist/toggle/{produk}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Rute Checkout
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/sukses', [CheckoutController::class, 'success'])->name('checkout.success');

    // Rute Akun Customer
    Route::prefix('akun')->name('account.')->group(function () {
        Route::get('/profil', [AccountController::class, 'editProfile'])->name('profil.edit');
        Route::put('/profil', [AccountController::class, 'updateProfile'])->name('profil.update');
        Route::patch('/password', [AccountController::class, 'changePassword'])->name('password.change');

        // Route Alamat
        Route::post('/alamat', [AccountController::class, 'storeAddress'])->name('address.store');
        Route::delete('/alamat/{address}', [AccountController::class, 'destroyAddress'])->name('address.destroy');

        Route::get('/dashboard', [AccountController::class, 'dashboard'])->name('dashboard');
        Route::get('/pesanan', [AccountController::class, 'orderHistory'])->name('orders');
        Route::get('/pesanan/{order}', [AccountController::class, 'orderDetail'])->name('orders.show');
        Route::patch('/pesanan/{order}/batal', [AccountController::class, 'cancelOrder'])->name('orders.cancel');
    });

    Route::post('/voucher/validate-dealer', [VoucherController::class, 'validateForDealer'])->name('voucher.validate.dealer');
});

Route::middleware(['auth', 'is.dealer'])->prefix('dealer')->name('dealer.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/accept', [DashboardController::class, 'acceptOrder'])->name('orders.accept');
    Route::post('/orders/{order}/reject', [DashboardController::class, 'rejectOrder'])->name('orders.reject');

    Route::get('/inventaris', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventaris', [InventoryController::class, 'update'])->name('inventory.update');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
    Route::post('/profil/alamat', [ProfileController::class, 'storeAddress'])->name('profil.address.store');
    Route::delete('/profil/alamat/{address}', [ProfileController::class, 'destroyAddress'])->name('profil.address.destroy');

    Route::get('/banner', [BannerController::class, 'index'])->name('banners.index');
    Route::post('/banner', [BannerController::class, 'store'])->name('banners.store');
    Route::delete('/banner/{dealerBanner}', [BannerController::class, 'destroy'])->name('banners.destroy');

    Route::get('/pembelian', [StockOrderController::class, 'index'])->name('stock_orders.index');
    Route::get('/pembelian/checkout', [StockOrderController::class, 'checkout'])->name('stock_orders.checkout'); // <-- SPESIFIK DI ATAS
    Route::get('/pembelian/{stockOrder}', [StockOrderController::class, 'show'])->name('stock_orders.show'); // <-- UMUM (WILDCARD) DI BAWAH
    Route::post('/pembelian/checkout', [StockOrderController::class, 'placeOrder'])->name('stock_orders.place_order');
    Route::get('/pembelian/{stockOrder}/cetak', [StockOrderController::class, 'printInvoice'])->name('stock_orders.print');

    Route::post('/keranjang-stok/tambah', [DealerCartController::class, 'store'])->name('cart.store');
    Route::patch('/keranjang-stok/update/{cartItem}', [DealerCartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang-stok/hapus/{cartItem}', [DealerCartController::class, 'destroy'])->name('cart.destroy');
});

// --- RUTE KHUSUS ADMIN LOEWIX ---
Route::middleware(['auth', 'is.loewix'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/pesanan/loewix', [AdminOrderController::class, 'loewixOrders'])->name('orders.loewix');
    Route::get('/pesanan/dealer', [AdminOrderController::class, 'dealerOrders'])->name('orders.dealer');
    Route::get('/pesanan/pending', [AdminOrderController::class, 'pendingOrders'])->name('orders.pending');
    Route::get('/pesanan/semua', [AdminOrderController::class, 'allOrders'])->name('orders.all');
    Route::get('/pesanan/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::get('/pesanan-stok/{stockOrder}', [AdminOrderController::class, 'showStockOrder'])->name('orders.stock.show');

    Route::get('/stok', [AdminInventoryController::class, 'index'])->name('inventory.index');
    Route::post('/stok', [AdminInventoryController::class, 'update'])->name('inventory.update');

    Route::resource('/products', AdminProductController::class);
    Route::resource('/vouchers', AdminVoucherController::class);

    Route::delete('/products/images/{image}', [AdminProductController::class, 'destroyImage'])->name('products.images.destroy');

    Route::get('/tiers', [AdminDealerTierController::class, 'index'])->name('tiers.index');
    Route::post('/tiers', [AdminDealerTierController::class, 'update'])->name('tiers.update');

    Route::get('/stok/riwayat', [StockHistoryController::class, 'index'])->name('inventory.history');
});
