<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_products', function (Blueprint $table) {
            $table->id();

            // pdkm, gbhkm, pkm, pdpm
            $table->string('type', 20)->index();

            // Only numbered products (PKM, PDPM) use these.
            $table->unsignedSmallInteger('number')->nullable();
            $table->unsignedSmallInteger('year')->nullable();

            $table->foreignId('period_id')->nullable()->constrained()->nullOnDelete();

            // For "Perubahan atas PKM No. 4 Tahun 2018 ..." style documents.
            $table->foreignId('amends_id')->nullable()->constrained('legal_products')->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->string('file_path')->nullable();
            $table->string('external_url', 2048)->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->default(0);

            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedBigInteger('downloads')->default(0);
            $table->timestamps();

            $table->index(['type', 'year', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_products');
    }
};
