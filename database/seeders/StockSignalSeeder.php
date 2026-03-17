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
        $sqlFilePath = 'c:\Users\Mann\Downloads\stock_signals (3).sql';

        if (!file_exists($sqlFilePath)) {
            $this->command->warn("SQL file not found at: $sqlFilePath. Skipping import.");
            return;
        }

        $content = file_get_contents($sqlFilePath);

        // Extract the part between "VALUES" and ";"
        if (!preg_match('/INSERT INTO `stock_signals` .* VALUES\s*(.*);/s', $content, $matches)) {
            $this->command->error("Could not find INSERT statement in SQL file.");
            return;
        }

        $valuesPart = trim($matches[1]);
        preg_match_all('/\((.*?)\)(?:,|\s*;)/s', $valuesPart, $recordMatches);
        $records = $recordMatches[1];

        \DB::table('stock_signals')->truncate();
        $inserted = 0;

        foreach ($records as $recordStr) {
            $values = str_getcsv($recordStr, ',', "'", "\\");
            
            $cleanValues = array_map(function($val) {
                $v = trim($val);
                if ($v === 'NULL') return null;
                return $v;
            }, $values);

            if (count($cleanValues) < 14) continue;

            $entryDate = $cleanValues[10];
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $entryDate, $dMatches)) {
                $entryDate = sprintf('%04d-%02d-%02d', $dMatches[1], $dMatches[2], $dMatches[3]);
            }

            \App\Models\StockSignal::create([
                'id'           => (int)$cleanValues[0],
                'symbol'       => $cleanValues[1],
                'signal_type'  => $cleanValues[2],
                'entry'        => (float)$cleanValues[3],
                'target'       => (float)$cleanValues[4],
                'sl'           => (float)$cleanValues[5],
                'close_price'  => $cleanValues[6] === null ? null : (float)$cleanValues[6],
                'result'       => $cleanValues[7],
                'breakeven'    => (float)$cleanValues[8],
                'qty'          => 0,
                'entry_time'   => $cleanValues[9],
                'entry_date'   => $entryDate,
                'pnl'          => $cleanValues[11] === null ? null : (float)$cleanValues[11],
                'created_at'   => $cleanValues[12],
                'updated_at'   => $cleanValues[13],
            ]);
            $inserted++;
        }

        $this->command->info("Successfully truncated and imported $inserted records.");
    }
}
