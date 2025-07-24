<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'address',
        'province',
        'city',
        'postal_code',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => Role::class,
    ];

    // --------------------------------------------------------------------
    // DEFINISI RELASI
    // --------------------------------------------------------------------

    public function dealerProfile()
    {
        return $this->hasOne(DealerProfile::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function ordersAsCustomer()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function ordersAsDealer()
    {
        return $this->hasMany(Order::class, 'dealer_id');
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'customer_id');
    }

    public function stockOrders()
    {
        return $this->hasMany(StockOrder::class, 'dealer_id');
    }

    public function dealerBanners()
    {
        return $this->hasMany(DealerBanner::class, 'dealer_id');
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    public function dealerCartItems()
    {
        return $this->hasMany(DealerCart::class, 'dealer_id');
    }
}
