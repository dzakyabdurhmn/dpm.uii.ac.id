<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Document;
use App\Models\DocumentCategory;

$cat = DocumentCategory::where('slug', 'surat-keputusan')->first();

$docs = Document::where('document_category_id', $cat->id)->get();
foreach ($docs as $doc) {
    echo "{$doc->year} | {$doc->title} | {$doc->file_path}\n";
}