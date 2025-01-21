<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShipping extends Model
{
    use HasFactory;

    protected $table = 'order_shipping';

    protected $fillable = [
        'order_id',
        'address_id',
        'delivery_status',
        'estimated_delivery_date',
        'delivered_at',
        'tracking_number',
        'delivery_notes'
    ];

    protected $casts = [
        'estimated_delivery_date' => 'date',
        'delivered_at' => 'datetime'
    ];

    const DELIVERY_STATUS = [
        'pending' => 'Pendiente',
        'in_transit' => 'En camino',
        'delivered' => 'Entregado',
        'cancelled' => 'Cancelado',
        'returned' => 'Devuelto'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'address_id');
    }
}
