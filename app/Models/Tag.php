<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  protected $fillable = ['name', 'slug'];

  public function products()
  {
    return $this->belongsToMany(\App\Models\Product::class, 'product_tag')->withTimestamps();
  }
}
