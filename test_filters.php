<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\StockSignal;
use Illuminate\Http\Request;

function testFilter($params) {
    echo "Testing with params: " . json_encode($params) . "\n";
    $request = new Request($params);
    
    // NEW LOGIC
    $query = StockSignal::query()
        ->where(function($q) {
            $q->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') < STR_TO_DATE(?, '%Y-%m-%d')", [now()->toDateString()])
              ->orWhere(function($sq) {
                  $sq->where('entry_date', now()->toDateString())
                     ->where(function($ssq) {
                         $ssq->whereNotNull('result')->where('result', '!=', '')->where('result', '!=', 'RUNNING')
                             ->orWhereNotNull('pnl')->where('pnl', '!=', '');
                     });
              });
        });

    if ($request->filled('start_date')) {
        $query->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') >= STR_TO_DATE(?, '%Y-%m-%d')", [$request->start_date]);
    }
    if ($request->filled('end_date')) {
        $query->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') <= STR_TO_DATE(?, '%Y-%m-%d')", [$request->end_date]);
    }
    if ($request->filled('symbol')) {
        $query->where('stock_name', 'LIKE', '%' . strtoupper($request->symbol) . '%');
    }
    if ($request->filled('signal_type')) {
        $query->where('signal_type', strtoupper($request->signal_type));
    }
    if ($request->filled('result')) {
        $res = strtoupper($request->result);
        if ($res === 'WIN') {
            $query->where(function($q) {
                $q->where('result', 'WIN')
                  ->orWhere(function($sq) {
                      $sq->where(function($internal) {
                          $internal->whereNull('result')->orWhere('result', '');
                      })->where('pnl', '>', 0);
                  });
            });
        } elseif ($res === 'LOSS') {
            $query->where(function($q) {
                $q->where('result', 'LOSS')
                  ->orWhere(function($sq) {
                      $sq->where(function($internal) {
                          $internal->whereNull('result')->orWhere('result', '');
                      })->where('pnl', '<', 0);
                  });
            });
        } else {
            $query->where('result', $res);
        }
    }

    $results = $query->get();
    echo "Count: " . $results->count() . "\n";
    foreach($results as $r) {
        echo " - ID:{$r->id}, Symbol:{$r->stock_name}, Type:{$r->signal_type}, Result:{$r->result}, PNL:{$r->pnl}\n";
    }
    echo "--------------------\n";
}

testFilter([]);
testFilter(['symbol' => 'RELIANCE']);
testFilter(['result' => 'WIN']);
testFilter(['result' => 'LOSS']);
testFilter(['signal_type' => 'SELL']);
