<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\LegalProduct;
use Illuminate\Contracts\Console\Kernel;

$products = LegalProduct::orderBy('type')->orderBy('year')->orderBy('number')->get();

echo "=== LEGAL PRODUCTS ===\n";
foreach ($products as $p) {
    $num = $p->number ? "No. {$p->number}" : 'Tunggal';
    echo "  {$p->type} | {$num} | {$p->year} | {$p->title}\n";
}
echo "\nTotal: ".$products->count()."\n";
