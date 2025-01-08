<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'street_address',
        'no_street_number',
        'zip_code',
        'unknown_zip_code',
        'state',
        'municipality',
        'locality',
        'neighborhood',
        'interior_number',
        'delivery_instructions',
        'address_type',
        'contact_name',
        'contact_phone',
        'is_default'
    ];

    protected $casts = [
        'no_street_number' => 'boolean',
        'unknown_zip_code' => 'boolean',
        'is_default' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
