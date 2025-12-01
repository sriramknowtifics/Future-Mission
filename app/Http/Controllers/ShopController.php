<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ShopController extends Controller
{
  /**
   * Public shop - product listing
   */
  public function index(Request $request)
  {
    $brands = [
      "Milton",
      "Prestige",
    ];
    $query = Product::query()->where('approval_status', 'approved')->where('is_active', true)->with('images', 'tags', 'category');
    $current = NULL;
    if ($request->filled('q')) {
      $q = $request->input('q');
      $query->where('name', 'like', "%{$q}%");
    }


    if ($request->filled('category')) {
      $categoryId = (int)$request->category;

      $current = \App\Models\Category::where('id', $categoryId)->value('name');
      // include products in category or in subcategories
      $query->where(function ($q2) use ($categoryId) {
        $q2->where('category_id', $categoryId)
          ->orWhereIn('category_id', \App\Models\Category::where('parent_id', $categoryId)->pluck('id')->toArray());
      });
    }

    if ($request->filled('subcategory')) {
      $query->where('category_id', (int)$request->subcategory);
    }

    if ($request->filled('tag')) {
      $tag = $request->tag;
      $query->whereHas('tags', function ($q2) use ($tag) {
        $q2->where('slug', $tag)->orWhere('name', 'like', "%{$tag}%");
      });
    }

    if ($request->filled('min_price')) {
      $query->where('price', '>=', (float)$request->min_price);
    }
    if ($request->filled('max_price')) {
      $query->where('price', '<=', (float)$request->max_price);
    }

    $products = $query->paginate(24)->withQueryString();

    $categories = \App\Models\Category::whereNull('parent_id')->with('children')->limit(10)->get();
    $tags = \App\Models\Tag::orderBy('name')->get();
    // FEATURED PRODUCTS (10 nos) + FEATURED SERVICES (10 nos)
        $featured       = collect(); // normal "product" items
        $featuredServices = collect(); // "service" type items

        if (class_exists(\App\Models\Product::class)) {

            // base query: approved + active + with images
            $baseQuery = Product::query()
                ->where('approval_status', 'approved')
                ->where('is_active', true)
                ->with('images');

            // 10 PRODUCT type rows
            $featured = (clone $baseQuery)
                ->where('type', 'product')
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();

            // 10 SERVICE type rows
            $featuredServices = (clone $baseQuery)
                ->where('type', 'service')
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();
        }

    return view('shop.grid', compact('products', 'brands','categories','current','tags', 'featured', 'featuredServices'));
  }


  /**
   * Public product detail
   */
  public function show(Product $product)
  {
    if ($product->approval_status !== 'approved' || !$product->is_active) {
      abort(404);
    }

    $product->load(['images', 'vendor', 'category', 'brand']);

    // FEATURED PRODUCTS (10 nos) + FEATURED SERVICES (10 nos)
        $featured       = collect(); // normal "product" items
        $featuredServices = collect(); // "service" type items

        if (class_exists(\App\Models\Product::class)) {

            // base query: approved + active + with images
            $baseQuery = Product::query()
                ->where('approval_status', 'approved')
                ->where('is_active', true)
                ->with('images');

            // 10 PRODUCT type rows
            $featured = (clone $baseQuery)
                ->where('type', 'product')
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();

            // 10 SERVICE type rows
            $featuredServices = (clone $baseQuery)
                ->where('type', 'service')
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();
        }

    return view('shop.show', compact('product',  'featured', 'featuredServices'));
  }

  /**
   * Quick API for product search (JSON)
   */
  public function searchApi(Request $request)
  {
    $q = $request->input('q', '');
    $results = Product::visibleToPublic()
      ->where('name', 'like', "%{$q}%")
      ->limit(10)
      ->get(['id', 'name', 'slug']);

    return response()->json($results);
  }
}
