<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PremiumTipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\PremiumTip::create([
            'stock_name' => 'RELIANCE',
            'entry_price' => 2845.50,
            'target_1' => 2920.00,
            'target_2' => 2980.00,
            'target_3' => 3050.00,
            'stop_loss' => 2780.00,
            'confidence_percentage' => 92,
            'risk_level' => 'Low',
            'trade_type' => 'Swing',
            'status' => 'Active',
        ]);

        \App\Models\PremiumTip::create([
            'stock_name' => 'HDFC BANK',
            'entry_price' => 1640.20,
            'target_1' => 1685.00,
            'target_2' => 1720.00,
            'target_3' => 1780.00,
            'stop_loss' => 1610.00,
            'confidence_percentage' => 88,
            'risk_level' => 'Medium',
            'trade_type' => 'Intraday',
            'status' => 'Active',
        ]);

        \App\Models\PremiumTip::create([
            'stock_name' => 'INFY',
            'entry_price' => 1520.00,
            'target_1' => 1580.00,
            'target_2' => 1620.00,
            'target_3' => 1680.00,
            'stop_loss' => 1485.00,
            'confidence_percentage' => 95,
            'risk_level' => 'Low',
            'trade_type' => 'Long Term',
            'status' => 'Active',
        ]);
    }
}
