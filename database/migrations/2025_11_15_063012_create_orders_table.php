<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['pending','paid','packed','shipped','out_for_delivery','delivered','cancelled','returned'])->default('pending');
            $table->json('shipping_address')->nullable();
            $table->json('billing_address')->nullable();
            $table->decimal('shipping_cost', 10, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('subtotal_amount', 12, 2)->default(0.00);
            $table->decimal('total_amount', 12, 2)->default(0.00);
            $table->string('payment_method')->nullable(); // cod, upi, card, wallet
            $table->enum('payment_status', ['pending','paid','failed','refunded'])->default('pending');
            $table->foreignId('delivery_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['order_number','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
