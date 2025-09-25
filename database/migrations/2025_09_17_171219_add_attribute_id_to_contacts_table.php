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
        Schema::table('contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_id')->nullable()->after('brand_id');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('set null');
            $table->index('attribute_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
            $table->dropIndex(['attribute_id']);
            $table->dropColumn('attribute_id');
        });
    }
};
