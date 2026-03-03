<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeHistory extends Model
{
    protected $table = 'user_trade_history';

    protected $fillable = [
        'user_id',
        'premium_tip_id',
        'action',
        'profit_loss',
        'action_timestamp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function premiumTip()
    {
        return $this->belongsTo(PremiumTip::class);
    }
}
