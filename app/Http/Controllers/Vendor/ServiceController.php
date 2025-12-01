<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:vendor']);
    }


    /* ============================================================
       LIST SERVICES
    ============================================================ */
    public function index(Request $request)
    {
        $vendor = Auth::user()->vendor;

        $query = Service::where('vendor_id', $vendor->id)
                        ->with(['category', 'approvedBy'])
                        ->orderByDesc('created_at');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $services = $query->paginate(20)->withQueryString();

        return view('vendor.services.index', compact('services'));
    }


    /* ============================================================
       CREATE FORM
    ============================================================ */
    public function create()
    {
        return view('vendor.services.create', [
            'vendor'     => Auth::user()->vendor,
            'categories' => ServiceCategory::orderBy('name')->get(),
        ]);
    }


    /* ============================================================
       STORE NEW SERVICE
    ============================================================ */
    public function store(Request $request)
    {
        Log::info("New service request", $request->all());

        $validated = $this->validateService($request);

        DB::beginTransaction();
        try {
            // Create service record
            $service = new Service($validated);
            $service->vendor_id = Auth::user()->vendor->id;
            $service->slug      = $validated['slug'] ?? Str::slug($validated['name']);
            $service->approval_status = 'pending';

            // Default VAT
            $service->vat_percentage = $validated['vat_percentage'] ?? 10.00;
            $service->vat_included   = $validated['vat_included'] ?? true;

            $service->save();

            /* ------------------------------
               PRIMARY THUMBNAIL
            ------------------------------ */
            if ($request->hasFile('thumbnail')) {
                $path = $request->file('thumbnail')->store('services', 'public');

                ServiceImage::create([
                    'service_id' => $service->id,
                    'path'       => $path,
                    'is_primary' => true,
                    'sort_order' => 0,
                    'alt_text'   => $service->name,
                ]);

                $service->thumbnail = $path;
                $service->save();
            }

            /* ------------------------------
               GALLERY IMAGES
            ------------------------------ */
            if ($request->hasFile('gallery')) {
                $sort = 1;
                foreach ($request->file('gallery') as $image) {
                    $path = $image->store('services', 'public');

                    ServiceImage::create([
                        'service_id' => $service->id,
                        'path'       => $path,
                        'is_primary' => false,
                        'sort_order' => $sort++,
                        'alt_text'   => $service->name,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('vendor.services.index')
                             ->with('success', 'Service created successfully and is pending approval.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("❌ SERVICE STORE ERROR: ".$e->getMessage());
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /* ============================================================
       EDIT FORM
    ============================================================ */
    public function edit(Service $service)
    {
        $vendor = Auth::user()->vendor;
        if ($service->vendor_id !== $vendor->id) abort(403);

        return view('vendor.services.edit', [
            'service'    => $service->load(['images']),
            'categories' => ServiceCategory::orderBy('name')->get(),
        ]);
    }


    /* ============================================================
       UPDATE SERVICE
    ============================================================ */
    public function update(Request $request, Service $service)
    {
        $vendor = Auth::user()->vendor;
        if ($service->vendor_id !== $vendor->id) abort(403);

        $validated = $this->validateService($request, $service->id);

        DB::beginTransaction();
        try {
            $validated['vat_percentage'] = $validated['vat_percentage'] ?? 10.00;
            $validated['vat_included']   = $validated['vat_included'] ?? true;

            $service->update($validated);

            /* ------------------------------
               THUMBNAIL UPDATE
            ------------------------------ */
            if ($request->hasFile('thumbnail')) {

                // delete old thumbnail
                if ($service->thumbnail && Storage::disk('public')->exists($service->thumbnail)) {
                    Storage::disk('public')->delete($service->thumbnail);
                }

                $path = $request->file('thumbnail')->store('services', 'public');

                // Update database primary image
                $primary = $service->images()->where('is_primary', true)->first();
                if ($primary) {
                    $primary->update(['path' => $path]);
                } else {
                    ServiceImage::create([
                        'service_id' => $service->id,
                        'path'       => $path,
                        'is_primary' => true,
                        'sort_order' => 0,
                        'alt_text'   => $service->name,
                    ]);
                }

                $service->thumbnail = $path;
                $service->save();
            }

            /* ------------------------------
               GALLERY ADDING
            ------------------------------ */
            if ($request->hasFile('gallery')) {
                $sort = $service->images()->max('sort_order') + 1;

                foreach ($request->file('gallery') as $image) {
                    $path = $image->store('services', 'public');

                    ServiceImage::create([
                        'service_id' => $service->id,
                        'path'       => $path,
                        'is_primary' => false,
                        'sort_order' => $sort++,
                        'alt_text'   => $service->name,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('vendor.services.index')
                             ->with('success', 'Service updated successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("❌ SERVICE UPDATE ERROR: ".$e->getMessage());
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /* ============================================================
       DELETE SERVICE
    ============================================================ */
    public function destroy(Service $service)
    {
        $vendor = Auth::user()->vendor;
        if ($service->vendor_id !== $vendor->id) abort(403);

        DB::beginTransaction();
        try {
            foreach ($service->images as $img) {
                if (Storage::disk('public')->exists($img->path)) {
                    Storage::disk('public')->delete($img->path);
                }
                $img->delete();
            }

            $service->delete();

            DB::commit();
            return redirect()->route('vendor.services.index')
                             ->with('success', 'Service deleted.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => "Failed: ".$e->getMessage()]);
        }
    }


    /* ============================================================
       SHARED VALIDATION (Store & Update)
    ============================================================ */
    private function validateService(Request $request, $id = null)
    {
        return $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:services,slug,'.($id ?? 'NULL'),
            'code'              => 'nullable|string|max:255|unique:services,code,'.($id ?? 'NULL'),
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',

            'category_id'       => 'nullable|exists:categories,id',

            // Media
            'thumbnail'         => $id ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096' 
                                       : 'required|image|mimes:jpg,jpeg,png,webp|max:4096',

            'gallery.*'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            // Pricing
            'price'             => 'required|numeric|min:0',
            'offer_price'       => 'nullable|numeric|min:0|lt:price',

            // VAT
            'vat_percentage'    => 'nullable|numeric|min:0|max:100',
            'vat_included'      => 'nullable|boolean',

            // Fees
            'visit_fee'         => 'nullable|numeric|min:0',
            'minimum_charge'    => 'nullable|numeric|min:0',
            'minimum_minutes'   => 'nullable|integer|min:1',

            // Service type
            'duration_minutes'  => 'nullable|integer|min:1',
            'service_type'      => 'required|in:online,offline,both',

            // Availability
            'available_days'      => 'nullable|array',
            'available_time_start'=> 'nullable|date_format:H:i',
            'available_time_end'  => 'nullable|date_format:H:i',
            'is_24_hours'         => 'nullable|boolean',

            // Location
            'service_city'     => 'nullable|string|max:150',
            'service_area'     => 'nullable|string|max:150',

            // Addons
            'addons'           => 'nullable|array',

            // Cancel policy
            'cancellation_policy'=> 'nullable|string',
            'cancellation_fee'   => 'nullable|numeric|min:0',

            // Commission
            'commission_percentage' => 'nullable|numeric|min:0|max:100',

            // HSN
            'hsn'                => 'nullable|string|max:50',

            // Status
            'is_active'          => 'required|boolean',
        ]);
    }
}
