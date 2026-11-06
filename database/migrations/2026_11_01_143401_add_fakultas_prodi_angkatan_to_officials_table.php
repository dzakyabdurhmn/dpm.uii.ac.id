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
        Schema::table('officials', function (Blueprint $table) {
            $table->string('fakultas')->nullable()->after('position');
            $table->string('prodi')->nullable()->after('fakultas');
            $table->string('angkatan')->nullable()->after('prodi');
            $table->string('nim')->nullable()->after('angkatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            $table->dropColumn(['fakultas', 'prodi', 'angkatan', 'nim']);
        });
    }
};
