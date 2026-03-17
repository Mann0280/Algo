<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockSignal extends Model
{
    protected $fillable = [
        'symbol',
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
        'qty',
    ];

    /**
     * Fallback for symbol/stock_name to ensure compatibility
     */
    public function getStockNameAttribute($value)
    {
        return $value ?: $this->attributes['symbol'] ?? null;
    }

    public function getSymbolAttribute($value)
    {
        return $value ?: $this->attributes['stock_name'] ?? null;
    }

    /**
     * Calculate quantity based on 5x leverage formula.
     * Quantity = (Capital * 5) / Entry
     */
    public function getCalculatedQty(float $capital = 100000)
    {
        if ($this->entry <= 0) return 0;
        return floor(($capital * 5) / $this->entry);
    }

    /**
     * Calculate simulated PNL based on 5x leverage formula.
     * PNL = Points * Quantity
     */
    public function getCalculatedSimPnl(float $capital = 100000)
    {
        $qty = $this->getCalculatedQty($capital);
        return (float)($qty * ($this->pnl ?? 0));
    }

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
