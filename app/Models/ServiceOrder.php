<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'vendor_id',

        'booking_date',
        'booking_time',
        'duration_minutes',

        'customer_name',
        'customer_phone',
        'address',
        'latitude',
        'longitude',

        'base_price',
        'discount',
        'tax_amount',
        'total_amount',

        'service_status',
        'payment_status',
        'payment_method',
        'transaction_id',

        'assigned_user_id',

        'rating',
        'review',

        'otp_code',
        'otp_verified_at',
        'notes',
    ];

    protected $dates = [
        'booking_date',
        'booking_time',
        'otp_verified_at',
    ];

    /* ============================
        RELATIONSHIPS
    =============================*/

    // Customer
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // Assigned Technician
    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}
