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
        Schema::table('item_checks', function (Blueprint $table) {
            $table->unsignedBigInteger('location_item_id')->nullable();

        // Add a foreign key constraint if you have the LocationItem table
        $table->foreign('location_item_id')->references('id')->on('location_inventory')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_checks', function (Blueprint $table) {
            $table->dropForeign(['location_item_id']);
            $table->dropColumn('location_item_id');
        });
    }
};
