<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TradingTip;

$tips = TradingTip::all();
echo json_encode($tips, JSON_PRETTY_PRINT);
