<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $table = 'customer_addresses';

protected $fillable = [
    'customer_id',
    'user_id',
    'type',
    'country',
    'state',
    'city',
    'address_line',
    'landmark',
    'zip_code',
    'contact_phone',
    'is_default',
];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
