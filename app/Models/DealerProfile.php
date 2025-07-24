<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerProfile extends Model
{
    use HasFactory;

    protected $table = 'dealer_profiles';

    protected $fillable = [
        'user_id',
        'store_name',
        'store_slug',
        'store_logo',
        'store_image',
        'store_maps',
        'store_description',
    ];

    // --------------------------------------------------------------------
    // DEFINISI RELASI 
    // --------------------------------------------------------------------

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
