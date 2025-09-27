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
            $table->unsignedBigInteger('review_id')->nullable()->after('warehouse_id');
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('set null');
            $table->index('review_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['review_id']);
            $table->dropIndex(['review_id']);
            $table->dropColumn('review_id');
        });
    }
};
