<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Category;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:admin']);
    }

    public function index(Request $request)
    {
        // Banners
        $banners = collect();
        if (class_exists(\App\Models\Banner::class)) {
            $banners = Banner::where('placement', 'home')
                ->orderByDesc('sort_order')
                ->get();
        }

        // Top-level categories (limit 12, with product count)
        $categories = collect();
        if (class_exists(\App\Models\Category::class)) {
            $categories = Category::whereNull('parent_id')
                ->withCount('products')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->take(12)
                ->get();
        }

        // Featured / latest products
        $featured = collect();
        if (class_exists(\App\Models\Product::class)) {
            $featured = Product::visibleToPublic()
                ->orderByDesc('created_at')
                ->limit(12)
                ->with(['images'])
                ->get();
        }

        return view('admin.banners.index', compact('banners', 'categories', 'featured'));
    }

    public function create()
    {
        $products = Product::visibleToPublic()->orderBy('name')->get();

        return view('admin.banners.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'place'        => 'required|integer|digits_between:1,4',
            'subtitle'    => 'nullable|string|max:255',
            'link_url'    => 'nullable|url',
            'product_id'  => 'nullable|exists:products,id',
            'placement'   => ['required', 'string', Rule::in(['home', 'category', 'product'])],
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'boolean',
            'desktop_image'       => 'required|mimes:jpg,jpeg,png,webp,svg,svg+xml|max:4096',
            'mobile_image'       => 'required|mimes:jpg,jpeg,png,webp,svg,svg+xml|max:4096',

        ]);

        $data['is_active'] = $request->boolean('is_active');
        $place = $data['place'] ?? NULL;
        if ($request->hasFile('desktop_image')) {
            if($place != NULL) {
                $data['desktop_image'] = $request->file('desktop_image')->store("banners/desktop/$place", 'public');
                $data['mobile_image'] = $request->file('mobile_image')->store("banners/mobile/$place", 'public');

            }else {
                $data['desktop_image'] = $request->file('desktop_image')->store('banners/desktop', 'public');
                $data['mobile_image'] = $request->file('mobile_image')->store('banners/mobile', 'public');

            }
        }


        Banner::create($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created.');
    }

    public function edit(Banner $banner)
    {
        $products = Product::visibleToPublic()->orderBy('name')->get();

        return view('admin.banners.edit', compact('banner', 'products'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'place'        => 'required|integer|digits_between:1,4',
            'link_url'    => 'nullable|url',
            'product_id'  => 'nullable|exists:products,id',
            'placement'   => ['required', 'string', Rule::in(['home', 'category', 'product'])],
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'boolean',
            'desktop_image'   => 'nullable|mimes:jpg,jpeg,png,webp,svg,svg+xml|max:4096',
            'mobile_image'    => 'nullable|mimes:jpg,jpeg,png,webp,svg,svg+xml|max:4096',

        ]);

        $data['is_active'] = $request->boolean('is_active');
        $place = $data['place'] ?? NULL;
        if ($request->hasFile('desktop_image')) {

    // delete old image
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            if ($place !== null) {
                // store inside banners/{place}/
                $data['desktop_image'] = $request->file('desktop_image')->store("banners/desktop/$place", 'public');
                $data['mobile_image'] = $request->file('mobile_image')->store("banners/mobile/$place", 'public');

            } else {
                $data['desktop_image'] = $request->file('desktop_image')->store('banners/desktop', 'public');
                $data['mobile_image'] = $request->file('desktop_image')->store('banners/mobile', 'public');


            }
        }


        $banner->update($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated.');
    }
    public function show () {
        
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted.');
    }
}
