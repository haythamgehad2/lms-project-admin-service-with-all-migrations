<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeedUserRolesPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            [
                'id'=>1,
                'name'=> [
                    'en' => 'JEEL Admin',
                    'ar' => ''
                ],
                'code' => 'jeeladmin',
                'system_role' => 1,
                'is_default' => 1,

            ],
            [
                'id'=>2,
                'name'=> [
                    'en' => 'school admin',
                    'ar' => ''
                ],
                'code' => 'schooladmin',
                'system_role' => 0,
                'is_default' => 1,

            ],
            [
                'id'=>3,

                'name'=> [
                    'en' => 'supervisor',
                    'ar' => ''
                ],
                'code' => 'supervisor',
                'system_role' => 0,
                'is_default' => 1,

            ],
            [
                'id'=>4,

                'name'=> [
                    'en' => 'teacher',
                    'ar' => ''
                ],
                'code' => 'teacher',
                'system_role' => 0,
                'is_default' => 1,

            ],
            [
                'id'=>5,

                'name'=> [
                    'en' => 'student',
                    'ar' => ''
                ],
                'code' => 'student',
                'system_role' => 0,
                'is_default' => 1,

            ],
            [
                'id'=>6,

                'name'=> [
                    'en' => 'parent',
                    'ar' => ''
                ],
                'code' => 'parent',
                'system_role' => 0,
                'is_default' => 1,


            ],
        ];

        foreach($roles as $item){
            $role = new Role();
            $role->name = ['ar' => $item['name']['ar'], 'en' => $item['name']['en']];
            $role->code = $item['code'];
            $role->system_role = $item['system_role'];
            $role->is_default = $item['is_default'];
            $role->save();
        }

        $actions = ['view','add','edit','delete','show'];

        $entities = [
         'roles','users','permissions','countries','schoolGroups','schools','schoolTypes','packages','levels','terms','classes',
         'themes','questions','questionType','questionDifficulty','questionAnswer','languageSkill','languageMethod','bloomCategory','learningpath'
         ,'enrollment','missions','questions','paperWork','quizzes', 'reward-actions', 'jeel-level-xp', 'jeel-gem-prices',
          'student-action-histories','video','schooladmins'
      ];


        foreach($actions as $action){
            foreach($entities as $entity){
                if($entity == 'mission'){
                    $permissionMission = new Permission();
                    $permissionMission->setTranslation('name','en','can '.'rearrange'.' '.$entity);
                    $permissionMission->code = 'rearrange'.'-'.$entity;
                    $permissionMission->save();

                }
                if($entity == 'level'){
                    $pemssionsLevel = new Permission();
                    $pemssionsLevel->setTranslation('name','en','can '.'show'.' '.'mission-levels');
                    $pemssionsLevel->code = 'show'.'-'.'mission-levels';
                    $pemssionsLevel->save();
                }
                $permission = new Permission();
                $permission->setTranslation('name','en','can '.$action.' '.$entity);
                $permission->code = $action.'-'.$entity;
                $permission->save();
            }
        }

        $superAdminRole = Role::find(1);
        $superAdminRole->permissions()->attach(Permission::all()->pluck('id')->toArray());

        // $roleSchoolAdmin = Role::find(2);
        // $roleSchoolAdmin->permissions()->attach(Permission::all()->pluck('id')->toArray());




        $role=Role::find(1);
        $role->users()->attach([1]);


        /**teatcher */
        $permissionTeatcher = new Permission();
        $permissionTeatcher->setTranslation('name','en','can '.'manage'.' '.'learningpath');
        $permissionTeatcher->code = 'manage-learningpath';
        $permissionTeatcher->save();

        $permissionTeatcher2 = new Permission();
        $permissionTeatcher2->setTranslation('name','en','can '.'manage'.' '.'content');
        $permissionTeatcher2->code = 'manage-content';
        $permissionTeatcher2->save();


        /**SuperViseor */
        $permissionSupervisor = new Permission();
        $permissionSupervisor->setTranslation('name','en','can '.'rearrange'.' '.'missions');
        $permissionSupervisor->code = 'rearrange-missions';
        $permissionSupervisor->save();


        // /**
        //  * Attach Users To Random Role
        //  */
        // $users = User::where('id','!=',1)->get();

        // foreach($users as $user){
        //     $role=Role::inRandomOrder()->where('id','!=',1)->first();
        //     $role->users()->attach($user->id);
        // }

    }
}
