<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'first',
            'last_name' => 'last',
            'name' => 'first last',
            'email' => 'admin@admin.com',
            'password' =>'password',
            'is_super_admin'=>1,
            'lang_id'=>Language::EN_ID
        ]);

        User::factory(100)->create();

        $this->call([
            JeelGemPriceSeeder::class,
            JeelLevelXpSeeder::class,
            RewardActionSeeder::class,
            SeedLanguages::class,
            SeedSettings::class,
            SeedMissedStudentCredit::class,
            SeedUserRolesPermission::class,
        ]);
    }
}
