<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Show cart contents.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'sometimes|integer|min:1'
        ]);

        $product = Product::findOrFail($data['product_id']);
        $qty = $request->input('qty', 1);

        $cart = Session::get('cart', []);
        $key = $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $qty,
                'vendor_id' => $product->vendor_id
            ];
        }

        Session::put('cart', $cart);
        return back()->with('success', 'Added to cart.');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:0'
        ]);

        $cart = Session::get('cart', []);
        $key = $data['product_id'];

        if (isset($cart[$key])) {
            if ($data['qty'] <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['qty'] = $data['qty'];
            }
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Cart updated.');
    }

    /**
     * Remove item from cart.
     */
    public function remove(Request $request, $productId)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Removed from cart.');
    }

    /**
     * Clear the whole cart.
     */
    public function clear()
    {
        Session::forget('cart');
        return back()->with('success', 'Cart cleared.');
    }
}
