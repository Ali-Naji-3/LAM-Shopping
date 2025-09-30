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
        Schema::table('reviews', function (Blueprint $table) {
            // Add JSON column for dynamic attributes
            $table->json('attributes')->nullable()->after('comment');
            
            // Add helpful attributes for common review aspects
            $table->string('pros')->nullable()->after('attributes');
            $table->string('cons')->nullable()->after('pros');
            $table->boolean('would_recommend')->default(true)->after('cons');
            $table->string('purchase_verified')->nullable()->after('would_recommend');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['attributes', 'pros', 'cons', 'would_recommend', 'purchase_verified']);
        });
    }
};
