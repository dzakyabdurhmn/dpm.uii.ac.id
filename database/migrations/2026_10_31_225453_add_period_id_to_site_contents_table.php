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
        Schema::table('site_contents', function (Blueprint $table) {
            $table->foreignId('period_id')->nullable()->constrained('periods')->nullOnDelete()
                ->after('key');
            $table->unique(['key', 'period_id'], 'site_contents_key_period_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_contents', function (Blueprint $table) {
            $table->dropUnique('site_contents_key_period_unique');
            $table->dropConstrainedForeignId('period_id');
        });
    }
};
