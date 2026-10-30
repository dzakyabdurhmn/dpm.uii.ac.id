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
        Schema::table('organizational_units', function (Blueprint $table) {
            // abbreviation already exists
            $table->text('tasks')->nullable()->after('description');
            $table->text('work_programs')->nullable()->after('tasks');
            $table->string('email')->nullable()->after('work_programs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizational_units', function (Blueprint $table) {
            $table->dropColumn(['tasks', 'work_programs', 'email']);
        });
    }
};