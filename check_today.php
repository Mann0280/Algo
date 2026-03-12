<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\StockSignal;

$all = StockSignal::all();
echo "IDs and Values:\n";
foreach($all as $s) {
    printf("ID:%d | Symbol:[%s] | Type:[%s] | Result:[%s] | PNL:[%s] | Date:[%s]\n", 
        $s->id, $s->stock_name, $s->signal_type, $s->result, $s->pnl, $s->entry_date);
}
