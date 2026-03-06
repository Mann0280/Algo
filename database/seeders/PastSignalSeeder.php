<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Signal;
use Carbon\Carbon;

class PastSignalSeeder extends Seeder
{
    public function run(): void
    {
        $symbols = ['BTC/USDT', 'ETH/USDT', 'GOLD', 'RELIANCE', 'TCS', 'INFY', 'HDFCBANK', 'SOL/USDT', 'XRP/USDT', 'NASDAQ100'];
        $results = ['WIN', 'LOSS', 'BREAKEVEN'];
        $types = ['BUY', 'SELL'];

        // Seed 50 past signals over the last 30 days
        for ($i = 0; $i < 50; $i++) {
            $type = $types[array_rand($types)];
            $entry = rand(100, 50000);
            $target = $type === 'BUY' ? $entry * 1.05 : $entry * 0.95;
            $sl = $type === 'BUY' ? $entry * 0.97 : $entry * 1.03;
            
            $result = $results[array_rand($results)];
            $close = $entry;
            if ($result === 'WIN') {
                $close = $type === 'BUY' ? $entry * 1.03 : $entry * 0.97;
            } elseif ($result === 'LOSS') {
                $close = $type === 'BUY' ? $entry * 0.98 : $entry * 1.02;
            }

            $date = Carbon::now()->subDays(rand(1, 30))->subHours(rand(1, 23));
            $pl = $type === 'BUY' ? ($close - $entry) : ($entry - $close);

            Signal::create([
                'stock_symbol' => $symbols[array_rand($symbols)],
                'type' => $type,
                'entry_price' => $entry,
                'target_1' => $target,
                'target_2' => $target * 1.02,
                'stop_loss' => $sl,
                'close_price' => $close,
                'result' => $result,
                'pl' => $pl,
                'confidence_level' => rand(70, 98),
                'status' => 'closed',
                'is_premium' => (rand(0, 1) == 1),
                'created_at' => $date,
                'closed_at' => $date->addHours(rand(1, 48)),
            ]);
        }

        // Add 5 signals for today (P/L should be hidden by controller logic)
        for ($i = 0; $i < 5; $i++) {
            $type = $types[array_rand($types)];
            $entry = rand(100, 50000);
            $target = $type === 'BUY' ? $entry * 1.05 : $entry * 0.95;
            
            Signal::create([
                'stock_symbol' => $symbols[array_rand($symbols)],
                'type' => $type,
                'entry_price' => $entry,
                'target_1' => $target,
                'target_2' => $target * 1.02,
                'stop_loss' => $type === 'BUY' ? $entry * 0.97 : $entry * 1.03,
                'close_price' => $entry * 1.01,
                'result' => 'WIN',
                'pl' => 100,
                'confidence_level' => rand(80, 95),
                'status' => 'closed',
                'is_premium' => true,
                'created_at' => Carbon::now(),
                'closed_at' => Carbon::now()->addMinutes(30),
            ]);
        }
    }
}
