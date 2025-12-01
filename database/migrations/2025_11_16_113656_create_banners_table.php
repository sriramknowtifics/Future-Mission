<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('banners', function (Blueprint $table) {
      $table->id();
      $table->string('title')->nullable();
      $table->string('subtitle')->nullable();
      $table->string('cta_text')->nullable();
      $table->string('cta_url')->nullable();
      $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
      $table->string('image')->nullable(); // path in storage/app/public
      $table->boolean('is_active')->default(true);
      $table->integer('sort_order')->default(0);
      $table->string('placement')->default('home'); // optional: home, header, category, promo
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('banners');
  }
};
