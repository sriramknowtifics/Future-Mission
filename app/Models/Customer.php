<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'country',
        'state',
        'city',
        'address_line',
        'zip_code',
        'profile_image',
        'status',
        'notes',
    ];

    protected $casts = [
        'notes' => 'string',
    ];

    /**
     * Relationship: Customer belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
