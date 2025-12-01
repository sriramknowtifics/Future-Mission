<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('services');

        Schema::create('services', function (Blueprint $table) {
            $table->id();

            /**
             * 🔵 Vendor & Category
             */
            $table->unsignedBigInteger('vendor_id');           // service provider
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable(); // admin/moderator

            /**
             * 🔵 Basic Info
             */
            $table->string('name');
            $table->string('slug')->nullable();                // SEO URL
            $table->string('code')->nullable();                // internal service code

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            /**
             * 🔵 Pricing (Base + Offers)
             */
            $table->decimal('price', 12, 2)->default(0.00);     // base price
            $table->decimal('offer_price', 12, 2)->nullable();  // discounted price

            /**
             * 🔵 Bahrain VAT Requirements
             */
            $table->decimal('vat_percentage', 5, 2)->default(10.00)
                  ->comment('Bahrain VAT rate (10%)');
            $table->boolean('vat_included')->default(true)
                  ->comment('1 = price includes VAT');

            /**
             * 🔵 Visit Fee / Minimum Billing
             */
            $table->decimal('visit_fee', 12, 2)->nullable()
                  ->comment('On-site visit / call-out charge');
            $table->decimal('minimum_charge', 12, 2)->nullable()
                  ->comment('Minimum charge for accepting a job');
            $table->integer('minimum_minutes')->nullable()
                  ->comment('Time included in minimum charge');

            /**
             * 🔵 Service Duration & Type
             */
            $table->integer('duration_minutes')->nullable()
                  ->comment('Typical job duration');
            $table->enum('service_type', ['online', 'offline', 'both'])
                  ->default('offline');

            /**
             * 🔵 Availability Schedule
             */
            $table->json('available_days')->nullable()
                  ->comment('Mon–Sun availability');
            $table->time('available_time_start')->nullable()
                  ->comment('Start time');
            $table->time('available_time_end')->nullable()
                  ->comment('End time');
            $table->boolean('is_24_hours')->default(false)
                  ->comment('24/7 emergency service?');

            /**
             * 🔵 Bahrain Location (City + Area)
             */
            $table->string('service_city', 150)->nullable()
                  ->comment('Manama, Riffa, Muharraq, etc.');
            $table->string('service_area', 150)->nullable()
                  ->comment('Block/Area within the city');

            /**
             * 🔵 Add-on Services
             */
            $table->json('addons')->nullable()
                  ->comment('Extra tasks like pipe replacement, AC refill, etc.');

            /**
             * 🔵 Ratings
             */
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('rating_count')->default(0);

            /**
             * 🔵 Cancellation Policy
             */
            $table->text('cancellation_policy')->nullable();
            $table->decimal('cancellation_fee', 12, 2)->nullable();

            /**
             * 🔵 Vendor Commission System
             */
            $table->decimal('commission_percentage', 5, 2)->default(0.00)
                  ->comment('Platform commission charged to vendor');

            /**
             * 🔵 Media / Documents
             */
            $table->string('thumbnail')->nullable()
                  ->comment('Main service image');
            $table->json('documents')->nullable()
                  ->comment('Permits, licenses, certificates, etc.');

            /**
             * 🔵 Tax & Metadata
             */
            $table->string('hsn')->nullable()
                  ->comment('HSN code for invoice mapping');

            /**
             * 🔵 Status Controls
             */
            $table->boolean('is_active')->default(true);
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('approved_at')->nullable();

            /**
             * 🔵 Soft Deletes & Timestamps
             */
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
