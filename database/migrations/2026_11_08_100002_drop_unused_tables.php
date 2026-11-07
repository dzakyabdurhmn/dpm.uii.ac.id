<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus foreign key dari posts ke post_categories terlebih dahulu
        DB::statement('ALTER TABLE posts DROP CONSTRAINT IF EXISTS posts_post_category_id_foreign');

        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('site_contents');
    }

    public function down(): void
    {
        // Tidak ada rollback untuk penghapusan tabel yang tidak digunakan lagi.
    }
};
