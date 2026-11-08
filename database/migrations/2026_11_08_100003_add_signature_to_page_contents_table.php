<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->string('signature_role')->nullable();
            $table->string('signature_name')->nullable();
            $table->string('signature_fakultas')->nullable();
            $table->string('signature_nim')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->dropColumn([
                'signature_role',
                'signature_name',
                'signature_fakultas',
                'signature_nim',
            ]);
        });
    }
};
