<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Contracts\Console\Kernel;

echo "=== Post Categories ===\n";
$cats = PostCategory::all();
foreach ($cats as $cat) {
    echo "  - {$cat->name} ({$cat->slug})\n";
}

echo "\n=== Posts ===\n";
$posts = Post::with('category')->get();
echo 'Total: '.$posts->count()."\n";
foreach ($posts as $post) {
    $catName = $post->category ? $post->category->name : 'No Category';
    echo "  - {$post->title} | {$post->slug} | {$catName} | ".($post->published_at ? 'Published' : 'Draft')."\n";
}
