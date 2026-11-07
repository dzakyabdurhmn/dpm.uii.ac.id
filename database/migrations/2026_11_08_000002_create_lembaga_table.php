<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lembaga', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 120);
            $table->enum('tingkat', ['universitas', 'fakultas']);
            $table->enum('jenis', ['lem', 'dpm', 'lpm', 'kopma', 'lembaga_khusus', 'lainnya']);
            $table->foreignId('fakultas_id')->nullable()->constrained('fakultas')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('lembaga')->nullOnDelete();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lembaga');
    }
};
