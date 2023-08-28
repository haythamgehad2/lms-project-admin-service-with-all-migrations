<?php
namespace Database\Seeders;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class SchoolAdminRolesPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = ['view','edit','show'];

        $entities = [
            'levels',
            'classes',
            'enrollment',
            'schools',
            'missions',
            'schooladmins',
        ];
        foreach($actions as $action){
                foreach($entities as $entity){
                $schoolAdmin = Role::find(2);
                $schoolAdmin->permissions()->attach(Permission::where('code',$action.'-'.$entity)->pluck('id')->toArray());
            }
        }

        $actions = ['view'];

        $entities = [
            'packages',
            'schoolTypes',
            'schoolGroups',
        ];

        foreach($actions as $action){
                foreach($entities as $entity){
                $schoolAdmin = Role::find(2);
                $schoolAdmin->permissions()->attach(Permission::where('code',$action.'-'.$entity)->pluck('id')->toArray());
            }
        }

        $schoolAdmin->permissions()->attach(Permission::where('code','rearrange-missions')->pluck('id')->toArray());
        $schoolAdmin->permissions()->attach(Permission::where('code','manage-content')->pluck('id')->toArray());
        $schoolAdmin->permissions()->attach(Permission::where('code','manage-learningpath')->pluck('id')->toArray());
        $schoolAdmin->permissions()->attach(Permission::where('code','add-classes')->pluck('id')->toArray());
        $schoolAdmin->permissions()->attach(Permission::where('code','add-enrollment')->pluck('id')->toArray());
        $schoolAdmin->permissions()->attach(Permission::where('code','delete-enrollment')->pluck('id')->toArray());
        $schoolAdmin->permissions()->attach(Permission::where('code','view-roles')->pluck('id')->toArray());


    }
}
