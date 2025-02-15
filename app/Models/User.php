<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'second_last_name',
        'display_name',
        'phone',
        'email',
        'avatar',
        'identity_document',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    protected $appends = ['cart_id', 'favorite_id'];

    public function getCartIdAttribute()
    {
        return $this->cart?->id;
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function favorite()
    {
        return $this->hasOne(Favorite::class);
    }

    public function getFavoriteIdAttribute()
    {
        return $this->favorite?->id;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function purchases()
    {
        return $this->hasMany(Order::class)->whereIn('status', ['completed', 'pending', 'processing']);
    }
}
