<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->nullable()->index();
            $table->string('sku')->nullable()->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('price', 12, 2)->default(0.00);
            $table->integer('stock')->default(0);
            $table->boolean('is_active')->default(true); // vendor toggle
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->json('attributes')->nullable(); // size/color/extra attributes
            $table->decimal('weight', 10, 3)->nullable();
            $table->string('hsn')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['is_active', 'approval_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
