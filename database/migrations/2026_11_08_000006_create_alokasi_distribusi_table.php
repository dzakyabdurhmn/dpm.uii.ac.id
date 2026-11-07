<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alokasi_distribusi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dana_triwulan_id')->constrained('dana_triwulan')->cascadeOnDelete();
            $table->foreignId('lembaga_id')->constrained('lembaga');
            $table->unsignedBigInteger('jumlah');
            $table->unique(['dana_triwulan_id', 'lembaga_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alokasi_distribusi');
    }
};
