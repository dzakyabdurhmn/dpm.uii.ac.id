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
        Schema::table('menu_items', function (Blueprint $table) {
            $table->text('description')->nullable()->after('url');
            $table->string('mega_eyebrow')->nullable()->after('description');
            $table->string('mega_image')->nullable()->after('mega_eyebrow');
            $table->string('mega_caption_title')->nullable()->after('mega_image');
            $table->text('mega_caption_desc')->nullable()->after('mega_caption_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'mega_eyebrow',
                'mega_image',
                'mega_caption_title',
                'mega_caption_desc',
            ]);
        });
    }
};
