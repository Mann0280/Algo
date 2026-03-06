<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signal extends Model
{
    protected $fillable = [
        'stock_symbol',
        'type',
        'risk_level',
        'entry_price',
        'stop_loss',
        'target_1',
        'target_2',
        'close_price',
        'result',
        'pl',
        'confidence_level',
        'status',
        'is_premium',
        'closed_at',
    ];

    protected $casts = [
        'closed_at' => 'datetime',
        'is_premium' => 'boolean',
    ];
}
