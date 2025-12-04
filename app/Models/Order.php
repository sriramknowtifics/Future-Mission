<?php

namespace App\Models;


use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'tracking_id',

        'status',
        
        'shipping_address',
        'billing_address',

        'subtotal_amount',
        'shipping_cost',
        'tax_amount',
        'total_amount',

        'payment_method',
        'payment_status',
        'payment_reference',

        'delivery_user_id',
        'notes',
        'placed_at',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address'  => 'array',

        'subtotal_amount' => 'decimal:2',
        'shipping_cost'   => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'total_amount'    => 'decimal:2',

        'placed_at' => 'datetime',
    ];

    /* -----------------------
       RELATIONSHIPS
    ------------------------*/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        Log::info("Reaching here");
        return $this->hasMany(OrderItem::class);
    }

    public function deliveryUser()
    {
        return $this->belongsTo(User::class, 'delivery_user_id');
    }

    // If you have delivery assignment table
    public function deliveryAssignment()
    {
        return $this->hasOne(DeliveryAssignment::class);
    }
}
