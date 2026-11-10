<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$deleted = DB::table('officials')->whereIn('name', [
    'Hasan Basri', 'Nabila Putri', 'Adi Nugroho', 'Rika Wulandari', 'Tommy Gunawan', 'Lina Marlina', 'Yoga Pratama',
])->delete();

echo 'deleted BAK: '.$deleted.PHP_EOL;
echo 'sisa per unit/periode: '.json_encode(DB::table('officials')->selectRaw('organizational_unit_id, period_id, count(*) c')->groupBy('organizational_unit_id', 'period_id')->get()).PHP_EOL;
