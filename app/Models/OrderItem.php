<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

        'attributes',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'qty'       => 'integer',
        'subtotal'  => 'decimal:2',
        'attributes'=> 'array',
    ];
    protected static function booted()
    {
        Log::info("🔥 OrderItem model LOADED", [
            'file' => __FILE__,
            'model' => static::class
        ]);
    }
        public function product()
    {
        Log::info("The product OrderItem model LOADED", [
            'file' => __FILE__,
            'model' => static::class
        ]);
        return $this->belongsTo(Product::class)->withTrashed();
    }
    /* -----------------------
       RELATIONSHIPS
    ------------------------*/

    public function order()
    {
        return $this->belongsTo(Order::class);
    }



    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
