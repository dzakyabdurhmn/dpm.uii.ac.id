<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;
use App\Models\MenuItem;

$menu = Menu::where('location', 'header')->first();

echo "=== Header Menu Items ===\n";
$items = MenuItem::where('menu_id', $menu->id)->whereNull('parent_id')->orderBy('sort_order')->get();
foreach ($items as $item) {
    echo "  {$item->sort_order}. {$item->label} -> {$item->url}\n";
    $children = MenuItem::where('parent_id', $item->id)->orderBy('sort_order')->get();
    foreach ($children as $child) {
        echo "      - {$child->label} -> {$child->url}\n";
    }
}