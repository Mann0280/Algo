<?php

namespace Database\Seeders;

use App\Models\TradingTip;
use Illuminate\Database\Seeder;

class TradingTipSeeder extends Seeder
{
    public function run(): void
    {
        $tips = [
            [
                'stock_name' => 'RELIANCE',
                'entry_price' => 2850.50,
                'stop_loss' => 2810.00,
                'target_price' => 2920.00,
                'status' => 'LIVE',
            ],
            [
                'stock_name' => 'TCS',
                'entry_price' => 3920.00,
                'stop_loss' => 3880.00,
                'target_price' => 4050.00,
                'status' => 'RUNNING',
            ],
            [
                'stock_name' => 'HDFCBANK',
                'entry_price' => 1645.00,
                'stop_loss' => 1620.00,
                'target_price' => 1700.00,
                'status' => 'HIT TARGET',
            ],
            [
                'stock_name' => 'INFY',
                'entry_price' => 1512.00,
                'stop_loss' => 1535.00,
                'target_price' => 1480.00,
                'status' => 'SL HIT',
            ],
            [
                'stock_name' => 'ICICIBANK',
                'entry_price' => 1085.00,
                'stop_loss' => 1065.00,
                'target_price' => 1120.00,
                'status' => 'LIVE',
            ],
        ];

        foreach ($tips as $tip) {
            TradingTip::create($tip);
        }
    }
}
