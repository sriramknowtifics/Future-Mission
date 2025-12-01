<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('services', function (Blueprint $table) {

        // VAT
        if (!Schema::hasColumn('services', 'vat_percentage')) {
            $table->decimal('vat_percentage', 5, 2)->default(10.00)->after('offer_price');
        }
        if (!Schema::hasColumn('services', 'vat_included')) {
            $table->boolean('vat_included')->default(true)->after('vat_percentage');
        }

        // Visit Fee & Minimum
        if (!Schema::hasColumn('services', 'visit_fee')) {
            $table->decimal('visit_fee', 12, 2)->nullable()->after('vat_included');
        }
        if (!Schema::hasColumn('services', 'minimum_charge')) {
            $table->decimal('minimum_charge', 12, 2)->nullable()->after('visit_fee');
        }
        if (!Schema::hasColumn('services', 'minimum_minutes')) {
            $table->integer('minimum_minutes')->nullable()->after('minimum_charge');
        }

        // Bahrain Location
        if (!Schema::hasColumn('services', 'service_city')) {
            $table->string('service_city', 150)->nullable()->after('minimum_minutes');
        }
        if (!Schema::hasColumn('services', 'service_area')) {
            $table->string('service_area', 150)->nullable()->after('service_city');
        }

        // Timing
        if (!Schema::hasColumn('services', 'available_time_start')) {
            $table->time('available_time_start')->nullable()->after('service_area');
        }
        if (!Schema::hasColumn('services', 'available_time_end')) {
            $table->time('available_time_end')->nullable()->after('available_time_start');
        }
        if (!Schema::hasColumn('services', 'is_24_hours')) {
            $table->boolean('is_24_hours')->default(false)->after('available_time_end');
        }

        // Add-ons
        if (!Schema::hasColumn('services', 'addons')) {
            $table->json('addons')->nullable()->after('is_24_hours');
        }

        // Cancellation
        if (!Schema::hasColumn('services', 'cancellation_policy')) {
            $table->text('cancellation_policy')->nullable()->after('addons');
        }
        if (!Schema::hasColumn('services', 'cancellation_fee')) {
            $table->decimal('cancellation_fee', 12, 2)->nullable()->after('cancellation_policy');
        }

        // Commission
        if (!Schema::hasColumn('services', 'commission_percentage')) {
            $table->decimal('commission_percentage', 5, 2)->default(0.00)->after('cancellation_fee');
        }

        // Thumbnail
        if (!Schema::hasColumn('services', 'thumbnail')) {
            $table->string('thumbnail')->nullable()->after('commission_percentage');
        }

        // Documents
        if (!Schema::hasColumn('services', 'documents')) {
            $table->json('documents')->nullable()->after('thumbnail');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
