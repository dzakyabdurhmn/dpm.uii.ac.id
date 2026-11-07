<?php

// Database changes script
require_once 'vendor/autoload.php';

use App\Models\OrganizationalUnit;
use App\Models\SiteContent;

// 1. Verify remaining units
$count = OrganizationalUnit::count();
echo 'Remaining organizational units: '.$count.PHP_EOL;

// 2. Delete konten halaman dari database
SiteContent::query()->delete();
echo 'Site contents deleted.'.PHP_EOL;

// 3. Buat "SAMBUTAN KETUA" content
$existing = SiteContent::where('key', 'sambutan')->first();
if (! $existing) {
    $content = new SiteContent;
    $content->key = 'sambutan';
    $content->title = 'Sambutan';
    $content->body = 'Ini adalah sambutan dari Ketua DPM UII.';
    $content->save();
    echo 'Sambutan content created.'.PHP_EOL;
} else {
    echo 'Sambutan content already exists.'.PHP_EOL;
}

// 4. Verify remaining units
$count2 = OrganizationalUnit::count();
echo 'Remaining organizational units after: '.$count2.PHP_EOL;

echo 'Done.'.PHP_EOL;
