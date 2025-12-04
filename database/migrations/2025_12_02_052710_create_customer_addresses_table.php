<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');

            // Address label type
            $table->enum('type', ['home', 'work', 'other'])->default('home');

            // Address fields
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address_line')->nullable();
            $table->string('landmark')->nullable()->comment('Optional landmark such as Near Mall');
            $table->string('zip_code')->nullable();

            // For phone specific to address (optional)
            $table->string('contact_phone')->nullable();

            // Make one default
            $table->boolean('is_default')->default(false);

            $table->timestamps();

            // Foreign key
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
