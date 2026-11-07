<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa_fakultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periods');
            $table->foreignId('fakultas_id')->constrained('fakultas');
            $table->unsignedInteger('jumlah_mahasiswa');
            $table->unique(['periode_id', 'fakultas_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_fakultas');
    }
};
