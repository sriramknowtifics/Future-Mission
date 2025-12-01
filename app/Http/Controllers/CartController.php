<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // -------------------------
    // SHOW CART ITEMS
    // -------------------------
    public function index()
    {
        $cart = CartItem::with(['product.images', 'vendor'])
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->get();

        return view('cart.index', compact('cart'));
    }


    // -------------------------
    // ADD TO CART
    // -------------------------
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
        ]);

        Log::info("Add to cart reached");

        $product = Product::find($request->product_id);
        $vendor_id = $product->vendor_id;

        $qty = $request->qty; // frontend qty

        $cartItem = CartItem::updateOrCreate(
            [
                'user_id'    => auth()->id(),
                'product_id' => $request->product_id,
            ],
            [
                'vendor_id'   => $vendor_id,
                'quantity'    => DB::raw('quantity + ' . $qty),
                'price'       => $product->price,
                'total_price' => DB::raw('(quantity + '.$qty.') * '.$product->price),
                'status'      => 'active',
            ]
        );

        return back()->with('success', 'Added to cart.');
    }


    // -------------------------
    // UPDATE QUANTITY
    // -------------------------
    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',  // use qty from frontend
        ]);

        $item = CartItem::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $item->quantity = $request->qty;   // map qty → quantity column
        $item->total_price = $item->price * $request->qty;
        $item->save();

        return back()->with('success', 'Cart updated.');
    }


    // -------------------------
    // REMOVE ONE ITEM
    // -------------------------
    public function remove($id)
    {
        CartItem::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return back()->with('success', 'Removed from cart.');
    }


    // -------------------------
    // CLEAR WHOLE CART
    // -------------------------
    public function clear()
    {
        CartItem::where('user_id', auth()->id())
            ->where('status', 'active')
            ->delete();

        return back()->with('success', 'Cart cleared.');
    }
}
