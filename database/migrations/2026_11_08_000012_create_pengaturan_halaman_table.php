<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_halaman', function (Blueprint $table) {
            $table->id();
            $table->string('halaman', 40);
            $table->string('kunci', 60);
            $table->text('nilai');
            $table->unique(['halaman', 'kunci']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_halaman');
    }
};
