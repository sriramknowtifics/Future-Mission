<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{
    // User can view only their own orders
    public function view(User $user, Order $order)
    {
        return $order->user_id === $user->id;
    }

    // User can update/cancel only their own orders
    public function update(User $user, Order $order)
    {
        return $order->user_id === $user->id &&
               in_array($order->status, ['pending', 'paid']);
    }
}
