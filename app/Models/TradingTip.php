<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradingTip extends Model
{
    protected $fillable = [
        'stock_name',
        'entry_price',
        'stop_loss',
        'target_price',
        'status',
        'video_url'
    ];
}
