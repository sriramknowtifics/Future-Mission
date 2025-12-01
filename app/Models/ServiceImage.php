<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'path',
        'is_primary',
        'sort_order',
        'alt_text',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    /* -----------------------------
       RELATIONSHIP
    ------------------------------ */
    public function Service()
    {
        return $this->belongsTo(Service::class);
    }

    /* -----------------------------
       ACCESSOR: Full URL
    ------------------------------ */
    public function getUrlAttribute()
    {
        return $this->path 
            ? asset('storage/' . $this->path) 
            : null;
    }

    /* -----------------------------
       SCOPE: Ordered images
    ------------------------------ */
    public function scopeOrdered($query)
    {
        return $query->orderBy('is_primary', 'desc')
                     ->orderBy('sort_order', 'asc');
    }
    
}
