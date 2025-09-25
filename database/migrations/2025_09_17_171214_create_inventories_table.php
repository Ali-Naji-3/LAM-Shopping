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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->integer('minimum_stock')->default(0);
            $table->integer('reorder_level')->default(5);
            $table->timestamps();
            
            // Add unique constraint to prevent duplicate product-warehouse combinations
            $table->unique(['product_id', 'warehouse_id']);
            
            // Add indexes for performance
            $table->index(['warehouse_id', 'quantity']);
            $table->index(['product_id', 'quantity']);
            $table->index(['quantity', 'minimum_stock']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
