<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pimpinan_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pimpinan_dewan_id')->constrained('pimpinan_dewan')->onDelete('cascade');
            $table->text('tugas');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('pimpinan_dewan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pimpinan_tugas');
    }
};
