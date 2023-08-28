<?php
namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\School\LevelTermResource;
use App\Http\Resources\School\MySchoolInfoResource;
use App\Http\Resources\School\SchoolResource;
use App\Http\Resources\School\SchoolsResource;
use App\Mapper\PaginationMapper;
use App\Models\LevelTerm;
use App\Models\Role;
use App\Models\User;
use App\Repositories\ClassRepository;
use App\Repositories\LevelRepository;
use App\Repositories\MissionRepository;
use App\Repositories\SchoolGroupRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\TermRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SchoolService
{
    /**
     * _Construct function
     *
     * @param SchoolRepository $schoolRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(
    protected SchoolRepository $schoolRepository,
    protected LevelRepository $levelRepository,
    protected TermRepository $termRepository,
    protected SchoolGroupRepository $schoolGroupRepository,
    protected MissionRepository $missionRepository,
    protected ClassRepository $classRepository,
    protected PaginationMapper $paginationMapper,
    protected ReturnData $returnData){}

    /**
     * Get All function
     *
     * @param array $options
     * @return void
     */
    public function getAll(array $options = [])
    {

        $schools = $this->schoolRepository->getAll($options,['admin:id,name,email','schoolGroup:id,name','schoolType:id,name']);


        return $this->returnData->create(
            [],
            Response::HTTP_OK,
             SchoolsResource::collection($schools),
             __('admin.schools.list'),
             $schools instanceof \Illuminate\Pagination\LengthAwarePaginator ?
             $this->paginationMapper->metaPagination($options,$schools):[]
            );
    }

    /**
    * Show function
    *
    * @param array $options
    * @return void
    */
   public function show(int $id)
   {
       $term = $this->schoolRepository->show($id,['admin:id,name,email','schoolGroup:id,name','schoolType:id,name']);

       return $this->returnData->create(
           [],
           Response::HTTP_OK,
           new SchoolResource($term),
           [__('admin.schools.show')],
       );
   }


    /**
    * Show function
    *
    * @param array $options
    * @return void
    */
   public function mySchoolInfoResource()
   {
        if(auth()->user()->school_id){
                $school = $this->schoolRepository->show(auth()->user()->school_id,['admin:id,name,email','schoolGroup:id,name','schoolType:id,name']);


                    return $this->returnData->create(
                        [],
                        Response::HTTP_OK,
                        new MySchoolInfoResource($school),
                        [__('school group item returned successfully')],
                    );
                }else{
                    return $this->returnData->create(
                        [],
                        Response::HTTP_OK,
                        [],
                        [__('no have school to returned')],
                    );
        }
   }

    /**
     * Create function
     *
     * @param [type] $data
     * @return void
     */
    public function create($data)
    {
        DB::beginTransaction();

        try {
            $school = $this->schoolRepository->create($data);
            $this->schoolGroupLevel($school->school_group_id,$school->id);
            // $this->schoolMissions($school->school_group_id,$school->id);

            $user=User::findOrfail($data['admin_id']);
            $user->update(['school_id' => $school->id ,'is_school_admin'=>1]);
            //Attach Role School Admin To User
            $role=Role::where('code','schooladmin')->firstOrfail();
            $role->users()->sync($data['admin_id']);



            if(isset($data['logo'])){
                $school->saveFiles($data['logo']);
            }

            DB::commit();

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                new SchoolResource($school),
                [__('admin.schools.create')]
            );

        } catch (Exception $excption) {
            dd($excption->getMessage());
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );
        }
        DB::rollBack();

        return $this->returnData->create(
            [__('admin.schools.not_create')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

    }

       /**
     * Update function
     *
     * @param array $data
     * @param integer $id
     * @return void
     */
    // public function schoolMissions(int $schooGroupId,int $schoolId)
    // {
    //         $schoolGroup= $this->schoolGroupRepository->find($schooGroupId);
    //         $levels=$schoolGroup->levels;

    //         if($levels){

    //         $missions=$this->missionRepository->schoolLevelDefaultMission($levels->pluck('id')->toArray());

    //         if($missions){
    //             foreach($missions as $mission){
    //                     $newMission=$mission->replicate();
    //                     $newMission->school_id = $schoolId;

    //                     $newMission->save();

    //                     $mission->load('videosBanks', 'papersWork','quizzes');




    //                     if($mission->videosBanks){
    //                         foreach($mission->videosBanks as $videosBank){
    //                             $newMission->videosBanks()->attach([
    //                             'video_bank_id' => $videosBank->pivot->video_bank_id],
    //                             ['order' => $videosBank->pivot->order,
    //                             'is_selected' => 0,
    //                             'learning_path_id' => $videosBank->pivot->learning_path_id,
    //                             ]);

    //                         }

    //                 }
    //                 if($mission->papersWork){
    //                         foreach($mission->papersWork as $papersWork){
    //                             $newMission->papersWork()->attach(['peper_work_id' => $papersWork->pivot->peper_work_id],
    //                             ['order' => $papersWork->pivot->order,
    //                             'is_selected' => 0,
    //                             'learning_path_id' => $papersWork->pivot->learning_path_id,
    //                             ]);

    //                         }

    //                 }

    //                 if($mission->quizzes){
    //                     foreach($mission->quizzes as $quizz){
    //                         $newMission->quizzes()->attach(['quiz_id' => $quizz->pivot->quiz_id],
    //                         ['order' => $quizz->pivot->order,
    //                         'is_selected' => 0,
    //                         'learning_path_id' => $quizz->pivot->learning_path_id,
    //                         ]);

    //                     }
    //                 }
    //             }
    //         }
    //     }
    // }


    private function defultMissionClone($missions ,$schoolId,$newSchoolLevel){

        if($missions){
            foreach($missions as $mission){
                    $newMission=$mission->replicate();
                    $newMission->school_id   = $schoolId;
                    $newMission->level_id    = $newSchoolLevel->id;
                    $newMission->original_id = $mission->id;
                    $newMission->save();

                    if($mediaItem = $mission->media->first()){
                        $mediaItem->copy($newMission, 'mission_image', 'public');
                    }
            }
        }
    }
    /**
     * Update function
     *
     * @param array $data
     * @param integer $id
     * @return void
     */
    public function schoolGroupLevel(int $schooGroupId, int $schoolId)
    {
       $schoolGroup= $this->schoolGroupRepository->find($schooGroupId);
       $levels=$schoolGroup->levels;

       if($levels){

        foreach($levels as $level){

            $newSchoolLevel=$level->replicate();
            $newSchoolLevel->school_id = $schoolId;
            $newSchoolLevel->save();

            $missions=$this->missionRepository->schoolLevelDefaultMissions($level->id);
            // if($levels){
            $this->defultMissionClone($missions,$schoolId,$newSchoolLevel);

            $terms=$level->terms;

            if($terms){
            foreach($terms as $term){
                $newSchoolTerm=$term->replicate();
                $newSchoolTerm->school_id = $schoolId;
                $newSchoolTerm->save();
                $newSchoolTerm->levels()->sync([$newSchoolLevel->id=>['school_id'=>$schoolId]]);

                 }
               }
            }
        }
    }

   /**
     * Update function
     *
     * @param array $data
     * @param integer $id
     * @return void
     */
    public function update(array $data, int $id)
    {
        DB::beginTransaction();

        try {

           $school =$this->schoolRepository->update($data, $id);

           if(isset($data['logo'])){
                $school->updateFile($data['logo']);
            }

           DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new SchoolResource($school),
                    [__('admin.schools.update')]
                );

        } catch (Exception $excption) {
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );
        DB::rollback();

        return $this->returnData->create(
            [__('admin.schools.not_update')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );
        }

    }
    /**
     * Delete function
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        try{

            $user=User::where('school_id',$id)->update(['school_id'=>NULL]);
            
            $this->schoolRepository->delete($id);

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.schools.delete')]
            );
        }catch (Exception $excption) {
            dd($excption->getMessage());
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );
        }

        return $this->returnData->create(
            [__('admin.schools.not_delete')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

    }
     /**
     * School Levels function
     *
     * @param integer $id
     * @return void
     */
    public function schoolLevels(array $data)
    {
        try {
            $levels=$this->levelRepository->whereIn('id',$data['levels']);

            foreach($levels as $level){

                $newSchoolLevel=$level->replicate();
                $newSchoolLevel->school_id = $data['school_id'];
                $newSchoolLevel->save();
            }

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.schools.level_assigned_school')]
            );

        }catch (Exception $excption) {
            logger(
                [
                    'error'=> $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            return $this->returnData->create(
                [__('admin.schools.level_assigned_school_field')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

    /**
     * School Levels function
     *
     * @param integer $id
     * @return void
     */
    public function schoolTerms(array $data)
    {
        try {
            $terms=$this->termRepository->whereIn('id',$data['terms']);

            foreach($terms as $term){

                $newSchoolTerm=$term->replicate();
                $newSchoolTerm->school_id = $data['school_id'];
                $newSchoolTerm->save();

            }

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('levels has been assign to school')]
            );

        }catch (Exception $excption) {
            logger(
                [
                    'error'=> $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            return $this->returnData->create(
                [__('levels not been assign to school')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

    /**
     * School Level Term  function
     *
     * @param integer $id
     * @return void
     */
    public function schoolLevelTerm(array $data,int $id)
    {
        try {
            $query=LevelTerm::query();

            if(isset($data['level_id'])){
                $query=$query->where('level_id',$data['level_id']);
            }

              $levelTerm= $query->where('school_id',$id)->get();

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                LevelTermResource::collection($levelTerm),
                [__('admin.schools.level_term_list')]
            );

        }catch (Exception $excption) {
            logger(
                [
                    'error'=> $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            return $this->returnData->create(
                [__('admin.schools.level_term_not_return_list')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

    /**
     * School Classes function
     *
     * @param integer $id
     * @return void
     */
    public function schoolClasses(array $data)
    {
        try {
            $classes=$this->classRepository->create($data);

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('levels has been assign to school')]
            );

        }catch (Exception $excption) {
            logger(
                [
                    'error'=> $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            return $this->returnData->create(
                [__('levels not been assign to school')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

}
