<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockSignal extends Model
{
    protected $fillable = [
        'stock_name',
        'signal_type',
        'entry',
        'target',
        'sl',
        'breakeven',
        'entry_time',
        'entry_date',
        'close_price',
        'result',
        'pnl',
    ];
}
