<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\Site\DistribusiDanaController;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

$router = $app->make('router');
$router->get('/test-route', [DistribusiDanaController::class, 'index']);

$request = Request::create('/test-route', 'GET');
try {
    $response = $router->dispatch($request);
    $content = $response->getContent();
    echo 'STATUS: '.$response->getStatusCode().PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR: '.$e->getMessage().PHP_EOL;
}
