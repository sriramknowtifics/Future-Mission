<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'subtitle',
    'desktop_image',
    'mobile_image',
    'place',
    'cta_text',
    'cta_url',
    'product_id',
    'is_active',
    'sort_order',
    'placement',
  ];

  protected $casts = [
    'is_active' => 'boolean',
  ];

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }

  // helper to return full image url
  public function imageUrl()
  {
    return $this->desktop_image ? asset('storage/' . $this->desktop_image) : null;
  }
}
