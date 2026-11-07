<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profil_dewans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nim')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('program_studi')->nullable();
            $table->string('angkatan')->nullable();
            $table->string('email_kampus')->nullable();
            $table->string('jabatan');
            $table->string('unit_kerja')->nullable();
            $table->string('periode');
            $table->string('masa_jabatan')->nullable();
            $table->string('status')->default('Aktif');
            $table->text('bio')->nullable();
            $table->text('tugas_tanggung_jawab')->nullable();
            $table->string('instagram')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_dewans');
    }
};
