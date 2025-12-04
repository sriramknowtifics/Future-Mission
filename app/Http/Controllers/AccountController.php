<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\ServiceOrder;
use App\Models\CustomerAddress;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * MAIN DASHBOARD
     */
    public function index()
    {
        $user = Auth::user();

        // Ensure customer profile exists
        $customer = Customer::firstOrCreate(
            ['user_id' => $user->id],
            ['name' => $user->name, 'email' => $user->email]
        );

        // Addresses
        $addresses = CustomerAddress::where('user_id', $user->id)
            ->orderByDesc('is_default')
            ->get();

        // Product Orders + Items + Product + Vendor
        $orders = Order::where('user_id', $user->id)
            ->with(['items.product', 'items.vendor'])
            ->latest()
            ->paginate(10);

        // Service Bookings
        $serviceOrders = ServiceOrder::where('user_id', $user->id)
            ->with(['service.images', 'vendor'])
            ->latest()
            ->paginate(10);

        // Quick Stats (Single optimized query)
        $orderStats = Order::select('status')
            ->selectRaw('COUNT(*) as total')
            ->where('user_id', $user->id)
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('account.dashboard', [
            'username'      => $user->name,
            'customer'      => $customer,
            'addresses'     => $addresses,
            'orders'        => $orders,
            'serviceOrders' => $serviceOrders,
            'orderStats'    => [
                'pending'   => $orderStats['pending'] ?? 0,
                'shipped'   => $orderStats['shipped'] ?? 0,
                'delivered' => $orderStats['delivered'] ?? 0,
            ],
        ]);
    }

    /**
     * UPDATE ACCOUNT
     */
    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'           => 'required|max:255',
            'email'          => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'          => 'nullable|max:25|unique:users,phone,' . $user->id,
            'profile_image'  => 'nullable|image|max:2048',
        ]);

        $user->update([
            'name'  => $validated['name'],
            'email' => strtolower($validated['email']),
            'phone' => $validated['phone'] ?? null,
        ]);

        $customer = Customer::firstOrCreate(['user_id' => $user->id]);
        $customer->fill($validated);

        if ($request->hasFile('profile_image')) {
            $customer->profile_image = $request->file('profile_image')
                ->store('customers', 'public');
        }

        $customer->save();

        return back()->with('success', 'Account updated successfully!');
    }


    /**
     * ADDRESS CRUD
     */
    public function addressStore(Request $request)
    {
        $validated = $request->validate([
            'type'          => 'required|in:home,work,other',
            'address_line'  => 'required|max:255',
            'country'       => 'nullable|string|max:120',
            'state'         => 'nullable|string|max:120',
            'city'          => 'nullable|string|max:120',
            'zip_code'      => 'nullable|string|max:20',
            'landmark'      => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $customer = Customer::firstOrCreate(['user_id' => $user->id]);

        $validated['user_id']     = $user->id;
        $validated['customer_id'] = $customer->id;
        $validated['is_default']  = CustomerAddress::where('user_id', $user->id)->count() == 0;

        CustomerAddress::create($validated);

        return back()->with('success', 'Address added successfully!');
    }

    public function addressUpdate(Request $request, $id)
    {
        $address = CustomerAddress::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'type'          => 'required|in:home,work,other',
            'address_line'  => 'required|max:255',
            'country'       => 'nullable|string|max:120',
            'state'         => 'nullable|string|max:120',
            'city'          => 'nullable|string|max:120',
            'zip_code'      => 'nullable|string|max:20',
            'landmark'      => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'is_default'    => 'nullable|boolean',
        ]);

        if ($request->is_default) {
            CustomerAddress::where('user_id', Auth::id())->update(['is_default' => false]);
            $validated['is_default'] = true;
        }

        $address->update($validated);

        return back()->with('success', 'Address updated successfully!');
    }

    public function addressDestroy($id)
    {
        $address = CustomerAddress::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $next = CustomerAddress::where('user_id', Auth::id())->first();
            if ($next) $next->update(['is_default' => true]);
        }

        return back()->with('success', 'Address deleted successfully!');
    }

    public function addressMakeDefault($id)
    {
        CustomerAddress::where('user_id', Auth::id())->update(['is_default' => false]);

        CustomerAddress::where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['is_default' => true]);

        return back()->with('success', 'Default address updated!');
    }


    /**
     * ORDER LIST
     */
    public function orderList()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product', 'items.vendor'])
            ->latest()
            ->paginate(10);

        return view('account.orders.index', compact('orders'));
    }

    /**
     * ORDER DETAILS
     */
    public function showOrderDetails($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['items.product', 'items.vendor', 'deliveryUser'])
            ->firstOrFail();

        return view('account.orders.show', compact('order'));
    }

    /**
     * ORDER ITEMS SEPARATE PAGE
     */
    public function orderItems($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $items = $order->items()->with(['product', 'vendor'])->get();

        return view('account.orders.items', compact('order', 'items'));
    }

    /**
     * CANCEL ORDER
     */
    public function cancelOrder(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'paid'])) {
            return back()->withErrors(['error' => 'Order cannot be cancelled at this stage.']);
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled successfully.');
    }


    /**
     * SERVICE BOOKINGS
     */
    public function serviceBookings()
    {
        $user = Auth::user();

        $serviceOrders = ServiceOrder::where('user_id', $user->id)
            ->with(['service.images', 'vendor'])
            ->latest()
            ->paginate(10);

        return view('account.service_bookings', compact('serviceOrders'));
    }

    public function showServiceBooking($id)
    {
        $order = ServiceOrder::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['service.images', 'vendor', 'technician'])
            ->firstOrFail();

        return view('account.service_booking_show', compact('order'));
    }

    public function cancelServiceBooking($id)
    {
        $order = ServiceOrder::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!in_array($order->service_status, ['pending', 'assigned'])) {
            return back()->withErrors(['error' => 'This booking cannot be cancelled at this stage.']);
        }

        $order->update(['service_status' => 'cancelled']);

        return back()->with('success', 'Service booking cancelled successfully.');
    }
}
