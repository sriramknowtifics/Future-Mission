<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('products', function (Blueprint $table) {
      if (!Schema::hasColumn('products', 'type')) {
        $table->string('type')->default('product')->comment('product|service');
      }
      if (!Schema::hasColumn('products', 'sku')) {
        $table->string('sku')->nullable()->unique();
      }
      if (!Schema::hasColumn('products', 'status')) {
        $table->string('status')->default('draft')->comment('draft|published|archived');
      }
      if (!Schema::hasColumn('products', 'is_approved')) {
        $table->boolean('is_approved')->default(false)->index();
      }
      if (!Schema::hasColumn('products', 'service_meta')) {
        $table->json('service_meta')->nullable()->comment('json: service-specific fields (duration, location, hours)');
      }
    });
  }

  public function down(): void
  {
    Schema::table('products', function (Blueprint $table) {
      $table->dropColumn(['type', 'sku', 'status', 'is_approved', 'service_meta']);
    });
  }
};
