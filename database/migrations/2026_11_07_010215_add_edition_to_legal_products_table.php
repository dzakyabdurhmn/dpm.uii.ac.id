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
        Schema::table('legal_products', function (Blueprint $table) {
            $table->string('edition', 50)->nullable()->after('year'); // e.g. "Ke-38", "Ke-37", dsb.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_products', function (Blueprint $table) {
            $table->dropColumn('edition');
        });
    }
};
