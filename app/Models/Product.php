<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    /**
     * We use guarded so all fields are mass assignable except id.
     */
    protected $guarded = ['id'];

    /**
     * --------------------------
     *  CASTS
     * --------------------------
     */
    protected $casts = [
        'attributes'           => 'array',
        'documents'            => 'array',
        'service_meta'         => 'array',

        'is_active'            => 'boolean',
        'is_approved'          => 'boolean',
        'vat_included'         => 'boolean',

        'price'                => 'decimal:2',
        'offer_price'          => 'decimal:2',
        'vat_percentage'       => 'decimal:2',
        'installation_fee'     => 'decimal:2',
        'commission_percentage'=> 'decimal:2',
        'cancellation_fee'     => 'decimal:2',

        'stock'                => 'integer',
        'warranty_months'      => 'integer',

        'approved_at'          => 'datetime',
    ];

    /**
     * --------------------------
     *  RELATIONSHIPS
     * --------------------------
     */

    // Product Images
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    // Primary Image
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)
                    ->where('is_primary', true);
    }

    // Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // Vendor (Owner)
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    // Tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag')->withTimestamps();
    }


    /**
     * --------------------------
     *  MUTATORS
     * --------------------------
     */

    // Auto-generate slug if missing
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }


    /**
     * --------------------------
     *  SCOPES
     * --------------------------
     */

    // Only visible on shop page
    public function scopeVisibleToPublic($query)
    {
        return $query
            ->where('is_active', true)
            ->where('approval_status', 'approved')
            ->where('status', 'published');
    }

    // Approved items
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    // Items pending review
    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }


    /**
     * --------------------------
     *  ACCESSORS
     * --------------------------
     */

    public function getFormattedPriceAttribute()
    {
        return number_format((float) $this->price, 2);
    }

    // Final price calculation based on VAT inclusion
    public function getFinalPriceAttribute()
    {
        $price = $this->offer_price ?: $this->price;

        if (!$this->vat_included) {
            $price += ($price * ($this->vat_percentage / 100));
        }

        return number_format($price, 2);
    }

    // Thumbnail URL accessor
    public function getThumbnailUrlAttribute()
    {
        $img = $this->primaryImage;

        return $img ? asset('storage/' . $img->path) : asset('assets/images/placeholder.png');
    }

    // Full list of document URLs
    public function getDocumentUrlsAttribute()
    {
        if (!$this->documents) return [];

        return collect($this->documents)->map(fn($d) => asset('storage/' . $d))->toArray();
    }
}
