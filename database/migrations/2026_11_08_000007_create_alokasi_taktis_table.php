<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alokasi_taktis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dana_triwulan_id')->constrained('dana_triwulan')->cascadeOnDelete();
            $table->foreignId('fakultas_id')->nullable()->constrained('fakultas')->nullOnDelete();
            $table->unsignedBigInteger('jumlah');
            $table->string('keterangan')->nullable();
            $table->unique(['dana_triwulan_id', 'fakultas_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alokasi_taktis');
    }
};
