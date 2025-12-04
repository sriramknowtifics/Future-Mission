<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {

            // --- Fix enum status ---
            $table->enum('status', [
                'pending', 'confirmed', 'processing', 'packed',
                'shipped', 'delivered', 'cancelled', 'returned'
            ])->default('pending')->change();

            // --- Convert longtext to JSON ---
            $table->json('shipping_address')->nullable()->change();
            $table->json('billing_address')->nullable()->change();

            // --- Ensure order_number exists & is unique ---
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->unique()->after('id');
            }

            // --- Add placed_at only if missing ---
            if (!Schema::hasColumn('orders', 'placed_at')) {
                $table->timestamp('placed_at')->nullable()->after('notes');
            }

        });
    }


    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // rollback JSON to LONGTEXT
            $table->longText('shipping_address')->nullable()->change();
            $table->longText('billing_address')->nullable()->change();

            if (Schema::hasColumn('orders', 'placed_at')) {
                $table->dropColumn('placed_at');
            }
        });
    }
};

