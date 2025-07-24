<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerBanner extends Model
{
    use HasFactory;

    protected $table = 'dealer_banners';

    protected $fillable = [
        'dealer_id',
        'title',
        'subtitle',
        'image',
        'link',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }
}
