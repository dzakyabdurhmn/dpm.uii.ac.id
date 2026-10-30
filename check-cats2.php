<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DocumentCategory;
use App\Models\Document;

$cats = DocumentCategory::with('children')->get();
foreach ($cats as $cat) {
    if ($cat->type === 'main' || $cat->parent_id === null) {
        echo "=== {$cat->name} ({$cat->slug}) ===\n";
        $count = Document::where('document_category_id', $cat->id)->count();
        echo "  Documents: {$count}\n";
        if ($cat->children->count()) {
            foreach ($cat->children as $child) {
                $subCount = Document::where('document_category_id', $child->id)->count();
                echo "  - {$child->name} ({$child->slug}): {$subCount} docs\n";
            }
        }
    }
}

echo "\nTotal Documents: " . Document::count() . "\n";