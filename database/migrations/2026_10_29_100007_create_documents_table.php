<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('period_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Either a locally uploaded file or an external link (e.g. Google Drive).
            $table->string('file_path')->nullable();
            $table->string('external_url', 2048)->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->default(0);

            // Reporting metadata: laporan triwulan uses year + quarter (1-4).
            $table->unsignedSmallInteger('year')->nullable();
            $table->unsignedTinyInteger('quarter')->nullable();

            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('downloads')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['document_category_id', 'year', 'quarter']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
