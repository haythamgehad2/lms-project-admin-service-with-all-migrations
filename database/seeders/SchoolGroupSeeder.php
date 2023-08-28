<?php

namespace Database\Seeders;

use App\Models\SchoolGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        SchoolGroup::query()->truncate();

        $ShcoolGroups = [
            ['name' => ['ar'=>'جروب المصرية','en'=>'Egypt Group'], 'country_id' => 1,'status' => 1, 'type' => 'national','music_status' => 1, 'owner_id' => 2],
            ['name' => ['ar'=>'جروب الكنانة','en'=>'Kanana Group'], 'country_id' => 1,'status' => 1, 'type' => 'international','music_status' => 0, 'owner_id' => 2],
            ['name' => ['ar'=>'جروب المستقبل','en'=>'Modern Group'], 'country_id' => 1,'status' => 1, 'type' => 'international','music_status' => 1, 'owner_id' => 2],

        ];

        foreach($ShcoolGroups as $shcoolGroup){
            SchoolGroup::create($shcoolGroup);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
