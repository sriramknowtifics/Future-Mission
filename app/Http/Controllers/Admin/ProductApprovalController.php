<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * -----------------------------------------------------
     * Show only pending products that require admin approval
     * -----------------------------------------------------
     */
    public function index(Request $request)
    {
        $products = Product::where('approval_status', 'pending')
            ->with(['vendor', 'category', 'brand'])
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        return view('admin.products.pending', compact('products'));
    }

    /**
     * -----------------------------------------------------
     * Approve Product
     * -----------------------------------------------------
     */
    public function approve(Request $request, Product $product)
    {
        // If already approved, prevent duplicate update
        if ($product->approval_status === 'approved') {
            return back()->with('info', 'This product is already approved.');
        }

        $product->approval_status = 'approved';
        $product->approved_by = Auth::id();
        $product->approved_at = now();

        // If product is inactive but admin is approving → auto activate
        if (!$product->is_active) {
            $product->is_active = true;
        }

        $product->save();

        // TODO: Notification to vendor
        return back()->with('success', 'Product approved successfully.');
    }

    /**
     * -----------------------------------------------------
     * Reject Product
     * -----------------------------------------------------
     */
    public function reject(Request $request, Product $product)
    {
        $request->validate([
            'reason' => 'nullable|string|max:255'
        ]);

        // If already rejected, avoid duplicate actions
        if ($product->approval_status === 'rejected') {
            return back()->with('info', 'This product is already rejected.');
        }

        $product->approval_status = 'rejected';
        $product->approved_by = Auth::id();
        $product->approved_at = now();

        // Optional: store rejection reason in JSON metadata
        $meta = $product->service_meta ?? [];
        $meta['rejection_reason'] = $request->reason ?: 'No reason provided';
        $product->service_meta = $meta;

        $product->save();

        // TODO: Notify vendor
        return back()->with('success', 'Product rejected.');
    }

    /**
     * -----------------------------------------------------
     * Show all products (approved, pending, rejected)
     * -----------------------------------------------------
     */
    public function indexAll(Request $request)
    {
        $query = Product::with(['vendor', 'category', 'brand'])
            ->orderBy('created_at', 'desc');

        // Optional filter by approval_status
        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
        }

        $products = $query->paginate(30)->withQueryString();

        return view('admin.products.index', compact('products'));
    }
}
