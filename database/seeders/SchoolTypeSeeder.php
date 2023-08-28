<?php

namespace Database\Seeders;

use App\Models\SchoolType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        SchoolType::query()->truncate();


        $schoolTypes = [
            ['name' => ['ar'=>'محلى','en'=>'national']],
            ['name' =>['ar'=>'دولى','en'=>'international']],
        ];

        foreach($schoolTypes as $schoolType){
            SchoolType::create($schoolType);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
