<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produks';

    protected $fillable = [
        'name',
        'harga',
        'kategori_id',
        'merk',
        'berat',
        'garansi',
        'diskon',
        'keterangan',
        'is_archive',
        'is_popular',
        'rating',
        'sold',
    ];

    protected $casts = [
        'is_archive' => 'boolean',
        'is_popular' => 'boolean',
        'rating' => 'float',
        'harga' => 'integer',
        'diskon' => 'integer',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function images()
    {
        return $this->hasMany(ProdukImage::class, 'produk_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'produk_id');
    }

    public function getHasDiscountAttribute()
    {
        return $this->diskon > 0;
    }

    public function getFinalPriceAttribute()
    {
        if ($this->has_discount) {
            $discountedPrice = $this->harga - ($this->harga * $this->diskon / 100);
            return round($discountedPrice);
        }
        return $this->harga;
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'produk_id');
    }
}
