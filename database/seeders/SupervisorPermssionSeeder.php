<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupervisorPermssionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = ['view','edit','show'];

        $entities = [
        'levels',
      ];

        foreach($actions as $action){
                foreach($entities as $entity){
                $superVisor = Role::find(3);
                $superVisor->permissions()->attach(Permission::where('code',$action.'-'.$entity)->pluck('id')->toArray());
            }
        }


        $superVisor = Role::find(3);
        $superVisor->permissions()->attach(Permission::where('code','rearrange-missions')->pluck('id')->toArray());


    }
}
