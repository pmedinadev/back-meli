<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'favorite_id',
        'product_id'
    ];

    public function favorite()
{
    return $this->belongsTo(Favorite::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}

}
