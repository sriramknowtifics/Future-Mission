<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {

            /** ------------------------------
             * UNIQUE ORDER NUMBER
             * -------------------------------*/
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->unique()->after('id');
            }

            /** ------------------------------
             * TRACKING ID (for delivery tracking)
             * -------------------------------*/
            if (!Schema::hasColumn('orders', 'tracking_id')) {
                $table->string('tracking_id')->nullable()->after('order_number');
            }

            /** ------------------------------
             * USER FK
             * -------------------------------*/
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('tracking_id');
                $table->foreign('user_id')
                      ->references('id')->on('users')
                      ->onDelete('cascade');
            }

            /** ------------------------------
             * STATUS ENUM
             * -------------------------------*/
            if (Schema::hasColumn('orders', 'status')) {
                $table->enum('status', [
                    'pending', 'confirmed', 'processing', 'packed',
                    'shipped', 'delivered', 'cancelled', 'returned'
                ])->default('pending')->change();
            }

            /** ------------------------------
             * JSON ADDRESSES
             * -------------------------------*/
            if (!Schema::hasColumn('orders', 'shipping_address')) {
                $table->json('shipping_address')->nullable()->after('status');
            }

            if (!Schema::hasColumn('orders', 'billing_address')) {
                $table->json('billing_address')->nullable()->after('shipping_address');
            }

            /** ------------------------------
             * PRICING FIELDS
             * -------------------------------*/
            if (!Schema::hasColumn('orders', 'subtotal_amount')) {
                $table->decimal('subtotal_amount', 12, 2)->default(0)->after('billing_address');
            }

            if (!Schema::hasColumn('orders', 'shipping_cost')) {
                $table->decimal('shipping_cost', 10, 2)->default(0)->after('subtotal_amount');
            }

            if (!Schema::hasColumn('orders', 'tax_amount')) {
                $table->decimal('tax_amount', 10, 2)->default(0)->after('shipping_cost');
            }

            if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 12, 2)->default(0)->after('tax_amount');
            }

            /** ------------------------------
             * PAYMENT INFO
             * -------------------------------*/
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('total_amount');
            }

            if (Schema::hasColumn('orders', 'payment_status')) {
                $table->enum('payment_status', ['pending','paid','failed','refunded'])
                      ->default('pending')
                      ->change();
            } else {
                $table->enum('payment_status', ['pending','paid','failed','refunded'])
                      ->default('pending')
                      ->after('payment_method');
            }

            if (!Schema::hasColumn('orders', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->after('payment_status');
            }

            /** ------------------------------
             * DELIVERY ASSIGNMENT
             * -------------------------------*/
            if (!Schema::hasColumn('orders', 'delivery_user_id')) {
                $table->unsignedBigInteger('delivery_user_id')->nullable()->after('payment_reference');
                $table->foreign('delivery_user_id')
                      ->references('id')->on('users')
                      ->onDelete('set null');
            }

            /** ------------------------------
             * META
             * -------------------------------*/
            if (!Schema::hasColumn('orders', 'placed_at')) {
                $table->timestamp('placed_at')->nullable()->after('delivery_user_id');
            }

            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('placed_at');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'order_number',
                'tracking_id',
                'shipping_address',
                'billing_address',
                'subtotal_amount',
                'shipping_cost',
                'tax_amount',
                'total_amount',
                'payment_method',
                'payment_reference',
                'placed_at',
                'notes'
            ]);

            if (Schema::hasColumn('orders', 'delivery_user_id')) {
                $table->dropForeign(['delivery_user_id']);
                $table->dropColumn('delivery_user_id');
            }
        });
    }
};
