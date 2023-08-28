<?php

namespace Database\Seeders;

use App\Models\LearningPath;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LearningPathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        LearningPath::query()->truncate();



        $larningpaths = [
            ['name' =>['ar'=>'المسار الاول','en'=>'learning path 1'], 'description' => 'المسار الاول'],
            ['name' =>['ar'=>'المسار الثانى','en'=>'learning path 2'], 'description' => 'المسار الثانى'],
            ['name' => ['ar'=>'المسار الثالث','en'=>'learning path 3'], 'description' => 'المسار الثالث',],
        ];

        foreach($larningpaths as $learningPath){
            LearningPath::create($learningPath);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
