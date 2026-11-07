<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dana_seksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dana_triwulan_id')->constrained('dana_triwulan')->cascadeOnDelete();
            $table->enum('seksi', ['overview', 'pembagian', 'universitas', 'fakultas', 'per_fakultas', 'rasio', 'taktis']);
            $table->smallInteger('urutan')->default(0);
            $table->boolean('is_tampil')->default(true);
            $table->string('judul', 120)->nullable();
            $table->unique(['dana_triwulan_id', 'seksi']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dana_seksi');
    }
};
