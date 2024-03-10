<?php

namespace Database\Seeders;

use App\Models\Strategy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StrategySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $strategies = ['DESKTOP', 'MOBILE'];

        foreach ($strategies as $strategy) {
            Strategy::create([
                'name' => $strategy,
            ]);
        }
    }
}
