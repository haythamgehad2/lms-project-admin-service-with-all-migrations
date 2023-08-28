<?php

namespace Database\Seeders;

use App\Models\JeelLevelXp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JeelLevelXpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JeelLevelXp::updateOrCreate(["level" => 1], ["xp" => 1000]);
    }
}
