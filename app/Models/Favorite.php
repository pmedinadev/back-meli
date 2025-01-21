<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'favorite_products')
            ->withPivot(['id'])
            ->withTimestamps()
            ->with([
                'photos' => fn($query) => $query->select('id', 'url', 'public_id', 'product_id'),
                'user' => fn($query) => $query->select('id', 'username', 'display_name')
            ])
            ->select([
                'products.id',
                'products.title',
                'products.price',
                'products.stock',
                'products.user_id'
            ]);
    }
}
