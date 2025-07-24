<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_code',
        'customer_id',
        'dealer_id',
        'total_amount',
        'shipping_address',
        'shipping_province',
        'shipping_city',
        'status',
        'acceptance_deadline',
        'customer_address_id',
        'voucher_id',
        'voucher_code',
        'discount_amount',
        'shipping_cost',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'acceptance_deadline' => 'datetime',
        'status' => OrderStatus::class,
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function assignments()
    {
        return $this->hasMany(OrderDealerAssignment::class, 'order_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'customer_address_id');
    }
}
