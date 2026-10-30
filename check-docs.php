<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Document;
use App\Models\DocumentCategory;

$cats = DocumentCategory::where('type', 'sub')->orWhereNull('parent_id')->get();
foreach ($cats as $cat) {
    $docs = Document::where('document_category_id', $cat->id)->get();
    if ($docs->count() > 0) {
        echo "=== {$cat->name} ({$cat->slug}) - {$docs->count()} docs ===\n";
        foreach ($docs as $doc) {
            echo "  - {$doc->title} ({$doc->year})\n";
        }
    }
}