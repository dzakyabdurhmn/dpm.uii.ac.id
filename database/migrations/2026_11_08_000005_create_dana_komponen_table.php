<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dana_komponen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dana_triwulan_id')->constrained('dana_triwulan')->cascadeOnDelete();
            $table->foreignId('komponen_id')->constrained('komponen_dana');
            $table->unsignedBigInteger('jumlah');
            $table->unique(['dana_triwulan_id', 'komponen_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dana_komponen');
    }
};
