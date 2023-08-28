<?php

namespace Database\Seeders;

use App\Models\BloomCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloomCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        BloomCategory::query()->truncate();

        $bloomCategories = [
            ['name' => ['ar'=>'كتابة','en'=>'write'], 'slug' => 'write','is_default'=>1],
            ['name' => ['ar'=>'قراءة','en'=>'reading'], 'slug' => 'reading','is_default'=>1],
            ['name' => ['ar'=>'اخرى','en'=>'other'], 'slug' => 'other','is_default'=>1],
        ];

        foreach($bloomCategories as $bloomCategory){
            BloomCategory::create($bloomCategory);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');



    }
}
