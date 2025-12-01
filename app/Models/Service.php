<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * -------------------------------------------------------------
     *  FILLABLE (updated to match the new final services table)
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'vendor_id',
        'category_id',
        'approved_by',

        'name',
        'slug',
        'code',

        'short_description',
        'description',

        'thumbnail',
        'documents',

        'price',
        'offer_price',
        'vat_percentage',
        'vat_included',

        'visit_fee',
        'minimum_charge',
        'minimum_minutes',

        'duration_minutes',
        'service_type',

        'available_days',
        'available_time_start',
        'available_time_end',
        'is_24_hours',

        'service_city',
        'service_area',

        'addons',

        'rating',
        'rating_count',

        'cancellation_policy',
        'cancellation_fee',

        'commission_percentage',

        'hsn',

        'is_active',
        'approval_status',
        'approved_at',
    ];


    /**
     * -------------------------------------------------------------
     * CASTS (for JSON & boolean fields)
     * -------------------------------------------------------------
     */
    protected $casts = [
        'documents'            => 'array',
        'addons'               => 'array',
        'available_days'       => 'array',

        'vat_included'         => 'boolean',
        'is_24_hours'          => 'boolean',
        'is_active'            => 'boolean',

        'approved_at'          => 'datetime',
        'available_time_start' => 'datetime:H:i',
        'available_time_end'   => 'datetime:H:i',
    ];


    /**
     * -------------------------------------------------------------
     * RELATIONSHIPS
     * -------------------------------------------------------------
     */

    // Vendor who offers the service
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // Service Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Approving Admin/Staff
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Service images (if using separate image table)
    public function images()
    {
        return $this->hasMany(ServiceImage::class)->orderBy('sort_order');
    }


    /**
     * -------------------------------------------------------------
     * MUTATORS
     * -------------------------------------------------------------
     */

    // Automatically create slug from name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        if (!isset($this->attributes['slug']) || empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }


    /**
     * -------------------------------------------------------------
     * SCOPES
     * -------------------------------------------------------------
     */

    // Only approved & active services shown to the public
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('approval_status', 'approved');
    }

    // Show only pending services in vendor/admin panel
    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }


    /**
     * -------------------------------------------------------------
     * ACCESSORS
     * -------------------------------------------------------------
     */

    // Full URL for thumbnail
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : asset('assets/images/default-service.png');
    }

    // Full URLs for documents (JSON)
    public function getDocumentUrlsAttribute()
    {
        if (!$this->documents) return [];

        return collect($this->documents)->map(function ($file) {
            return asset('storage/' . $file);
        })->toArray();
    }
        public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }

}

//below things are optimized

// vat_percentage

// vat_included

// visit_fee

// minimum_charge

// minimum_minutes

// service_city

// service_area

// addons

// cancellation_policy

// cancellation_fee

// commission_percentage

// documents

// available_time_start

// available_time_end

// is_24_hours

// ✔ Updated casts for JSON, boolean, and time fields
// ✔ Updated fillable completely
// ✔ Kept your slug mutator (safe)
// ✔ Kept existing relations
// ✔ Added full URL generators for documents
// ✔ Removed deprecated gallery (not in new schema)
// ✔ Improved naming & added comments
