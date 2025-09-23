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
        // Add soft deletes to main entities
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'deleted_at')) {
                $table->softDeletes();
            }
        });
        
        Schema::table('brands', function (Blueprint $table) {
            if (!Schema::hasColumn('brands', 'deleted_at')) {
                $table->softDeletes();
            }
        });
        
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'deleted_at')) {
                $table->softDeletes();
            }
        });
        
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });
        
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'deleted_at')) {
                $table->softDeletes();
            }
        });
        
        Schema::table('warehouses', function (Blueprint $table) {
            if (!Schema::hasColumn('warehouses', 'deleted_at')) {
                $table->softDeletes();
            }
        });
        
        Schema::table('attributes', function (Blueprint $table) {
            if (!Schema::hasColumn('attributes', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('brands', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
