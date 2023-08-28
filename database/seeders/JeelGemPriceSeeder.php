<?php

namespace Database\Seeders;

use App\Models\JeelGemPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JeelGemPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JeelGemPrice::updateOrCreate([
            "quantity" => 1
        ], [
            "jeel_coins_quantity" => 1000
        ]);

        JeelGemPrice::updateOrCreate([
            "quantity" => 5
        ], [
            "jeel_coins_quantity" => 4000
        ]);

        JeelGemPrice::updateOrCreate([
            "quantity" => 10
        ], [
            "jeel_coins_quantity" => 7000
        ]);
    }
}
