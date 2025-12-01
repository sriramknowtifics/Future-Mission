<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Parent category
    public function parent()
    {
        return $this->belongsTo(ServiceCategory::class, 'parent_id');
    }

    // Sub categories
    public function children()
    {
        return $this->hasMany(ServiceCategory::class, 'parent_id');
    }

    // Services under this category
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
