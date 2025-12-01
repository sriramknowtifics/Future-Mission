<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_orders', function (Blueprint $table) {

            $table->id();

            // CUSTOMER
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // SERVICE & VENDOR
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');

            // BOOKING
            $table->date('booking_date');
            $table->time('booking_time');
            $table->integer('duration_minutes')->nullable();

            // ADDRESS INFO
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->longText('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // PRICING SNAPSHOT
            $table->decimal('base_price', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);

            // SERVICE STATUS
            $table->enum('service_status', [
                'pending',
                'accepted',
                'assigned',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('pending');

            // PAYMENT STATUS
            $table->enum('payment_status', [
                'pending',
                'awaiting_payment',
                'paid',
                'failed',
                'refunded',
            ])->default('pending');

            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();

            // TECHNICIAN
            $table->foreignId('assigned_user_id')->nullable()
                ->constrained('users')->onDelete('set null');

            // FEEDBACK
            $table->integer('rating')->nullable();
            $table->text('review')->nullable();

            // OTP FLOW
            $table->string('otp_code')->nullable();
            $table->timestamp('otp_verified_at')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
