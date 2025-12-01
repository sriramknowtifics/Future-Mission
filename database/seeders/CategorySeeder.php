<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
  public function run(): void
  {
    // top-level categories array from user's image table
    $cats = [
      ['name' => 'Appliances', 'sub' => ['Home and Kitchen Appliances']],
      ['name' => 'Lighting', 'sub' => ['Bulbs, Fixtures, and Controls']],
      ['name' => 'Wiring & Installation', 'sub' => ['Infrastructure and Installation Components']],
      ['name' => 'Power Distribution & Control', 'sub' => ['Safety and Management Devices']],
      ['name' => 'Tools & Equipment', 'sub' => ['Testing and Repair Gear']],
      ['name' => 'Batteries & Power Storage', 'sub' => ['Energy Sources']],
      ['name' => 'Security & Automation', 'sub' => ['Smart and Protective Systems']],
      ['name' => 'Consumer Electronics Accessories', 'sub' => ['Charging and Connectivity']],
    ];

    foreach ($cats as $c) {
      $parent = Category::firstOrCreate([
        'name' => $c['name'],
        'slug' => Str::slug($c['name'])
      ], [
        'description' => null
      ]);

      foreach ($c['sub'] as $subName) {
        Category::firstOrCreate([
          'name' => $subName,
          'parent_id' => $parent->id,
          'slug' => Str::slug($parent->name . '-' . $subName)
        ], [
          'description' => null
        ]);
      }
    }
  }
}
