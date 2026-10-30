<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Document;

$doc = Document::where('title', 'like', '%Baleg Komisi I%')->first();

if ($doc) {
    echo "Found: {$doc->title}\n";
    $doc->title = 'Struktur Badan Legislasi Dewan Permusyawaratan Mahasiswa Periode 2020-2021';
    $doc->slug = \Illuminate\Support\Str::slug($doc->title);
    $doc->save();
    echo "Updated to: {$doc->title}\n";
} else {
    echo "Document not found\n";
}