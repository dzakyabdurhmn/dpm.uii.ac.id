<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dana_triwulan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periods');
            $table->unsignedTinyInteger('triwulan');
            $table->unsignedBigInteger('total_dana');
            $table->enum('status', ['draft', 'terbit'])->default('draft');
            $table->timestamp('diterbitkan_pada')->nullable();
            $table->foreignId('diterbitkan_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->string('sumber_url')->nullable();
            $table->unique(['periode_id', 'triwulan']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dana_triwulan');
    }
};
