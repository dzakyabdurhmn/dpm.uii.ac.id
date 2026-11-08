<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus foreign key & kolom lama dari posts ke post_categories.
        // SQLite tidak mendukung DROP CONSTRAINT, jadi kolomnya di-drop
        // lewat schema builder (table rebuild).
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE posts DROP CONSTRAINT IF EXISTS posts_post_category_id_foreign');
        }

        if (Schema::hasColumn('posts', 'post_category_id')) {
            Schema::table('posts', function (Blueprint $table): void {
                $table->dropColumn('post_category_id');
            });
        }

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
