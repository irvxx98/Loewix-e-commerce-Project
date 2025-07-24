<?php

namespace App\Models;

use App\Enums\OrderDealerAssignmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDealerAssignment extends Model
{
    use HasFactory;

    protected $table = 'order_dealer_assignments';

    protected $fillable = [
        'order_id',
        'dealer_id',
        'status',
        'assigned_at',
        'handled_at',
        'notes',
    ];

    protected $casts = [
        'status' => OrderDealerAssignmentStatus::class,
        'assigned_at' => 'datetime',
        'handled_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }
}
