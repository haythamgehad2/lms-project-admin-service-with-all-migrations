<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Package::query()->truncate();

        $pacakges = [
            ['name' =>['ar'=>'الحزمة الاولة','en'=>'package1'],'price'=>100,'description'=>'description test','classes_count'=>5],
            ['name' => ['ar'=>'الحزمة الثانية','en'=>'package2'],'price'=>100,'description'=>'description test','classes_count'=>5],
            ['name' => ['ar'=>'الحزمة الثالثة','en'=>'package3'],'price'=>100,'description'=>'description test','classes_count'=>5],
            // ['name' => 'Pacakge 4','price'=>100,'description'=>'description test','classes_count'=>5],
        ];

        foreach($pacakges as $pacakge){
            Package::create($pacakge);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
