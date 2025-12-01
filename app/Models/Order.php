<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'status', // pending, packed, shipped, delivered, cancelled, returned
        'shipping_address',
        'billing_address',
        'shipping_cost',
        'tax_amount',
        'total_amount',
        'payment_method', // cod, upi, card, wallet
        'payment_status', // pending, paid, failed, refunded
        'delivery_user_id', // assigned delivery partner (nullable)
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /* Relationships */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function deliveryAssignment()
    {
        return $this->hasOne(DeliveryAssignment::class);
    }

    public function deliveryUser()
    {
        return $this->belongsTo(User::class, 'delivery_user_id');
    }
}
