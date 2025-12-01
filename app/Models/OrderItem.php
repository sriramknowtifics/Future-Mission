<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'vendor_id',
        'name',
        'sku',
        'price',
        'qty',
        'subtotal',
        'attributes', // json variant info (size,color)
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'qty' => 'integer',
        'subtotal' => 'decimal:2',
        'attributes' => 'array',
    ];

    /* Relationships */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
