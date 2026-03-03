<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PremiumTip extends Model
{
    protected $fillable = [
        'stock_name',
        'entry_price',
        'target_1',
        'target_2',
        'target_3',
        'stop_loss',
        'confidence_percentage',
        'risk_level',
        'trade_type',
        'status',
    ];

    public function tradeHistories()
    {
        return $this->hasMany(TradeHistory::class);
    }
}
