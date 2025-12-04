<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {

            if (!Schema::hasColumn('order_items', 'vendor_id')) {
                $table->unsignedBigInteger('vendor_id')->nullable()->after('product_id');
                $table->foreign('vendor_id')
                      ->references('id')->on('vendors')
                      ->onDelete('set null');
            }

            if (!Schema::hasColumn('order_items', 'sku')) {
                $table->string('sku')->nullable()->after('name');
            }

            if (!Schema::hasColumn('order_items', 'attributes')) {
                $table->json('attributes')->nullable()->after('subtotal');
            }

            // Ensure pricing columns exist
            if (!Schema::hasColumn('order_items', 'price')) {
                $table->decimal('price', 12, 2)->after('name');
            }

            if (!Schema::hasColumn('order_items', 'qty')) {
                $table->integer('qty')->default(1)->after('price');
            }

            if (!Schema::hasColumn('order_items', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->default(0)->after('qty');
            }
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['vendor_id', 'sku', 'attributes']);
        });
    }
};
