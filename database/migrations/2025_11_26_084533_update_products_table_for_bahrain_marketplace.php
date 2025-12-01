<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            /* ============================
               1. Pricing Improvements
            ============================ */
            if (!Schema::hasColumn('products', 'offer_price')) {
                $table->decimal('offer_price', 12, 2)->nullable()->after('price')
                      ->comment('Discounted price');
            }

            /* ============================
               2. Bahrain VAT
            ============================ */
            if (!Schema::hasColumn('products', 'vat_percentage')) {
                $table->decimal('vat_percentage', 5, 2)
                      ->default(10.00)->after('offer_price')
                      ->comment('Bahrain VAT rate (10%)');
            }

            if (!Schema::hasColumn('products', 'vat_included')) {
                $table->boolean('vat_included')
                      ->default(true)->after('vat_percentage')
                      ->comment('1 = price includes VAT');
            }

            /* =====================================
               3. Additional Charges (for appliances)
            ===================================== */
            if (!Schema::hasColumn('products', 'installation_fee')) {
                $table->decimal('installation_fee', 12, 2)
                      ->nullable()->after('vat_included')
                      ->comment('Optional installation fee');
            }

            if (!Schema::hasColumn('products', 'warranty_months')) {
                $table->integer('warranty_months')->nullable()->after('installation_fee')
                      ->comment('Product warranty duration');
            }

            /* ============================
               4. Location (for Bahrain)
            ============================ */
            if (!Schema::hasColumn('products', 'product_city')) {
                $table->string('product_city', 150)->nullable()->after('warranty_months')
                      ->comment('Manama, Riffa, Muharraq, etc.');
            }

            if (!Schema::hasColumn('products', 'product_area')) {
                $table->string('product_area', 150)->nullable()->after('product_city')
                      ->comment('Block/Area inside city');
            }

            /* ============================
               5. Commission System
            ============================ */
            if (!Schema::hasColumn('products', 'commission_percentage')) {
                $table->decimal('commission_percentage', 5, 2)->default(0.00)
                      ->after('product_area')
                      ->comment('Platform commission for vendor');
            }

            /* ============================
               6. Media / Documents
            ============================ */
            if (!Schema::hasColumn('products', 'documents')) {
                $table->json('documents')->nullable()->after('commission_percentage')
                      ->comment('Certificates, manuals, product docs');
            }

            /* ============================
               7. Cancellation Policy
            ============================ */
            if (!Schema::hasColumn('products', 'cancellation_policy')) {
                $table->text('cancellation_policy')->nullable()->after('documents');
            }

            if (!Schema::hasColumn('products', 'cancellation_fee')) {
                $table->decimal('cancellation_fee', 12, 2)->nullable()->after('cancellation_policy');
            }

        });
    }


    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'offer_price',
                'vat_percentage',
                'vat_included',
                'installation_fee',
                'warranty_months',
                'product_city',
                'product_area',
                'commission_percentage',
                'documents',
                'cancellation_policy',
                'cancellation_fee'
            ]);
        });
    }
};
