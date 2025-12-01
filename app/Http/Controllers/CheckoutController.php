<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Require authenticated & verified user for checkout.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show checkout page (cart summary + address selection).
     */
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('warning', 'Your cart is empty.');
        }

        return view('checkout.index', compact('cart'));
    }

    /**
     * Place order (simple implementation).
     * Payment integrations/validation should be added later.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|array',
            'payment_method' => 'required|string'
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Cart is empty.']);
        }

        DB::beginTransaction();
        try {
            $order = new Order();
            $order->order_number = Str::upper('FM' . Str::random(8));
            $order->user_id = Auth::id();
            $order->shipping_address = $request->input('shipping_address');
            $order->billing_address = $request->input('billing_address', $request->input('shipping_address'));
            $order->payment_method = $request->input('payment_method');
            $order->payment_status = 'pending';
            $order->status = 'pending';

            // calculate totals
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += ($item['price'] * $item['qty']);
            }
            $order->subtotal_amount = $subtotal;
            $order->shipping_cost = 0; // calculate later
            $order->tax_amount = 0; // calculate later
            $order->total_amount = $order->subtotal_amount + $order->shipping_cost + $order->tax_amount;

            $order->save();

            // items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'vendor_id' => $item['vendor_id'] ?? null,
                    'name' => $item['name'],
                    'sku' => null,
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => ($item['price'] * $item['qty']),
                    'attributes' => null,
                ]);
            }

            // TODO: integrate payment gateway -> update payment_status & status accordingly
            // For now set payment_status = 'paid' for testing
            if ($order->payment_method !== 'cod') {
                $order->payment_status = 'paid';
                $order->status = 'paid';
                $order->save();
            }

            DB::commit();

            // clear cart
            session()->forget('cart');

            return redirect()->route('account.orders.show', $order->id)->with('success', 'Order placed successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to place order: ' . $e->getMessage()]);
        }
    }
}
