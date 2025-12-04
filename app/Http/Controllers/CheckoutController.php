<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        $user = Auth::user();

        $cart = CartItem::with(['product.images', 'vendor'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        if ($cart->isEmpty()) {
            return redirect()->route('shop.index')
                ->with('warning', 'Your cart is empty.');
        }

        $addresses = CustomerAddress::where('user_id', $user->id)->get();

        return view('checkout.index', compact('cart', 'addresses'));
    }
    public function storeAddress(Request $request)
{
    $request->validate([
        'type'         => 'required|in:home,work,other',
        'address_line' => 'required|string|max:255',
        'city'         => 'required|string|max:120',
        'state'        => 'required|string|max:120',
        'zip_code'     => 'required|string|max:20',
        'country'      => 'required|string|max:120',
        'phone'        => 'required|string|max:30',    // matches form field 'phone'
        'label'        => 'nullable|string|max:60',    // optional label
        'landmark'     => 'nullable|string|max:255',
    ]);

    $user = Auth::user();

    // ensure customer row exists
    $customer = Customer::firstOrCreate(['user_id' => $user->id], [
        'name'  => $user->name,
        'email' => $user->email,
    ]);

    // if this is first address, make it default
    $isDefault = CustomerAddress::where('customer_id', $customer->id)->count() === 0;

    CustomerAddress::create([
        'user_id'       => $user->id,
        'customer_id'   => $customer->id,
        'type'          => $request->type,
        'country'       => $request->country,
        'state'         => $request->state,
        'city'          => $request->city,
        'zip_code'      => $request->zip_code,
        'address_line'  => $request->address_line,
        'landmark'      => $request->landmark,
        'contact_phone' => $request->phone,      // stored as contact_phone
        'label'         => $request->label,
        'is_default'    => $isDefault,
    ]);

    return back()->with('success', 'Address added successfully!');
}


    /**
     * Place order using cart_items data
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'address_id'     => ['required', 'exists:customer_addresses,id'],   // FIXED TABLE NAME
            'payment_method' => ['required', 'string'],
        ]);

        $user = Auth::user();

        // Load cart items from DB (active only)
        $cart = CartItem::with('product')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        if ($cart->isEmpty()) {
            return back()->withErrors(['cart' => 'Your cart is empty.']);
        }

        // Load selected address
        $address = CustomerAddress::where('id', $request->address_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        DB::beginTransaction();
        try {

            // ----------------------------------
            // CREATE ORDER
            // ----------------------------------
            $order = new Order();
            $order->order_number = Str::upper('FM' . Str::random(8));
            $order->user_id = $user->id;

            // Save address as JSON
            $order->shipping_address = [
                'type'         => $address->type,
                'country'      => $address->country,
                'state'        => $address->state,
                'city'         => $address->city,
                'zip_code'     => $address->zip_code,
                'address_line' => $address->address_line,
                'label'        => $address->label,
                'phone'        => $address->phone,
            ];

            $order->billing_address = $order->shipping_address;

            $order->payment_method = $request->payment_method;
            $order->payment_status = 'pending';
            $order->status         = 'pending';

            // ----------------------------------
            // CALCULATE TOTAL
            // ----------------------------------
            $subtotal = $cart->sum(fn($i) => $i->price * $i->quantity);

            $order->subtotal_amount = $subtotal;
            $order->shipping_cost   = 0;
            $order->tax_amount      = 0;
            $order->total_amount    = $subtotal;

            $order->save();

            // ----------------------------------
            // ADD ORDER ITEMS
            // ----------------------------------
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'vendor_id'  => $item->vendor_id,
                    'name'       => $item->product->name,
                    'sku'        => null,
                    'price'      => $item->price,
                    'qty'        => $item->quantity,
                    'subtotal'   => $item->price * $item->quantity,
                    'attributes' => null,
                ]);
            }

            // ----------------------------------
            // PAYMENT HANDLING
            // ----------------------------------
            if ($request->payment_method !== 'cod') {
                $order->payment_status = 'paid';
                $order->status         = 'paid';
                $order->save();
            }

            // ----------------------------------
            // CLEAR CART
            // ----------------------------------
            CartItem::where('user_id', $user->id)
                ->where('status', 'active')
                ->delete();

            DB::commit();

            return redirect()
                ->route('account.orders.show', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to place order: ' . $e->getMessage()
            ]);
        }
    }

}
