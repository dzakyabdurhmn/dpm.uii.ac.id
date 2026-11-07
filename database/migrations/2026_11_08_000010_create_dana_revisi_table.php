<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dana_revisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dana_triwulan_id')->constrained('dana_triwulan')->cascadeOnDelete();
            $table->foreignId('diubah_oleh')->constrained('users')->nullOnDelete();
            $table->text('alasan');
            $table->json('snapshot');
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dana_revisi');
    }
};
