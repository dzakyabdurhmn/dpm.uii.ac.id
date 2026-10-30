<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DocumentCategory;

$cats = DocumentCategory::all();
foreach ($cats as $cat) {
    echo "{$cat->id} | {$cat->name} | {$cat->slug} | {$cat->group}\n";
}