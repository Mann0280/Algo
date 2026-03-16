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

    /**
     * Mutator to ensure entry_date is always stored in YYYY-MM-DD format.
     */
    public function setEntryDateAttribute($value)
    {
        if ($value) {
            try {
                $this->attributes['entry_date'] = \Carbon\Carbon::parse($value)->format('Y-m-d');
            } catch (\Exception $e) {
                $this->attributes['entry_date'] = $value;
            }
        }
    }
}
