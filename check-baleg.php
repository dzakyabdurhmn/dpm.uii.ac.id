<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Contracts\Console\Kernel;

$cat = DocumentCategory::where('slug', 'badan-kelengkapan-dewan')->first();
$docs = Document::where('document_category_id', $cat->id)->get();

echo "=== Badan Kelengkapan Dewan ===\n";
foreach ($docs as $doc) {
    echo "  - {$doc->title} ({$doc->year})\n";
}
