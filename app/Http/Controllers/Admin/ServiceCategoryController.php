<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * List all service categories
     */
    public function index()
    {
        $categories = ServiceCategory::orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.service_categories.index', compact('categories'));
    }

    /**
     * Show form to create a category
     */
    public function create()
    {
        $parents = ServiceCategory::orderBy('name')->get();

        return view('admin.service_categories.create', compact('parents'));
    }

    /**
     * Store new category
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|unique:service_categories,slug',
            'parent_id'   => 'nullable|exists:service_categories,id',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',

            // allow png & svg
            'icon'        => 'nullable|mimes:png,svg,svg+xml|max:2048',
        ]);

        // auto-create slug if blank
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // store icon
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('service-category-icons', 'public');
        }

        ServiceCategory::create($data);

        return redirect()->route('admin.service_categories.index')
            ->with('success', 'Service category created.');
    }

    /**
     * Edit category screen
     */
    public function edit(ServiceCategory $serviceCategory)
    {
        $parents = ServiceCategory::where('id', '!=', $serviceCategory->id)
            ->orderBy('name')
            ->get();

        return view('admin.service_categories.edit', [
            'category' => $serviceCategory,
            'parents'  => $parents,
        ]);
    }

    /**
     * Update category
     */
    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => "nullable|string|unique:service_categories,slug,{$serviceCategory->id}",
            'parent_id'   => 'nullable|exists:service_categories,id',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',
            'icon'        => 'nullable|mimes:png,svg,svg+xml|max:2048',
        ]);

        // generate slug if empty
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // update icon
        if ($request->hasFile('icon')) {
            if ($serviceCategory->icon && Storage::disk('public')->exists($serviceCategory->icon)) {
                Storage::disk('public')->delete($serviceCategory->icon);
            }

            $data['icon'] = $request->file('icon')->store('service-category-icons', 'public');
        }

        $serviceCategory->update($data);

        return redirect()->route('admin.service_categories.index')
            ->with('success', 'Service category updated.');
    }

    /**
     * Delete category
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        if ($serviceCategory->icon && Storage::disk('public')->exists($serviceCategory->icon)) {
            Storage::disk('public')->delete($serviceCategory->icon);
        }

        $serviceCategory->delete();

        return back()->with('success', 'Service category deleted.');
    }
}
