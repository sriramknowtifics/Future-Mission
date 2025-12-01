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
        Schema::create('service_categories', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('slug')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();
            
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')->on('service_categories')
                ->nullOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_categories');
    }
};
