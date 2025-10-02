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
        Schema::create('settings', function (Blueprint $table) {
           $table->id();

    // Header
    $table->string('logo')->nullable();
    $table->json('menu_items')->nullable(); // تخزنها كـ JSON
    $table->json('top_nav')->nullable(); // phone, email, socials

    // Hero
    $table->string('hero_background')->nullable(); // صورة أو فيديو
    $table->string('hero_title')->nullable();
    $table->string('hero_button_text')->nullable();
    $table->string('hero_button_link')->nullable();

    // Content (slider images as separate table أفضل، لكن ممكن JSON)
    $table->json('sliders')->nullable();

    // Footer
    $table->string('footer_logo')->nullable();
    $table->json('footer_links')->nullable();
    $table->json('footer_categories')->nullable();
    $table->string('contact_name')->nullable();
    $table->string('contact_phone')->nullable();
    $table->string('contact_email')->nullable();
    $table->string('contact_address')->nullable();
    $table->string('footer_copyright')->nullable();
    $table->json('footer_socials')->nullable();

    // Other
    $table->string('language')->nullable();
    $table->string('currency')->nullable();
    $table->json('payment_methods')->nullable();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
