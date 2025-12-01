<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // Show wishlist
    public function index()
    {
        $wishlist = Wishlist::with(['product', 'vendor'])
            ->where('user_id', auth()->id())
            ->get();

        return view('wishlist.index', compact('wishlist'));
    }

    // Add to wishlist
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);

        Wishlist::firstOrCreate([
            'user_id'    => auth()->id(),
            'product_id' => $request->product_id,
            'vendor_id'  => $product->vendor_id,
        ]);

        return back()->with('success', 'Added to wishlist.');
    }

    // Remove item
    public function remove($id)
    {
        Wishlist::where('id', $id)->where('user_id', auth()->id())->delete();
        return back()->with('success', 'Removed from wishlist.');
    }
}
