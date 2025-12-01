<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\ServiceOrder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth', 'verified']);
  }

  /**
   * User dashboard / orders overview.
   */
  
public function index()
{
    $user = Auth::user();

    // Basic username display
    $username = $user->name;

    // Load customer profile (may be null if not created yet)
    $customer = Customer::where('user_id', $user->id)->first();

    // Load product orders (if your User model has orders() relationship)
    $orders = $user->orders()
        ->latest()
        ->paginate(10);

    // Load service bookings
    $serviceOrders = ServiceOrder::where('user_id', $user->id)
        ->with(['service.images', 'vendor'])  // Eager loading
        ->latest()
        ->paginate(10);

    return view('account.dashboard', compact(
        'orders',
        'serviceOrders',
        'username',
        'customer'
    ));
}


  /**
   * Show a user's specific order.
   */
  public function showOrder(Order $order)
  {
    $this->authorize('view', $order); // create a policy or ensure user owns the order
    $order->load('items.product.vendor', 'deliveryAssignment');
    return view('account.order_show', compact('order'));
  }

  /**
   * Cancel order (if allowed).
   */
  public function cancelOrder(Request $request, Order $order)
  {
    $this->authorize('update', $order);

    if (! in_array($order->status, ['pending', 'paid'])) {
      return back()->withErrors(['error' => 'Order cannot be canceled at this stage.']);
    }

    $order->status = 'cancelled';
    $order->save();

    // TODO: refund if payment was made, notify vendor/admin
    return back()->with('success', 'Order cancelled successfully.');
  }
/**
 * This function is as of now not used directly anwhere , i added this to index function,other than that i have tnot used irectly
 */
    public function serviceBookings()
    {
        $user = Auth::user();

        $serviceOrders = ServiceOrder::where('user_id', $user->id)
            ->with(['service.images', 'vendor'])     // eager loading improves speed
            ->latest()
            ->paginate(10);

        return view('account.service_bookings', compact('serviceOrders'));
    }


    public function showServiceBooking($id)
    {
        $user = Auth::user();

        $order = ServiceOrder::where('id', $id)
            ->where('user_id', $user->id)  // secure: user can only view their own order
            ->with(['service.images', 'vendor', 'technician'])
            ->firstOrFail();

        return view('account.service_booking_show', compact('order'));
    }
    public function cancelServiceBooking($id)
  {
      $user = Auth::user();

      $order = ServiceOrder::where('id', $id)
          ->where('user_id', $user->id)
          ->firstOrFail();

      if (! in_array($order->service_status, ['pending', 'assigned'])) {
          return back()->withErrors(['error' => 'This booking cannot be cancelled at this stage.']);
      }

      $order->service_status = 'cancelled';
      $order->save();

      return back()->with('success', 'Service booking cancelled successfully.');
  }
  public function updateAccount(Request $request)
{
    $user = Auth::user();

    // Validation for user + customer profile fields
    $request->validate([
        'name'        => ['required', 'string', 'max:255'],
        'email'       => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        'phone'       => ['nullable', 'string', 'max:20', 'unique:users,phone,' . $user->id],
        'country'     => ['nullable', 'string', 'max:120'],
        'state'       => ['nullable', 'string', 'max:120'],
        'city'        => ['nullable', 'string', 'max:120'],
        'address_line'=> ['nullable', 'string', 'max:255'],
        'zip_code'    => ['nullable', 'string', 'max:20'],
        'notes'       => ['nullable', 'string'],
        'profile_image' => ['nullable', 'image', 'max:2048'], // 2MB
    ]);

    // ---- UPDATE USER TABLE ----
    $user->update([
        'name'  => $request->name,
        'email' => strtolower($request->email),
        'phone' => $request->phone,
    ]);

    // ---- UPDATE CUSTOMER TABLE ----
    $customer = Customer::firstOrCreate(
        ['user_id' => $user->id],
        ['name' => $user->name, 'email' => $user->email]
    );

    // Handle profile image upload
    if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')->store('customers', 'public');
        $customer->profile_image = $path;
    }

    // Update customer fields
    $customer->update([
        'name'         => $request->name,
        'email'        => $request->email,
        'phone'        => $request->phone,
        'country'      => $request->country,
        'state'        => $request->state,
        'city'         => $request->city,
        'address_line' => $request->address_line,
        'zip_code'     => $request->zip_code,
        'notes'        => $request->notes,
    ]);

    return back()->with('success', 'Account updated successfully!');
}



}
