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
        Schema::create('bio_links', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('DPM UII');
            $table->string('tagline')->default('Lembaga Legislatif Keluarga Mahasiswa UII');
            $table->string('handle')->default('@dpmuii');
            $table->string('logo')->nullable();
            $table->longText('description')->nullable();
            $table->string('theme_color')->default('#001E43');
            $table->json('social_links')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bio_links');
    }
};
