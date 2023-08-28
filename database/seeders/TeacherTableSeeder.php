<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $actions = ['view','edit','show'];

        $entities = [
                'levels',
                'classes'
        ];

        foreach($actions as $action){
                foreach($entities as $entity){
                $teatcher = Role::find(4);
                $teatcher->permissions()->attach(Permission::where('code',$action.'-'.$entity)->pluck('id')->toArray());
            }
        }


        $teatcher = Role::find(4);

        $teatcher->permissions()->attach(Permission::where('code','manage-content')->pluck('id')->toArray());
        $teatcher->permissions()->attach(Permission::where('code','manage-learningpath')->pluck('id')->toArray());


    }
}
