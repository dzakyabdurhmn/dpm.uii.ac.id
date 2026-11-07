<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komponen_dana', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 80);
            $table->smallInteger('urutan')->default(0);
            $table->boolean('is_tampil')->default(true);
            $table->enum('peran', ['distribusi', 'taktis', 'lainnya'])->default('lainnya');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komponen_dana');
    }
};
