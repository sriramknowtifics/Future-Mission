<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:vendor']);
    }

    /**
     * ----------------------------------------------------
     * LIST PRODUCTS (VENDOR PANEL)
     * ----------------------------------------------------
     */
    public function index(Request $request)
    {
        $vendor = Auth::user()->vendor;

        $query = Product::where('vendor_id', $vendor->id)
            ->with(['images', 'category', 'brand'])
            ->orderByDesc('created_at');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $products = $query->paginate(20)->withQueryString();

        return view('vendor.products.index', compact('products'));
    }


    /**
     * ----------------------------------------------------
     * CREATE PRODUCT FORM
     * ----------------------------------------------------
     */
    public function create()
    {
        return view('vendor.products.create', [
            'categories' => Category::orderBy('name')->get(),
            'brands'     => Brand::orderBy('name')->get()
        ]);
    }


    /**
     * ----------------------------------------------------
     * STORE PRODUCT
     * ----------------------------------------------------
     */
    public function store(Request $request)
    {
        $vendor = Auth::user()->vendor;
        Log::info("📌 Product Store triggered");

        $data = $request->validate([
            // BASIC
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255',
            'sku'              => 'nullable|string|max:100|unique:products,sku',
            'category_id'      => 'nullable|exists:categories,id',
            'brand_id'         => 'nullable|exists:brands,id',
            'short_description'=> 'nullable|string|max:500',
            'description'      => 'nullable|string',

            // PRICING
            'price'            => 'required|numeric|min:0',
            'offer_price'      => 'nullable|numeric|min:0|lt:price',

            // BAHRAIN VAT
            'vat_percentage'   => 'nullable|numeric|min:0|max:50',
            'vat_included'     => 'nullable|boolean',

            // COMMISSION
            'commission_percentage' => 'nullable|numeric|min:0|max:100',

            // STOCK
            'stock'            => 'nullable|integer|min:0',

            // IMAGES
            'images.*'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            // ACTIVE
            'is_active'        => 'nullable|boolean',
        ]);

        $data['vendor_id'] = $vendor->id;
        $data['slug'] = $data['slug'] ?? Str::slug($data['name'] . '-' . Str::random(5));
        $data['approval_status'] = 'pending';   // admin must approve
        $data['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        // Apply default VAT if none given
        $data['vat_percentage'] = $data['vat_percentage'] ?? 10.00;
        $data['vat_included']   = $data['vat_included'] ?? true;

        DB::beginTransaction();
        try {
            $product = Product::create($data);

            // IMAGE UPLOAD
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $i => $file) {
                    $path = $file->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path'       => $path,
                        'is_primary' => ($i == 0),
                        'sort_order' => $i
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('vendor.products.index')
                ->with('success', 'Product submitted for approval.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("❌ PRODUCT STORE ERROR: " . $e->getMessage());

            return back()->withInput()
                ->withErrors(['error' => "Failed: " . $e->getMessage()]);
        }
    }


    /**
     * ----------------------------------------------------
     * SHOW PRODUCT (VENDOR PANEL)
     * ----------------------------------------------------
     */
    public function show(Product $product)
    {
        $vendor = Auth::user()->vendor;
        if ($product->vendor_id != $vendor->id) abort(403);

        $product->load(['images', 'category', 'brand']);

        return view('vendor.products.show', compact('product'));
    }


    /**
     * ----------------------------------------------------
     * EDIT PRODUCT FORM
     * ----------------------------------------------------
     */
    public function edit(Product $product)
    {
        $vendor = Auth::user()->vendor;
        if ($product->vendor_id != $vendor->id) abort(403);

        return view('vendor.products.edit', [
            'product'   => $product->load(['images']),
            'categories'=> Category::orderBy('name')->get(),
            'brands'    => Brand::orderBy('name')->get()
        ]);
    }


    /**
     * ----------------------------------------------------
     * UPDATE PRODUCT
     * ----------------------------------------------------
     */
    public function update(Request $request, Product $product)
    {
        $vendor = Auth::user()->vendor;
        if ($product->vendor_id != $vendor->id) abort(403);

        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'slug'           => 'nullable|string|max:255',
            'sku'            => ['nullable','string','max:100', Rule::unique('products','sku')->ignore($product->id)],
            'category_id'    => 'nullable|exists:categories,id',
            'brand_id'       => 'nullable|exists:brands,id',
            'short_description'=> 'nullable|string|max:500',
            'description'    => 'nullable|string',

            'price'          => 'required|numeric|min:0',
            'offer_price'    => 'nullable|numeric|min:0|lt:price',

            'vat_percentage' => 'nullable|numeric|min:0|max:50',
            'vat_included'   => 'nullable|boolean',

            'commission_percentage' => 'nullable|numeric|min:0|max:100',

            'stock'          => 'nullable|integer|min:0',
            'attributes'     => 'nullable|array',

            'images.*'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'is_active'      => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active') ? (bool)$request->is_active : $product->is_active;
        $data['vat_percentage'] = $data['vat_percentage'] ?? 10.00;
        $data['vat_included'] = $data['vat_included'] ?? true;

        DB::beginTransaction();
        try {
            $product->update($data);

            // IMAGE UPLOAD
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('products', 'public');

                    $product->images()->create([
                        'path'       => $path,
                        'is_primary' => false,
                        'sort_order' => $product->images()->max('sort_order') + 1
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('vendor.products.index')->with('success', 'Product updated.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("❌ PRODUCT UPDATE ERROR: " . $e->getMessage());

            return back()->withInput()
                ->withErrors(['error' => "Failed: " . $e->getMessage()]);
        }
    }


    /**
     * ----------------------------------------------------
     * DELETE PRODUCT
     * ----------------------------------------------------
     */
    public function destroy(Product $product)
    {
        $vendor = Auth::user()->vendor;
        if ($product->vendor_id != $vendor->id) abort(403);

        DB::beginTransaction();
        try {
            foreach ($product->images as $img) {
                if (Storage::disk('public')->exists($img->path)) {
                    Storage::disk('public')->delete($img->path);
                }
                $img->delete();
            }

            $product->delete();

            DB::commit();
            return redirect()->route('vendor.products.index')->with('success', 'Product deleted.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => "Failed: " . $e->getMessage()]);
        }
    }
}
