<?php

require 'vendor/autoload.php';

use App\Models\DocumentCategory;

$cats = DocumentCategory::where('group', 'Dana')->get();
echo "Dana Categories:\n";
foreach ($cats as $c) {
    echo '  ID '.$c->id.': '.$c->name.' (slug: '.$c->slug.")\n";
}
echo "\nTotal: ".$cats->count()."\n";
