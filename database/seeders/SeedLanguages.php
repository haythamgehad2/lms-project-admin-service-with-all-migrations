<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeedLanguages extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::insert([
            'name'=>'english',
            'code'=>'en'
        ]);
    }
}
