<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        // Drop the old unique constraint on just 'key'
        DB::statement('ALTER TABLE site_contents DROP CONSTRAINT IF EXISTS site_contents_key_unique');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement('ALTER TABLE site_contents DROP CONSTRAINT IF EXISTS site_contents_key_period_unique');
        DB::statement('ALTER TABLE site_contents ADD CONSTRAINT site_contents_key_unique UNIQUE (key)');
    }
};
