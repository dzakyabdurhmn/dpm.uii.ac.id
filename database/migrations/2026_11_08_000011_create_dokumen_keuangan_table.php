<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_keuangan', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['lpj', 'lha']);
            $table->foreignId('periode_id')->constrained('periods');
            $table->foreignId('lembaga_id')->constrained('lembaga');
            $table->enum('semester', ['ganjil', 'genap']);
            $table->string('judul', 200);
            $table->date('tanggal');
            $table->string('file_path')->nullable();
            $table->enum('status', ['draft', 'terbit'])->default('draft');
            $table->unique(['jenis', 'periode_id', 'lembaga_id', 'semester']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_keuangan');
    }
};
