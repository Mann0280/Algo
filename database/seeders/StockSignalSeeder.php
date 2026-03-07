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
                'entry' => 2500.00,
                'target' => 2650.00,
                'sl' => 2420.00,
                'breakeven' => 2550.00,
                'entry_time' => '10:30 AM',
                'entry_date' => '2026-03-06',
                'pnl' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stock_name' => 'TATASTEEL',
                'entry' => 1150.50,
                'target' => 1280.00,
                'sl' => 1090.00,
                'breakeven' => 1200.00,
                'entry_time' => '11:15 AM',
                'entry_date' => '2026-03-06',
                'pnl' => 120.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stock_name' => 'HDFCBANK',
                'entry' => 1650.00,
                'target' => 1800.00,
                'sl' => 1580.00,
                'breakeven' => 1700.00,
                'entry_time' => '02:00 PM',
                'entry_date' => '2026-03-06',
                'pnl' => -15.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
