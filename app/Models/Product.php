<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'condition',
        'stock',
        'upc',
        'sku',
        'price',
        'publication_type',
        'shipping_cost',
        'shipping_type',
        'warranty_type',
        'warranty_duration',
        'warranty_duration_type',
        'status',
        'slug',
        'user_id',
        'category_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->title);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->title);
        });
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
