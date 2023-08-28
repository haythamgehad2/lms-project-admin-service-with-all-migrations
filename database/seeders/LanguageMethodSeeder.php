<?php

namespace Database\Seeders;

use App\Models\LanguageMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        LanguageMethod::query()->truncate();

        $LanguageMethods = [
            ['name' => ['ar'=>'كتابة','en'=>'write'],'is_default'=>1,'slug' => 'write'],
            ['name' => ['ar'=>'قراءة','en'=>'reading'],'is_default'=>1,'slug' => 'reading'],
            ['name' => ['ar'=>'اخرى','en'=>'other'],'is_default'=>1,'slug' => 'other'],
        ];

        foreach($LanguageMethods as $languageMethod){
            LanguageMethod::create($languageMethod);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');



    }
}
