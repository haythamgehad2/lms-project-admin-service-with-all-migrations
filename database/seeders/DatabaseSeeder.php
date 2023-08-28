<?php

namespace Database\Seeders;
use App\Models\Language;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\SeedUserRolesPermission;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name'  => 'first',
            'last_name'   => 'last',
            'name'        => 'first last',
            'email'       => 'admin@admin.com',
            'password'    =>'password',
            'is_super_admin'=>1,
            'lang_id'=>Language::EN_ID
        ]);

        User::factory(100)->create();

        //Load production seeder
        if (App::Environment() === 'production') {
            $this->call([
                SeedLanguages::class,
                SeedUserRolesPermission::class,
                SeedSettings::class,
            ]);
        }

        //Load local seeder
        if (App::Environment() === 'local') {
            $this->call([
                SeedLanguages::class,
                SeedUserRolesPermission::class,
                SeedSettings::class,

            ]);
        }

        if (App::environment() != "production") {
            $this->call([
                SeedMissedStudentCredit::class,
                JeelLevelXpSeeder::class,
                JeelGemPriceSeeder::class,
                RewardActionSeeder::class,
            ]);
        }
    }
}
