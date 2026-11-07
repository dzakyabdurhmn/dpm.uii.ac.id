<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pimpinan_dewans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periods')->onDelete('cascade');
            $table->string('jabatan'); // Ketua, Sekjen, Komisi 1, Komisi 2, Komisi 3, Komisi 4, Anggota Komisi 1-4
            $table->string('nama');
            $table->string('fakultas')->nullable();
            $table->string('prodi')->nullable();
            $table->string('angkatan')->nullable();
            $table->string('nim')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('foto_path')->nullable();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['periode_id', 'is_active']);
            $table->index('jabatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pimpinan_dewans');
    }
};
