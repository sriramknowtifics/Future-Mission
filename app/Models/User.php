<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_hint', // optional quick hint: 'admin','vendor','customer','delivery','finance','crm'
    ];

    /**
     * The attributes that should be hidden for arrays / JSON.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes casts.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* ---------------------------
     | Relationships
     |---------------------------*/

    // If a user has a vendor profile
    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    // Orders placed by this user (customer)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Tickets opened by this user
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Delivery assignments for delivery partners (if user is delivery)
    public function deliveryAssignments()
    {
        return $this->hasMany(DeliveryAssignment::class, 'delivery_user_id');
    }
        public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function assignedServiceOrders()
    {
        return $this->hasMany(ServiceOrder::class, 'assigned_user_id');
}

}
