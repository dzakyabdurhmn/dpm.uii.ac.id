<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // "group" clusters categories under one section (Dana, Laporan, Keputusan)
        // so the public navigation can render them together.
        Schema::table('document_categories', function (Blueprint $table) {
            $table->string('group')->nullable()->after('description');
            $table->index('group');
        });

        // Alat kelengkapan are known by their short name (Mentari, Baleg, Bawas, ...).
        Schema::table('organizational_units', function (Blueprint $table) {
            $table->string('abbreviation', 32)->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('document_categories', function (Blueprint $table) {
            $table->dropIndex(['group']);
            $table->dropColumn('group');
        });

        Schema::table('organizational_units', function (Blueprint $table) {
            $table->dropColumn('abbreviation');
        });
    }
};
