<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signal extends Model
{
    protected $fillable = [
        'stock_symbol',
        'risk_level',
        'entry_price',
        'stop_loss',
        'target_1',
        'target_2',
        'confidence_level',
        'is_premium',
    ];
}
