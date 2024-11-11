<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'warranty_type',
        'warranty_duration',
        'warranty_duration_type',
        'status',
        'user_id',
        'category_id'
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
