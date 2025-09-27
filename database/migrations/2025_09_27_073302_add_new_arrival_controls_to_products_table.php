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
        Schema::table('products', function (Blueprint $table) {
            // New arrival control fields
            $table->boolean('is_new_arrival')->default(false)->after('featured');
            $table->timestamp('new_arrival_until')->nullable()->after('is_new_arrival');
            $table->boolean('featured_new_arrival')->default(false)->after('new_arrival_until');
            $table->integer('new_arrival_priority')->default(0)->after('featured_new_arrival');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove new arrival control fields
            $table->dropColumn([
                'is_new_arrival',
                'new_arrival_until', 
                'featured_new_arrival',
                'new_arrival_priority'
            ]);
        });
    }
};
