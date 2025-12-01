<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServicePublicController extends Controller
{
    /**
     * --------------------------------------------
     * SERVICE LIST PAGE (PUBLIC)
     * --------------------------------------------
     */
    public function index(Request $request)
    {
        $query = Service::query()
            ->where('approval_status', 'approved')
            ->where('is_active', true)
            ->with(['images', 'category']);

        $current = null;


        /**
         * --------------------------------------------
         * SEARCH
         * --------------------------------------------
         */
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where('name', 'like', "%{$q}%");
        }


        /**
         * --------------------------------------------
         * CATEGORY FILTER
         * (service_category=ID)
         * --------------------------------------------
         */
        if ($request->filled('service_category')) {

            $categoryId = (int) $request->service_category;

            // Current breadcrumb label
            $current = ServiceCategory::where('id', $categoryId)->value('name');

            // Include child categories
            $childIds = ServiceCategory::where('parent_id', $categoryId)->pluck('id');

            $query->where(function ($q2) use ($categoryId, $childIds) {
                $q2->where('category_id', $categoryId)
                   ->orWhereIn('category_id', $childIds);
            });
        }


        /**
         * --------------------------------------------
         * PRICE FILTER
         * --------------------------------------------
         */
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }


        /**
         * --------------------------------------------
         * PAGINATION
         * --------------------------------------------
         */
        $services = $query->paginate(24)->withQueryString();

        /**
         * --------------------------------------------
         * CATEGORIES (Only Parent Categories)
         * --------------------------------------------
         */
        $categories = ServiceCategory::whereNull('parent_id')
            ->with('children')
            ->get();

        /**
         * --------------------------------------------
         * FEATURED SERVICES (10 Latest)
         * --------------------------------------------
         */
        $featured = Service::where('approval_status', 'approved')
            ->where('is_active', true)
            ->with('images')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();


        return view('service.grid', compact('services', 'current', 'featured', 'categories'));
    }



    /**
     * --------------------------------------------
     * SERVICE SHOW PAGE
     * --------------------------------------------
     */
    public function show($id)
    {
        $service = Service::where('id', $id)
            ->where('approval_status', 'approved')
            ->with(['images', 'vendor', 'category'])
            ->firstOrFail();

        // Related services (same category)
        $related = Service::where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->where('approval_status', 'approved')
            ->where('is_active', true)
            ->with('images')
            ->limit(8)
            ->get();

        return view('service.show', compact('service', 'related'));
    }



    /**
     * --------------------------------------------
     * QUICK SEARCH API (Used by Search Box)
     * --------------------------------------------
     */
    public function searchApi(Request $request)
    {
        $q = $request->input('q', '');

        $results = Service::where('approval_status', 'approved')
            ->where('is_active', true)
            ->where('name', 'like', "%{$q}%")
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($results);
    }
}
