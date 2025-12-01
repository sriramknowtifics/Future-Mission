<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['settlement','commission','refund','payout','adjustment'])->default('settlement');
            $table->decimal('amount', 14, 2)->default(0.00);
            $table->enum('status', ['pending','completed','failed'])->default('pending');
            $table->json('meta')->nullable(); // gateway details, note
            $table->timestamps();
            $table->index(['vendor_id','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
