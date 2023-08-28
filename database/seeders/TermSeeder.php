<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Term::query()->truncate();


        $terms = [
            ['name' => ['ar'=>'الخريف','en'=>'Spring']],
            ['name' => ['ar'=>'الشتاء','en'=>'Winter']],
            ['name' => ['ar'=>'الصيف','en'=>'summer']],


        ];

        foreach($terms as $tern){
            $term=Term::create($tern);
            $term->levels()->attach([1,2]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
