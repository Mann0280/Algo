<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SiteSetting::updateOrCreate(['key' => 'breakeven_point'], ['value' => '2500.00']);
        \App\Models\SiteSetting::updateOrCreate(['key' => 'breakeven_date'], ['value' => now()->format('Y-m-d')]);
    }
}
