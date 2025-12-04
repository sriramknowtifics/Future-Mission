<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // BANNERS
        $banners = collect();

        if (class_exists(\App\Models\Banner::class)) {
            $banners = Banner::where('placement', 'home')
                ->where('is_active', true)
                ->where("placement",'home')
                ->get();
                // ->where("place",1)

        }

        // TOP LEVEL CATEGORIES (you said this is already working)
        $categories = collect();
        if (class_exists(\App\Models\Category::class)) {
            $categories = Category::whereNull('parent_id')
                ->orderBy('name')
                ->take(12)
                ->get();
        }

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
            // $featuredServices = (clone $baseQuery)
            //     ->where('type', 'service')
            //     ->orderByDesc('created_at')
            //     ->limit(10)
            //     ->get();
            $featuredServices = Service::query()
            ->where('approval_status', 'approved')
            ->where('is_active', true)
            ->with(['images', 'category'])->get();
        }

        return view('home', compact(
            'banners',
            'categories',
            'featured',          // used by existing "Featured Products" section
            'featuredServices'   // we’ll add a new "Featured Services" section
        ));
    }
}
