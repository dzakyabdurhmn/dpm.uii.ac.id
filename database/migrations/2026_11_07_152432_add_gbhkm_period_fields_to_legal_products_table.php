<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('legal_products', function (Blueprint $table) {
            $table->date('enacted_on')->nullable()->after('published_at');
            $table->string('forum', 150)->nullable()->after('enacted_on');
        });

        // Satu GBHKM hanya boleh ada satu per periode kepengurusan.
        DB::statement("CREATE UNIQUE INDEX legal_products_gbhkm_period_unique ON legal_products (period_id) WHERE type = 'gbhkm' AND period_id IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS legal_products_gbhkm_period_unique');

        Schema::table('legal_products', function (Blueprint $table) {
            $table->dropColumn(['enacted_on', 'forum']);
        });
    }
};
