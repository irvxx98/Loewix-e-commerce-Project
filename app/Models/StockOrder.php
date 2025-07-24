<?php

namespace App\Models;

use App\Enums\StockOrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOrder extends Model
{
    use HasFactory;

    protected $table = 'stock_orders';

    protected $fillable = [
        'dealer_id',
        'order_code',
        'total_amount',
        'status',
        'customer_address_id',
        'voucher_id',
        'shipping_cost',
        'shipping_discount_amount',
        'discount_amount',
    ];

    protected $casts = [
        'status' => StockOrderStatus::class,
        'total_amount' => 'decimal:2',
    ];

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    public function items()
    {
        return $this->hasMany(StockOrderItem::class, 'stock_order_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'customer_address_id');
    }
}
