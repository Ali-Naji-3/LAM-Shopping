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
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id(); // BIGINT PK, auto_increment
            $table->unsignedBigInteger('attribute_id'); // BIGINT FK → attributes.id, not null
            $table->string('value', 255); // VARCHAR(255), not null
            $table->timestamps(); // created_at, updated_at TIMESTAMP, nullable

            // Indexes
            $table->index('attribute_id');
            $table->index(['attribute_id', 'value']);

            // Foreign key constraint
            $table->foreign('attribute_id')
                  ->references('id')
                  ->on('attributes')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key first to avoid errors
        Schema::table('attribute_values', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
        });

        Schema::dropIfExists('attribute_values');
    }
};
