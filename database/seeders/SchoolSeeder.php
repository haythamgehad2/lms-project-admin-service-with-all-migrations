<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        School::query()->truncate();

        $ShcoolGroups = [
            ['name' => ['ar'=>'مدرسة المصرية','en'=>'Egypt School'], 'country_id' => 1,'status' => 1, 'type' => 'national','music_status' => 1, 'owner_id' => 2],
            ['name' => ['ar'=>'مدرسة الكنانة','en'=>'Kanana School'], 'country_id' => 1,'status' => 1, 'type' => 'international','music_status' => 0, 'owner_id' => 2],
            ['name' => ['ar'=>'مدرسة المستقبل','en'=>'Modern School'], 'country_id' => 1,'status' => 1, 'type' => 'international','music_status' => 1, 'owner_id' => 2],

        ];

        foreach($ShcoolGroups as $shcoolGroup){
            School::create($shcoolGroup);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
