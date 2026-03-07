<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSignalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('stock_signals')->insert([
            [
                'stock_name' => 'RELIANCE',
                'signal_type' => 'BUY',
                'entry' => 2500.00,
                'target' => 2650.00,
                'sl' => 2420.00,
                'breakeven' => 2550.00,
                'close_price' => null,
                'result' => 'RUNNING',
                'entry_time' => '10:30 AM',
                'entry_date' => now()->format('Y-m-d'),
                'pnl' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stock_name' => 'TATASTEEL',
                'signal_type' => 'BUY',
                'entry' => 1150.50,
                'target' => 1280.00,
                'sl' => 1090.00,
                'breakeven' => 1200.00,
                'close_price' => 1270.50,
                'result' => 'WIN',
                'entry_time' => '11:15 AM',
                'entry_date' => '2026-03-06',
                'pnl' => 120.00,
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
            [
                'stock_name' => 'HDFCBANK',
                'signal_type' => 'SELL',
                'entry' => 1650.00,
                'target' => 1500.00, // Adjusted target for SELL
                'sl' => 1720.00, // Adjusted sl for SELL
                'breakeven' => 1600.00,
                'close_price' => 1665.50,
                'result' => 'LOSS',
                'entry_time' => '02:00 PM',
                'entry_date' => '2026-03-05',
                'pnl' => -15.50,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
        ]);
    }
}
