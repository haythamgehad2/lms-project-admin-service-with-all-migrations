<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Level::query()->truncate();


        $levels = [
            ['name' => ['ar'=>'المرحلة الدرسية الاولة','en'=>'First Leavel']],
            ['name' => ['ar'=>'المرحلة الدراسية الثانية','en'=>'Secound Leavel']],
            ['name' => ['ar'=>'المرحلة الدراسية الثالثة','en'=>'Third Leavel']],


        ];

        foreach($levels as $level){
            Level::create($level);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
