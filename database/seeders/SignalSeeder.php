<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Signal;

class SignalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $signals = [
            [
                'stock_symbol' => 'RELIANCE',
                'risk_level' => 'Low',
                'entry_price' => 2850.50,
                'stop_loss' => 2820.00,
                'target_1' => 2890.00,
                'target_2' => 2920.00,
                'confidence_level' => 88,
                'is_premium' => false,
            ],
            [
                'stock_symbol' => 'TCS',
                'risk_level' => 'Medium',
                'entry_price' => 3920.00,
                'stop_loss' => 3880.00,
                'target_1' => 3980.00,
                'target_2' => 4050.00,
                'confidence_level' => 85,
                'is_premium' => false,
            ],
            [
                'stock_symbol' => 'HDFCBANK',
                'risk_level' => 'Low',
                'entry_price' => 1645.30,
                'stop_loss' => 1625.00,
                'target_1' => 1675.00,
                'target_2' => 1695.00,
                'confidence_level' => 92,
                'is_premium' => false,
            ],
            [
                'stock_symbol' => 'INFY',
                'risk_level' => 'Medium',
                'entry_price' => 1498.50,
                'stop_loss' => 1475.00,
                'target_1' => 1530.00,
                'target_2' => 1560.00,
                'confidence_level' => 82,
                'is_premium' => false,
            ],
            [
                'stock_symbol' => 'ZOMATO',
                'risk_level' => 'High',
                'entry_price' => 162.40,
                'stop_loss' => 155.00,
                'target_1' => 175.00,
                'target_2' => 185.00,
                'confidence_level' => 78,
                'is_premium' => false,
            ],
        ];

        foreach ($signals as $signal) {
            Signal::create($signal);
        }
    }
}
