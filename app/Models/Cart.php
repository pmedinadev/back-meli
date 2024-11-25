<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_products')
            ->withPivot(['id', 'quantity'])
            ->withTimestamps()
            ->with([
                'photos' => function ($query) {
                    $query->select('id', 'url', 'public_id', 'product_id');
                },
                'user' => function ($query) {
                    $query->select('id', 'username', 'display_name');
                }
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
