<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('category')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->string('attachment_path')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->string('status')->default('baru'); // baru, diproses, selesai, ditolak
            $table->text('response')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
