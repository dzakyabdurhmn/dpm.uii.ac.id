<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Produk hukum wajib berupa berkas yang diunggah, bukan tautan luar.
        Schema::table('legal_products', function (Blueprint $table) {
            $table->dropColumn('external_url');
        });

        // Navigasi memakai URL tetap, bukan relasi ke halaman bebas.
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('page_id');
        });

        Schema::dropIfExists('pages');

        Schema::create('site_contents', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('title');
            $table->longText('body')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_contents');

        Schema::table('menu_items', function (Blueprint $table) {
            $table->foreignId('page_id')->nullable()->after('parent_id')->constrained()->nullOnDelete();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('show_in_menu')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::table('legal_products', function (Blueprint $table) {
            $table->string('external_url', 2048)->nullable();
        });
    }
};
