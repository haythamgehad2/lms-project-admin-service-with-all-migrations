<?php

namespace App\Services;

use App\Events\MissionProgressEvent;
use App\Helpers\ReturnData;
use App\Http\Resources\Class\ClassesResource;
use App\Http\Resources\Class\ClassResource;
use App\Http\Resources\ClassCollection;
use App\Mapper\PaginationMapper;
use App\Mapper\ClassMapper;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizContent;
use App\Repositories\ClassRepository;
use App\Repositories\LevelRepository;
use App\Repositories\MissionRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ClassService
{


    /**
     * __construct function
     *
     * @param ClassRepository $classRepository
     * @param LevelRepository $levelRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     * @param MissionRepository $missionRepository
     */
    public function __construct(protected ClassRepository $classRepository,protected LevelRepository $levelRepository,
    protected PaginationMapper $paginationMapper, protected ReturnData $returnData
    ,protected MissionRepository $missionRepository){}


        /**
         * Get All function
         *
         * @param array $options
         * @return void
         */
        public function getAll(array $options = [])
        {
            $classes = $this->classRepository->getAll($options);

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                    ClassesResource::collection($classes),
                 __('admin.classes.list'),$classes instanceof \Illuminate\Pagination\LengthAwarePaginator ?
                $this->paginationMapper->metaPagination($options,$classes):[]
            );
        }

        /**
         * LearningPaths Mission function
         *
         * @param [type] $newMission
         * @param [type] $mission
         * @return void
         */
        private function cloneClassMissionLearningPaths($newMission,$mission){
            if($mission->orginalMission->learningPaths){
                foreach($mission->orginalMission->learningPaths as $key=>$learningPath) {

                    $newMission->learningPaths()->attach([
                        'learning_path_id' => $learningPath->pivot->learning_path_id],
                        [
                        'order' => $key+1,
                        'is_selected' => 1,
                    ]);
                }
            }
        }
        /**
         * Class Mission VideoBank function
         *
         * @param [type] $newMission
         * @param [type] $mission
         * @return void
         */
        private function cloneClassMissionVideoBanks($newMission,$mission){
            if($mission->orginalMission->videosBanks){
                    foreach($mission->orginalMission->videosBanks as $key=>$videosBank){
                        $newMission->videosBanks()->attach([
                        'video_bank_id' => $videosBank->pivot->video_bank_id],
                        [
                        'order' => $key+1,
                        'is_selected' => 1,
                        'learning_path_id' => $videosBank->pivot->learning_path_id,
                    ]);
                }
            }
        }

            /**
         * Class Mission VideoBank function
         *
         * @param [type] $newMission
         * @param [type] $mission
         * @return void
         */
        private function cloneClassMissionPapersWorks($newMission,$mission){
            if($mission->orginalMission->papersWork){
                    foreach($mission->orginalMission->papersWork as $key=>$papersWork){
                        $newMission->papersWork()->attach(['peper_work_id' => $papersWork->pivot->peper_work_id],
                        ['order' => $key+1,
                        'is_selected' => 1,
                        'learning_path_id' => $papersWork->pivot->learning_path_id,
                        ]);

                    }

            }
        }

        /**
         * Class Mission VideoBank function
         *
         * @param [type] $newMission
         * @param [type] $mission
         * @return void
         */
        private function cloneClassMissionQuizzes($newMission,$mission){

                if($mission->orginalMission->quizzes){
                    foreach($mission->orginalMission->quizzes as $key=>$quizz){

                        $newQuiz=$quizz->replicate();
                        $newQuiz->school_id = $mission->school_id;
                        $newQuiz->level_id = $newMission->level_id;
                        $newQuiz->save();

                        foreach($quizz->questions()->get()->pluck('id') as $key=>$questionId){
                            QuizContent::create([
                                'quiz_id'=>$newQuiz->id,
                                'question_id'=>$questionId,
                                'order'=>$key+1,
                                'is_selected'=>true,

                            ]);
                        }

                        $newMission->quizzes()->attach(['quiz_id' => $newQuiz->id],
                        ['order' => $key+1,
                        'is_selected' => 1,
                        'learning_path_id' => $quizz->pivot->learning_path_id,
                        ]);

                    }
                }
        }
    /**
     * Class Mission Clone function
     *
     * @param [type] $levelId
     * @return void
     */
        private function classMissionClone($missions,$classId){

                foreach($missions as $mission){
                    // $orginalMission=$mission->orginalMission;
                    $newMission=$mission->replicate();
                    $newMission->original_id = $mission->id;
                    $newMission->class_id = $classId;
                    $newMission->save();

                    if($mediaItem = $mission->media->first()){
                        $mediaItem->copy($newMission, 'mission_image', 'public');
                    }

                    /** Clone Content Missions */
                    $mission->orginalMission->load('videosBanks', 'papersWork','quizzes');
                    $this->cloneClassMissionLearningPaths($newMission,$mission);
                    $this->cloneClassMissionVideoBanks($newMission,$mission);
                    $this->cloneClassMissionPapersWorks($newMission,$mission);
                    $this->cloneClassMissionQuizzes($newMission,$mission);
                    
                    event(new MissionProgressEvent($newMission));
            }

        }

    public function create(array $data)
    {
        DB::beginTransaction();

        try{
            $class = $this->classRepository->create($data);

            $level=$class->levelTerm->level;

            $missions=$this->missionRepository->classLevelDefaultMissions($level->id,$data['school_id']);

            // if($missions->count() < $level->min_levels){

            //     DB::rollBack();

            //         return $this->returnData->create(
            //             [__('admin.classes.classes_missions_num_filed')],
            //             Response::HTTP_UNPROCESSABLE_ENTITY,
            //             [],
            //             []
            //     );

            // }else{
                 $this->classMissionClone($missions,$class->id);
            // }

            DB::commit();

            return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new ClassResource($class),
                    [__('admin.classes.create')]
            );

        }catch (Exception $excption) {
            // dd($excption->getMessage());
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );
            DB::rollBack();

            return $this->returnData->create(
                [__('admin.classes.not_create')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
        /**
        * Show function
        *
        * @param array $options
        * @return void
        */
    public function show(int $id)
    {
        $country = $this->classRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new ClassResource($country),
            [__('admin.classes.show')],
        );
    }

    public function update(array $data, int $id)
    {
        try {
            // $level = $this->levelRepository->find($data['level_id']);

            // $level->terms()->syncWithoutDetaching($data['term_id']);

            // $levelTerm=$level->terms()->wherePivot('term_id',$data['term_id'])->wherePivot('level_id',$data['level_id'])->first();

            // $data['level_term_id']=$levelTerm->pivot->id;

            $class= $this->classRepository->update($data, $id);


                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new ClassResource($class),
                    [__('admin.classes.update')]
                );
        }catch (Exception $excption) {
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
            [__('admin.classes.not_update')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );
    }

    public function delete(int $id)
    {
        try {
            $this->classRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.classes.delete')]
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
        }

        return $this->returnData->create(
            [__('admin.classes.not_delete')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

    }
}
