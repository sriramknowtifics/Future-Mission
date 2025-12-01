<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('banners', function (Blueprint $table) {
        // Rename old image to mobile image
        $table->renameColumn('image', 'mobile_image');

        // Add desktop image column
        $table->string('desktop_image')->nullable()->after('mobile_image');
    });
}

public function down()
{
    Schema::table('banners', function (Blueprint $table) {
        // Reverse: rename back
        $table->renameColumn('mobile_image', 'image');

        // Drop desktop_image
        $table->dropColumn('desktop_image');
    });
}

};
